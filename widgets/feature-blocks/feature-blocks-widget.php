<?php
/**
 * Promen Feature Blocks Widget
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/feature-blocks-controls.php');
require_once(__DIR__ . '/includes/render/feature-blocks-render.php');

class Promen_Feature_Blocks_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_feature_blocks';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Feature Blocks With Image', 'promen-elementor-widgets');
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
        return ['feature', 'blocks', 'image', 'info', 'card'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Register content controls
        register_feature_blocks_content_controls($this);
        
        // Register layout controls
        register_feature_blocks_layout_controls($this);
        
        // Register positioning controls
        register_feature_blocks_positioning_controls($this);
        
        // Register style controls
        register_feature_blocks_style_controls($this);
    }

    /**
     * Render the widget output on the frontend.
     */
    protected function render() {
        render_feature_blocks_widget($this);
    }
} 