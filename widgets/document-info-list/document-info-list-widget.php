<?php
/**
 * Document Info List Widget.
 *
 * @package Promen
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Import static classes
require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');
require_once(__DIR__ . '/includes/render/render-widget.php');

use Promen\Widgets\DocumentInfoList\Controls\Promen_Document_Info_List_Content_Controls;
use Promen\Widgets\DocumentInfoList\Controls\Promen_Document_Info_List_Style_Controls;
use Promen\Widgets\DocumentInfoList\Render\Promen_Document_Info_List_Render;

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
        return ['promen-document-info-list'];
    }

    public function get_script_depends() {
        return ['promen-document-info-list-script', 'promen-document-info-list-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        Promen_Document_Info_List_Content_Controls::register_controls($this);
        Promen_Document_Info_List_Style_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        Promen_Document_Info_List_Render::render_widget($this);
    }
} 