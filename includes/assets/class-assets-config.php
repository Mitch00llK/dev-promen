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
            'promen-feature-blocks' => [
                'path' => 'widgets/feature-blocks/assets/css/feature-blocks.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-services-carousel-base' => [
                'path' => 'widgets/services-carousel/assets/css/base/variables.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-services-carousel-layout' => [
                'path' => 'widgets/services-carousel/assets/css/layout/container.css',
                'deps' => ['promen-services-carousel-base'],
            ],
            'promen-services-carousel-component-header' => [
                'path' => 'widgets/services-carousel/assets/css/components/header.css',
                'deps' => ['promen-services-carousel-layout'],
            ],
            'promen-services-carousel-component-card' => [
                'path' => 'widgets/services-carousel/assets/css/components/card.css',
                'deps' => ['promen-services-carousel-layout'],
            ],
            'promen-services-carousel-component-carousel' => [
                'path' => 'widgets/services-carousel/assets/css/components/carousel.css',
                'deps' => ['promen-services-carousel-layout'],
            ],
            'promen-services-carousel-component-navigation' => [
                'path' => 'widgets/services-carousel/assets/css/components/navigation.css',
                'deps' => ['promen-services-carousel-layout'],
            ],
            'promen-services-carousel-responsive-tablet' => [
                'path' => 'widgets/services-carousel/assets/css/responsive/tablet.css',
                'deps' => ['promen-services-carousel-layout'],
            ],
            'promen-services-carousel-responsive-mobile' => [
                'path' => 'widgets/services-carousel/assets/css/responsive/mobile.css',
                'deps' => ['promen-services-carousel-layout'],
            ],
            'promen-benefits-base' => [
                'path' => 'widgets/benefits-widget/assets/css/base/variables.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-benefits-typography' => [
                'path' => 'widgets/benefits-widget/assets/css/base/typography.css',
                'deps' => ['promen-benefits-base'],
            ],
            'promen-benefits-layout' => [
                'path' => 'widgets/benefits-widget/assets/css/layout/container.css',
                'deps' => ['promen-benefits-base'],
            ],
            'promen-benefits-component-benefit-item' => [
                'path' => 'widgets/benefits-widget/assets/css/components/benefit-item.css',
                'deps' => ['promen-benefits-layout'],
            ],
            'promen-benefits-component-media' => [
                'path' => 'widgets/benefits-widget/assets/css/components/media.css',
                'deps' => ['promen-benefits-layout'],
            ],
            'promen-benefits-component-animations' => [
                'path' => 'widgets/benefits-widget/assets/css/components/animations.css',
                'deps' => ['promen-benefits-layout'],
            ],
            'promen-benefits-responsive-tablet' => [
                'path' => 'widgets/benefits-widget/assets/css/responsive/tablet.css',
                'deps' => ['promen-benefits-layout'],
            ],
            'promen-benefits-responsive-mobile' => [
                'path' => 'widgets/benefits-widget/assets/css/responsive/mobile.css',
                'deps' => ['promen-benefits-layout'],
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
            'promen-image-text-block-base' => [
                'path' => 'widgets/image-text-block/assets/css/base/variables.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-image-text-block-typography' => [
                'path' => 'widgets/image-text-block/assets/css/base/typography.css',
                'deps' => ['promen-image-text-block-base'],
            ],
            'promen-image-text-block-layout' => [
                'path' => 'widgets/image-text-block/assets/css/layout/container.css',
                'deps' => ['promen-image-text-block-base'],
            ],
            'promen-image-text-block-components' => [
                'path' => 'widgets/image-text-block/assets/css/components/image.css', // Loading image.css as representative, others can be enqueued or deps
                // Actually, we need to register all of them if we want to be clean, or just one "components" handle if we concatenated (which we didn't).
                // Let's register them individually.
            ],
            'promen-image-text-block-component-image' => [
                 'path' => 'widgets/image-text-block/assets/css/components/image.css',
                 'deps' => ['promen-image-text-block-layout'],
            ],
            'promen-image-text-block-component-content' => [
                 'path' => 'widgets/image-text-block/assets/css/components/content.css',
                 'deps' => ['promen-image-text-block-layout'],
            ],
            'promen-image-text-block-component-buttons' => [
                 'path' => 'widgets/image-text-block/assets/css/components/buttons.css',
                 'deps' => ['promen-image-text-block-layout'],
            ],
            'promen-image-text-block-component-tabs' => [
                 'path' => 'widgets/image-text-block/assets/css/components/tabs.css',
                 'deps' => ['promen-image-text-block-layout'],
            ],
            'promen-image-text-block-responsive-tablet' => [
                 'path' => 'widgets/image-text-block/assets/css/responsive/tablet.css',
                 'deps' => ['promen-image-text-block-layout'],
            ],
             'promen-image-text-block-responsive-mobile' => [
                 'path' => 'widgets/image-text-block/assets/css/responsive/mobile.css',
                 'deps' => ['promen-image-text-block-layout'],
            ],
            // Main handle to enqueue them all easily
            'promen-image-text-block-widget' => [
                 // We can make this a "dummy" handle with deps if the system supports it, or just return an array of handles in the widget.
                 // For now, let's keep this key but maybe point it to one file or just remove it and use the list in the widget.
                 // The user plan said "Remove the single promen-image-text-block-widget entry".
                 // So I will remove it.
            ],
            'promen-image-text-block-accessibility' => [
                'path' => 'widgets/image-text-block/assets/css/image-text-block-accessibility.css',
                'deps' => ['promen-image-text-block-widget'],
            ],
            'promen-news-posts-widget' => [
                'path' => 'widgets/news-posts/assets/css/news-posts.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-news-posts-slider' => [
                'path' => 'widgets/news-posts/assets/css/news-posts-slider.css',
                'deps' => ['promen-news-posts-widget'],
            ],
            'promen-stats-counter-widget' => [
                'path' => 'widgets/stats-counter/assets/css/stats-counter.css',
            ],
            'promen-stats-counter-accessibility' => [
                'path' => 'widgets/stats-counter/assets/css/stats-counter-accessibility.css',
                'enqueue' => true,
            ],
            'promen-contact-info-card' => [
                'path' => 'widgets/contact-info-card/assets/css/contact-info-card.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-contact-info-card-accessibility' => [
                'path' => 'widgets/contact-info-card/assets/css/contact-info-card-accessibility.css',
            ],
            'promen-team-members-carousel-widget' => [
                'path' => 'widgets/team-members-carousel/assets/css/team-members-carousel.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-certification-logos-base' => [
                'path' => 'widgets/certification-logos/assets/css/base/variables.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-certification-logos-typography' => [
                'path' => 'widgets/certification-logos/assets/css/base/typography.css',
                'deps' => ['promen-certification-logos-base'],
            ],
            'promen-certification-logos-layout-grid' => [
                'path' => 'widgets/certification-logos/assets/css/layout/grid.css',
                'deps' => ['promen-certification-logos-base'],
            ],
            'promen-certification-logos-component-logo' => [
                'path' => 'widgets/certification-logos/assets/css/components/logo.css',
                'deps' => ['promen-certification-logos-layout-grid'],
            ],
            'promen-certification-logos-component-slider' => [
                'path' => 'widgets/certification-logos/assets/css/components/slider.css',
                'deps' => ['promen-certification-logos-layout-grid'],
            ],
            'promen-certification-logos-responsive-tablet' => [
                'path' => 'widgets/certification-logos/assets/css/responsive/tablet.css',
                'deps' => ['promen-certification-logos-layout-grid'],
            ],
            'promen-certification-logos-responsive-mobile' => [
                'path' => 'widgets/certification-logos/assets/css/responsive/mobile.css',
                'deps' => ['promen-certification-logos-layout-grid'],
            ],
            'promen-certification-logos-style' => [
                // Refactored
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
            'promen-image-slider' => [
                'path' => 'widgets/image-slider/assets/css/image-slider.css',
                'deps' => ['swiper-bundle-css'],
                'enqueue' => true,
            ],
            'promen-related-services-base' => [
                'path' => 'widgets/related-services/assets/css/base/variables.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-related-services-layout' => [
                'path' => 'widgets/related-services/assets/css/layout/container.css',
                'deps' => ['promen-related-services-base'],
            ],
            'promen-related-services-component-header' => [
                'path' => 'widgets/related-services/assets/css/components/header.css',
                'deps' => ['promen-related-services-layout'],
            ],
            'promen-related-services-component-card' => [
                'path' => 'widgets/related-services/assets/css/components/card.css',
                'deps' => ['promen-related-services-layout'],
            ],
            'promen-related-services-responsive-tablet' => [
                'path' => 'widgets/related-services/assets/css/responsive/tablet.css',
                'deps' => ['promen-related-services-layout'],
            ],
            'promen-related-services-responsive-mobile' => [
                'path' => 'widgets/related-services/assets/css/responsive/mobile.css',
                'deps' => ['promen-related-services-layout'],
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
                'deps' => ['swiper-bundle-css', 'image-text-slider-layout', 'image-text-slider-content', 'image-text-slider-controls'],
                'ver' => '1.0.2',
            ],
            'image-text-slider-layout' => [
                'path' => 'widgets/image-text-slider/assets/css/layout.css',
                'deps' => ['swiper-bundle-css'],
                'ver' => '1.0.2',
            ],
            'image-text-slider-content' => [
                'path' => 'widgets/image-text-slider/assets/css/content.css',
                'deps' => ['image-text-slider-layout'],
                'ver' => '1.0.2',
            ],
            'image-text-slider-controls' => [
                'path' => 'widgets/image-text-slider/assets/css/controls.css',
                'deps' => ['image-text-slider-layout'],
                'ver' => '1.0.2',
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
            'image-text-slider-responsive' => [
                'path' => 'widgets/image-text-slider/assets/css/responsive.css',
                'deps' => ['image-text-slider'],
                'ver' => '1.0.2',
            ],
            'promen-checklist-comparison-widget' => [
                'path' => 'widgets/checklist-comparison/assets/css/checklist-comparison.css',
                'deps' => ['promen-elementor-widgets'],
            ],
            'promen-contact-info-blocks-widget' => [
                'path' => 'widgets/contact-info-blocks/assets/css/contact-info-blocks.css',
                'deps' => ['promen-elementor-widgets'],
                'enqueue' => true,
            ],
            'promen-locations-display-widget' => [
                'path' => 'widgets/locations-display/assets/css/locations-display.css',
                'deps' => ['promen-elementor-widgets'],
                'enqueue' => true,
            ],
            'promen-document-info-list' => [
                'path' => 'widgets/document-info-list/assets/css/document-info-list.css',
                'deps' => ['promen-elementor-widgets'],
                'enqueue' => true,
            ],
            'promen-accessibility-target-sizes' => [
                'path' => 'assets/css/accessibility-target-sizes.css',
                'enqueue' => true,
            ],
            'promen-accessibility-focus' => [
                'path' => 'assets/css/accessibility-focus.css',
                'enqueue' => true,
            ],
            // ...
            'promen-document-info-list-script' => [
                'path' => 'widgets/document-info-list/assets/js/document-info-list.js',
                'deps' => ['jquery', 'gsap'],
            ],
            'promen-document-info-list-accessibility' => [
                'path' => 'widgets/document-info-list/assets/js/document-info-list-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
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
            'promen-solicitation-timeline-accessibility' => [
                'path' => 'widgets/solicitation-timeline/assets/js/solicitation-timeline-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-news-posts-accessibility' => [
                'path' => 'widgets/news-posts/assets/js/news-posts-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],

            'promen-checklist-comparison-widget' => [
                'path' => 'widgets/checklist-comparison/assets/js/checklist-comparison.js',
                'deps' => ['jquery'],
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
            'promen-contact-info-blocks-handler' => [
                'path' => 'widgets/contact-info-blocks/assets/js/modules/accessibility-handler.js',
                'deps' => ['promen-accessibility'],
            ],
            'promen-contact-info-blocks-accessibility' => [
                'path' => 'widgets/contact-info-blocks/assets/js/contact-info-blocks-accessibility.js',
                'deps' => ['jquery', 'promen-contact-info-blocks-handler'],
            ],
            'promen-contact-info-card-handler' => [
                'path' => 'widgets/contact-info-card/assets/js/modules/accessibility-handler.js',
                'deps' => ['promen-accessibility'],
            ],
            'promen-contact-info-card-accessibility' => [
                'path' => 'widgets/contact-info-card/assets/js/contact-info-card-accessibility.js',
                'deps' => ['jquery', 'promen-contact-info-card-handler'],
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
            'promen-text-column-repeater-accessibility' => [
                'path' => 'widgets/text-column-repeater/assets/js/text-column-repeater-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-benefits-accessibility' => [
                'path' => 'widgets/benefits-widget/assets/js/benefits-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            // Image Text Slider scripts
            'promen-accessibility-utils' => [
                'path' => 'widgets/image-text-slider/assets/js/accessibility.js',
                'deps' => [],
            ],
            'promen-slider-utils' => [
                'path' => 'widgets/image-text-slider/assets/js/utils.js',
                'deps' => [],
            ],
            'promen-image-text-slider-config' => [
                'path' => 'widgets/image-text-slider/assets/js/modules/slider-config.js',
                'deps' => ['promen-slider-utils'],
            ],
            'promen-image-text-slider-spacer' => [
                'path' => 'widgets/image-text-slider/assets/js/modules/slider-spacer.js',
                'deps' => ['promen-slider-utils'],
            ],
            'promen-image-text-slider-content' => [
                'path' => 'widgets/image-text-slider/assets/js/modules/slider-content.js',
                'deps' => ['promen-slider-utils', 'promen-accessibility-utils'],
            ],
            'promen-image-text-slider-editor' => [
                'path' => 'widgets/image-text-slider/assets/js/modules/slider-editor.js',
                'deps' => ['promen-slider-utils', 'promen-accessibility-utils'],
            ],
            'promen-image-text-slider-core' => [
                'path' => 'widgets/image-text-slider/assets/js/modules/slider-main.js',
                'deps' => [
                    'jquery',
                    'swiper-bundle',
                    'promen-slider-utils',
                    'promen-accessibility-utils',
                    'promen-image-text-slider-config',
                    'promen-image-text-slider-spacer',
                    'promen-image-text-slider-content',
                    'promen-image-text-slider-editor'
                ],
            ],
            'promen-certification-logos-module' => [
                'path' => 'widgets/certification-logos/assets/js/module-certification-logos.js',
                'deps' => ['jquery', 'swiper-bundle'],
            ],
            'promen-certification-logos-accessibility' => [
                'path' => 'widgets/certification-logos/assets/js/certification-logos-accessibility.js',
                'deps' => ['jquery', 'promen-accessibility'],
            ],
            'promen-certification-logos-script' => [
                // Refactored
            ],
            'promen-image-text-slider-init' => [
                'path' => 'widgets/image-text-slider/assets/js/init-slider.js',
                'deps' => ['promen-image-text-slider-core'],
            ],
        ];
    }
}
