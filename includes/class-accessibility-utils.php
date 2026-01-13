<?php
/**
 * Accessibility Utilities Loader
 * 
 * Loads all accessibility utility modules and provides
 * backward-compatible facade for existing code.
 * 
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include accessibility modules
require_once PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/accessibility/class-accessibility-aria.php';

require_once PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/accessibility/class-accessibility-contact.php';
require_once PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/accessibility/class-accessibility-skip-links.php';

/**
 * Accessibility Utilities Class (Facade)
 * 
 * Provides backward-compatible interface to accessibility utilities.
 * New code should use the specific classes directly.
 */
class Promen_Accessibility_Utils {

    /**
     * Instance
     *
     * @var Promen_Accessibility_Utils|null
     */
    private static $_instance = null;

    /**
     * Get Instance
     *
     * @return Promen_Accessibility_Utils
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->init_hooks();
    }

    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Enqueue screen reader styles
        add_action('wp_enqueue_scripts', [$this, 'enqueue_accessibility_styles']);
        
        // Add accessibility features to wp_head
        add_action('wp_head', [$this, 'add_accessibility_features']);
    }

    /**
     * Enqueue accessibility styles
     */
    public function enqueue_accessibility_styles() {
        wp_enqueue_style(
            'promen-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/css/accessibility.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
    }

    /**
     * Add accessibility features to head
     */
    public function add_accessibility_features() {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
    }

    // =========================================================================
    // FACADE METHODS - Delegate to specific classes
    // =========================================================================

    /**
     * @see Promen_Accessibility_Aria::generate_id()
     */
    public static function generate_id($prefix, $widget_id = '') {
        return Promen_Accessibility_Aria::generate_id($prefix, $widget_id);
    }

    /**
     * @see Promen_Accessibility_Aria::get_aria_label_attrs()
     */
    public static function get_aria_label_attrs($label = '', $labelledby = '', $describedby = '') {
        return Promen_Accessibility_Aria::get_aria_label_attrs($label, $labelledby, $describedby);
    }

    /**
     * @see Promen_Accessibility_Aria::get_aria_live_attrs()
     */
    public static function get_aria_live_attrs($politeness = 'polite', $atomic = false) {
        return Promen_Accessibility_Aria::get_aria_live_attrs($politeness, $atomic);
    }

    /**
     * @see Promen_Accessibility_Aria::get_button_attrs()
     */
    public static function get_button_attrs($args = []) {
        return Promen_Accessibility_Aria::get_button_attrs($args);
    }

    /**
     * @see Promen_Accessibility_Aria::get_slider_attrs()
     */
    public static function get_slider_attrs($args = []) {
        return Promen_Accessibility_Aria::get_slider_attrs($args);
    }

    /**
     * @see Promen_Accessibility_Aria::get_menu_attrs()
     */
    public static function get_menu_attrs($args = []) {
        return Promen_Accessibility_Aria::get_menu_attrs($args);
    }

    /**
     * @see Promen_Accessibility_Aria::get_form_attrs()
     */
    public static function get_form_attrs($args = []) {
        return Promen_Accessibility_Aria::get_form_attrs($args);
    }

    /**
     * @see Promen_Accessibility_Aria::get_screen_reader_text()
     */
    public static function get_screen_reader_text($text, $tag = 'span') {
        return Promen_Accessibility_Aria::get_screen_reader_text($text, $tag);
    }

    /**
     * @see Promen_Accessibility_Aria::get_keyboard_instructions()
     */
    public static function get_keyboard_instructions($component_type = 'grid') {
        return Promen_Accessibility_Aria::get_keyboard_instructions($component_type);
    }

    /**
     * @see Promen_Accessibility_Skip_Links::get_skip_link()
     */
    public static function get_skip_link($target, $text = '') {
        return Promen_Accessibility_Skip_Links::get_skip_link($target, $text);
    }

    /**
     * @see Promen_Accessibility_Skip_Links::get_widget_skip_link()
     */
    public static function get_widget_skip_link($widget_id, $widget_title = '', $widget_name = '') {
        return Promen_Accessibility_Skip_Links::get_widget_skip_link($widget_id, $widget_title, $widget_name);
    }

    /**
     * @see Promen_Accessibility_Skip_Links::render_widget_skip_link()
     */
    public static function render_widget_skip_link($widget, $widget_title = '') {
        Promen_Accessibility_Skip_Links::render_widget_skip_link($widget, $widget_title);
    }

    /**
     * @see Promen_Accessibility_Skip_Links::get_widget_container_id()
     */
    public static function get_widget_container_id($widget_id) {
        return Promen_Accessibility_Skip_Links::get_widget_container_id($widget_id);
    }



    /**
     * @see Promen_Accessibility_Contact::get_contact_block_attrs()
     */
    public static function get_contact_block_attrs($block_type, $data = [], $index = 0, $widget_id = '') {
        return Promen_Accessibility_Contact::get_contact_block_attrs($block_type, $data, $index, $widget_id);
    }

    /**
     * @see Promen_Accessibility_Contact::get_accessible_phone_link()
     */
    public static function get_accessible_phone_link($phone_number, $clickable = true, $extra_attrs = []) {
        return Promen_Accessibility_Contact::get_accessible_phone_link($phone_number, $clickable, $extra_attrs);
    }

    /**
     * @see Promen_Accessibility_Contact::get_accessible_email_link()
     */
    public static function get_accessible_email_link($email_address, $clickable = true, $extra_attrs = []) {
        return Promen_Accessibility_Contact::get_accessible_email_link($email_address, $clickable, $extra_attrs);
    }

    /**
     * @see Promen_Accessibility_Contact::sanitize_phone_number()
     */
    public static function sanitize_phone_number($phone) {
        return Promen_Accessibility_Contact::sanitize_phone_number($phone);
    }

    /**
     * @see Promen_Accessibility_Contact::validate_email_address()
     */
    public static function validate_email_address($email) {
        return Promen_Accessibility_Contact::validate_email_address($email);
    }

    /**
     * Check if user prefers reduced motion
     * 
     * @return bool Always false (JavaScript detection handles this).
     */
    public static function prefers_reduced_motion() {
        return false;
    }

    /**
     * Generate focus trap for modals/overlays
     * 
     * @param string $container_selector CSS selector for the container.
     * @return string JavaScript focus trap code.
     */
    public static function get_focus_trap_js($container_selector) {
        return "
        function initFocusTrap(containerSelector) {
            const container = document.querySelector(containerSelector);
            if (!container) return;
            
            const focusableElements = container.querySelectorAll(
                'a[href], button:not([disabled]), textarea:not([disabled]), input[type=\"text\"]:not([disabled]), input[type=\"radio\"]:not([disabled]), input[type=\"checkbox\"]:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex=\"-1\"])'
            );
            
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];
            
            container.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusable) {
                            lastFocusable.focus();
                            e.preventDefault();
                        }
                    } else {
                        if (document.activeElement === lastFocusable) {
                            firstFocusable.focus();
                            e.preventDefault();
                        }
                    }
                }
                
                if (e.key === 'Escape') {
                    container.style.display = 'none';
                    container.setAttribute('aria-hidden', 'true');
                }
            });
            
            if (firstFocusable) {
                firstFocusable.focus();
            }
        }
        
        initFocusTrap('" . esc_js($container_selector) . "');
        ";
    }

    /**
     * @see Promen_Accessibility_Aria::get_service_attrs()
     */
    public static function get_service_attrs($service, $index = 0, $widget_id = '') {
        return Promen_Accessibility_Aria::get_service_attrs($service, $index, $widget_id);
    }

    /**
     * @see Promen_Accessibility_Aria::get_services_grid_attrs()
     */
    public static function get_services_grid_attrs($services, $widget_id = '') {
        return Promen_Accessibility_Aria::get_services_grid_attrs($services, $widget_id);
    }

    /**
     * @see Promen_Accessibility_Aria::get_image_slider_attrs()
     */
    public static function get_image_slider_attrs($images, $index = 0, $widget_id = '') {
        return Promen_Accessibility_Aria::get_image_slider_attrs($images, $index, $widget_id);
    }

    /**
     * @see Promen_Accessibility_Aria::get_image_slider_container_attrs()
     */
    public static function get_image_slider_container_attrs($images, $widget_id = '', $is_slider = false) {
        return Promen_Accessibility_Aria::get_image_slider_container_attrs($images, $widget_id, $is_slider);
    }
}

// Initialize the accessibility utils
Promen_Accessibility_Utils::instance();