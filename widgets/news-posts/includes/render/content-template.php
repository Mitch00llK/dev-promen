<?php
/**
 * Content template for individual post cards in News Posts Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Use template_settings if available, otherwise fallback to settings
$template_settings = isset($template_settings) ? $template_settings : $settings;
$post_type = isset($template_settings['post_type']) ? $template_settings['post_type'] : 'post';
?>

<div class="promen-content-card <?php echo esc_attr($post_type); ?>-card">
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
        <span id="post-title-<?php echo esc_attr(get_the_ID()); ?>" class="promen-content-post-title"><?php the_title(); ?></span>
        
        <?php if ($post_type === 'vacatures') : ?>
            <p class="promen-content-excerpt">
                <?php 
                $excerpt = get_the_excerpt();
                $excerpt_length = isset($template_settings['excerpt_length']) ? intval($template_settings['excerpt_length']) : 0;
                
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
            
            <?php 
            // Get vacature meta fields
            $hours_per_week = get_post_meta(get_the_ID(), 'uren_per_week', true);
            $education_level = get_post_meta(get_the_ID(), 'opleidingsniveau', true);
            $location = get_post_meta(get_the_ID(), 'locatie', true);
            ?>
            
            <?php if (!empty($hours_per_week)) : ?>
                <div class="vacature-meta-item">
                    <strong><?php echo esc_html__('Uren per week', 'promen-elementor-widgets'); ?></strong>
                    <span><?php echo esc_html($hours_per_week); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($education_level)) : ?>
                <div class="vacature-meta-item">
                    <strong><?php echo esc_html__('Opleidingsniveau', 'promen-elementor-widgets'); ?></strong>
                    <span><?php echo esc_html($education_level); ?></span>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($location)) : ?>
                <div class="vacature-meta-item">
                    <strong><?php echo esc_html__('Locatie', 'promen-elementor-widgets'); ?></strong>
                    <span><?php echo esc_html($location); ?></span>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <p class="promen-content-excerpt">
                <?php 
                $excerpt = get_the_excerpt();
                $excerpt_length = isset($template_settings['excerpt_length']) ? intval($template_settings['excerpt_length']) : 0;
                
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
        <?php endif; ?>
        
        <a href="<?php echo esc_url(get_permalink()); ?>" 
           class="promen-content-read-more" 
           aria-label="<?php echo esc_attr__('Lees meer over', 'promen-elementor-widgets') . ' ' . esc_attr(get_the_title()); ?>">
            <?php if (isset($template_settings['read_more_icon']['value']) && !empty($template_settings['read_more_icon']['value']) && isset($template_settings['read_more_icon_position']) && $template_settings['read_more_icon_position'] === 'before') : ?>
                <span class="button-icon-before" aria-hidden="true">
                    <?php \Elementor\Icons_Manager::render_icon($template_settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                </span>
            <?php endif; ?>
            <span class="button-text"><?php echo esc_html(isset($template_settings['read_more_text']) ? $template_settings['read_more_text'] : __('Lees meer', 'promen-elementor-widgets')); ?></span>
            <?php if (isset($template_settings['read_more_icon']['value']) && !empty($template_settings['read_more_icon']['value']) && isset($template_settings['read_more_icon_position']) && $template_settings['read_more_icon_position'] === 'after') : ?>
                <span class="button-icon-after" aria-hidden="true">
                    <?php \Elementor\Icons_Manager::render_icon($template_settings['read_more_icon'], ['aria-hidden' => 'true']); ?>
                </span>
            <?php endif; ?>
        </a>
    </div>
</div> 