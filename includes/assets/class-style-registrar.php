<?php
/**
 * Style Registrar Class
 * 
 * Handles the registration and enqueuing of CSS files using configuration arrays.
 * 
 * @package Elementor
 */

if (!defined('ABSPATH')) {
    exit;
}

class Promen_Style_Registrar {

    /**
     * Register widget styles from configuration
     * 
     * @param array $styles Configuration array
     */
    public function register_widget_styles($styles) {
        foreach ($styles as $handle => $config) {
            $path = isset($config['path']) ? $config['path'] : '';
            $deps = isset($config['deps']) ? $config['deps'] : [];
            $media = isset($config['media']) ? $config['media'] : 'all';

            if (empty($path)) {
                continue;
            }

            // Determine version: use filemtime for automatic cache busting, fallback to plugin version
            $file_path = PROMEN_ELEMENTOR_WIDGETS_PATH . $path;
            if (isset($config['ver'])) {
                $ver = $config['ver'];
            } elseif (file_exists($file_path)) {
                $ver = filemtime($file_path);
            } else {
                $ver = PROMEN_ELEMENTOR_WIDGETS_VERSION;
            }

            wp_register_style(
                $handle,
                PROMEN_ELEMENTOR_WIDGETS_URL . $path,
                $deps,
                $ver,
                $media
            );

            if (isset($config['enqueue']) && $config['enqueue']) {
                wp_enqueue_style($handle);
            }
        }
    }
}
