<?php
/**
 * Solicitation Timeline Widget Render Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Solicitation_Timeline_Render {

    /**
     * Render the widget output on the frontend
     */
    public static function render_widget($widget, $settings) {
        // Start widget container
        echo '<div class="solicitation-timeline">';
        
        // Start two-column layout
        echo '<div class="solicitation-timeline__container">';
        
        // Left column - Text content
        echo '<div class="solicitation-timeline__text-column">';
        
        // Render heading section
        self::render_heading_section($widget, $settings);
        
        echo '</div>'; // End text column
        
        // Right column - Timeline
        echo '<div class="solicitation-timeline__timeline-column">';
        
        // Render timeline steps
        self::render_timeline_steps($widget, $settings);
        
        echo '</div>'; // End timeline column
        
        echo '</div>'; // End two-column container
        
        // End widget container
        echo '</div>';
    }

    /**
     * Render the heading section
     */
    private static function render_heading_section($widget, $settings) {
        // Check if heading is enabled
        if (empty($settings['show_heading']) || $settings['show_heading'] !== 'yes') {
            return;
        }
        
        // Render intro text if enabled
        if (!empty($settings['show_intro_text']) && $settings['show_intro_text'] === 'yes' && !empty($settings['intro_text'])) {
            echo '<p class="solicitation-timeline__intro-text">' . esc_html($settings['intro_text']) . '</p>';
        }
        
        // Get heading tag
        $heading_tag = !empty($settings['heading_tag']) ? $settings['heading_tag'] : 'h2';
        
        // Render heading
        echo '<' . esc_html($heading_tag) . ' class="solicitation-timeline__heading">';
        
        if (!empty($settings['enable_split_heading']) && $settings['enable_split_heading'] === 'yes') {
            // Render split heading
            if (!empty($settings['split_text_before'])) {
                echo '<span class="light">' . esc_html($settings['split_text_before']) . '</span> ';
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
    }

    /**
     * Render the timeline steps
     */
    private static function render_timeline_steps($widget, $settings) {
        // Check if there are timeline steps
        if (empty($settings['timeline_steps']) || !is_array($settings['timeline_steps'])) {
            return;
        }
        
        // Start timeline container
        echo '<div class="solicitation-timeline__steps">';
        
        // Loop through timeline steps
        foreach ($settings['timeline_steps'] as $index => $step) {
            $is_last_step = ($index === count($settings['timeline_steps']) - 1);
            
            // Start step container
            echo '<div class="solicitation-timeline__step">';
            
            // Render step marker and line
            echo '<div class="solicitation-timeline__step-marker-container">';
            echo '<div class="solicitation-timeline__marker"></div>';
            
            // Only render the line if it's not the last step
            if (!$is_last_step) {
                echo '<div class="solicitation-timeline__line"></div>';
            }
            
            echo '</div>';
            
            // Start step content
            echo '<div class="solicitation-timeline__step-content">';
            
            // Render step number
            if (!empty($step['step_number'])) {
                echo '<div class="solicitation-timeline__step-number">' . esc_html($step['step_number']) . '</div>';
            }
            
            // Render step title if enabled
            if (!empty($step['show_step_title']) && $step['show_step_title'] === 'yes' && !empty($step['step_title'])) {
                $title_tag = !empty($step['step_title_tag']) ? $step['step_title_tag'] : 'h3';
                echo '<' . esc_html($title_tag) . ' class="solicitation-timeline__step-title">' . esc_html($step['step_title']) . '</' . esc_html($title_tag) . '>';
            }
            
            // Render step description if enabled
            if (!empty($step['show_step_description']) && $step['show_step_description'] === 'yes' && !empty($step['step_description'])) {
                echo '<p class="solicitation-timeline__step-description">' . esc_html($step['step_description']) . '</p>';
            }
            
            // End step content
            echo '</div>';
            
            // End step container
            echo '</div>';
        }
        
        // End timeline container
        echo '</div>';
    }
} 