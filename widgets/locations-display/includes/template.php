<?php
/**
 * Template for Locations Display Widget
 *
 * @package Promen
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Generate unique ID for animation
$widget_id = $this->get_id();

// Container class
$container_class = 'locations-container';

// GSAP animation preparation
$animation_enabled = 'yes' === $settings['enable_animation'];
$animation_attributes = '';

if ($animation_enabled) {
    $container_class .= ' locations-animated';
    $animation_type = $settings['animation_type'];
    $animation_delay = $settings['animation_delay']['size'];
    
    $animation_attributes .= ' data-animation="' . esc_attr($animation_type) . '"';
    $animation_attributes .= ' data-animation-delay="' . esc_attr($animation_delay) . '"';
    $animation_attributes .= ' data-animation-id="' . esc_attr($widget_id) . '"';
}

// Generate unique IDs for accessibility
$container_id = Promen_Accessibility_Utils::generate_id('locations-display', $widget_id);
$heading_id = Promen_Accessibility_Utils::generate_id('locations-heading', $widget_id);
$description_id = Promen_Accessibility_Utils::generate_id('locations-description', $widget_id);
$locations_id = Promen_Accessibility_Utils::generate_id('locations-list', $widget_id);

?>

<section class="<?php echo esc_attr($container_class); ?>" 
         id="<?php echo esc_attr($container_id); ?>"
         <?php echo $animation_attributes; ?> 
         role="region" 
         aria-labelledby="<?php echo esc_attr($heading_id); ?>" 
         aria-describedby="<?php echo esc_attr($description_id); ?>"
         aria-label="<?php esc_attr_e('Overzicht van alle locaties waar wij actief zijn en waar u ons kunt bezoeken', 'promen-elementor-widgets'); ?>">
    
    <?php if ('yes' === $settings['show_heading_section']) : ?>
        <header class="locations-heading" id="<?php echo esc_attr($heading_id); ?>">
            <?php 
            // Use the standardized split title render function
            echo promen_render_split_title($this, $settings, 'heading_text', 'locations'); 
            ?>
            
            <?php if ('yes' === $settings['show_heading_description'] && !empty($settings['heading_description'])) : ?>
                <p class="locations-heading-description" id="<?php echo esc_attr($description_id); ?>">
                    <?php echo esc_html($settings['heading_description']); ?>
                </p>
            <?php endif; ?>
        </header>
    <?php endif; ?>
    
    <?php
    // Get columns value - handle responsive control
    $columns = !empty($settings['columns']) ? $settings['columns'] : '2';
    if (is_array($columns)) {
        $columns = !empty($columns['size']) ? $columns['size'] : (!empty($columns['default']) ? $columns['default'] : '2');
    }
    ?>
    <div class="locations-grid columns-<?php echo esc_attr($columns); ?>" 
         role="list" 
         aria-label="<?php esc_attr_e('Rooster met alle locaties die u kunt bekijken voor contactinformatie en adresgegevens', 'promen-elementor-widgets'); ?>"
         id="<?php echo esc_attr($locations_id); ?>">
        <?php
        if (!empty($settings['locations'])) {
            foreach ($settings['locations'] as $index => $location) {
                if ('yes' !== $location['show_location']) {
                    continue;
                }
                
                $location_image = wp_get_attachment_image_src($location['location_image']['id'], $location['location_image_size_size']);
                $location_name = $location['location_name'];
                $location_street = $location['location_street'];
                $location_postal_city = $location['location_postal_city'];
                $location_class = 'location-item location-item-' . ($index + 1);
                $has_image = !empty($location_image);
                $location_item_id = Promen_Accessibility_Utils::generate_id('location-item-' . ($index + 1));
                $location_name_id = Promen_Accessibility_Utils::generate_id('location-name-' . ($index + 1));
                $location_address_id = Promen_Accessibility_Utils::generate_id('location-address-' . ($index + 1));
                ?>
                
                <article class="<?php echo esc_attr($location_class); ?>" 
                         role="listitem" 
                         tabindex="0"
                         aria-labelledby="<?php echo esc_attr($location_name_id); ?>"
                         aria-describedby="<?php echo esc_attr($location_address_id); ?>"
                         id="<?php echo esc_attr($location_item_id); ?>">
                    <?php if ($has_image) : ?>
                        <figure class="location-image" role="img" aria-label="<?php echo esc_attr($location_name); ?>">
                            <picture>
                                <img src="<?php echo esc_url($location_image[0]); ?>" 
                                     alt="<?php echo esc_attr($location_name); ?>" 
                                     width="<?php echo esc_attr($location_image[1]); ?>" 
                                     height="<?php echo esc_attr($location_image[2]); ?>"
                                     loading="lazy" />
                            </picture>
                        </figure>
                    <?php endif; ?>
                    
                    <div class="location-info">
                        <?php if (!empty($location_name)) : ?>
                            <h3 class="location-name" id="<?php echo esc_attr($location_name_id); ?>"><?php echo esc_html($location_name); ?></h3>
                        <?php endif; ?>
                        
                        <address class="location-address" id="<?php echo esc_attr($location_address_id); ?>">
                            <?php if (!empty($location_street)) : ?>
                                <p class="location-street"><?php echo esc_html($location_street); ?></p>
                            <?php endif; ?>
                            
                            <?php if (!empty($location_postal_city)) : ?>
                                <p class="location-postal-city"><?php echo esc_html($location_postal_city); ?></p>
                            <?php endif; ?>
                        </address>
                    </div>
                </article>
                
            <?php
            }
        }
        ?>
    </div>
</section>

<?php if ($animation_enabled) : ?>
<script>
(function() {
    'use strict';
    
    function initLocationsAnimation() {
        if (typeof gsap === 'undefined') return;
        
        const animationContainer = document.querySelector('[data-animation-id="<?php echo esc_attr($widget_id); ?>"]');
        if (!animationContainer) return;
        
        const animationItems = Array.from(animationContainer.querySelectorAll('.location-item'));
        if (animationItems.length === 0) return;
        
        const animationType = '<?php echo esc_js($animation_type); ?>';
        const staggerDelay = <?php echo esc_js($animation_delay); ?> / 1000;
        
        // First, ensure no inline styles persist from previous loads
        animationItems.forEach(function(item) {
            // Remove any existing inline styles that might persist
            item.style.removeProperty('opacity');
            item.style.removeProperty('transform');
            item.style.removeProperty('-webkit-transform');
            item.style.removeProperty('will-change');
        });
        
        // Performance optimization - only apply will-change when needed
        let isIntersecting = false;
        let animationComplete = false;
        
        // Use Intersection Observer instead of ScrollTrigger for better performance
        const observer = new IntersectionObserver((entries) => {
            const [entry] = entries;
            
            if (entry.isIntersecting && !isIntersecting && !animationComplete) {
                isIntersecting = true;
                
                // Add will-change property just before animation
                gsap.set(animationItems, {
                    willChange: "transform, opacity",
                    opacity: 0,
                    y: animationType === 'slide-up' ? 30 : 0,
                    x: animationType === 'slide-in' ? -30 : 0,
                    scale: animationType === 'scale-in' ? 0.8 : 1,
                    force3D: true // Better performance for transforms
                });
                
                // Run the animation
                const timeline = gsap.to(animationItems, {
                    opacity: 1,
                    y: 0,
                    x: 0,
                    scale: 1,
                    stagger: staggerDelay,
                    duration: 0.8,
                    ease: 'power2.out',
                    onComplete: function() {
                        animationComplete = true;
                        
                        // Clean up all inline styles after animation completes
                        animationItems.forEach(function(item) {
                            item.style.removeProperty('opacity');
                            item.style.removeProperty('transform');
                            item.style.removeProperty('-webkit-transform');
                            item.style.removeProperty('will-change');
                        });
                        
                        // Use GSAP's clearProps to ensure all transform properties are cleared
                        gsap.set(animationItems, { 
                            clearProps: "all"
                        });
                        
                        // Mark container as animated
                        animationContainer.setAttribute('data-animation-complete', 'true');
                    }
                });
                
                // Once animation has run, disconnect observer
                observer.disconnect();
            }
        }, {
            root: null,
            threshold: 0.1,
            rootMargin: '0px 0px -10% 0px'
        });
        
        observer.observe(animationContainer);
        
        // Cleanup function for page unload
        function cleanupStyles() {
            animationItems.forEach(function(item) {
                item.style.removeProperty('opacity');
                item.style.removeProperty('transform');
                item.style.removeProperty('-webkit-transform');
                item.style.removeProperty('will-change');
            });
        }
        
        // Clean up on page unload
        window.addEventListener('beforeunload', cleanupStyles);
        
        // Also clean up if animation container is removed from DOM
        if (typeof MutationObserver !== 'undefined') {
            const mutationObserver = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.removedNodes.length > 0) {
                        Array.from(mutation.removedNodes).forEach(function(node) {
                            if (node === animationContainer || (node.nodeType === 1 && node.contains && node.contains(animationContainer))) {
                                cleanupStyles();
                                mutationObserver.disconnect();
                            }
                        });
                    }
                });
            });
            
            if (document.body) {
                mutationObserver.observe(document.body, {
                    childList: true,
                    subtree: true
                });
            }
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLocationsAnimation, { passive: true });
    } else {
        initLocationsAnimation();
    }
})();
</script>
<?php endif; ?>
