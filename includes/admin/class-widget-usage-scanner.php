<?php
/**
 * Widget Usage Scanner Class
 * 
 * Scans Elementor pages/posts for widget usage and provides usage statistics.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Promen_Widget_Usage_Scanner {
    
    /**
     * Cache transient key
     */
    const CACHE_KEY = 'promen_widget_usage_cache';
    
    /**
     * Cache expiration (24 hours)
     */
    const CACHE_EXPIRATION = DAY_IN_SECONDS;
    
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
     * Get all widget usage data
     * 
     * @param bool $force_refresh Force a cache refresh
     * @return array Widget usage data
     */
    public function get_all_usage($force_refresh = false) {
        // Check cache first
        if (!$force_refresh) {
            $cached = get_transient(self::CACHE_KEY);
            if ($cached !== false) {
                return $cached;
            }
        }
        
        // Scan all Elementor content
        $usage_data = $this->scan_all_content();
        
        // Cache the results
        set_transient(self::CACHE_KEY, $usage_data, self::CACHE_EXPIRATION);
        
        return $usage_data;
    }
    
    /**
     * Get usage count for a specific widget
     * 
     * @param string $widget_name Widget name (e.g., 'hero_slider')
     * @return int Usage count
     */
    public function get_usage_count($widget_name) {
        $usage = $this->get_all_usage();
        return isset($usage[$widget_name]['count']) ? $usage[$widget_name]['count'] : 0;
    }
    
    /**
     * Get locations where a widget is used
     * 
     * @param string $widget_name Widget name
     * @return array Array of locations with post_id, title, edit_url
     */
    public function get_usage_locations($widget_name) {
        $usage = $this->get_all_usage();
        return isset($usage[$widget_name]['locations']) ? $usage[$widget_name]['locations'] : [];
    }
    
    /**
     * Scan all Elementor content for widget usage
     * 
     * @return array Usage data organized by widget name
     */
    private function scan_all_content() {
        global $wpdb;
        
        $usage_data = [];
        
        // Get all posts with Elementor data
        $posts = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT p.ID, p.post_title, p.post_type, pm.meta_value 
                 FROM {$wpdb->posts} p
                 INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
                 WHERE pm.meta_key = %s
                 AND p.post_status IN ('publish', 'draft', 'private')
                 AND pm.meta_value != ''",
                '_elementor_data'
            )
        );
        
        foreach ($posts as $post) {
            $elementor_data = json_decode($post->meta_value, true);
            
            if (!is_array($elementor_data)) {
                continue;
            }
            
            // Find all widgets in this post
            $widgets_in_post = $this->find_widgets_recursive($elementor_data);
            
            foreach ($widgets_in_post as $widget_name) {
                if (!isset($usage_data[$widget_name])) {
                    $usage_data[$widget_name] = [
                        'count' => 0,
                        'locations' => []
                    ];
                }
                
                $usage_data[$widget_name]['count']++;
                $usage_data[$widget_name]['locations'][] = [
                    'post_id' => $post->ID,
                    'title' => $post->post_title,
                    'post_type' => $post->post_type,
                    'edit_url' => admin_url('post.php?post=' . $post->ID . '&action=elementor'),
                    'view_url' => get_permalink($post->ID)
                ];
            }
        }
        
        return $usage_data;
    }
    
    /**
     * Recursively find all widget names in Elementor data
     * 
     * @param array $elements Elementor elements array
     * @return array Unique widget names found
     */
    private function find_widgets_recursive($elements) {
        $widgets = [];
        
        foreach ($elements as $element) {
            // Check if this is a widget
            if (isset($element['elType']) && $element['elType'] === 'widget') {
                if (isset($element['widgetType'])) {
                    $widgets[] = $element['widgetType'];
                }
            }
            
            // Recursively check nested elements
            if (isset($element['elements']) && is_array($element['elements'])) {
                $nested_widgets = $this->find_widgets_recursive($element['elements']);
                $widgets = array_merge($widgets, $nested_widgets);
            }
        }
        
        return array_unique($widgets);
    }
    
    /**
     * Clear the usage cache
     */
    public function clear_cache() {
        delete_transient(self::CACHE_KEY);
    }
    
    /**
     * Get cache status
     * 
     * @return array Cache info
     */
    public function get_cache_status() {
        $cached = get_transient(self::CACHE_KEY);
        $timeout = get_option('_transient_timeout_' . self::CACHE_KEY);
        
        return [
            'cached' => $cached !== false,
            'expires' => $timeout ? date('Y-m-d H:i:s', $timeout) : null,
            'widget_count' => $cached !== false ? count($cached) : 0
        ];
    }
}
