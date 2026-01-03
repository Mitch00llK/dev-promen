<?php
/**
 * Image Text Slider Wrapper
 * 
 * Registers the Image Text Slider widget
 * 
 * @package Promen Elementor Widgets
 */
 
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

require_once(__DIR__ . '/image-text-slider-widget.php');

/**
 * Image Text Slider Widget Class
 */
class Promen_Image_Text_Slider extends Promen_Image_Text_Slider_Widget {
    public function __construct($data = [], $args = null) {
        // The widget will be registered in the main plugin file
        // No need to register it here 
        parent::__construct($data, $args);
    }
} 