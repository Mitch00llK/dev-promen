<?php
/**
 * Main Promen Elementor Widgets Class
 * 
 * Handles the core functionality of the plugin.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include required files
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/class-assets-manager.php');
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/class-widget-manager.php');
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/class-accessibility-utils.php');


/**
 * Main Promen Elementor Widgets Class
 */
final class Promen_Elementor_Widgets {

    /**
     * Minimum Elementor Version
     */
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    /**
     * Minimum PHP Version
     */
    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     */
    private static $_instance = null;
    
    /**
     * Assets Manager
     */
    public $assets_manager;
    
    /**
     * Widget Manager
     */
    public $widget_manager;
    
    /**
     * Accessibility Utils
     */
    public $accessibility_utils;

    /**
     * Get Instance
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
        // Initialize plugin only after Elementor is loaded
        add_action('plugins_loaded', [$this, 'init']);
    }

    /**
     * Initialize the plugin
     */
    public function init() {
        // Check if Elementor is installed and activated
        if (!did_action('elementor/loaded')) {
            add_action('admin_notices', [$this, 'admin_notice_missing_elementor']);
            return;
        }

        // Check for required Elementor version
        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);
            return;
        }

        // Check for required PHP version
        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);
            return;
        }

        // Initialize managers that don't depend on Elementor classes being loaded yet
        $this->assets_manager = new Promen_Assets_Manager();
        $this->accessibility_utils = Promen_Accessibility_Utils::instance();

        // Defer loading of our widget base class and widget registration until Elementor is fully initialized
        // This prevents "Class Elementor\Widget_Base not found" errors
        add_action('elementor/init', [$this, 'on_elementor_init']);
        
        // Include common controls after Elementor is loaded (controls don't extend Widget_Base so this is safeish, but cleaner in init)
        // Moving this to on_elementor_init as well just to be safe and consistent.
    }

    /**
     * Load plugin components after Elementor has initialized
     */
    public function on_elementor_init() {
        // Include common controls
        require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/controls/split-title-controls.php');
        
        // Include Promen Widget Base Class (Elementor is fully loaded now)
        require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/class-promen-widget-base.php');

        // Initialize Widget Manager (depends on Elementor)
        $this->widget_manager = new Promen_Widget_Manager();
        
        // Initialize Widget Admin (admin only)
        if (is_admin()) {
            require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/admin/class-widget-admin.php');
            Promen_Widget_Admin::instance();
        }
        
        // Add accessibility test endpoint for administrators
        if (current_user_can('administrator')) {
            add_action('wp_ajax_promen_accessibility_test', [$this, 'run_accessibility_tests']);
        }
    }

    /**
     * Admin notice for missing Elementor
     */
    public function admin_notice_missing_elementor() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" to be installed and activated.', 'promen-elementor-widgets'),
            '<strong>Promen Elementor Widgets</strong>',
            '<strong>Elementor</strong>'
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum Elementor version
     */
    public function admin_notice_minimum_elementor_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'promen-elementor-widgets'),
            '<strong>Promen Elementor Widgets</strong>',
            '<strong>Elementor</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice for minimum PHP version
     */
    public function admin_notice_minimum_php_version() {
        if (isset($_GET['activate'])) {
            unset($_GET['activate']);
        }

        $message = sprintf(
            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'promen-elementor-widgets'),
            '<strong>Promen Elementor Widgets</strong>',
            '<strong>PHP</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }
    
    /**
     * Run accessibility tests (AJAX endpoint)
     */
    public function run_accessibility_tests() {
        // Verify user permissions
        if (!current_user_can('administrator')) {
            wp_die('Unauthorized access');
        }
        
        // Include test file
        require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/accessibility-test.php');
        
        // Run tests
        $results = run_promen_accessibility_tests();
        
        // Return results
        wp_send_json_success($results);
    }
} 