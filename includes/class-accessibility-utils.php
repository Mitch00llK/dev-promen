<?php
/**
 * Accessibility Utilities Class
 * 
 * Provides WCAG 2.1/2.2 compliant accessibility helpers and utilities
 * for all Promen Elementor Widgets.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Accessibility Utilities Class
 */
class Promen_Accessibility_Utils {

    /**
     * Instance
     */
    private static $_instance = null;

    /**
     * Get Instance
     */
    public static function instance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Constructor
     */
    public function __construct() {
        $this->init_hooks();
    }

    /**
     * Initialize hooks
     */
    private function init_hooks() {
        // Enqueue screen reader styles
        add_action('wp_enqueue_scripts', [$this, 'enqueue_accessibility_styles']);
        
        // Add accessibility features to wp_head
        add_action('wp_head', [$this, 'add_accessibility_features']);
        
        // Add skip links to Elementor widgets
        add_action('elementor/widget/before_render_content', [$this, 'inject_widget_skip_link'], 10, 1);
        
        // Add JavaScript to ensure widget containers have proper IDs for skip links
        add_action('wp_footer', [$this, 'add_widget_skip_link_script'], 99);
    }

    /**
     * Enqueue accessibility styles
     */
    public function enqueue_accessibility_styles() {
        wp_enqueue_style(
            'promen-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/css/accessibility.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
    }

    /**
     * Add accessibility features to head
     */
    public function add_accessibility_features() {
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<style>
            .screen-reader-text:not(:focus) {
                position: absolute !important;
                clip: rect(1px, 1px, 1px, 1px);
                width: 1px !important;
                height: 1px !important;
                overflow: hidden;
                word-wrap: normal !important;
            }
            .screen-reader-text:focus {
                clip: auto !important;
                width: auto !important;
                height: auto !important;
                background: #000;
                color: #fff;
                padding: 0.5em;
                z-index: 100000;
                text-decoration: none;
                box-shadow: 0 0 2px 2px rgba(0,0,0,.6);
            }
        </style>';
    }

    /**
     * Generate unique ID for accessibility purposes
     * 
     * @param string $prefix ID prefix
     * @param string $widget_id Widget ID
     * @return string Unique accessibility ID
     */
    public static function generate_id($prefix, $widget_id = '') {
        $unique_id = $prefix . '-' . ($widget_id ? $widget_id : wp_generate_uuid4());
        return sanitize_html_class($unique_id);
    }

    /**
     * Generate ARIA label attributes
     * 
     * @param string $label The aria-label text
     * @param string $labelledby Optional aria-labelledby ID
     * @param string $describedby Optional aria-describedby ID
     * @return string ARIA attributes string
     */
    public static function get_aria_label_attrs($label = '', $labelledby = '', $describedby = '') {
        $attrs = [];

        if (!empty($label)) {
            $attrs[] = 'aria-label="' . esc_attr($label) . '"';
        }

        if (!empty($labelledby)) {
            $attrs[] = 'aria-labelledby="' . esc_attr($labelledby) . '"';
        }

        if (!empty($describedby)) {
            $attrs[] = 'aria-describedby="' . esc_attr($describedby) . '"';
        }

        return implode(' ', $attrs);
    }

    /**
     * Generate ARIA live region attributes
     * 
     * @param string $politeness 'polite', 'assertive', or 'off'
     * @param bool $atomic Whether the entire region should be announced
     * @return string ARIA live attributes
     */
    public static function get_aria_live_attrs($politeness = 'polite', $atomic = false) {
        $attrs = [];
        
        $attrs[] = 'aria-live="' . esc_attr($politeness) . '"';
        
        if ($atomic) {
            $attrs[] = 'aria-atomic="true"';
        }

        return implode(' ', $attrs);
    }

    /**
     * Generate button accessibility attributes
     * 
     * @param array $args Button configuration
     * @return string Button attributes
     */
    public static function get_button_attrs($args = []) {
        $defaults = [
            'label' => '',
            'expanded' => null,
            'controls' => '',
            'haspopup' => false,
            'pressed' => null,
            'disabled' => false
        ];

        $args = wp_parse_args($args, $defaults);
        $attrs = [];

        if (!empty($args['label'])) {
            $attrs[] = 'aria-label="' . esc_attr($args['label']) . '"';
        }

        if (!is_null($args['expanded'])) {
            $attrs[] = 'aria-expanded="' . ($args['expanded'] ? 'true' : 'false') . '"';
        }

        if (!empty($args['controls'])) {
            $attrs[] = 'aria-controls="' . esc_attr($args['controls']) . '"';
        }

        if ($args['haspopup']) {
            $attrs[] = 'aria-haspopup="true"';
        }

        if (!is_null($args['pressed'])) {
            $attrs[] = 'aria-pressed="' . ($args['pressed'] ? 'true' : 'false') . '"';
        }

        if ($args['disabled']) {
            $attrs[] = 'aria-disabled="true"';
            $attrs[] = 'disabled';
        }

        return implode(' ', $attrs);
    }

    /**
     * Generate slider/carousel accessibility attributes
     * 
     * @param array $args Slider configuration
     * @return array Slider accessibility data
     */
    public static function get_slider_attrs($args = []) {
        $defaults = [
            'widget_id' => '',
            'slides_count' => 0,
            'autoplay' => false,
            'loop' => false
        ];

        $args = wp_parse_args($args, $defaults);
        
        $container_id = self::generate_id('slider-container', $args['widget_id']);
        $live_region_id = self::generate_id('slider-live-region', $args['widget_id']);

        return [
            'container_id' => $container_id,
            'live_region_id' => $live_region_id,
            'container_attrs' => 'role="region" aria-label="' . esc_attr__('Image carousel', 'promen-elementor-widgets') . '" aria-describedby="' . esc_attr($live_region_id) . '"',
            'live_region_attrs' => self::get_aria_live_attrs('polite', true),
            'prev_button_attrs' => self::get_button_attrs([
                'label' => __('Previous slide', 'promen-elementor-widgets'),
                'controls' => $container_id
            ]),
            'next_button_attrs' => self::get_button_attrs([
                'label' => __('Next slide', 'promen-elementor-widgets'),
                'controls' => $container_id
            ]),
            'play_button_attrs' => self::get_button_attrs([
                'label' => $args['autoplay'] ? __('Pause slideshow', 'promen-elementor-widgets') : __('Play slideshow', 'promen-elementor-widgets'),
                'pressed' => $args['autoplay'],
                'controls' => $container_id
            ])
        ];
    }

    /**
     * Generate menu accessibility attributes
     * 
     * @param array $args Menu configuration
     * @return array Menu accessibility data
     */
    public static function get_menu_attrs($args = []) {
        $defaults = [
            'widget_id' => '',
            'expanded' => false,
            'has_submenu' => false
        ];

        $args = wp_parse_args($args, $defaults);
        
        $menu_id = self::generate_id('menu', $args['widget_id']);
        $toggle_id = self::generate_id('menu-toggle', $args['widget_id']);

        return [
            'menu_id' => $menu_id,
            'toggle_id' => $toggle_id,
            'toggle_attrs' => self::get_button_attrs([
                'label' => __('Toggle navigation menu', 'promen-elementor-widgets'),
                'expanded' => $args['expanded'],
                'controls' => $menu_id,
                'haspopup' => $args['has_submenu']
            ]),
            'menu_attrs' => 'role="navigation" aria-labelledby="' . esc_attr($toggle_id) . '"'
        ];
    }

    /**
     * Generate form accessibility attributes
     * 
     * @param array $args Form configuration
     * @return array Form accessibility data
     */
    public static function get_form_attrs($args = []) {
        $defaults = [
            'widget_id' => '',
            'required_fields' => [],
            'error_message' => ''
        ];

        $args = wp_parse_args($args, $defaults);
        
        $error_id = self::generate_id('form-error', $args['widget_id']);
        $success_id = self::generate_id('form-success', $args['widget_id']);

        return [
            'error_id' => $error_id,
            'success_id' => $success_id,
            'error_attrs' => 'id="' . esc_attr($error_id) . '" ' . self::get_aria_live_attrs('assertive', true),
            'success_attrs' => 'id="' . esc_attr($success_id) . '" ' . self::get_aria_live_attrs('polite', true),
            'required_indicator' => '<span aria-label="' . esc_attr__('Required field', 'promen-elementor-widgets') . '">*</span>'
        ];
    }

    /**
     * Generate focus trap for modals/overlays
     * 
     * @param string $container_selector CSS selector for the container
     * @return string JavaScript focus trap code
     */
    public static function get_focus_trap_js($container_selector) {
        return "
        function initFocusTrap(containerSelector) {
            const container = document.querySelector(containerSelector);
            if (!container) return;
            
            const focusableElements = container.querySelectorAll(
                'a[href], button:not([disabled]), textarea:not([disabled]), input[type=\"text\"]:not([disabled]), input[type=\"radio\"]:not([disabled]), input[type=\"checkbox\"]:not([disabled]), select:not([disabled]), [tabindex]:not([tabindex=\"-1\"])'
            );
            
            const firstFocusable = focusableElements[0];
            const lastFocusable = focusableElements[focusableElements.length - 1];
            
            container.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    if (e.shiftKey) {
                        if (document.activeElement === firstFocusable) {
                            lastFocusable.focus();
                            e.preventDefault();
                        }
                    } else {
                        if (document.activeElement === lastFocusable) {
                            firstFocusable.focus();
                            e.preventDefault();
                        }
                    }
                }
                
                if (e.key === 'Escape') {
                    container.style.display = 'none';
                    container.setAttribute('aria-hidden', 'true');
                }
            });
            
            if (firstFocusable) {
                firstFocusable.focus();
            }
        }
        
        initFocusTrap('" . esc_js($container_selector) . "');
        ";
    }

    /**
     * Check if user prefers reduced motion
     * 
     * @return bool True if user prefers reduced motion
     */
    public static function prefers_reduced_motion() {
        return false; // Will be enhanced with JavaScript detection
    }

    /**
     * Generate screen reader text
     * 
     * @param string $text The text for screen readers
     * @param string $tag HTML tag to wrap the text
     * @return string HTML markup
     */
    public static function get_screen_reader_text($text, $tag = 'span') {
        return '<' . esc_attr($tag) . ' class="screen-reader-text">' . esc_html($text) . '</' . esc_attr($tag) . '>';
    }

    /**
     * Generate skip link
     * 
     * @param string $target Target element ID
     * @param string $text Link text
     * @return string Skip link HTML
     */
    public static function get_skip_link($target, $text = '') {
        if (empty($text)) {
            $text = __('Sla over naar inhoud', 'promen-elementor-widgets');
        }

        return '<a href="#' . esc_attr($target) . '" class="screen-reader-text">' . esc_html($text) . '</a>';
    }

    /**
     * Generate skip link for widget
     * 
     * @param string $widget_id Widget ID or unique identifier
     * @param string $widget_title Widget title (optional, will be auto-generated if empty)
     * @param string $widget_name Widget name/slug (optional)
     * @return string Skip link HTML
     */
    public static function get_widget_skip_link($widget_id, $widget_title = '', $widget_name = '') {
        // Elementor automatically creates a wrapper with ID: elementor-widget-{widget_id}
        // We'll use that as the target, but also add a fallback custom ID
        $elementor_wrapper_id = 'elementor-widget-' . esc_attr($widget_id);
        $custom_target_id = self::generate_id('widget-content', $widget_id);
        
        // Always use "Sla over naar inhoud" for widget skip links
        $widget_title = __('Sla over naar inhoud', 'promen-elementor-widgets');
        
        // Use Elementor's wrapper ID as primary target
        return '<a href="#' . esc_attr($elementor_wrapper_id) . '" class="skip-link widget-skip-link" data-widget-id="' . esc_attr($widget_id) . '" data-custom-target="' . esc_attr($custom_target_id) . '">' . esc_html($widget_title) . '</a>';
    }

    /**
     * Render widget skip link (helper function for easy use)
     * 
     * @param string|object $widget Widget instance or widget ID
     * @param string $widget_title Optional custom title
     * @return void Echoes the skip link
     */
    public static function render_widget_skip_link($widget, $widget_title = '') {
        // Handle both widget object and widget ID string
        if (is_object($widget)) {
            $widget_id = method_exists($widget, 'get_id') ? $widget->get_id() : '';
            $widget_name = method_exists($widget, 'get_name') ? $widget->get_name() : '';
            
            // Try to get title from widget if not provided
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
        
        echo self::get_widget_skip_link($widget_id, $widget_title, $widget_name);
    }

    /**
     * Generate widget container ID for skip link target
     * 
     * @param string $widget_id Widget ID
     * @return string Container ID
     */
    public static function get_widget_container_id($widget_id) {
        return self::generate_id('widget-content', $widget_id);
    }

    /**
     * Validate color contrast ratio
     * 
     * @param string $foreground Foreground color (hex)
     * @param string $background Background color (hex)
     * @return float Contrast ratio
     */
    public static function get_contrast_ratio($foreground, $background) {
        // Convert hex to RGB
        $fg_rgb = self::hex_to_rgb($foreground);
        $bg_rgb = self::hex_to_rgb($background);
        
        // Calculate relative luminance
        $fg_luminance = self::get_relative_luminance($fg_rgb);
        $bg_luminance = self::get_relative_luminance($bg_rgb);
        
        // Calculate contrast ratio
        $lighter = max($fg_luminance, $bg_luminance);
        $darker = min($fg_luminance, $bg_luminance);
        
        return ($lighter + 0.05) / ($darker + 0.05);
    }

    /**
     * Convert hex color to RGB
     * 
     * @param string $hex Hex color code
     * @return array RGB values
     */
    private static function hex_to_rgb($hex) {
        $hex = ltrim($hex, '#');
        
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    /**
     * Get relative luminance
     * 
     * @param array $rgb RGB color values
     * @return float Relative luminance
     */
    private static function get_relative_luminance($rgb) {
        $r = $rgb['r'] / 255;
        $g = $rgb['g'] / 255;
        $b = $rgb['b'] / 255;
        
        $r = $r <= 0.03928 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = $g <= 0.03928 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = $b <= 0.03928 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);
        
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    /**
     * Generate service accessibility attributes
     * 
     * @param array $service Service data
     * @param int $index Service index
     * @param string $widget_id Widget ID
     * @return array Service accessibility data
     */
    public static function get_service_attrs($service, $index = 0, $widget_id = '') {
        $service_title = !empty($service['service_title']) ? $service['service_title'] : '';
        $service_description = !empty($service['service_description']) ? $service['service_description'] : '';
        $service_link = !empty($service['service_link']['url']) ? $service['service_link']['url'] : '';
        
        // Generate unique IDs
        $service_item_id = self::generate_id('service-item-' . ($index + 1), $widget_id);
        $service_title_id = self::generate_id('service-title-' . ($index + 1), $widget_id);
        $service_description_id = self::generate_id('service-description-' . ($index + 1), $widget_id);
        $service_icon_id = self::generate_id('service-icon-' . ($index + 1), $widget_id);
        
        // Generate aria-labels based on service title
        $base_label = $service_title;
        $link_label = $service_title;
        $icon_label = $service_title;
        
        // Add context to labels
        if (!empty($service_link)) {
            $link_label = sprintf(__('Lees meer over %s', 'promen-elementor-widgets'), $service_title);
        }
        
        if (!empty($service['service_icon']['value'])) {
            $icon_label = sprintf(__('%s icon', 'promen-elementor-widgets'), $service_title);
        }
        
        // Add description to base label if available
        if (!empty($service_description)) {
            $base_label = sprintf(__('%s: %s', 'promen-elementor-widgets'), $service_title, $service_description);
        }
        
        return [
            'service_item_id' => $service_item_id,
            'service_title_id' => $service_title_id,
            'service_description_id' => $service_description_id,
            'service_icon_id' => $service_icon_id,
            'service_item_attrs' => 'role="listitem" tabindex="0" aria-labelledby="' . esc_attr($service_title_id) . '"' . (!empty($service_description_id) ? ' aria-describedby="' . esc_attr($service_description_id) . '"' : ''),
            'service_link_attrs' => 'aria-label="' . esc_attr($link_label) . '"',
            'service_icon_attrs' => 'role="img" aria-label="' . esc_attr($icon_label) . '"',
            'service_title_attrs' => 'id="' . esc_attr($service_title_id) . '"',
            'service_description_attrs' => 'id="' . esc_attr($service_description_id) . '"',
            'service_icon_id_attr' => 'id="' . esc_attr($service_icon_id) . '"',
            'base_label' => $base_label,
            'link_label' => $link_label,
            'icon_label' => $icon_label
        ];
    }

    /**
     * Generate services grid accessibility attributes
     * 
     * @param array $services Services array
     * @param string $widget_id Widget ID
     * @return array Services grid accessibility data
     */
    public static function get_services_grid_attrs($services, $widget_id = '') {
        $services_count = count($services);
        $services_id = self::generate_id('services-grid-list', $widget_id);
        $services_label = sprintf(_n('Services grid with %d service', 'Services grid with %d services', $services_count, 'promen-elementor-widgets'), $services_count);
        
        return [
            'services_id' => $services_id,
            'services_attrs' => 'role="list" aria-label="' . esc_attr($services_label) . '" id="' . esc_attr($services_id) . '"',
            'services_count' => $services_count
        ];
    }

    /**
     * Generate image slider accessibility attributes
     * 
     * @param array $images Images array
     * @param int $index Image index
     * @param string $widget_id Widget ID
     * @return array Image accessibility data
     */
    public static function get_image_slider_attrs($images, $index = 0, $widget_id = '') {
        $image = $images[$index] ?? [];
        $image_title = !empty($image['title']) ? $image['title'] : '';
        $image_description = !empty($image['description']) ? $image['description'] : '';
        $image_alt = !empty($image['image']['alt']) ? $image['image']['alt'] : $image_title;
        
        // Generate unique IDs
        $image_item_id = self::generate_id('image-item-' . ($index + 1), $widget_id);
        $image_title_id = self::generate_id('image-title-' . ($index + 1), $widget_id);
        $image_description_id = self::generate_id('image-description-' . ($index + 1), $widget_id);
        
        // Generate aria-labels based on image title
        $base_label = $image_title;
        $image_label = $image_title;
        
        // Add context to labels
        if (!empty($image_title)) {
            $image_label = sprintf(__('Afbeelding: %s', 'promen-elementor-widgets'), $image_title);
        }
        
        // Add description to base label if available
        if (!empty($image_description)) {
            $base_label = sprintf(__('%s: %s', 'promen-elementor-widgets'), $image_title, $image_description);
        }
        
        return [
            'image_item_id' => $image_item_id,
            'image_title_id' => $image_title_id,
            'image_description_id' => $image_description_id,
            'image_item_attrs' => 'role="listitem" tabindex="0" aria-labelledby="' . esc_attr($image_title_id) . '"' . (!empty($image_description_id) ? ' aria-describedby="' . esc_attr($image_description_id) . '"' : ''),
            'image_attrs' => 'alt="' . esc_attr($image_alt) . '" aria-label="' . esc_attr($image_label) . '"',
            'image_title_attrs' => 'id="' . esc_attr($image_title_id) . '"',
            'image_description_attrs' => 'id="' . esc_attr($image_description_id) . '"',
            'base_label' => $base_label,
            'image_label' => $image_label
        ];
    }

    /**
     * Generate image slider container accessibility attributes
     * 
     * @param array $images Images array
     * @param string $widget_id Widget ID
     * @param bool $is_slider Whether it's a slider or grid
     * @return array Image slider accessibility data
     */
    public static function get_image_slider_container_attrs($images, $widget_id = '', $is_slider = false) {
        $images_count = count($images);
        $container_id = self::generate_id($is_slider ? 'image-slider-container' : 'image-grid-container', $widget_id);
        
        if ($is_slider) {
            $container_label = sprintf(_n('Afbeeldingen schuifregelaar met %d afbeelding', 'Afbeeldingen schuifregelaar met %d afbeeldingen', $images_count, 'promen-elementor-widgets'), $images_count);
            $container_attrs = 'role="region" aria-label="' . esc_attr($container_label) . '" aria-live="polite"';
        } else {
            $container_label = sprintf(_n('Afbeeldingen grid met %d afbeelding', 'Afbeeldingen grid met %d afbeeldingen', $images_count, 'promen-elementor-widgets'), $images_count);
            $container_attrs = 'role="list" aria-label="' . esc_attr($container_label) . '"';
        }
        
        return [
            'container_id' => $container_id,
            'container_attrs' => $container_attrs . ' id="' . esc_attr($container_id) . '"',
            'images_count' => $images_count
        ];
    }

    /**
     * Generate contact info blocks accessibility attributes
     * 
     * @param string $block_type Type of contact block ('address', 'phone', 'email')
     * @param array $data Block data
     * @param int $index Block index
     * @param string $widget_id Widget ID
     * @return array Contact block accessibility data
     */
    public static function get_contact_block_attrs($block_type, $data = [], $index = 0, $widget_id = '') {
        // Generate unique IDs
        $block_id = self::generate_id($block_type . '-block-' . ($index + 1), $widget_id);
        $heading_id = self::generate_id($block_type . '-heading-' . ($index + 1), $widget_id);
        $content_id = self::generate_id($block_type . '-content-' . ($index + 1), $widget_id);
        
        // Generate appropriate schema.org itemtype
        $schema_type = '';
        switch ($block_type) {
            case 'address':
                $schema_type = 'https://schema.org/PostalAddress';
                break;
            case 'phone':
            case 'email':
                $schema_type = 'https://schema.org/ContactPoint';
                break;
        }
        
        // Generate localized labels
        $block_labels = [
            'address' => __('Adresinformatie', 'promen-elementor-widgets'),
            'phone' => __('Telefoonnummer', 'promen-elementor-widgets'),
            'email' => __('E-mailadres', 'promen-elementor-widgets')
        ];
        
        $block_label = $block_labels[$block_type] ?? __('Contactinformatie', 'promen-elementor-widgets');
        
        // Generate link aria-labels
        $link_labels = [
            'phone' => __('Bel %s', 'promen-elementor-widgets'),
            'email' => __('Stuur een e-mail naar %s', 'promen-elementor-widgets')
        ];
        
        return [
            'block_id' => $block_id,
            'heading_id' => $heading_id,
            'content_id' => $content_id,
            'block_attrs' => 'id="' . esc_attr($block_id) . '" role="listitem" data-block-type="' . esc_attr($block_type) . '"',
            'article_attrs' => 'aria-labelledby="' . esc_attr($heading_id) . '" itemscope itemtype="' . esc_attr($schema_type) . '"',
            'heading_attrs' => 'id="' . esc_attr($heading_id) . '" class="contact-info-title"',
            'content_attrs' => 'id="' . esc_attr($content_id) . '" class="contact-info-content"',
            'block_label' => $block_label,
            'link_label_format' => $link_labels[$block_type] ?? '',
            'schema_type' => $schema_type
        ];
    }

    /**
     * Generate phone link with proper accessibility
     * 
     * @param string $phone_number Phone number to display
     * @param bool $clickable Whether to make it clickable
     * @param array $extra_attrs Extra attributes
     * @return string Phone link HTML
     */
    public static function get_accessible_phone_link($phone_number, $clickable = true, $extra_attrs = []) {
        if (!$clickable) {
            return '<span class="contact-info-text" itemprop="telephone">' . esc_html($phone_number) . '</span>';
        }
        
        // Clean phone number for tel: protocol
        $clean_number = preg_replace('/[^0-9+]/', '', $phone_number);
        
        // Generate aria-label
        $aria_label = sprintf(__('Bel %s', 'promen-elementor-widgets'), $phone_number);
        if (isset($extra_attrs['aria-label'])) {
            $aria_label = $extra_attrs['aria-label'];
            unset($extra_attrs['aria-label']);
        }
        
        // Build attributes string
        $attrs = 'href="tel:' . esc_attr($clean_number) . '" ';
        $attrs .= 'class="contact-info-link contact-info-link--phone" ';
        $attrs .= 'itemprop="telephone" ';
        $attrs .= 'aria-label="' . esc_attr($aria_label) . '" ';
        $attrs .= 'rel="nofollow"';
        
        foreach ($extra_attrs as $key => $value) {
            $attrs .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
        }
        
        return '<a ' . $attrs . '><span aria-hidden="true">' . esc_html($phone_number) . '</span><span class="screen-reader-text">' . esc_html(sprintf(__('Telefoonnummer: %s (klik om te bellen)', 'promen-elementor-widgets'), $phone_number)) . '</span></a>';
    }

    /**
     * Generate email link with proper accessibility
     * 
     * @param string $email_address Email address to display
     * @param bool $clickable Whether to make it clickable
     * @param array $extra_attrs Extra attributes
     * @return string Email link HTML
     */
    public static function get_accessible_email_link($email_address, $clickable = true, $extra_attrs = []) {
        if (!$clickable) {
            return '<span class="contact-info-text" itemprop="email">' . esc_html($email_address) . '</span>';
        }
        
        // Generate aria-label
        $aria_label = sprintf(__('Stuur een e-mail naar %s', 'promen-elementor-widgets'), $email_address);
        if (isset($extra_attrs['aria-label'])) {
            $aria_label = $extra_attrs['aria-label'];
            unset($extra_attrs['aria-label']);
        }
        
        // Build attributes string
        $attrs = 'href="mailto:' . esc_attr($email_address) . '" ';
        $attrs .= 'class="contact-info-link contact-info-link--email" ';
        $attrs .= 'itemprop="email" ';
        $attrs .= 'aria-label="' . esc_attr($aria_label) . '" ';
        $attrs .= 'rel="nofollow"';
        
        foreach ($extra_attrs as $key => $value) {
            $attrs .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
        }
        
        return '<a ' . $attrs . '><span aria-hidden="true">' . esc_html($email_address) . '</span><span class="screen-reader-text">' . esc_html(sprintf(__('E-mailadres: %s (klik om een e-mail te versturen)', 'promen-elementor-widgets'), $email_address)) . '</span></a>';
    }

    /**
     * Sanitize and validate phone number
     * 
     * @param string $phone Phone number
     * @return string Sanitized phone number
     */
    public static function sanitize_phone_number($phone) {
        // Remove all non-numeric characters except + at the start
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        // Ensure + is only at the start
        if (strpos($phone, '+') !== false) {
            $phone = '+' . str_replace('+', '', $phone);
        }
        
        return $phone;
    }

    /**
     * Validate email address with accessibility feedback
     * 
     * @param string $email Email address
     * @return bool True if valid
     */
    public static function validate_email_address($email) {
        return is_email($email);
    }

    /**
     * Generate keyboard navigation instructions for screen readers
     * 
     * @param string $component_type Type of component
     * @return string Instructions HTML
     */
    public static function get_keyboard_instructions($component_type = 'contact-blocks') {
        $instructions = [
            'contact-blocks' => __('Gebruik de pijltjestoetsen om te navigeren tussen contactinformatie blokken. Druk op Enter of Spatie om een link te activeren. Druk op Escape om de navigatie te annuleren.', 'promen-elementor-widgets'),
            'slider' => __('Gebruik de pijltjestoetsen Links en Rechts om te navigeren tussen slides. Druk op Spatie om de slideshow te pauzeren of af te spelen.', 'promen-elementor-widgets'),
            'menu' => __('Gebruik de pijltjestoetsen om te navigeren door het menu. Druk op Enter om een menu-item te selecteren. Druk op Escape om het menu te sluiten.', 'promen-elementor-widgets'),
            'grid' => __('Gebruik Tab om te navigeren tussen items. Druk op Enter om een item te selecteren.', 'promen-elementor-widgets')
        ];
        
        $instruction = $instructions[$component_type] ?? $instructions['grid'];
        
        return '<div class="screen-reader-text keyboard-instructions" role="region" aria-label="' . esc_attr__('Keyboard navigatie instructies', 'promen-elementor-widgets') . '">' . esc_html($instruction) . '</div>';
    }

    /**
     * Check if WCAG color contrast is sufficient
     * 
     * @param string $foreground Foreground color
     * @param string $background Background color
     * @param string $level 'AA' or 'AAA'
     * @param string $size 'normal' or 'large'
     * @return bool True if contrast is sufficient
     */
    public static function check_wcag_contrast($foreground, $background, $level = 'AA', $size = 'normal') {
        $ratio = self::get_contrast_ratio($foreground, $background);
        
        // WCAG 2.2 requirements
        $requirements = [
            'AA' => [
                'normal' => 4.5,
                'large' => 3.0
            ],
            'AAA' => [
                'normal' => 7.0,
                'large' => 4.5
            ]
        ];
        
        $required_ratio = $requirements[$level][$size] ?? 4.5;
        
        return $ratio >= $required_ratio;
    }

    /**
     * Inject skip link for Elementor widgets
     * 
     * @param \Elementor\Widget_Base $widget Widget instance
     * @return void
     */
    public function inject_widget_skip_link($widget) {
        // Only add skip links to Promen widgets
        $widget_name = $widget->get_name();
        if (strpos($widget_name, 'promen_') !== 0 && strpos($widget_name, 'promen-') !== 0) {
            // Check if it's one of our custom widget classes
            $widget_class = get_class($widget);
            $promen_widgets = [
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
            
            if (!in_array($widget_class, $promen_widgets)) {
                return;
            }
        }
        
        // Get widget ID and title
        $widget_id = $widget->get_id();
        $widget_title = $widget->get_title();
        
        // Render skip link
        self::render_widget_skip_link($widget, $widget_title);
    }

    /**
     * Add JavaScript to handle skip link targeting
     * Ensures widget containers are properly targeted by skip links
     */
    public function add_widget_skip_link_script() {
        ?>
        <script>
        (function() {
            'use strict';
            
            // Wait for DOM to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initSkipLinks);
            } else {
                initSkipLinks();
            }
            
            function initSkipLinks() {
                // Find all widget skip links
                const skipLinks = document.querySelectorAll('.widget-skip-link');
                
                skipLinks.forEach(function(skipLink) {
                    const widgetId = skipLink.getAttribute('data-widget-id');
                    if (!widgetId) return;
                    
                    // Elementor creates wrapper with ID: elementor-widget-{id}
                    const elementorWrapperId = 'elementor-widget-' + widgetId;
                    const elementorWrapper = document.getElementById(elementorWrapperId);
                    
                    if (elementorWrapper) {
                        // Ensure the wrapper has scroll-margin for proper scrolling
                        elementorWrapper.style.scrollMarginTop = '20px';
                        elementorWrapper.style.scrollMarginBottom = '20px';
                        
                        // Update skip link href if needed
                        const currentHref = skipLink.getAttribute('href');
                        if (currentHref !== '#' + elementorWrapperId) {
                            skipLink.setAttribute('href', '#' + elementorWrapperId);
                        }
                        
                        // Handle click to ensure smooth scroll
                        skipLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            const target = document.getElementById(elementorWrapperId);
                            if (target) {
                                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                // Focus the first focusable element in the widget
                                const focusable = target.querySelector('a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])');
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

// Initialize the accessibility utils
Promen_Accessibility_Utils::instance();