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
        return ['promen-image-slider-style', 'swiper-bundle-css'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        return ['swiper-bundle', 'promen-image-slider-script'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include control files
        require_once(__DIR__ . '/includes/controls/content-controls.php');
        require_once(__DIR__ . '/includes/controls/slider-controls/slider-controls.php');
        require_once(__DIR__ . '/includes/controls/style-controls/style-controls.php');
        require_once(__DIR__ . '/includes/controls/visibility-controls.php');
        
        // Make sure the split title controls are included
        if (!function_exists('promen_add_split_title_controls')) {
            $split_title_controls = WP_PLUGIN_DIR . '/promen-elementor-widgets/includes/controls/split-title-controls.php';
            if (file_exists($split_title_controls)) {
                require_once($split_title_controls);
            }
        }
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Debug output
        if (current_user_can('administrator')) {
            echo '<!-- Image Slider Widget Debug: Settings loaded -->';
        }
        
        // Include render file
        require_once(__DIR__ . '/includes/render/render-widget.php');
    }
} 