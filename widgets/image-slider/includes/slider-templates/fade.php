<?php
/**
 * Fade Slider Template for Business Catering Widget
 * 
 * This template provides a fade transition slider layout with navigation and pagination.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Default slider options with fade effect
$default_options = [
    'slidesPerView' => 1,
    'spaceBetween' => 30,
    'navigation' => true,
    'pagination' => true,
    'loop' => true,
    'autoplay' => true,
    'effect' => 'fade',
];

// Merge with user settings
$slider_options = isset($slider_settings) ? array_merge($default_options, $slider_settings) : $default_options;
$slider_options['effect'] = 'fade'; // Force fade effect for this template

// Generate unique ID for this slider instance
$slider_id = 'promen-slider-fade-' . uniqid();

// Prepare slider attributes
$slider_attributes = [
    'data-slides-per-view' => $slider_options['slidesPerView'],
    'data-space-between' => $slider_options['spaceBetween'],
    'data-navigation' => $slider_options['navigation'] ? 'true' : 'false',
    'data-pagination' => $slider_options['pagination'] ? 'true' : 'false',
    'data-loop' => $slider_options['loop'] ? 'true' : 'false',
    'data-autoplay' => $slider_options['autoplay'] ? 'true' : 'false',
    'data-autoplay-delay' => isset($slider_options['autoplayDelay']) ? $slider_options['autoplayDelay'] : 5000,
    'data-effect' => 'fade',
    'data-speed' => isset($slider_options['speed']) ? $slider_options['speed'] : 500,
];

$slider_attr_string = '';
foreach ($slider_attributes as $key => $value) {
    $slider_attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
}
?>

<div class="promen-slider-container promen-slider-fade-container">
    <!-- Slider main container -->
    <div id="<?php echo esc_attr($slider_id); ?>" class="swiper promen-slider promen-slider-fade"<?php echo $slider_attr_string; ?>>
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <?php foreach ($slider_images as $index => $item) : ?>
                <!-- Slides -->
                <div class="swiper-slide">
                    <div class="promen-slider-image-wrapper">
                        <div class="promen-slider-image elementor-animation-<?php echo esc_attr($settings['image_hover_animation']); ?>">
                            <?php if (!empty($item['image']['url'])) : ?>
                                <img src="<?php echo esc_url($item['image']['url']); ?>" 
                                     alt="<?php echo esc_attr($item['title']); ?>" 
                                     class="promen-slider-img">
                            <?php endif; ?>
                            
                            <?php if (($settings['show_image_title'] === 'yes' || $settings['show_image_description'] === 'yes') && 
                                      ($item['show_overlay'] === 'yes' || $settings['show_overlay_on_hover'] === 'yes')) : ?>
                                <div class="promen-slider-overlay<?php echo $settings['show_overlay_on_hover'] === 'yes' ? ' hover-overlay' : ''; ?>">
                                    <?php if ($settings['show_image_title'] === 'yes' && !empty($item['title'])) : ?>
                                        <p class="promen-slider-overlay-title"><?php echo esc_html($item['title']); ?></p>
                                    <?php endif; ?>
                                    
                                    <?php if ($settings['show_image_description'] === 'yes' && !empty($item['description'])) : ?>
                                        <p class="promen-slider-overlay-description"><?php echo esc_html($item['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <?php if ($slider_options['pagination']) : ?>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        <?php endif; ?>
        
        <?php if ($slider_options['navigation']) : ?>
            <!-- Navigation buttons -->
            <div class="swiper-button-prev" aria-label="<?php echo esc_attr__('Previous slide', 'promen-elementor-widgets'); ?>"></div>
            <div class="swiper-button-next" aria-label="<?php echo esc_attr__('Next slide', 'promen-elementor-widgets'); ?>"></div>
        <?php endif; ?>
    </div>
</div> 