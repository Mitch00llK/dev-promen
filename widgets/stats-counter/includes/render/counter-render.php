<?php
/**
 * Stats Counter Widget Render
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the Stats Counter widget
 */
function render_stats_counter_widget($widget) {
    $settings = $widget->get_settings_for_display();
    
    $widget->add_render_attribute('container', 'class', 'promen-stats-counter-container');
    
    // CRITICAL: Never set role="listbox" in PHP - only JavaScript should set it after validation
    // This prevents ARIA validation errors if items are missing
    // The JavaScript will add the listbox role only when option children are confirmed
    
    // Add animation data attributes if enabled
    if ($settings['enable_animation'] === 'yes') {
        $widget->add_render_attribute('container', 'data-animation', 'true');
        $widget->add_render_attribute('container', 'data-animation-duration', $settings['animation_duration']);
    }
    
    // Add accessibility attributes
    $widget->add_render_attribute('container', 'data-announce-changes', $settings['announce_counter_changes'] === 'yes' ? 'true' : 'false');
    $widget->add_render_attribute('container', 'data-respect-motion', $settings['respect_reduced_motion'] === 'yes' ? 'true' : 'false');
    $widget->add_render_attribute('container', 'data-pause-on-focus', $settings['pause_animation_on_focus'] === 'yes' ? 'true' : 'false');
    ?>
    <?php
    // Pre-process counter items - ensure we have valid items before rendering
    $counter_items = isset($settings['counter_items']) && is_array($settings['counter_items']) ? $settings['counter_items'] : [];
    $visible_items = [];
    
    // Pre-filter to get actual visible items with proper validation
    foreach ($counter_items as $index => $item) {
        // Check if item should be shown and has required data
        if (isset($item['show_counter']) && 
            $item['show_counter'] === 'yes' && 
            is_array($item) &&
            (isset($item['counter_number']) || isset($item['counter_title']))) {
            $visible_items[] = ['index' => $index, 'item' => $item];
        }
    }
    $visible_count = count($visible_items);
    $has_items = $visible_count > 0;
    ?>
    <section class="promen-stats-counter-wrapper" 
             role="region" 
             aria-label="<?php echo esc_attr($settings['stats_aria_label'] ?: __('Statistieken en cijfers die onze prestaties en resultaten tonen', 'promen-elementor-widgets')); ?>">
        <?php if ($has_items) : ?>
        <!-- Skip link for keyboard navigation -->
        <a href="#<?php echo esc_attr('stats-container-' . $widget->get_id_int()); ?>" class="promen-stats-counter-skip-link">
            <?php echo esc_html__('Sla over naar inhoud', 'promen-elementor-widgets'); ?>
        </a>
        <?php endif; ?>
        
        <?php if ($settings['show_section_title'] === 'yes') : ?>
            <header class="promen-stats-counter-section-title-wrapper">
                <?php echo promen_render_split_title($widget, $settings, 'section_title', 'promen-stats-counter'); ?>
            </header>
        <?php endif; ?>
        
        <?php if ($has_items) : ?>
        <?php 
        // Pre-render items to count actual rendered items
        $visible_index = 0;
        $rendered_count = 0;
        $items_to_render = [];
        
        foreach ($visible_items as $visible_data) :
            $index = $visible_data['index'];
            $item = $visible_data['item'];
            
            // Validate item has required data before rendering
            if (!isset($item['counter_number']) && !isset($item['counter_title'])) {
                continue; // Skip invalid items
            }
            
            $visible_index++;
            $rendered_count++;
            
            $item_id = 'stats-item-' . $widget->get_id_int() . '-' . $index;
            $announcement_id = $item_id . '-announcement';
            
            $items_to_render[] = [
                'index' => $visible_index,
                'item' => $item,
                'item_id' => $item_id,
                'announcement_id' => $announcement_id,
                'count' => $rendered_count
            ];
        endforeach;
        
        // Only render container if we have items with role="option" to avoid ARIA validation errors
        if ($rendered_count > 0) :
        ?>
        <div <?php echo $widget->get_render_attribute_string('container'); ?> 
             id="<?php echo esc_attr('stats-container-' . $widget->get_id_int()); ?>"
             class="no-js-fallback"
             data-stats-count="<?php echo esc_attr($rendered_count); ?>">
            <?php 
            foreach ($items_to_render as $item_data) :
            ?>
                <div class="promen-stats-counter-item" 
                     role="option"
                     tabindex="<?php echo $item_data['index'] === 1 ? '0' : '-1'; ?>"
                     aria-posinset="<?php echo $item_data['index']; ?>"
                     aria-setsize="<?php echo $rendered_count; ?>"
                     aria-selected="<?php echo $item_data['index'] === 1 ? 'true' : 'false'; ?>"
                     aria-labelledby="<?php echo esc_attr($item_data['item_id'] . '-title'); ?>"
                     aria-describedby="<?php echo esc_attr($item_data['announcement_id']); ?>">
                    <div class="promen-counter-circle" 
                         role="img" 
                         aria-label="<?php echo esc_attr(sprintf(__('Counter showing %d', 'promen-elementor-widgets'), $item_data['item']['counter_number'] ?? 0)); ?>">
                        <div class="promen-counter-number" 
                             data-count="<?php echo esc_attr($item_data['item']['counter_number'] ?? 0); ?>"
                             aria-live="polite"
                             aria-atomic="true"
                             id="<?php echo esc_attr($item_data['announcement_id']); ?>">
                            <?php echo esc_html($item_data['item']['counter_number'] ?? 0); ?>
                        </div>
                    </div>
                    <h3 class="promen-counter-title" id="<?php echo esc_attr($item_data['item_id'] . '-title'); ?>">
                        <?php echo esc_html($item_data['item']['counter_title'] ?? ''); ?>
                    </h3>
                </div>
            <?php 
            endforeach;
            ?>
        </div>
        <?php endif; // $rendered_count > 0 ?>
        <?php else : ?>
        <!-- No counter items to display - container not rendered to avoid empty listbox -->
        <?php endif; ?>
        
        <!-- Screen reader announcements -->
        <div class="sr-only" 
             aria-live="polite" 
             aria-atomic="true" 
             id="<?php echo esc_attr('stats-announcements-' . $widget->get_id_int()); ?>"></div>
    </section>
    <?php
} 