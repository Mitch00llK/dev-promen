<?php
/**
 * Promen Hamburger Menu Widget
 * 
 * An advanced hamburger menu widget with smooth animations and customizable options.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the controls and render files
require_once(__DIR__ . '/includes/controls/hamburger-menu-controls.php');
require_once(__DIR__ . '/includes/render/hamburger-menu-render.php');

/**
 * Class Hamburger_Menu_Widget
 * 
 * Main widget class for the hamburger menu implementation
 */
class Promen_Hamburger_Menu_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'promen_hamburger_menu';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Hamburger Menu', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-menu-bar';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['general', 'header-elements'];
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['menu', 'hamburger', 'navigation', 'mobile', 'toggle'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Register content controls
        register_hamburger_menu_content_controls($this);
        
        // Register style controls
        register_hamburger_menu_style_controls($this);
    }

    /**
     * Render the widget output on the frontend.
     */
    protected function render() {
        render_hamburger_menu_widget($this);
    }
    
    /**
     * Get script dependencies.
     *
     * @return array Scripts dependencies.
     */
    public function get_script_depends() {
        return ['gsap', 'promen-hamburger-menu-js'];
    }
    
    /**
     * Get style dependencies.
     *
     * @return array Styles dependencies.
     */
    public function get_style_depends() {
        return ['promen-hamburger-menu-css'];
    }
} 