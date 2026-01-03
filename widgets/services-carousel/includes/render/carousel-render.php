<?php
/**
 * Services Carousel Widget Render
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the services carousel widget
 */
function render_services_carousel_widget($widget) {
    $settings = $widget->get_settings_for_display();
    $id_int = substr($widget->get_id_int(), 0, 3);
    
    $carousel_id = 'promen-services-carousel-' . $id_int;
    $has_center_mode = $settings['center_mode'] === 'yes' ? 'has-center-mode' : '';
    $has_gradient = $settings['gradient_overlay'] === 'yes' ? 'has-gradient' : '';
    $gradient_class = '';
    
    if ($settings['gradient_overlay'] === 'yes') {
        $gradient_class = $settings['gradient_intensity'] . '-gradient';
    }
    
    // Prepare classes for the main container
    $fullwidth_classes = array();
    if ($settings['fullwidth_carousel'] === 'yes') {
        $fullwidth_classes[] = 'promen-services-carousel-fullwidth';
        // Add gradient classes to full-width container if enabled
        if ($settings['gradient_overlay'] === 'yes') {
            $fullwidth_classes[] = 'has-gradient';
            $fullwidth_classes[] = $gradient_class;
        }
    }
    
    // Get complete list of fullwidth classes
    $fullwidth_class = implode(' ', $fullwidth_classes);
    
    // Define wrapper classes for regular carousel
    $wrapper_classes = array('promen-services-carousel-wrapper', $has_center_mode);
    
    // Add gradient classes to the wrapper when not fullwidth
    if ($settings['fullwidth_carousel'] !== 'yes' && $settings['gradient_overlay'] === 'yes') {
        $wrapper_classes[] = 'has-gradient';
        $wrapper_classes[] = $gradient_class;
    }
    
    // Get complete list of wrapper classes
    $wrapper_class = implode(' ', array_filter($wrapper_classes));
    
    // Set up attributes
    $widget->add_render_attribute('container', 'class', 'promen-services-carousel-container');
    $widget->add_render_attribute('container', 'class', $fullwidth_class);
    
    // Add custom arrow positioning attribute
    if ($settings['show_arrows'] === 'yes') {
        $widget->add_render_attribute('container', 'data-arrows-position-type', $settings['arrows_position_type']);
    }
    
    // Add GSAP animation attributes
    if (isset($settings['enable_gsap_animation']) && $settings['enable_gsap_animation'] === 'yes') {
        $widget->add_render_attribute('container', 'data-gsap-enabled', 'true');
        $widget->add_render_attribute('container', 'data-stagger-duration', $settings['stagger_duration']['size']);
        $widget->add_render_attribute('container', 'data-stagger-delay', $settings['stagger_delay']['size']);
        $widget->add_render_attribute('container', 'data-animation-easing', $settings['animation_easing']);
        $widget->add_render_attribute('container', 'data-start-opacity', $settings['start_opacity']['size']);
        $widget->add_render_attribute('container', 'data-y-distance', $settings['y_distance']['size']);
    } else {
        $widget->add_render_attribute('container', 'data-gsap-enabled', 'false');
    }
    ?>
    <div <?php echo $widget->get_render_attribute_string('container'); ?>>
        <div class="promen-services-content-container">
            <!-- Header section with title and navigation -->
            <div class="promen-services-header">
                <div class="promen-services-title-wrapper">
                    <?php echo promen_render_split_title($widget, $settings, 'section_title', 'promen-services'); ?>
                </div>
                
                <?php if ($settings['show_arrows'] === 'yes') : ?>
                    <div class="promen-services-navigation">
                        <div class="carousel-arrow carousel-arrow-prev" data-carousel="<?php echo esc_attr($carousel_id); ?>">
                            <?php \Elementor\Icons_Manager::render_icon($settings['prev_arrow_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                        <div class="carousel-arrow carousel-arrow-next" data-carousel="<?php echo esc_attr($carousel_id); ?>">
                            <?php \Elementor\Icons_Manager::render_icon($settings['next_arrow_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if ($settings['fullwidth_carousel'] === 'yes') : ?>
            <div class="promen-services-carousel-fullwidth-inner">
            <?php endif; ?>
            
            <div class="<?php echo esc_attr($wrapper_class); ?>">
                <?php if ($settings['gradient_overlay'] === 'yes' && $settings['fullwidth_carousel'] !== 'yes') : ?>
                    <div class="viewport-edge-gradient <?php echo esc_attr($gradient_class); ?>"></div>
                <?php endif; ?>
                
                <div id="<?php echo esc_attr($carousel_id); ?>" class="promen-services-carousel swiper <?php echo $settings['center_mode'] === 'yes' ? 'swiper-center-mode' : ''; ?>"
                     data-cards-desktop="<?php echo esc_attr($settings['cards_per_view']); ?>"
                     data-cards-tablet="<?php echo esc_attr($settings['cards_per_view_tablet']); ?>"
                     data-cards-mobile="<?php echo esc_attr($settings['cards_per_view_mobile']); ?>"
                     data-center-mode="<?php echo $settings['center_mode'] === 'yes' ? 'true' : 'false'; ?>"
                     data-center-padding="<?php echo $settings['center_mode'] === 'yes' ? $settings['center_padding']['size'] . $settings['center_padding']['unit'] : '0'; ?>"
                     data-infinite="<?php echo $settings['infinite'] === 'yes' ? 'true' : 'false'; ?>"
                     data-autoplay="<?php echo $settings['autoplay'] === 'yes' ? 'true' : 'false'; ?>"
                     data-autoplay-speed="<?php echo $settings['autoplay'] === 'yes' ? $settings['autoplay_speed'] : '3000'; ?>"
                     data-speed="<?php echo esc_attr($settings['speed']); ?>"
                     data-center-mode-tablet="<?php echo ($settings['center_mode'] === 'yes' && $settings['center_mode_tablet'] === 'yes') ? 'true' : 'false'; ?>"
                     data-center-padding-tablet="<?php echo ($settings['center_mode'] === 'yes' && $settings['center_mode_tablet'] === 'yes') ? $settings['center_padding_tablet']['size'] . $settings['center_padding_tablet']['unit'] : '0'; ?>"
                     data-center-mode-mobile="<?php echo ($settings['center_mode'] === 'yes' && $settings['center_mode_mobile'] === 'yes') ? 'true' : 'false'; ?>"
                     data-center-padding-mobile="<?php echo ($settings['center_mode'] === 'yes' && $settings['center_mode_mobile'] === 'yes') ? $settings['center_padding_mobile']['size'] . $settings['center_padding_mobile']['unit'] : '0'; ?>">
                    <div class="swiper-wrapper">
                        <?php foreach ($settings['services'] as $index => $service) : 
                            $service_key = 'service_' . $id_int . '_' . $index;
                            $widget->add_render_attribute($service_key, [
                                'class' => [
                                    'service-card',
                                    'elementor-repeater-item-' . $service['_id'],
                                ],
                                'aria-label' => $service['service_title'],
                            ]);
                            
                            $link_key = 'link_' . $index;
                            $url = !empty($service['service_link']['url']) ? $service['service_link']['url'] : '#';
                            $target = !empty($service['service_link']['is_external']) ? ' target="_blank"' : '';
                            $nofollow = !empty($service['service_link']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <div class="swiper-slide" data-slide-index="<?php echo esc_attr($index); ?>">
                                <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?> <?php echo $widget->get_render_attribute_string($service_key); ?>>
                                    <div class="service-icon">
                                        <?php \Elementor\Icons_Manager::render_icon($service['service_icon'], ['aria-hidden' => 'true']); ?>
                                    </div>
                                    <?php
                                    $service_title_tag = isset($service['service_title_html_tag']) && !empty($service['service_title_html_tag']) ? $service['service_title_html_tag'] : 'span';
                                    ?>
                                    <<?php echo esc_attr($service_title_tag); ?> class="service-title"><?php echo esc_html($service['service_title']); ?></<?php echo esc_attr($service_title_tag); ?>>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <?php if ($settings['fullwidth_carousel'] === 'yes') : ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            // Make sure jQuery and Swiper are loaded
            if (typeof window.initCarousel === 'function') {
                window.initCarousel('<?php echo esc_js($carousel_id); ?>');
            } else {
                // If initCarousel is not loaded yet, wait for it
                var checkInterval = setInterval(function() {
                    if (typeof window.initCarousel === 'function') {
                        clearInterval(checkInterval);
                        window.initCarousel('<?php echo esc_js($carousel_id); ?>');
                    }
                }, 100);

                // Set a timeout to stop checking after 5 seconds
                setTimeout(function() {
                    clearInterval(checkInterval);
                }, 5000);
            }
        });
    </script>
    <?php
} 