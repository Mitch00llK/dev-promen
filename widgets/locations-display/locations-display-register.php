<?php
/**
 * Register Locations Display Widget Assets
 * 
 * Registers styles and scripts for the Locations Display widget using WordPress hooks.
 * This ensures assets are registered before Elementor tries to enqueue them,
 * preventing widgets from disappearing when cache is cleared.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register Locations Display widget styles.
 */
function register_locations_display_styles() {
    // Prevent duplicate registration
    if (wp_style_is('locations-display', 'registered')) {
        return;
    }
    
    $css_file = __DIR__ . '/assets/css/locations-display.css';
    $css_mod_time = file_exists($css_file) ? filemtime($css_file) : time();
    
    wp_register_style(
        'locations-display',
        PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/locations-display/assets/css/locations-display.css',
        [],
        $css_mod_time
    );
}
add_action('elementor/frontend/after_register_styles', 'register_locations_display_styles');
add_action('wp_enqueue_scripts', 'register_locations_display_styles');

/**
 * Register Locations Display widget scripts.
 */
function register_locations_display_scripts() {
    // Prevent duplicate registration
    if (wp_script_is('promen-locations-display-accessibility', 'registered')) {
        return;
    }
    
    // Register GSAP if not already registered
    if (!wp_script_is('gsap', 'registered')) {
        wp_register_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js',
            [],
            '3.11.5',
            true
        );
    }
    
    // Register GSAP ScrollTrigger if not already registered
    if (!wp_script_is('gsap-scrolltrigger', 'registered')) {
        wp_register_script(
            'gsap-scrolltrigger',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/ScrollTrigger.min.js',
            ['gsap'],
            '3.11.5',
            true
        );
    }
    
    // Register accessibility script
    $js_file = __DIR__ . '/assets/js/locations-display-accessibility.js';
    $js_mod_time = file_exists($js_file) ? filemtime($js_file) : time();
    
    wp_register_script(
        'promen-locations-display-accessibility',
        PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/locations-display/assets/js/locations-display-accessibility.js',
        [],
        $js_mod_time,
        true
    );
}
add_action('elementor/frontend/after_register_scripts', 'register_locations_display_scripts');
add_action('wp_enqueue_scripts', 'register_locations_display_scripts');

