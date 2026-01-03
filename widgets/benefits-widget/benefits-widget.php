<?php
/**
 * Benefits Widget
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Benefits Widget Class
 */
class Promen_Benefits_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_benefits';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Benefits', 'promen-elementor-widgets');
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
        return ['benefits', 'advantages', 'features', 'list'];
    }

    /**
     * Register widget styles and scripts.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    }

    /**
     * Get style depends.
     */
    public function get_style_depends() {
        return ['promen-benefits-widget'];
    }

    /**
     * Get script depends.
     */
    public function get_script_depends() {
        return ['promen-benefits-accessibility'];
    }

    /**
     * Get widget help URL.
     */
    public function get_custom_help_url() {
        return 'https://example.com/benefits-widget';
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        require_once(__DIR__ . '/includes/controls/benefits-controls.php');
        register_benefits_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        require_once(__DIR__ . '/includes/render/benefits-render.php');
        render_benefits($this);
    }
}

// Register the widget
add_action('elementor/widgets/register', function($widgets_manager) {
    $widgets_manager->register(new Promen_Benefits_Widget());
}); 