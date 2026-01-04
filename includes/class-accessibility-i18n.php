<?php
/**
 * Accessibility Internationalization Strings
 * 
 * Provides translated strings for JavaScript accessibility features.
 * Uses WordPress i18n functions for translation support.
 * 
 * @package Promen_Elementor_Widgets
 */

if (!defined('ABSPATH')) {
    exit;
}

class Promen_Accessibility_i18n {

    /**
     * Get all translatable accessibility strings
     * 
     * @return array
     */
    public static function get_strings() {
        return [
            // General
            'reducedMotionEnabled' => __('Animations disabled for reduced motion preference', 'promen-elementor-widgets'),
            'loading' => __('Loading', 'promen-elementor-widgets'),
            
            // Carousel/Slider
            'slideOf' => __('Slide %1$s of %2$s', 'promen-elementor-widgets'),
            'previousSlide' => __('Previous slide', 'promen-elementor-widgets'),
            'nextSlide' => __('Next slide', 'promen-elementor-widgets'),
            'carouselLabel' => __('Carousel', 'promen-elementor-widgets'),
            'slideLabel' => __('slide', 'promen-elementor-widgets'),
            
            // Team Members Carousel
            'teamMembersCarouselLabel' => __('Team Members Carousel', 'promen-elementor-widgets'),
            'previousTeamMember' => __('Previous team member', 'promen-elementor-widgets'),
            'nextTeamMember' => __('Next team member', 'promen-elementor-widgets'),
            
            // Image Slider
            'imageSliderLabel' => __('Image Slider', 'promen-elementor-widgets'),
            'imageGalleryLabel' => __('Image Gallery', 'promen-elementor-widgets'),
            
            // Timeline
            'timelineLabel' => __('Timeline', 'promen-elementor-widgets'),
            'solicitationTimelineLabel' => __('Solicitation process timeline', 'promen-elementor-widgets'),
            'timelineWithSteps' => __('Timeline with %s steps', 'promen-elementor-widgets'),
            'stepOf' => __('Step %1$s of %2$s', 'promen-elementor-widgets'),
            'timelineAnimationsDisabled' => __('Timeline animations disabled for reduced motion preference', 'promen-elementor-widgets'),
            
            // Hero Slider
            'heroSliderLabel' => __('Hero Slider', 'promen-elementor-widgets'),
            'playSlideshow' => __('Play slideshow', 'promen-elementor-widgets'),
            'pauseSlideshow' => __('Pause slideshow', 'promen-elementor-widgets'),
            'stopSlideshow' => __('Stop slideshow', 'promen-elementor-widgets'),
            'slideshowPaused' => __('Slideshow paused', 'promen-elementor-widgets'),
            'slideshowPlaying' => __('Slideshow playing', 'promen-elementor-widgets'),
            'slideshowStopped' => __('Slideshow stopped', 'promen-elementor-widgets'),
            
            // Tabs
            'tabLabel' => __('Tab', 'promen-elementor-widgets'),
            'tabPanelLabel' => __('Tab panel', 'promen-elementor-widgets'),
            'switchedToTab' => __('Switched to %s tab', 'promen-elementor-widgets'),
            
            // Navigation & Skip Links
            'skipToContent' => __('Skip to content', 'promen-elementor-widgets'),
            'skipToMainContent' => __('Skip to main content', 'promen-elementor-widgets'),
            'skipToNavigation' => __('Skip to navigation', 'promen-elementor-widgets'),
            'skipImageTextBlock' => __('Skip image text block', 'promen-elementor-widgets'),
            'skipToSection' => __('Skip this section', 'promen-elementor-widgets'),
            'skipTextBlock' => __('Skip text block', 'promen-elementor-widgets'),
            'skipLocations' => __('Skip locations', 'promen-elementor-widgets'),
            'skipTextColumns' => __('Skip text columns', 'promen-elementor-widgets'),
            'skipRelatedServices' => __('Skip related services', 'promen-elementor-widgets'),
            'skipTeamCarousel' => __('Skip team carousel', 'promen-elementor-widgets'),
            'skipStats' => __('Skip statistics', 'promen-elementor-widgets'),
            'skipTestimonial' => __('Skip testimonial', 'promen-elementor-widgets'),
            'skipWorkerTestimonial' => __('Skip worker testimonial', 'promen-elementor-widgets'),
            'skipTimeline' => __('Skip timeline', 'promen-elementor-widgets'),
            'skipCarousel' => __('Skip carousel', 'promen-elementor-widgets'),
            'skipSlider' => __('Skip slider', 'promen-elementor-widgets'),
            'skipGallery' => __('Skip gallery', 'promen-elementor-widgets'),
            'skipToForm' => __('Skip to form', 'promen-elementor-widgets'),
            'backToTop' => __('Back to top', 'promen-elementor-widgets'),
            'goToSlide' => __('Go to slide %s', 'promen-elementor-widgets'),
            'sliderPagination' => __('Slider pagination', 'promen-elementor-widgets'),
            'readMoreAbout' => __('Read more about %s', 'promen-elementor-widgets'),
            'viewDetails' => __('View details', 'promen-elementor-widgets'),
            'iconFor' => __('Icon for %s', 'promen-elementor-widgets'),
            'documentsFromYear' => __('Documents from year %s', 'promen-elementor-widgets'),
            
            // Stats Counter
            'statisticsLoading' => __('Statistics are loading', 'promen-elementor-widgets'),
            'statisticsComplete' => __('Statistics loaded', 'promen-elementor-widgets'),
            
            // Services
            'servicesCarouselLabel' => __('Services Carousel', 'promen-elementor-widgets'),
            'servicesGridLabel' => __('Services Grid', 'promen-elementor-widgets'),
            'servicesAvailable' => __('%s services available', 'promen-elementor-widgets'),
            'serviceNowShowing' => __('Now showing service: %s', 'promen-elementor-widgets'),
            'previousService' => __('Previous service', 'promen-elementor-widgets'),
            'nextService' => __('Next service', 'promen-elementor-widgets'),
            
            // News
            'newsCarouselLabel' => __('News Carousel', 'promen-elementor-widgets'),
            'newsSliderLabel' => __('News Slider', 'promen-elementor-widgets'),
            
            // Forms
            'requiredField' => __('Required field', 'promen-elementor-widgets'),
            'invalidEmail' => __('Please enter a valid email address', 'promen-elementor-widgets'),
            'invalidPhone' => __('Please enter a valid phone number', 'promen-elementor-widgets'),
            'formError' => __('Please correct the errors in the form', 'promen-elementor-widgets'),
            'formSuccess' => __('Form submitted successfully', 'promen-elementor-widgets'),
            
            // Text-to-Speech
            'ttsPlay' => __('Read aloud', 'promen-elementor-widgets'),
            'ttsPause' => __('Pause reading', 'promen-elementor-widgets'),
            'ttsResume' => __('Resume reading', 'promen-elementor-widgets'),
            'ttsStop' => __('Stop reading', 'promen-elementor-widgets'),
            'ttsPaused' => __('Reading paused', 'promen-elementor-widgets'),
            'ttsResumed' => __('Reading resumed', 'promen-elementor-widgets'),
            'ttsStopped' => __('Reading stopped', 'promen-elementor-widgets'),
            
            // Collapsible/Accordion
            'expandSection' => __('Expand section', 'promen-elementor-widgets'),
            'collapseSection' => __('Collapse section', 'promen-elementor-widgets'),
            'sectionExpanded' => __('Section expanded', 'promen-elementor-widgets'),
            'sectionCollapsed' => __('Section collapsed', 'promen-elementor-widgets'),
            
            // Menu
            'menuLabel' => __('Menu', 'promen-elementor-widgets'),
            'openMenu' => __('Open menu', 'promen-elementor-widgets'),
            'closeMenu' => __('Close menu', 'promen-elementor-widgets'),
            'menuOpened' => __('Menu opened', 'promen-elementor-widgets'),
            'menuClosed' => __('Menu closed', 'promen-elementor-widgets'),
            
            // Testimonials
            'testimonialCarouselLabel' => __('Testimonials Carousel', 'promen-elementor-widgets'),
            'testimonialLabel' => __('Testimonial', 'promen-elementor-widgets'),
            
            // Documents
            'documentListLabel' => __('Document list', 'promen-elementor-widgets'),
            'downloadDocument' => __('Download document', 'promen-elementor-widgets'),
            
            // Locations
            'locationsLabel' => __('Locations', 'promen-elementor-widgets'),
            'locationDetails' => __('Location details', 'promen-elementor-widgets'),
            
            // Contact
            'contactFormLabel' => __('Contact form', 'promen-elementor-widgets'),
            'contactInfoLabel' => __('Contact information', 'promen-elementor-widgets'),
        ];
    }

    /**
     * Get strings formatted for JavaScript (with sprintf placeholders converted)
     * 
     * @return array
     */
    public static function get_js_strings() {
        $strings = self::get_strings();
        
        // Convert PHP sprintf placeholders to JavaScript format
        foreach ($strings as $key => $value) {
            // Convert %1$s, %2$s etc. to {0}, {1} for JS
            $strings[$key] = preg_replace_callback(
                '/%(\d+)\$s/',
                function($matches) {
                    return '{' . ($matches[1] - 1) . '}';
                },
                $value
            );
            // Convert simple %s to {n}
            $counter = 0;
            $strings[$key] = preg_replace_callback(
                '/%s/',
                function() use (&$counter) {
                    return '{' . ($counter++) . '}';
                },
                $strings[$key]
            );
        }
        
        return $strings;
    }
}
