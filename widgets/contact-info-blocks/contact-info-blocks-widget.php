<?php
/**
 * Contact Info Blocks Widget.
 *
 * @package Promen
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include asset registration file
require_once(__DIR__ . '/contact-info-blocks-register.php');

/**
 * Contact Info Blocks widget.
 *
 * Elementor widget that displays contact information blocks with icons.
 */
class Promen_Contact_Info_Blocks_Widget extends \Elementor\Widget_Base {

    /**
     * Register widget scripts and styles.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    }

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'contact_info_blocks';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Contact Info Blocks', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-info-box';
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
        return ['contact', 'info', 'blocks', 'address', 'phone', 'email'];
    }

    /**
     * Enqueue widget styles and scripts
     */
    public function get_style_depends() {
        return ['contact-info-blocks'];
    }

    /**
     * Enqueue widget scripts
     */
    public function get_script_depends() {
        return ['gsap', 'gsap-scrolltrigger', 'promen-contact-info-blocks-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include control files
        require_once(__DIR__ . '/includes/content-controls.php');
        require_once(__DIR__ . '/includes/style-controls.php');
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Include the template file
        require_once(__DIR__ . '/includes/template.php');
    }
} 