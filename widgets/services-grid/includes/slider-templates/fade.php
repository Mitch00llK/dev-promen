<?php
/**
 * Fade Slider Template for Services Grid Widget
 * 
 * This template provides a fade transition effect between slides.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Default slider options for fade template
$default_options = [
    'slidesPerView' => 1,
    'spaceBetween' => 0,
    'navigation' => true,
    'pagination' => true,
    'loop' => true,
    'autoplay' => true,
    'autoplayDelay' => 5000,
    'effect' => 'fade',
    'fadeEffect' => [
        'crossFade' => true
    ],
];

// Merge with user settings
$slider_options = isset($slider_settings) ? array_merge($default_options, $slider_settings) : $default_options;

// Generate unique ID for this slider instance
$slider_id = 'services-slider-fade-' . uniqid();

// Prepare slider attributes
$slider_attributes = [
    'data-slides-per-view' => $slider_options['slidesPerView'],
    'data-space-between' => $slider_options['spaceBetween'],
    'data-navigation' => $slider_options['navigation'] ? 'true' : 'false',
    'data-pagination' => $slider_options['pagination'] ? 'true' : 'false',
    'data-loop' => $slider_options['loop'] ? 'true' : 'false',
    'data-autoplay' => $slider_options['autoplay'] ? 'true' : 'false',
    'data-autoplay-delay' => $slider_options['autoplayDelay'],
    'data-effect' => $slider_options['effect'],
    'data-fade-effect' => json_encode($slider_options['fadeEffect']),
];

$slider_attr_string = '';
foreach ($slider_attributes as $key => $value) {
    $slider_attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
}
?>

<div class="services-slider-container services-slider-fade-container">
    <!-- Slider main container -->
    <div id="<?php echo esc_attr($slider_id); ?>" class="swiper services-slider services-slider-fade"<?php echo $slider_attr_string; ?>>
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper" <?php if (!empty($services_array)) : ?>role="list" aria-label="<?php esc_attr_e('Lijst met alle services die u kunt bekijken en waarop u kunt klikken voor meer informatie', 'promen-elementor-widgets'); ?>"<?php endif; ?>>
            <?php
            foreach ($services_array as $index => $service) :
                $target = !empty($service['service_link']['is_external']) ? ' target="_blank"' : '';
                $nofollow = !empty($service['service_link']['nofollow']) ? ' rel="nofollow"' : '';
                $url = !empty($service['service_link']['url']) ? $service['service_link']['url'] : '#';
                
                // Generate service accessibility attributes for slider template
                $service_attrs = Promen_Accessibility_Utils::get_service_attrs($service, $index, $slider_id);
                ?>
                <!-- Slides -->
                <div class="swiper-slide" id="<?php echo esc_attr($service_attrs['service_item_id']); ?>">
                    <article class="service-card service-card-fade" 
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
        
        <?php if ($slider_options['pagination']) : ?>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        <?php endif; ?>
        
        <?php if ($slider_options['navigation']) : ?>
            <!-- Navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        <?php endif; ?>
    </div>
</div> 