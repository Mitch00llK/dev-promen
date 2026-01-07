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

// Include control components
require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');
require_once(__DIR__ . '/includes/controls/visibility-controls.php');

// Include render components
require_once(__DIR__ . '/includes/render/render-widget.php');
// Note: content-template.php is usually for JS templates, we'll keep it as is or handle it if needed. 
// However, standard architecture suggests converting it too. But for now let's stick to what we know.
// The file usage below suggests it's a function `render_contact_info_card_content_template`.
require_once(__DIR__ . '/includes/render/content-template.php');

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
        return ['promen-contact-info-card', 'promen-contact-info-card-accessibility'];
    }

    /**
     * Get script dependencies.
     */
    public function get_script_depends() {
        return ['promen-contact-info-card-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Register content controls
        Promen_Contact_Info_Card_Content_Controls::register_controls($this);
        
        // Register style controls
        Promen_Contact_Info_Card_Style_Controls::register_controls($this);
        
        // Register visibility controls
        Promen_Contact_Info_Card_Visibility_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        Promen_Contact_Info_Card_Render::render_widget($this);
    }

    /**
     * Render widget output in the editor.
     */
    protected function content_template() {
        ob_start();
        render_contact_info_card_content_template();
        $template = ob_get_clean();
        echo $template;
    }
}
 