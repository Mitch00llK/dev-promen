<?php
/**
 * Promen Image Slider Widget
 * 
 * A widget that displays images in a grid or slider layout.
 * Includes SwiperJS slider functionality when more than 3 images are added.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/includes/controls/content-controls.php');
require_once(__DIR__ . '/includes/controls/style-controls.php');
require_once(__DIR__ . '/includes/render/render-widget.php');

use Promen\Widgets\ImageSlider\Controls\Promen_Image_Slider_Content_Controls;
use Promen\Widgets\ImageSlider\Controls\Promen_Image_Slider_Style_Controls;
use Promen\Widgets\ImageSlider\Render\Promen_Image_Slider_Render;

class Promen_Image_Slider_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_image_slider';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Image Slider', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-gallery-grid';
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
        return ['image', 'slider', 'gallery', 'carousel', 'photos'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['promen-image-slider', 'swiper-bundle-css'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        return ['promen-image-slider-widget'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        Promen_Image_Slider_Content_Controls::register_controls($this);
        Promen_Image_Slider_Style_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        Promen_Image_Slider_Render::render_widget($this);
    }
}