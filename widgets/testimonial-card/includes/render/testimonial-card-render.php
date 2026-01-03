<?php
/**
 * Testimonial Card Widget Render Helper Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register and enqueue widget styles
 */
function register_testimonial_card_styles() {
    wp_register_style(
        'promen-testimonial-card-style',
        plugins_url('assets/css/testimonial-card.css', dirname(dirname(__FILE__))),
        [],
        '1.0.0'
    );
}
add_action('elementor/frontend/after_register_styles', 'register_testimonial_card_styles');

/**
 * Register and enqueue widget scripts
 */
function register_testimonial_card_scripts() {
    wp_register_script(
        'promen-testimonial-card-script',
        plugins_url('assets/js/testimonial-card.js', dirname(dirname(__FILE__))),
        ['jquery'],
        '1.0.0',
        true
    );
}
add_action('elementor/frontend/after_register_scripts', 'register_testimonial_card_scripts'); 