<?php
/**
 * Register Certification Logos Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register Certification Logos Widget.
 *
 * Include widget file and register widget class.
 *
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_certification_logos_widget($widgets_manager) {
    require_once(__DIR__ . '/certification-logos.php');
    $widgets_manager->register(new \Promen_Certification_Logos_Widget());
}
add_action('elementor/widgets/register', 'register_certification_logos_widget');

/**
 * Register widget styles.
 */
function register_certification_logos_styles() {
    wp_register_style(
        'certification-logos',
        plugins_url('assets/css/certification-logos.css', __FILE__),
        [],
        '1.0.0'
    );
}
add_action('wp_enqueue_scripts', 'register_certification_logos_styles');

/**
 * Enqueue widget styles.
 */
function enqueue_certification_logos_styles() {
    wp_enqueue_style('certification-logos');
}
add_action('elementor/frontend/after_enqueue_styles', 'enqueue_certification_logos_styles');

/**
 * Register and enqueue Swiper if not already included by Elementor
 */
function register_certification_logos_scripts() {
    if (!wp_script_is('swiper', 'registered')) {
        wp_register_script(
            'swiper',
            'https://unpkg.com/swiper@8/swiper-bundle.min.js',
            [],
            '8.0.0',
            true
        );
        wp_register_style(
            'swiper',
            'https://unpkg.com/swiper@8/swiper-bundle.min.css',
            [],
            '8.0.0'
        );
    }
}
add_action('wp_enqueue_scripts', 'register_certification_logos_scripts');

/**
 * Enqueue Swiper if needed
 */
function enqueue_certification_logos_scripts() {
    if (!wp_script_is('swiper', 'enqueued')) {
        wp_enqueue_script('swiper');
        wp_enqueue_style('swiper');
    }
}
add_action('elementor/frontend/after_enqueue_scripts', 'enqueue_certification_logos_scripts'); 