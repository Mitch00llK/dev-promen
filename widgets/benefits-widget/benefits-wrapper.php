<?php
/**
 * Benefits Widget Wrapper
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/benefits-widget/benefits-widget.php');

/**
 * Benefits Widget Class
 */
class Promen_Benefits extends Promen_Benefits_Widget {
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
    }
} 