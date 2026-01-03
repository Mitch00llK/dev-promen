<?php
/**
 * News Posts Widget Wrapper
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the widget file
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/news-posts/news-posts-widget.php');

// The widget will be registered in the main plugin file
// No need to register it here 