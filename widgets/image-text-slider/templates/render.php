<?php
/**
 * Image Text Slider Widget Render Template
 * 
 * Main rendering template for the Image Text Slider widget.
 * Variables are passed from the widget render() method.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Ensure variables are set (defensive coding)
if (!isset($visible_slides) || !isset($slider_options)) {
    return;
}
?>

<div class="<?php echo esc_attr($container_class); ?>" id="<?php echo esc_attr($slider_id); ?>" data-options='<?php echo json_encode($slider_options); ?>' style="--swiper-transition-duration: <?php echo $transition_speed; ?>ms;" <?php echo $accessibility_attrs['container_attrs']; ?>>
    <!-- ARIA live region for slide announcements -->
    <div id="<?php echo esc_attr($accessibility_attrs['live_region_id']); ?>" <?php echo $accessibility_attrs['live_region_attrs']; ?>></div>
    
    <!-- Persistent slider controls in top right corner -->
    <?php if (count($visible_slides) >= 3) : ?>
    <div class="image-text-slider-controls-persistent" role="group" aria-label="<?php echo esc_attr__('Slideshow controls', 'promen-elementor-widgets'); ?>">
        <!-- Play/Pause and Stop buttons -->
        <?php if ($slider_options['autoplay']) : ?>
        <button type="button" class="slider-play-pause active" 
                <?php echo $accessibility_attrs['play_button_attrs']; ?>
                title="<?php echo esc_attr__('Pauzeer slideshow', 'promen-elementor-widgets'); ?>"
                data-tooltip-play="<?php echo esc_attr__('Start slideshow', 'promen-elementor-widgets'); ?>"
                data-tooltip-pause="<?php echo esc_attr__('Pauzeer slideshow', 'promen-elementor-widgets'); ?>">
            <span class="play-icon" aria-hidden="true">⏸</span>
            <span class="pause-icon" aria-hidden="true" style="display: none;">▶</span>
            <span class="control-text">Pauzeer slideshow</span>
        </button>
        <button type="button" class="slider-stop" aria-label="<?php echo esc_attr__('Stop slideshow', 'promen-elementor-widgets'); ?>"
                aria-controls="<?php echo esc_attr($accessibility_attrs['container_id']); ?>"
                aria-pressed="false"
                title="<?php echo esc_attr__('Stop slideshow', 'promen-elementor-widgets'); ?>"
                data-tooltip-stop="<?php echo esc_attr__('Stop slideshow', 'promen-elementor-widgets'); ?>"
                data-tooltip-start="<?php echo esc_attr__('Start slideshow', 'promen-elementor-widgets'); ?>">
            <span class="stop-icon" aria-hidden="true">⏹</span>
            <span class="start-icon" aria-hidden="true" style="display: none;">▶</span>
            <span class="control-text"><?php echo esc_html__('Stop slideshow', 'promen-elementor-widgets'); ?></span>
        </button>
        <?php else : ?>
        <button type="button" class="slider-play-pause" 
                aria-label="<?php echo esc_attr__('Start slideshow', 'promen-elementor-widgets'); ?>"
                aria-pressed="false"
                aria-controls="<?php echo esc_attr($accessibility_attrs['container_id']); ?>"
                title="<?php echo esc_attr__('Start slideshow', 'promen-elementor-widgets'); ?>"
                data-tooltip-play="<?php echo esc_attr__('Start slideshow', 'promen-elementor-widgets'); ?>"
                data-tooltip-pause="<?php echo esc_attr__('Pauzeer slideshow', 'promen-elementor-widgets'); ?>">
            <span class="play-icon" aria-hidden="true" style="display: none;">⏸</span>
            <span class="pause-icon" aria-hidden="true">▶</span>
            <span class="control-text"><?php echo esc_html__('Start slideshow', 'promen-elementor-widgets'); ?></span>
        </button>
        <?php endif; ?>
        
        <!-- Fraction indicator -->
        <div class="slider-fraction-indicator-persistent" aria-live="polite" aria-atomic="true">
            <span class="current-slide">1</span>
            <span class="separator"> / </span>
            <span class="total-slides"><?php echo count($visible_slides); ?></span>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="swiper" role="img" aria-label="<?php echo esc_attr__('Image carousel', 'promen-elementor-widgets'); ?>"<?php echo $divider_data_attrs; ?>>
        <div class="swiper-wrapper">
            <?php 
            // Include slide image template for each slide
            foreach ($visible_slides as $index => $slide) {
                include(__DIR__ . '/partials/_slide_image.php');
            } 
            ?>
        </div>
        
        <?php if ($show_pagination) : ?>
            <!-- Pagination removed from top of slider as requested -->
        <?php endif; ?>
        
    </div>
    
    <div class="slide-content-wrapper" 
         role="complementary" 
         aria-label="<?php echo esc_attr(sprintf(_n('Slide content area with %d slide', 'Slide content area with %d slides', count($visible_slides), 'promen-elementor-widgets'), count($visible_slides))); ?>"
         aria-describedby="<?php echo esc_attr($accessibility_attrs['live_region_id']); ?>">
        <!-- Screen reader context for content area -->
        <?php echo Promen_Accessibility_Utils::get_screen_reader_text(sprintf(__('Content area: Navigate through %d slides to view different content sections.', 'promen-elementor-widgets'), count($visible_slides))); ?>
        <div class="swiper-content-slider" data-slider-id="<?php echo esc_attr($slider_id); ?>" role="region" aria-label="<?php echo esc_attr__('Slide content', 'promen-elementor-widgets'); ?>">
            <div class="swiper-wrapper">
                <?php 
                // Include slide content template for each slide
                foreach ($visible_slides as $index => $slide) {
                    $slide_number = $index + 1;
                    $total_slides = count($visible_slides);
                    include(__DIR__ . '/partials/_slide_content.php');
                } 
                ?>
            </div>
        </div>
    </div>

    <!-- Spacer element to ensure content below is pushed down properly -->
    <div class="slider-bottom-spacer"></div>
    
    <?php if (\Elementor\Plugin::$instance->editor->is_edit_mode()) : ?>
    <!-- Visual indicator for bottom spacing in editor only -->
    <div class="editor-spacing-indicator">
        <span>Bottom Spacing Area</span>
        <small>This space accounts for overflowing content like absolute positioned images</small>
    </div>
    <?php endif; ?>
</div>