<?php
/**
 * Slide Image Template
 * 
 * Renders the image portion of a single slide.
 * Note: The outer swiper-slide wrapper is now in render.php.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
?>
<?php if (!empty($slide['background_image']['url'])) : 
    $image_url = $slide['background_image']['url'];
        
        // Get the image size if specified
        if (!empty($slide['image_size']) && $slide['image_size'] !== 'full') {
            $image_id = $slide['background_image']['id'];
            $image_size = $slide['image_size'];
            $image_data = wp_get_attachment_image_src($image_id, $image_size);
            
            if ($image_data) {
                $image_url = $image_data[0];
            }
        }
    ?>
        <div class="slide-image">
            <picture>
                <source srcset="<?php echo esc_url($image_url); ?>" media="(min-width: 768px)">
                <?php 
                // Get alt text for accessibility
                $alt_text = '';
                if (!empty($slide['background_image']['alt'])) {
                    $alt_text = $slide['background_image']['alt'];
                } elseif (!empty($slide['title_text'])) {
                    $alt_text = $slide['title_text'];
                } else {
                    $alt_text = __('Slide background image', 'promen-elementor-widgets');
                }
                ?>
                <img src="<?php echo esc_url($image_url); ?>" 
                     alt="<?php echo esc_attr($alt_text); ?>" 
                     loading="lazy"
                     decoding="async"
                     fetchpriority="<?php echo $index === 0 ? 'high' : 'low'; ?>">
            </picture>
            
            <?php if (isset($slide['show_overlay_image']) && $slide['show_overlay_image'] === 'yes' && !empty($slide['overlay_image']['url'])) : 
                $overlay_image_url = $slide['overlay_image']['url'];
                
                // Enhanced alt text with fallback logic for accessibility
                $overlay_image_alt = '';
                if (!empty($slide['overlay_image']['alt'])) {
                    $overlay_image_alt = $slide['overlay_image']['alt'];
                } elseif (!empty($slide['title_text'])) {
                    $overlay_image_alt = esc_attr($slide['title_text']) . ' - ' . __('overlay image', 'promen-elementor-widgets');
                } else {
                    $overlay_image_alt = __('Decorative overlay image', 'promen-elementor-widgets');
                }
                
                // Get image size if specified
                if (!empty($slide['overlay_image']['id'])) {
                    $overlay_image_id = $slide['overlay_image']['id'];
                    $overlay_image_data = wp_get_attachment_image_src($overlay_image_id, 'full');
                    
                    if ($overlay_image_data) {
                        $overlay_image_url = $overlay_image_data[0];
                    }
                }
                
                // Check if this is decorative (empty alt text means decorative)
                $is_decorative = empty($slide['overlay_image']['alt']) && empty($slide['title_text']);
            ?>
                <div class="overlay-image" role="img" <?php echo $is_decorative ? 'aria-hidden="true"' : 'aria-label="' . esc_attr($overlay_image_alt) . '"'; ?>>
                    <img src="<?php echo esc_url($overlay_image_url); ?>" 
                         alt="<?php echo $is_decorative ? '' : esc_attr($overlay_image_alt); ?>" 
                         loading="lazy"
                         decoding="async"
                         <?php echo $is_decorative ? 'aria-hidden="true"' : ''; ?>>
                </div>
            <?php endif; ?>
            
            <?php if (isset($slide['show_absolute_overlay_image']) && $slide['show_absolute_overlay_image'] === 'yes' && !empty($slide['absolute_overlay_image']['url'])) : 
                $absolute_overlay_url = $slide['absolute_overlay_image']['url'];
                
                // Enhanced alt text with fallback logic for accessibility
                $absolute_overlay_alt = '';
                if (!empty($slide['absolute_overlay_image']['alt'])) {
                    $absolute_overlay_alt = $slide['absolute_overlay_image']['alt'];
                } elseif (!empty($slide['title_text'])) {
                    $absolute_overlay_alt = esc_attr($slide['title_text']) . ' - ' . __('positioned overlay image', 'promen-elementor-widgets');
                } else {
                    $absolute_overlay_alt = __('Decorative positioned overlay image', 'promen-elementor-widgets');
                }
                $position_class = '';
                $extend_class = isset($slide['absolute_overlay_extend_beyond']) && $slide['absolute_overlay_extend_beyond'] === 'yes' ? 'extend-beyond' : '';
                
                // Get image size
                if (!empty($slide['absolute_overlay_image']['id'])) {
                    $absolute_overlay_id = $slide['absolute_overlay_image']['id'];
                    $absolute_overlay_data = wp_get_attachment_image_src($absolute_overlay_id, 'full');
                    
                    if ($absolute_overlay_data) {
                        $absolute_overlay_url = $absolute_overlay_data[0];
                    }
                }
                
                // Set position class based on the selected position
                if (isset($slide['absolute_overlay_position']) && $slide['absolute_overlay_position'] !== 'custom') {
                    $position_class = 'position-' . $slide['absolute_overlay_position'];
                    
                    // Apply position styling based on the class
                    switch($slide['absolute_overlay_position']) {
                        case 'top-left':
                            $position_styles = 'top: 0; left: 0;';
                            break;
                        case 'top-center':
                            $position_styles = 'top: 0; left: 50%; transform: translateX(-50%);';
                            break;
                        case 'top-right':
                            $position_styles = 'top: 0; right: 0;';
                            break;
                        case 'middle-left':
                            $position_styles = 'top: 50%; left: 0; transform: translateY(-50%);';
                            break;
                        case 'middle-center':
                            $position_styles = 'top: 50%; left: 50%; transform: translate(-50%, -50%);';
                            break;
                        case 'middle-right':
                            $position_styles = 'top: 50%; right: 0; transform: translateY(-50%);';
                            break;
                        case 'bottom-left':
                            $position_styles = 'bottom: 0; left: 0;';
                            break;
                        case 'bottom-center':
                            $position_styles = 'bottom: 0; left: 50%; transform: translateX(-50%);';
                            break;
                        case 'bottom-right':
                            $position_styles = 'bottom: 0; right: 0;';
                            break;
                        default:
                            $position_styles = '';
                    }
                    
                    // If extend beyond is enabled and position is at bottom, adjust position
                    if ($extend_class === 'extend-beyond' && strpos($slide['absolute_overlay_position'], 'bottom-') === 0) {
                        if ($slide['absolute_overlay_position'] === 'bottom-center') {
                            $position_styles = 'bottom: -10%; left: 50%; transform: translateX(-50%) translateY(10%);';
                        } else {
                            $position_styles = str_replace('bottom: 0;', 'bottom: -10%;', $position_styles);
                        }
                    }
                } else {
                    // Custom position is handled by Elementor's selectors
                    $position_styles = '';
                }
                
                // Check if this absolute overlay is decorative
                $absolute_is_decorative = empty($slide['absolute_overlay_image']['alt']) && empty($slide['title_text']);
            ?>
                <div class="absolute-overlay-image <?php echo esc_attr($position_class . ' ' . $extend_class); ?>" 
                     style="<?php echo esc_attr($position_styles); ?>"
                     role="img" 
                     <?php echo $absolute_is_decorative ? 'aria-hidden="true"' : 'aria-label="' . esc_attr($absolute_overlay_alt) . '"'; ?>>
                    <img src="<?php echo esc_url($absolute_overlay_url); ?>" 
                         alt="<?php echo $absolute_is_decorative ? '' : esc_attr($absolute_overlay_alt); ?>" 
                         loading="lazy"
                         decoding="async"
                         <?php echo $absolute_is_decorative ? 'aria-hidden="true"' : ''; ?>>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>