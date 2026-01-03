<?php
/**
 * Promen Business Catering Widget
 * 
 * A widget that displays business catering images in a grid or slider layout.
 * Includes SwiperJS slider functionality when more than 3 images are added.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Business_Catering_Widget extends \Elementor\Widget_Base {

    /**
     * Register widget scripts and styles.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_script(
            'promen-business-catering-accessibility',
            plugins_url('assets/js/business-catering-accessibility.js', __FILE__),
            ['jquery'],
            '1.0.0',
            true
        );
    }

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_business_catering';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Business Catering', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return ['general'];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return ['business', 'catering', 'gallery', 'slider', 'images'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['promen-business-catering-style', 'swiper-bundle-css'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        return ['swiper-bundle', 'promen-business-catering-script', 'promen-business-catering-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include control files
        require_once(__DIR__ . '/includes/controls/content-controls.php');
        require_once(__DIR__ . '/includes/controls/slider-controls/slider-controls.php');
        require_once(__DIR__ . '/includes/controls/style-controls/style-controls.php');
        require_once(__DIR__ . '/includes/controls/visibility-controls.php');
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        // Include render file
        require_once(__DIR__ . '/includes/render/render-widget.php');
    }
} 