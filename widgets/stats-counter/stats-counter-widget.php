<?php
/**
 * Promen Stats Counter Widget
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/counter-controls.php');
require_once(__DIR__ . '/includes/render/counter-render.php');

class Promen_Stats_Counter_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_stats_counter';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Stats Counter', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-counter-circle';
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
        return ['counter', 'stats', 'numbers', 'achievements'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        return ['promen-stats-counter-widget', 'promen-stats-counter-accessibility'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['promen-stats-counter-widget', 'promen-stats-counter-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Register content controls
        register_stats_counter_content_controls($this);
        
        // Register layout controls
        register_stats_counter_layout_controls($this);
        
        // Register style controls
        register_stats_counter_style_controls($this);
        
        // Register animation controls
        register_stats_counter_animation_controls($this);
        
        // Register accessibility controls
        register_stats_counter_accessibility_controls($this);
    }

    /**
     * Render the widget output on the frontend.
     */
    protected function render() {
        render_stats_counter_widget($this);
    }
} 