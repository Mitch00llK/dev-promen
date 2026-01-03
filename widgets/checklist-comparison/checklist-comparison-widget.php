<?php
/**
 * Promen Checklist Comparison Widget
 * 
 * A widget for displaying two-column comparison of checklist items.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');
require_once(__DIR__ . '/includes/render/render-functions.php');

class Promen_Checklist_Comparison_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_checklist_comparison';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Checklist Comparison', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-table';
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
        return ['checklist', 'comparison', 'promen', 'list', 'compare'];
    }

    /**
     * Register widget styles.
     */
    public function get_style_depends() {
        return ['promen-checklist-comparison-widget'];
    }

    /**
     * Register widget scripts.
     */
    public function get_script_depends() {
        return ['promen-checklist-comparison-widget', 'promen-checklist-comparison-accessibility'];
    }

    /**
     * Register widget scripts in constructor.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_script(
            'promen-checklist-comparison-accessibility',
            plugins_url('assets/js/checklist-comparison-accessibility.js', __FILE__),
            ['jquery'],
            '1.0.0',
            true
        );
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include controls from separate files
        Promen_Checklist_Comparison_Content_Controls::register_controls($this);
        Promen_Checklist_Comparison_Style_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Call the render function from the render file
        Promen_Checklist_Comparison_Render::render_widget($this, $settings);
    }
} 