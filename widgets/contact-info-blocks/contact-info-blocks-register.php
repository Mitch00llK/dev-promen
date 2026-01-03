<?php
/**
 * Register Contact Info Blocks Widget Assets
 * 
 * Registers styles and scripts for the Contact Info Blocks widget using WordPress hooks.
 * This ensures assets are registered before Elementor tries to enqueue them,
 * preventing widgets from disappearing when cache is cleared.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register Contact Info Blocks widget styles.
 */
function register_contact_info_blocks_styles() {
    // Prevent duplicate registration
    if (wp_style_is('contact-info-blocks', 'registered')) {
        return;
    }
    
    $css_file = __DIR__ . '/assets/css/contact-info-blocks.css';
    $css_mod_time = file_exists($css_file) ? filemtime($css_file) : time();
    
    wp_register_style(
        'contact-info-blocks',
        PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/contact-info-blocks/assets/css/contact-info-blocks.css',
        [],
        $css_mod_time
    );
}
// Register immediately if WordPress is loaded, otherwise on hooks
if (function_exists('wp_register_style')) {
    register_contact_info_blocks_styles();
}
// Also register on hooks as fallback
add_action('init', 'register_contact_info_blocks_styles', 5);
add_action('elementor/frontend/after_register_styles', 'register_contact_info_blocks_styles');
add_action('wp_enqueue_scripts', 'register_contact_info_blocks_styles');

/**
 * Register Contact Info Blocks widget scripts.
 */
function register_contact_info_blocks_scripts() {
    // Prevent duplicate registration
    if (wp_script_is('promen-contact-info-blocks-accessibility', 'registered')) {
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
    $js_file = __DIR__ . '/assets/js/contact-info-blocks-accessibility.js';
    $js_mod_time = file_exists($js_file) ? filemtime($js_file) : time();
    
    wp_register_script(
        'promen-contact-info-blocks-accessibility',
        PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/contact-info-blocks/assets/js/contact-info-blocks-accessibility.js',
        [],
        $js_mod_time,
        true
    );
}
// Register immediately if WordPress is loaded, otherwise on hooks
if (function_exists('wp_register_script')) {
    register_contact_info_blocks_scripts();
}
// Also register on hooks as fallback
add_action('init', 'register_contact_info_blocks_scripts', 5);
add_action('elementor/frontend/after_register_scripts', 'register_contact_info_blocks_scripts');
add_action('wp_enqueue_scripts', 'register_contact_info_blocks_scripts');

