<?php
/**
 * Related Services Widget Render
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Promen_Related_Services_Render {

    /**
     * Render Related Services Widget
     */
    public static function render($widget) {
        $settings = $widget->get_settings_for_display();
        
        // Debug the settings 
        $services_debug = '';
        if (!empty($settings['services'])) {
            foreach ($settings['services'] as $index => $service) {
                $bg_color = isset($service['service_background_color']) ? $service['service_background_color'] : 'not set';
                $services_debug .= "<!-- Service {$index}: ID: " . (isset($service['_id']) ? $service['_id'] : 'no id') . ", BG Color: {$bg_color} -->\n";
            }
        }
        echo $services_debug;

        // Add hover animation class
        $hover_animation_class = '';
        if (!empty($settings['card_hover_animation'])) {
            switch ($settings['card_hover_animation']) {
                case 'translateY':
                    $hover_animation_class = 'hover-translateY';
                    break;
                case 'scale':
                    $hover_animation_class = 'hover-scale';
                    break;
                case 'both':
                    $hover_animation_class = 'hover-translateY hover-scale';
                    break;
                default:
                    $hover_animation_class = '';
            }
        }

        // Get layout type
        $layout_type = !empty($settings['layout_type']) ? $settings['layout_type'] : 'two-column';
        $layout_class = 'layout-' . $layout_type;
        
        // Generate unique IDs for accessibility
        $widget_id = $widget->get_id();
        $heading_id = Promen_Accessibility_Utils::generate_id('related-services-heading');
        $services_id = Promen_Accessibility_Utils::generate_id('related-services-list');
        ?>
        <section class="related-services-container" 
                 role="region" 
                 aria-labelledby="<?php echo esc_attr($heading_id); ?>"
                 aria-label="<?php esc_attr_e('Overzicht van gerelateerde services en diensten die mogelijk interessant voor u zijn', 'promen-elementor-widgets'); ?>">
            <div class="related-services-wrapper <?php echo esc_attr($layout_class); ?>">
                <!-- Title Column -->
                <header class="related-services-title-column" id="<?php echo esc_attr($heading_id); ?>">
                    <?php if (!empty($settings['show_title']) && $settings['show_title'] === 'yes') : ?>
                        <?php $title_tag = !empty($settings['title_tag']) ? $settings['title_tag'] : 'h3'; ?>
                        <<?php echo esc_attr($title_tag); ?> class="related-services-title">
                            <?php if (!empty($settings['title_part_1'])) : ?>
                                <span class="title-part-1"><?php echo esc_html($settings['title_part_1']); ?></span>
                            <?php endif; ?>
                            <?php if (!empty($settings['title_part_2'])) : ?>
                                <span class="title-part-2"><?php echo esc_html($settings['title_part_2']); ?></span>
                            <?php endif; ?>
                        </<?php echo esc_attr($title_tag); ?>>
                    <?php endif; ?>
                </header>

                <!-- Cards Column -->
                <div class="related-services-cards-column">
                    <?php
                    // Split services into two groups
                    $services_list = [];
                    if (!empty($settings['services'])) {
                        foreach ($settings['services'] as $index => $service) {
                            if (empty($service['show_service']) || $service['show_service'] !== 'yes') continue;
                            $services_list[] = $service;
                        }
                    }
                    
                    // Split into two groups
                    $total_services = count($services_list);
                    $mid_point = ceil($total_services / 2);
                    $first_group = array_slice($services_list, 0, $mid_point);
                    $second_group = array_slice($services_list, $mid_point);
                    
                    // Render first container
                    if (!empty($first_group)) :
                    ?>
                    <div class="related-services-grid-container">
                        <div class="related-services-grid" 
                             role="list" 
                             aria-label="<?php esc_attr_e('Lijst met gerelateerde services die u kunt bekijken en waarop u kunt klikken voor meer informatie', 'promen-elementor-widgets'); ?>"
                             id="<?php echo esc_attr($services_id); ?>-1">
                            <?php
                            foreach ($first_group as $index => $service) {
                                $target = !empty($service['service_link']['is_external']) ? ' target="_blank"' : '';
                                $nofollow = !empty($service['service_link']['nofollow']) ? ' rel="nofollow"' : '';
                                $url = !empty($service['service_link']['url']) ? $service['service_link']['url'] : '#';
                                
                                // Get the service ID for styling
                                $service_id = isset($service['_id']) ? $service['_id'] : $index;
                                
                                // Get background color if set
                                $bg_style = '';
                                if (!empty($service['service_background_color'])) {
                                    $bg_style = 'style="background-color: ' . esc_attr($service['service_background_color']) . ';"';
                                }
                                
                                // Generate unique IDs for accessibility
                                $service_item_id = Promen_Accessibility_Utils::generate_id('service-item-' . ($index + 1));
                                $service_title_id = Promen_Accessibility_Utils::generate_id('service-title-' . ($index + 1));
                                
                                // Debug output
                                echo "<!-- Service ID: $service_id, Has bg color: " . (!empty($service['service_background_color']) ? 'yes' : 'no') . " -->";
                                ?>
                                <article class="related-service-card service-id-<?php echo esc_attr($service_id); ?> <?php echo esc_attr($hover_animation_class); ?>" 
                                         role="listitem" 
                                         tabindex="0"
                                         aria-labelledby="<?php echo esc_attr($service_title_id); ?>"
                                         id="<?php echo esc_attr($service_item_id); ?>"
                                         <?php echo $bg_style; ?>>
                                    <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?> 
                                       class="related-service-link"
                                       aria-label="<?php echo esc_attr($service['service_title']); ?>">
                                        <?php if (!empty($service['service_icon']['value'])) : ?>
                                            <div class="related-service-icon" role="img" aria-label="<?php echo esc_attr($service['service_title']); ?>">
                                                <?php \Elementor\Icons_Manager::render_icon($service['service_icon'], ['aria-hidden' => 'true']); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <span class="related-service-title" id="<?php echo esc_attr($service_title_id); ?>">
                                            <?php echo esc_html($service['service_title']); ?>
                                        </span>
                                        
                                        <?php if (!empty($settings['show_arrow']) && $settings['show_arrow'] === 'yes') : ?>
                                            <div class="related-service-arrow" aria-hidden="true">
                                                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                </article>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php
                    // Render second container
                    if (!empty($second_group)) :
                    ?>
                    <div class="related-services-grid-container">
                        <div class="related-services-grid" 
                             role="list" 
                             aria-label="<?php esc_attr_e('Lijst met gerelateerde services die u kunt bekijken en waarop u kunt klikken voor meer informatie', 'promen-elementor-widgets'); ?>"
                             id="<?php echo esc_attr($services_id); ?>-2">
                            <?php
                            foreach ($second_group as $index => $service) {
                                $original_index = $mid_point + $index;
                                $target = !empty($service['service_link']['is_external']) ? ' target="_blank"' : '';
                                $nofollow = !empty($service['service_link']['nofollow']) ? ' rel="nofollow"' : '';
                                $url = !empty($service['service_link']['url']) ? $service['service_link']['url'] : '#';
                                
                                // Get the service ID for styling
                                $service_id = isset($service['_id']) ? $service['_id'] : $original_index;
                                
                                // Get background color if set
                                $bg_style = '';
                                if (!empty($service['service_background_color'])) {
                                    $bg_style = 'style="background-color: ' . esc_attr($service['service_background_color']) . ';"';
                                }
                                
                                // Generate unique IDs for accessibility
                                $service_item_id = Promen_Accessibility_Utils::generate_id('service-item-' . ($original_index + 1));
                                $service_title_id = Promen_Accessibility_Utils::generate_id('service-title-' . ($original_index + 1));
                                
                                // Debug output
                                echo "<!-- Service ID: $service_id, Has bg color: " . (!empty($service['service_background_color']) ? 'yes' : 'no') . " -->";
                                ?>
                                <article class="related-service-card service-id-<?php echo esc_attr($service_id); ?> <?php echo esc_attr($hover_animation_class); ?>" 
                                         role="listitem" 
                                         tabindex="0"
                                         aria-labelledby="<?php echo esc_attr($service_title_id); ?>"
                                         id="<?php echo esc_attr($service_item_id); ?>"
                                         <?php echo $bg_style; ?>>
                                    <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?> 
                                       class="related-service-link"
                                       aria-label="<?php echo esc_attr($service['service_title']); ?>">
                                        <?php if (!empty($service['service_icon']['value'])) : ?>
                                            <div class="related-service-icon" role="img" aria-label="<?php echo esc_attr($service['service_title']); ?>">
                                                <?php \Elementor\Icons_Manager::render_icon($service['service_icon'], ['aria-hidden' => 'true']); ?>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <span class="related-service-title" id="<?php echo esc_attr($service_title_id); ?>">
                                            <?php echo esc_html($service['service_title']); ?>
                                        </span>
                                        
                                        <?php if (!empty($settings['show_arrow']) && $settings['show_arrow'] === 'yes') : ?>
                                            <div class="related-service-arrow" aria-hidden="true">
                                                <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                            </div>
                                        <?php endif; ?>
                                    </a>
                                </article>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}