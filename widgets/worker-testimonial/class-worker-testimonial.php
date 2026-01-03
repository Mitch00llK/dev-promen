<?php
/**
 * Worker Testimonial Widget
 *
 * @package Promen\Widgets
 */

namespace Promen\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Typography;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Worker Testimonial Widget
 *
 * Elementor widget for displaying worker testimonials.
 *
 * @since 1.0.0
 */
class Worker_Testimonial extends Widget_Base {

    /**
     * Get widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'promen-worker-testimonial';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Worker Testimonial', 'promen-elementor');
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-testimonial';
    }

    /**
     * Get widget categories.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['promen-widgets'];
    }

    /**
     * Get widget keywords.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['testimonial', 'worker', 'quote'];
    }

    /**
     * Get widget style dependencies.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget styles.
     */
    public function get_style_depends() {
        return ['promen-worker-testimonial-widget'];
    }

    /**
     * Register widget controls.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        // Include controls
        require_once plugin_dir_path(__FILE__) . 'includes/controls-content.php';
        require_once plugin_dir_path(__FILE__) . 'includes/controls-style.php';
    }

    /**
     * Render widget output on the frontend.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Include template
        include plugin_dir_path(__FILE__) . 'templates/worker-testimonial-template.php';
    }
} 