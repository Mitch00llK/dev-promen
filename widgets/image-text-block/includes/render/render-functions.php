<?php
/**
 * Image Text Block Widget Render Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Image_Text_Block_Render {

    /**
     * Render the widget output on the frontend
     */
    public static function render_widget($widget, $settings) {
        // Get responsive classes
        $responsive_classes = self::get_responsive_classes($widget);
        
        // Get layout class
        $layout_class = !empty($settings['layout']) ? $settings['layout'] : 'image-left';
        $layout_class_formatted = str_replace('image-', 'promen-image-text-block--', $layout_class);
        
        // Get responsive stacking classes
        $responsive_stacking_classes = self::get_responsive_stacking_classes($settings);

        // Render based on display mode
        if ($settings['display_mode'] === 'tabs') {
            self::render_tabs($widget, $settings, $responsive_classes, $layout_class, $layout_class_formatted, $responsive_stacking_classes);
        } else {
            self::render_normal($widget, $settings, $responsive_classes, $layout_class, $layout_class_formatted, $responsive_stacking_classes);
        }
    }

    /**
     * Get responsive classes for the widget
     */
    private static function get_responsive_classes($widget) {
        $breakpoints = \Elementor\Plugin::$instance->breakpoints->get_breakpoints();
        
        return [
            'mobile' => 'elementor-hidden-' . $breakpoints['mobile']->get_name(),
            'tablet' => 'elementor-hidden-' . $breakpoints['tablet']->get_name(),
            'desktop' => 'elementor-hidden-desktop',
        ];
    }
    
    /**
     * Get responsive stacking classes based on settings
     */
    private static function get_responsive_stacking_classes($settings) {
        $classes = [];
        
        if ($settings['display_mode'] === 'tabs') {
            if (!empty($settings['tab_stack_on_tablet']) && $settings['tab_stack_on_tablet'] === 'yes') {
                $classes[] = 'stack-on-tablet';
                
                // Add tablet image order classes
                if (!empty($settings['tab_tablet_image_order'])) {
                    if ($settings['tab_tablet_image_order'] === 'first') {
                        $classes[] = 'tablet-image-first';
                    } elseif ($settings['tab_tablet_image_order'] === 'last') {
                        $classes[] = 'tablet-image-last';
                    }
                }
            }
            
            if (!empty($settings['tab_stack_on_mobile']) && $settings['tab_stack_on_mobile'] === 'yes') {
                $classes[] = 'stack-on-mobile';
                
                // Add mobile image order classes
                if (!empty($settings['tab_mobile_image_order'])) {
                    if ($settings['tab_mobile_image_order'] === 'first') {
                        $classes[] = 'mobile-image-first';
                    } elseif ($settings['tab_mobile_image_order'] === 'last') {
                        $classes[] = 'mobile-image-last';
                    }
                }
            }
        } else {
            if (!empty($settings['stack_on_tablet']) && $settings['stack_on_tablet'] === 'yes') {
                $classes[] = 'stack-on-tablet';
                
                // Add tablet image order classes
                if (!empty($settings['tablet_image_order'])) {
                    if ($settings['tablet_image_order'] === 'first') {
                        $classes[] = 'tablet-image-first';
                    } elseif ($settings['tablet_image_order'] === 'last') {
                        $classes[] = 'tablet-image-last';
                    }
                }
            }
            
            if (!empty($settings['stack_on_mobile']) && $settings['stack_on_mobile'] === 'yes') {
                $classes[] = 'stack-on-mobile';
                
                // Add mobile image order classes
                if (!empty($settings['mobile_image_order'])) {
                    if ($settings['mobile_image_order'] === 'first') {
                        $classes[] = 'mobile-image-first';
                    } elseif ($settings['mobile_image_order'] === 'last') {
                        $classes[] = 'mobile-image-last';
                    }
                }
            }
        }
        
        return implode(' ', $classes);
    }

    /**
     * Render normal mode (image and text)
     */
    private static function render_normal($widget, $settings, $responsive_classes, $layout_class, $layout_class_formatted, $responsive_stacking_classes) {
        $image_url = !empty($settings['image']['url']) ? $settings['image']['url'] : '';
        $image_alt = !empty($settings['image']['alt']) ? $settings['image']['alt'] : '';
        $title = $settings['title'];
        $description = $settings['description'];
        $button_text = $settings['button_text'];
        $button_url = !empty($settings['button_url']['url']) ? $settings['button_url']['url'] : '#';
        $button_target = !empty($settings['button_url']['is_external']) ? ' target="_blank"' : '';
        $button_nofollow = !empty($settings['button_url']['nofollow']) ? ' rel="nofollow"' : '';
        $split_title = $settings['split_title'];
        $title_split_position = $settings['title_split_position'];
        $show_button = isset($settings['show_button']) ? $settings['show_button'] : 'yes';

        // Classes
        $container_class = 'promen-image-text-block';
        $container_class .= ' ' . $layout_class_formatted;
        $container_class .= ' ' . $layout_class; // Add this class for CSS compatibility
        $container_class .= ' ' . $responsive_stacking_classes; // Add responsive stacking classes
        
        // Generate unique ID for the widget
        $widget_id = 'promen-image-text-block-' . uniqid();
        
        // Start output with semantic HTML
        ?>
        <section class="<?php echo esc_attr($container_class); ?>" id="<?php echo esc_attr($widget_id); ?>" role="region" aria-labelledby="<?php echo esc_attr($widget_id); ?>-title">
            <div class="promen-image-text-block__container promen-image-text-container">
                <figure class="promen-image-text-block__image-wrapper promen-image-text-image-wrapper">
                    <div class="promen-image-text-block__image promen-image-text-image">
                        <?php if (!empty($image_url)) : ?>
                            <img src="<?php echo esc_url($image_url); ?>" 
                                 alt="<?php echo esc_attr($image_alt ?: 'Content image'); ?>"
                                 loading="lazy"
                                 decoding="async">
                        <?php endif; ?>
                    </div>
                </figure>
                
                <div class="promen-image-text-block__content-wrapper promen-image-text-content-wrapper">
                    <article class="promen-image-text-block__content">
                        <header class="promen-image-text-block__title-wrapper">
                            <?php echo promen_render_split_title($widget, $settings, 'title', 'promen'); ?>
                        </header>
                        
                        <?php if (!empty($description)) : ?>
                            <div class="promen-image-text-block__description promen-image-text-description">
                                <?php echo wp_kses_post($description); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($button_text) && $show_button === 'yes') : ?>
                            <footer class="promen-image-text-block__button-wrapper">
                                <a href="<?php echo esc_url($button_url); ?>" 
                                   class="promen-image-text-block__button promen-image-text-button"
                                   role="button"
                                   aria-label="<?php echo esc_attr($button_text . ($button_target ? ' (opent in een nieuw tabblad)' : '')); ?>"
                                   <?php echo $button_target . $button_nofollow; ?>>
                                    <span class="promen-image-text-block__button-text"><?php echo esc_html($button_text); ?></span>
                                    <span class="promen-image-text-block__button-icon" aria-hidden="true">
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                </a>
                            </footer>
                        <?php endif; ?>
                    </article>
                </div>
            </div>
        </section>
        <?php
    }

    /**
     * Render tabs mode
     */
    private static function render_tabs($widget, $settings, $responsive_classes, $layout_class, $layout_class_formatted, $responsive_stacking_classes) {
        $tabs = $settings['tabs'];
        $show_button = isset($settings['show_button']) ? $settings['show_button'] : 'yes';
        
        if (empty($tabs)) {
            return;
        }
        
        $id_int = substr(uniqid(), 0, 7);
        $widget_id = 'promen-image-text-block-tabs-' . $id_int;
        $tablist_id = $widget_id . '-tablist';
        $tabpanel_id = $widget_id . '-tabpanel';
        
        ?>
        <section class="promen-image-text-block promen-image-text-block--tabs promen-tabs-mode <?php echo esc_attr($layout_class); ?> <?php echo esc_attr($layout_class_formatted); ?> <?php echo esc_attr($responsive_stacking_classes); ?>" 
                 id="<?php echo esc_attr($widget_id); ?>" 
                 role="region" 
                 aria-label="<?php echo esc_attr__('Inhoud met tabs die u kunt selecteren om verschillende informatie te bekijken', 'promen-elementor-widgets'); ?>">
            <div class="promen-image-text-block__container promen-image-text-container">
                <figure class="promen-image-text-block__image-wrapper promen-image-text-image-wrapper">
                    <!-- Tab Images -->
                    <?php foreach ($tabs as $index => $item) : 
                        $tab_count = $index + 1;
                        $tab_id = 'promen-image-text-block-tab-' . $id_int . '-' . $tab_count;
                        $tab_active_class = $index === 0 ? ' active' : '';
                        $tab_hidden_class = $index === 0 ? '' : ' promen-tab-hidden';
                        
                        $image_url = !empty($item['tab_image']['url']) ? $item['tab_image']['url'] : '';
                        $image_alt = !empty($item['tab_image']['alt']) ? $item['tab_image']['alt'] : '';
                    ?>
                        <div class="promen-image-text-block__image promen-image-text-image promen-tab-image<?php echo esc_attr($tab_active_class . $tab_hidden_class); ?>" 
                             data-tab="<?php echo esc_attr($tab_id); ?>"
                             role="img"
                             aria-label="<?php echo esc_attr($image_alt ?: $item['tab_title'] . ' afbeelding'); ?>"
                             <?php echo $index === 0 ? '' : 'aria-hidden="true"'; ?>>
                            <?php if (!empty($image_url)) : ?>
                                <img src="<?php echo esc_url($image_url); ?>" 
                                     alt="<?php echo esc_attr($image_alt ?: $item['tab_title'] . ' image'); ?>"
                                     loading="lazy"
                                     decoding="async">
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </figure>
                
                <div class="promen-image-text-block__content-wrapper promen-image-text-content-wrapper">
                    <!-- Tab Navigation -->
                    <nav class="promen-image-text-block__tabs-nav promen-tabs-nav" 
                         id="<?php echo esc_attr($tablist_id); ?>"
                         role="tablist" 
                         aria-label="<?php echo esc_attr__('Navigatie tussen verschillende tabs om inhoud te selecteren', 'promen-elementor-widgets'); ?>"
                         aria-orientation="horizontal"
                         tabindex="-1">
                        <div class="promen-image-text-block__tabs-buttons">
                            <?php foreach ($tabs as $btn_index => $btn_item) : 
                                $btn_tab_id = 'promen-image-text-block-tab-' . $id_int . '-' . ($btn_index + 1);
                                $btn_tabpanel_id = $btn_tab_id . '-panel';
                                $btn_active_class = $btn_index === 0 ? ' active' : '';
                                $btn_selected = $btn_index === 0 ? 'true' : 'false';
                                $btn_tabindex = $btn_index === 0 ? '0' : '-1';
                            ?>
                                <button type="button"
                                        class="promen-image-text-block__tab promen-tab-title<?php echo esc_attr($btn_active_class); ?>" 
                                        id="<?php echo esc_attr($btn_tab_id); ?>"
                                        data-tab="<?php echo esc_attr($btn_tab_id); ?>"
                                        role="tab"
                                        aria-selected="<?php echo esc_attr($btn_selected); ?>"
                                        aria-expanded="<?php echo esc_attr($btn_selected); ?>"
                                        aria-controls="<?php echo esc_attr($btn_tabpanel_id); ?>"
                                        tabindex="<?php echo esc_attr($btn_tabindex); ?>"
                                        aria-label="<?php echo esc_attr($btn_item['tab_title']); ?>">
                                    <span class="promen-image-text-block__tab-title"><?php echo esc_html($btn_item['tab_title']); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </nav>
                    
                    <!-- Tab Content -->
                    <div class="promen-image-text-block__tabs-content promen-tabs-content-wrapper" 
                         id="<?php echo esc_attr($tabpanel_id); ?>"
                         aria-live="polite"
                         aria-label="<?php echo esc_attr__('Inhoud van de geselecteerde tab die u kunt bekijken', 'promen-elementor-widgets'); ?>">
                        <?php foreach ($tabs as $index => $item) : 
                            $tab_count = $index + 1;
                            $tab_id = 'promen-image-text-block-tab-' . $id_int . '-' . $tab_count;
                            $tab_panel_id = $tab_id . '-panel';
                            $tab_active_class = $index === 0 ? ' active' : '';
                            $tab_hidden_class = $index === 0 ? '' : ' promen-tab-hidden';
                            $tab_hidden_attr = $index === 0 ? '' : ' aria-hidden="true"';
                            
                            $title = $item['tab_title_text'];
                            $description = $item['tab_description'];
                            $button_text = $item['tab_button_text'];
                            $button_url = !empty($item['tab_button_url']['url']) ? $item['tab_button_url']['url'] : '#';
                            $button_target = !empty($item['tab_button_url']['is_external']) ? ' target="_blank"' : '';
                            $button_nofollow = !empty($item['tab_button_url']['nofollow']) ? ' rel="nofollow"' : '';
                            $split_title = $item['tab_split_title'];
                            $title_split_position = $item['tab_title_split_position'];
                        ?>
                            <article class="promen-image-text-block__tab-content promen-tab-content<?php echo esc_attr($tab_active_class . $tab_hidden_class); ?>" 
                                     id="<?php echo esc_attr($tab_panel_id); ?>" 
                                     data-tab="<?php echo esc_attr($tab_id); ?>"
                                     role="tabpanel"
                                     aria-labelledby="<?php echo esc_attr($tab_id); ?>"
                                     tabindex="<?php echo esc_attr($index === 0 ? '0' : '-1'); ?>"
                                     <?php echo $tab_hidden_attr; ?>>
                                <div class="promen-image-text-block__content">
                                    <header class="promen-image-text-block__title-wrapper">
                                        <?php 
                                        $tab_settings = [
                                            'title_html_tag' => isset($settings['title_html_tag']) && !empty($settings['title_html_tag']) ? $settings['title_html_tag'] : 'h3',
                                            'split_title' => isset($item['tab_split_title']) ? $item['tab_split_title'] : 'no',
                                            'title_part_1' => isset($item['tab_title_part_1']) ? $item['tab_title_part_1'] : '',
                                            'title_part_2' => isset($item['tab_title_part_2']) ? $item['tab_title_part_2'] : '',
                                            'tab_title_text' => isset($item['tab_title_text']) ? $item['tab_title_text'] : '',
                                        ];
                                        echo promen_render_split_title($widget, $tab_settings, 'tab_title_text', 'promen'); 
                                        ?>
                                    </header>
                                    
                                    <?php if (!empty($item['tab_description'])) : ?>
                                        <div class="promen-image-text-block__description promen-image-text-description promen-description">
                                            <?php echo wp_kses_post($item['tab_description']); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($button_text) && $show_button === 'yes') : ?>
                                        <footer class="promen-image-text-block__button-wrapper">
                                            <a href="<?php echo esc_url($button_url); ?>" 
                                               class="promen-image-text-block__button promen-image-text-button"
                                               role="button"
                                               aria-label="<?php echo esc_attr($button_text . ($button_target ? ' (opent in een nieuw tabblad)' : '')); ?>"
                                               <?php echo $button_target . $button_nofollow; ?>>
                                                <span class="promen-image-text-block__button-text"><?php echo esc_html($button_text); ?></span>
                                                <span class="promen-image-text-block__button-icon" aria-hidden="true">
                                                    <i class="fas fa-chevron-right"></i>
                                                </span>
                                            </a>
                                        </footer>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
} 