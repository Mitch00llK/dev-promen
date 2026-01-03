<?php
/**
 * Image Text Slider Widget Render Template
 * 
 * Main rendering template for the Image Text Slider widget.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Process initial settings and configuration
$settings = $this->get_settings_for_display();
$id_int = substr($this->get_id_int(), 0, 3);
$slider_id = 'image-text-slider-' . $id_int;

// Get and filter visible slides
$slides = $settings['slides'];
$visible_slides = array_filter($slides, function($slide) {
    return isset($slide['show_slide']) && $slide['show_slide'] === 'yes';
});

// Show a message if no visible slides
if (empty($visible_slides)) {
    echo '<div class="image-text-slider-no-slides">';
    echo esc_html__('No slides to display. Please add slides in the widget settings.', 'promen-elementor-widgets');
    echo '</div>';
    return;
}

// Reset array keys
$visible_slides = array_values($visible_slides);

// Prepare slider options for JS with accessibility
$slider_options = [
    'autoplay' => $settings['autoplay'] === 'yes',
    'autoplaySpeed' => $settings['autoplay'] === 'yes' ? (int)$settings['autoplay_speed'] : 5000,
    'pauseOnHover' => $settings['autoplay'] === 'yes' && $settings['pause_on_hover'] === 'yes',
    'infinite' => $settings['infinite'] === 'yes',
    'speed' => (int)$settings['transition_speed'],
    'effect' => $settings['transition_effect'],
    'enableGsapAnimations' => $settings['enable_gsap_animations'] === 'yes',
    'animationDuration' => isset($settings['animation_duration']['size']) ? $settings['animation_duration']['size'] : 0.7,
    'accessibility' => [
        'enabled' => true,
        'keyboard' => true,
        'announcements' => true,
        'focusOnSelect' => true,
        'reducedMotion' => false // Will be set by JS based on user preference
    ]
];

// Get accessibility attributes for slider
$accessibility_attrs = Promen_Accessibility_Utils::get_slider_attrs([
    'widget_id' => $this->get_id(),
    'slides_count' => count($visible_slides),
    'autoplay' => $slider_options['autoplay'],
    'loop' => $slider_options['infinite']
]);

// Get the transition speed for synchronization
$transition_speed = (int)$settings['transition_speed'];

// Prepare navigation options
$show_arrows = $settings['show_arrows'] === 'yes';
$show_pagination = $settings['show_pagination'] === 'yes';
$pagination_type = $show_pagination ? $settings['pagination_type'] : 'none';
$pagination_position = $show_pagination ? $settings['pagination_position'] : 'bottom-center';

// Prepare classes
$container_classes = ['image-text-slider-container'];

// Add content position class
$container_classes[] = 'content-position-' . $settings['content_position'];

// Add height mode class
if ($settings['slider_height'] === 'full') {
    $container_classes[] = 'height-full';
} elseif ($settings['slider_height'] === 'custom') {
    $container_classes[] = 'height-custom';
}

// Add pagination position class
if ($show_pagination) {
    $container_classes[] = 'pagination-' . $pagination_position;
}

// Add arrows position class
if ($show_arrows) {
    $container_classes[] = 'arrows-inside-content';
}

// Check for extended overlays
$has_extended_overlays = false;
foreach ($visible_slides as $slide) {
    if (isset($slide['show_absolute_overlay_image']) && 
        $slide['show_absolute_overlay_image'] === 'yes' && 
        isset($slide['absolute_overlay_extend_beyond']) && 
        $slide['absolute_overlay_extend_beyond'] === 'yes') {
        $has_extended_overlays = true;
        break;
    }
}
if ($has_extended_overlays) {
    $container_classes[] = 'has-extended-overlays';
}

$container_class = implode(' ', $container_classes);

// Include component templates
include(__DIR__ . '/partials/_breadcrumb.php'); // Generate breadcrumb HTML

// Prepare divider data attributes
$divider_data_attrs = '';
if ($settings['show_tilted_divider'] === 'yes') {
    // Set the tilt angle
    if (isset($settings['divider_tilt_degrees'])) {
        $tilt_angle = $settings['divider_tilt_degrees'];
    } else {
        $tilt_angle = $settings['divider_tilt_angle']['size'] ?? -12;
    }
    
    // Flip the angle if the flip direction is enabled
    if ($settings['divider_flip_direction'] === 'yes') {
        $tilt_angle = -1 * $tilt_angle;
    }
    
    // Get the height for reference
    $divider_height = isset($settings['divider_height']['size']) ? $settings['divider_height']['size'] : 20;
    $divider_height_unit = isset($settings['divider_height']['unit']) ? $settings['divider_height']['unit'] : 'rem';
    
    $divider_data_attrs = ' data-degrees="' . esc_attr($tilt_angle) . '" data-height="' . esc_attr($divider_height . $divider_height_unit) . '"';
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

<?php
// Initialize the slider when the DOM is fully loaded
if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
    // For editor mode, use the editor-specific initialization
    ?>
    <script type="text/javascript">
    (function() {
        var sliderId = "<?php echo esc_attr($slider_id); ?>";
        
        
        // Function to try initialization
        function tryEditorInit() {
            if (typeof initImageTextSliderForEditor === "function") {
                var sliderElement = document.getElementById(sliderId);
                if (sliderElement) {
                    initImageTextSliderForEditor(sliderElement);
                } else {
                }
            } else if (typeof initEditorSliders === "function") {
                // Fallback to initializing all sliders
                initEditorSliders();
            } else {
                // Ultimate fallback - try basic initialization if available
                if (typeof initImageTextSlider === "function") {
                    var sliderElement = document.getElementById(sliderId);
                    if (sliderElement) {
                        initImageTextSlider(sliderElement);
                    }
                }
            }
        }
        
        // Try immediate initialization
        tryEditorInit();
        
        // Also attempt with delays as fallbacks
        setTimeout(tryEditorInit, 100);
        setTimeout(tryEditorInit, 500);
    })();
    </script>
    <?php
} else {
    // For frontend, use the standard initialization approach
    ?>
    <script type="text/javascript">
    (function() {
        var sliderId = "<?php echo esc_attr($slider_id); ?>";
        
        // Function to initialize the slider
        function tryInitialize() {
            if (typeof initImageTextSlider === "function") {
                var sliderElement = document.getElementById(sliderId);
                if (sliderElement) {
                    initImageTextSlider(sliderElement);
                } else {
                    // If element not found, try again later
                    setTimeout(tryInitialize, 200);
                }
            } else {
                // If the function is not available yet, try again after a delay
                setTimeout(tryInitialize, 200);
            }
        }
        
        // Try to initialize when DOM is ready
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(tryInitialize, 100);
        } else {
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(tryInitialize, 100);
            });
        }
        
        // Fallback for when DOMContentLoaded might have already fired or scripts load late
        setTimeout(tryInitialize, 500);
        
        // Final fallback for archive pages and other special cases
        window.addEventListener('load', function() {
            setTimeout(tryInitialize, 100);
        });
    })();
    </script>
    <?php
} 