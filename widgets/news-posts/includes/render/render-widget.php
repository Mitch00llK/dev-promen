<?php
/**
 * Render logic for News Posts Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$settings = $this->get_settings_for_display();

// Build query arguments based on content selection method
$args = [
    'post_type' => isset($settings['post_type']) ? $settings['post_type'] : 'post',
    'post_status' => 'publish',
];

$content_selection = isset($settings['content_selection']) ? $settings['content_selection'] : 'automatic';

switch ($content_selection) {
    case 'manual':
        // Manual post selection
        if (!empty($settings['selected_posts'])) {
            $args['post__in'] = $settings['selected_posts'];
            $args['orderby'] = 'post__in'; // Maintain the order of selection
            $args['posts_per_page'] = count($settings['selected_posts']);
        } else {
            // No posts selected, show nothing
            $args['post__in'] = [0]; // This will return no posts
            $args['posts_per_page'] = 1;
        }
        break;

    case 'taxonomy':
        // Taxonomy-based selection
        $args['posts_per_page'] = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 6;
        $args['orderby'] = isset($settings['orderby']) ? $settings['orderby'] : 'date';
        $args['order'] = isset($settings['order']) ? $settings['order'] : 'DESC';

        if (!empty($settings['selected_taxonomy'])) {
            if (!empty($settings['selected_terms'])) {
                // Filter by specific terms
                $args['tax_query'] = [
                    [
                        'taxonomy' => $settings['selected_taxonomy'],
                        'field' => 'term_id',
                        'terms' => $settings['selected_terms'],
                        'operator' => 'IN',
                    ],
                ];
            } else {
                // Show all posts from the selected taxonomy (that have any term)
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
        // Automatic selection (latest posts)
        $args['posts_per_page'] = isset($settings['posts_per_page']) ? $settings['posts_per_page'] : 6;
        $args['orderby'] = isset($settings['orderby']) ? $settings['orderby'] : 'date';
        $args['order'] = isset($settings['order']) ? $settings['order'] : 'DESC';
        break;
}

// Set default section title based on post type if not provided
$section_title = isset($settings['section_title']) ? $settings['section_title'] : '';
if (empty($section_title)) {
    if ($settings['post_type'] === 'succesvolle-verhalen') {
        $section_title = esc_html__('Onze Succesvolle Verhalen', 'promen-elementor-widgets');
    } elseif ($settings['post_type'] === 'vacatures') {
        $section_title = esc_html__('Onze Vacatures', 'promen-elementor-widgets');
    } else {
        $section_title = esc_html__('Blijf op de hoogte met het laatste Nieuws', 'promen-elementor-widgets');
    }
}

// Set default button text based on post type if not provided
$header_button_text = isset($settings['header_button_text']) ? $settings['header_button_text'] : '';
$footer_button_text = isset($settings['footer_button_text']) ? $settings['footer_button_text'] : '';

if (empty($header_button_text)) {
    if ($settings['post_type'] === 'succesvolle-verhalen') {
        $header_button_text = esc_html__('Meer verhalen', 'promen-elementor-widgets');
    } elseif ($settings['post_type'] === 'vacatures') {
        $header_button_text = esc_html__('Meer vacatures', 'promen-elementor-widgets');
    } else {
        $header_button_text = esc_html__('Meer nieuws', 'promen-elementor-widgets');
    }
}

if (empty($footer_button_text)) {
    if ($settings['post_type'] === 'succesvolle-verhalen') {
        $footer_button_text = esc_html__('Meer verhalen', 'promen-elementor-widgets');
    } elseif ($settings['post_type'] === 'vacatures') {
        $footer_button_text = esc_html__('Meer vacatures', 'promen-elementor-widgets');
    } else {
        $footer_button_text = esc_html__('Meer nieuws', 'promen-elementor-widgets');
    }
}

// Set default read more text based on post type if not provided
$read_more_text = isset($settings['read_more_text']) ? $settings['read_more_text'] : '';
if (empty($read_more_text)) {
    if ($settings['post_type'] === 'succesvolle-verhalen') {
        $read_more_text = esc_html__('Lees verhaal', 'promen-elementor-widgets');
    } elseif ($settings['post_type'] === 'vacatures') {
        $read_more_text = esc_html__('Bekijk vacature', 'promen-elementor-widgets');
    } else {
        $read_more_text = esc_html__('Lees meer', 'promen-elementor-widgets');
    }
}

$posts_query = new \WP_Query($args);

// Responsive classes
$columns_desktop = isset($settings['columns_desktop']) ? $settings['columns_desktop'] : '3';
$columns_tablet = isset($settings['columns_tablet']) ? $settings['columns_tablet'] : '2';
$columns_mobile = isset($settings['columns_mobile']) ? $settings['columns_mobile'] : '1';

$grid_classes = "promen-content-grid desktop-columns-{$columns_desktop} tablet-columns-{$columns_tablet} mobile-columns-{$columns_mobile}";

// Slider settings
$enable_mobile_slider = isset($settings['enable_mobile_slider']) ? $settings['enable_mobile_slider'] : 'yes';
$slider_template = isset($settings['slider_template']) ? $settings['slider_template'] : 'default';

// Prepare slider settings
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

// Generate a unique ID for this widget instance
$widget_id = $this->get_id();
?>

<section class="promen-content-posts-widget promen-widget-loading" role="region" aria-labelledby="section-title-<?php echo esc_attr($widget_id); ?>">
    <?php if (isset($settings['show_section_title']) && $settings['show_section_title'] === 'yes') : ?>
    <header class="promen-content-header">
        <div class="promen-content-section-title-wrapper">
            <h2 id="section-title-<?php echo esc_attr($widget_id); ?>" class="promen-content-title">
                <?php echo promen_render_split_title($this, $settings, 'section_title', 'promen'); ?>
            </h2>
        </div>
        
        <?php if (isset($settings['show_header_button']) && $settings['show_header_button'] === 'yes' && !empty($header_button_text) && !empty($settings['header_button_url']['url'])) : ?>
            <a href="<?php echo esc_url($settings['header_button_url']['url']); ?>" class="promen-content-header-button" 
               <?php if ($settings['header_button_url']['is_external']) : ?>target="_blank" aria-label="<?php echo esc_attr($header_button_text . ' ' . esc_html__('(opent in een nieuw tabblad)', 'promen-elementor-widgets')); ?>"<?php else: ?>aria-label="<?php echo esc_attr($header_button_text); ?>"<?php endif; ?>
               <?php if ($settings['header_button_url']['nofollow']) : ?>rel="nofollow"<?php endif; ?>>
                <?php if (!empty($settings['header_button_icon']['value']) && $settings['header_button_icon_position'] === 'before') : ?>
                    <span class="button-icon-before" aria-hidden="true">
                        <?php \Elementor\Icons_Manager::render_icon($settings['header_button_icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                <?php endif; ?>
                <span class="button-text"><?php echo esc_html($header_button_text); ?></span>
                <?php if (!empty($settings['header_button_icon']['value']) && $settings['header_button_icon_position'] === 'after') : ?>
                    <span class="button-icon-after" aria-hidden="true">
                        <?php \Elementor\Icons_Manager::render_icon($settings['header_button_icon'], ['aria-hidden' => 'true']); ?>
                    </span>
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </header>
    <?php endif; ?>
    
    <?php if ($posts_query->have_posts()) : ?>
        <?php 
        // Display filter buttons for vacatures if enabled (only for non-manual selection)
        if (isset($settings['post_type']) && $settings['post_type'] === 'vacatures' && isset($settings['show_vacature_filter']) && $settings['show_vacature_filter'] === 'yes' && $content_selection !== 'manual') : 
            // Get the primary taxonomy for this post type
            $filter_taxonomy = $this->get_primary_taxonomy_for_post_type($settings['post_type']);
            
            // Get all categories for the determined taxonomy
            $vacature_categories = [];
            if ($filter_taxonomy) {
                $vacature_categories = get_terms([
                    'taxonomy' => $filter_taxonomy,
                    'hide_empty' => true,
                ]);
            }
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
        <?php endif; ?>

        <!-- Desktop/Tablet Grid View -->
        <div class="<?php echo esc_attr($grid_classes); ?>" 
             id="content-grid-<?php echo esc_attr($widget_id); ?>" 
             role="tabpanel" 
             aria-labelledby="filter-all-<?php echo esc_attr($widget_id); ?>"
             aria-live="polite"
             aria-label="<?php echo esc_attr__('Job listings grid', 'promen-elementor-widgets'); ?>">
            <?php while ($posts_query->have_posts()) : $posts_query->the_post(); 
                // Get post categories for filtering
                $post_categories = '';
                if (isset($settings['show_vacature_filter']) && $settings['show_vacature_filter'] === 'yes' && isset($filter_taxonomy) && $filter_taxonomy) {
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
                    <?php 
                    // Pass the read_more_text to the template
                    $template_settings = $settings;
                    $template_settings['read_more_text'] = $read_more_text;
                    include(__DIR__ . '/content-template.php'); 
                    ?>
                </article>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        </div>
        
        <?php if (isset($settings['show_footer_button']) && $settings['show_footer_button'] === 'yes' && !empty($footer_button_text) && !empty($settings['footer_button_url']['url'])) : ?>
            <footer class="promen-content-footer-wrapper">
                <a href="<?php echo esc_url($settings['footer_button_url']['url']); ?>" class="promen-content-footer-button" 
                   <?php if ($settings['footer_button_url']['is_external']) : ?>target="_blank" aria-label="<?php echo esc_attr($footer_button_text . ' ' . esc_html__('(opens in new tab)', 'promen-elementor-widgets')); ?>"<?php else: ?>aria-label="<?php echo esc_attr($footer_button_text); ?>"<?php endif; ?>
                   <?php if ($settings['footer_button_url']['nofollow']) : ?>rel="nofollow"<?php endif; ?>>
                    <?php if (!empty($settings['footer_button_icon']['value']) && $settings['footer_button_icon_position'] === 'before') : ?>
                        <span class="button-icon-before" aria-hidden="true">
                            <?php \Elementor\Icons_Manager::render_icon($settings['footer_button_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                    <?php endif; ?>
                    <span class="button-text"><?php echo esc_html($footer_button_text); ?></span>
                    <?php if (!empty($settings['footer_button_icon']['value']) && $settings['footer_button_icon_position'] === 'after') : ?>
                        <span class="button-icon-after" aria-hidden="true">
                            <?php \Elementor\Icons_Manager::render_icon($settings['footer_button_icon'], ['aria-hidden' => 'true']); ?>
                        </span>
                    <?php endif; ?>
                </a>
            </footer>
        <?php endif; ?>
        
        <?php if (isset($settings['post_type']) && $settings['post_type'] === 'vacatures' && isset($settings['show_vacature_filter']) && $settings['show_vacature_filter'] === 'yes' && $content_selection !== 'manual') : ?>
        <script>
        (function() {
            function initFiltering() {
                const widgetId = '<?php echo esc_js($widget_id); ?>';
                const gridId = 'content-grid-' + widgetId;
                const grid = document.getElementById(gridId);
                
                if (!grid) {
                    // Retry if grid is not ready yet
                    requestAnimationFrame(function() {
                        setTimeout(initFiltering, 50);
                    });
                    return;
                }
                
                const filterButtons = document.querySelectorAll('.content-filter-buttons .content-filter-button');
                const widget = grid.closest('.promen-content-posts-widget');
                
                // Make sure all items are visible initially
                const allItems = grid.querySelectorAll('.promen-content-card-wrapper');
                allItems.forEach(item => {
                    item.style.display = '';
                });
                
                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Remove active class and aria-selected from all buttons
                        filterButtons.forEach(btn => {
                            btn.classList.remove('active');
                            btn.setAttribute('aria-selected', 'false');
                        });
                        
                        // Add active class and aria-selected to clicked button
                        this.classList.add('active');
                        this.setAttribute('aria-selected', 'true');
                        
                        const filter = this.getAttribute('data-filter');
                        const filterText = this.textContent.trim();
                        
                        // Announce filter change to screen readers
                        const announcement = document.createElement('div');
                        announcement.setAttribute('aria-live', 'polite');
                        announcement.setAttribute('aria-atomic', 'true');
                        announcement.className = 'sr-only';
                        announcement.textContent = `Filtered to show ${filter === 'all' ? 'all job listings' : filterText + ' job listings'}`;
                        document.body.appendChild(announcement);
                        
                        // Remove announcement after screen reader has time to read it
                        setTimeout(() => {
                            document.body.removeChild(announcement);
                        }, 1000);
                        
                        // Filter desktop/tablet grid items
                        const gridItems = grid.querySelectorAll('.promen-content-card-wrapper');
                        let visibleCount = 0;
                        
                        gridItems.forEach(item => {
                            if (filter === 'all') {
                                // Show all items when "All" is selected
                                item.style.display = '';
                                visibleCount++;
                            } else {
                                // Filter items based on category
                                const categories = item.getAttribute('data-categories');
                                if (categories && categories.includes(filter)) {
                                    item.style.display = '';
                                    visibleCount++;
                                } else {
                                    item.style.display = 'none';
                                }
                            }
                        });
                        
                        // Update grid aria-label with count
                        grid.setAttribute('aria-label', `Job listings grid showing ${visibleCount} ${visibleCount === 1 ? 'listing' : 'listings'}`);
                    });
                    
                    // Add keyboard support for filter buttons
                    button.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.click();
                        } else if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                            e.preventDefault();
                            const currentIndex = Array.from(filterButtons).indexOf(this);
                            let nextIndex;
                            
                            if (e.key === 'ArrowLeft') {
                                nextIndex = currentIndex > 0 ? currentIndex - 1 : filterButtons.length - 1;
                            } else {
                                nextIndex = currentIndex < filterButtons.length - 1 ? currentIndex + 1 : 0;
                            }
                            
                            filterButtons[nextIndex].focus();
                        }
                    });
                });
            }
            
            // Wait for DOM and layout to be ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    requestAnimationFrame(function() {
                        setTimeout(initFiltering, 100);
                    });
                });
            } else {
                requestAnimationFrame(function() {
                    setTimeout(initFiltering, 100);
                });
            }
        })();
        </script>
        <?php endif; ?>
        
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <div class="promen-content-no-posts" role="status" aria-live="polite">
            <p><?php echo esc_html__('No posts found.', 'promen-elementor-widgets'); ?></p>
        </div>
    <?php endif; ?>
</section> 