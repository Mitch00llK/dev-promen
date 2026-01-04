<?php
/**
 * Widget Admin Class
 * 
 * Admin page for managing Elementor widgets - enable/disable and view usage.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Promen_Widget_Admin {
    
    /**
     * Option key for disabled widgets
     */
    const OPTION_KEY = 'promen_disabled_widgets';
    
    /**
     * Instance
     */
    private static $_instance = null;
    
    /**
     * Usage scanner instance
     */
    private $scanner;
    
    /**
     * Widget manager reference
     */
    private $widget_manager;
    
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
        // Initialize scanner
        require_once dirname(__FILE__) . '/class-widget-usage-scanner.php';
        $this->scanner = Promen_Widget_Usage_Scanner::instance();
        
        // Add admin menu
        add_action('admin_menu', [$this, 'add_admin_menu']);
        
        // Register AJAX handlers
        add_action('wp_ajax_promen_toggle_widget', [$this, 'ajax_toggle_widget']);
        add_action('wp_ajax_promen_get_widget_usage', [$this, 'ajax_get_widget_usage']);
        add_action('wp_ajax_promen_refresh_usage_cache', [$this, 'ajax_refresh_cache']);
        
        // Enqueue admin assets
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
    }
    
    /**
     * Add admin menu page
     */
    public function add_admin_menu() {
        add_submenu_page(
            'elementor', // Parent slug (Elementor menu)
            __('Widget Manager', 'promen-elementor-widgets'),
            __('Widget Manager', 'promen-elementor-widgets'),
            'manage_options',
            'promen-widget-manager',
            [$this, 'render_admin_page']
        );
    }
    
    /**
     * Enqueue admin assets
     */
    public function enqueue_admin_assets($hook) {
        // Only load on our admin page
        if ($hook !== 'elementor_page_promen-widget-manager') {
            return;
        }
        
        wp_enqueue_style(
            'promen-widget-admin',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/css/admin/widget-admin.css',
            [],
            PROMEN_ELEMENTOR_WIDGETS_VERSION
        );
        
        wp_enqueue_script(
            'promen-widget-admin',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'assets/js/admin/widget-admin.js',
            ['jquery'],
            PROMEN_ELEMENTOR_WIDGETS_VERSION,
            true
        );
        
        wp_localize_script('promen-widget-admin', 'promenWidgetAdmin', [
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('promen_widget_admin'),
            'strings' => [
                'confirmDisable' => __('Are you sure you want to disable this widget? It will be removed from the Elementor panel.', 'promen-elementor-widgets'),
                'saving' => __('Saving...', 'promen-elementor-widgets'),
                'saved' => __('Saved!', 'promen-elementor-widgets'),
                'error' => __('Error saving. Please try again.', 'promen-elementor-widgets'),
                'loading' => __('Loading...', 'promen-elementor-widgets'),
                'noUsage' => __('This widget is not used on any pages.', 'promen-elementor-widgets'),
                'refreshing' => __('Refreshing...', 'promen-elementor-widgets')
            ]
        ]);
    }
    
    /**
     * Render admin page
     */
    public function render_admin_page() {
        // Get all widgets from widget manager
        $all_widgets = $this->get_all_widgets();
        $disabled_widgets = $this->get_disabled_widgets();
        $usage_data = $this->scanner->get_all_usage();
        $cache_status = $this->scanner->get_cache_status();
        
        ?>
        <div class="wrap promen-widget-manager">
            <h1 class="wp-heading-inline">
                <?php esc_html_e('Promen Widget Manager', 'promen-elementor-widgets'); ?>
            </h1>
            
            <button type="button" class="page-title-action" id="promen-refresh-cache">
                <span class="dashicons dashicons-update"></span>
                <?php esc_html_e('Refresh Usage Data', 'promen-elementor-widgets'); ?>
            </button>
            
            <?php if ($cache_status['cached']) : ?>
            <p class="description">
                <?php printf(
                    esc_html__('Usage data cached. Expires: %s', 'promen-elementor-widgets'),
                    esc_html($cache_status['expires'])
                ); ?>
            </p>
            <?php endif; ?>
            
            <div class="promen-widget-grid">
                <?php foreach ($all_widgets as $widget) : 
                    $widget_name = $widget['name'];
                    $is_disabled = in_array($widget_name, $disabled_widgets);
                    $usage_count = isset($usage_data[$widget_name]['count']) ? $usage_data[$widget_name]['count'] : 0;
                ?>
                <div class="promen-widget-card <?php echo $is_disabled ? 'is-disabled' : ''; ?>" data-widget="<?php echo esc_attr($widget_name); ?>">
                    <div class="promen-widget-card__header">
                        <h3 class="promen-widget-card__title">
                            <?php echo esc_html($widget['title']); ?>
                        </h3>
                        <span class="promen-widget-card__icon">
                            <i class="<?php echo esc_attr($widget['icon']); ?>"></i>
                        </span>
                    </div>
                    
                    <div class="promen-widget-card__body">
                        <div class="promen-widget-card__usage">
                            <span class="usage-count"><?php echo esc_html($usage_count); ?></span>
                            <span class="usage-label"><?php esc_html_e('times used', 'promen-elementor-widgets'); ?></span>
                        </div>
                        
                        <div class="promen-widget-card__toggle">
                            <label class="promen-toggle">
                                <input type="checkbox" 
                                       class="promen-toggle__input" 
                                       <?php checked(!$is_disabled); ?>
                                       data-widget="<?php echo esc_attr($widget_name); ?>">
                                <span class="promen-toggle__slider"></span>
                            </label>
                            <span class="promen-toggle__label">
                                <?php echo $is_disabled ? esc_html__('Disabled', 'promen-elementor-widgets') : esc_html__('Enabled', 'promen-elementor-widgets'); ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="promen-widget-card__footer">
                        <button type="button" class="button promen-view-usage" data-widget="<?php echo esc_attr($widget_name); ?>">
                            <?php esc_html_e('View Usage', 'promen-elementor-widgets'); ?>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Usage Modal -->
        <div id="promen-usage-modal" class="promen-modal" style="display: none;">
            <div class="promen-modal__overlay"></div>
            <div class="promen-modal__content">
                <div class="promen-modal__header">
                    <h2 class="promen-modal__title"><?php esc_html_e('Widget Usage', 'promen-elementor-widgets'); ?></h2>
                    <button type="button" class="promen-modal__close">&times;</button>
                </div>
                <div class="promen-modal__body">
                    <!-- Content loaded via AJAX -->
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Get all registered widgets with metadata
     */
    public function get_all_widgets() {
        // Widget definitions matching class-widget-manager.php
        return [
            ['name' => 'promen_feature_blocks', 'title' => 'Feature Blocks', 'icon' => 'eicon-posts-grid'],
            ['name' => 'promen_services_carousel', 'title' => 'Services Carousel', 'icon' => 'eicon-slider-push'],
            ['name' => 'promen_image_text_block', 'title' => 'Image Text Block', 'icon' => 'eicon-image-box'],
            ['name' => 'promen_news_posts', 'title' => 'News Posts', 'icon' => 'eicon-posts-ticker'],
            ['name' => 'promen_stats_counter', 'title' => 'Stats Counter', 'icon' => 'eicon-counter'],
            ['name' => 'contact_info_card', 'title' => 'Contact Info Card', 'icon' => 'eicon-info-box'],
            ['name' => 'promen_team_members_carousel', 'title' => 'Team Members Carousel', 'icon' => 'eicon-person'],
            ['name' => 'promen_certification_logos', 'title' => 'Certification Logos', 'icon' => 'eicon-logo'],
            ['name' => 'promen_services_grid', 'title' => 'Services Grid', 'icon' => 'eicon-gallery-grid'],
            ['name' => 'promen_worker_testimonial', 'title' => 'Worker Testimonial', 'icon' => 'eicon-testimonial'],
            ['name' => 'promen_benefits', 'title' => 'Benefits Widget', 'icon' => 'eicon-bullet-list'],
            ['name' => 'promen_hero_slider', 'title' => 'Hero Slider', 'icon' => 'eicon-slider-full-screen'],
            ['name' => 'promen_text_content_block', 'title' => 'Text Content Block', 'icon' => 'eicon-text'],
            ['name' => 'promen_image_slider', 'title' => 'Image Slider', 'icon' => 'eicon-slider-album'],
            ['name' => 'promen_related_services', 'title' => 'Related Services', 'icon' => 'eicon-post-list'],
            ['name' => 'promen_text_column_repeater', 'title' => 'Text Column Repeater', 'icon' => 'eicon-columns'],
            ['name' => 'promen_solicitation_timeline', 'title' => 'Solicitation Timeline', 'icon' => 'eicon-time-line'],
            ['name' => 'promen_business_catering', 'title' => 'Business Catering', 'icon' => 'eicon-products'],
            ['name' => 'promen_testimonial_card', 'title' => 'Testimonial Card', 'icon' => 'eicon-testimonial-carousel'],
            ['name' => 'image_text_slider', 'title' => 'Image Text Slider', 'icon' => 'eicon-slider-3d'],
            ['name' => 'promen_checklist_comparison', 'title' => 'Checklist Comparison', 'icon' => 'eicon-check-circle'],
            ['name' => 'promen_contact_info_blocks', 'title' => 'Contact Info Blocks', 'icon' => 'eicon-info-circle'],
            ['name' => 'promen_locations_display', 'title' => 'Locations Display', 'icon' => 'eicon-map-pin'],
            ['name' => 'document_info_list', 'title' => 'Document Info List', 'icon' => 'eicon-document-file'],
            ['name' => 'promen_hamburger_menu', 'title' => 'Hamburger Menu', 'icon' => 'eicon-menu-bar']
        ];
    }
    
    /**
     * Get disabled widgets
     * 
     * @return array
     */
    public static function get_disabled_widgets() {
        return get_option(self::OPTION_KEY, []);
    }
    
    /**
     * Set disabled widgets
     * 
     * @param array $widgets
     * @return bool
     */
    public static function set_disabled_widgets($widgets) {
        return update_option(self::OPTION_KEY, $widgets);
    }
    
    /**
     * Check if a widget is disabled
     * 
     * @param string $widget_name
     * @return bool
     */
    public static function is_widget_disabled($widget_name) {
        $disabled = self::get_disabled_widgets();
        return in_array($widget_name, $disabled);
    }
    
    /**
     * AJAX handler: Toggle widget enabled/disabled state
     */
    public function ajax_toggle_widget() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'promen_widget_admin')) {
            wp_send_json_error(['message' => 'Invalid nonce']);
        }
        
        // Verify permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Insufficient permissions']);
        }
        
        $widget_name = sanitize_text_field($_POST['widget']);
        $enabled = filter_var($_POST['enabled'], FILTER_VALIDATE_BOOLEAN);
        
        $disabled_widgets = self::get_disabled_widgets();
        
        if ($enabled) {
            // Remove from disabled list
            $disabled_widgets = array_diff($disabled_widgets, [$widget_name]);
        } else {
            // Add to disabled list
            if (!in_array($widget_name, $disabled_widgets)) {
                $disabled_widgets[] = $widget_name;
            }
        }
        
        self::set_disabled_widgets(array_values($disabled_widgets));
        
        wp_send_json_success([
            'message' => $enabled ? 'Widget enabled' : 'Widget disabled',
            'widget' => $widget_name,
            'enabled' => $enabled
        ]);
    }
    
    /**
     * AJAX handler: Get widget usage locations
     */
    public function ajax_get_widget_usage() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'promen_widget_admin')) {
            wp_send_json_error(['message' => 'Invalid nonce']);
        }
        
        // Verify permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Insufficient permissions']);
        }
        
        $widget_name = sanitize_text_field($_POST['widget']);
        $locations = $this->scanner->get_usage_locations($widget_name);
        
        // Build HTML for modal
        ob_start();
        if (empty($locations)) {
            echo '<p class="promen-no-usage">' . esc_html__('This widget is not used on any pages.', 'promen-elementor-widgets') . '</p>';
        } else {
            echo '<table class="widefat striped">';
            echo '<thead><tr>';
            echo '<th>' . esc_html__('Page Title', 'promen-elementor-widgets') . '</th>';
            echo '<th>' . esc_html__('Type', 'promen-elementor-widgets') . '</th>';
            echo '<th>' . esc_html__('Actions', 'promen-elementor-widgets') . '</th>';
            echo '</tr></thead><tbody>';
            
            foreach ($locations as $location) {
                echo '<tr>';
                echo '<td>' . esc_html($location['title']) . '</td>';
                echo '<td>' . esc_html($location['post_type']) . '</td>';
                echo '<td>';
                echo '<a href="' . esc_url($location['edit_url']) . '" target="_blank" class="button button-small">' . esc_html__('Edit', 'promen-elementor-widgets') . '</a> ';
                echo '<a href="' . esc_url($location['view_url']) . '" target="_blank" class="button button-small">' . esc_html__('View', 'promen-elementor-widgets') . '</a>';
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</tbody></table>';
        }
        $html = ob_get_clean();
        
        wp_send_json_success([
            'html' => $html,
            'count' => count($locations)
        ]);
    }
    
    /**
     * AJAX handler: Refresh usage cache
     */
    public function ajax_refresh_cache() {
        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'promen_widget_admin')) {
            wp_send_json_error(['message' => 'Invalid nonce']);
        }
        
        // Verify permissions
        if (!current_user_can('manage_options')) {
            wp_send_json_error(['message' => 'Insufficient permissions']);
        }
        
        // Force refresh cache
        $this->scanner->clear_cache();
        $usage_data = $this->scanner->get_all_usage(true);
        
        // Build usage counts for response
        $counts = [];
        foreach ($usage_data as $widget_name => $data) {
            $counts[$widget_name] = $data['count'];
        }
        
        wp_send_json_success([
            'message' => 'Cache refreshed',
            'counts' => $counts,
            'cache_status' => $this->scanner->get_cache_status()
        ]);
    }
}
