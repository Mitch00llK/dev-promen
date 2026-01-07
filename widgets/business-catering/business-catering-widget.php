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

class Promen_Business_Catering_Widget extends \Promen_Widget_Base {

    /**
     * Register widget scripts and styles.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
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
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return [
            'promen-business-catering-base',
            'promen-business-catering-typography',
            'promen-business-catering-layout-grid',
            'promen-business-catering-component-image',
            'promen-business-catering-component-overlay',
            'promen-business-catering-component-slider',
            'promen-business-catering-responsive-tablet',
            'promen-business-catering-responsive-mobile',
            'swiper-bundle-css'
        ];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        return ['swiper-bundle', 'promen-business-catering-script', 'promen-business-catering-accessibility'];
    }

    /**
     * Get widget help URL.
     */
    public function get_custom_help_url() {
        return 'https://example.com/business-catering-widget';
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        require_once(__DIR__ . '/includes/controls/class-business-catering-controls.php');
        \Promen_Business_Catering_Controls::register($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        require_once(__DIR__ . '/includes/render/class-business-catering-render.php');
        \Promen_Business_Catering_Render::render($this);
    }
} 