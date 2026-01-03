<?php
/**
 * Promen Text Content Block Widget
 * 
 * A customizable widget for displaying formatted text content with headings, paragraphs, lists, and blockquotes.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');
require_once(__DIR__ . '/includes/render/render-functions.php');

class Promen_Text_Content_Block_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_text_content_block';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Text Content Block', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-text';
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
        return ['text', 'content', 'block', 'promen', 'heading', 'list', 'blockquote'];
    }

    /**
     * Register widget styles.
     */
    public function get_style_depends() {
        return ['promen-text-content-block'];
    }

    /**
     * Register widget scripts.
     */
    public function get_script_depends() {
        return ['promen-text-content-block'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include controls from separate files
        Promen_Text_Content_Block_Content_Controls::register_controls($this);
        Promen_Text_Content_Block_Style_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Call the render function from the render file
        Promen_Text_Content_Block_Render::render_widget($this, $settings);
    }
} 