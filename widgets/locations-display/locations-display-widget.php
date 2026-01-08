<?php
/**
 * Locations Display Widget.
 *
 * @package Promen
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include the split title functions
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/controls/split-title-controls.php');

// Include control files
require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');

// Include render files
require_once(__DIR__ . '/includes/render/render-functions.php');

/**
 * Locations Display widget.
 *
 * Elementor widget that displays location information with images and addresses.
 */
class Promen_Locations_Display_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'locations_display';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Locations Display', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-map-pin';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['promen'];
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['locations', 'address', 'map', 'places', 'offices'];
    }

    /**
     * Enqueue widget styles
     *
     * @return array Style dependencies
     */
    public function get_style_depends() {
        return ['promen-locations-display-widget'];
    }

    /**
     * Enqueue widget scripts
     *
     * @return array Script dependencies
     */
    public function get_script_depends() {
        return ['gsap', 'gsap-scrolltrigger', 'promen-locations-display-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Register content controls
        Promen_Locations_Display_Content_Controls::register_controls($this);
        
        // Register style controls
        Promen_Locations_Display_Style_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        Promen_Locations_Display_Render::render_widget($this, $settings);
    }
}