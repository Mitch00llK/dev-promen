<?php
/**
 * Image Text Slider Widget
 * 
 * A modern slider widget with image background and text overlay container
 * 
 * @package Elementor
 * @subpackage Promen Elementor Widgets
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Load traits
require_once(__DIR__ . '/controls/content-section.php');
require_once(__DIR__ . '/controls/slider-section.php');
require_once(__DIR__ . '/controls/style-section.php');
require_once(__DIR__ . '/controls/typography-section.php');

/**
 * Image Text Slider Widget Class
 * 
 * A modern slider with image backgrounds and text overlay containers
 */
class Promen_Image_Text_Slider_Widget extends \Elementor\Widget_Base {
    use Image_Text_Slider_Content_Controls;
    use Image_Text_Slider_Slider_Controls;
    use Image_Text_Slider_Style_Controls;
    use Image_Text_Slider_Typography_Controls;

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'image_text_slider';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Image Text Slider', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-slider-push';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['promen-widgets'];
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['slider', 'image', 'text', 'banner', 'carousel'];
    }

    /**
     * Get widget script dependencies.
     *
     * @return array Widget script dependencies.
     */
    public function get_script_depends() {
        $dependencies = ['swiper-bundle', 'image-text-slider'];
        
        // Check if we're in Elementor editor mode
        $is_editor_mode = \Elementor\Plugin::$instance->editor->is_edit_mode() || 
                         \Elementor\Plugin::$instance->preview->is_preview_mode();
        
        // In editor mode or desktop, always include all dependencies
        if ($is_editor_mode || !wp_is_mobile()) {
            $dependencies = array_merge(['jquery', 'gsap', 'image-text-slider-init'], $dependencies);
        }
        
        return $dependencies;
    }

    /**
     * Get widget style dependencies.
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends() {
        $dependencies = ['swiper-bundle-css', 'image-text-slider'];
        
        // Add accessibility styles for WCAG 2.2 compliance
        $dependencies[] = 'image-text-slider-accessibility';
        
        // Add mobile optimizations
        if (wp_is_mobile()) {
            $dependencies[] = 'image-text-slider-mobile';
        }
        
        return $dependencies;
    }

    /**
     * Register and enqueue necessary scripts and styles.
     */
    public function register_widget_scripts() {
        // Detect mobile for performance optimization
        $is_mobile = wp_is_mobile();
        $is_editor_mode = \Elementor\Plugin::$instance->editor->is_edit_mode() || 
                         \Elementor\Plugin::$instance->preview->is_preview_mode();
        $script_version = '1.0.2-mobile-optimized';
        
        // Register main slider script (now handles both mobile and desktop optimizations)
        wp_register_script(
            'image-text-slider-init',
            plugins_url('assets/js/modules/init-slider.js', __FILE__),
            ['jquery', 'swiper-bundle', 'gsap'],
            '1.0.1',
            true
        );
        
        // For editor mode, always use full dependencies; for frontend, optimize for mobile
        $script_dependencies = ($is_editor_mode || !$is_mobile) ? 
            ['jquery', 'swiper-bundle', 'gsap', 'image-text-slider-init'] : 
            ['swiper-bundle'];
        
        wp_register_script(
            'image-text-slider',
            plugins_url('assets/js/script.js', __FILE__),
            $script_dependencies,
            $script_version,
            true
        );
        
        // Register main slider styles
        wp_register_style(
            'image-text-slider',
            plugins_url('assets/css/style.css', __FILE__),
            ['swiper-bundle-css'],
            '1.0.1'
        );
        
        // Note: Accessibility and mobile styles are now registered in the main assets manager
        
        // Add defer attribute to scripts for better performance (but not in editor mode)
        if (!$is_editor_mode) {
            add_filter('script_loader_tag', function($tag, $handle) {
                if ($handle === 'image-text-slider-init' || $handle === 'image-text-slider') {
                    return str_replace(' src', ' defer src', $tag);
                }
                return $tag;
            }, 10, 2);
        }
        
        // Add preload for CSS (but not in editor mode for better debugging)
        if (!$is_editor_mode) {
            add_filter('style_loader_tag', function($tag, $handle) {
                if ($handle === 'image-text-slider') {
                    return str_replace('rel=\'stylesheet\'', 'rel=\'preload\' as=\'style\' onload="this.onload=null;this.rel=\'stylesheet\'"', $tag);
                }
                return $tag;
            }, 10, 2);
        }
    }

    /**
     * Constructor method.
     *
     * @param array $data Widget data.
     * @param array $args Widget arguments.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        
        // Register scripts - use init hook instead of wp_enqueue_scripts for archive pages
        add_action('init', [$this, 'register_widget_scripts']);
        
        // Also keep the Elementor hook for better compatibility
        add_action('elementor/frontend/after_register_scripts', [$this, 'register_widget_scripts']);
    }

    /**
     * Get class name based on settings
     * 
     * @return string
     */
    protected function get_class_name_with_settings() {
        $settings = $this->get_settings_for_display();
        $classes = ['image-text-slider-widget'];
        
        if (isset($settings['show_overlay_image']) && $settings['show_overlay_image'] === 'yes') {
            $classes[] = 'has-overlay-image';
        }
        
        return implode(' ', $classes);
    }

    /**
     * Register editor-specific scripts and styles
     */
    protected function register_editor_scripts() {
        // Only add these styles if we're in the editor
        if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
            // Enqueue editor styles - attached directly to the Elementor editor via admin_enqueue_scripts
            add_action('admin_enqueue_scripts', function() {
                wp_register_style(
                    'image-text-slider-editor', 
                    false, 
                    [], 
                    '1.0.0'
                );
                
                wp_enqueue_style('image-text-slider-editor');
                
                wp_add_inline_style('image-text-slider-editor', '
                    /* Ensure slider container is properly visible in the editor */
                    .elementor-editor-active .image-text-slider-container {
                        overflow: visible !important;
                        min-height: 40rem !important;
                        display: block !important;
                    }
                    
                    /* Make sure the slides container is visible */
                    .elementor-editor-active .image-text-slider-container .swiper {
                        overflow: hidden !important;
                        min-height: 40rem !important;
                        display: block !important;
                    }
                    
                    /* Ensure content wrapper is visible */
                    .elementor-editor-active .image-text-slider-container .slide-content-wrapper,
                    .elementor-editor-active .image-text-slider-container .swiper-content-slider {
                        overflow: visible !important;
                        display: block !important;
                    }
                    
                    /* Make all slides visible in the editor */
                    .elementor-editor-active .image-text-slider-container .swiper-slide,
                    .elementor-editor-active .image-text-slider-container .swiper-wrapper {
                        opacity: 1 !important;
                        visibility: visible !important;
                        display: block !important;
                    }
                    
                    /* First slide should be in front */
                    .elementor-editor-active .image-text-slider-container .swiper-slide:first-child {
                        z-index: 3 !important;
                    }
                    
                    /* Make content slides visible */
                    .elementor-editor-active .image-text-slider-container .swiper-content-slider .swiper-slide,
                    .elementor-editor-active .image-text-slider-container .swiper-content-slider .swiper-wrapper {
                        opacity: 1 !important;
                        visibility: visible !important;
                        display: block !important;
                    }
                    
                    /* First content slide should be in front */
                    .elementor-editor-active .image-text-slider-container .swiper-content-slider .swiper-slide:first-child {
                        z-index: 3 !important;
                    }
                    
                    /* Make sure back link and publication date are visible in the editor when enabled */
                    .elementor-editor-active .slide-back-link {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                        margin-bottom: 1rem !important;
                        padding: 0.3rem 0.7rem !important;
                        background-color: rgba(48, 86, 211, 0.1) !important;
                        border-left: 3px solid #3056D3 !important;
                        max-width: fit-content !important;
                    }
                    
                    .elementor-editor-active .slide-back-link a {
                        color: #3056D3 !important;
                        text-decoration: none !important;
                        font-size: 0.9rem !important;
                        display: inline-flex !important;
                        align-items: center !important;
                        font-weight: 500 !important;
                        gap: 0.5rem !important;
                    }
                    
                    .elementor-editor-active .slide-back-link .back-link-chevron {
                        width: 16px !important;
                        height: 16px !important;
                        transform: rotate(90deg) !important;
                    }
                    
                    .elementor-editor-active .slide-publication-date {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                        margin-top: 0.5rem !important;
                        margin-bottom: 1rem !important;
                        font-size: 0.85rem !important;
                        font-style: italic !important;
                        padding: 0.3rem 0.7rem !important;
                        background-color: rgba(0, 0, 0, 0.05) !important;
                        max-width: fit-content !important;
                    }
                    
                    /* Make sure breadcrumb is always visible in the editor */
                    .elementor-editor-active .image-text-slider-breadcrumb {
                        opacity: 1 !important;
                        visibility: visible !important;
                        display: flex !important;
                    }
                    
                    /* Make sure breadcrumb overlay is clearly visible */
                    .elementor-editor-active .image-text-slider-breadcrumb.overlay {
                        background-color: rgba(255, 255, 255, 0.7) !important;
                        z-index: 15 !important;
                        margin-bottom: 0 !important;
                        margin-top: 0 !important;
                        padding: 0.5rem 1rem !important;
                        position: relative !important;
                    }
                    
                    /* Style for above position */
                    .elementor-editor-active .slide-content-container > .image-text-slider-breadcrumb:first-child:not(.overlay) {
                        margin-bottom: 1rem !important;
                    }
                    
                    /* Style for below position */
                    .elementor-editor-active .slide-content-container > .image-text-slider-breadcrumb:last-child:not(.overlay) {
                        margin-top: 1rem !important;
                        margin-bottom: 0 !important;
                    }
                    
                    /* Specific overlay styles based on position */
                    .elementor-editor-active .slide-content-container > .image-text-slider-breadcrumb.overlay:first-child {
                        border-radius: 6px 6px 0 0 !important;
                    }
                    
                    .elementor-editor-active .slide-content-container > .image-text-slider-breadcrumb.overlay:last-child {
                        border-radius: 0 0 6px 6px !important;
                    }
                    
                    /* Make sure tilted divider is properly visible and styled in the editor */
                    .elementor-editor-active .has-tilted-divider-yes .swiper::after {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 0.7 !important;
                        background-color: #ffffff;
                        z-index: 5 !important;
                        pointer-events: none !important;
                        bottom: 0 !important;
                        transform-origin: bottom center !important;
                    }
                    
                    /* Ensure flipped divider is properly displayed */
                    .elementor-editor-active .divider-flipped-yes .swiper::after {
                        transform: skewY(12deg) !important;
                        transform-origin: bottom center !important;
                    }
                    
                    /* Adjust divider origin based on content position */
                    .elementor-editor-active .content-position-left.has-tilted-divider-yes .swiper::after {
                        transform-origin: bottom left !important;
                    }
                    
                    .elementor-editor-active .content-position-right.has-tilted-divider-yes .swiper::after {
                        transform-origin: bottom right !important;
                    }
                    
                    /* Adjust flipped divider origin based on content position */
                    .elementor-editor-active .divider-flipped-yes.content-position-left .swiper::after {
                        transform-origin: bottom left !important;
                    }
                    
                    .elementor-editor-active .divider-flipped-yes.content-position-right .swiper::after {
                        transform-origin: bottom right !important;
                    }
                    
                    /* Add angle indicator for the divider in the editor */
                    .elementor-editor-active .has-tilted-divider-yes .swiper::before {
                        content: attr(data-degrees) "°";
                        position: absolute;
                        bottom: 10px;
                        left: 50%;
                        transform: translateX(-50%);
                        background-color: rgba(0, 0, 0, 0.7);
                        color: white;
                        padding: 3px 8px;
                        border-radius: 4px;
                        font-size: 12px;
                        font-family: monospace;
                        pointer-events: none;
                        z-index: 100;
                        display: block !important;
                    }
                ');
            });
            
            // Force all content to be visible in preview mode
            add_action('elementor/preview/enqueue_styles', function() {
                wp_register_style(
                    'image-text-slider-preview', 
                    false, 
                    [], 
                    '1.0.0'
                );
                
                wp_enqueue_style('image-text-slider-preview');
                
                wp_add_inline_style('image-text-slider-preview', '
                    /* Make sure everything is visible in preview mode */
                    .elementor-editor-preview .image-text-slider-container,
                    .elementor-editor-preview .image-text-slider-container .swiper,
                    .elementor-editor-preview .image-text-slider-container .slide-content-wrapper,
                    .elementor-editor-preview .image-text-slider-container .swiper-content-slider,
                    .elementor-editor-preview .image-text-slider-container .swiper-slide,
                    .elementor-editor-preview .image-text-slider-container .swiper-wrapper,
                    .elementor-editor-preview .image-text-slider-container .swiper-content-slider .swiper-slide,
                    .elementor-editor-preview .image-text-slider-container .swiper-content-slider .swiper-wrapper,
                    .elementor-editor-preview .image-text-slider-container .tilted-divider {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                    }
                    
                    /* Make sure back link and publication date are visible in preview when enabled */
                    .elementor-editor-preview .slide-back-link {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                    }
                    
                    .elementor-editor-preview .slide-publication-date {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                    }
                    
                    /* Position the divider at the bottom in preview mode */
                    .elementor-editor-preview .has-tilted-divider-yes .swiper::after {
                        bottom: 0 !important;
                        transform-origin: bottom center !important;
                        opacity: 0.7 !important;
                        visibility: visible !important;
                        display: block !important;
                    }
                    
                    /* Adjust preview mode origin positions */
                    .elementor-editor-preview .content-position-left.has-tilted-divider-yes .swiper::after {
                        transform-origin: bottom left !important;
                    }
                    
                    .elementor-editor-preview .content-position-right.has-tilted-divider-yes .swiper::after {
                        transform-origin: bottom right !important;
                    }
                    
                    /* Add angle indicator for preview mode too */
                    .elementor-editor-preview .has-tilted-divider-yes .swiper::before {
                        content: attr(data-degrees) "°";
                        position: absolute;
                        bottom: 10px;
                        left: 50%;
                        transform: translateX(-50%);
                        background-color: rgba(0, 0, 0, 0.7);
                        color: white;
                        padding: 3px 8px;
                        border-radius: 4px;
                        font-size: 12px;
                        font-family: monospace;
                        pointer-events: none;
                        z-index: 100;
                        display: block !important;
                    }
                ');
            });
        }
    }

    /**
     * Get available image sizes
     */
    private function get_image_sizes() {
        $wp_image_sizes = get_intermediate_image_sizes();
        $image_sizes = ['full' => 'Full'];
        
        foreach ($wp_image_sizes as $size) {
            $image_sizes[$size] = ucfirst(str_replace(['_', '-'], ' ', $size));
        }
        
        return $image_sizes;
    }

    /**
     * Register controls
     */
    protected function register_controls() {
        // Register all controls from traits
        $this->register_content_controls();
        $this->register_slider_controls();
        $this->register_style_controls();
        $this->register_typography_controls();
        
        // Register editor scripts for better editor experience
        $this->register_editor_scripts();
    }

    /**
     * Render widget output
     */
    protected function render() {
        // Check if all partials exist before including the main render file
        $required_partials = [
            '/templates/partials/_breadcrumb.php',
            '/templates/partials/_slide_image.php',
            '/templates/partials/_slide_content.php'
        ];
        
        $missing_partials = [];
        
        foreach ($required_partials as $partial) {
            $file_path = __DIR__ . $partial;
            if (!file_exists($file_path)) {
                $missing_partials[] = $partial;
            }
        }
        
        if (!empty($missing_partials)) {
            echo '<div class="elementor-alert elementor-alert-danger">';
            echo esc_html__('Error: Missing template files. Please reinstall the widget or contact support.', 'promen-elementor-widgets');
            echo '<ul>';
            foreach ($missing_partials as $missing) {
                echo '<li>' . esc_html($missing) . '</li>';
            }
            echo '</ul>';
            echo '</div>';
            return;
        }
        
        // Include main render template
        $settings = $this->get_settings_for_display();
        include(__DIR__ . '/templates/render.php');
        
        // Add a spacer element after the slider to prevent content below from overlapping
        echo '<div class="slider-bottom-spacer" aria-hidden="true"></div>';
        
        // Add inline script for better editor handling if in edit mode
        if (\Elementor\Plugin::$instance->editor->is_edit_mode()) {
            ?>
            <script type="text/javascript">
            (function() {
                setTimeout(function() {
                    if (typeof window.setupEditorView === 'function') {
                        window.setupEditorView();
                    } else {
                    }
                }, 200);
            })();
            </script>
            <?php
        }
    }

    /**
     * Render content template
     */
    protected function content_template() {
        ?>
        <div class="image-text-slider-container content-position-{{ settings.content_position }}">
            <# if (settings.slides && settings.slides.length) { #>
                <# 
                var tiltAngle = settings.divider_tilt_degrees;
                if (settings.divider_flip_direction === 'yes') {
                    tiltAngle = -tiltAngle;
                }
                var dividerDataAttrs = '';
                if (settings.show_tilted_divider === 'yes') {
                    dividerDataAttrs = ' data-degrees="' + tiltAngle + '" data-height="' + settings.divider_height.size + settings.divider_height.unit + '"';
                }
                #>
                <div class="swiper"{{ dividerDataAttrs }}>
                    <div class="swiper-wrapper">
                        <# _.each(settings.slides, function(slide) { #>
                            <# if (slide.show_slide === 'yes') { #>
                                <div class="swiper-slide elementor-repeater-item-{{ slide._id }}">
                                    <# if (slide.background_image && slide.background_image.url) { #>
                                        <div class="slide-image">
                                            <img src="{{ slide.background_image.url }}" alt="{{ slide.title_text || '' }}">
                                            
                                            <# if (slide.show_overlay_image === 'yes' && slide.overlay_image && slide.overlay_image.url) { #>
                                                <div class="overlay-image">
                                                    <img src="{{ slide.overlay_image.url }}" alt="{{ slide.title_text || '' }} - overlay">
                                                </div>
                                            <# } #>
                                            
                                            <# if (slide.show_absolute_overlay_image === 'yes' && slide.absolute_overlay_image && slide.absolute_overlay_image.url) { 
                                                var positionClass = '';
                                                var positionStyles = '';
                                                var extendClass = slide.absolute_overlay_extend_beyond === 'yes' ? 'extend-beyond' : '';
                                                
                                                if (slide.absolute_overlay_position && slide.absolute_overlay_position !== 'custom') {
                                                    positionClass = 'position-' + slide.absolute_overlay_position;
                                                    
                                                    // Set inline styles based on position
                                                    switch(slide.absolute_overlay_position) {
                                                        case 'top-left':
                                                            positionStyles = 'top: 0; left: 0;';
                                                            break;
                                                        case 'top-center':
                                                            positionStyles = 'top: 0; left: 50%; transform: translateX(-50%);';
                                                            break;
                                                        case 'top-right':
                                                            positionStyles = 'top: 0; right: 0;';
                                                            break;
                                                        case 'middle-left':
                                                            positionStyles = 'top: 50%; left: 0; transform: translateY(-50%);';
                                                            break;
                                                        case 'middle-center':
                                                            positionStyles = 'top: 50%; left: 50%; transform: translate(-50%, -50%);';
                                                            break;
                                                        case 'middle-right':
                                                            positionStyles = 'top: 50%; right: 0; transform: translateY(-50%);';
                                                            break;
                                                        case 'bottom-left':
                                                            positionStyles = 'bottom: 0; left: 0;';
                                                            break;
                                                        case 'bottom-center':
                                                            positionStyles = 'bottom: 0; left: 50%; transform: translateX(-50%);';
                                                            break;
                                                        case 'bottom-right':
                                                            positionStyles = 'bottom: 0; right: 0;';
                                                            break;
                                                    }
                                                    
                                                    // Adjust position if extend-beyond is used
                                                    if (extendClass === 'extend-beyond' && slide.absolute_overlay_position.indexOf('bottom-') === 0) {
                                                        if (slide.absolute_overlay_position === 'bottom-center') {
                                                            positionStyles = 'bottom: -10%; left: 50%; transform: translateX(-50%) translateY(10%);';
                                                        } else {
                                                            positionStyles = positionStyles.replace('bottom: 0;', 'bottom: -10%;');
                                                        }
                                                    }
                                                }
                                            #>
                                                <div class="absolute-overlay-image {{ positionClass }} {{ extendClass }}" style="{{ positionStyles }}">
                                                    <img src="{{ slide.absolute_overlay_image.url }}" alt="{{ slide.title_text || '' }} - absolute overlay">
                                                </div>
                                            <# } #>
                                        </div>
                                    <# } #>
                                </div>
                            <# } #>
                        <# }); #>
                    </div>
                    
                    <# if (settings.show_pagination === 'yes') { #>
                        <div class="swiper-pagination-wrapper">
                            <div class="swiper-pagination-container">
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>
                    <# } #>
                </div>
                
                <div class="slide-content-wrapper">
                    <div class="swiper-content-slider">
                        <div class="swiper-wrapper">
                            <# _.each(settings.slides, function(slide) { #>
                                <# if (slide.show_slide === 'yes') { #>
                                    <div class="swiper-slide elementor-repeater-item-content-{{ slide._id }}">
                                        <div class="slide-content-container">
                                            <# 
                                            // Add breadcrumb above content container if setting is "above"
                                            if (settings.show_breadcrumb === 'yes' && settings.breadcrumb_position === 'above') { 
                                                var breadcrumbPositionClass = settings.breadcrumb_position === 'overlay' ? 'overlay' : '';
                                                var separator = settings.breadcrumb_separator || '›';
                                            #>
                                                <nav class="image-text-slider-breadcrumb {{ breadcrumbPositionClass }}" aria-label="<?php esc_attr_e('Navigatiepad om te zien waar u zich bevindt op de website', 'promen-elementor-widgets'); ?>">
                                                    <div class="breadcrumb-item">
                                                        <a href="#"><?php esc_html_e('Home', 'promen-elementor-widgets'); ?></a>
                                                        <span class="separator">{{ separator }}</span>
                                                    </div>
                                                    <div class="breadcrumb-item">
                                                        <span class="current-item"><?php esc_html_e('Huidige Pagina', 'promen-elementor-widgets'); ?></span>
                                                    </div>
                                                </nav>
                                            <# } #>
                                            <div class="slide-content">
                                                <# 
                                                if (slide.show_title === 'yes' && slide.title_text) { 
                                                    var titleTag = slide.title_tag || 'h2';
                                                #>
                                                    <{{{ titleTag }}} class="slide-title">{{{ slide.title_text }}}</{{{ titleTag }}}>
                                                <# } #>
                                                
                                                <# if (slide.show_content === 'yes' && slide.content) { #>
                                                    <p class="slide-description">{{{ slide.content }}}</p>
                                                <# } #>
                                                
                                                <# if (slide.show_publication_date === 'yes') { #>
                                                    <div class="slide-publication-date">
                                                        <?php 
                                                        // Display placeholder date in editor
                                                        echo sprintf(
                                                            esc_html__('Gepubliceerd op %s', 'promen-elementor-widgets'),
                                                            date_i18n('d M Y')
                                                        ); 
                                                        ?>
                                                    </div>
                                                <# } #>
                                                
                                                <# 
                                                var showButtons = (slide.show_button_1 === 'yes' && slide.button_1_text) || 
                                                                 (slide.show_button_2 === 'yes' && slide.button_2_text);
                                                
                                                if (showButtons) { 
                                                #>
                                                    <div class="slide-buttons">
                                                        <# if (slide.show_button_1 === 'yes' && slide.button_1_text) { 
                                                            var button1Url = '#';
                                                            if (slide.button_1_link && slide.button_1_link.url) {
                                                                button1Url = slide.button_1_link.url;
                                                            }
                                                        #>
                                                            <a href="{{ button1Url }}" class="slide-button button-1">
                                                                {{{ slide.button_1_text }}}
                                                            </a>
                                                        <# } #>
                                                        
                                                        <# if (slide.show_button_2 === 'yes' && slide.button_2_text) { 
                                                            var button2Url = '#';
                                                            if (slide.button_2_link && slide.button_2_link.url) {
                                                                button2Url = slide.button_2_link.url;
                                                            }
                                                        #>
                                                            <a href="{{ button2Url }}" class="slide-button button-2">
                                                                {{{ slide.button_2_text }}}
                                                            </a>
                                                        <# } #>
                                                    </div>
                                                <# } #>
                                                
                                                <# if (settings.show_arrows === 'yes') { #>
                                                    <div class="slider-navigation">
                                                        <div class="swiper-button-prev"></div>
                                                        <div class="swiper-button-next"></div>
                                                    </div>
                                                <# } #>
                                                
                                                <!-- Slider controls inside slide content - only show if 3+ slides -->
                                                <# if (settings.slides && settings.slides.length >= 3) { #>
                                                <div class="image-text-slider-controls" role="group" aria-label="<?php esc_attr_e('Bedieningselementen om de diavoorstelling te controleren en door de dia\'s te navigeren', 'promen-elementor-widgets'); ?>">
                                                    <!-- Navigation buttons -->
                                                    <# if (settings.show_arrows === 'yes') { #>
                                                        <button type="button" class="slider-arrow slider-arrow-prev swiper-button-prev">
                                                            <span aria-hidden="true">‹</span>
                                                            <span class="sr-only"><?php esc_html_e('Ga naar de vorige dia in de diavoorstelling', 'promen-elementor-widgets'); ?></span>
                                                        </button>
                                                        <button type="button" class="slider-arrow slider-arrow-next swiper-button-next">
                                                            <span aria-hidden="true">›</span>
                                                            <span class="sr-only"><?php esc_html_e('Ga naar de volgende dia in de diavoorstelling', 'promen-elementor-widgets'); ?></span>
                                                        </button>
                                                    <# } #>
                                                    
                                                    <!-- Play/Pause and Stop buttons -->
                                                    <# if (settings.autoplay === 'yes') { #>
                                                        <button type="button" class="slider-play-pause active" aria-pressed="true" aria-label="<?php esc_attr_e('Pauzeer de automatische diavoorstelling', 'promen-elementor-widgets'); ?>">
                                                            <span class="play-icon" aria-hidden="true">⏸</span>
                                                            <span class="pause-icon" aria-hidden="true" style="display: none;">▶</span>
                                                            <span class="control-text">Pauzeer slideshow</span>
                                                        </button>
                                                        <button type="button" class="slider-stop" aria-label="<?php esc_attr_e('Stop de automatische diavoorstelling volledig', 'promen-elementor-widgets'); ?>">
                                                            <span class="stop-icon" aria-hidden="true">⏹</span>
                                                            <span class="control-text"><?php esc_html_e('Diavoorstelling stoppen', 'promen-elementor-widgets'); ?></span>
                                                        </button>
                                                    <# } else { #>
                                                        <button type="button" class="slider-play-pause" aria-label="<?php esc_attr_e('Start de automatische diavoorstelling', 'promen-elementor-widgets'); ?>" aria-pressed="false">
                                                            <span class="play-icon" aria-hidden="true" style="display: none;">⏸</span>
                                                            <span class="pause-icon" aria-hidden="true">▶</span>
                                                            <span class="control-text">Start slideshow</span>
                                                        </button>
                                                    <# } #>
                                                    
                                                    <!-- Slide status for screen readers -->
                                                    <div class="slider-status" aria-live="polite" aria-atomic="true">
                                                        <span class="sr-only"><?php esc_html_e('Afbeelding diavoorstelling met meerdere dia\'s. Huidige dia wordt aangekondigd bij wijziging.', 'promen-elementor-widgets'); ?></span>
                                                    </div>
                                                </div>
                                                
                                                <!-- Fraction progress indicator - only show if 3+ slides -->
                                                <div class="slider-fraction-indicator" role="status" aria-label="<?php esc_attr_e('Voortgang van de diavoorstelling met huidige en totale aantal dia\'s', 'promen-elementor-widgets'); ?>">
                                                    <span class="current-slide">{{{ 1 }}}</span>
                                                    <span class="progress-separator"> / </span>
                                                    <span class="total-slides">{{{ settings.slides.length }}}</span>
                                                </div>
                                                <# } #>
                                            </div>
                                            <# 
                                            // Add breadcrumb below content container if setting is "below" or "overlay"
                                            if (settings.show_breadcrumb === 'yes' && (settings.breadcrumb_position === 'below' || settings.breadcrumb_position === 'overlay')) { 
                                                var breadcrumbPositionClass = settings.breadcrumb_position === 'overlay' ? 'overlay' : '';
                                                var separator = settings.breadcrumb_separator || '›';
                                            #>
                                                <nav class="image-text-slider-breadcrumb {{ breadcrumbPositionClass }}" aria-label="<?php esc_attr_e('Navigatiepad om te zien waar u zich bevindt op de website', 'promen-elementor-widgets'); ?>">
                                                    <div class="breadcrumb-item">
                                                        <a href="#"><?php esc_html_e('Home', 'promen-elementor-widgets'); ?></a>
                                                        <span class="separator">{{ separator }}</span>
                                                    </div>
                                                    <div class="breadcrumb-item">
                                                        <span class="current-item"><?php esc_html_e('Huidige Pagina', 'promen-elementor-widgets'); ?></span>
                                                    </div>
                                                </nav>
                                            <# } #>
                                        </div>
                                    </div>
                                <# } #>
                            <# }); #>
                        </div>
                    </div>
                </div>
            <# } else { #>
                <div class="elementor-alert elementor-alert-info">
                    <?php esc_html_e('Voeg dia\'s toe om de schuifregelaar weer te geven.', 'promen-elementor-widgets'); ?>
                </div>
            <# } #>
            
            <!-- Spacer element to ensure content below is pushed down properly -->
            <div class="slider-bottom-spacer"></div>
        </div>
        <?php
    }
} 