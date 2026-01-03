<?php
/**
 * Spring Slider Template for Image Slider Widget
 * 
 * This template provides a spring transition slider layout with navigation and pagination.
 * 
 * Expected variables:
 * @var array $settings Widget settings
 * @var array $slider_images Array of slider images
 * @var array $slider_settings Slider configuration
 * @var bool $gradient_overlay Whether gradient overlay is enabled
 * @var string $gradient_left_style Left gradient style
 * @var string $gradient_right_style Right gradient style
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Default slider options with spring effect
$default_options = [
    'slidesPerView' => 1,
    'spaceBetween' => 30,
    'navigation' => true,
    'pagination' => true,
    'loop' => true,
    'autoplay' => false,
    'effect' => 'creative',
    'creativeEffect' => [
        'prev' => [
            'translate' => [0, 0, -400],
            'scale' => 0.75,
            'origin' => 'left center'
        ],
        'next' => [
            'translate' => [0, 0, -400],
            'scale' => 0.75,
            'origin' => 'right center'
        ]
    ],
];

// Merge with user settings
$slider_options = isset($slider_settings) ? array_merge($default_options, $slider_settings) : $default_options;
$slider_options['effect'] = 'creative'; // Force creative effect for spring animation

// Generate unique ID for this slider instance
$slider_id = 'promen-slider-spring-' . uniqid();

// Prepare slider attributes
$slider_attributes = [
    'data-slides-per-view' => $slider_options['slidesPerView'],
    'data-space-between' => $slider_options['spaceBetween'],
    'data-navigation' => $slider_options['navigation'] ? 'true' : 'false',
    'data-pagination' => $slider_options['pagination'] ? 'true' : 'false',
    'data-loop' => $slider_options['loop'] ? 'true' : 'false',
    'data-autoplay' => $slider_options['autoplay'] ? 'true' : 'false',
    'data-autoplay-delay' => isset($slider_options['autoplayDelay']) ? $slider_options['autoplayDelay'] : 5000,
    'data-effect' => 'creative',
    'data-speed' => isset($slider_options['speed']) ? $slider_options['speed'] : 500,
    'data-spring-effect' => 'true'
];

$slider_attr_string = '';
foreach ($slider_attributes as $key => $value) {
    $slider_attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
}

// Ensure gradient overlay settings are available
$gradient_overlay = isset($settings['gradient_overlay']) ? $settings['gradient_overlay'] === 'yes' : false;
?>

<div class="promen-slider-container promen-slider-spring-container">
    <?php if ($gradient_overlay) : ?>
        <div class="promen-slider-gradient-left" style="<?php echo esc_attr($gradient_left_style); ?>"></div>
        <div class="promen-slider-gradient-right" style="<?php echo esc_attr($gradient_right_style); ?>"></div>
    <?php endif; ?>
    
    <!-- Slider main container -->
    <div id="<?php echo esc_attr($slider_id); ?>" class="swiper promen-slider promen-slider-spring"<?php echo $slider_attr_string; ?>>
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
                                        <h3 class="promen-slider-overlay-title"><?php echo esc_html($item['title']); ?></h3>
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

        <?php if ($slider_options['navigation']) : ?>
            <!-- Navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        <?php endif; ?>

        <?php if ($slider_options['pagination']) : ?>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        <?php endif; ?>
    </div>
</div> 