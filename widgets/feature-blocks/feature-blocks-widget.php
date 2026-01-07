<?php
/**
 * Promen Feature Blocks Widget
 */

use Promen\Widgets\FeatureBlocks\Controls\Promen_Feature_Blocks_Content_Controls;
use Promen\Widgets\FeatureBlocks\Controls\Promen_Feature_Blocks_Style_Controls;
use Promen\Widgets\FeatureBlocks\Render\Promen_Feature_Blocks_Render;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Global require calls for the static classes
require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');
require_once(__DIR__ . '/includes/render/render-widget.php');

class Promen_Feature_Blocks_Widget extends \Promen_Widget_Base {

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
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['promen-feature-blocks'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        Promen_Feature_Blocks_Content_Controls::register_controls($this);
        Promen_Feature_Blocks_Style_Controls::register_controls($this);
    }

    /**
     * Render the widget output on the frontend.
     */
    protected function render() {
        Promen_Feature_Blocks_Render::render_widget($this);
    }
} 