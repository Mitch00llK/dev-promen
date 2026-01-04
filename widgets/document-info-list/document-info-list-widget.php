<?php
/**
 * Document Info List Widget.
 *
 * @package Promen
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Document Info List Widget.
 *
 * Elementor widget that displays a two-column info list with icons and document attachments.
 */
class Promen_Document_Info_List_Widget extends \Promen_Widget_Base {

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
        return 'document_info_list';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Document Info List', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-document-file';
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
        return ['document', 'info', 'list', 'attachment', 'file', 'download'];
    }

    public function get_style_depends() {
        return ['promen-document-info-list-widget'];
    }

    public function get_script_depends() {
        return ['document-info-list-script', 'promen-document-info-list-accessibility'];
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