<?php
/**
 * Locations Display Widget.
 *
 * @package Promen
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the split title functions
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/controls/split-title-controls.php');

/**
 * Locations Display widget.
 *
 * Elementor widget that displays location information with images and addresses.
 */
class Promen_Locations_Display_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'locations_display';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Locations Display', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-map-pin';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['promen'];
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['locations', 'address', 'map', 'places', 'offices'];
    }

    /**
     * Enqueue widget styles and scripts
     */
    public function get_style_depends() {
        // Get the file modification time for cache busting
        $css_file = __DIR__ . '/assets/locations-display.css';
        $css_mod_time = file_exists($css_file) ? filemtime($css_file) : time();
        
        // Enqueue the CSS file
        wp_register_style(
            'locations-display',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/locations-display/assets/locations-display.css',
            [],
            $css_mod_time
        );
        
        return ['locations-display'];
    }

    /**
     * Enqueue widget scripts
     */
    public function get_script_depends() {
        // Conditionally enqueue GSAP if not already loaded
        if (!wp_script_is('gsap', 'registered')) {
            wp_register_script(
                'gsap',
                'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js',
                [],
                '3.11.5',
                true
            );
        }
        
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
        wp_register_script(
            'promen-locations-display-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/locations-display/assets/js/locations-display-accessibility.js',
            [],
            filemtime(__DIR__ . '/assets/js/locations-display-accessibility.js'),
            true
        );
        
        return ['gsap', 'gsap-scrolltrigger', 'promen-locations-display-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include control files
        require_once(__DIR__ . '/includes/content-controls.php');
        require_once(__DIR__ . '/includes/style-controls.php');
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Include the template file
        require_once(__DIR__ . '/includes/template.php');
    }
} 