<?php
/**
 * Worker Testimonial Widget - Frontend Template
 *
 * @package Promen\Widgets
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

$classes = ['worker-testimonial'];

if (!empty($settings['position'])) {
    $classes[] = 'worker-testimonial--position-' . $settings['position'];
}

// Generate unique IDs for ARIA attributes
$widget_id = 'worker-testimonial-' . uniqid();
$quote_id = $widget_id . '-quote';
$name_id = $widget_id . '-name';
$image_id = $widget_id . '-image';

// Prepare testimonial content for screen readers
$testimonial_content = '';
if ($settings['show_quote'] === 'yes' && !empty($settings['quote_text'])) {
    $testimonial_content .= $settings['quote_text'];
}
if ($settings['show_name'] === 'yes') {
    if ($settings['enable_split_heading'] === 'yes') {
        $name_parts = [];
        if (!empty($settings['split_text_before'])) {
            $name_parts[] = $settings['split_text_before'];
        }
        if (!empty($settings['split_text_after'])) {
            $name_parts[] = $settings['split_text_after'];
        }
        $testimonial_content .= ' - ' . implode(' ', $name_parts);
    } else if (!empty($settings['worker_name'])) {
        $testimonial_content .= ' - ' . $settings['worker_name'];
    }
}
?>
<article class="<?php echo esc_attr(implode(' ', $classes)); ?>" 
         role="article" 
         aria-labelledby="<?php echo esc_attr($name_id); ?>"
         aria-describedby="<?php echo esc_attr($quote_id); ?>"
         id="<?php echo esc_attr($widget_id); ?>">
    
    <?php if ($settings['show_image'] === 'yes' && !empty($settings['worker_image']['url'])) : ?>
        <?php 
        $image_alt = !empty($settings['image_alt_text']) ? $settings['image_alt_text'] : ($settings['worker_image']['alt'] ?: 'Worker testimonial background image');
        ?>
        <div class="worker-testimonial__image-wrapper" role="img" aria-label="<?php echo esc_attr('Foto van ' . $image_alt); ?>">
            <div class="worker-testimonial__image">
                <?php 
                echo wp_get_attachment_image($settings['worker_image']['id'], 'full', false, [
                    'alt' => esc_attr($image_alt),
                    'id' => esc_attr($image_id),
                    'loading' => 'lazy'
                ]); 
                ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="worker-testimonial__container">
        <div class="worker-testimonial__content" role="region" aria-label="Testimonial content">
            <?php if ($settings['show_quote'] === 'yes') : ?>
                <div class="worker-testimonial__quote-wrapper">
                    <?php if (!empty($settings['quote_icon']['value'])) : ?>
                        <div class="worker-testimonial__quote-icon" aria-hidden="true" role="presentation">
                            <?php \Elementor\Icons_Manager::render_icon($settings['quote_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($settings['quote_text'])) : ?>
                        <blockquote class="worker-testimonial__quote" id="<?php echo esc_attr($quote_id); ?>">
                            <?php echo esc_html($settings['quote_text']); ?>
                        </blockquote>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($settings['show_name'] === 'yes' && (!empty($settings['worker_name']) || ($settings['enable_split_heading'] === 'yes' && (!empty($settings['split_text_before']) || !empty($settings['split_text_after']))))) : ?>
                <?php
                $name_tag = $settings['name_tag'] ?? 'h3';
                $name_classes = ['worker-testimonial__name'];
                if ($settings['enable_split_heading'] === 'yes') {
                    $name_classes[] = 'worker-testimonial__name--split';
                }
                ?>
                <<?php echo esc_html($name_tag); ?> class="<?php echo esc_attr(implode(' ', $name_classes)); ?>" id="<?php echo esc_attr($name_id); ?>">
                    <?php if ($settings['enable_split_heading'] === 'yes') : ?>
                        <?php if (!empty($settings['split_text_before'])) : ?>
                            <span class="light"><?php echo esc_html($settings['split_text_before']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($settings['split_text_after'])) : ?>
                            <span class="bold"><?php echo esc_html($settings['split_text_after']); ?></span>
                        <?php endif; ?>
                    <?php else : ?>
                        <?php echo esc_html($settings['worker_name']); ?>
                    <?php endif; ?>
                </<?php echo esc_html($name_tag); ?>>
            <?php endif; ?>
        </div>
    </div>
</article> 