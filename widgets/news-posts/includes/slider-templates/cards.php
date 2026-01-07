<?php
/**
 * Cards Slider Template for News Posts Widget
 * 
 * This template provides a card-style slider layout with multiple slides per view.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Default slider options for cards template
$default_options = [
    'slidesPerView' => 'auto',
    'spaceBetween' => 20,
    'centeredSlides' => false,
    'navigation' => true,
    'pagination' => true,
    'loop' => true,
    'autoplay' => false,
    'effect' => 'slide',
    'breakpoints' => [
        '576' => [
            'slidesPerView' => 1.2,
            'spaceBetween' => 20,
        ],
        '768' => [
            'slidesPerView' => 2.2,
            'spaceBetween' => 30,
        ],
    ],
];

// Merge with user settings
$slider_options = isset($slider_settings) ? array_merge($default_options, $slider_settings) : $default_options;

// Generate unique ID for this slider instance
$slider_id = 'promen-news-slider-cards-' . uniqid();

// Prepare slider attributes
$slider_attributes = [
    'data-slides-per-view' => $slider_options['slidesPerView'],
    'data-space-between' => $slider_options['spaceBetween'],
    'data-centered-slides' => $slider_options['centeredSlides'] ? 'true' : 'false',
    'data-navigation' => $slider_options['navigation'] ? 'true' : 'false',
    'data-pagination' => $slider_options['pagination'] ? 'true' : 'false',
    'data-loop' => $slider_options['loop'] ? 'true' : 'false',
    'data-autoplay' => $slider_options['autoplay'] ? 'true' : 'false',
    'data-effect' => $slider_options['effect'],
    'data-breakpoints' => json_encode($slider_options['breakpoints']),
];

$slider_attr_string = '';
foreach ($slider_attributes as $key => $value) {
    $slider_attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
}
?>

<div class="promen-news-slider-container promen-news-slider-cards-container" role="region" aria-label="<?php echo esc_attr__('Content slider', 'promen-elementor-widgets'); ?>">
    <!-- Slider main container -->
    <div id="<?php echo esc_attr($slider_id); ?>" 
         class="swiper promen-news-slider promen-news-slider-cards" 
         role="region" 
         aria-label="<?php echo esc_attr__('Content carousel', 'promen-elementor-widgets'); ?>"
         <?php echo $slider_attr_string; ?>>
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
            <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                <!-- Slides -->
                <div class="swiper-slide" 
                     role="group" 
                     aria-roledescription="slide" 
                     aria-label="<?php echo esc_attr(sprintf(__('Slide %d of %d', 'promen-elementor-widgets'), $posts_query->current_post + 1, $posts_query->post_count)); ?>">
                    <article class="promen-content-card">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="promen-content-image-wrapper">
                                <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'large')); ?>" 
                                     alt="<?php echo esc_attr(get_the_title()); ?>" 
                                     class="promen-content-image"
                                     loading="lazy"
                                     width="400" 
                                     height="300">
                            </div>
                        <?php endif; ?>
                        
                        <div class="promen-content-content">
                            <span id="cards-slider-post-title-<?php echo esc_attr(get_the_ID()); ?>" class="promen-content-post-title"><?php the_title(); ?></span>
                            <p class="promen-content-excerpt">
                                <?php 
                                $excerpt = get_the_excerpt();
                                $excerpt_length = intval($template_settings['excerpt_length']);
                                
                                // Only process if excerpt is not empty
                                if (!empty($excerpt) && trim($excerpt) !== '...') {
                                    // Remove any existing ellipsis from WordPress's excerpt (both Unicode and regular dots)
                                    $excerpt = preg_replace('/[….]+\s*$/', '', trim($excerpt));
                                    
                                    // Only truncate and add ellipsis if excerpt is longer than the limit
                                    if ($excerpt_length > 0 && mb_strlen($excerpt) > $excerpt_length) {
                                        $excerpt = mb_substr($excerpt, 0, $excerpt_length) . '...';
                                    }
                                    
                                    echo esc_html($excerpt);
                                } else {
                                    // If excerpt is empty or just "...", try to get content excerpt
                                    $content = get_the_content();
                                    $content = strip_tags($content);
                                    $content = strip_shortcodes($content);
                                    
                                    if (!empty($content)) {
                                        if ($excerpt_length > 0 && mb_strlen($content) > $excerpt_length) {
                                            $excerpt = mb_substr($content, 0, $excerpt_length) . '...';
                                        } else {
                                            $excerpt = $content;
                                        }
                                        echo esc_html($excerpt);
                                    }
                                }
                                ?>
                            </p>
                            <a href="<?php echo esc_url(get_permalink()); ?>" 
                               class="promen-content-read-more" 
                               aria-label="<?php echo esc_attr__('Read more about', 'promen-elementor-widgets') . ' ' . esc_attr(get_the_title()); ?>">
                                <?php if (!empty($template_settings['read_more_icon']['value']) && $template_settings['read_more_icon_position'] === 'before') : ?>
                                    <span class="button-icon-before" aria-hidden="true">
                                        <?php \Elementor\Icons_Manager::render_icon($template_settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="button-text"><?php echo esc_html($template_settings['read_more_text']); ?></span>
                                <?php if (!empty($template_settings['read_more_icon']['value']) && $template_settings['read_more_icon_position'] === 'after') : ?>
                                    <span class="button-icon-after" aria-hidden="true">
                                        <?php \Elementor\Icons_Manager::render_icon($template_settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                                    </span>
                                <?php endif; ?>
                            </a>
                        </div>
                    </article>
                </div>
            <?php endwhile; ?>
        </div>
        
        <?php if ($slider_options['pagination']) : ?>
            <!-- Pagination -->
            <div class="swiper-pagination" 
                 role="tablist" 
                 aria-label="<?php echo esc_attr__('Slider pagination', 'promen-elementor-widgets'); ?>"></div>
        <?php endif; ?>
        
        <?php if ($slider_options['navigation']) : ?>
            <!-- Navigation buttons -->
            <button class="swiper-button-prev" 
                    aria-label="<?php echo esc_attr__('Previous slide', 'promen-elementor-widgets'); ?>"
                    type="button">
                <span class="sr-only"><?php echo esc_html__('Previous slide', 'promen-elementor-widgets'); ?></span>
            </button>
            <button class="swiper-button-next" 
                    aria-label="<?php echo esc_attr__('Next slide', 'promen-elementor-widgets'); ?>"
                    type="button">
                <span class="sr-only"><?php echo esc_html__('Next slide', 'promen-elementor-widgets'); ?></span>
            </button>
        <?php endif; ?>
    </div>
</div> 