<?php
/**
 * Text Column Repeater Widget Render Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Text_Column_Repeater_Render {

    /**
     * Render the widget output on the frontend
     */
    public static function render_widget($widget, $settings) {
        // Generate unique IDs for accessibility
        $widget_id = $widget->get_id();
        $heading_id = Promen_Accessibility_Utils::generate_id('text-column-repeater-heading');
        $subtitle_id = Promen_Accessibility_Utils::generate_id('text-column-repeater-subtitle');
        $content_id = Promen_Accessibility_Utils::generate_id('text-column-repeater-content');
        
        // Start widget container
        echo '<section class="text-column-repeater" 
                     role="region" 
                     aria-labelledby="' . esc_attr($heading_id) . '" 
                     aria-describedby="' . esc_attr($subtitle_id) . '"
                     aria-label="' . esc_attr__('Herhalende tekstkolommen met informatie die u kunt bekijken', 'promen-elementor-widgets') . '">';
        
        // Render heading section
        self::render_heading_section($widget, $settings, $heading_id, $subtitle_id);
        
        // Render tool items
        self::render_tool_items($widget, $settings, $content_id);
        
        // End widget container
        echo '</section>';
    }

    /**
     * Render the heading section
     */
    private static function render_heading_section($widget, $settings, $heading_id, $subtitle_id) {
        // Check if heading is enabled
        if (empty($settings['show_heading']) || $settings['show_heading'] !== 'yes') {
            return;
        }
        
        // Get heading tag
        $heading_tag = !empty($settings['heading_tag']) ? $settings['heading_tag'] : 'h2';
        
        // Render heading
        echo '<header class="text-column-repeater__header" id="' . esc_attr($heading_id) . '">';
        
        // Render heading
        echo '<' . esc_html($heading_tag) . ' class="text-column-repeater__heading">';
        
        if (!empty($settings['enable_split_heading']) && $settings['enable_split_heading'] === 'yes') {
            // Render split heading
            if (!empty($settings['split_text_before'])) {
                echo '<span class="light">' . esc_html($settings['split_text_before']) . '</span>';
            }
            
            if (!empty($settings['split_text_after'])) {
                echo '<span class="bold">' . esc_html($settings['split_text_after']) . '</span>';
            }
        } else {
            // Render regular heading
            if (!empty($settings['heading_text'])) {
                echo esc_html($settings['heading_text']);
            }
        }
        
        echo '</' . esc_html($heading_tag) . '>';
        
        // Render subtitle if enabled
        if (!empty($settings['show_subtitle']) && $settings['show_subtitle'] === 'yes' && !empty($settings['subtitle_text'])) {
            $subtitle_text = $settings['subtitle_text'];
            $max_chars = !empty($settings['subtitle_max_chars']) ? (int) $settings['subtitle_max_chars'] : 100;
            
            echo '<p class="text-column-repeater__subtitle" id="' . esc_attr($subtitle_id) . '">';
            echo esc_html($subtitle_text);
            echo '<span class="text-column-repeater__char-limit">&lt; max ' . esc_html($max_chars) . ' tekens &gt;</span>';
            echo '</p>';
        }
        
        echo '</header>';
    }

    /**
     * Render the tool items
     */
    private static function render_tool_items($widget, $settings, $content_id) {
        // Check if there are tool items
        if (empty($settings['tool_items']) || !is_array($settings['tool_items'])) {
            return;
        }
        
        // Get columns setting
        $columns = !empty($settings['columns']) ? $settings['columns'] : 2;
        
        // Start grid container
        echo '<div class="text-column-repeater__grid" 
                     role="list" 
                     aria-label="' . esc_attr__('Lijst met tekstkolommen die u kunt bekijken voor meer informatie', 'promen-elementor-widgets') . '"
                     id="' . esc_attr($content_id) . '">';
        
        // Loop through tool items
        foreach ($settings['tool_items'] as $index => $item) {
            // Generate unique IDs for accessibility
            $item_id = Promen_Accessibility_Utils::generate_id('text-column-item-' . ($index + 1));
            $item_title_id = Promen_Accessibility_Utils::generate_id('text-column-title-' . ($index + 1));
            $item_description_id = Promen_Accessibility_Utils::generate_id('text-column-description-' . ($index + 1));
            
            // Start tool item
            echo '<article class="text-column-repeater__item" 
                           role="listitem" 
                           tabindex="0"
                           aria-labelledby="' . esc_attr($item_title_id) . '"
                           aria-describedby="' . esc_attr($item_description_id) . '"
                           id="' . esc_attr($item_id) . '">';
            
            // Render tool title if enabled
            if (!empty($item['show_tool_title']) && $item['show_tool_title'] === 'yes' && !empty($item['tool_title'])) {
                $title_tag = !empty($item['tool_title_tag']) ? $item['tool_title_tag'] : 'h3';
                
                echo '<' . esc_html($title_tag) . ' class="text-column-repeater__item-title" id="' . esc_attr($item_title_id) . '">';
                echo esc_html($item['tool_title']);
                echo '</' . esc_html($title_tag) . '>';
            }
            
            // Render tool description if enabled
            if (!empty($item['show_tool_description']) && $item['show_tool_description'] === 'yes' && !empty($item['tool_description'])) {
                $description = $item['tool_description'];
                $max_chars = !empty($item['description_max_chars']) ? (int) $item['description_max_chars'] : 200;
                
                echo '<div class="text-column-repeater__item-description" id="' . esc_attr($item_description_id) . '">';
                echo '<p>' . esc_html($description) . '</p>';
                echo '<span class="text-column-repeater__char-limit">&lt; max ' . esc_html($max_chars) . ' tekens &gt;</span>';
                echo '</div>';
            }
            
            // End tool item
            echo '</article>';
        }
        
        // End grid container
        echo '</div>';
    }
} 