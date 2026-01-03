<?php
/**
 * Services Carousel Widget Wrapper
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the widget file
require_once(dirname(__DIR__) . '/services-carousel/services-carousel-widget.php');

// The widget will be registered in the main plugin file
// No need to register it here 