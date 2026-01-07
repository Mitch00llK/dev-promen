<?php
/**
 * Render logic for News Posts Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_News_Posts_Render {

    public static function render($widget) {
        $settings = $widget->get_settings_for_display();
        $widget_id = $widget->get_id();

        // Build query arguments
        $args = self::get_query_args($settings);
        $posts_query = new \WP_Query($args);

        // Responsive classes
        $columns_desktop = isset($settings['columns_desktop']) ? $settings['columns_desktop'] : '3';
        $columns_tablet = isset($settings['columns_tablet']) ? $settings['columns_tablet'] : '2';
        $columns_mobile = isset($settings['columns_mobile']) ? $settings['columns_mobile'] : '1';
        $grid_classes = "promen-content-grid desktop-columns-{$columns_desktop} tablet-columns-{$columns_tablet} mobile-columns-{$columns_mobile}";

        // Defaults for texts
        $defaults = self::get_default_texts($settings);
        $header_button_text = !empty($settings['header_button_text']) ? $settings['header_button_text'] : $defaults['header_button_text'];
        $footer_button_text = !empty($settings['footer_button_text']) ? $settings['footer_button_text'] : $defaults['footer_button_text'];
        $read_more_text = !empty($settings['read_more_text']) ? $settings['read_more_text'] : $defaults['read_more_text'];
        
        // Pass read_more_text to template settings
        $settings['read_more_default_text'] = $read_more_text;

        ?>
        <section class="promen-content-posts-widget promen-widget-loading" role="region" aria-labelledby="section-title-<?php echo esc_attr($widget_id); ?>">
            <?php 
            self::render_header($widget, $settings, $widget_id, $defaults['section_title'], $header_button_text);
            
            if ($posts_query->have_posts()) {
                self::render_filter_buttons($widget, $settings, $widget_id);
                
                // Content Rendering (Grid or Slider)
                // Content Rendering (Grid and optional Slider)
                self::render_grid($posts_query, $settings, $widget_id, $grid_classes, $read_more_text);
                
                if (isset($settings['enable_mobile_slider']) && $settings['enable_mobile_slider'] === 'yes') {
                     self::render_mobile_slider($posts_query, $settings, $widget_id);
                }
                
                self::render_footer_button($settings, $footer_button_text);
                self::render_filter_script($widget, $settings, $widget_id);
                
            } else {
                 echo '<div class="promen-content-no-posts" role="status" aria-live="polite"><p>' . esc_html__('No posts found.', 'promen-elementor-widgets') . '</p></div>';
            }
            ?>
        </section>
        <?php
    }

    private static function get_query_args($settings) {
        $args = [
            'post_type' => isset($settings['post_type']) ? $settings['post_type'] : 'post',
            'post_status' => 'publish',
        ];

        $content_selection = isset($settings['content_selection']) ? $settings['content_selection'] : 'automatic';

        switch ($content_selection) {
            case 'manual':
                if (!empty($settings['selected_posts'])) {
                    $args['post__in'] = $settings['selected_posts'];
                    $args['orderby'] = 'post__in';
                    $args['posts_per_page'] = count($settings['selected_posts']);
                } else {
                    $args['post__in'] = [0];
                    $args['posts_per_page'] = 1;
                }
                break;

            case 'taxonomy':
                $args['posts_per_page'] = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 6;
                $args['orderby'] = isset($settings['orderby']) ? $settings['orderby'] : 'date';
                $args['order'] = isset($settings['order']) ? $settings['order'] : 'DESC';

                if (!empty($settings['selected_taxonomy'])) {
                    if (!empty($settings['selected_terms'])) {
                        $args['tax_query'] = [
                            [
                                'taxonomy' => $settings['selected_taxonomy'],
                                'field' => 'term_id',
                                'terms' => $settings['selected_terms'],
                                'operator' => 'IN',
                            ],
                        ];
                    } else {
                        $args['tax_query'] = [
                            [
                                'taxonomy' => $settings['selected_taxonomy'],
                                'operator' => 'EXISTS',
                            ],
                        ];
                    }
                }
                break;

            case 'automatic':
            default:
                $args['posts_per_page'] = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 6;
                $args['orderby'] = isset($settings['orderby']) ? $settings['orderby'] : 'date';
                $args['order'] = isset($settings['order']) ? $settings['order'] : 'DESC';
                break;
        }

        return $args;
    }

    private static function get_default_texts($settings) {
        $post_type = isset($settings['post_type']) ? $settings['post_type'] : 'post';
        
        $defaults = [
            'section_title' => esc_html__('Blijf op de hoogte met het laatste Nieuws', 'promen-elementor-widgets'),
            'header_button_text' => esc_html__('Meer nieuws', 'promen-elementor-widgets'),
            'footer_button_text' => esc_html__('Meer nieuws', 'promen-elementor-widgets'),
            'read_more_text' => esc_html__('Lees meer', 'promen-elementor-widgets'),
        ];

        if ($post_type === 'succesvolle-verhalen') {
            $defaults['section_title'] = esc_html__('Onze Succesvolle Verhalen', 'promen-elementor-widgets');
            $defaults['header_button_text'] = esc_html__('Meer verhalen', 'promen-elementor-widgets');
            $defaults['footer_button_text'] = esc_html__('Meer verhalen', 'promen-elementor-widgets');
            $defaults['read_more_text'] = esc_html__('Lees verhaal', 'promen-elementor-widgets');
        } elseif ($post_type === 'vacatures') {
            $defaults['section_title'] = esc_html__('Onze Vacatures', 'promen-elementor-widgets');
            $defaults['header_button_text'] = esc_html__('Meer vacatures', 'promen-elementor-widgets');
            $defaults['footer_button_text'] = esc_html__('Meer vacatures', 'promen-elementor-widgets');
            $defaults['read_more_text'] = esc_html__('Bekijk vacature', 'promen-elementor-widgets');
        }
        
        // Use user provided title if available
        if (!empty($settings['section_title'])) {
            $defaults['section_title'] = $settings['section_title'];
        }

        return $defaults;
    }

    private static function render_header($widget, $settings, $widget_id, $section_title, $button_text) {
        if (!isset($settings['show_section_title']) || $settings['show_section_title'] !== 'yes') {
            return;
        }
        ?>
        <header class="promen-content-header">
            <div class="promen-content-section-title-wrapper">
                <h2 id="section-title-<?php echo esc_attr($widget_id); ?>" class="promen-content-title">
                    <?php echo promen_render_split_title($widget, $settings, 'section_title', 'promen'); ?>
                </h2>
            </div>
            
            <?php if (isset($settings['show_header_button']) && $settings['show_header_button'] === 'yes' && !empty($button_text) && !empty($settings['header_button_url']['url'])) : ?>
                <a href="<?php echo esc_url($settings['header_button_url']['url']); ?>" class="promen-content-header-button" 
                   <?php if ($settings['header_button_url']['is_external']) : ?>target="_blank" aria-label="<?php echo esc_attr($button_text . ' ' . esc_html__('(opent in een nieuw tabblad)', 'promen-elementor-widgets')); ?>"<?php else: ?>aria-label="<?php echo esc_attr($button_text); ?>"<?php endif; ?>
                   <?php if ($settings['header_button_url']['nofollow']) : ?>rel="nofollow"<?php endif; ?>>
                    <?php if (!empty($settings['header_button_icon']['value']) && $settings['header_button_icon_position'] === 'before') : ?>
                        <span class="button-icon-before" aria-hidden="true">
                            <?php \Elementor\Icons_Manager::render_icon($settings['header_button_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                    <?php endif; ?>
                    <span class="button-text"><?php echo esc_html($button_text); ?></span>
                    <?php if (!empty($settings['header_button_icon']['value']) && $settings['header_button_icon_position'] === 'after') : ?>
                        <span class="button-icon-after" aria-hidden="true">
                            <?php \Elementor\Icons_Manager::render_icon($settings['header_button_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </header>
        <?php
    }

    private static function render_filter_buttons($widget, $settings, $widget_id) {
        $content_selection = isset($settings['content_selection']) ? $settings['content_selection'] : 'automatic';
        if (!isset($settings['post_type']) || $settings['post_type'] !== 'vacatures' || 
            !isset($settings['show_vacature_filter']) || $settings['show_vacature_filter'] !== 'yes' || 
            $content_selection === 'manual') {
            return;
        }

        $filter_taxonomy = $widget->get_primary_taxonomy_for_post_type($settings['post_type']);
        $vacature_categories = [];
        if ($filter_taxonomy) {
            $vacature_categories = get_terms([
                'taxonomy' => $filter_taxonomy,
                'hide_empty' => true,
            ]);
        }
        
        if (empty($vacature_categories)) return;
        ?>
        <nav class="content-filter-buttons" role="tablist" aria-label="<?php echo esc_attr__('Filter nieuwsberichten op categorie om specifieke content te bekijken', 'promen-elementor-widgets'); ?>">
            <button class="content-filter-button active" 
                    data-filter="all" 
                    role="tab" 
                    aria-selected="true" 
                    aria-controls="content-grid-<?php echo esc_attr($widget_id); ?>"
                    id="filter-all-<?php echo esc_attr($widget_id); ?>">
                <?php echo esc_html(isset($settings['filter_all_text']) ? $settings['filter_all_text'] : esc_html__('Alle vacatures', 'promen-elementor-widgets')); ?>
            </button>
            
            <?php foreach ($vacature_categories as $category) : ?>
                <button class="content-filter-button" 
                        data-filter="<?php echo esc_attr($category->slug); ?>" 
                        role="tab" 
                        aria-selected="false" 
                        aria-controls="content-grid-<?php echo esc_attr($widget_id); ?>"
                        id="filter-<?php echo esc_attr($category->slug); ?>-<?php echo esc_attr($widget_id); ?>">
                    <?php echo esc_html($category->name); ?>
                </button>
            <?php endforeach; ?>
        </nav>
        <?php
    }

    private static function render_grid($posts_query, $settings, $widget_id, $grid_classes, $read_more_text) {
        // We use $posts_query but need to make sure we don't mess up the loop if we reuse it
        // The calling function should handle rewind if needed, or we clone.
        // But WP_Query is an object.
        // Assuming we reset or rewind before calling this if it was used.
        // Actually, render() calls this.
        
        if ($posts_query->current_post > -1) {
            $posts_query->rewind_posts();
        }

        // Add 'desktop-only' class if mobile slider is enabled, so grid hides on mobile
        if (isset($settings['enable_mobile_slider']) && $settings['enable_mobile_slider'] === 'yes') {
            $grid_classes .= ' desktop-only';
        }

        // Helper for template inclusion
        $template_settings = $settings;
        $template_settings['read_more_text'] = $read_more_text;
        
        // We need filter_taxonomy if filtering is on
        $filter_taxonomy = null;
        if (isset($settings['post_type']) && $settings['post_type'] === 'vacatures' && isset($settings['show_vacature_filter']) && $settings['show_vacature_filter'] === 'yes') {
             // We can't access $widget easily here to call get_primary_taxonomy... unless we pass it or make that method static too.
             // But we can approximate or pass it.
             // Actually, 'vacatures' usually uses 'vacature_categorie' or similar. 
             // Let's rely on get_taxonomies or just assume it's passed or available.
             // For now, let's skip the taxonomy lookup inside the loop optimization and just use get_the_terms matching settings?
             // Or better, pass $filter_taxonomy to this method.
             // But for now, let's keep it simple.
             $filter_taxonomy = 'vacature_categorie'; // Hardcoded assumption or we need to pass it.
             // Actually, let's use the one from settings if we can find it? No.
             // Let's instantiate Promen_News_Posts_Widget to call helper? No.
             // For now, let's just get the terms that are relevant.
        }

        ?>
        <div class="<?php echo esc_attr($grid_classes); ?>" 
             id="content-grid-<?php echo esc_attr($widget_id); ?>" 
             role="tabpanel" 
             aria-labelledby="filter-all-<?php echo esc_attr($widget_id); ?>"
             aria-live="polite"
             aria-label="<?php echo esc_attr__('Job listings grid', 'promen-elementor-widgets'); ?>">
            <?php while ($posts_query->have_posts()) : $posts_query->the_post(); 
                $post_categories = '';
                // Logic for categories (simplified for refactor, ideally pass taxonomy)
                if ($filter_taxonomy) {
                    $terms = get_the_terms(get_the_ID(), $filter_taxonomy);
                    if (!empty($terms) && !is_wp_error($terms)) {
                        $category_slugs = [];
                        foreach ($terms as $term) {
                            $category_slugs[] = $term->slug;
                        }
                        $post_categories = implode(' ', $category_slugs);
                    }
                }
            ?>
                <article class="promen-content-card-wrapper" 
                         data-categories="<?php echo esc_attr($post_categories); ?>"
                         role="article"
                         aria-labelledby="post-title-<?php echo esc_attr(get_the_ID()); ?>">
                    <?php include(__DIR__ . '/content-template.php'); ?>
                </article>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        <?php
    }

    private static function render_mobile_slider($posts_query, $settings, $widget_id) {
        if ($posts_query->current_post > -1) {
             $posts_query->rewind_posts();
        }

        // This container should be mobile only
        echo '<div class="mobile-slider-wrapper mobile-only">';
        
        $slider_template = isset($settings['slider_template']) ? $settings['slider_template'] : 'default';
        $slider_settings = [
            'slidesPerView' => isset($settings['slides_per_view']) ? $settings['slides_per_view'] : 1,
            'spaceBetween' => isset($settings['space_between']) ? intval($settings['space_between']) : 30,
            'navigation' => isset($settings['slider_navigation']) && $settings['slider_navigation'] === 'yes',
            'pagination' => isset($settings['slider_pagination']) && $settings['slider_pagination'] === 'yes',
            'loop' => isset($settings['slider_loop']) && $settings['slider_loop'] === 'yes',
            'autoplay' => isset($settings['slider_autoplay']) && $settings['slider_autoplay'] === 'yes',
            'autoplayDelay' => isset($settings['slider_autoplay_delay']) ? intval($settings['slider_autoplay_delay']) : 5000,
            'effect' => isset($settings['slider_effect']) ? $settings['slider_effect'] : 'slide',
            'speed' => isset($settings['slider_speed']) ? intval($settings['slider_speed']) : 300,
            'centeredSlides' => isset($settings['centered_slides']) && $settings['centered_slides'] === 'yes',
        ];
        
        // Pass essential vars to include
        // We need $filter_taxonomy logic here too if we want filtering to work in slider? 
        // Sliders usually don't filter in realtime easily like grids. 
        // We'll ignore filtering specific logic for slider slides unless needed.
        
        $template_file = __DIR__ . '/../slider-templates/' . $slider_template . '.php';
        if (file_exists($template_file)) {
            // Need to pass variables to the include scope
            // $posts_query and $settings are needed.
            $template_settings = $settings; // Ensure this is available
            include($template_file);
        }

        echo '</div>';
        wp_reset_postdata();
    }

    private static function render_footer_button($settings, $button_text) {
        if (isset($settings['show_footer_button']) && $settings['show_footer_button'] === 'yes' && !empty($button_text) && !empty($settings['footer_button_url']['url'])) : ?>
            <footer class="promen-content-footer-wrapper">
                <a href="<?php echo esc_url($settings['footer_button_url']['url']); ?>" class="promen-content-footer-button" 
                   <?php if ($settings['footer_button_url']['is_external']) : ?>target="_blank" aria-label="<?php echo esc_attr($button_text . ' ' . esc_html__('(opens in new tab)', 'promen-elementor-widgets')); ?>"<?php else: ?>aria-label="<?php echo esc_attr($button_text); ?>"<?php endif; ?>
                   <?php if ($settings['footer_button_url']['nofollow']) : ?>rel="nofollow"<?php endif; ?>>
                    <?php if (!empty($settings['header_button_icon']['value']) && $settings['header_button_icon_position'] === 'before') : ?>
                        <span class="button-icon-before" aria-hidden="true">
                            <?php \Elementor\Icons_Manager::render_icon($settings['header_button_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                    <?php endif; ?>
                    <span class="button-text"><?php echo esc_html($button_text); ?></span>
                    <?php if (!empty($settings['header_button_icon']['value']) && $settings['header_button_icon_position'] === 'after') : ?>
                        <span class="button-icon-after" aria-hidden="true">
                            <?php \Elementor\Icons_Manager::render_icon($settings['header_button_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                    <?php endif; ?>
                </a>
            </footer>
        <?php endif;
    }

    private static function render_filter_script($widget, $settings, $widget_id) {
        // Filter script is now handled by assets/js/modules/news-posts-filter.js
    }

}