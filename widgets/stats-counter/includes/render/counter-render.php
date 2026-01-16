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
    <section class="promen-stats-counter-wrapper" 
             role="region" 
             aria-label="<?php echo esc_attr($settings['stats_aria_label'] ?: __('Statistieken en cijfers die onze prestaties en resultaten tonen', 'promen-elementor-widgets')); ?>">
        <!-- Skip link for keyboard navigation -->
        <a href="#<?php echo esc_attr('stats-container-' . $widget->get_id_int()); ?>" class="promen-stats-counter-skip-link">
            <?php echo esc_html__('Sla over naar inhoud', 'promen-elementor-widgets'); ?>
        </a>
        
        <?php if ($settings['show_section_title'] === 'yes') : ?>
            <header class="promen-stats-counter-section-title-wrapper">
                <?php echo promen_render_split_title($widget, $settings, 'section_title', 'promen-stats-counter'); ?>
            </header>
        <?php endif; ?>
        
        <?php
        // Count visible counter items
        $visible_items = array_filter($settings['counter_items'] ?? [], function($item) {
            return isset($item['show_counter']) && $item['show_counter'] === 'yes';
        });
        $has_items = !empty($visible_items);
        ?>
        
        <div <?php echo $widget->get_render_attribute_string('container'); ?> 
             id="<?php echo esc_attr('stats-container-' . $widget->get_id_int()); ?>"
             class="no-js-fallback"
             <?php if ($has_items) : ?>role="listbox" aria-orientation="horizontal" aria-label="<?php echo esc_attr__('Statistics navigation - use arrow keys to navigate', 'promen-elementor-widgets'); ?>"<?php endif; ?>>
            <?php 
            $visible_index = 0;
            foreach ($settings['counter_items'] as $index => $item) : 
                if ($item['show_counter'] !== 'yes') continue;
                
                $item_id = 'stats-item-' . $widget->get_id_int() . '-' . $index;
                $announcement_id = $item_id . '-announcement';
                $visible_index++;
            ?>
                <div class="promen-stats-counter-item" 
                     role="option"
                     tabindex="<?php echo $visible_index === 1 ? '0' : '-1'; ?>"
                     aria-posinset="<?php echo $visible_index; ?>"
                     aria-setsize="<?php echo count($visible_items); ?>"
                     aria-selected="<?php echo $visible_index === 1 ? 'true' : 'false'; ?>"
                     aria-labelledby="<?php echo esc_attr($item_id . '-title'); ?>"
                     aria-describedby="<?php echo esc_attr($announcement_id); ?>">
                    <div class="promen-counter-circle" 
                         role="img" 
                         aria-label="<?php echo esc_attr(sprintf(__('Counter showing %d', 'promen-elementor-widgets'), $item['counter_number'])); ?>">
                        <div class="promen-counter-number" 
                             data-count="<?php echo esc_attr($item['counter_number']); ?>"
                             aria-live="polite"
                             aria-atomic="true"
                             id="<?php echo esc_attr($announcement_id); ?>">
                            <?php echo esc_html($item['counter_number']); ?>
                        </div>
                    </div>
                    <h3 class="promen-counter-title" id="<?php echo esc_attr($item_id . '-title'); ?>">
                        <?php echo esc_html($item['counter_title']); ?>
                    </h3>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Screen reader announcements -->
        <div class="sr-only" 
             aria-live="polite" 
             aria-atomic="true" 
             id="<?php echo esc_attr('stats-announcements-' . $widget->get_id_int()); ?>"></div>
    </section>
    <?php
} 