<?php
/**
 * Certification Logos Widget
 * 
 * Displays a collection of certification and quality mark logos with title
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Certification_Logos_Widget extends \Elementor\Widget_Base {

    /**
     * Register widget scripts and styles.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    }

    public function get_name() {
        return 'promen_certification_logos';
    }

    public function get_title() {
        return esc_html__('Certification Logos', 'promen-elementor-widgets');
    }

    public function get_icon() {
        return 'eicon-logo';
    }

    public function get_categories() {
        return ['promen-widgets'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return [
            'promen-certification-logos-base',
            'promen-certification-logos-typography',
            'promen-certification-logos-layout-grid',
            'promen-certification-logos-component-logo',
            'promen-certification-logos-component-slider',
            'promen-certification-logos-responsive-tablet',
            'promen-certification-logos-responsive-mobile',
            'swiper-bundle-css'
        ];
    }

    /**
     * Get script dependencies.
     */
    public function get_script_depends() {
        return [
            'swiper-bundle', 
            'promen-certification-logos-module',
            'promen-certification-logos-accessibility'
        ];
    }

    /**
     * Get widget help URL.
     */
    public function get_custom_help_url() {
        return 'https://example.com/certification-logos-widget';
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        require_once(__DIR__ . '/includes/controls/class-certification-logos-controls.php');
        \Promen_Certification_Logos_Controls::register($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        require_once(__DIR__ . '/includes/render/class-certification-logos-render.php');
        \Promen_Certification_Logos_Render::render($this);
    }
}