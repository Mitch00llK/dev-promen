<?php
/**
 * Contact Info Card Widget
 * 
 * A customizable contact information card widget with heading, description, 
 * employee information, and contact details.
 * 
 * This file serves as the main entry point for the widget and includes all necessary components.
 * The widget has been structured in a modular way for better maintainability.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Contact_Info_Card_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'contact_info_card';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Contact Info Card', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-info-box';
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
        return ['contact', 'info', 'card', 'employee'];
    }

    /**
     * Get style dependencies.
     */
    public function get_style_depends() {
        return ['contact-info-card', 'contact-info-card-accessibility'];
    }

    /**
     * Get script dependencies.
     */
    public function get_script_depends() {
        return ['contact-info-card-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include control components
        require_once(__DIR__ . '/includes/controls/content-controls.php');
        require_once(__DIR__ . '/includes/controls/style-controls.php');
        require_once(__DIR__ . '/includes/controls/visibility-controls.php');
        
        // Register content controls
        register_content_controls_for_contact_info_card($this);
        
        // Register style controls
        register_style_controls_for_contact_info_card($this);
        
        // Register visibility controls
        register_visibility_controls_for_contact_info_card($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        require_once(__DIR__ . '/includes/render/render-widget.php');
        render_contact_info_card_widget($this);
    }

    /**
     * Render widget output in the editor.
     */
    protected function content_template() {
        require_once(__DIR__ . '/includes/render/content-template.php');
        ob_start();
        render_contact_info_card_content_template();
        $template = ob_get_clean();
        echo $template;
    }
} 