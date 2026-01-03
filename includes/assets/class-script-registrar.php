<?php
/**
 * Script Registrar Class
 * 
 * Handles the registration of JavaScript files using configuration arrays.
 * 
 * @package Elementor
 */

if (!defined('ABSPATH')) {
    exit;
}

class Promen_Script_Registrar {

    /**
     * Register widget scripts from configuration
     * 
     * @param array $scripts Configuration array
     */
    public function register_widget_scripts($scripts) {
        foreach ($scripts as $handle => $config) {
            $path = isset($config['path']) ? $config['path'] : '';
            $deps = isset($config['deps']) ? $config['deps'] : [];
            $ver  = isset($config['ver']) ? $config['ver'] : PROMEN_ELEMENTOR_WIDGETS_VERSION;
            $in_footer = isset($config['in_footer']) ? $config['in_footer'] : true;

            if (empty($path)) {
                continue;
            }

            wp_register_script(
                $handle,
                PROMEN_ELEMENTOR_WIDGETS_URL . $path,
                $deps,
                $ver,
                $in_footer
            );

            if (isset($config['enqueue']) && $config['enqueue']) {
                wp_enqueue_script($handle);
            }
        }
    }
}
