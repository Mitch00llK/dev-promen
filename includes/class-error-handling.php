<?php
/**
 * Error Handling Class
 * 
 * Handles error logging and debugging for the plugin.
 * 
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Promen_Error_Handling {
    
    /**
     * Log directory path.
     *
     * @var string
     */
    private $log_dir;

    /**
     * Cached disabled widgets.
     *
     * @var array|null
     */
    private $disabled_widgets_cache = null;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Set log directory to uploads folder (writable, not in plugin dir)
        $upload_dir = wp_upload_dir();
        $this->log_dir = trailingslashit($upload_dir['basedir']) . 'promen-logs/';
        
        // Create log directory if it doesn't exist
        if (!file_exists($this->log_dir)) {
            wp_mkdir_p($this->log_dir);
            // Add .htaccess to protect logs
            file_put_contents($this->log_dir . '.htaccess', 'Deny from all');
        }
        
        // Setup AJAX error handling
        $this->setup_ajax_error_handling();
        
        // Setup accessibility-friendly error handling
        $this->setup_accessibility_error_handling();
    }
    
    /**
     * Setup accessibility-friendly error handling
     */
    private function setup_accessibility_error_handling() {
        // Add error display action
        add_action('wp_footer', [$this, 'render_error_live_region']);
        
        // Handle form validation errors
        add_action('wp_ajax_promen_widget_error', [$this, 'handle_widget_error']);
        add_action('wp_ajax_nopriv_promen_widget_error', [$this, 'handle_widget_error']);
        
        // Enqueue error handling JavaScript
        add_action('wp_enqueue_scripts', [$this, 'enqueue_error_handling_scripts']);
    }
    
    /**
     * Render ARIA live region for errors
     */
    public function render_error_live_region() {
        echo '<div id="promen-error-live-region" aria-live="assertive" aria-atomic="true" class="screen-reader-text"></div>';
        echo '<div id="promen-success-live-region" aria-live="polite" aria-atomic="true" class="screen-reader-text"></div>';
    }
    
    /**
     * Enqueue error handling scripts
     */
    public function enqueue_error_handling_scripts() {
        wp_enqueue_script(
            'promen-error-handling',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/error-handling.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Localize script with accessibility messages
        wp_localize_script('promen-error-handling', 'promenErrors', [
            'generic_error' => __('Er is een fout opgetreden. Probeer het opnieuw.', 'promen-elementor-widgets'),
            'network_error' => __('Netwerkfout. Controleer uw verbinding en probeer het opnieuw.', 'promen-elementor-widgets'),
            'validation_error' => __('Corrigeer de gemarkeerde velden.', 'promen-elementor-widgets'),
            'success_message' => __('Operatie succesvol voltooid.', 'promen-elementor-widgets'),
            'loading_message' => __('Verwerken... Een ogenblik geduld.', 'promen-elementor-widgets'),
            'aria_labels' => [
                'error_region' => __('Foutmeldingen', 'promen-elementor-widgets'),
                'success_region' => __('Succesmeldingen', 'promen-elementor-widgets'),
                'close_error' => __('Sluit foutmelding', 'promen-elementor-widgets')
            ]
        ]);
    }
    
    /**
     * Handle widget errors with accessibility features
     */
    public function handle_widget_error() {
        check_ajax_referer('promen_widget_nonce', 'nonce');
        
        $error_type = sanitize_text_field(wp_unslash($_POST['error_type'] ?? 'generic'));
        $error_message = sanitize_text_field(wp_unslash($_POST['error_message'] ?? ''));
        $widget_id = sanitize_text_field(wp_unslash($_POST['widget_id'] ?? ''));
        
        // Create accessible error response
        $response = [
            'success' => false,
            'data' => [
                'error_type' => $error_type,
                'message' => $this->get_accessible_error_message($error_type, $error_message),
                'widget_id' => $widget_id,
                'accessibility' => [
                    'announce' => true,
                    'focus_target' => $widget_id ? '#' . $widget_id : null,
                    'error_id' => 'error-' . wp_generate_uuid4()
                ]
            ]
        ];
        
        // Log the error for debugging
        $this->log_user_error($error_type, $error_message, $widget_id);
        
        wp_send_json($response);
    }
    
    /**
     * Get accessible error message
     *
     * @param string $error_type Error type identifier.
     * @param string $custom_message Optional custom message.
     * @return string Accessible error message.
     */
    private function get_accessible_error_message($error_type, $custom_message = '') {
        if (!empty($custom_message)) {
            return $custom_message;
        }
        
        $messages = [
            'validation' => __('Controleer en corrigeer de velden gemarkeerd met fouten.', 'promen-elementor-widgets'),
            'network' => __('Kan geen verbinding maken met de server. Controleer uw internetverbinding en probeer het opnieuw.', 'promen-elementor-widgets'),
            'permission' => __('U heeft geen toestemming om deze actie uit te voeren.', 'promen-elementor-widgets'),
            'timeout' => __('Het verzoek duurde te lang. Probeer het opnieuw.', 'promen-elementor-widgets'),
            'server' => __('Er is een serverfout opgetreden. Probeer het later opnieuw.', 'promen-elementor-widgets'),
            'file_upload' => __('Bestandsupload mislukt. Controleer de bestandsgrootte en het formaat.', 'promen-elementor-widgets'),
            'generic' => __('Er is een onverwachte fout opgetreden. Probeer het opnieuw.', 'promen-elementor-widgets')
        ];
        
        return $messages[$error_type] ?? $messages['generic'];
    }
    
    /**
     * Log user-facing errors (GDPR compliant - no IP logging)
     *
     * @param string $error_type Error type.
     * @param string $message Error message.
     * @param string $widget_id Widget ID.
     */
    private function log_user_error($error_type, $message, $widget_id) {
        $log_file = $this->log_dir . 'user-errors.log';
        
        $log_data = gmdate('[Y-m-d H:i:s]') . "\n";
        $log_data .= "USER ERROR: $error_type\n";
        $log_data .= "MESSAGE: $message\n";
        $log_data .= "WIDGET: $widget_id\n";
        $log_data .= "USER: " . (is_user_logged_in() ? get_current_user_id() : 'anonymous') . "\n";
        $log_data .= "PAGE: " . esc_url(wp_get_referer() ?: 'unknown') . "\n";
        $log_data .= "-----------------------------------\n\n";
        
        $this->write_log($log_file, $log_data);
    }
    
    /**
     * Write to log file with size rotation
     *
     * @param string $log_file Log file path.
     * @param string $log_data Data to write.
     */
    private function write_log($log_file, $log_data) {
        // Rotate log if it exceeds 5MB
        if (file_exists($log_file) && filesize($log_file) > 5 * 1024 * 1024) {
            $backup_file = str_replace('.log', '-' . gmdate('Y-m-d-His') . '.log', $log_file);
            rename($log_file, $backup_file);
        }
        
        // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_put_contents
        file_put_contents($log_file, $log_data, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Display accessible error message
     *
     * @param string $error_message Error message.
     * @param string $error_type Error type.
     * @param string $widget_id Widget ID.
     * @return string Error HTML.
     */
    public static function display_error($error_message, $error_type = 'error', $widget_id = '') {
        $error_id = 'promen-error-' . wp_generate_uuid4();
        $classes = ['promen-widget-error', 'promen-form-' . $error_type];
        
        if (!empty($widget_id)) {
            $classes[] = 'widget-' . $widget_id . '-error';
        }
        
        return sprintf(
            '<div id="%s" class="%s" role="alert" aria-live="assertive" tabindex="-1">
                <span class="error-icon" aria-hidden="true">⚠</span>
                <span class="error-message">%s</span>
                <button type="button" class="error-dismiss" aria-label="%s" onclick="this.parentElement.remove()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>',
            esc_attr($error_id),
            esc_attr(implode(' ', $classes)),
            esc_html($error_message),
            esc_attr__('Foutmelding sluiten', 'promen-elementor-widgets')
        );
    }
    
    /**
     * Display accessible success message
     *
     * @param string $message Success message.
     * @param string $widget_id Widget ID.
     * @return string Success HTML.
     */
    public static function display_success($message, $widget_id = '') {
        $success_id = 'promen-success-' . wp_generate_uuid4();
        $classes = ['promen-widget-success', 'promen-form-success'];
        
        if (!empty($widget_id)) {
            $classes[] = 'widget-' . $widget_id . '-success';
        }
        
        return sprintf(
            '<div id="%s" class="%s" role="status" aria-live="polite" tabindex="-1">
                <span class="success-icon" aria-hidden="true">✓</span>
                <span class="success-message">%s</span>
                <button type="button" class="success-dismiss" aria-label="%s" onclick="this.parentElement.remove()">
                    <span aria-hidden="true">×</span>
                </button>
            </div>',
            esc_attr($success_id),
            esc_attr(implode(' ', $classes)),
            esc_html($message),
            esc_attr__('Succesmelding sluiten', 'promen-elementor-widgets')
        );
    }
    
    /**
     * Setup AJAX error handling
     */
    private function setup_ajax_error_handling() {
        // Only apply to AJAX requests
        if (!wp_doing_ajax()) {
            return;
        }
        
        // Set a custom error handler for AJAX requests
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            $log_file = $this->log_dir . 'ajax-errors.log';
            
            $log_data = gmdate('[Y-m-d H:i:s]') . "\n";
            $log_data .= "ERROR: [$errno] $errstr\n";
            $log_data .= "FILE: $errfile\n";
            $log_data .= "LINE: $errline\n";
            $log_data .= "-----------------------------------\n\n";
            
            $this->write_log($log_file, $log_data);
            
            // Let PHP handle the error as well
            return false;
        });
        
        // Set a shutdown function to catch fatal errors
        register_shutdown_function(function() {
            $error = error_get_last();
            
            if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR], true)) {
                $log_file = $this->log_dir . 'fatal-errors.log';
                
                $log_data = gmdate('[Y-m-d H:i:s]') . "\n";
                $log_data .= "FATAL ERROR: [{$error['type']}] {$error['message']}\n";
                $log_data .= "FILE: {$error['file']}\n";
                $log_data .= "LINE: {$error['line']}\n";
                $log_data .= "-----------------------------------\n\n";
                
                $this->write_log($log_file, $log_data);
            }
        });
    }
}

// Initialize error handling
new Promen_Error_Handling();