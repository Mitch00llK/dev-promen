<?php
/**
 * Image Text Slider View Helper
 * 
 * Handles logic for rendering the widget.
 * 
 * @package Elementor
 * @subpackage Promen Elementor Widgets
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Image_Text_Slider_View_Helper {

    /**
     * Get slider options for JS
     * 
     * @param array $settings Widget settings
     * @return array
     */
    public static function get_slider_options($settings) {
        return [
            'autoplay' => $settings['autoplay'] === 'yes',
            'autoplaySpeed' => $settings['autoplay'] === 'yes' ? (int)$settings['autoplay_speed'] : 5000,
            'pauseOnHover' => $settings['autoplay'] === 'yes' && $settings['pause_on_hover'] === 'yes',
            'infinite' => $settings['infinite'] === 'yes',
            'speed' => (int)$settings['transition_speed'],
            'effect' => $settings['transition_effect'],
            'enableGsapAnimations' => $settings['enable_gsap_animations'] === 'yes',
            'animationDuration' => isset($settings['animation_duration']['size']) ? $settings['animation_duration']['size'] : 0.7,
            'accessibility' => [
                'enabled' => true,
                'keyboard' => true,
                'announcements' => true,
                'focusOnSelect' => true,
                'reducedMotion' => false // Will be set by JS
            ]
        ];
    }

    /**
     * Get container classes
     * 
     * @param array $settings Widget settings
     * @param array $visible_slides Visible slides
     * @return string
     */
    public static function get_container_classes($settings, $visible_slides) {
        $classes = ['image-text-slider-container'];
        
        // Content position
        $classes[] = 'content-position-' . $settings['content_position'];
        
        // Height mode
        if ($settings['slider_height'] === 'full') {
            $classes[] = 'height-full';
        } elseif ($settings['slider_height'] === 'custom') {
            $classes[] = 'height-custom';
        }
        
        // Pagination position
        if ($settings['show_pagination'] === 'yes') {
            $classes[] = 'pagination-' . $settings['pagination_position'];
        }
        
        // Arrows position
        if ($settings['show_arrows'] === 'yes') {
            $classes[] = 'arrows-inside-content';
        }
        
        // Extended overlays
        $has_extended_overlays = false;
        foreach ($visible_slides as $slide) {
            if (isset($slide['show_absolute_overlay_image']) && 
                $slide['show_absolute_overlay_image'] === 'yes' && 
                isset($slide['absolute_overlay_extend_beyond']) && 
                $slide['absolute_overlay_extend_beyond'] === 'yes') {
                $has_extended_overlays = true;
                break;
            }
        }
        if ($has_extended_overlays) {
            $classes[] = 'has-extended-overlays';
        }

        return implode(' ', $classes);
    }

    /**
     * Get divider data attributes
     * 
     * @param array $settings
     * @return string
     */
    public static function get_divider_data_attrs($settings) {
        if ($settings['show_tilted_divider'] !== 'yes') {
            return '';
        }

        $tilt_angle = isset($settings['divider_tilt_degrees']) ? $settings['divider_tilt_degrees'] : ($settings['divider_tilt_angle']['size'] ?? -12);
        
        if ($settings['divider_flip_direction'] === 'yes') {
            $tilt_angle = -1 * $tilt_angle;
        }
        
        $divider_height = isset($settings['divider_height']['size']) ? $settings['divider_height']['size'] : 20;
        $divider_height_unit = isset($settings['divider_height']['unit']) ? $settings['divider_height']['unit'] : 'rem';
        
        return ' data-degrees="' . esc_attr($tilt_angle) . '" data-height="' . esc_attr($divider_height . $divider_height_unit) . '"';
    }

    /**
     * Get visible slides
     * 
     * @param array $slides
     * @return array
     */
    public static function get_visible_slides($slides) {
        if (empty($slides)) {
            return [];
        }
        $visible = array_filter($slides, function($slide) {
            return isset($slide['show_slide']) && $slide['show_slide'] === 'yes';
        });
        return array_values($visible);
    }
}
