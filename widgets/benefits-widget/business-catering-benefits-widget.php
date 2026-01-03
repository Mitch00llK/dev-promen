<?php
/**
 * Business Catering Benefits Widget
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Business Catering Benefits Widget Class
 */
class Business_Catering_Benefits_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'business_catering_benefits';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Business Catering Benefits', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-bullet-list';
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
        return ['business', 'catering', 'benefits', 'advantages', 'features'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        require_once(__DIR__ . '/includes/controls/business-catering-benefits-controls.php');
        register_business_catering_benefits_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        require_once(__DIR__ . '/includes/render/business-catering-benefits-render.php');
        render_business_catering_benefits($this);
    }

    /**
     * Register widget styles and scripts
     */
    public function get_style_depends() {
        return ['business-catering-benefits'];
    }
}

// Register the widget
add_action('elementor/widgets/register', function($widgets_manager) {
    $widgets_manager->register(new Business_Catering_Benefits_Widget());
}); 