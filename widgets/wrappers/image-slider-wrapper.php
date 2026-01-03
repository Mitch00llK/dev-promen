<?php
/**
 * Image Slider Widget Wrapper
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the widget file
require_once(dirname(__DIR__) . '/image-slider/image-slider-widget.php');

/**
 * Image Slider Widget Class
 */
class Promen_Image_Slider extends Promen_Image_Slider_Widget {
    public function __construct($data = [], $args = null) {
        // The widget will be registered in the main plugin file
        // No need to register it here 
        parent::__construct($data, $args);
    }
} 