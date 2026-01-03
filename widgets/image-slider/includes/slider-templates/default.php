<?php
/**
 * Default Slider Template for Business Catering Widget
 * 
 * This template provides a standard slider layout with navigation and pagination.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Default slider options
$default_options = [
    'slidesPerView' => 1,
    'spaceBetween' => 30,
    'navigation' => true,
    'pagination' => true,
    'loop' => true,
    'autoplay' => false,
    'effect' => 'slide',
];

// Merge with user settings
$slider_options = isset($slider_settings) ? array_merge($default_options, $slider_settings) : $default_options;

// Generate unique ID for this slider instance
$slider_id = 'promen-slider-' . uniqid();

// Prepare slider attributes
$slider_attributes = [
    'data-slides-per-view' => $slider_options['slidesPerView'],
    'data-space-between' => $slider_options['spaceBetween'],
    'data-navigation' => $slider_options['navigation'] ? 'true' : 'false',
    'data-pagination' => $slider_options['pagination'] ? 'true' : 'false',
    'data-loop' => $slider_options['loop'] ? 'true' : 'false',
    'data-autoplay' => $slider_options['autoplay'] ? 'true' : 'false',
    'data-effect' => $slider_options['effect'],
];

$slider_attr_string = '';
foreach ($slider_attributes as $key => $value) {
    $slider_attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
}
?>

<div class="promen-slider-container">
    <?php if ($gradient_overlay) : ?>
        <div class="promen-slider-gradient-left" style="<?php echo esc_attr($gradient_left_style); ?>"></div>
        <div class="promen-slider-gradient-right" style="<?php echo esc_attr($gradient_right_style); ?>"></div>
    <?php endif; ?>
    
    <!-- Slider main container -->
    <div id="<?php echo esc_attr($slider_id); ?>" class="swiper promen-slider"<?php echo $slider_attr_string; ?>>
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <?php foreach ($catering_images as $index => $item) : ?>
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