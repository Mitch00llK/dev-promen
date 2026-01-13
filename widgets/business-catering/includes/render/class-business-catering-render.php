<?php
/**
 * Business Catering Widget Render
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Business Catering Widget Render Class
 */
class Promen_Business_Catering_Render {

    /**
     * Render Business Catering Widget
     */
    public static function render($widget) {
        $settings = $widget->get_settings_for_display();

        // Generate accessibility attributes
        $widget_id = $widget->get_id();
        $container_id = Promen_Accessibility_Utils::generate_id('business-catering', $widget_id);
        $title_id = Promen_Accessibility_Utils::generate_id('catering-title', $widget_id);

        // Get catering images
        $catering_images = isset($settings['catering_images']) ? $settings['catering_images'] : [];
        $image_count = count($catering_images);

        // Determine if we should use slider (more than 3 images)
        $use_slider = $image_count > 3;

        // Responsive classes
        $columns_desktop = isset($settings['columns_desktop']) ? $settings['columns_desktop'] : '3';
        $columns_tablet = isset($settings['columns_tablet']) ? $settings['columns_tablet'] : '2';
        $columns_mobile = isset($settings['columns_mobile']) ? $settings['columns_mobile'] : '1';

        $grid_classes = "promen-catering-grid desktop-columns-{$columns_desktop} tablet-columns-{$columns_tablet} mobile-columns-{$columns_mobile}";

        // Prepare slider settings
        $slider_settings = [
            'slidesPerView' => isset($settings['slides_per_view']) ? $settings['slides_per_view'] : 1,
            'spaceBetween' => isset($settings['space_between']['size']) ? intval($settings['space_between']['size']) : 30,
            'navigation' => isset($settings['slider_navigation']) && $settings['slider_navigation'] === 'yes',
            'pagination' => isset($settings['slider_pagination']) && $settings['slider_pagination'] === 'yes',
            'loop' => isset($settings['slider_loop']) && $settings['slider_loop'] === 'yes',
            'autoplay' => isset($settings['slider_autoplay']) && $settings['slider_autoplay'] === 'yes',
            'autoplayDelay' => isset($settings['slider_autoplay_delay']) ? intval($settings['slider_autoplay_delay']) : 5000,
            'effect' => isset($settings['slider_effect']) ? $settings['slider_effect'] : 'slide',
            'speed' => isset($settings['slider_speed']) ? intval($settings['slider_speed']) : 500,
            'centeredSlides' => isset($settings['centered_slides']) && $settings['centered_slides'] === 'yes',
        ];

        // Gradient overlay settings
        $gradient_overlay = isset($settings['gradient_overlay']) && $settings['gradient_overlay'] === 'yes';
        $gradient_color = isset($settings['gradient_color_start']) ? $settings['gradient_color_start'] : '#ffffff';
        $gradient_opacity = isset($settings['gradient_opacity']['size']) ? intval($settings['gradient_opacity']['size']) : 90;
        $gradient_width = isset($settings['gradient_width']['size']) ? intval($settings['gradient_width']['size']) : 15;

        // Convert opacity to decimal
        $gradient_opacity_decimal = $gradient_opacity / 100;

        // Create RGBA color for gradient
        $rgb = self::hex2rgb($gradient_color);
        $rgba_start = "rgba({$rgb[0]}, {$rgb[1]}, {$rgb[2]}, {$gradient_opacity_decimal})";
        $rgba_end = "rgba({$rgb[0]}, {$rgb[1]}, {$rgb[2]}, 0)";

        // Gradient styles
        $gradient_left_style = "background: linear-gradient(to right, {$rgba_start} 0%, {$rgba_end} 100%); width: {$gradient_width}%;";
        $gradient_right_style = "background: linear-gradient(to left, {$rgba_start} 0%, {$rgba_end} 100%); width: {$gradient_width}%;";
        ?>

        <section class="promen-business-catering-widget promen-widget" 
                 id="<?php echo esc_attr($container_id); ?>"
                 role="region" 
                 <?php if ($settings['show_title'] === 'yes' && !empty($settings['section_title'])) : ?>aria-labelledby="<?php echo esc_attr($title_id); ?>"<?php endif; ?>
                 aria-label="<?php echo esc_attr__('Galerij met bedrijfscatering afbeeldingen en informatie over onze cateringdiensten', 'promen-elementor-widgets'); ?>">
            
            <?php if ($settings['show_title'] === 'yes' && !empty($settings['section_title'])) : ?>
                <header class="promen-catering-title-wrapper">
                    <?php 
                    // Use the split title function if available
                    if (function_exists('promen_render_split_title')) {
                        $title_settings = $settings;
                        $title_settings['title_id'] = $title_id;
                        echo promen_render_split_title($widget, $title_settings, 'section_title', 'promen-catering');
                    } else {
                        // Fallback if the function is not available
                        $tag = !empty($settings['title_html_tag']) ? $settings['title_html_tag'] : 'h2';
                        echo "<{$tag} class='promen-catering-title' id='" . esc_attr($title_id) . "'>" . esc_html($settings['section_title']) . "</{$tag}>";
                    }
                    ?>
                </header>
            <?php endif; ?>

            <?php if ($use_slider) : ?>
                <?php
                // Generate unique ID for this slider instance
                $slider_id = 'promen-catering-slider-' . uniqid();

                // Prepare slider attributes
                $slider_attributes = [
                    'data-slides-per-view' => $slider_settings['slidesPerView'],
                    'data-space-between' => $slider_settings['spaceBetween'],
                    'data-navigation' => $slider_settings['navigation'] ? 'true' : 'false',
                    'data-pagination' => $slider_settings['pagination'] ? 'true' : 'false',
                    'data-loop' => $slider_settings['loop'] ? 'true' : 'false',
                    'data-autoplay' => $slider_settings['autoplay'] ? 'true' : 'false',
                    'data-autoplay-delay' => $slider_settings['autoplayDelay'],
                    'data-effect' => $slider_settings['effect'],
                    'data-speed' => $slider_settings['speed'],
                    'data-centered-slides' => $slider_settings['centeredSlides'] ? 'true' : 'false',
                ];

                $slider_attr_string = '';
                foreach ($slider_attributes as $key => $value) {
                    $slider_attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
                }
                ?>

                <div class="promen-catering-slider-container">
                    <?php if ($gradient_overlay) : ?>
                        <div class="promen-catering-gradient-left" style="<?php echo esc_attr($gradient_left_style); ?>" aria-hidden="true"></div>
                        <div class="promen-catering-gradient-right" style="<?php echo esc_attr($gradient_right_style); ?>" aria-hidden="true"></div>
                    <?php endif; ?>
                    
                    <!-- Slider main container -->
                    <div id="<?php echo esc_attr($slider_id); ?>" 
                         class="swiper promen-catering-slider" 
                         role="region" 
                         aria-label="<?php echo esc_attr__('Interactieve carrousel met catering afbeeldingen die u kunt doorbladeren', 'promen-elementor-widgets'); ?>"
                         aria-live="polite"
                         <?php echo $slider_attr_string; ?>>
                        
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper" role="list" aria-label="<?php echo esc_attr__('Lijst met alle catering afbeeldingen die u kunt bekijken', 'promen-elementor-widgets'); ?>">
                            <?php foreach ($catering_images as $index => $item) : ?>
                                <!-- Slides -->
                                <div class="swiper-slide" 
                                     role="listitem" 
                                     aria-label="<?php echo esc_attr(sprintf(__('Catering afbeelding %d van %d in de carrousel', 'promen-elementor-widgets'), $index + 1, $image_count)); ?>"
                                     tabindex="0">
                                    <div class="promen-catering-image-wrapper">
                                        <figure class="promen-catering-image elementor-animation-<?php echo esc_attr($settings['image_hover_animation']); ?>" 
                                                role="img" 
                                                aria-label="<?php echo esc_attr(!empty($item['title']) ? $item['title'] : sprintf(__('Catering afbeelding %d met informatie over onze cateringdiensten', 'promen-elementor-widgets'), $index + 1)); ?>">
                                            <?php if (!empty($item['image']['url'])) : ?>
                                                <img src="<?php echo esc_url($item['image']['url']); ?>" 
                                                     alt="<?php echo esc_attr(!empty($item['title']) ? $item['title'] : sprintf(__('Catering afbeelding %d', 'promen-elementor-widgets'), $index + 1)); ?>" 
                                                     class="promen-catering-img"
                                                     loading="lazy">
                                            <?php endif; ?>
                                            
                                            <?php if (($settings['show_image_title'] === 'yes' || $settings['show_image_description'] === 'yes') && 
                                                      ($item['show_overlay'] === 'yes' || $settings['show_overlay_on_hover'] === 'yes')) : ?>
                                                <figcaption class="promen-catering-overlay<?php echo $settings['show_overlay_on_hover'] === 'yes' ? ' hover-overlay' : ''; ?>">
                                                    <?php if ($settings['show_image_title'] === 'yes' && !empty($item['title'])) : ?>
                                                        <h3 class="promen-catering-overlay-title"><?php echo esc_html($item['title']); ?></h3>
                                                    <?php endif; ?>
                                                    
                                                    <?php if ($settings['show_image_description'] === 'yes' && !empty($item['description'])) : ?>
                                                        <p class="promen-catering-overlay-description"><?php echo esc_html($item['description']); ?></p>
                                                    <?php endif; ?>
                                                </figcaption>
                                            <?php endif; ?>
                                        </figure>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if ($slider_settings['pagination']) : ?>
                            <!-- Pagination -->
                            <div class="swiper-pagination" 
                                 role="group" 
                                 aria-label="<?php echo esc_attr__('Paginering om door verschillende catering afbeeldingen te navigeren', 'promen-elementor-widgets'); ?>"></div>
                        <?php endif; ?>
                        
                        <?php if ($slider_settings['navigation']) : ?>
                            <!-- Navigation buttons -->
                            <button class="swiper-button-prev" 
                                    type="button"
                                    aria-label="<?php echo esc_attr__('Ga naar de vorige catering afbeelding in de carrousel', 'promen-elementor-widgets'); ?>"
                                    aria-controls="<?php echo esc_attr($slider_id); ?>">
                                <span class="screen-reader-text"><?php echo esc_html__('Vorige dia', 'promen-elementor-widgets'); ?></span>
                            </button>
                            <button class="swiper-button-next" 
                                    type="button"
                                    aria-label="<?php echo esc_attr__('Ga naar de volgende catering afbeelding in de carrousel', 'promen-elementor-widgets'); ?>"
                                    aria-controls="<?php echo esc_attr($slider_id); ?>">
                                <span class="screen-reader-text"><?php echo esc_html__('Volgende dia', 'promen-elementor-widgets'); ?></span>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else : ?>
                <!-- Regular grid layout for 3 or fewer images -->
                <div class="<?php echo esc_attr($grid_classes); ?>" 
                     role="list" 
                     aria-label="<?php echo esc_attr__('Rooster met alle catering afbeeldingen die u kunt bekijken voor informatie over onze diensten', 'promen-elementor-widgets'); ?>">
                    <?php foreach ($catering_images as $index => $item) : ?>
                        <div class="promen-catering-image-wrapper" 
                             role="listitem"
                             tabindex="0"
                             aria-label="<?php echo esc_attr(sprintf(__('Catering afbeelding %d van %d in het rooster', 'promen-elementor-widgets'), $index + 1, $image_count)); ?>">
                            <figure class="promen-catering-image elementor-animation-<?php echo esc_attr($settings['image_hover_animation']); ?>" 
                                    role="img" 
                                    aria-label="<?php echo esc_attr(!empty($item['title']) ? $item['title'] : sprintf(__('Catering afbeelding %d met informatie over onze cateringdiensten', 'promen-elementor-widgets'), $index + 1)); ?>">
                                <?php if (!empty($item['image']['url'])) : ?>
                                    <img src="<?php echo esc_url($item['image']['url']); ?>" 
                                         alt="<?php echo esc_attr(!empty($item['title']) ? $item['title'] : sprintf(__('Catering afbeelding %d', 'promen-elementor-widgets'), $index + 1)); ?>" 
                                         class="promen-catering-img"
                                         loading="lazy">
                                <?php endif; ?>
                                
                                <?php if (($settings['show_image_title'] === 'yes' || $settings['show_image_description'] === 'yes') && 
                                          ($item['show_overlay'] === 'yes' || $settings['show_overlay_on_hover'] === 'yes')) : ?>
                                    <figcaption class="promen-catering-overlay<?php echo $settings['show_overlay_on_hover'] === 'yes' ? ' hover-overlay' : ''; ?>">
                                        <?php if ($settings['show_image_title'] === 'yes' && !empty($item['title'])) : ?>
                                            <h3 class="promen-catering-overlay-title"><?php echo esc_html($item['title']); ?></h3>
                                        <?php endif; ?>
                                        
                                        <?php if ($settings['show_image_description'] === 'yes' && !empty($item['description'])) : ?>
                                            <p class="promen-catering-overlay-description"><?php echo esc_html($item['description']); ?></p>
                                        <?php endif; ?>
                                    </figcaption>
                                <?php endif; ?>
                            </figure>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
        <?php
    }

    /**
     * Helper to convert hex to RGB
     */
    private static function hex2rgb($hex) {
        $hex = str_replace("#", "", $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return [$r, $g, $b];
    }
}
