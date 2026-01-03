<?php
/**
 * Promen Image Text Block Widget
 * 
 * A customizable widget with image and text blocks that can be switched between left and right positions.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');
require_once(__DIR__ . '/includes/render/render-functions.php');

class Promen_Image_Text_Block_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_image_text_block';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Image Text Block', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-image-box';
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
        return ['image', 'text', 'block', 'promen', 'switch', 'layout'];
    }

    /**
     * Register widget styles.
     */
    public function get_style_depends() {
        return ['promen-image-text-block-widget', 'promen-image-text-block-accessibility', 'fontawesome'];
    }

    /**
     * Register widget scripts.
     */
    public function get_script_depends() {
        return ['promen-image-text-block-widget', 'promen-image-text-block-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include controls from separate files
        Promen_Image_Text_Block_Content_Controls::register_controls($this);
        Promen_Image_Text_Block_Style_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Call the render function from the render file
        Promen_Image_Text_Block_Render::render_widget($this, $settings);
    }
} 