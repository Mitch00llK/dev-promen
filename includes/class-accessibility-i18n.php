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
            'reducedMotionEnabled' => __('Animaties uitgeschakeld vanwege voorkeur voor verminderde beweging', 'promen-elementor-widgets'),
            'loading' => __('Laden', 'promen-elementor-widgets'),
            
            // Carousel/Slider
            'slideOf' => __('Dia %1$s van %2$s', 'promen-elementor-widgets'),
            'previousSlide' => __('Vorige dia', 'promen-elementor-widgets'),
            'nextSlide' => __('Volgende dia', 'promen-elementor-widgets'),
            'carouselLabel' => __('Carrousel', 'promen-elementor-widgets'),
            'slideLabel' => __('dia', 'promen-elementor-widgets'),
            
            // Team Members Carousel
            'teamMembersCarouselLabel' => __('Teamleden carrousel', 'promen-elementor-widgets'),
            'previousTeamMember' => __('Vorig teamlid', 'promen-elementor-widgets'),
            'nextTeamMember' => __('Volgend teamlid', 'promen-elementor-widgets'),
            
            // Image Slider
            'imageSliderLabel' => __('Afbeeldingen slider', 'promen-elementor-widgets'),
            'imageGalleryLabel' => __('Afbeeldingen galerij', 'promen-elementor-widgets'),
            
            // Timeline
            'timelineLabel' => __('Tijdlijn', 'promen-elementor-widgets'),
            'solicitationTimelineLabel' => __('Sollicitatieproces tijdlijn', 'promen-elementor-widgets'),
            'timelineWithSteps' => __('Tijdlijn met %s stappen', 'promen-elementor-widgets'),
            'stepOf' => __('Stap %1$s van %2$s', 'promen-elementor-widgets'),
            'timelineAnimationsDisabled' => __('Tijdlijn animaties uitgeschakeld vanwege voorkeur voor verminderde beweging', 'promen-elementor-widgets'),
            
            // Hero Slider
            'heroSliderLabel' => __('Hero slider', 'promen-elementor-widgets'),
            'playSlideshow' => __('Diavoorstelling afspelen', 'promen-elementor-widgets'),
            'pauseSlideshow' => __('Diavoorstelling pauzeren', 'promen-elementor-widgets'),
            'stopSlideshow' => __('Diavoorstelling stoppen', 'promen-elementor-widgets'),
            'slideshowPaused' => __('Diavoorstelling gepauzeerd', 'promen-elementor-widgets'),
            'slideshowPlaying' => __('Diavoorstelling speelt af', 'promen-elementor-widgets'),
            'slideshowStopped' => __('Diavoorstelling gestopt', 'promen-elementor-widgets'),
            'autoplayStopped' => __('Automatisch afspelen gestopt', 'promen-elementor-widgets'),
            
            // Tabs
            'tabLabel' => __('Tabblad', 'promen-elementor-widgets'),
            'tabPanelLabel' => __('Tabblad paneel', 'promen-elementor-widgets'),
            'switchedToTab' => __('Overgeschakeld naar tabblad %s', 'promen-elementor-widgets'),
            
            // Navigation & Skip Links
            'skipToContent' => __('Ga naar inhoud', 'promen-elementor-widgets'),
            'skipToMainContent' => __('Ga naar hoofdinhoud', 'promen-elementor-widgets'),
            'skipToNavigation' => __('Ga naar navigatie', 'promen-elementor-widgets'),
            'skipImageTextBlock' => __('Sla afbeelding tekst blok over', 'promen-elementor-widgets'),
            'skipToSection' => __('Sla deze sectie over', 'promen-elementor-widgets'),
            'skipTextBlock' => __('Sla tekst blok over', 'promen-elementor-widgets'),
            'skipLocations' => __('Sla locaties over', 'promen-elementor-widgets'),
            'skipTextColumns' => __('Sla tekst kolommen over', 'promen-elementor-widgets'),
            'skipRelatedServices' => __('Sla gerelateerde diensten over', 'promen-elementor-widgets'),
            'skipTeamCarousel' => __('Sla team carrousel over', 'promen-elementor-widgets'),
            'skipStats' => __('Sla statistieken over', 'promen-elementor-widgets'),
            'skipTestimonial' => __('Sla testimonial over', 'promen-elementor-widgets'),
            'skipWorkerTestimonial' => __('Sla medewerker testimonial over', 'promen-elementor-widgets'),
            'skipTimeline' => __('Sla tijdlijn over', 'promen-elementor-widgets'),
            'skipCarousel' => __('Sla carrousel over', 'promen-elementor-widgets'),
            'skipSlider' => __('Sla slider over', 'promen-elementor-widgets'),
            'skipGallery' => __('Sla galerij over', 'promen-elementor-widgets'),
            'skipToForm' => __('Ga naar formulier', 'promen-elementor-widgets'),
            'backToTop' => __('Terug naar boven', 'promen-elementor-widgets'),
            'goToSlide' => __('Ga naar dia %s', 'promen-elementor-widgets'),
            'sliderPagination' => __('Slider paginering', 'promen-elementor-widgets'),
            'readMoreAbout' => __('Lees meer over %s', 'promen-elementor-widgets'),
            'viewDetails' => __('Bekijk details', 'promen-elementor-widgets'),
            'iconFor' => __('Icoon voor %s', 'promen-elementor-widgets'),
            'documentsFromYear' => __('Documenten uit jaar %s', 'promen-elementor-widgets'),
            
            // Stats Counter
            'statisticsLoading' => __('Statistieken worden geladen', 'promen-elementor-widgets'),
            'statisticsComplete' => __('Statistieken geladen', 'promen-elementor-widgets'),
            
            // Services
            'servicesCarouselLabel' => __('Diensten carrousel', 'promen-elementor-widgets'),
            'servicesGridLabel' => __('Diensten rooster', 'promen-elementor-widgets'),
            'servicesAvailable' => __('%s diensten beschikbaar', 'promen-elementor-widgets'),
            'serviceNowShowing' => __('Toont nu dienst: %s', 'promen-elementor-widgets'),
            'previousService' => __('Vorige dienst', 'promen-elementor-widgets'),
            'nextService' => __('Volgende dienst', 'promen-elementor-widgets'),
            
            // News
            'newsCarouselLabel' => __('Nieuws carrousel', 'promen-elementor-widgets'),
            'newsSliderLabel' => __('Nieuws slider', 'promen-elementor-widgets'),
            
            // Forms
            'requiredField' => __('Verplicht veld', 'promen-elementor-widgets'),
            'invalidEmail' => __('Voer een geldig e-mailadres in', 'promen-elementor-widgets'),
            'invalidPhone' => __('Voer een geldig telefoonnummer in', 'promen-elementor-widgets'),
            'formError' => __('Corrigeer de fouten in het formulier', 'promen-elementor-widgets'),
            'formSuccess' => __('Formulier succesvol verzonden', 'promen-elementor-widgets'),
            
            // Text-to-Speech
            'ttsPlay' => __('Voorlezen', 'promen-elementor-widgets'),
            'ttsPause' => __('Pauzeer voorlezen', 'promen-elementor-widgets'),
            'ttsResume' => __('Hervat voorlezen', 'promen-elementor-widgets'),
            'ttsStop' => __('Stop voorlezen', 'promen-elementor-widgets'),
            'ttsPaused' => __('Voorlezen gepauzeerd', 'promen-elementor-widgets'),
            'ttsResumed' => __('Voorlezen hervat', 'promen-elementor-widgets'),
            'ttsStopped' => __('Voorlezen gestopt', 'promen-elementor-widgets'),
            
            // Collapsible/Accordion
            'expandSection' => __('Sectie uitklappen', 'promen-elementor-widgets'),
            'collapseSection' => __('Sectie inklappen', 'promen-elementor-widgets'),
            'sectionExpanded' => __('Sectie uitgeklapt', 'promen-elementor-widgets'),
            'sectionCollapsed' => __('Sectie ingeklapt', 'promen-elementor-widgets'),
            
            // Menu
            'menuLabel' => __('Menu', 'promen-elementor-widgets'),
            'openMenu' => __('Open menu', 'promen-elementor-widgets'),
            'closeMenu' => __('Sluit menu', 'promen-elementor-widgets'),
            'menuOpened' => __('Menu geopend', 'promen-elementor-widgets'),
            'menuClosed' => __('Menu gesloten', 'promen-elementor-widgets'),
            
            // Testimonials
            'testimonialCarouselLabel' => __('Testimonials carrousel', 'promen-elementor-widgets'),
            'testimonialLabel' => __('Testimonial', 'promen-elementor-widgets'),
            
            // Documents
            'documentListLabel' => __('Documentenlijst', 'promen-elementor-widgets'),
            'downloadDocument' => __('Download document', 'promen-elementor-widgets'),
            
            // Locations
            'locationsLabel' => __('Locaties', 'promen-elementor-widgets'),
            'locationDetails' => __('Locatie details', 'promen-elementor-widgets'),
            
            // Contact
            'contactFormLabel' => __('Contactformulier', 'promen-elementor-widgets'),
            'contactInfoLabel' => __('Contactinformatie', 'promen-elementor-widgets'),
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
