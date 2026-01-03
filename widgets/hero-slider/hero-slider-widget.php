<?php
/**
 * Hero Slider Widget
 * 
 * A modern, optimized slider widget for Elementor
 * 
 * @package Elementor
 * @subpackage Elementor Widgets
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Load traits
require_once(__DIR__ . '/controls/content-section.php');
require_once(__DIR__ . '/controls/layout-section.php');
require_once(__DIR__ . '/controls/slider-section.php');
require_once(__DIR__ . '/controls/navigation-section.php');
require_once(__DIR__ . '/controls/style-section.php');
require_once(__DIR__ . '/controls/typography-section.php');

/**
 * Hero Slider Widget Class
 * 
 * A modern, optimized slider widget for Elementor with clean architecture
 * and performance optimizations.
 */
class Hero_Slider_Widget extends \Elementor\Widget_Base {
    use Hero_Slider_Content_Controls;
    use Hero_Slider_Layout_Controls;
    use Hero_Slider_Slider_Controls;
    use Hero_Slider_Navigation_Controls;
    use Hero_Slider_Style_Controls;
    use Hero_Slider_Typography_Controls;

    /**
     * Get widget name.
     *
     * @return string Widget name.
     */
    public function get_name() {
        return 'hero_slider';
    }

    /**
     * Get widget title.
     *
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Hero Slider', 'elementor-widgets');
    }

    /**
     * Get widget icon.
     *
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-slider-full-screen';
    }

    /**
     * Get widget categories.
     *
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['widgets'];
    }

    /**
     * Get widget keywords.
     *
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['hero', 'slider', 'banner', 'carousel'];
    }

    /**
     * Get widget script dependencies.
     *
     * @return array Widget script dependencies.
     */
    public function get_script_depends() {
        return ['swiper-bundle', 'hero-slider'];
    }

    /**
     * Get widget style dependencies.
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends() {
        return ['swiper-bundle-css', 'hero-slider'];
    }

    /**
     * Get available image sizes
     *
     * @return array Available image sizes.
     */
    private function get_image_sizes() {
        $sizes = get_intermediate_image_sizes();
        $sizes = array_combine($sizes, $sizes);
        $sizes['full'] = 'full';
        return $sizes;
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        $this->register_content_controls();
        $this->register_layout_controls();
        $this->register_slider_controls();
        $this->register_navigation_controls();
        $this->register_style_controls();
        $this->register_typography_controls();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        try {
            // Check if the template file exists
            $template_file = __DIR__ . '/templates/render.php';
            if (!file_exists($template_file)) {
                echo '<div class="hero-slider-error">Template file not found.</div>';
                return;
            }
            
            // Include the template file
            include($template_file);
        } catch (Exception $e) {
            // Log the error
            error_log('Hero Slider Widget Error: ' . $e->getMessage());
            
            // Display a fallback message
            echo '<div class="hero-slider-error">Error rendering hero slider. Please check the error logs.</div>';
        }
    }

    /**
     * Add custom render attributes for editor mode
     */
    protected function _content_template() {
        ?>
        <# if ( settings.slides ) { #>
            <div class="hero-slider-container hero-slider-mode">
                <div id="hero-slider-preview" class="hero-slider">
                    <# if ( settings.show_tilted_divider === 'yes' && settings.divider_position === 'top' ) { #>
                    <div class="hero-tilted-divider"></div>
                    <# } #>
                    <div class="swiper">
                        <div class="swiper-wrapper">
                            <# _.each( settings.slides, function( slide, index ) { #>
                                <# if ( slide.show_slide === 'yes' ) { #>
                                    <div class="hero-slide swiper-slide elementor-repeater-item-{{ slide._id }}">
                                        <# if ( slide.background_image.url ) { 
                                            var imagePosition = slide.image_position || 'center center';
                                            var bgStyle = 'background-image: url(' + slide.background_image.url + '); background-position: ' + imagePosition + ';';
                                        #>
                                            <div class="hero-slide-background" style="{{ bgStyle }}"></div>
                                        <# } #>
                                        
                                        <# if ( settings.overlay_type !== 'none' ) { #>
                                            <div class="hero-slide-overlay"></div>
                                        <# } #>
                                        
                                        <# 
                                        // Determine content container classes and styles
                                        var contentContainerClasses = 'hero-slide-content-container';
                                        var contentContainerStyles = '';
                                        
                                        // Add vertical position style
                                        if (settings.content_vertical_position) {
                                            contentContainerStyles += 'align-items:' + settings.content_vertical_position + ';';
                                        }
                                        
                                        // Add horizontal position style
                                        if (settings.content_horizontal_position) {
                                            contentContainerStyles += 'justify-content:' + settings.content_horizontal_position + ';';
                                        }
                                        
                                        // Determine content wrapper classes and styles
                                        var contentWrapperClasses = 'hero-slide-content-wrapper';
                                        var contentWrapperStyles = '';
                                        
                                        // Add position styles for content overlap
                                        if (settings.content_overlap === 'yes') {
                                            contentWrapperClasses += ' editor-overlap-fix';
                                            
                                            if (settings.content_vertical_position === 'flex-start') {
                                                contentWrapperStyles += 'position:absolute; top:0; transform:translateY(3rem);';
                                            } else if (settings.content_vertical_position === 'center') {
                                                contentWrapperStyles += 'position:absolute; top:50%; transform:translateY(-50%);';
                                            } else if (settings.content_vertical_position === 'flex-end') {
                                                contentWrapperStyles += 'position:absolute; top:100%; transform:translateY(-50px);';
                                            }
                                        }
                                        #>
                                        
                                        <div class="{{ contentContainerClasses }}" style="{{ contentContainerStyles }}">
                                            <div class="{{ contentWrapperClasses }}" style="{{ contentWrapperStyles }}">
                                                <# if ( slide.show_title === 'yes' && slide.title_text ) { 
                                                    var titleTag = slide.title_tag || 'h1';
                                                #>
                                                    <{{{ titleTag }}} class="hero-slide-title">{{{ slide.title_text }}}</{{{ titleTag }}}>
                                                <# } #>
                                                
                                                <# if ( slide.show_content === 'yes' && slide.content ) { #>
                                                    <div class="hero-slide-content">
                                                        <p>{{{ slide.content }}}</p>
                                                    </div>
                                                <# } #>
                                                
                                                <div class="hero-slide-buttons">
                                                    <# if ( slide.show_button_1 === 'yes' && slide.button_1_text ) { 
                                                        var button1Url = slide.button_1_link && slide.button_1_link.url ? slide.button_1_link.url : '#';
                                                    #>
                                                        <a href="{{ button1Url }}" class="hero-button hero-button-1">
                                                            {{ slide.button_1_text }}
                                                            <# if ( slide.button_1_icon && slide.button_1_icon.value ) { #>
                                                                <span class="hero-button-icon">
                                                                    <i class="{{ slide.button_1_icon.value }}"></i>
                                                                </span>
                                                            <# } #>
                                                        </a>
                                                    <# } #>
                                                    
                                                    <# if ( slide.show_button_2 === 'yes' && slide.button_2_text ) { 
                                                        var button2Url = slide.button_2_link && slide.button_2_link.url ? slide.button_2_link.url : '#';
                                                    #>
                                                        <a href="{{ button2Url }}" class="hero-button hero-button-2">
                                                            {{ slide.button_2_text }}
                                                            <# if ( slide.button_2_icon && slide.button_2_icon.value ) { #>
                                                                <span class="hero-button-icon">
                                                                    <i class="{{ slide.button_2_icon.value }}"></i>
                                                                </span>
                                                            <# } #>
                                                        </a>
                                                    <# } #>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <# } #>
                            <# }); #>
                        </div>
                    </div>
                    
                    <# if ( settings.show_pagination === 'yes' ) { #>
                    <div class="swiper-pagination"></div>
                    <# } #>
                    </div>
                    <# if ( settings.show_tilted_divider === 'yes' && settings.divider_position === 'bottom' ) { #>
                    <div class="hero-tilted-divider"></div>
                    <# } #>
                </div>
            </div>
        <# } else { #>
            <div class="hero-slider-no-slides">
                <?php echo esc_html__('No slides to display. Please add slides in the widget settings.', 'elementor-widgets'); ?>
            </div>
        <# } #>
        <?php
    }
} 