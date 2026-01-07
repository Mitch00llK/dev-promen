<?php
/**
 * Promen News Posts Widget
 * 
 * A widget that displays posts from the "post", "succesvolle-verhalen", or "vacatures" post types with featured images, titles, excerpts, and links.
 * Includes SwiperJS slider functionality for mobile viewports.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_News_Posts_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_news_posts';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Content Posts & Vacatures Grid', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-posts-grid';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return ['general'];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return ['news', 'posts', 'blog', 'articles', 'grid', 'succesvolle verhalen', 'content', 'slider', 'vacatures'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['promen-news-posts-widget', 'promen-news-posts-accessibility'];
    }

    /**
     * Get widget script dependencies.
     */

    public function get_script_depends() {
        // Register filter script if not already registered
        if (!wp_script_is('promen-news-posts-filter', 'registered')) {
            wp_register_script(
                'promen-news-posts-filter',
                plugin_dir_url( __FILE__ ) . 'assets/js/modules/news-posts-filter.js',
                ['jquery'],
                '1.0.0',
                true
            );
        }
        
        return ['promen-news-posts-filter', 'promen-news-posts-accessibility'];
    }

    /**
     * Get taxonomies for the currently selected post type
     */
    public function get_taxonomies_for_post_type($post_type = null) {
        if ($post_type === null) {
            // Safely get settings, default to 'post' if not available yet
            try {
                $settings = $this->get_settings_for_display();
                $post_type = isset($settings['post_type']) ? $settings['post_type'] : 'post';
            } catch (Exception $e) {
                $post_type = 'post'; // Default to 'post' if settings aren't available
            }
        }

        $taxonomies = get_object_taxonomies($post_type, 'objects');
        $options = ['' => esc_html__('Select Taxonomy', 'promen-elementor-widgets')];

        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->public && $taxonomy->show_ui) {
                $options[$taxonomy->name] = $taxonomy->label;
            }
        }

        // Add special taxonomies that might not be detected by get_object_taxonomies
        $this->add_special_taxonomies($post_type, $options);

        return $options;
    }

    /**
     * Add special taxonomies that might not be detected by get_object_taxonomies
     */
    public function add_special_taxonomies($post_type, &$options) {
        $special_taxonomies = [];

        // Define known taxonomy mappings
        switch ($post_type) {
            case 'succesvolle-verhalen':
                $special_taxonomies = [
                    'verhalen-categorie' => 'Verhalen Categorieën',
                    'verhalen_categorie' => 'Verhalen Categorieën', // Alternative naming
                    'story-category' => 'Story Categories',
                    'story_category' => 'Story Categories',
                ];
                break;
            case 'vacatures':
                $special_taxonomies = [
                    'vacature-categorie' => 'Vacature Categorieën',
                    'vacature_categorie' => 'Vacature Categorieën',
                    'job-category' => 'Job Categories',
                    'job_category' => 'Job Categories',
                ];
                break;
        }

        // Check each potential taxonomy
        foreach ($special_taxonomies as $taxonomy_name => $default_label) {
            if (!isset($options[$taxonomy_name]) && taxonomy_exists($taxonomy_name)) {
                $taxonomy_obj = get_taxonomy($taxonomy_name);
                
                // Check if this taxonomy is actually associated with the post type
                if (in_array($post_type, $taxonomy_obj->object_type)) {
                    $options[$taxonomy_name] = $taxonomy_obj->label ?: $default_label;
                }
            }
        }
    }

    /**
     * Get the primary taxonomy for filtering for a specific post type
     */
    public function get_primary_taxonomy_for_post_type($post_type) {
        // Define primary taxonomy mappings for each post type
        $primary_taxonomies = [
            'succesvolle-verhalen' => ['verhalen-categorie', 'verhalen_categorie', 'story-category', 'story_category'],
            'vacatures' => ['vacature-categorie', 'vacature_categorie', 'vacature-categorieen', 'job-category', 'job_category'],
            'post' => ['category'], // Standard WordPress category
        ];

        if (!isset($primary_taxonomies[$post_type])) {
            return null;
        }

        // Check each potential taxonomy in order of preference
        foreach ($primary_taxonomies[$post_type] as $taxonomy_name) {
            if (taxonomy_exists($taxonomy_name)) {
                $taxonomy_obj = get_taxonomy($taxonomy_name);
                
                // Verify the taxonomy is associated with the post type
                if (in_array($post_type, $taxonomy_obj->object_type)) {
                    return $taxonomy_name;
                }
            }
        }

        // Fallback: get the first available taxonomy for the post type
        $taxonomies = get_object_taxonomies($post_type, 'objects');
        foreach ($taxonomies as $taxonomy) {
            if ($taxonomy->public && $taxonomy->show_ui) {
                return $taxonomy->name;
            }
        }

        return null;
    }

    /**
     * Get all available taxonomies for all supported post types (for control options)
     */
    public function get_available_taxonomies() {
        $options = ['' => esc_html__('Select Taxonomy', 'promen-elementor-widgets')];
        $post_types = ['post', 'succesvolle-verhalen', 'vacatures'];
        
        foreach ($post_types as $post_type) {
            $taxonomies = $this->get_taxonomies_for_post_type($post_type);
            
            // Merge with existing options, excluding the empty option
            foreach ($taxonomies as $key => $value) {
                if ($key !== '' && !isset($options[$key])) {
                    $options[$key] = $value;
                }
            }
        }
        
        return $options;
    }

    /**
     * Get all available terms for common taxonomies (for control options)
     */
    public function get_available_terms() {
        $options = [];
        $common_taxonomies = ['category', 'verhalen-categorie', 'vacature-categorie', 'vacature-categorieen'];
        
        foreach ($common_taxonomies as $taxonomy) {
            if (taxonomy_exists($taxonomy)) {
                $terms = $this->get_terms_for_taxonomy($taxonomy);
                
                // Add taxonomy prefix to avoid conflicts
                foreach ($terms as $term_id => $term_name) {
                    $options[$term_id] = $term_name;
                }
            }
        }
        
        return $options;
    }

    /**
     * Get available posts for all supported post types (for control options)
     */
    public function get_available_posts() {
        $options = [];
        $post_types = ['post', 'succesvolle-verhalen', 'vacatures'];
        
        foreach ($post_types as $post_type) {
            $posts = $this->get_posts_for_selection($post_type);
            
            // Add posts with post type prefix to avoid conflicts
            foreach ($posts as $post_id => $post_title) {
                $options[$post_id] = "[{$post_type}] {$post_title}";
            }
        }
        
        return $options;
    }

    /**
     * Get terms for the selected taxonomy
     */
    public function get_terms_for_taxonomy($taxonomy = '') {
        if (empty($taxonomy)) {
            return [];
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

        return $options;
    }

    /**
     * Get posts for manual selection
     */
    public function get_posts_for_selection($post_type = 'post', $search = '') {
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

        return $options;
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Include and register Content Controls
        require_once(__DIR__ . '/includes/controls/content-controls.php');
        Promen_News_Posts_Content_Controls::register_controls($this);

        // Include and register Style Controls
        require_once(__DIR__ . '/includes/controls/style-controls.php');
        Promen_News_Posts_Style_Controls::register_controls($this);
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        // Include render file
        require_once(__DIR__ . '/includes/render/render-widget.php');
        
        Promen_News_Posts_Render::render($this);
    }
} 