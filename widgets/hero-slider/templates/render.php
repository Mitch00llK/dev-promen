<?php
/**
 * Hero Slider Widget Render Template
 * 
 * Optimized version with improved performance and structure
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$settings = $this->get_settings_for_display();
$id_int = substr($this->get_id_int(), 0, 3);
$slider_id = 'hero-slider-' . $id_int;

// Determine if we're showing a slider or a static header
$is_slider = $settings['display_type'] === 'slider';
$static_slide_index = $is_slider ? 0 : (int)$settings['static_slide_index'] - 1;

// Get slides
$slides = $settings['slides'];

// Filter out hidden slides
$visible_slides = array_filter($slides, function($slide) {
    return isset($slide['show_slide']) && $slide['show_slide'] === 'yes';
});

// If no visible slides, show a message
if (empty($visible_slides)) {
    echo '<div class="hero-slider-no-slides">';
    echo esc_html__('No slides to display. Please add slides in the widget settings.', 'elementor-widgets');
    echo '</div>';
    return;
}

// Reset array keys
$visible_slides = array_values($visible_slides);

// If static mode and the index is out of bounds, use the first slide
if (!$is_slider && $static_slide_index >= count($visible_slides)) {
    $static_slide_index = 0;
}

// Prepare slider options for JS with accessibility
$slider_options = [
    'autoplay' => $is_slider && $settings['autoplay'] === 'yes',
    'autoplaySpeed' => $is_slider && $settings['autoplay'] === 'yes' ? (int)$settings['autoplay_speed'] : 5000,
    'pauseOnHover' => $is_slider && $settings['autoplay'] === 'yes' && $settings['pause_on_hover'] === 'yes',
    'infinite' => $is_slider && $settings['infinite'] === 'yes',
    'speed' => $is_slider ? (int)$settings['transition_speed'] : 500,
    'effect' => $is_slider ? $settings['transition_effect'] : 'fade',
    'heightMode' => isset($settings['slider_height_mode']) ? $settings['slider_height_mode'] : 'fixed',
    'accessibility' => [
        'keyboard' => true,
        'announcements' => true,
        'focusOnSelect' => true,
        'reducedMotion' => false // Will be set by JS based on user preference
    ]
];

// Get accessibility attributes for slider
$accessibility_attrs = Promen_Accessibility_Utils::get_slider_attrs([
    'widget_id' => $this->get_id(),
    'slides_count' => count($visible_slides),
    'autoplay' => $slider_options['autoplay'],
    'loop' => $slider_options['infinite']
]);

// Prepare navigation options
$show_arrows = $is_slider && $settings['show_arrows'] === 'yes';
$show_pagination = $is_slider && $settings['show_pagination'] === 'yes';
$pagination_type = $show_pagination ? $settings['pagination_type'] : 'none';
$pagination_position = $show_pagination ? $settings['pagination_position'] : 'bottom-center';

// Prepare classes
$container_classes = ['hero-slider-container'];
if ($is_slider) {
    $container_classes[] = 'hero-slider-mode';
} else {
    $container_classes[] = 'hero-static-mode';
}

// Add height mode class
if (isset($settings['slider_height_mode'])) {
    $container_classes[] = 'height-mode-' . $settings['slider_height_mode'];
}

// Add overlay class if needed
if ($settings['overlay_type'] !== 'none') {
    $container_classes[] = 'has-overlay';
    $container_classes[] = 'overlay-' . $settings['overlay_type'];
}

// Add content overflow class if enabled
if (isset($settings['content_overflow']) && $settings['content_overflow'] === 'yes') {
    $container_classes[] = 'content-overflow-yes';
}

// Add pagination position class
if ($show_pagination) {
    $container_classes[] = 'pagination-' . $pagination_position;
}

// Add arrows position class
if ($show_arrows) {
    $container_classes[] = 'arrows-' . $settings['arrows_position'];
}

$container_class = implode(' ', $container_classes);

// For progressive loading: separate first slide from remaining slides
$first_slide = !empty($visible_slides) ? $visible_slides[0] : null;
$remaining_slides = count($visible_slides) > 1 ? array_slice($visible_slides, 1) : [];

// Helper function to render a single slide HTML
function render_slide_html($slide, $index, $total_slides, $settings, $show_arrows, $accessibility_attrs, $is_slider) {
    $slide_number = $index + 1;
    ob_start();
    ?>
    <div class="hero-slide swiper-slide elementor-repeater-item-<?php echo esc_attr($slide['_id']); ?>" 
         role="group" 
         aria-roledescription="<?php echo esc_attr__('slide', 'promen-elementor-widgets'); ?>" 
         aria-label="<?php echo esc_attr(sprintf(__('Slide %d of %d', 'promen-elementor-widgets'), $slide_number, $total_slides)); ?>">
        <?php if (!empty($slide['background_image']['url'])) : 
            $image_size = !empty($slide['image_size']) ? $slide['image_size'] : 'full';
            $image_id = $slide['background_image']['id'];
            $image_url = $image_id ? wp_get_attachment_image_url($image_id, $image_size) : $slide['background_image']['url'];
            
            // Image position
            $image_position = !empty($slide['image_position']) ? $slide['image_position'] : 'center center';
            
            $bg_style = 'background-image: url(' . esc_url($image_url) . '); background-position: ' . esc_attr($image_position) . ';';
            
            // Get alt text for accessibility
            $alt_text = '';
            if ($image_id) {
                $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            }
            if (empty($alt_text) && !empty($slide['title_text'])) {
                $alt_text = $slide['title_text'];
            }
            if (empty($alt_text)) {
                $alt_text = __('Slide background image', 'promen-elementor-widgets');
            }
        ?>
        <div class="hero-slide-background" style="<?php echo $bg_style; ?>" 
             role="img" 
             aria-label="<?php echo esc_attr($alt_text); ?>"></div>
        <?php endif; ?>
        
        <?php if ($settings['overlay_type'] !== 'none') : ?>
        <div class="hero-slide-overlay"></div>
        <?php endif; ?>
        
        <div class="hero-slide-content-container">
            <div class="hero-slide-content-wrapper">
                <?php if (isset($slide['show_title']) && $slide['show_title'] === 'yes' && !empty($slide['title_text'])) : 
                    $title_tag = isset($slide['title_tag']) ? $slide['title_tag'] : 'h2';
                ?>
                    <<?php echo esc_attr($title_tag); ?> class="hero-slide-title"><?php echo esc_html($slide['title_text']); ?></<?php echo esc_attr($title_tag); ?>>
                <?php endif; ?>
                
                <?php if (isset($slide['show_content']) && $slide['show_content'] === 'yes' && !empty($slide['content'])) : ?>
                <div class="hero-slide-content">
                    <p><?php echo wp_kses_post($slide['content']); ?></p>
                </div>
                <?php endif; ?>
                
                <div class="hero-slide-buttons">
                    <?php if (isset($slide['show_button_1']) && $slide['show_button_1'] === 'yes' && !empty($slide['button_1_text'])) : 
                        $button_1_url = !empty($slide['button_1_link']['url']) ? $slide['button_1_link']['url'] : '#';
                        $button_1_target = !empty($slide['button_1_link']['is_external']) ? ' target="_blank"' : '';
                        $button_1_nofollow = !empty($slide['button_1_link']['nofollow']) ? ' rel="nofollow"' : '';
                        $button_1_animation = !empty($settings['button_1_hover_animation']) ? ' elementor-animation-' . $settings['button_1_hover_animation'] : '';
                    ?>
                    <a href="<?php echo esc_url($button_1_url); ?>" class="hero-button hero-button-1<?php echo esc_attr($button_1_animation); ?>"<?php echo $button_1_target . $button_1_nofollow; ?>>
                        <?php echo esc_html($slide['button_1_text']); ?>
                        <?php if (!empty($slide['button_1_icon']['value'])) : ?>
                        <span class="hero-button-icon">
                            <?php \Elementor\Icons_Manager::render_icon($slide['button_1_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                        <?php endif; ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if (isset($slide['show_button_2']) && $slide['show_button_2'] === 'yes' && !empty($slide['button_2_text'])) : 
                        $button_2_url = !empty($slide['button_2_link']['url']) ? $slide['button_2_link']['url'] : '#';
                        $button_2_target = !empty($slide['button_2_link']['is_external']) ? ' target="_blank"' : '';
                        $button_2_nofollow = !empty($slide['button_2_link']['nofollow']) ? ' rel="nofollow"' : '';
                        $button_2_animation = !empty($settings['button_2_hover_animation']) ? ' elementor-animation-' . $settings['button_2_hover_animation'] : '';
                    ?>
                    <a href="<?php echo esc_url($button_2_url); ?>" class="hero-button hero-button-2<?php echo esc_attr($button_2_animation); ?>"<?php echo $button_2_target . $button_2_nofollow; ?>>
                        <?php echo esc_html($slide['button_2_text']); ?>
                        <?php if (!empty($slide['button_2_icon']['value'])) : ?>
                        <span class="hero-button-icon">
                            <?php \Elementor\Icons_Manager::render_icon($slide['button_2_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                        <?php endif; ?>
                    </a>
                    <?php endif; ?>
                </div>
                
                <?php if ($is_slider && $show_arrows) : ?>
                <div class="hero-slide-navigation" role="group" aria-label="<?php echo esc_attr__('Slide navigation', 'promen-elementor-widgets'); ?>">
                    <button type="button" class="hero-slider-arrow hero-slider-arrow-prev swiper-button-prev" 
                            <?php echo $accessibility_attrs['prev_button_attrs']; ?>>
                        <?php \Elementor\Icons_Manager::render_icon($settings['prev_arrow_icon'], ['aria-hidden' => 'true']); ?>
                        <?php echo Promen_Accessibility_Utils::get_screen_reader_text(__('Previous slide', 'promen-elementor-widgets')); ?>
                    </button>
                    <button type="button" class="hero-slider-arrow hero-slider-arrow-next swiper-button-next" 
                            <?php echo $accessibility_attrs['next_button_attrs']; ?>>
                        <?php \Elementor\Icons_Manager::render_icon($settings['next_arrow_icon'], ['aria-hidden' => 'true']); ?>
                        <?php echo Promen_Accessibility_Utils::get_screen_reader_text(__('Next slide', 'promen-elementor-widgets')); ?>
                    </button>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// Prepare remaining slides data for progressive loading
$remaining_slides_data = [];
foreach ($remaining_slides as $index => $slide) {
    $remaining_slides_data[] = [
        'index' => $index + 2, // +2 because first slide is index 1, remaining start at 2
        'slide' => $slide,
        'html' => render_slide_html($slide, $index + 1, count($visible_slides), $settings, $show_arrows, $accessibility_attrs, $is_slider)
    ];
}
?>

<div class="<?php echo esc_attr($container_class); ?>" id="<?php echo esc_attr($slider_id); ?>" data-options='<?php echo json_encode($slider_options); ?>' data-display-type="<?php echo esc_attr($settings['display_type']); ?>" <?php echo $accessibility_attrs['container_attrs']; ?>>
    <?php if ($is_slider) : ?>
    <div class="hero-slider">
        <?php if ($settings['show_tilted_divider'] === 'yes' && $settings['divider_position'] === 'top') : ?>
        <div class="hero-tilted-divider"></div>
        <?php endif; ?>
        <div class="swiper" role="region" aria-label="<?php echo esc_attr__('Hero content carousel', 'promen-elementor-widgets'); ?>">
            <!-- ARIA live region for slide announcements -->
            <div id="<?php echo esc_attr($accessibility_attrs['live_region_id']); ?>" <?php echo $accessibility_attrs['live_region_attrs']; ?>></div>
            
            <div class="swiper-wrapper">
                <?php 
                // Render first slide statically for LCP optimization
                if ($first_slide) {
                    echo render_slide_html($first_slide, 0, count($visible_slides), $settings, $show_arrows, $accessibility_attrs, $is_slider);
                }
                ?>
            </div>
            
            <?php if (!empty($remaining_slides_data)) : ?>
            <!-- Remaining slides stored for progressive loading -->
            <script type="application/json" class="hero-slider-remaining-slides" style="display: none;">
                <?php echo json_encode($remaining_slides_data); ?>
            </script>
            <?php endif; ?>
            
            <?php if ($show_pagination) : ?>
            <div class="swiper-pagination" role="tablist" aria-label="<?php echo esc_attr__('Choose slide to display', 'promen-elementor-widgets'); ?>"></div>
            <?php endif; ?>
            
            <?php if ($is_slider) : ?>
            <!-- Slideshow controls for accessibility (WCAG 2.1 requirement) -->
            <div class="hero-slider-controls" role="group" aria-label="<?php echo esc_attr__('Slideshow controls', 'promen-elementor-widgets'); ?>">
                <?php if ($slider_options['autoplay']) : ?>
                <button type="button" class="hero-slider-play-pause" 
                        <?php echo $accessibility_attrs['play_button_attrs']; ?>>
                    <span class="play-icon" aria-hidden="true">⏸</span>
                    <span class="pause-icon" aria-hidden="true" style="display: none;">▶</span>
                    <span class="control-text"><?php echo esc_html__('Pause slideshow', 'promen-elementor-widgets'); ?></span>
                </button>
                <?php else : ?>
                <button type="button" class="hero-slider-play-pause" 
                        aria-label="<?php echo esc_attr__('Start slideshow', 'promen-elementor-widgets'); ?>"
                        aria-pressed="false"
                        aria-controls="<?php echo esc_attr($accessibility_attrs['container_id']); ?>">
                    <span class="play-icon" aria-hidden="true" style="display: none;">⏸</span>
                    <span class="pause-icon" aria-hidden="true">▶</span>
                    <span class="control-text"><?php echo esc_html__('Start slideshow', 'promen-elementor-widgets'); ?></span>
                </button>
                <?php endif; ?>
                
                <!-- Slide counter for screen readers -->
                <div class="hero-slider-status" aria-live="polite" aria-atomic="true">
                    <?php echo Promen_Accessibility_Utils::get_screen_reader_text(sprintf(__('Slideshow with %d slides. Current slide will be announced when changed.', 'promen-elementor-widgets'), count($visible_slides))); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <?php if ($settings['show_tilted_divider'] === 'yes' && $settings['divider_position'] === 'bottom') : ?>
        <div class="hero-tilted-divider"></div>
        <?php endif; ?>
    </div>
    <?php else : 
        // Static mode - display only the selected slide
        $slide = $visible_slides[$static_slide_index];
    ?>
    <div class="hero-static">
        <?php if ($settings['show_tilted_divider'] === 'yes' && $settings['divider_position'] === 'top') : ?>
        <div class="hero-tilted-divider"></div>
        <?php endif; ?>
        <div class="hero-slide elementor-repeater-item-<?php echo esc_attr($slide['_id']); ?>">
            <?php if (!empty($slide['background_image']['url'])) : 
                $image_size = !empty($slide['image_size']) ? $slide['image_size'] : 'full';
                $image_id = $slide['background_image']['id'];
                $image_url = $image_id ? wp_get_attachment_image_url($image_id, $image_size) : $slide['background_image']['url'];
                
                // Image position
                $image_position = !empty($slide['image_position']) ? $slide['image_position'] : 'center center';
                
                $bg_style = 'background-image: url(' . esc_url($image_url) . '); background-position: ' . esc_attr($image_position) . ';';
            ?>
            <div class="hero-slide-background" style="<?php echo $bg_style; ?>"></div>
            <?php endif; ?>
            
            <?php if ($settings['overlay_type'] !== 'none') : ?>
            <div class="hero-slide-overlay"></div>
            <?php endif; ?>
            
            <div class="hero-slide-content-container">
                <div class="hero-slide-content-wrapper">
                    <?php if ($slide['show_title'] === 'yes' && !empty($slide['title_text'])) : 
                        $title_tag = $slide['title_tag'];
                    ?>
                        <<?php echo esc_attr($title_tag); ?> class="hero-slide-title"><?php echo esc_html($slide['title_text']); ?></<?php echo esc_attr($title_tag); ?>>
                    <?php endif; ?>
                    
                    <?php if ($slide['show_content'] === 'yes' && !empty($slide['content'])) : ?>
                    <div class="hero-slide-content">
                        <p><?php echo wp_kses_post($slide['content']); ?></p>
                    </div>
                    <?php endif; ?>
                    
                    <div class="hero-slide-buttons">
                        <?php if ($slide['show_button_1'] === 'yes' && !empty($slide['button_1_text'])) : 
                            $button_1_url = !empty($slide['button_1_link']['url']) ? $slide['button_1_link']['url'] : '#';
                            $button_1_target = !empty($slide['button_1_link']['is_external']) ? ' target="_blank"' : '';
                            $button_1_nofollow = !empty($slide['button_1_link']['nofollow']) ? ' rel="nofollow"' : '';
                            $button_1_animation = !empty($settings['button_1_hover_animation']) ? ' elementor-animation-' . $settings['button_1_hover_animation'] : '';
                        ?>
                        <a href="<?php echo esc_url($button_1_url); ?>" class="hero-button hero-button-1<?php echo esc_attr($button_1_animation); ?>"<?php echo $button_1_target . $button_1_nofollow; ?>>
                            <?php echo esc_html($slide['button_1_text']); ?>
                            <?php if (!empty($slide['button_1_icon']['value'])) : ?>
                            <span class="hero-button-icon">
                                <?php \Elementor\Icons_Manager::render_icon($slide['button_1_icon'], ['aria-hidden' => 'true']); ?>
                            </span>
                            <?php endif; ?>
                        </a>
                        <?php endif; ?>
                        
                        <?php if ($slide['show_button_2'] === 'yes' && !empty($slide['button_2_text'])) : 
                            $button_2_url = !empty($slide['button_2_link']['url']) ? $slide['button_2_link']['url'] : '#';
                            $button_2_target = !empty($slide['button_2_link']['is_external']) ? ' target="_blank"' : '';
                            $button_2_nofollow = !empty($slide['button_2_link']['nofollow']) ? ' rel="nofollow"' : '';
                            $button_2_animation = !empty($settings['button_2_hover_animation']) ? ' elementor-animation-' . $settings['button_2_hover_animation'] : '';
                        ?>
                        <a href="<?php echo esc_url($button_2_url); ?>" class="hero-button hero-button-2<?php echo esc_attr($button_2_animation); ?>"<?php echo $button_2_target . $button_2_nofollow; ?>>
                            <?php echo esc_html($slide['button_2_text']); ?>
                            <?php if (!empty($slide['button_2_icon']['value'])) : ?>
                            <span class="hero-button-icon">
                                <?php \Elementor\Icons_Manager::render_icon($slide['button_2_icon'], ['aria-hidden' => 'true']); ?>
                            </span>
                            <?php endif; ?>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($settings['show_tilted_divider'] === 'yes' && $settings['divider_position'] === 'bottom') : ?>
        <div class="hero-tilted-divider"></div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
    
    <?php if ($is_slider) : ?>
    <!-- Add data attributes for JS initialization -->
    <div class="hero-slider-data" 
         data-autoplay="<?php echo esc_attr($slider_options['autoplay'] ? 'true' : 'false'); ?>"
         data-autoplay-speed="<?php echo esc_attr($slider_options['autoplaySpeed']); ?>"
         data-pause-on-hover="<?php echo esc_attr($slider_options['pauseOnHover'] ? 'true' : 'false'); ?>"
         data-infinite="<?php echo esc_attr($slider_options['infinite'] ? 'true' : 'false'); ?>"
         data-speed="<?php echo esc_attr($slider_options['speed']); ?>"
         data-effect="<?php echo esc_attr($slider_options['effect']); ?>"
         data-pagination-type="<?php echo esc_attr($pagination_type); ?>"
         data-height-mode="<?php echo esc_attr($slider_options['heightMode']); ?>"
         style="display: none;">
    </div>
    <?php endif; ?>
</div> 