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

if (class_exists('Promen_Assets_Manager')) {
    return;
}

class Promen_Assets_Manager {
    
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
        
        // --- Widget Styles (Standardized Paths) ---

        // Feature Blocks
        wp_register_style(
            'promen-feature-blocks-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/feature-blocks/assets/css/feature-blocks.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Services Carousel
        wp_register_style(
            'promen-services-carousel-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-carousel/assets/css/services-carousel.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Services Grid
        wp_register_style(
            'promen-services-grid-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/css/services-grid.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        // Services Grid Extras
        wp_register_style(
            'promen-services-grid-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/css/services-grid-accessibility.css',
            ['promen-services-grid-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_register_style(
            'services-grid-slider-style',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/css/services-grid-slider.css',
            ['promen-services-grid-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Image Text Block
        wp_register_style(
            'promen-image-text-block-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/css/image-text-block.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        // Image Text Block Extras
        wp_register_style(
            'promen-image-text-block-accessibility', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/css/image-text-block-accessibility.css',
            ['promen-image-text-block-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // News Posts
        // Note: Using 'promen-content-posts-style' handle for backward compatibility
        wp_register_style(
            'promen-content-posts-style',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/news-posts/assets/css/news-posts.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        // News Posts Extras
        wp_register_style(
            'promen-news-slider-style',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/news-posts/assets/css/news-posts-slider.css',
            ['promen-content-posts-style'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Stats Counter
        wp_register_style(
            'promen-stats-counter-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/css/stats-counter.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        // Stats Counter Extras
        wp_register_style(
            'promen-stats-counter-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/css/stats-counter-accessibility.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-stats-counter-accessibility');

        // Contact Info Card
        wp_register_style(
            'contact-info-card',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/contact-info-card/assets/css/contact-info-card.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        ); // Enqueue handled in widget if needed, or by dependency
        wp_register_style(
            'contact-info-card-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/contact-info-card/assets/css/contact-info-card-accessibility.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Team Members Carousel
        wp_register_style(
            'promen-team-members-carousel-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/team-members-carousel/assets/css/team-members-carousel.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Certification Logos
        wp_register_style(
            'promen-certification-logos',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/certification-logos/assets/css/certification-logos.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-certification-logos');

        // Worker Testimonial
        wp_register_style(
            'promen-worker-testimonial-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/worker-testimonial/assets/css/worker-testimonial.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-worker-testimonial-widget');

        // Benefits Widget
        wp_register_style(
            'promen-benefits-widget-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/benefits-widget/assets/css/benefits-widget.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-benefits-widget-widget');

        // Hero Slider
        wp_register_style(
            'hero-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hero-slider/assets/css/hero-slider.css',
            ['swiper-bundle-css'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('hero-slider');

        // Text Content Block
        wp_register_style(
            'promen-text-content-block',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-content-block/assets/css/text-content-block.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Image Slider
        wp_register_style(
            'promen-image-slider-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-slider/assets/css/image-slider.css',
            ['swiper-bundle-css'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-image-slider-widget');

        // Related Services
        wp_register_style(
            'promen-related-services-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/related-services/assets/css/related-services.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Text Column Repeater
        wp_register_style(
            'promen-text-column-repeater-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-column-repeater/assets/css/text-column-repeater.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Solicitation Timeline
        wp_register_style(
            'promen-solicitation-timeline-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/solicitation-timeline/assets/css/solicitation-timeline.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Business Catering
        wp_register_style(
            'promen-business-catering-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/business-catering/assets/css/business-catering.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Testimonial Card
        wp_register_style(
            'promen-testimonial-card-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/testimonial-card/assets/css/testimonial-card.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Image Text Slider
        wp_register_style(
            'image-text-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/css/style.css',
            ['swiper-bundle-css'],
            '1.0.1' // Version from original file
        );
        // Image Text Slider Extras
        wp_register_style(
            'image-text-slider-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/css/modules/accessibility-minimal.css',
            ['image-text-slider'],
            '1.0.0-wcag-2.2-minimal'
        );
        wp_register_style(
            'image-text-slider-mobile',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/css/modules/mobile-optimizations.css',
            ['image-text-slider'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Checklist Comparison
        wp_register_style(
            'promen-checklist-comparison-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/checklist-comparison/assets/css/checklist-comparison.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Contact Info Blocks
        wp_register_style(
            'promen-contact-info-blocks-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/contact-info-blocks/assets/css/contact-info-blocks.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Locations Display
        wp_register_style(
            'promen-locations-display-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/locations-display/assets/css/locations-display.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Document Info List
        wp_register_style(
            'promen-document-info-list-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/document-info-list/assets/css/document-info-list.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Hamburger Menu
        wp_register_style(
            'promen-hamburger-menu-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hamburger-menu/assets/css/hamburger-menu.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-hamburger-menu-widget');
    }
    
    /**
     * Register All Scripts
     */
    public function register_scripts() {
        // Global Libraries
        $this->register_lenis_scripts();
        $this->register_gsap_scripts();

        // Core Accessibility Library
        wp_register_script(
            'promen-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/promen-accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_enqueue_script('promen-accessibility');
        
        // --- Widget Scripts (Standardized Paths) ---

        // Feature Blocks (No main script, only accessibility)
        wp_register_script(
            'feature-blocks-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/feature-blocks/assets/js/feature-blocks-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Services Carousel
        wp_register_script(
            'promen-services-carousel-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-carousel/assets/js/services-carousel.js',
            ['jquery', 'swiper-bundle', 'gsap'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-services-carousel-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-carousel/assets/js/services-carousel-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Services Grid
        wp_register_script(
            'services-grid-slider-script', // Legacy handle
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/js/services-grid.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-services-grid-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/js/services-grid-accessibility.js',
            ['jquery', 'services-grid-slider-script', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Image Text Block
        wp_register_script(
            'promen-image-text-block-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/js/image-text-block.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-image-text-block-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/js/image-text-block-accessibility.js',
            ['jquery', 'promen-image-text-block-widget', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // News Posts
        // Note: Using 'promen-news-slider-script' handle for backward compatibility
        wp_register_script(
            'promen-news-slider-script',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/news-posts/assets/js/news-posts-slider.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Stats Counter
        wp_register_script(
            'promen-stats-counter-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/js/stats-counter.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-stats-counter-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/js/stats-counter-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Team Members Carousel
        wp_register_script(
            'promen-team-members-carousel-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/team-members-carousel/assets/js/team-members-carousel.js',
            ['jquery', 'swiper-bundle', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        wp_register_script(
            'promen-team-members-carousel-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/team-members-carousel/assets/js/team-members-carousel-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Worker Testimonial (Accessibility only)
        wp_register_script(
            'promen-worker-testimonial-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/worker-testimonial/assets/js/worker-testimonial-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION . '.' . time(),
            true
        );

        // Hero Slider
        wp_register_script(
            'hero-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hero-slider/assets/js/hero-slider.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-hero-slider-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hero-slider/assets/js/hero-slider-accessibility.js',
            ['jquery', 'hero-slider', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Text Content Block
        wp_register_script(
            'promen-text-content-block-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-content-block/assets/js/text-content-block.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Image Slider
        wp_register_script(
            'promen-image-slider-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-slider/assets/js/image-slider.js',
            ['jquery', 'swiper-bundle', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Solicitation Timeline
        wp_register_script(
            'promen-solicitation-timeline-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/solicitation-timeline/assets/js/solicitation-timeline.js',
            ['jquery', 'gsap', 'gsap-scrolltrigger', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // News Posts Accessibility
        wp_register_script(
            'promen-news-posts-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/news-posts/assets/js/news-posts-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Image Text Slider
        // Promen Image Text Slider Init (MUST be loaded before script.js due to function definition)
        wp_register_script(
            'promen-image-text-slider-init',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/js/modules/init-slider.js',
            ['jquery', 'swiper-bundle', 'gsap'], 
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        wp_register_script(
            'image-text-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/js/script.js',
            ['jquery', 'swiper-bundle', 'gsap', 'promen-image-text-slider-init', 'promen-accessibility'],
            '1.0.2-mobile-optimized',
            true
        );

        // Checklist Comparison
        wp_register_script(
            'promen-checklist-comparison-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/checklist-comparison/assets/js/checklist-comparison.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Hamburger Menu
        wp_register_script(
            'promen-hamburger-menu-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hamburger-menu/assets/js/hamburger-menu.js',
            ['jquery', 'gsap', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Business Catering
        wp_register_script(
            'promen-business-catering-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/business-catering/assets/js/business-catering-slider.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-business-catering-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/business-catering/assets/js/business-catering-accessibility.js',
            ['jquery', 'promen-business-catering-slider', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Locations Display (Accessibility only)
        wp_register_script(
            'promen-locations-display-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/locations-display/assets/js/locations-display-accessibility.js',
            ['jquery', 'gsap', 'gsap-scrolltrigger', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Contact Info Blocks (Accessibility only)
        wp_register_script(
            'promen-contact-info-blocks-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/contact-info-blocks/assets/js/contact-info-blocks-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Contact Info Card (Accessibility only)
        wp_register_script(
            'contact-info-card-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/contact-info-card/assets/js/contact-info-card-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Document Info List
        wp_register_script(
            'document-info-list-script',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/document-info-list/assets/js/document-info-list.js',
            ['jquery', 'gsap'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-document-info-list-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/document-info-list/assets/js/document-info-list-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Related Services
        wp_register_script(
            'promen-related-services-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/related-services/assets/js/related-services-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Testimonial Card
        wp_register_script(
            'promen-testimonial-card-script',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/testimonial-card/assets/js/testimonial-card.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-testimonial-card-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/testimonial-card/assets/js/testimonial-card-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Text Column Repeater
        wp_register_script(
            'promen-text-column-repeater-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-column-repeater/assets/js/text-column-repeater.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_register_script(
            'promen-text-column-repeater-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-column-repeater/assets/js/text-column-repeater-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );

        // Benefits Widget
        wp_register_script(
            'promen-benefits-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/benefits-widget/assets/js/benefits-accessibility.js',
            ['jquery', 'promen-accessibility'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
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