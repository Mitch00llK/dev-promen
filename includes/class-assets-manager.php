<?php
/**
 * Assets Manager Class
 * 
 * Handles registration and enqueuing of scripts and styles.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include registrar and config files
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/assets/class-assets-config.php');
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/assets/class-script-registrar.php');
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/assets/class-style-registrar.php');
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/class-accessibility-i18n.php');

class Promen_Assets_Manager {
    
    /**
     * Script Registrar
     */
    private $script_registrar;

    /**
     * Style Registrar
     */
    private $style_registrar;

    /**
     * Constructor
     */
    public function __construct() {
        // Initialize registrars
        $this->script_registrar = new Promen_Script_Registrar();
        $this->style_registrar  = new Promen_Style_Registrar();

        // Core Assets Registration
        add_action('init', [$this, 'register_styles'], 20);
        add_action('init', [$this, 'register_scripts'], 20);
        
        // Global Enqueues
        add_action('wp_enqueue_scripts', [$this, 'enqueue_global_assets']);
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueue_global_assets']);
        add_action('elementor/preview/enqueue_scripts', [$this, 'enqueue_swiper']);
    }
    
    /**
     * Register All Styles
     */
    public function register_styles() {
        // Main stylesheet
        wp_register_style(
            'promen-elementor-widgets', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/css/style.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Register Swiper CSS
        $swiper_css_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'assets/js/swiper/swiper-bundle.min.css';
        if (file_exists($swiper_css_path)) {
            wp_register_style('swiper-bundle-css', PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/swiper/swiper-bundle.min.css', [], PROMEN_ELEMENTOR_WIDGETS_VERSION);
        } else if (did_action('elementor/loaded')) {
             wp_register_style('swiper-bundle-css', ELEMENTOR_ASSETS_URL . 'lib/swiper/swiper.min.css', [], ELEMENTOR_VERSION);
        }

        // Register widget styles from config
        $this->style_registrar->register_widget_styles(
            Promen_Assets_Config::get_widget_styles()
        );
    }
    
    /**
     * Register All Scripts
     */
    public function register_scripts() {
        // Global Libraries
        $this->register_lenis_scripts();
        $this->register_gsap_scripts();

        // Register Swiper JS
        $swiper_js_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'assets/js/swiper/swiper-bundle.min.js';
        if (file_exists($swiper_js_path)) {
            wp_register_script('swiper-bundle', PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/swiper/swiper-bundle.min.js', [], PROMEN_ELEMENTOR_WIDGETS_VERSION, true);
        } else if (did_action('elementor/loaded')) {
            wp_register_script('swiper-bundle', ELEMENTOR_ASSETS_URL . 'lib/swiper/swiper.min.js', [], ELEMENTOR_VERSION, true);
        }

        // Core Accessibility Library
        wp_register_script(
            'promen-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/promen-accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Localize accessibility strings for i18n
        wp_localize_script(
            'promen-accessibility',
            'promenA11yStrings',
            Promen_Accessibility_i18n::get_js_strings()
        );
        
        wp_enqueue_script('promen-accessibility');
        
        // Register widget scripts from config
        $this->script_registrar->register_widget_scripts(
            Promen_Assets_Config::get_widget_scripts()
        );

        // Editor Fix
        if (is_admin() && isset($_GET['action']) && $_GET['action'] === 'elementor') {
            wp_add_inline_script('elementor-editor-site-navigation', 'window.elementorSiteNavigationSettings = window.elementorSiteNavigationSettings || {};', 'before');
        }
    }

    /**
     * Enqueue global assets (Fonts, Swiper)
     */
    public function enqueue_global_assets() {
        wp_enqueue_style('promen-elementor-widgets');
        $this->enqueue_google_fonts();
        $this->enqueue_swiper();
    }

    /**
     * Enqueue Google Fonts
     */
    public function enqueue_google_fonts() {
        wp_enqueue_style('google-font-dancing-script', 'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap', [], PROMEN_ELEMENTOR_WIDGETS_VERSION);
        wp_enqueue_style('google-font-manrope', 'https://fonts.googleapis.com/css2?family=Manrope:wght@300;800&display=swap', [], PROMEN_ELEMENTOR_WIDGETS_VERSION);
    }
    
    /**
     * Enqueue Swiper library
     */
    public function enqueue_swiper() {
        wp_enqueue_style('swiper-bundle-css');
        wp_enqueue_script('swiper-bundle');
    }

    /**
     * Register GSAP scripts
     */
    public function register_gsap_scripts() {
        wp_register_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js', [], '3.12.2', true);
        wp_register_script('gsap-scrolltrigger', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js', ['gsap'], '3.12.2', true);
    }

    /**
     * Register Lenis smooth scroll
     */
    public function register_lenis_scripts() {
        $settings = get_option('lenis_scroll_options', ['enable_lenis' => true, 'scroll_duration' => 1.2, 'scroll_easing' => 'ease-out-expo']);
        if (!$settings['enable_lenis']) return;

        wp_register_script('lenis-js', 'https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js', [], '1.1.18', true);
        wp_register_script('promen-lenis-smooth-scroll', PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/lenis-smooth-scroll.js', ['lenis-js', 'gsap', 'gsap-scrolltrigger'], PROMEN_ELEMENTOR_WIDGETS_VERSION, true);
        
        if (!is_admin()) {
            wp_enqueue_script('lenis-js');
            wp_enqueue_script('promen-lenis-smooth-scroll');
            wp_localize_script('promen-lenis-smooth-scroll', 'lenisSettings', $settings);
        }
    }
}