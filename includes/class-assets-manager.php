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

class Promen_Assets_Manager {
    
    /**
     * Widget Configuration
     * 
     * Handles standard assets (styles/scripts) located in standardized paths:
     * widgets/{key}/assets/css/{key}.css
     * widgets/{key}/assets/js/{key}.js
     */
    private $widget_config = [
        'feature-blocks' => [
            'style_deps' => ['promen-elementor-widgets'],
            'has_script' => false // Has accessibility script handled separately
        ],
        'services-carousel' => [
            'style_deps' => ['promen-elementor-widgets'],
            'script_deps' => ['jquery', 'swiper-bundle', 'gsap']
        ],
        'services-grid' => [
            'style_deps' => ['promen-elementor-widgets'],
            'script_deps' => ['jquery', 'swiper-bundle']
        ],
        'image-text-block' => [
            'style_deps' => ['promen-elementor-widgets'],
            'script_deps' => ['jquery']
        ],
        'news-posts' => [
            'style_deps' => ['promen-elementor-widgets'],
            'script_deps' => ['jquery', 'swiper-bundle'],
            'script_handle_key' => 'news-posts-slider', // Only if file name differs from key
            'style_handle_key' => 'news-posts' // File is news-posts.css
        ],
        'team-members-carousel' => [
            'style_deps' => ['promen-elementor-widgets'],
            'script_deps' => ['jquery', 'swiper-bundle']
        ],
        'stats-counter' => [
            'style_deps' => [], // stats-counter.css
            'script_deps' => ['jquery'],
            'style_path_override' => 'widgets/stats-counter/assets/css/stats-counter/stats-counter.css',
            'script_path_override' => 'widgets/stats-counter/assets/js/stats-counter/stats-counter.js'
        ],
        'contact-info-card' => [
            'style_deps' => ['promen-elementor-widgets'],
            'has_script' => false
        ],
        'certification-logos' => [
            'style_deps' => [],
            'has_script' => false,
            'enqueue_style' => true
        ],
        'worker-testimonial' => [
            'style_deps' => ['promen-elementor-widgets'],
            'has_script' => false, // Handled separately due to versioning/meta
            'enqueue_style' => true
        ],
        'benefits-widget' => [
            'style_deps' => [],
            'has_script' => false,
            'enqueue_style' => true
        ],
        'hero-slider' => [
            'style_deps' => ['swiper-bundle-css'],
            'script_deps' => ['jquery', 'swiper-bundle'],
            'enqueue_style' => true,
            'enqueue_script' => true
        ],
        'text-content-block' => [
            'style_deps' => [],
            'script_deps' => ['jquery']
        ],
        'text-column-repeater' => [
            'style_deps' => ['promen-elementor-widgets'],
            'has_script' => false
        ],
        'solicitation-timeline' => [
            'style_deps' => ['promen-elementor-widgets'],
            'script_deps' => ['jquery', 'gsap', 'gsap-scrolltrigger']
        ],
        'related-services' => [
            'style_deps' => [],
            'has_script' => false
        ],
        'image-text-slider' => [
            'style_deps' => ['swiper-bundle-css'], // style.css
            'script_deps' => ['jquery', 'swiper-bundle', 'gsap'], // script.js
            'style_path_override' => 'widgets/image-text-slider/assets/css/style.css',
            'script_path_override' => 'widgets/image-text-slider/assets/js/script.js'
        ],
        'hamburger-menu' => [
            'style_deps' => [],
            'script_deps' => ['jquery', 'gsap'],
            'enqueue_style' => true,
            'enqueue_script' => true
        ],
        'checklist-comparison' => [
            'style_deps' => ['promen-elementor-widgets'],
            'script_deps' => ['jquery']
        ],
        'image-slider' => [
            'style_deps' => ['swiper-bundle-css'],
            'script_deps' => ['jquery', 'swiper-bundle'],
            'enqueue_style' => true,
            'enqueue_script' => true
        ]
    ];

    /**
     * Constructor
     */
    public function __construct() {
        // Core Assets Registration
        add_action('elementor/frontend/after_register_styles', [$this, 'register_styles']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_scripts']);
        
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
        wp_enqueue_style('promen-elementor-widgets');
        
        // Standard Widget Styles
        $this->register_configured_widgets('style');

        // --- Special Case Style Registrations ---

        // Services Grid Accessibility
        wp_register_style(
            'promen-services-grid-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/css/services-grid-accessibility.css',
            ['promen-services-grid-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Image Text Block Accessibility
        wp_register_style(
            'promen-image-text-block-accessibility', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/css/image-text-block-accessibility.css',
            ['promen-image-text-block-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Stats Counter Accessibility
        wp_register_style(
            'promen-stats-counter-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/css/stats-counter/accessibility.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-stats-counter-accessibility');

        // Image Text Slider Extras (WCAG & Mobile)
        wp_register_style(
            'image-text-slider-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/css/modules/accessibility-minimal.css',
            ['promen-image-text-slider-widget'], // Alias generated by loop
            '1.0.0-wcag-2.2-minimal'
        );
        wp_register_style(
            'image-text-slider-mobile',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/css/modules/mobile-optimizations.css',
            ['promen-image-text-slider-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
    }
    
    /**
     * Register All Scripts
     */
    public function register_scripts() {
        // Global Libraries
        $this->register_lenis_scripts();
        $this->register_gsap_scripts();
        
        // Standard Widget Scripts
        $this->register_configured_widgets('script');

        // --- Special Case Script Registrations ---

        // Image Text Block Accessibility
        wp_register_script(
            'promen-image-text-block-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/js/image-text-block-accessibility.js',
            ['jquery', 'promen-image-text-block-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_enqueue_script('promen-image-text-block-accessibility');

        // Stats Counter Accessibility
        wp_register_script(
            'promen-stats-counter-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/js/stats-counter/accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_enqueue_script('promen-stats-counter-accessibility');

        // Services Carousel Accessibility
        wp_register_script(
            'promen-services-carousel-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-carousel/assets/js/services-carousel-accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_enqueue_script('promen-services-carousel-accessibility');

        // Worker Testimonial Accessibility (Explicit Versioning in original)
        wp_register_script(
            'promen-worker-testimonial-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/worker-testimonial/assets/js/worker-testimonial-accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION . '.' . time(),
            true
        );
        wp_enqueue_script('promen-worker-testimonial-accessibility');

        // Feature Blocks Accessibility
        wp_register_script(
            'feature-blocks-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/feature-blocks/assets/js/feature-blocks-accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Hero Slider Inline Script
        if (wp_script_is('promen-hero-slider-widget', 'registered')) {
             wp_add_inline_script('promen-hero-slider-widget', 'window.heroSliderSwiperAvailable = typeof Swiper !== "undefined";', 'before');
        }

        // Editor Fix
        if (is_admin() && isset($_GET['action']) && $_GET['action'] === 'elementor') {
            wp_add_inline_script('elementor-editor-site-navigation', 'window.elementorSiteNavigationSettings = window.elementorSiteNavigationSettings || {};', 'before');
        }
    }

    /**
     * Enqueue global assets (Fonts, Swiper)
     */
    public function enqueue_global_assets() {
        $this->enqueue_google_fonts();
        $this->enqueue_swiper();
    }

    /**
     * Core Logic: Register Styles/Scripts from Config
     * 
     * @param string $type 'style' or 'script'
     */
    private function register_configured_widgets($type) {
        foreach ($this->widget_config as $key => $config) {
            
            // Generate Handle
            // Default: promen-{key}-widget
            // Override: script_handle_key / style_handle_key
            $handle_key = $config[$type . '_handle_key'] ?? $key;
            // Exceptions for legacy handle compatibility can be added here
            // Mapping known legacy handles to maintain compatibility:
            $handle = 'promen-' . $handle_key . '-widget';
            
            // Special legacy overrides (if needed based on original file analysis):
            if ($key === 'news-posts' && $type === 'style') $handle = 'promen-content-posts-style';
            if ($key === 'news-posts' && $type === 'script') $handle = 'promen-news-slider-script';
            if ($key === 'news-posts' && $type === 'style' && isset($config['style_handle_key'])) $handle = 'promen-' . $config['style_handle_key'] . '-style'; // Fix logic
            
            // Clean logic:
            if ($key === 'news-posts') {
                $handle = ($type === 'style') ? 'promen-content-posts-style' : 'promen-news-slider-script';
            } elseif ($key === 'services-grid' && $type === 'script') {
                $handle = 'services-grid-slider-script'; // Legacy
            } elseif ($key === 'services-grid' && $type === 'style') {
                $handle = 'promen-services-grid-widget';
            } elseif ($key === 'contact-info-card' && $type === 'style') {
                $handle = 'contact-info-card';
            } elseif ($key === 'certification-logos') {
                $handle = 'promen-certification-logos';
            } elseif ($key === 'hero-slider') {
                $handle = 'hero-slider'; // Legacy handle used in dependencies? Note: Original used 'hero-slider'.
            } elseif ($key === 'text-content-block' && $type === 'style') {
                $handle = 'promen-text-content-block';
            } elseif ($key === 'image-text-slider') {
                $handle = 'image-text-slider';
            }
            
            // Check if asset should be registered
            if ($type === 'script' && isset($config['has_script']) && $config['has_script'] === false) {
                continue;
            }

            // Generate Path
            if (isset($config[$type . '_path_override'])) {
                $path = PROMEN_ELEMENTOR_WIDGETS_URL . $config[$type . '_path_override'];
            } else {
                // Standard: widgets/{key}/assets/{ext}/{key}.{ext}
                // Handle special filename cases (e.g. news-posts vs news-posts-slider)
                $filename = ($type === 'script' && isset($config['script_handle_key'])) ? $config['script_handle_key'] : $key;
                $ext = ($type === 'style') ? 'css' : 'js';
                // Note: Original code mostly used explicit names.
                // We will assume standard structure: widgets/{key}/assets/{ext}/{filename}.{ext}
                $path = PROMEN_ELEMENTOR_WIDGETS_URL . "widgets/{$key}/assets/{$ext}/{$filename}.{$ext}";
            }

            // Deps
            $deps = $config[$type . '_deps'] ?? [];

            // Register
            if ($type === 'style') {
                wp_register_style($handle, $path, $deps, PROMEN_ELEMENTOR_WIDGETS_VERSION);
                if (!empty($config['enqueue_style'])) {
                    wp_enqueue_style($handle);
                }
            } else {
                wp_register_script($handle, $path, $deps, PROMEN_ELEMENTOR_WIDGETS_VERSION, true);
                if (!empty($config['enqueue_script'])) {
                    wp_enqueue_script($handle);
                }
            }
        }
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
        $swiper_css_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'assets/js/swiper/swiper-bundle.min.css';
        $swiper_js_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'assets/js/swiper/swiper-bundle.min.js';
        
        if (!file_exists($swiper_css_path) || !file_exists($swiper_js_path)) {
            // Fallback to Elementor's Swiper
            if (did_action('elementor/loaded')) {
                wp_register_style('swiper-bundle-css', ELEMENTOR_ASSETS_URL . 'lib/swiper/swiper.min.css', [], ELEMENTOR_VERSION);
                wp_register_script('swiper-bundle', ELEMENTOR_ASSETS_URL . 'lib/swiper/swiper.min.js', [], ELEMENTOR_VERSION, true);
                return;
            }
            return;
        }
        
        wp_register_style('swiper-bundle-css', PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/swiper/swiper-bundle.min.css', [], PROMEN_ELEMENTOR_WIDGETS_VERSION);
        wp_register_script('swiper-bundle', PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/swiper/swiper-bundle.min.js', [], PROMEN_ELEMENTOR_WIDGETS_VERSION, true);
        
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

        wp_register_script('lenis-js', 'https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.19/bundled/lenis.min.js', [], '1.0.19', true);
        wp_register_script('promen-lenis-smooth-scroll', PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/lenis-smooth-scroll.js', ['lenis-js', 'gsap', 'gsap-scrolltrigger'], PROMEN_ELEMENTOR_WIDGETS_VERSION, true);
        
        if (!is_admin()) {
            wp_enqueue_script('lenis-js');
            wp_enqueue_script('promen-lenis-smooth-scroll');
            wp_localize_script('promen-lenis-smooth-scroll', 'lenisSettings', $settings);
        }
    }
}