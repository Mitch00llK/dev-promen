<?php
/**
 * Slide Content Template
 * 
 * Renders the content portion of a single slide
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<div class="swiper-slide elementor-repeater-item-content-<?php echo esc_attr($slide['_id']); ?>" 
     role="group" 
     aria-roledescription="<?php echo esc_attr__('slide', 'promen-elementor-widgets'); ?>" 
     aria-label="<?php echo esc_attr(sprintf(__('Slide %d of %d', 'promen-elementor-widgets'), $slide_number, $total_slides)); ?>">
    <div class="slide-content-container" 
         role="article" 
         aria-label="<?php echo esc_attr(sprintf(__('Slide %d: %s', 'promen-elementor-widgets'), $slide_number, !empty($slide['title_text']) ? esc_attr($slide['title_text']) : sprintf(__('Slide %d', 'promen-elementor-widgets'), $slide_number))); ?>"
         aria-describedby="<?php echo esc_attr('slide-description-' . $slide['_id']); ?>">
        <?php 
        // Add breadcrumb above the content container if selected
        if ($settings['show_breadcrumb'] === 'yes' && $settings['breadcrumb_position'] === 'above') {
            echo $breadcrumb_html;
        }
        ?>
        <div class="slide-content" 
             role="main" 
             aria-labelledby="<?php echo esc_attr('slide-title-' . $slide['_id']); ?>"
             aria-describedby="<?php echo esc_attr('slide-description-' . $slide['_id']); ?>">
            <!-- Screen reader context for slide content -->
            <?php echo Promen_Accessibility_Utils::get_screen_reader_text(sprintf(__('Slide content: %s', 'promen-elementor-widgets'), !empty($slide['title_text']) ? esc_html($slide['title_text']) : sprintf(__('Slide %d of %d', 'promen-elementor-widgets'), $slide_number, $total_slides))); ?>
            <?php if (isset($slide['show_back_link']) && $slide['show_back_link'] === 'yes' && !empty($slide['back_link_text'])) : 
                $back_link_url = !empty($slide['back_link_url']['url']) ? $slide['back_link_url']['url'] : '#';
                $back_link_target = !empty($slide['back_link_url']['is_external']) ? ' target="_blank"' : '';
                $back_link_nofollow = !empty($slide['back_link_url']['nofollow']) ? ' rel="nofollow"' : '';
                $back_link_rel = $back_link_nofollow;
                if (!empty($slide['back_link_url']['is_external'])) {
                    $back_link_rel .= ($back_link_rel ? ' ' : ' rel="') . 'noopener';
                    if (!$back_link_nofollow) $back_link_rel = ' rel="noopener"';
                }
            ?>
                <nav class="slide-back-link" aria-label="<?php echo esc_attr__('Navigation', 'promen-elementor-widgets'); ?>">
                    <a href="<?php echo esc_url($back_link_url); ?>"<?php echo $back_link_target . $back_link_rel; ?> 
                       aria-label="<?php echo esc_attr(sprintf(__('Go back: %s', 'promen-elementor-widgets'), $slide['back_link_text'])); ?>">
                        <svg class="back-link-chevron" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M9.5 11L6.5 8L9.5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php echo esc_html($slide['back_link_text']); ?>
                    </a>
                </nav>
            <?php endif; ?>

            <?php if ($slide['show_title'] === 'yes' && !empty($slide['title_text'])) : 
                $title_tag = !empty($slide['title_tag']) ? $slide['title_tag'] : 'h2';
            ?>
                <<?php echo esc_attr($title_tag); ?> class="slide-title" id="<?php echo esc_attr('slide-title-' . $slide['_id']); ?>">
                    <?php echo esc_html($slide['title_text']); ?>
                </<?php echo esc_attr($title_tag); ?>>
            <?php endif; ?>

            <?php if ($slide['show_content'] === 'yes' && !empty($slide['content'])) : ?>
                <div class="slide-description" id="<?php echo esc_attr('slide-description-' . $slide['_id']); ?>">
                    <?php echo wp_kses_post($slide['content']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($slide['show_publication_date']) && $slide['show_publication_date'] === 'yes') : ?>
                <div class="slide-publication-date">
                    <?php 
                    // Get the post's publication date
                    $post_id = get_the_ID();
                    $post_date = get_the_date('d M Y', $post_id);
                    
                    echo sprintf(
                        esc_html__('Gepubliceerd op %s', 'promen-elementor-widgets'),
                        $post_date
                    ); 
                    ?>
                </div>
            <?php endif; ?>

            <?php if (($slide['show_button_1'] === 'yes' && !empty($slide['button_1_text'])) || 
                     ($slide['show_button_2'] === 'yes' && !empty($slide['button_2_text']))) : ?>
                <div class="slide-buttons">
                    <?php if ($slide['show_button_1'] === 'yes' && !empty($slide['button_1_text'])) : 
                        $button_1_url = !empty($slide['button_1_link']['url']) ? $slide['button_1_link']['url'] : '#';
                        $button_1_target = !empty($slide['button_1_link']['is_external']) ? ' target="_blank"' : '';
                        $button_1_nofollow = !empty($slide['button_1_link']['nofollow']) ? ' rel="nofollow"' : '';
                    ?>
                        <?php
                        // Create accessible button attributes
                        $button_1_rel = $button_1_nofollow;
                        if (!empty($slide['button_1_link']['is_external'])) {
                            $button_1_rel .= ($button_1_rel ? ' ' : ' rel="') . 'noopener';
                            if (!$button_1_nofollow) $button_1_rel = ' rel="noopener"';
                        }
                        ?>
                        <a href="<?php echo esc_url($button_1_url); ?>" 
                           class="slide-button button-1"
                           <?php echo $button_1_target . $button_1_rel; ?>
                           aria-label="<?php echo esc_attr(sprintf(__('Button: %s', 'promen-elementor-widgets'), $slide['button_1_text'])); ?>">
                            <?php echo esc_html($slide['button_1_text']); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if ($slide['show_button_2'] === 'yes' && !empty($slide['button_2_text'])) : 
                        $button_2_url = !empty($slide['button_2_link']['url']) ? $slide['button_2_link']['url'] : '#';
                        $button_2_target = !empty($slide['button_2_link']['is_external']) ? ' target="_blank"' : '';
                        $button_2_nofollow = !empty($slide['button_2_link']['nofollow']) ? ' rel="nofollow"' : '';
                        
                        // Create accessible button attributes
                        $button_2_rel = $button_2_nofollow;
                        if (!empty($slide['button_2_link']['is_external'])) {
                            $button_2_rel .= ($button_2_rel ? ' ' : ' rel="') . 'noopener';
                            if (!$button_2_nofollow) $button_2_rel = ' rel="noopener"';
                        }
                    ?>
                        <a href="<?php echo esc_url($button_2_url); ?>" 
                           class="slide-button button-2"
                           <?php echo $button_2_target . $button_2_rel; ?>
                           aria-label="<?php echo esc_attr(sprintf(__('Button: %s', 'promen-elementor-widgets'), $slide['button_2_text'])); ?>">
                            <?php echo esc_html($slide['button_2_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Slider controls inside slide content - only show if 3+ slides -->
            <?php if (count($visible_slides) >= 3) : ?>
            <div class="image-text-slider-controls" role="group" aria-label="<?php echo esc_attr__('Slideshow controls', 'promen-elementor-widgets'); ?>">
                <!-- Navigation buttons -->
                <?php if ($show_arrows) : ?>
                <button type="button" class="slider-arrow slider-arrow-prev swiper-button-prev" 
                        data-slider-id="<?php echo esc_attr($slider_id); ?>"
                        <?php echo $accessibility_attrs['prev_button_attrs']; ?>>
                    <span aria-hidden="true">‹</span>
                    <?php echo Promen_Accessibility_Utils::get_screen_reader_text(__('Previous slide', 'promen-elementor-widgets')); ?>
                </button>
                <button type="button" class="slider-arrow slider-arrow-next swiper-button-next" 
                        data-slider-id="<?php echo esc_attr($slider_id); ?>"
                        <?php echo $accessibility_attrs['next_button_attrs']; ?>>
                    <span aria-hidden="true">›</span>
                    <?php echo Promen_Accessibility_Utils::get_screen_reader_text(__('Next slide', 'promen-elementor-widgets')); ?>
                </button>
                <?php endif; ?>
                
                <!-- Slide status for screen readers -->
                <div class="slider-status" aria-live="polite" aria-atomic="true">
                    <?php echo Promen_Accessibility_Utils::get_screen_reader_text(sprintf(__('Image slideshow with %d slides. Current slide will be announced when changed.', 'promen-elementor-widgets'), count($visible_slides))); ?>
                </div>
            </div>
            
            <!-- Fraction progress indicator - only show if 3+ slides -->
            <div class="slider-fraction-indicator" role="status" aria-label="<?php echo esc_attr__('Slide progress', 'promen-elementor-widgets'); ?>">
                <span class="current-slide"><?php echo $slide_number; ?></span>
                <span class="progress-separator"> / </span>
                <span class="total-slides"><?php echo count($visible_slides); ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <?php 
        // Add breadcrumb below the content container if selected, or as an overlay if selected
        if ($settings['show_breadcrumb'] === 'yes' && ($settings['breadcrumb_position'] === 'below' || $settings['breadcrumb_position'] === 'overlay')) {
            echo $breadcrumb_html;
        }
        ?>
    </div>
</div> 