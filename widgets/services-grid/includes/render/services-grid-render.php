<?php
/**
 * Services Grid Widget Render
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Services Grid Widget
 */
function render_services_grid_widget($widget) {
    $settings = $widget->get_settings_for_display();
    
    // Generate unique IDs for accessibility
    $widget_id = $widget->get_id();
    $heading_id = Promen_Accessibility_Utils::generate_id('services-grid-heading');
    $description_id = Promen_Accessibility_Utils::generate_id('services-grid-description');
    $services_id = Promen_Accessibility_Utils::generate_id('services-grid-list');
    ?>
    <section class="services-grid-container" 
             role="region" 
             aria-labelledby="<?php echo esc_attr($heading_id); ?>"
             aria-describedby="<?php echo esc_attr($description_id); ?>"
             aria-label="<?php esc_attr_e('Overzicht van alle beschikbare services en diensten die wij aanbieden', 'promen-elementor-widgets'); ?>">
        <header class="services-grid-content" id="<?php echo esc_attr($heading_id); ?>">
            <?php if (!empty($settings['show_title']) && $settings['show_title'] === 'yes') : ?>
                <<?php echo esc_attr($settings['title_tag']); ?> class="services-grid-title">
                    <?php if (!empty($settings['title_part_1'])) : ?>
                        <span class="title-part-1"><?php echo esc_html($settings['title_part_1']); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($settings['title_part_2'])) : ?>
                        <span class="title-part-2"><?php echo esc_html($settings['title_part_2']); ?></span>
                    <?php endif; ?>
                </<?php echo esc_attr($settings['title_tag']); ?>>
            <?php endif; ?>

            <?php if (!empty($settings['show_description']) && $settings['show_description'] === 'yes' && !empty($settings['description'])) : ?>
                <p class="services-grid-description" id="<?php echo esc_attr($description_id); ?>">
                    <?php echo esc_html($settings['description']); ?>
                </p>
            <?php endif; ?>
        </header>

        <main class="services-grid-wrapper">
            <?php
            // Prepare services array for both grid and slider
            $services_array = [];
            if (!empty($settings['services'])) {
                foreach ($settings['services'] as $service) {
                    if (empty($service['show_service']) || $service['show_service'] !== 'yes') continue;
                    
                    $services_array[] = $service;
                }
            }
            ?>
            
            <!-- Grid View (Desktop) -->
            <?php
            // Generate services grid accessibility attributes
            $grid_attrs = Promen_Accessibility_Utils::get_services_grid_attrs($services_array, $widget_id);
            ?>
            <div class="services-grid" <?php echo $grid_attrs['services_attrs']; ?>>
                <?php
                foreach ($services_array as $index => $service) :
                    $target = !empty($service['service_link']['is_external']) ? ' target="_blank"' : '';
                    $nofollow = !empty($service['service_link']['nofollow']) ? ' rel="nofollow"' : '';
                    $url = !empty($service['service_link']['url']) ? $service['service_link']['url'] : '#';
                    
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
                    
                    // Generate service accessibility attributes
                    $service_attrs = Promen_Accessibility_Utils::get_service_attrs($service, $index, $widget_id);
                    ?>
                    <article class="service-card <?php echo esc_attr($hover_animation_class); ?>" 
                             <?php echo $service_attrs['service_item_attrs']; ?>
                             id="<?php echo esc_attr($service_attrs['service_item_id']); ?>">
                        <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?>
                           <?php echo $service_attrs['service_link_attrs']; ?>>
                            <?php if (!empty($service['service_icon']['value'])) : ?>
                                <div class="service-icon" <?php echo $service_attrs['service_icon_attrs']; ?>>
                                    <?php \Elementor\Icons_Manager::render_icon($service['service_icon'], ['aria-hidden' => 'true']); ?>
                                </div>
                            <?php endif; ?>
                            <span class="service-title" <?php echo $service_attrs['service_title_attrs']; ?>><?php echo esc_html($service['service_title']); ?></span>
                            <?php if (!empty($service['service_description'])) : ?>
                                <p class="service-description" <?php echo $service_attrs['service_description_attrs']; ?>><?php echo esc_html($service['service_description']); ?></p>
                            <?php endif; ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
            
            <?php
            // Slider settings
            $enable_mobile_slider = isset($settings['enable_mobile_slider']) ? $settings['enable_mobile_slider'] : 'yes';
            $slider_template = isset($settings['slider_template']) ? $settings['slider_template'] : 'default';

            // Prepare slider settings
            $slider_settings = [
                'slidesPerView' => isset($settings['slides_per_view']) ? $settings['slides_per_view'] : 1,
                'spaceBetween' => isset($settings['space_between']) ? intval($settings['space_between']) : 30,
                'navigation' => isset($settings['slider_navigation']) && $settings['slider_navigation'] === 'yes',
                'pagination' => isset($settings['slider_pagination']) && $settings['slider_pagination'] === 'yes',
                'loop' => isset($settings['slider_loop']) && $settings['slider_loop'] === 'yes',
                'autoplay' => isset($settings['slider_autoplay']) && $settings['slider_autoplay'] === 'yes',
                'autoplayDelay' => isset($settings['slider_autoplay_delay']) ? intval($settings['slider_autoplay_delay']) : 5000,
                'effect' => isset($settings['slider_effect']) ? $settings['slider_effect'] : 'slide',
                'speed' => isset($settings['slider_speed']) ? intval($settings['slider_speed']) : 300,
                'centeredSlides' => isset($settings['centered_slides']) && $settings['centered_slides'] === 'yes',
            ];
            ?>
            
            <?php
            // Prepare slider data attributes
            $slider_data_attrs = [];
            $slider_data_attrs[] = 'id="services-slider-' . $widget_id . '"';
            $slider_data_attrs[] = 'class="services-slider swiper"';
            
            // Basic settings
            $slider_data_attrs[] = 'data-slides-per-view="' . esc_attr($slider_settings['slidesPerView']) . '"';
            $slider_data_attrs[] = 'data-space-between="' . esc_attr($slider_settings['spaceBetween']) . '"';
            $slider_data_attrs[] = 'data-loop="' . ($slider_settings['loop'] ? 'true' : 'false') . '"';
            $slider_data_attrs[] = 'data-autoplay="' . ($slider_settings['autoplay'] ? 'true' : 'false') . '"';
            if ($slider_settings['autoplay']) {
                $slider_data_attrs[] = 'data-autoplay-delay="' . esc_attr($slider_settings['autoplayDelay']) . '"';
            }
            $slider_data_attrs[] = 'data-navigation="' . ($slider_settings['navigation'] ? 'true' : 'false') . '"';
            $slider_data_attrs[] = 'data-pagination="' . ($slider_settings['pagination'] ? 'true' : 'false') . '"';
            $slider_data_attrs[] = 'data-effect="' . esc_attr($slider_settings['effect']) . '"';
            $slider_data_attrs[] = 'data-centered-slides="' . ($slider_settings['centeredSlides'] ? 'true' : 'false') . '"';
            
            // Breakpoints
            $breakpoints = [];
            
            // Mobile (default base, but we can set 480 specifically if needed)
            $mobile_spv = !empty($settings['slides_per_view_mobile']) ? $settings['slides_per_view_mobile'] : 1;
            $breakpoints[480] = [
                'slidesPerView' => (int)$mobile_spv,
                'spaceBetween' => 20
            ];
            
            // Tablet
            $tablet_spv = !empty($settings['slides_per_view_tablet']) ? $settings['slides_per_view_tablet'] : 2;
            $breakpoints[768] = [
                'slidesPerView' => (int)$tablet_spv,
                'spaceBetween' => isset($settings['space_between_tablet']) ? (int)$settings['space_between_tablet'] : 30
            ];
            
            $slider_data_attrs[] = 'data-breakpoints="' . esc_attr(json_encode($breakpoints)) . '"';
            ?>

            <?php if ($enable_mobile_slider === 'yes') : ?>
                <!-- Mobile Slider View -->
                <?php 
                // Include the selected slider template
                $template_file = __DIR__ . '/../slider-templates/' . $slider_template . '.php';
                if (file_exists($template_file)) {
                    include($template_file);
                } else {
                    // Fallback to default template if selected template doesn't exist
                    include(__DIR__ . '/../slider-templates/default.php');
                }
                ?>
            <?php else : ?>
                <!-- Slider View (Mobile) -->
                <div class="services-slider-container" 
                     role="region" 
                     aria-label="<?php esc_attr_e('Interactieve schuifregelaar met services die u kunt doorbladeren', 'promen-elementor-widgets'); ?>"
                     aria-live="polite">
                    <div <?php echo implode(' ', $slider_data_attrs); ?>>
                        <div class="swiper-wrapper" role="list" aria-label="<?php esc_attr_e('Lijst met alle services die u kunt bekijken en waarop u kunt klikken voor meer informatie', 'promen-elementor-widgets'); ?>">
                            <?php
                            foreach ($services_array as $index => $service) :
                                $target = !empty($service['service_link']['is_external']) ? ' target="_blank"' : '';
                                $nofollow = !empty($service['service_link']['nofollow']) ? ' rel="nofollow"' : '';
                                $url = !empty($service['service_link']['url']) ? $service['service_link']['url'] : '#';
                                
                                // Generate service accessibility attributes for slider
                                $service_attrs = Promen_Accessibility_Utils::get_service_attrs($service, $index, $widget_id . '-slider');
                                ?>
                                <div class="swiper-slide" role="listitem" id="<?php echo esc_attr($service_attrs['service_item_id']); ?>">
                                    <article class="service-card" 
                                             tabindex="0"
                                             <?php echo $service_attrs['service_item_attrs']; ?>>
                                        <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?>
                                           <?php echo $service_attrs['service_link_attrs']; ?>>
                                            <?php if (!empty($service['service_icon']['value'])) : ?>
                                                <div class="service-icon" <?php echo $service_attrs['service_icon_attrs']; ?>>
                                                    <?php \Elementor\Icons_Manager::render_icon($service['service_icon'], ['aria-hidden' => 'true']); ?>
                                                </div>
                                            <?php endif; ?>
                                            <span class="service-title" <?php echo $service_attrs['service_title_attrs']; ?>><?php echo esc_html($service['service_title']); ?></span>
                                            <?php if (!empty($service['service_description'])) : ?>
                                                <p class="service-description" <?php echo $service_attrs['service_description_attrs']; ?>><?php echo esc_html($service['service_description']); ?></p>
                                            <?php endif; ?>
                                        </a>
                                    </article>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination" role="tablist" aria-label="<?php esc_attr_e('Paginering om door verschillende service pagina\'s te navigeren', 'promen-elementor-widgets'); ?>"></div>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </section>
    

    <?php
} 