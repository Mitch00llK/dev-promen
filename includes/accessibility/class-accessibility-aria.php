<?php
/**
 * Accessibility ARIA Utilities
 * 
 * Provides ARIA attribute generators for accessible widgets.
 * 
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Accessibility ARIA Utilities Class
 */
class Promen_Accessibility_Aria {

    /**
     * Generate unique ID for accessibility purposes
     * 
     * @param string $prefix ID prefix.
     * @param string $widget_id Widget ID.
     * @return string Unique accessibility ID.
     */
    public static function generate_id($prefix, $widget_id = '') {
        $unique_id = $prefix . '-' . ($widget_id ? $widget_id : wp_generate_uuid4());
        return sanitize_html_class($unique_id);
    }

    /**
     * Generate ARIA label attributes
     * 
     * @param string $label The aria-label text.
     * @param string $labelledby Optional aria-labelledby ID.
     * @param string $describedby Optional aria-describedby ID.
     * @return string ARIA attributes string.
     */
    public static function get_aria_label_attrs($label = '', $labelledby = '', $describedby = '') {
        $attrs = [];

        if (!empty($label)) {
            $attrs[] = 'aria-label="' . esc_attr($label) . '"';
        }

        if (!empty($labelledby)) {
            $attrs[] = 'aria-labelledby="' . esc_attr($labelledby) . '"';
        }

        if (!empty($describedby)) {
            $attrs[] = 'aria-describedby="' . esc_attr($describedby) . '"';
        }

        return implode(' ', $attrs);
    }

    /**
     * Generate ARIA live region attributes
     * 
     * @param string $politeness 'polite', 'assertive', or 'off'.
     * @param bool   $atomic Whether the entire region should be announced.
     * @return string ARIA live attributes.
     */
    public static function get_aria_live_attrs($politeness = 'polite', $atomic = false) {
        $attrs = [];
        
        $attrs[] = 'aria-live="' . esc_attr($politeness) . '"';
        
        if ($atomic) {
            $attrs[] = 'aria-atomic="true"';
        }

        return implode(' ', $attrs);
    }

    /**
     * Generate button accessibility attributes
     * 
     * @param array $args Button configuration.
     * @return string Button attributes.
     */
    public static function get_button_attrs($args = []) {
        $defaults = [
            'label' => '',
            'expanded' => null,
            'controls' => '',
            'haspopup' => false,
            'pressed' => null,
            'disabled' => false
        ];

        $args = wp_parse_args($args, $defaults);
        $attrs = [];

        if (!empty($args['label'])) {
            $attrs[] = 'aria-label="' . esc_attr($args['label']) . '"';
        }

        if (!is_null($args['expanded'])) {
            $attrs[] = 'aria-expanded="' . ($args['expanded'] ? 'true' : 'false') . '"';
        }

        if (!empty($args['controls'])) {
            $attrs[] = 'aria-controls="' . esc_attr($args['controls']) . '"';
        }

        if ($args['haspopup']) {
            $attrs[] = 'aria-haspopup="true"';
        }

        if (!is_null($args['pressed'])) {
            $attrs[] = 'aria-pressed="' . ($args['pressed'] ? 'true' : 'false') . '"';
        }

        if ($args['disabled']) {
            $attrs[] = 'aria-disabled="true"';
            $attrs[] = 'disabled';
        }

        return implode(' ', $attrs);
    }

    /**
     * Generate slider/carousel accessibility attributes
     * 
     * @param array $args Slider configuration.
     * @return array Slider accessibility data.
     */
    public static function get_slider_attrs($args = []) {
        $defaults = [
            'widget_id' => '',
            'slides_count' => 0,
            'autoplay' => false,
            'loop' => false
        ];

        $args = wp_parse_args($args, $defaults);
        
        $container_id = self::generate_id('slider-container', $args['widget_id']);
        $live_region_id = self::generate_id('slider-live-region', $args['widget_id']);

        return [
            'container_id' => $container_id,
            'live_region_id' => $live_region_id,
            'container_attrs' => 'role="region" aria-label="' . esc_attr__('Image carousel', 'promen-elementor-widgets') . '" aria-describedby="' . esc_attr($live_region_id) . '"',
            'live_region_attrs' => self::get_aria_live_attrs('polite', true),
            'prev_button_attrs' => self::get_button_attrs([
                'label' => __('Previous slide', 'promen-elementor-widgets'),
                'controls' => $container_id
            ]),
            'next_button_attrs' => self::get_button_attrs([
                'label' => __('Next slide', 'promen-elementor-widgets'),
                'controls' => $container_id
            ]),
            'play_button_attrs' => self::get_button_attrs([
                'label' => $args['autoplay'] ? __('Pause slideshow', 'promen-elementor-widgets') : __('Play slideshow', 'promen-elementor-widgets'),
                'pressed' => $args['autoplay'],
                'controls' => $container_id
            ])
        ];
    }

    /**
     * Generate menu accessibility attributes
     * 
     * @param array $args Menu configuration.
     * @return array Menu accessibility data.
     */
    public static function get_menu_attrs($args = []) {
        $defaults = [
            'widget_id' => '',
            'expanded' => false,
            'has_submenu' => false
        ];

        $args = wp_parse_args($args, $defaults);
        
        $menu_id = self::generate_id('menu', $args['widget_id']);
        $toggle_id = self::generate_id('menu-toggle', $args['widget_id']);

        return [
            'menu_id' => $menu_id,
            'toggle_id' => $toggle_id,
            'toggle_attrs' => self::get_button_attrs([
                'label' => __('Toggle navigation menu', 'promen-elementor-widgets'),
                'expanded' => $args['expanded'],
                'controls' => $menu_id,
                'haspopup' => $args['has_submenu']
            ]),
            'menu_attrs' => 'role="navigation" aria-labelledby="' . esc_attr($toggle_id) . '"'
        ];
    }

    /**
     * Generate form accessibility attributes
     * 
     * @param array $args Form configuration.
     * @return array Form accessibility data.
     */
    public static function get_form_attrs($args = []) {
        $defaults = [
            'widget_id' => '',
            'required_fields' => [],
            'error_message' => ''
        ];

        $args = wp_parse_args($args, $defaults);
        
        $error_id = self::generate_id('form-error', $args['widget_id']);
        $success_id = self::generate_id('form-success', $args['widget_id']);

        return [
            'error_id' => $error_id,
            'success_id' => $success_id,
            'error_attrs' => 'id="' . esc_attr($error_id) . '" ' . self::get_aria_live_attrs('assertive', true),
            'success_attrs' => 'id="' . esc_attr($success_id) . '" ' . self::get_aria_live_attrs('polite', true),
            'required_indicator' => '<span aria-label="' . esc_attr__('Required field', 'promen-elementor-widgets') . '">*</span>'
        ];
    }

    /**
     * Generate screen reader text
     * 
     * @param string $text The text for screen readers.
     * @param string $tag HTML tag to wrap the text.
     * @return string HTML markup.
     */
    public static function get_screen_reader_text($text, $tag = 'span') {
        return '<' . esc_attr($tag) . ' class="screen-reader-text">' . esc_html($text) . '</' . esc_attr($tag) . '>';
    }

    /**
     * Generate keyboard navigation instructions for screen readers
     * 
     * @param string $component_type Type of component.
     * @return string Instructions HTML.
     */
    public static function get_keyboard_instructions($component_type = 'grid') {
        $instructions = [
            'contact-blocks' => __('Use arrow keys to navigate between contact blocks. Press Enter or Space to activate a link. Press Escape to cancel navigation.', 'promen-elementor-widgets'),
            'slider' => __('Use Left and Right arrow keys to navigate between slides. Press Space to pause or play the slideshow.', 'promen-elementor-widgets'),
            'menu' => __('Use arrow keys to navigate through the menu. Press Enter to select a menu item. Press Escape to close the menu.', 'promen-elementor-widgets'),
            'grid' => __('Use Tab to navigate between items. Press Enter to select an item.', 'promen-elementor-widgets')
        ];
        
        $instruction = $instructions[$component_type] ?? $instructions['grid'];
        
        return '<div class="screen-reader-text keyboard-instructions" role="region" aria-label="' . esc_attr__('Keyboard navigation instructions', 'promen-elementor-widgets') . '">' . esc_html($instruction) . '</div>';
    }
}
