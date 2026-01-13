<?php
/**
 * Benefits Widget Render
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Benefits Widget Render Class
 */
class Promen_Benefits_Render {

    /**
     * Render Benefits Widget
     */
    public static function render($widget) {
        $settings = $widget->get_settings_for_display();
        
        // Generate accessibility attributes
        $widget_id = $widget->get_id();
        $container_id = Promen_Accessibility_Utils::generate_id('benefits-container', $widget_id);
        $title_id = Promen_Accessibility_Utils::generate_id('benefits-title', $widget_id);
        $description_id = Promen_Accessibility_Utils::generate_id('benefits-description', $widget_id);
        ?>
        <section class="benefits-widget promen-widget" 
                 id="<?php echo esc_attr($container_id); ?>"
                 role="region" 
                 <?php if ($settings['show_header'] === 'yes') : ?>aria-labelledby="<?php echo esc_attr($title_id); ?>"<?php endif; ?>
                 <?php if (!empty($settings['description'])) : ?>aria-describedby="<?php echo esc_attr($description_id); ?>"<?php endif; ?>>
            
            <!-- Header Section -->
            <?php if ('yes' === $settings['show_header']) : ?>
            <header class="benefits-header">
                <?php 
                // Add ID to title for ARIA labeling
                $title_settings = $settings;
                $title_settings['title_id'] = $title_id;
                echo promen_render_split_title($widget, $title_settings, 'title', 'benefits'); 
                ?>
                
                <?php if (!empty($settings['description'])) : ?>
                    <p class="benefits-description" id="<?php echo esc_attr($description_id); ?>">
                        <?php echo esc_html($settings['description']); ?>
                    </p>
                <?php endif; ?>
            </header>
            <?php endif; ?>

            <!-- Content Section -->
            <div class="benefits-content" aria-label="<?php echo esc_attr__('Benefits list', 'promen-elementor-widgets'); ?>">
                <!-- Benefits Container -->
                <div class="benefits-container" role="list" aria-label="<?php echo esc_attr__('List of benefits', 'promen-elementor-widgets'); ?>">
                    <?php
                    if (!empty($settings['benefits_list'])) :
                        foreach ($settings['benefits_list'] as $index => $item) :
                            $item_id = Promen_Accessibility_Utils::generate_id('benefit-item', $widget_id . '-' . $index);
                            $icon_id = Promen_Accessibility_Utils::generate_id('benefit-icon', $widget_id . '-' . $index);
                            ?>
                            <article class="benefit-item" 
                                     role="listitem" 
                                     id="<?php echo esc_attr($item_id); ?>"
                                     <?php if (!empty($item['benefit_title'])) : ?>aria-labelledby="<?php echo esc_attr($icon_id); ?>"<?php endif; ?>
                                     tabindex="0">
                                
                                <?php if (!empty($item['benefit_icon']['value'])) : ?>
                                    <div class="benefit-icon" 
                                         id="<?php echo esc_attr($icon_id); ?>"
                                         role="img" 
                                         aria-label="<?php echo esc_attr(sprintf(__('Icon for %s', 'promen-elementor-widgets'), $item['benefit_title'])); ?>">
                                        <?php \Elementor\Icons_Manager::render_icon($item['benefit_icon'], ['aria-hidden' => 'true']); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="benefit-content">
                                    <?php if (!empty($item['benefit_title'])) : ?>
                                        <h3 class="benefit-title" 
                                            id="<?php echo esc_attr($icon_id); ?>">
                                            <?php echo esc_html($item['benefit_title']); ?>
                                        </h3>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($item['benefit_description'])) : ?>
                                        <p class="benefit-description" 
                                           aria-describedby="<?php echo esc_attr($icon_id); ?>">
                                            <?php echo esc_html($item['benefit_description']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </article>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <!-- Media Container -->
                <aside class="benefits-media" 
                       role="complementary" 
                       aria-label="<?php echo esc_attr__('Supporting media content', 'promen-elementor-widgets'); ?>">
                    <?php if ($settings['media_type'] === 'image' && !empty($settings['image']['url'])) : ?>
                        <figure class="benefits-figure" role="img" aria-label="<?php echo esc_attr__('Supporting image for benefits', 'promen-elementor-widgets'); ?>">
                            <img src="<?php echo esc_url($settings['image']['url']); ?>"
                                 alt="<?php echo esc_attr($settings['image']['alt'] ?: (isset($settings['title']) ? $settings['title'] : '')); ?>"
                                 class="benefits-img"
                                 loading="lazy">
                            <?php if (!empty($settings['image']['caption'])) : ?>
                                <figcaption class="benefits-caption">
                                    <?php echo esc_html($settings['image']['caption']); ?>
                                </figcaption>
                            <?php endif; ?>
                        </figure>
                    <?php elseif ($settings['media_type'] === 'video') : ?>
                        <?php
                        $video_attributes = [];
                        $video_id = Promen_Accessibility_Utils::generate_id('benefits-video', $widget_id);
                        
                        // Add video attributes
                        if ($settings['video_controls'] === 'yes') {
                            $video_attributes[] = 'controls';
                        }
                        if ($settings['video_autoplay'] === 'yes') {
                            $video_attributes[] = 'autoplay';
                            $video_attributes[] = 'playsinline';
                        }
                        if ($settings['video_loop'] === 'yes') {
                            $video_attributes[] = 'loop';
                        }
                        if ($settings['video_mute'] === 'yes') {
                            $video_attributes[] = 'muted';
                        }
                        
                        $video_attributes_string = implode(' ', $video_attributes);
                        ?>
                        
                        <?php if ($settings['video_source'] === 'upload' && !empty($settings['video_upload']['url'])) : ?>
                            <?php 
                            // Add animation class if set
                            $animation_class = !empty($settings['video_hover_animation']) ? 'elementor-animation-' . $settings['video_hover_animation'] : '';
                            ?>
                            <figure class="benefits-video-container <?php echo esc_attr($animation_class); ?>" 
                                    role="img" 
                                    aria-label="<?php echo esc_attr__('Supporting video for benefits', 'promen-elementor-widgets'); ?>">
                                <video class="benefits-video" 
                                       id="<?php echo esc_attr($video_id); ?>"
                                       <?php echo esc_attr($video_attributes_string); ?>
                                       aria-label="<?php echo esc_attr__('Benefits explanation video', 'promen-elementor-widgets'); ?>">
                                    <source src="<?php echo esc_url($settings['video_upload']['url']); ?>" type="video/mp4">
                                    <?php esc_html_e('Uw browser ondersteunt de video tag niet.', 'promen-elementor-widgets'); ?>
                                </video>
                                <?php if (isset($settings['video_overlay']) && $settings['video_overlay'] === 'yes') : ?>
                                    <div class="benefits-video-overlay" aria-hidden="true"></div>
                                <?php endif; ?>
                            </figure>
                        <?php elseif ($settings['video_source'] === 'external' && !empty($settings['video_url']['url'])) : ?>
                            <?php
                            // Get the external video URL
                            $external_url = $settings['video_url']['url'];
                            
                            // Determine video type based on file extension
                            $video_type = 'video/mp4'; // Default type
                            $url_parts = parse_url($external_url);
                            if (isset($url_parts['path'])) {
                                $extension = strtolower(pathinfo($url_parts['path'], PATHINFO_EXTENSION));
                                switch ($extension) {
                                    case 'webm':
                                        $video_type = 'video/webm';
                                        break;
                                    case 'ogv':
                                    case 'ogg':
                                        $video_type = 'video/ogg';
                                        break;
                                    case 'mov':
                                        $video_type = 'video/quicktime';
                                        break;
                                    // Default is already set to mp4
                                }
                            }
                            
                            // Add animation class if set
                            $animation_class = !empty($settings['video_hover_animation']) ? 'elementor-animation-' . $settings['video_hover_animation'] : '';
                            ?>
                            <figure class="benefits-video-container <?php echo esc_attr($animation_class); ?>" 
                                    role="img" 
                                    aria-label="<?php echo esc_attr__('Supporting video for benefits', 'promen-elementor-widgets'); ?>">
                                <video class="benefits-video" 
                                       id="<?php echo esc_attr($video_id); ?>"
                                       <?php echo esc_attr($video_attributes_string); ?>
                                       aria-label="<?php echo esc_attr__('Benefits explanation video', 'promen-elementor-widgets'); ?>">
                                    <source src="<?php echo esc_url($external_url); ?>" type="<?php echo esc_attr($video_type); ?>">
                                    <?php esc_html_e('Uw browser ondersteunt de video tag niet.', 'promen-elementor-widgets'); ?>
                                </video>
                                <?php if (isset($settings['video_overlay']) && $settings['video_overlay'] === 'yes') : ?>
                                    <div class="benefits-video-overlay" aria-hidden="true"></div>
                                <?php endif; ?>
                            </figure>
                        <?php elseif ($settings['video_source'] === 'embedded' && !empty($settings['embedded_video_url'])) : ?>
                            <?php
                            $video_url = $settings['embedded_video_url'];
                            $embed_params = [];
                            $ratio_class = 'embed-responsive-16by9'; // Default
                            
                            // Set aspect ratio
                            switch ($settings['embedded_video_ratio']) {
                                case '4:3':
                                    $ratio_class = 'embed-responsive-4by3';
                                    break;
                                case '3:2':
                                    $ratio_class = 'embed-responsive-3by2';
                                    break;
                                case '1:1':
                                    $ratio_class = 'embed-responsive-1by1';
                                    break;
                                default:
                                    $ratio_class = 'embed-responsive-16by9';
                            }
                            
                            // Add video parameters
                            if ($settings['video_autoplay'] === 'yes') {
                                $embed_params['autoplay'] = '1';
                            }
                            if ($settings['video_loop'] === 'yes') {
                                $embed_params['loop'] = '1';
                            }
                            if ($settings['video_controls'] === 'yes') {
                                $embed_params['controls'] = '1';
                            } else {
                                $embed_params['controls'] = '0';
                            }
                            if ($settings['video_mute'] === 'yes') {
                                $embed_params['mute'] = '1';
                            }
                            
                            // Generate iframe
                            $iframe_html = wp_oembed_get($video_url, $embed_params);
                            
                            // Add animation class if set
                            $animation_class = !empty($settings['video_hover_animation']) ? 'elementor-animation-' . $settings['video_hover_animation'] : '';
                            ?>
                            <figure class="benefits-video-embed-container <?php echo esc_attr($animation_class); ?>" 
                                    role="img" 
                                    aria-label="<?php echo esc_attr__('Supporting embedded video for benefits', 'promen-elementor-widgets'); ?>">
                                <div class="benefits-video-embed embed-responsive <?php echo esc_attr($ratio_class); ?>">
                                    <?php echo $iframe_html; ?>
                                </div>
                            </figure>
                        <?php endif; ?>
                    <?php endif; ?>
                </aside>
            </div>
        </section>
        <?php
    }
}
