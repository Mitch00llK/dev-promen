<?php
/**
 * Promen Related Services Widget
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/related-services-controls.php');
require_once(__DIR__ . '/includes/render/related-services-render.php');

class Promen_Related_Services extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_related_services';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Related Services', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-grid';
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
        return ['services', 'related', 'grid', 'cards'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['promen-related-services-widget'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        // Register accessibility script
        wp_register_script(
            'promen-related-services-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/related-services/assets/js/related-services-accessibility.js',
            [],
            filemtime(__DIR__ . '/assets/js/related-services-accessibility.js'),
            true
        );
        
        return ['promen-related-services-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        register_related_services_controls($this);
    }

    /**
     * Render widget output.
     */
    protected function render() {
        render_related_services_widget($this);
    }
} 