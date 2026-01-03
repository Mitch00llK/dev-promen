<?php
/**
 * Promen Text Column Repeater Widget
 * 
 * A customizable widget for displaying a title with text columns in a repeater layout.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');
require_once(__DIR__ . '/includes/render/render-functions.php');

class Promen_Text_Column_Repeater_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_text_column_repeater';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Text Column Repeater', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-columns';
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
        return ['text', 'column', 'repeater', 'tools', 'promen'];
    }

    /**
     * Register widget styles.
     */
    public function get_style_depends() {
        return ['promen-text-column-repeater-widget'];
    }

    /**
     * Register widget scripts.
     */
    public function get_script_depends() {
        // Register accessibility script
        wp_register_script(
            'promen-text-column-repeater-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/text-column-repeater/assets/js/text-column-repeater-accessibility.js',
            [],
            filemtime(__DIR__ . '/assets/js/text-column-repeater-accessibility.js'),
            true
        );
        
        return ['promen-text-column-repeater-widget', 'promen-text-column-repeater-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include controls from separate files
        Promen_Text_Column_Repeater_Content_Controls::register_controls($this);
        Promen_Text_Column_Repeater_Style_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Call the render function from the render file
        Promen_Text_Column_Repeater_Render::render_widget($this, $settings);
    }
} 