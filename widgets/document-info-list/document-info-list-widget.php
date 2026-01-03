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
class Promen_Document_Info_List_Widget extends \Elementor\Widget_Base {

    /**
     * Register widget scripts and styles.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_script(
            'promen-document-info-list-accessibility',
            plugins_url('assets/js/document-info-list-accessibility.js', __FILE__),
            ['jquery'],
            '1.0.0',
            true
        );
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

    /**
     * Enqueue widget styles and scripts
     */
    public function get_style_depends() {
        // Get the file modification time for cache busting
        $css_file = __DIR__ . '/assets/css/document-info-list.css';
        $css_mod_time = file_exists($css_file) ? filemtime($css_file) : time();
        
        // Enqueue the CSS file
        wp_register_style(
            'document-info-list',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/document-info-list/assets/css/document-info-list.css',
            [],
            $css_mod_time
        );
        
        return ['document-info-list'];
    }

    /**
     * Enqueue widget scripts
     */
    public function get_script_depends() {
        // Register widget-specific script
        $js_file = __DIR__ . '/assets/js/document-info-list.js';
        $js_mod_time = file_exists($js_file) ? filemtime($js_file) : time();
        
        wp_register_script(
            'document-info-list-script',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/document-info-list/assets/js/document-info-list.js',
            ['gsap'],
            $js_mod_time,
            true
        );
        
        // Conditionally enqueue GSAP if not already loaded
        if (!wp_script_is('gsap', 'registered')) {
            wp_register_script(
                'gsap',
                'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.5/gsap.min.js',
                [],
                '3.11.5',
                true
            );
        }
        
        // We don't need ScrollTrigger anymore since we're animating on page load
        
        return ['gsap', 'document-info-list-script', 'promen-document-info-list-accessibility'];
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