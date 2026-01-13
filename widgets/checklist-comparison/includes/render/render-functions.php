<?php
/**
 * Checklist Comparison Widget Render Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Checklist_Comparison_Render {

    /**
     * Render the widget output on the frontend
     */
    public static function render_widget($widget, $settings) {
        // Generate accessibility attributes
        $widget_id = $widget->get_id();
        $container_id = Promen_Accessibility_Utils::generate_id('checklist-comparison', $widget_id);
        $left_id = Promen_Accessibility_Utils::generate_id('checklist-left', $widget_id);
        $right_id = Promen_Accessibility_Utils::generate_id('checklist-right', $widget_id);
        
        // Start widget container
        echo '<section class="promen-checklist-comparison promen-widget" 
                      id="' . esc_attr($container_id) . '"
                      role="region" 
                      aria-label="' . esc_attr__('Vergelijking van checklist items tussen twee kolommen om verschillen te tonen', 'promen-elementor-widgets') . '">';
        
        // Start comparison container
        echo '<div class="promen-checklist-comparison__container" 
                     aria-label="' . esc_attr__('Inhoud van de vergelijking tussen de twee kolommen met checklist items', 'promen-elementor-widgets') . '">';
        
        // Left column
        self::render_left_column($widget, $settings, $left_id);
        
        // Right column
        self::render_right_column($widget, $settings, $right_id);
        
        // End comparison container
        echo '</div>';
        
        // End widget container
        echo '</section>';
    }
    
    /**
     * Render the left column
     */
    private static function render_left_column($widget, $settings, $column_id) {
        $widget_id = $widget->get_id();
        $heading_id = Promen_Accessibility_Utils::generate_id('left-heading', $widget_id);
        $list_id = Promen_Accessibility_Utils::generate_id('left-checklist', $widget_id);
        
        echo '<aside class="promen-checklist-comparison__column promen-checklist-comparison__column--left" 
                     id="' . esc_attr($column_id) . '"
                     role="complementary" 
                     ' . (!empty($settings['show_left_heading']) && $settings['show_left_heading'] === 'yes' ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : '') . '>';
        
        // Render heading if enabled
        if (!empty($settings['show_left_heading']) && $settings['show_left_heading'] === 'yes') {
            $heading_tag = !empty($settings['left_heading_tag']) ? $settings['left_heading_tag'] : 'h3';
            $heading_text = !empty($settings['left_heading']) ? $settings['left_heading'] : '';
            
            if (!empty($heading_text)) {
                echo '<' . esc_attr($heading_tag) . ' class="promen-checklist-comparison__heading" 
                           id="' . esc_attr($heading_id) . '">' . esc_html($heading_text) . '</' . esc_attr($heading_tag) . '>';
            }
        }
        
        // Render checklist items
        if (!empty($settings['left_checklist_items'])) {
            echo '<ul class="promen-checklist-comparison__items" 
                      id="' . esc_attr($list_id) . '"
                      role="list" 
                      aria-label="' . esc_attr__('Lijst met checklist items in de linker kolom die u kunt vergelijken', 'promen-elementor-widgets') . '">';
            
            foreach ($settings['left_checklist_items'] as $index => $item) {
                $item_text = !empty($item['item_text']) ? $item['item_text'] : '';
                $item_id = Promen_Accessibility_Utils::generate_id('left-item', $widget_id . '-' . $index);
                
                echo '<li class="promen-checklist-comparison__item" 
                          id="' . esc_attr($item_id) . '"
                          role="listitem">';
                
                // Check icon
                echo '<span class="promen-checklist-comparison__item-icon" 
                             role="img" 
                             aria-label="' . esc_attr__('Vinkje dat aangeeft dat dit item is voltooid of beschikbaar', 'promen-elementor-widgets') . '">';
                if (!empty($item['icon_type']) && $item['icon_type'] === 'custom' && !empty($item['selected_icon']['value'])) {
                    // Render custom icon for this specific item
                    \Elementor\Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']);
                } elseif (!empty($settings['custom_default_icon']) && $settings['custom_default_icon'] === 'yes' && !empty($settings['default_icon']['value'])) {
                    // Render global default icon
                    \Elementor\Icons_Manager::render_icon($settings['default_icon'], ['aria-hidden' => 'true']);
                } else {
                    // Render default SVG icon
                    self::render_default_icon();
                }
                echo '</span>';
                
                // Item text
                echo '<span class="promen-checklist-comparison__item-text">' . wp_kses_post($item_text) . '</span>';
                
                echo '</li>';
            }
            
            echo '</ul>';
        }
        
        echo '</aside>';
    }
    
    /**
     * Render the right column
     */
    private static function render_right_column($widget, $settings, $column_id) {
        $widget_id = $widget->get_id();
        $heading_id = Promen_Accessibility_Utils::generate_id('right-heading', $widget_id);
        $list_id = Promen_Accessibility_Utils::generate_id('right-checklist', $widget_id);
        
        echo '<aside class="promen-checklist-comparison__column promen-checklist-comparison__column--right" 
                     id="' . esc_attr($column_id) . '"
                     role="complementary" 
                     ' . (!empty($settings['show_right_heading']) && $settings['show_right_heading'] === 'yes' ? 'aria-labelledby="' . esc_attr($heading_id) . '"' : '') . '>';
        
        // Render heading if enabled
        if (!empty($settings['show_right_heading']) && $settings['show_right_heading'] === 'yes') {
            $heading_tag = !empty($settings['right_heading_tag']) ? $settings['right_heading_tag'] : 'h3';
            $heading_text = !empty($settings['right_heading']) ? $settings['right_heading'] : '';
            
            if (!empty($heading_text)) {
                echo '<' . esc_attr($heading_tag) . ' class="promen-checklist-comparison__heading" 
                           id="' . esc_attr($heading_id) . '">' . esc_html($heading_text) . '</' . esc_attr($heading_tag) . '>';
            }
        }
        
        // Render checklist items
        if (!empty($settings['right_checklist_items'])) {
            echo '<ul class="promen-checklist-comparison__items" 
                      id="' . esc_attr($list_id) . '"
                      role="list" 
                      aria-label="' . esc_attr__('Lijst met checklist items in de rechter kolom die u kunt vergelijken', 'promen-elementor-widgets') . '">';
            
            foreach ($settings['right_checklist_items'] as $index => $item) {
                $item_text = !empty($item['item_text']) ? $item['item_text'] : '';
                $item_id = Promen_Accessibility_Utils::generate_id('right-item', $widget_id . '-' . $index);
                
                echo '<li class="promen-checklist-comparison__item" 
                          id="' . esc_attr($item_id) . '"
                          role="listitem">';
                
                // Check icon
                echo '<span class="promen-checklist-comparison__item-icon" 
                             role="img" 
                             aria-label="' . esc_attr__('Vinkje dat aangeeft dat dit item is voltooid of beschikbaar', 'promen-elementor-widgets') . '">';
                if (!empty($item['icon_type']) && $item['icon_type'] === 'custom' && !empty($item['selected_icon']['value'])) {
                    // Render custom icon for this specific item
                    \Elementor\Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']);
                } elseif (!empty($settings['custom_default_icon']) && $settings['custom_default_icon'] === 'yes' && !empty($settings['default_icon']['value'])) {
                    // Render global default icon
                    \Elementor\Icons_Manager::render_icon($settings['default_icon'], ['aria-hidden' => 'true']);
                } else {
                    // Render default SVG icon
                    self::render_default_icon();
                }
                echo '</span>';
                
                // Item text
                echo '<span class="promen-checklist-comparison__item-text">' . wp_kses_post($item_text) . '</span>';
                
                echo '</li>';
            }
            
            echo '</ul>';
        }
        
        echo '</aside>';
    }
    
    /**
     * Render default SVG icon
     */
    private static function render_default_icon() {
        echo '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor"><path d="M0 0h24v24H0z" fill="none"/><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>';
    }
} 