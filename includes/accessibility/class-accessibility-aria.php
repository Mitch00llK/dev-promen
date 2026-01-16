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
            'container_attrs' => 'role="region" aria-label="' . esc_attr__('Afbeeldingen carrousel', 'promen-elementor-widgets') . '" aria-describedby="' . esc_attr($live_region_id) . '"',
            'live_region_attrs' => self::get_aria_live_attrs('polite', true),
            'prev_button_attrs' => self::get_button_attrs([
                'label' => __('Vorige dia', 'promen-elementor-widgets'),
                'controls' => $container_id
            ]),
            'next_button_attrs' => self::get_button_attrs([
                'label' => __('Volgende dia', 'promen-elementor-widgets'),
                'controls' => $container_id
            ]),
            'play_button_attrs' => self::get_button_attrs([
                'label' => $args['autoplay'] ? __('Diavoorstelling pauzeren', 'promen-elementor-widgets') : __('Diavoorstelling afspelen', 'promen-elementor-widgets'),
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
                'label' => __('Navigatiemenu wisselen', 'promen-elementor-widgets'),
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
            'required_indicator' => '<span aria-label="' . esc_attr__('Verplicht veld', 'promen-elementor-widgets') . '">*</span>'
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
            'contact-blocks' => __('Gebruik de pijltjestoetsen om tussen contactblokken te navigeren. Druk op Enter of Spatie om een link te activeren. Druk op Escape om navigatie te annuleren.', 'promen-elementor-widgets'),
            'slider' => __('Gebruik de linker- en rechterpijltjestoetsen om tussen dia\'s te navigeren. Druk op Spatie om de diavoorstelling te pauzeren of af te spelen.', 'promen-elementor-widgets'),
            'menu' => __('Gebruik de pijltjestoetsen om door het menu te navigeren. Druk op Enter om een menu-item te selecteren. Druk op Escape om het menu te sluiten.', 'promen-elementor-widgets'),
            'grid' => __('Gebruik Tab om tussen items te navigeren. Druk op Enter om een item te selecteren.', 'promen-elementor-widgets')
        ];
        
        $instruction = $instructions[$component_type] ?? $instructions['grid'];
        
        return '<div class="screen-reader-text keyboard-instructions" role="region" aria-label="' . esc_attr__('Instructies voor toetsenbordnavigatie', 'promen-elementor-widgets') . '">' . esc_html($instruction) . '</div>';
    }

    /**
     * Generate service accessibility attributes
     * 
     * @param array  $service Service data.
     * @param int    $index Service index.
     * @param string $widget_id Widget ID.
     * @return array Service accessibility data.
     */
    public static function get_service_attrs($service, $index = 0, $widget_id = '') {
        $service_title = !empty($service['service_title']) ? $service['service_title'] : '';
        $service_description = !empty($service['service_description']) ? $service['service_description'] : '';
        $service_link = !empty($service['service_link']['url']) ? $service['service_link']['url'] : '';
        
        $service_item_id = self::generate_id('service-item-' . ($index + 1), $widget_id);
        $service_title_id = self::generate_id('service-title-' . ($index + 1), $widget_id);
        $service_description_id = self::generate_id('service-description-' . ($index + 1), $widget_id);
        $service_icon_id = self::generate_id('service-icon-' . ($index + 1), $widget_id);
        
        $base_label = $service_title;
        $link_label = $service_title;
        $icon_label = $service_title;
        
        if (!empty($service_link)) {
            $link_label = sprintf(__('Lees meer over %s', 'promen-elementor-widgets'), $service_title);
        }
        
        if (!empty($service['service_icon']['value'])) {
            $icon_label = sprintf(__('%s icoon', 'promen-elementor-widgets'), $service_title);
        }
        
        if (!empty($service_description)) {
            $base_label = sprintf(__('%s: %s', 'promen-elementor-widgets'), $service_title, $service_description);
        }
        
        return [
            'service_item_id' => $service_item_id,
            'service_title_id' => $service_title_id,
            'service_description_id' => $service_description_id,
            'service_icon_id' => $service_icon_id,
            'service_item_attrs' => 'role="listitem" tabindex="0" aria-labelledby="' . esc_attr($service_title_id) . '"' . (!empty($service_description_id) ? ' aria-describedby="' . esc_attr($service_description_id) . '"' : ''),
            'service_link_attrs' => 'aria-label="' . esc_attr($link_label) . '"',
            'service_icon_attrs' => 'role="img" aria-label="' . esc_attr($icon_label) . '"',
            'service_title_attrs' => 'id="' . esc_attr($service_title_id) . '"',
            'service_description_attrs' => 'id="' . esc_attr($service_description_id) . '"',
            'service_icon_id_attr' => 'id="' . esc_attr($service_icon_id) . '"',
            'base_label' => $base_label,
            'link_label' => $link_label,
            'icon_label' => $icon_label
        ];
    }

    /**
     * Generate services grid accessibility attributes
     * 
     * @param array  $services Services array.
     * @param string $widget_id Widget ID.
     * @return array Services grid accessibility data.
     */
    public static function get_services_grid_attrs($services, $widget_id = '') {
        $services_count = count($services);
        $services_id = self::generate_id('services-grid-list', $widget_id);
        $services_label = sprintf(
            _n('Diensten rooster met %d dienst', 'Diensten rooster met %d diensten', $services_count, 'promen-elementor-widgets'),
            $services_count
        );
        
        // Only apply role="list" if there are services
        $role_attr = $services_count > 0 ? 'role="list" aria-label="' . esc_attr($services_label) . '"' : '';
        
        return [
            'services_id' => $services_id,
            'services_attrs' => $role_attr . ' id="' . esc_attr($services_id) . '"',
            'services_count' => $services_count
        ];
    }

    /**
     * Generate image slider accessibility attributes
     * 
     * @param array  $images Images array.
     * @param int    $index Image index.
     * @param string $widget_id Widget ID.
     * @return array Image accessibility data.
     */
    public static function get_image_slider_attrs($images, $index = 0, $widget_id = '') {
        $image = $images[$index] ?? [];
        $image_title = !empty($image['title']) ? $image['title'] : '';
        $image_description = !empty($image['description']) ? $image['description'] : '';
        $image_alt = !empty($image['image']['alt']) ? $image['image']['alt'] : $image_title;
        
        $image_item_id = self::generate_id('image-item-' . ($index + 1), $widget_id);
        $image_title_id = self::generate_id('image-title-' . ($index + 1), $widget_id);
        $image_description_id = self::generate_id('image-description-' . ($index + 1), $widget_id);
        
        $base_label = $image_title;
        $image_label = $image_title;
        
        if (!empty($image_title)) {
            $image_label = sprintf(__('Afbeelding: %s', 'promen-elementor-widgets'), $image_title);
        }
        
        if (!empty($image_description)) {
            $base_label = sprintf(__('%s: %s', 'promen-elementor-widgets'), $image_title, $image_description);
        }
        
        return [
            'image_item_id' => $image_item_id,
            'image_title_id' => $image_title_id,
            'image_description_id' => $image_description_id,
            'image_item_attrs' => 'role="listitem" tabindex="0" aria-labelledby="' . esc_attr($image_title_id) . '"' . (!empty($image_description_id) ? ' aria-describedby="' . esc_attr($image_description_id) . '"' : ''),
            'image_attrs' => 'alt="' . esc_attr($image_alt) . '" aria-label="' . esc_attr($image_label) . '"',
            'image_title_attrs' => 'id="' . esc_attr($image_title_id) . '"',
            'image_description_attrs' => 'id="' . esc_attr($image_description_id) . '"',
            'base_label' => $base_label,
            'image_label' => $image_label
        ];
    }

    /**
     * Generate image slider container accessibility attributes
     * 
     * @param array  $images Images array.
     * @param string $widget_id Widget ID.
     * @param bool   $is_slider Whether it's a slider or grid.
     * @return array Image slider accessibility data.
     */
    public static function get_image_slider_container_attrs($images, $widget_id = '', $is_slider = false) {
        $images_count = count($images);
        $container_id = self::generate_id($is_slider ? 'image-slider-container' : 'image-grid-container', $widget_id);
        
        if ($is_slider) {
            $container_label = sprintf(
                _n('Afbeeldingen slider met %d afbeelding', 'Afbeeldingen slider met %d afbeeldingen', $images_count, 'promen-elementor-widgets'),
                $images_count
            );
            $container_attrs = 'role="region" aria-label="' . esc_attr($container_label) . '" aria-live="polite"';
        } else {
            $container_label = sprintf(
                _n('Afbeeldingen rooster met %d afbeelding', 'Afbeeldingen rooster met %d afbeeldingen', $images_count, 'promen-elementor-widgets'),
                $images_count
            );
            $container_attrs = 'role="list" aria-label="' . esc_attr($container_label) . '"';
        }
        
        return [
            'container_id' => $container_id,
            'container_attrs' => $container_attrs . ' id="' . esc_attr($container_id) . '"',
            'images_count' => $images_count
        ];
    }
}
