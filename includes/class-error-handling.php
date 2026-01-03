<?php
/**
 * Error Handling Class
 * 
 * Handles error logging and debugging for the plugin.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Promen_Error_Handling {
    
    /**
     * Constructor
     */
    public function __construct() {
        // Enable error logging for debugging
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        ini_set('error_log', WP_CONTENT_DIR . '/debug.log');
        
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
            'generic_error' => __('An error occurred. Please try again.', 'promen-elementor-widgets'),
            'network_error' => __('Network error. Please check your connection and try again.', 'promen-elementor-widgets'),
            'validation_error' => __('Please correct the highlighted fields.', 'promen-elementor-widgets'),
            'success_message' => __('Operation completed successfully.', 'promen-elementor-widgets'),
            'loading_message' => __('Processing... Please wait.', 'promen-elementor-widgets'),
            'aria_labels' => [
                'error_region' => __('Error messages', 'promen-elementor-widgets'),
                'success_region' => __('Success messages', 'promen-elementor-widgets'),
                'close_error' => __('Close error message', 'promen-elementor-widgets')
            ]
        ]);
    }
    
    /**
     * Handle widget errors with accessibility features
     */
    public function handle_widget_error() {
        check_ajax_referer('promen_widget_nonce', 'nonce');
        
        $error_type = sanitize_text_field($_POST['error_type'] ?? 'generic');
        $error_message = sanitize_text_field($_POST['error_message'] ?? '');
        $widget_id = sanitize_text_field($_POST['widget_id'] ?? '');
        
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
     */
    private function get_accessible_error_message($error_type, $custom_message = '') {
        if (!empty($custom_message)) {
            return $custom_message;
        }
        
        $messages = [
            'validation' => __('Please review and correct the form fields marked with errors.', 'promen-elementor-widgets'),
            'network' => __('Unable to connect to the server. Please check your internet connection and try again.', 'promen-elementor-widgets'),
            'permission' => __('You do not have permission to perform this action.', 'promen-elementor-widgets'),
            'timeout' => __('The request timed out. Please try again.', 'promen-elementor-widgets'),
            'server' => __('A server error occurred. Please try again later.', 'promen-elementor-widgets'),
            'file_upload' => __('File upload failed. Please check the file size and format.', 'promen-elementor-widgets'),
            'generic' => __('An unexpected error occurred. Please try again.', 'promen-elementor-widgets')
        ];
        
        return $messages[$error_type] ?? $messages['generic'];
    }
    
    /**
     * Log user-facing errors
     */
    private function log_user_error($error_type, $message, $widget_id) {
        $log_file = PROMEN_ELEMENTOR_WIDGETS_PATH . 'user-errors.log';
        $log_data = date('[Y-m-d H:i:s]') . "\n";
        $log_data .= "USER ERROR: $error_type\n";
        $log_data .= "MESSAGE: $message\n";
        $log_data .= "WIDGET: $widget_id\n";
        $log_data .= "USER: " . (is_user_logged_in() ? get_current_user_id() : 'anonymous') . "\n";
        $log_data .= "PAGE: " . ($_SERVER['HTTP_REFERER'] ?? 'unknown') . "\n";
        $log_data .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";
        $log_data .= "-----------------------------------\n\n";
        
        file_put_contents($log_file, $log_data, FILE_APPEND | LOCK_EX);
    }
    
    /**
     * Display accessible error message
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
            esc_attr__('Dismiss error message', 'promen-elementor-widgets')
        );
    }
    
    /**
     * Display accessible success message
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
            esc_attr__('Dismiss success message', 'promen-elementor-widgets')
        );
    }
    
    /**
     * Setup AJAX error handling
     */
    private function setup_ajax_error_handling() {
        // Only apply to AJAX requests
        if (strpos($_SERVER['REQUEST_URI'], 'admin-ajax.php') === false) {
            return;
        }
        
        // Increase memory limit for AJAX requests
        ini_set('memory_limit', '256M');
        
        // Set a custom error handler for AJAX requests
        set_error_handler(function($errno, $errstr, $errfile, $errline) {
            // Log the error
            $log_file = PROMEN_ELEMENTOR_WIDGETS_PATH . 'ajax-errors.log';
            $log_data = date('[Y-m-d H:i:s]') . "\n";
            $log_data .= "ERROR: [$errno] $errstr\n";
            $log_data .= "FILE: $errfile\n";
            $log_data .= "LINE: $errline\n";
            $log_data .= "REQUEST URI: " . $_SERVER['REQUEST_URI'] . "\n";
            $log_data .= "-----------------------------------\n\n";
            
            // Write to log file
            file_put_contents($log_file, $log_data, FILE_APPEND);
            
            // Let PHP handle the error as well
            return false;
        });
        
        // Set a shutdown function to catch fatal errors
        register_shutdown_function(function() {
            $error = error_get_last();
            
            if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
                // Log the error
                $log_file = PROMEN_ELEMENTOR_WIDGETS_PATH . 'fatal-errors.log';
                $log_data = date('[Y-m-d H:i:s]') . "\n";
                $log_data .= "FATAL ERROR: [{$error['type']}] {$error['message']}\n";
                $log_data .= "FILE: {$error['file']}\n";
                $log_data .= "LINE: {$error['line']}\n";
                $log_data .= "REQUEST URI: " . $_SERVER['REQUEST_URI'] . "\n";
                $log_data .= "-----------------------------------\n\n";
                
                // Write to log file
                file_put_contents($log_file, $log_data, FILE_APPEND);
            }
        });
        
        // Add specific error handling for Elementor AJAX requests
        add_action('wp_ajax_elementor_ajax', function() {
            // Set a higher error reporting level for AJAX requests
            error_reporting(E_ALL);
            
            // Increase memory limit for AJAX requests
            ini_set('memory_limit', '256M');
            
            // Log the request
            $log_file = PROMEN_ELEMENTOR_WIDGETS_PATH . 'elementor-ajax-debug.log';
            $log_data = date('[Y-m-d H:i:s]') . " - Elementor AJAX Request\n";
            file_put_contents($log_file, $log_data, FILE_APPEND);
        }, 1);
    }
    
    /**
     * Debug Elementor AJAX requests
     */
    public function debug_elementor_ajax() {
        // Create a log file in the plugin directory
        $log_file = PROMEN_ELEMENTOR_WIDGETS_PATH . 'elementor-ajax-debug.log';
        
        // Get the actions from the request
        $actions = isset($_REQUEST['actions']) ? json_decode(stripslashes($_REQUEST['actions']), true) : [];
        
        // Log request information
        $log_data = date('[Y-m-d H:i:s]') . "\n";
        $log_data .= "ELEMENTOR AJAX REQUEST\n";
        $log_data .= "ACTIONS: " . json_encode($actions) . "\n";
        
        // Log POST data
        if (!empty($_POST)) {
            $log_data .= "POST DATA:\n";
            foreach ($_POST as $key => $value) {
                if ($key !== 'actions') { // Skip actions as we already logged them
                    if (is_array($value)) {
                        $log_data .= "- $key: " . json_encode($value) . "\n";
                    } else {
                        $log_data .= "- $key: $value\n";
                    }
                }
            }
        }
        
        $log_data .= "-----------------------------------\n\n";
        
        // Write to log file
        file_put_contents($log_file, $log_data, FILE_APPEND);
    }
}

// Initialize error handling
new Promen_Error_Handling(); 