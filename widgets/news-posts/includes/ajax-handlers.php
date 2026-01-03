<?php
/**
 * AJAX Handlers for News Posts Widget
 * 
 * Handles AJAX requests for dynamic loading of taxonomies, terms, and posts.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_News_Posts_Ajax_Handlers {

    public function __construct() {
        add_action('wp_ajax_promen_get_taxonomies_for_post_type', [$this, 'get_taxonomies_for_post_type']);
        add_action('wp_ajax_promen_get_terms_for_taxonomy', [$this, 'get_terms_for_taxonomy']);
        add_action('wp_ajax_promen_get_posts_for_selection', [$this, 'get_posts_for_selection']);
    }

    /**
     * Get taxonomies for a specific post type
     */
    public function get_taxonomies_for_post_type() {
        // Check if required POST data exists
        if (!isset($_POST['nonce']) || !isset($_POST['post_type'])) {
            wp_send_json_error('Missing required parameters');
        }

        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'promen_admin_ajax')) {
            wp_send_json_error('Security check failed');
        }

        // Check user capabilities
        if (!current_user_can('edit_posts')) {
            wp_send_json_error('Insufficient permissions');
        }

        $post_type = sanitize_text_field($_POST['post_type']);
        
        if (empty($post_type)) {
            wp_send_json_error('Post type is required');
        }

        $taxonomies = get_object_taxonomies($post_type, 'objects');
        $options = ['' => esc_html__('Select Taxonomy', 'promen-elementor-widgets')];

        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->public && $taxonomy->show_ui) {
                $options[$taxonomy->name] = $taxonomy->label;
            }
        }

        wp_send_json_success($options);
    }

    /**
     * Get terms for a specific taxonomy
     */
    public function get_terms_for_taxonomy() {
        // Check if required POST data exists
        if (!isset($_POST['nonce']) || !isset($_POST['taxonomy'])) {
            wp_send_json_error('Missing required parameters');
        }

        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'promen_admin_ajax')) {
            wp_send_json_error('Security check failed');
        }

        // Check user capabilities
        if (!current_user_can('edit_posts')) {
            wp_send_json_error('Insufficient permissions');
        }

        $taxonomy = sanitize_text_field($_POST['taxonomy']);
        
        if (empty($taxonomy)) {
            wp_send_json_error('Taxonomy is required');
        }

        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC',
        ]);

        $options = [];
        if (!is_wp_error($terms) && !empty($terms)) {
            foreach ($terms as $term) {
                $options[$term->term_id] = $term->name;
            }
        }

        wp_send_json_success($options);
    }

    /**
     * Get posts for manual selection
     */
    public function get_posts_for_selection() {
        // Check if required POST data exists
        if (!isset($_POST['nonce']) || !isset($_POST['post_type'])) {
            wp_send_json_error('Missing required parameters');
        }

        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'promen_admin_ajax')) {
            wp_send_json_error('Security check failed');
        }

        // Check user capabilities
        if (!current_user_can('edit_posts')) {
            wp_send_json_error('Insufficient permissions');
        }

        $post_type = sanitize_text_field($_POST['post_type']);
        $search = isset($_POST['search']) ? sanitize_text_field($_POST['search']) : '';
        
        if (empty($post_type)) {
            wp_send_json_error('Post type is required');
        }

        $args = [
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => 50, // Limit for performance
            'orderby' => 'title',
            'order' => 'ASC',
        ];

        if (!empty($search)) {
            $args['s'] = $search;
        }

        $posts = get_posts($args);
        $options = [];

        foreach ($posts as $post) {
            $options[$post->ID] = $post->post_title;
        }

        wp_send_json_success($options);
    }

    /**
     * Search posts with AJAX for Select2 autocomplete
     */
    public function search_posts_for_selection() {
        // Check if required POST data exists
        if (!isset($_POST['nonce']) || !isset($_POST['post_type'])) {
            wp_send_json_error('Missing required parameters');
        }

        // Verify nonce
        if (!wp_verify_nonce($_POST['nonce'], 'promen_admin_ajax')) {
            wp_send_json_error('Security check failed');
        }

        // Check user capabilities
        if (!current_user_can('edit_posts')) {
            wp_send_json_error('Insufficient permissions');
        }

        $post_type = sanitize_text_field($_POST['post_type']);
        $search = isset($_POST['q']) ? sanitize_text_field($_POST['q']) : '';
        
        if (empty($post_type)) {
            wp_send_json_error('Post type is required');
        }

        $args = [
            'post_type' => $post_type,
            'post_status' => 'publish',
            'posts_per_page' => 20,
            'orderby' => 'title',
            'order' => 'ASC',
            's' => $search,
        ];

        $posts = get_posts($args);
        $results = [];

        foreach ($posts as $post) {
            $results[] = [
                'id' => $post->ID,
                'text' => $post->post_title,
            ];
        }

        wp_send_json([
            'results' => $results,
            'pagination' => ['more' => false]
        ]);
    }
}

// Initialize the AJAX handlers
new Promen_News_Posts_Ajax_Handlers(); 