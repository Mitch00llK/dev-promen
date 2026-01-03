<?php
/**
 * Promen Services Carousel Widget
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/carousel-controls.php');
require_once(__DIR__ . '/includes/render/carousel-render.php');

class Promen_Services_Carousel_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_services_carousel';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Services Carousel', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-carousel';
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
        return ['services', 'carousel', 'slider', 'reintegratie', 'card'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        return ['gsap', 'swiper-bundle', 'promen-services-carousel-widget'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['swiper-bundle-css', 'promen-services-carousel-widget'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Register content controls
        register_services_carousel_content_controls($this);
        
        // Register layout controls
        register_services_carousel_layout_controls($this);
        
        // Register style controls
        register_services_carousel_style_controls($this);
        
        // Register animation controls
        register_services_carousel_animation_controls($this);
    }

    /**
     * Render the widget output on the frontend.
     */
    protected function render() {
        render_services_carousel_widget($this);
    }
} 