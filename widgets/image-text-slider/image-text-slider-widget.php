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
require_once(__DIR__ . '/includes/ViewHelper.php');

/**
 * Image Text Slider Widget Class
 * 
 * A modern slider with image backgrounds and text overlay containers
 */
class Promen_Image_Text_Slider_Widget extends \Promen_Widget_Base {
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
        return ['promen-image-text-slider-init'];
    }

    /**
     * Get widget style dependencies.
     *
     * @return array Widget style dependencies.
     */
    public function get_style_depends() {
        return [
            'image-text-slider', 
            'image-text-slider-layout', 
            'image-text-slider-content', 
            'image-text-slider-controls', 
            'image-text-slider-accessibility', 
            'image-text-slider-mobile', 
            'image-text-slider-responsive'
        ];
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
        // Only add these styles if we're in the editor or preview
        if (\Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode()) {
            
            add_action('elementor/frontend/after_enqueue_styles', function() {
                wp_enqueue_style(
                    'image-text-slider-editor',
                    plugin_dir_url(__FILE__) . 'assets/css/editor.css',
                    [],
                    '1.0.0'
                );
            });

            // Make sure it loads in admin as well for the editor frame
            add_action('admin_enqueue_scripts', function() {
                wp_enqueue_style(
                    'image-text-slider-editor',
                    plugin_dir_url(__FILE__) . 'assets/css/editor.css',
                    [],
                    '1.0.0'
                );
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
        
        $settings = $this->get_settings_for_display();
        $id_int = substr($this->get_id_int(), 0, 3);
        $slider_id = 'image-text-slider-' . $id_int;
        
        // Include breadcrumb logic to generate $breadcrumb_html
        include __DIR__ . '/templates/partials/_breadcrumb.php';
        
        // Use ViewHelper to prepare data
        $visible_slides = Promen_Image_Text_Slider_View_Helper::get_visible_slides($settings['slides']);
        
        if (empty($visible_slides)) {
            echo '<div class="image-text-slider-no-slides">';
            echo esc_html__('No slides to display. Please add slides in the widget settings.', 'promen-elementor-widgets');
            echo '</div>';
            return;
        }
        
        $container_class = Promen_Image_Text_Slider_View_Helper::get_container_classes($settings, $visible_slides);
        $slider_options = Promen_Image_Text_Slider_View_Helper::get_slider_options($settings);
        $divider_data_attrs = Promen_Image_Text_Slider_View_Helper::get_divider_data_attrs($settings);
        
        // Accessibility attributes
        $accessibility_attrs = \Promen_Accessibility_Utils::get_slider_attrs([
            'widget_id' => $this->get_id(),
            'slides_count' => count($visible_slides),
            'autoplay' => $slider_options['autoplay'],
            'loop' => $slider_options['infinite']
        ]);
        
        // Transition settings
        $transition_speed = (int)$settings['transition_speed'];
        $show_arrows = $settings['show_arrows'] === 'yes';
        $show_pagination = $settings['show_pagination'] === 'yes';

        // Include main render template
        include(__DIR__ . '/templates/render.php');
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