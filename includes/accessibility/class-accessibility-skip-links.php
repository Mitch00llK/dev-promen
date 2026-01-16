<?php
/**
 * Accessibility Skip Links
 * 
 * Provides skip link functionality for accessible navigation.
 * 
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Accessibility Skip Links Class
 */
class Promen_Accessibility_Skip_Links {

    /**
     * Instance
     *
     * @var Promen_Accessibility_Skip_Links|null
     */
    private static $instance = null;

    /**
     * Get Instance
     *
     * @return Promen_Accessibility_Skip_Links
     */
    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        // Add skip links to Elementor widgets
        add_action('elementor/widget/before_render_content', [$this, 'inject_widget_skip_link'], 10, 1);
        
        // Add JavaScript to ensure widget containers have proper IDs for skip links
        add_action('wp_footer', [$this, 'add_widget_skip_link_script'], 99);
        
        // Enqueue skip links JavaScript
        add_action('wp_enqueue_scripts', [$this, 'enqueue_skip_links_script']);
    }

    /**
     * Enqueue skip links JavaScript
     */
    public function enqueue_skip_links_script() {
        wp_enqueue_script(
            'promen-skip-links',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/skip-links.js',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
    }

    /**
     * Generate skip link
     * 
     * @param string $target Target element ID.
     * @param string $text Link text.
     * @return string Skip link HTML.
     */
    public static function get_skip_link($target, $text = '') {
        if (empty($text)) {
            $text = __('Sla over naar inhoud', 'promen-elementor-widgets');
        }

        return '<a href="#' . esc_attr($target) . '" class="skip-link screen-reader-text">' . esc_html($text) . '</a>';
    }

    /**
     * Generate skip link for widget
     * 
     * @param string $widget_id Widget ID or unique identifier.
     * @param string $widget_title Widget title (optional).
     * @param string $widget_name Widget name/slug (optional).
     * @return string Skip link HTML.
     */
    public static function get_widget_skip_link($widget_id, $widget_title = '', $widget_name = '') {
        $elementor_wrapper_id = 'elementor-widget-' . esc_attr($widget_id);
        $custom_target_id = Promen_Accessibility_Aria::generate_id('widget-content', $widget_id);
        
        // Always use standardized Dutch text - "Sla over naar inhoud" (Skip to content)
        // Ignore widget_title parameter to ensure consistency across all widgets
        $skip_link_text = __('Sla over naar inhoud', 'promen-elementor-widgets');
        
        return '<a href="#' . esc_attr($elementor_wrapper_id) . '" class="skip-link widget-skip-link" data-widget-id="' . esc_attr($widget_id) . '" data-custom-target="' . esc_attr($custom_target_id) . '">' . esc_html($skip_link_text) . '</a>';
    }

    /**
     * Render widget skip link
     * 
     * @param string|object $widget Widget instance or widget ID.
     * @param string        $widget_title Optional custom title.
     */
    public static function render_widget_skip_link($widget, $widget_title = '') {
        if (is_object($widget)) {
            $widget_id = method_exists($widget, 'get_id') ? $widget->get_id() : '';
            $widget_name = method_exists($widget, 'get_name') ? $widget->get_name() : '';
            
            if (empty($widget_title) && method_exists($widget, 'get_title')) {
                $widget_title = $widget->get_title();
            }
        } else {
            $widget_id = $widget;
            $widget_name = '';
        }
        
        if (empty($widget_id)) {
            return;
        }
        
        echo self::get_widget_skip_link($widget_id, $widget_title, $widget_name); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Generate widget container ID for skip link target
     * 
     * @param string $widget_id Widget ID.
     * @return string Container ID.
     */
    public static function get_widget_container_id($widget_id) {
        return Promen_Accessibility_Aria::generate_id('widget-content', $widget_id);
    }

    /**
     * Inject skip link for Elementor widgets
     * 
     * @param \Elementor\Widget_Base $widget Widget instance.
     */
    public function inject_widget_skip_link($widget) {
        $widget_name = $widget->get_name();
        if (strpos($widget_name, 'promen_') !== 0 && strpos($widget_name, 'promen-') !== 0) {
            $widget_class = get_class($widget);
            $promen_widgets = $this->get_promen_widget_classes();
            
            if (!in_array($widget_class, $promen_widgets, true)) {
                return;
            }
        }
        
        $widget_id = $widget->get_id();
        $widget_title = $widget->get_title();
        
        self::render_widget_skip_link($widget, $widget_title);
    }

    /**
     * Get list of Promen widget class names
     *
     * @return array
     */
    private function get_promen_widget_classes() {
        return [
            'Promen_Feature_Blocks_Widget',
            'Promen_Services_Carousel_Widget',
            'Promen_Image_Text_Block_Widget',
            'Promen_News_Posts_Widget',
            'Promen_Stats_Counter_Widget',
            'Contact_Info_Card_Widget',
            'Promen_Team_Members_Carousel_Widget',
            'Promen_Certification_Logos_Widget',
            'Promen_Services_Grid',
            'Promen_Worker_Testimonial_Widget',
            'Promen_Benefits_Widget',
            'Promen_Benefits_Wrapper',
            'Promen_Hero_Slider',
            'Promen_Text_Content_Block_Widget',
            'Promen_Image_Slider_Widget',
            'Promen_Related_Services',
            'Promen_Text_Column_Repeater_Widget',
            'Promen_Solicitation_Timeline_Widget',
            'Promen_Business_Catering_Widget',
            'Promen_Testimonial_Card_Widget',
            'Promen_Image_Text_Slider_Widget',
            'Promen_Checklist_Comparison_Widget',
            'Promen_Contact_Info_Blocks_Widget',
            'Promen_Locations_Display_Widget',
            'Promen_Document_Info_List_Widget',
            'Promen_Hamburger_Menu_Widget'
        ];
    }

    /**
     * Add JavaScript to handle skip link targeting (fallback for inline script)
     */
    public function add_widget_skip_link_script() {
        // Skip if external JS is enqueued
        if (wp_script_is('promen-skip-links', 'enqueued')) {
            return;
        }
        
        ?>
        <script>
        (function() {
            'use strict';
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initSkipLinks);
            } else {
                initSkipLinks();
            }
            
            function initSkipLinks() {
                var skipLinks = document.querySelectorAll('.widget-skip-link');
                
                skipLinks.forEach(function(skipLink) {
                    var widgetId = skipLink.getAttribute('data-widget-id');
                    if (!widgetId) return;
                    
                    var elementorWrapperId = 'elementor-widget-' + widgetId;
                    var elementorWrapper = document.getElementById(elementorWrapperId);
                    
                    if (elementorWrapper) {
                        elementorWrapper.style.scrollMarginTop = '20px';
                        elementorWrapper.style.scrollMarginBottom = '20px';
                        
                        skipLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            var target = document.getElementById(elementorWrapperId);
                            if (target) {
                                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                var focusable = target.querySelector('a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])');
                                if (focusable) {
                                    setTimeout(function() {
                                        focusable.focus();
                                    }, 300);
                                }
                            }
                        });
                    }
                });
            }
        })();
        </script>
        <?php
    }
}

// Initialize skip links
Promen_Accessibility_Skip_Links::instance();
