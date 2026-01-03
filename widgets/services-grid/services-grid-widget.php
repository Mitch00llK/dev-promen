<?php
/**
 * Promen Services Grid Widget
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/services-grid-controls.php');
require_once(__DIR__ . '/includes/render/services-grid-render.php');

class Promen_Services_Grid extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_services_grid';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Services Grid', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-grid';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return ['promen-widgets'];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return ['services', 'grid', 'features', 'slider'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['promen-services-grid-widget', 'promen-services-grid-accessibility', 'services-grid-slider-style', 'swiper-bundle-css'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        // Register accessibility script
        wp_register_script(
            'promen-services-grid-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/services-grid/assets/js/services-grid-accessibility.js',
            ['jquery'],
            filemtime(__DIR__ . '/assets/js/services-grid-accessibility.js'),
            true
        );
        
        return ['swiper-bundle', 'services-grid-slider-script', 'promen-services-grid-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        register_services_grid_controls($this);
    }

    /**
     * Render widget output.
     */
    protected function render() {
        render_services_grid_widget($this);
    }
} 