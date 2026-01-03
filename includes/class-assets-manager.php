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
     * Constructor
     */
    public function __construct() {
        // Register styles
        add_action('elementor/frontend/after_register_styles', [$this, 'register_styles']);
        
        // Register scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_scripts']);
        
        // Register Google Fonts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_google_fonts']);
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueue_google_fonts']);
        
        // Register Swiper
        add_action('wp_enqueue_scripts', [$this, 'enqueue_swiper']);
        add_action('elementor/editor/before_enqueue_scripts', [$this, 'enqueue_swiper']);
        add_action('elementor/preview/enqueue_scripts', [$this, 'enqueue_swiper']);
        
        // Register widget-specific scripts
        $this->register_widget_specific_scripts();
    }
    
    /**
     * Register widget-specific scripts
     */
    private function register_widget_specific_scripts() {
        // Image Text Block scripts
        add_action('wp_enqueue_scripts', [$this, 'register_image_text_block_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_image_text_block_scripts']);
        
        // Register widget styles and scripts
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_stats_counter_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_services_carousel_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_team_members_carousel_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_hero_slider_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_news_posts_slider_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_services_grid_slider_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_image_slider_scripts']);
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_solicitation_timeline_scripts']);
    }
    
    /**
     * Register styles
     */
    public function register_styles() {
        // Main stylesheet that imports individual widget styles
        wp_register_style(
            'promen-elementor-widgets', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/css/style.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-elementor-widgets');
        
        // Individual widget stylesheets
        $this->register_widget_styles();
    }
    
    /**
     * Register widget styles
     */
    private function register_widget_styles() {
        // Feature Blocks Widget
        wp_register_style(
            'promen-feature-blocks-widget', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/feature-blocks/assets/css/feature-blocks.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Services Carousel Widget
        wp_register_style(
            'promen-services-carousel-widget', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-carousel/assets/css/services-carousel.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Services Grid Widget
        wp_register_style(
            'promen-services-grid-widget', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/css/services-grid.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Services Grid Accessibility Styles
        wp_register_style(
            'promen-services-grid-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/css/services-grid-accessibility.css',
            ['promen-services-grid-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Image Text Block Widget
        wp_register_style(
            'promen-image-text-block-widget', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/css/image-text-block.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Image Text Block Widget Accessibility
        wp_register_style(
            'promen-image-text-block-accessibility', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/css/image-text-block-accessibility.css',
            ['promen-image-text-block-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // News Posts Widget
        wp_register_style(
            'promen-content-posts-style', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/news-posts/assets/css/news-posts.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Team Members Carousel Widget
        wp_register_style(
            'promen-team-members-carousel-widget', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/team-members-carousel/assets/css/team-members-carousel.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Stats Counter Widget
        wp_register_style(
            'promen-stats-counter-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/css/stats-counter/stats-counter.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Contact Info Card Widget
        wp_register_style(
            'contact-info-card', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/contact-info-card/assets/css/contact-info-card.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Certification Logos Widget
        wp_register_style(
            'promen-certification-logos', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/certification-logos/assets/css/certification-logos.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-certification-logos');

        // Worker Testimonial Widget
        wp_register_style(
            'promen-worker-testimonial-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/worker-testimonial/assets/css/worker-testimonial.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION . '.' . time()
        );
        wp_enqueue_style('promen-worker-testimonial-widget');
        
        // Worker Testimonial Accessibility Script
        wp_register_script(
            'promen-worker-testimonial-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/worker-testimonial/assets/js/worker-testimonial-accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION . '.' . time(),
            true
        );
        wp_enqueue_script('promen-worker-testimonial-accessibility');

        // Benefits Widget
        wp_register_style(
            'promen-benefits-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/benefits-widget/assets/css/benefits-widget.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-benefits-widget');

        // Hero Slider Widget
        wp_register_style(
            'promen-hero-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hero-slider/assets/css/hero-slider.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Text Content Block Widget
        wp_register_style(
            'promen-text-content-block',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-content-block/assets/css/text-content-block.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Text Column Repeater Widget
        wp_register_style(
            'promen-text-column-repeater-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-column-repeater/assets/css/text-column-repeater.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Solicitation Timeline Widget
        wp_register_style(
            'promen-solicitation-timeline-widget', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/solicitation-timeline/assets/css/solicitation-timeline.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Related Services Widget
        wp_register_style(
            'promen-related-services-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/related-services/includes/css/related-services.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Add our image-text slider assets after any other slider assets
        wp_register_style(
            'image-text-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/css/style.css',
            ['swiper-bundle-css'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Register accessibility styles for WCAG 2.2 compliance
        wp_register_style(
            'image-text-slider-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/css/modules/accessibility-minimal.css',
            ['image-text-slider'],
            '1.0.0-wcag-2.2-minimal'
        );
        
        // Register mobile optimization styles
        wp_register_style(
            'image-text-slider-mobile',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/css/modules/mobile-optimizations.css',
            ['image-text-slider'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        wp_register_script(
            'image-text-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-slider/assets/js/script.js',
            ['jquery', 'swiper-bundle', 'gsap'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Hamburger Menu Widget
        wp_register_style(
            'promen-hamburger-menu-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hamburger-menu/assets/css/hamburger-menu.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        wp_enqueue_style('promen-hamburger-menu-widget');
        
        // Ensure GSAP is available for the hamburger menu
        wp_enqueue_script('gsap');
        
        wp_register_script(
            'promen-hamburger-menu-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hamburger-menu/assets/js/hamburger-menu.js',
            ['jquery', 'gsap'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        wp_enqueue_script('promen-hamburger-menu-widget');
        
        // Checklist Comparison Widget
        wp_register_style(
            'promen-checklist-comparison-widget', 
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/checklist-comparison/assets/css/checklist-comparison.css',
            ['promen-elementor-widgets'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Checklist Comparison Widget JS
        wp_register_script(
            'promen-checklist-comparison-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/checklist-comparison/assets/js/checklist-comparison.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Feature Blocks Accessibility JS
        wp_register_script(
            'feature-blocks-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/feature-blocks/assets/js/feature-blocks-accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
    }
    
    /**
     * Register scripts
     */
    public function register_scripts() {
        // Register Lenis for smooth scrolling
        $this->register_lenis_scripts();
        
        // Register GSAP and ScrollTrigger
        $this->register_gsap_scripts();
        
        // Register all widget scripts
        $this->register_image_text_block_scripts();
        $this->register_stats_counter_scripts();
        $this->register_team_members_carousel_scripts();
        $this->register_services_carousel_scripts();
        $this->register_hero_slider_scripts();
        $this->register_news_posts_slider_scripts();
        $this->register_services_grid_slider_scripts();
        $this->register_image_slider_scripts();
        $this->register_solicitation_timeline_scripts();

        wp_register_script(
            'promen-text-content-block',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-content-block/assets/js/text-content-block.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Fix for Elementor editor site navigation settings
        if (is_admin() && isset($_GET['action']) && $_GET['action'] === 'elementor') {
            wp_add_inline_script('elementor-editor-site-navigation', 'window.elementorSiteNavigationSettings = window.elementorSiteNavigationSettings || {};', 'before');
        }
    }
    
    /**
     * Enqueue Google Fonts
     */
    public function enqueue_google_fonts() {
        // Enqueue Dancing Script font for the overlay text
        wp_enqueue_style(
            'google-font-dancing-script',
            'https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap',
            array(),
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Enqueue Manrope font for the split title
        wp_enqueue_style(
            'google-font-manrope',
            'https://fonts.googleapis.com/css2?family=Manrope:wght@300;800&display=swap',
            array(),
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
    }
    
    /**
     * Enqueue Swiper library
     */
    public function enqueue_swiper() {
        // Check if Swiper files exist
        $swiper_css_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'assets/js/swiper/swiper-bundle.min.css';
        $swiper_js_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'assets/js/swiper/swiper-bundle.min.js';
        
        if (!file_exists($swiper_css_path) || !file_exists($swiper_js_path)) {
            // Log error
            error_log('Promen Elementor Widgets: Swiper library files not found at ' . $swiper_css_path);
            
            // Try to use Elementor's Swiper as fallback
            if (did_action('elementor/loaded')) {
                wp_register_style(
                    'swiper-bundle-css',
                    ELEMENTOR_ASSETS_URL . 'lib/swiper/swiper.min.css',
                    [],
                    ELEMENTOR_VERSION
                );
                
                wp_register_script(
                    'swiper-bundle',
                    ELEMENTOR_ASSETS_URL . 'lib/swiper/swiper.min.js',
                    [],
                    ELEMENTOR_VERSION,
                    true
                );
                
                return;
            }
            
            // If Elementor is not available, register empty scripts to prevent errors
            wp_register_style('swiper-bundle-css', false);
            wp_register_script('swiper-bundle', false);
            
            return;
        }
        
        // Add CSS
        wp_register_style(
            'swiper-bundle-css',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/swiper/swiper-bundle.min.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );

        // Add JS
        wp_register_script(
            'swiper-bundle',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/swiper/swiper-bundle.min.js',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Ensure Swiper is loaded for widgets that need it
        wp_enqueue_style('swiper-bundle-css');
        wp_enqueue_script('swiper-bundle');
    }
    
    /**
     * Register Image Text Block scripts
     */
    public function register_image_text_block_scripts() {
        // Register and enqueue the image text block script
        wp_register_script(
            'promen-image-text-block-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/js/image-text-block.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Register accessibility script
        wp_register_script(
            'promen-image-text-block-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-text-block/assets/js/image-text-block-accessibility.js',
            ['jquery', 'promen-image-text-block-widget'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        wp_enqueue_script('promen-image-text-block-widget');
        wp_enqueue_script('promen-image-text-block-accessibility');
    }
    
    /**
     * Register Stats Counter scripts
     */
    public function register_stats_counter_scripts() {
        wp_register_script(
            'promen-stats-counter-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/js/stats-counter/stats-counter.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Register accessibility script
        wp_register_script(
            'promen-stats-counter-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/js/stats-counter/accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Register accessibility styles
        wp_register_style(
            'promen-stats-counter-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/stats-counter/assets/css/stats-counter/accessibility.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Enqueue scripts and styles for Stats Counter widget
        wp_enqueue_script('promen-stats-counter-widget');
        wp_enqueue_script('promen-stats-counter-accessibility');
        wp_enqueue_style('promen-stats-counter-widget');
        wp_enqueue_style('promen-stats-counter-accessibility');
    }

    /**
     * Register Team Members Carousel scripts
     */
    public function register_team_members_carousel_scripts() {
        // Register and enqueue the team members carousel script
        wp_register_script(
            'promen-team-members-carousel-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/team-members-carousel/assets/js/team-members-carousel.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Enqueue the script
        wp_enqueue_script('promen-team-members-carousel-widget');
    }
    
    /**
     * Register Services Carousel scripts
     */
    public function register_services_carousel_scripts() {
        // Register and enqueue the services carousel script
        wp_register_script(
            'promen-services-carousel-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-carousel/assets/js/services-carousel.js',
            ['jquery', 'swiper-bundle', 'gsap'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Register accessibility script
        wp_register_script(
            'promen-services-carousel-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-carousel/assets/js/services-carousel-accessibility.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Ensure Swiper is loaded
        wp_enqueue_script('swiper-bundle');
        wp_enqueue_script('gsap');
        
        // Enqueue the scripts
        wp_enqueue_script('promen-services-carousel-widget');
        wp_enqueue_script('promen-services-carousel-accessibility');
    }

    /**
     * Register Hero Slider scripts
     */
    public function register_hero_slider_scripts() {
        // Check if hero slider script exists
        $hero_slider_js_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/hero-slider/assets/js/hero-slider.js';
        $hero_slider_css_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/hero-slider/assets/css/hero-slider.css';
        
        if (!file_exists($hero_slider_js_path)) {
            error_log('Promen Elementor Widgets: Hero Slider JS file not found at ' . $hero_slider_js_path);
            return;
        }
        
        if (!file_exists($hero_slider_css_path)) {
            error_log('Promen Elementor Widgets: Hero Slider CSS file not found at ' . $hero_slider_css_path);
        }
        
        // Ensure Swiper is loaded first
        $this->enqueue_swiper();
        
        // Register Hero Slider script
        wp_register_script(
            'hero-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hero-slider/assets/js/hero-slider.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Add inline script to check if Swiper is available
        wp_add_inline_script('hero-slider', 'window.heroSliderSwiperAvailable = typeof Swiper !== "undefined";', 'before');
        
        // Register Hero Slider style
        wp_register_style(
            'hero-slider',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/hero-slider/assets/css/hero-slider.css',
            ['swiper-bundle-css'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Immediately enqueue the scripts
        wp_enqueue_script('hero-slider');
        wp_enqueue_style('hero-slider');
    }

    /**
     * Register News Posts Slider scripts
     */
    public function register_news_posts_slider_scripts() {
        // Register News Posts Slider script
        wp_register_script(
            'promen-news-slider-script',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/news-posts/includes/js/news-posts-slider.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Register News Posts Slider style
        wp_register_style(
            'promen-news-slider-style',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/news-posts/assets/css/news-posts-slider.css',
            ['swiper-bundle-css'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Ensure Swiper is loaded
        wp_enqueue_style('swiper-bundle-css');
        wp_enqueue_script('swiper-bundle');
    }

    /**
     * Register Services Grid Slider scripts
     */
    public function register_services_grid_slider_scripts() {
        // Register Services Grid Slider script
        wp_register_script(
            'services-grid-slider-script',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/includes/js/services-grid-slider.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Register Services Grid Slider style
        wp_register_style(
            'services-grid-slider-style',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/css/services-grid-slider.css',
            ['swiper-bundle-css'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Ensure Swiper is loaded
        wp_enqueue_style('swiper-bundle-css');
        wp_enqueue_script('swiper-bundle');
    }

    /**
     * Register Image Slider scripts
     */
    public function register_image_slider_scripts() {
        // Register Image Slider script
        wp_register_script(
            'promen-image-slider-script',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-slider/includes/js/image-slider.js',
            ['jquery', 'swiper-bundle'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Register Image Slider style
        wp_register_style(
            'promen-image-slider-style',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/image-slider/assets/css/image-slider.css',
            ['swiper-bundle-css'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        // Ensure Swiper is loaded
        wp_enqueue_style('swiper-bundle-css');
        wp_enqueue_script('swiper-bundle');
        
        // Always enqueue the image slider script and style
        wp_enqueue_script('promen-image-slider-script');
        wp_enqueue_style('promen-image-slider-style');
    }

    /**
     * Register GSAP and ScrollTrigger scripts
     */
    public function register_gsap_scripts() {
        // Register GSAP Core
        wp_register_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js',
            [],
            '3.12.2',
            true
        );
        
        // Register ScrollTrigger plugin
        wp_register_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js',
            ['gsap'],
            '3.12.2',
            true
        );
    }
    
    /**
     * Register Solicitation Timeline Widget scripts
     */
    public function register_solicitation_timeline_scripts() {
        wp_register_script(
            'promen-solicitation-timeline-widget',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/solicitation-timeline/assets/js/solicitation-timeline.js',
            ['jquery', 'gsap', 'gsap-scrolltrigger'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
    }

    /**
     * Register Lenis smooth scroll scripts
     */
    public function register_lenis_scripts() {
        // Get Lenis settings
        $settings = get_option('lenis_scroll_options', array(
            'enable_lenis' => true,
            'scroll_duration' => 1.2,
            'scroll_easing' => 'ease-out-expo',
            'mouse_multiplier' => 1,
            'touch_multiplier' => 2
        ));

        // Check if Lenis is enabled
        if (!$settings['enable_lenis']) {
            return;
        }

        // Register Lenis library
        wp_register_script(
            'lenis-js',
            'https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.19/bundled/lenis.min.js',
            [],
            '1.0.19',
            true
        );
        
        // Register our custom Lenis implementation
        wp_register_script(
            'promen-lenis-smooth-scroll',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/lenis-smooth-scroll.js',
            ['lenis-js', 'gsap', 'gsap-scrolltrigger'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        // Enqueue on the frontend
        if (!is_admin()) {
            wp_enqueue_script('lenis-js');
            wp_enqueue_script('promen-lenis-smooth-scroll');

            wp_localize_script('promen-lenis-smooth-scroll', 'lenisSettings', $settings);
        }
    }
} 