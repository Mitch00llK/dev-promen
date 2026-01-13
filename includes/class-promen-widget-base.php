<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Guard: Only load this class if Elementor is available
if (!did_action('elementor/loaded')) {
    return;
}

/**
 * Promen Widget Base Class
 * 
 * Abstract base class for all Promen Elementor widgets.
 * Provides helper methods for safe settings retrieval and error tracking.
 */
abstract class Promen_Widget_Base extends \Elementor\Widget_Base {

    /**
     * Get a setting value safely with a default fallback.
     * 
     * @param string $key     The setting key to retrieve.
     * @param mixed  $default The default value if key is missing.
     * @return mixed The setting value or default.
     */
    public function get_safe_setting($key, $default = '') {
        $settings = $this->get_settings_for_display();
        
        if (!isset($settings[$key])) {
            // Optional: Log missing key to debug.log if WP_DEBUG is enabled
            if (defined('WP_DEBUG') && WP_DEBUG) {
                error_log(sprintf(
                    '[Promen Widget Warning] Missing setting key "%s" in widget "%s" (ID: %s). Using default: "%s"',
                    $key,
                    $this->get_name(),
                    $this->get_id(),
                    is_array($default) ? 'Array' : $default
                ));
            }
            return $default;
        }

        return $settings[$key];
    }

    /**
     * Print a safe setting value (escaped).
     * 
     * @param string $key     The setting key.
     * @param mixed  $default Default value.
     */
    public function safe_print($key, $default = '') {
        echo wp_kses_post($this->get_safe_setting($key, $default));
    }
}
