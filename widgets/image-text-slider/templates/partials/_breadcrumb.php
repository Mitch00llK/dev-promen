<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Prepare breadcrumb data for later use in slides
$breadcrumb_html = '';
if ($settings['show_breadcrumb'] === 'yes') {
    $breadcrumb_position_class = $settings['breadcrumb_position'] === 'overlay' ? 'overlay' : '';
    $separator = !empty($settings['breadcrumb_separator']) ? $settings['breadcrumb_separator'] : '›';
    
    // Get the breadcrumb items using WordPress functions
    $breadcrumb_items = [];
    
    // Add home page
    $breadcrumb_items[] = [
        'title' => esc_html__('Home', 'promen-elementor-widgets'),
        'url' => esc_url(home_url('/')),
    ];
    
    // Get current page info
    $post_id = get_the_ID();
    $post_type = get_post_type();
    
    if (is_page() && !is_front_page()) {
        // Get all parent pages
        $parents = get_post_ancestors($post_id);
        
        // Reverse the array to get the correct order
        $parents = array_reverse($parents);
        
        // Add all parent pages to breadcrumb
        foreach ($parents as $parent_id) {
            $breadcrumb_items[] = [
                'title' => get_the_title($parent_id),
                'url' => get_permalink($parent_id),
            ];
        }
        
        // Add current page
        $breadcrumb_items[] = [
            'title' => get_the_title(),
            'url' => '',
        ];
    } elseif (is_singular() && !is_front_page()) {
        // For custom post types, show the post type archive link
        if ($post_type !== 'post') {
            $post_type_obj = get_post_type_object($post_type);
            if ($post_type_obj && $post_type_obj->has_archive) {
                $breadcrumb_items[] = [
                    'title' => $post_type_obj->labels->name,
                    'url' => get_post_type_archive_link($post_type),
                ];
            }
        } else {
            // For regular posts, show the blog page
            $blog_page_id = get_option('page_for_posts');
            if ($blog_page_id) {
                $breadcrumb_items[] = [
                    'title' => get_the_title($blog_page_id),
                    'url' => get_permalink($blog_page_id),
                ];
            }
        }
        
        // Add current page
        $breadcrumb_items[] = [
            'title' => get_the_title(),
            'url' => '',
        ];
    } elseif (is_archive()) {
        // Archive page
        if (is_category() || is_tag() || is_tax()) {
            $term = get_queried_object();
            $breadcrumb_items[] = [
                'title' => $term->name,
                'url' => '',
            ];
        } elseif (is_post_type_archive()) {
            $post_type_obj = get_post_type_object(get_query_var('post_type'));
            $breadcrumb_items[] = [
                'title' => $post_type_obj->labels->name,
                'url' => '',
            ];
        } elseif (is_author()) {
            $breadcrumb_items[] = [
                'title' => get_the_author(),
                'url' => '',
            ];
        } elseif (is_date()) {
            if (is_day()) {
                $breadcrumb_items[] = [
                    'title' => get_the_date(),
                    'url' => '',
                ];
            } elseif (is_month()) {
                $breadcrumb_items[] = [
                    'title' => get_the_date('F Y'),
                    'url' => '',
                ];
            } elseif (is_year()) {
                $breadcrumb_items[] = [
                    'title' => get_the_date('Y'),
                    'url' => '',
                ];
            }
        }
    } elseif (is_search()) {
        // Search results page
        $breadcrumb_items[] = [
            'title' => sprintf(esc_html__('Search results for: %s', 'promen-elementor-widgets'), get_search_query()),
            'url' => '',
        ];
    } elseif (is_404()) {
        // 404 page
        $breadcrumb_items[] = [
            'title' => esc_html__('404 Not Found', 'promen-elementor-widgets'),
            'url' => '',
        ];
    }
    
    // Create the breadcrumb HTML
    ob_start();
    ?>
    <nav class="image-text-slider-breadcrumb <?php echo esc_attr($breadcrumb_position_class); ?>" aria-label="<?php echo esc_attr__('Breadcrumb', 'promen-elementor-widgets'); ?>">
        <?php foreach ($breadcrumb_items as $index => $item) : ?>
            <div class="breadcrumb-item">
                <?php if (!empty($item['url'])) : ?>
                    <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['title']); ?></a>
                <?php else : ?>
                    <span class="current-item"><?php echo esc_html($item['title']); ?></span>
                <?php endif; ?>
                
                <?php if ($index < count($breadcrumb_items) - 1) : ?>
                    <span class="separator"><?php echo esc_html($separator); ?></span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </nav>
    <?php
    $breadcrumb_html = ob_get_clean();
}
?> 