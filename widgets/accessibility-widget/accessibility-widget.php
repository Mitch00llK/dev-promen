<?php
/**
 * Accessibility Widget
 * 
 * WCAG-compliant accessibility overlay widget that provides
 * comprehensive accessibility controls without translation features.
 * 
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Accessibility Widget Class
 * 
 * Handles registration, asset loading, and rendering of the
 * accessibility widget toggle and control panel.
 */
class Promen_Accessibility_Widget {

    /**
     * Singleton instance
     * @var Promen_Accessibility_Widget
     */
    private static $instance = null;

    /**
     * Widget settings
     * @var array
     */
    private $settings = [];

    /**
     * Get singleton instance
     * @return Promen_Accessibility_Widget
     */
    public static function instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->load_settings();
        $this->init_hooks();
    }

    /**
     * Load widget settings
     */
    private function load_settings() {
        $defaults = [
            'enabled' => true,
            'position' => 'bottom-right',
            'icon_size' => 56,
            'z_index' => 999999,
        ];
        
        $this->settings = wp_parse_args(
            get_option('promen_a11y_widget_settings', []),
            $defaults
        );
    }

    /**
     * Initialize WordPress hooks
     */
    private function init_hooks() {
        // Enqueue assets on frontend
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        
        // Render widget on frontend
        add_action('wp_footer', [$this, 'render_widget']);
        
        // Register settings (for future admin page)
        add_action('admin_init', [$this, 'register_settings']);
    }

    /**
     * Register admin settings
     */
    public function register_settings() {
        register_setting('promen_a11y_widget', 'promen_a11y_widget_settings', [
            'type' => 'array',
            'sanitize_callback' => [$this, 'sanitize_settings'],
            'default' => [],
        ]);
    }

    /**
     * Sanitize settings
     * @param array $input Raw settings input
     * @return array Sanitized settings
     */
    public function sanitize_settings($input) {
        $sanitized = [];
        
        $sanitized['enabled'] = !empty($input['enabled']);
        $sanitized['position'] = sanitize_text_field($input['position'] ?? 'bottom-right');
        $sanitized['icon_size'] = absint($input['icon_size'] ?? 56);
        $sanitized['z_index'] = absint($input['z_index'] ?? 999999);
        
        return $sanitized;
    }

    /**
     * Enqueue widget assets
     */
    public function enqueue_assets() {
        if (!$this->settings['enabled']) {
            return;
        }
        
        // Don't load in admin or Elementor editor
        if (is_admin()) {
            return;
        }
        
        $widget_url = PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/accessibility-widget/assets/';
        $widget_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/accessibility-widget/assets/';
        $version = PROMEN_ELEMENTOR_WIDGETS_VERSION;
        
        // Main CSS
        wp_enqueue_style(
            'promen-a11y-widget',
            $widget_url . 'css/accessibility-widget.css',
            [],
            $version
        );
        
        // Main JS
        wp_enqueue_script(
            'promen-a11y-widget',
            $widget_url . 'js/accessibility-widget.js',
            [],
            $version,
            true
        );
        
        // Localize script with settings
        wp_localize_script('promen-a11y-widget', 'promenA11yWidget', [
            'position' => $this->settings['position'],
            'iconSize' => $this->settings['icon_size'],
            'zIndex' => $this->settings['z_index'],
            'i18n' => $this->get_i18n_strings(),
        ]);
    }

    /**
     * Get internationalization strings
     * @return array Translated strings
     */
    private function get_i18n_strings() {
        return [
            'widgetTitle' => __('Accessibility Options', 'promen-elementor-widgets'),
            'openWidget' => __('Open accessibility menu', 'promen-elementor-widgets'),
            'closeWidget' => __('Close accessibility menu', 'promen-elementor-widgets'),
            'resetAll' => __('Reset all settings', 'promen-elementor-widgets'),
            
            // Section titles
            'visualAdjustments' => __('Visual Adjustments', 'promen-elementor-widgets'),
            'contentScaling' => __('Content Scaling', 'promen-elementor-widgets'),
            'colorContrast' => __('Color & Contrast', 'promen-elementor-widgets'),
            'textAdjustments' => __('Text Adjustments', 'promen-elementor-widgets'),
            'navigation' => __('Navigation & Interaction', 'promen-elementor-widgets'),
            'contentControl' => __('Content Control', 'promen-elementor-widgets'),
            'cognitiveSupport' => __('Cognitive Support', 'promen-elementor-widgets'),
            'profiles' => __('Accessibility Profiles', 'promen-elementor-widgets'),
            
            // Controls
            'textSize' => __('Text Size', 'promen-elementor-widgets'),
            'pageZoom' => __('Page Zoom', 'promen-elementor-widgets'),
            'highContrast' => __('High Contrast', 'promen-elementor-widgets'),
            'darkContrast' => __('Dark Contrast', 'promen-elementor-widgets'),
            'lightContrast' => __('Light Contrast', 'promen-elementor-widgets'),
            'monochrome' => __('Monochrome', 'promen-elementor-widgets'),
            'invertColors' => __('Invert Colors', 'promen-elementor-widgets'),
            'saturation' => __('Saturation', 'promen-elementor-widgets'),
            'lineHeight' => __('Line Height', 'promen-elementor-widgets'),
            'letterSpacing' => __('Letter Spacing', 'promen-elementor-widgets'),
            'wordSpacing' => __('Word Spacing', 'promen-elementor-widgets'),
            'dyslexiaFont' => __('Dyslexia-Friendly Font', 'promen-elementor-widgets'),
            'textAlign' => __('Text Alignment', 'promen-elementor-widgets'),
            'focusIndicator' => __('Focus Indicators', 'promen-elementor-widgets'),
            'largeCursor' => __('Large Cursor', 'promen-elementor-widgets'),
            'readingGuide' => __('Reading Guide', 'promen-elementor-widgets'),
            'readingMask' => __('Reading Mask', 'promen-elementor-widgets'),
            'highlightLinks' => __('Highlight Links', 'promen-elementor-widgets'),
            'highlightHeaders' => __('Highlight Headers', 'promen-elementor-widgets'),
            'stopAnimations' => __('Stop Animations', 'promen-elementor-widgets'),
            'hideImages' => __('Hide Images', 'promen-elementor-widgets'),
            'muteSounds' => __('Mute Sounds', 'promen-elementor-widgets'),
            'textToSpeech' => __('Text to Speech', 'promen-elementor-widgets'),
            
            // Profiles
            'visionImpaired' => __('Vision Impaired', 'promen-elementor-widgets'),
            'cognitiveDisability' => __('Cognitive Disability', 'promen-elementor-widgets'),
            'seizureSafe' => __('Seizure Safe', 'promen-elementor-widgets'),
            'adhdFriendly' => __('ADHD Friendly', 'promen-elementor-widgets'),
            
            // Alignment options
            'alignLeft' => __('Left', 'promen-elementor-widgets'),
            'alignCenter' => __('Center', 'promen-elementor-widgets'),
            'alignRight' => __('Right', 'promen-elementor-widgets'),
            
            // Announcements
            'settingsReset' => __('All accessibility settings have been reset', 'promen-elementor-widgets'),
            'settingEnabled' => __('%s enabled', 'promen-elementor-widgets'),
            'settingDisabled' => __('%s disabled', 'promen-elementor-widgets'),
        ];
    }

    /**
     * Render the widget HTML
     */
    public function render_widget() {
        if (!$this->settings['enabled']) {
            return;
        }
        
        // Don't render in admin
        if (is_admin()) {
            return;
        }
        
        // Load the widget template
        include PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/accessibility-widget/templates/widget-panel.php';
    }

    /**
     * Get current settings
     * @return array Widget settings
     */
    public function get_settings() {
        return $this->settings;
    }
}

// Initialize the widget
add_action('init', function() {
    Promen_Accessibility_Widget::instance();
});
