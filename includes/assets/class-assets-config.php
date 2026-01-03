<?php
/**
 * Assets Configuration Class
 * 
 * Centralizes definitions for all widget scripts and styles.
 * 
 * @package Elementor
 */

if (!defined('ABSPATH')) {
    exit;
}

class Promen_Assets_Config {

    /**
     * Get all widget style configurations
     * 
     * @return array
     */
    public static function get_widget_styles() {
        return [
            'promen-feature-blocks-widget' => [
                'path' => 'widgets/feature-blocks/assets/css/feature-blocks.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-services-carousel-widget' => [
                'path' => 'widgets/services-carousel/assets/css/services-carousel.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-services-grid-widget' => [
                'path' => 'widgets/services-grid/assets/css/services-grid.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-services-grid-accessibility' => [
                'path' => 'widgets/services-grid/assets/css/services-grid-accessibility.css',
                'deps' => ['promen-services-grid-widget'],
            ],
            'services-grid-slider-style' => [
                'path' => 'widgets/services-grid/assets/css/services-grid-slider.css',
                'deps' => ['promen-services-grid-widget'],
            ],
            'promen-image-text-block-widget' => [
                'path' => 'widgets/image-text-block/assets/css/image-text-block.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-image-text-block-accessibility' => [
                'path' => 'widgets/image-text-block/assets/css/image-text-block-accessibility.css',
                'deps' => ['promen-image-text-block-widget'],
            ],
            'promen-content-posts-style' => [
                'path' => 'widgets/news-posts/assets/css/news-posts.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-news-slider-style' => [
                'path' => 'widgets/news-posts/assets/css/news-posts-slider.css',
                'deps' => ['promen-content-posts-style'],
            ],
            'promen-stats-counter-widget' => [
                'path' => 'widgets/stats-counter/assets/css/stats-counter.css',
            ],
            'promen-stats-counter-accessibility' => [
                'path' => 'widgets/stats-counter/assets/css/stats-counter-accessibility.css',
                'enqueue' => true,
            ],
            'contact-info-card' => [
                'path' => 'widgets/contact-info-card/assets/css/contact-info-card.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'contact-info-card-accessibility' => [
                'path' => 'widgets/contact-info-card/assets/css/contact-info-card-accessibility.css',
            ],
            'promen-team-members-carousel-widget' => [
                'path' => 'widgets/team-members-carousel/assets/css/team-members-carousel.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-certification-logos' => [
                'path' => 'widgets/certification-logos/assets/css/certification-logos.css',
                'enqueue' => true,
            ],
            'promen-worker-testimonial-widget' => [
                'path' => 'widgets/worker-testimonial/assets/css/worker-testimonial.css',
                'deps' => ['promen-elementor-widgets'],
                'enqueue' => true,
            ],
            'promen-benefits-widget-widget' => [
                'path' => 'widgets/benefits-widget/assets/css/benefits-widget.css',
                'enqueue' => true,
            ],
            'hero-slider' => [
                'path' => 'widgets/hero-slider/assets/css/hero-slider.css',
                'deps' => ['swiper-bundle-css'],
                'enqueue' => true,
            ],
            'promen-text-content-block' => [
                'path' => 'widgets/text-content-block/assets/css/text-content-block.css',
            ],
            'promen-image-slider-widget' => [
                'path' => 'widgets/image-slider/assets/css/image-slider.css',
                'deps' => ['swiper-bundle-css'],
                'enqueue' => true,
            ],
            'promen-related-services-widget' => [
                'path' => 'widgets/related-services/assets/css/related-services.css',
            ],
            'promen-text-column-repeater-widget' => [
                'path' => 'widgets/text-column-repeater/assets/css/text-column-repeater.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-solicitation-timeline-widget' => [
                'path' => 'widgets/solicitation-timeline/assets/css/solicitation-timeline.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-business-catering-widget' => [
                'path' => 'widgets/business-catering/assets/css/business-catering.css',
            ],
            'promen-testimonial-card-widget' => [
                'path' => 'widgets/testimonial-card/assets/css/testimonial-card.css',
            ],
            'image-text-slider' => [
                'path' => 'widgets/image-text-slider/assets/css/style.css',
                'deps' => ['swiper-bundle-css'],
                'ver' => '1.0.1',
            ],
            'image-text-slider-accessibility' => [
                'path' => 'widgets/image-text-slider/assets/css/modules/accessibility-minimal.css',
                'deps' => ['image-text-slider'],
                'ver' => '1.0.0-wcag-2.2-minimal',
            ],
            'image-text-slider-mobile' => [
                'path' => 'widgets/image-text-slider/assets/css/modules/mobile-optimizations.css',
                'deps' => ['image-text-slider'],
            ],
            'promen-checklist-comparison-widget' => [
                'path' => 'widgets/checklist-comparison/assets/css/checklist-comparison.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-contact-info-blocks-widget' => [
                'path' => 'widgets/contact-info-blocks/assets/css/contact-info-blocks.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-locations-display-widget' => [
                'path' => 'widgets/locations-display/assets/css/locations-display.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-document-info-list-widget' => [
                'path' => 'widgets/document-info-list/assets/css/document-info-list.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-hamburger-menu-widget' => [
                'path' => 'widgets/hamburger-menu/assets/css/hamburger-menu.css',
                'enqueue' => true,
            ],
        ];
    }

    /**
     * Get all widget script configurations
     * 
     * @return array
     */
    public static function get_widget_scripts() {
        return [
            'feature-blocks-accessibility' => [
                'path' => 'widgets/feature-blocks/assets/js/feature-blocks-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-services-carousel-widget' => [
                'path' => 'widgets/services-carousel/assets/js/services-carousel.js',
                'deps' => ['jquery', 'swiper-bundle', 'gsap'],
            ],
            'promen-services-carousel-accessibility' => [
                'path' => 'widgets/services-carousel/assets/js/services-carousel-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'services-grid-slider-script' => [
                'path' => 'widgets/services-grid/assets/js/services-grid.js',
                'deps' => ['jquery', 'swiper-bundle'],
            ],
            'promen-services-grid-accessibility' => [
                'path' => 'widgets/services-grid/assets/js/services-grid-accessibility.js',
                'deps' => ['jquery', 'services-grid-slider-script', 'promen-accessibility'],
            ],
            'promen-image-text-block-widget' => [
                'path' => 'widgets/image-text-block/assets/js/image-text-block.js',
                'deps' => ['jquery'],
            ],
            'promen-image-text-block-accessibility' => [
                'path' => 'widgets/image-text-block/assets/js/image-text-block-accessibility.js',
                'deps' => ['jquery', 'promen-image-text-block-widget', 'promen-accessibility'],
            ],
            'promen-news-slider-script' => [
                'path' => 'widgets/news-posts/assets/js/news-posts-slider.js',
                'deps' => ['jquery', 'swiper-bundle'],
            ],
            'promen-stats-counter-widget' => [
                'path' => 'widgets/stats-counter/assets/js/stats-counter.js',
                'deps' => ['jquery'],
            ],
            'promen-stats-counter-accessibility' => [
                'path' => 'widgets/stats-counter/assets/js/stats-counter-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-team-members-carousel-widget' => [
                'path' => 'widgets/team-members-carousel/assets/js/team-members-carousel.js',
                'deps' => ['jquery', 'swiper-bundle', 'promen-accessibility'],
            ],
            'promen-team-members-carousel-accessibility' => [
                'path' => 'widgets/team-members-carousel/assets/js/team-members-carousel-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-worker-testimonial-accessibility' => [
                'path' => 'widgets/worker-testimonial/assets/js/worker-testimonial-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
                'ver' => PROMEN_ELEMENTOR_WIDGETS_VERSION . '.' . time(), // Special case
            ],
            'hero-slider' => [
                'path' => 'widgets/hero-slider/assets/js/hero-slider.js',
                'deps' => ['jquery', 'swiper-bundle'],
            ],
            'promen-hero-slider-accessibility' => [
                'path' => 'widgets/hero-slider/assets/js/hero-slider-accessibility.js',
                'deps' => ['jquery', 'hero-slider', 'promen-accessibility'],
            ],
            'promen-text-content-block-widget' => [
                'path' => 'widgets/text-content-block/assets/js/text-content-block.js',
                'deps' => ['jquery'],
            ],
            'promen-image-slider-widget' => [
                'path' => 'widgets/image-slider/assets/js/image-slider.js',
                'deps' => ['jquery', 'swiper-bundle', 'promen-accessibility'],
            ],
            'promen-solicitation-timeline-widget' => [
                'path' => 'widgets/solicitation-timeline/assets/js/solicitation-timeline.js',
                'deps' => ['jquery', 'gsap', 'gsap-scrolltrigger', 'promen-accessibility'],
            ],
            'promen-news-posts-accessibility' => [
                'path' => 'widgets/news-posts/assets/js/news-posts-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-image-text-slider-init' => [
                'path' => 'widgets/image-text-slider/assets/js/modules/init-slider.js',
                'deps' => ['jquery', 'swiper-bundle', 'gsap'],
            ],
            'image-text-slider' => [
                'path' => 'widgets/image-text-slider/assets/js/script.js',
                'deps' => ['jquery', 'swiper-bundle', 'gsap', 'promen-image-text-slider-init', 'promen-accessibility'],
                'ver' => '1.0.2-mobile-optimized',
            ],
            'promen-checklist-comparison-widget' => [
                'path' => 'widgets/checklist-comparison/assets/js/checklist-comparison.js',
                'deps' => ['jquery'],
            ],
            'promen-hamburger-menu-widget' => [
                'path' => 'widgets/hamburger-menu/assets/js/hamburger-menu.js',
                'deps' => ['jquery', 'gsap', 'promen-accessibility'],
            ],
            'promen-business-catering-slider' => [
                'path' => 'widgets/business-catering/assets/js/business-catering-slider.js',
                'deps' => ['jquery', 'swiper-bundle'],
            ],
            'promen-business-catering-accessibility' => [
                'path' => 'widgets/business-catering/assets/js/business-catering-accessibility.js',
                'deps' => ['jquery', 'promen-business-catering-slider', 'promen-accessibility'],
            ],
            'promen-locations-display-accessibility' => [
                'path' => 'widgets/locations-display/assets/js/locations-display-accessibility.js',
                'deps' => ['jquery', 'gsap', 'gsap-scrolltrigger', 'promen-accessibility'],
            ],
            'promen-contact-info-blocks-accessibility' => [
                'path' => 'widgets/contact-info-blocks/assets/js/contact-info-blocks-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'contact-info-card-accessibility' => [
                'path' => 'widgets/contact-info-card/assets/js/contact-info-card-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'document-info-list-script' => [
                'path' => 'widgets/document-info-list/assets/js/document-info-list.js',
                'deps' => ['jquery', 'gsap'],
            ],
            'promen-document-info-list-accessibility' => [
                'path' => 'widgets/document-info-list/assets/js/document-info-list-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-related-services-accessibility' => [
                'path' => 'widgets/related-services/assets/js/related-services-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-testimonial-card-script' => [
                'path' => 'widgets/testimonial-card/assets/js/testimonial-card.js',
                'deps' => ['jquery'],
            ],
            'promen-testimonial-card-accessibility' => [
                'path' => 'widgets/testimonial-card/assets/js/testimonial-card-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-text-column-repeater-widget' => [
                'path' => 'widgets/text-column-repeater/assets/js/text-column-repeater.js',
                'deps' => ['jquery'],
            ],
            'promen-text-column-repeater-accessibility' => [
                'path' => 'widgets/text-column-repeater/assets/js/text-column-repeater-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-benefits-accessibility' => [
                'path' => 'widgets/benefits-widget/assets/js/benefits-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
        ];
    }
}
