<?php
/**
 * Team Members Carousel Widget Render Template
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

$settings = $this->get_settings_for_display();
$id_int = substr($this->get_id_int(), 0, 3);

$carousel_id = 'promen-team-members-carousel-' . $id_int;
$has_gradient = $settings['gradient_overlay'] === 'yes' ? 'has-gradient' : '';
$gradient_class = '';

if ($settings['gradient_overlay'] === 'yes') {
    $gradient_class = $settings['gradient_intensity'] . '-gradient';
}

// Prepare classes for the main container
$container_classes = array('team-members-carousel-container');
if ($settings['enable_right_overflow'] === 'yes') {
    $container_classes[] = 'team-members-carousel-overflow';
}

// Add gradient classes to container if enabled
if ($settings['gradient_overlay'] === 'yes') {
    $container_classes[] = 'has-gradient';
    $container_classes[] = $gradient_class;
}

// Get complete list of container classes
$container_class = implode(' ', $container_classes);

// Query posts
$args = array(
    'post_type' => 'organisatie-bestuur',
    'posts_per_page' => $settings['posts_per_page'],
    'orderby' => $settings['order_by'],
    'order' => $settings['order'],
);

$team_query = new \WP_Query($args);

// Generate unique IDs for accessibility
$widget_id = $this->get_id();
$heading_id = Promen_Accessibility_Utils::generate_id('team-members-heading');
$carousel_region_id = Promen_Accessibility_Utils::generate_id('team-members-carousel');
?>

<section class="<?php echo esc_attr($container_class); ?>" 
         role="region" 
         aria-labelledby="<?php echo esc_attr($heading_id); ?>"
         aria-label="<?php esc_attr_e('Interactieve carrousel met informatie over onze teamleden en medewerkers', 'promen-elementor-widgets'); ?>">
    <?php if ($settings['show_section_title'] === 'yes') : ?>
    <header class="team-members-header" id="<?php echo esc_attr($heading_id); ?>">
        <div class="team-members-title">
            <?php echo promen_render_split_title($this, $settings, 'title', 'team'); ?>
        </div>
        
        <?php if ($settings['show_arrows'] === 'yes') : ?>
        <nav class="team-members-navigation" aria-label="<?php esc_attr_e('Navigatieknoppen om door de teamleden carrousel te bladeren', 'promen-elementor-widgets'); ?>">
            <button type="button" class="carousel-arrow carousel-arrow-prev" 
                    data-carousel="<?php echo esc_attr($carousel_id); ?>"
                    aria-label="<?php esc_attr_e('Ga naar de vorige groep teamleden in de carrousel', 'promen-elementor-widgets'); ?>"
                    aria-controls="<?php echo esc_attr($carousel_region_id); ?>">
                <?php \Elementor\Icons_Manager::render_icon($settings['prev_arrow_icon'], ['aria-hidden' => 'true']); ?>
            </button>
            <button type="button" class="carousel-arrow carousel-arrow-next" 
                    data-carousel="<?php echo esc_attr($carousel_id); ?>"
                    aria-label="<?php esc_attr_e('Ga naar de volgende groep teamleden in de carrousel', 'promen-elementor-widgets'); ?>"
                    aria-controls="<?php echo esc_attr($carousel_region_id); ?>">
                <?php \Elementor\Icons_Manager::render_icon($settings['next_arrow_icon'], ['aria-hidden' => 'true']); ?>
            </button>
        </nav>
        <?php endif; ?>
    </header>
    <?php endif; ?>
    
    <div class="team-members-carousel-wrapper">
        <?php if ($settings['gradient_overlay'] === 'yes') : ?>
            <div class="carousel-gradient-overlay <?php echo esc_attr($gradient_class); ?>"></div>
        <?php endif; ?>
        
        <?php
        // Get responsive cards per view settings
        $cards_desktop = !empty($settings['cards_per_view']) ? $settings['cards_per_view'] : '4';
        $cards_tablet = !empty($settings['cards_per_view_tablet']) ? $settings['cards_per_view_tablet'] : '2';
        $cards_mobile = !empty($settings['cards_per_view_mobile']) ? $settings['cards_per_view_mobile'] : '1';
        
        // Fallback to desktop value if responsive values are not set
        if (empty($cards_tablet)) $cards_tablet = $cards_desktop;
        if (empty($cards_mobile)) $cards_mobile = $cards_desktop;
        ?>
        
        <!-- Swiper container with proper structure -->
        <div id="<?php echo esc_attr($carousel_id); ?>" 
             class="team-members-carousel"
             role="region" 
             aria-label="<?php esc_attr_e('Interactieve carrousel met informatie over onze teamleden en medewerkers', 'promen-elementor-widgets'); ?>"
             aria-live="polite"
             id="<?php echo esc_attr($carousel_region_id); ?>"
             data-cards-desktop="<?php echo esc_attr($cards_desktop); ?>"
             data-cards-tablet="<?php echo esc_attr($cards_tablet); ?>"
             data-cards-mobile="<?php echo esc_attr($cards_mobile); ?>"
             data-infinite="<?php echo esc_attr($settings['infinite'] === 'yes' ? 'true' : 'false'); ?>"
             data-autoplay="<?php echo esc_attr($settings['autoplay'] === 'yes' ? 'true' : 'false'); ?>"
             data-autoplay-speed="<?php echo esc_attr($settings['autoplay'] === 'yes' ? $settings['autoplay_speed'] : '3000'); ?>"
             data-speed="<?php echo esc_attr($settings['speed']); ?>"
             data-centered="<?php echo esc_attr($settings['centered_slides'] === 'yes' ? 'true' : 'false'); ?>"
             data-slide-to-clicked="<?php echo esc_attr($settings['slide_to_clicked'] === 'yes' ? 'true' : 'false'); ?>">
            <div class="swiper">
                <div class="swiper-wrapper" <?php if ($team_query->have_posts()) : ?>role="list" aria-label="<?php esc_attr_e('Lijst met alle teamleden en hun contactinformatie die u kunt bekijken', 'promen-elementor-widgets'); ?>"<?php endif; ?>>
                    <?php 
                    if ($team_query->have_posts()) :
                        $member_index = 0;
                        while ($team_query->have_posts()) : $team_query->the_post();
                            $member_id = get_the_ID();
                            $member_title = get_post_meta($member_id, 'functie_titel', true);
                            $linkedin_url = get_post_meta($member_id, 'linkedin_profiel', true);
                            $member_index++;
                            
                            // Generate unique IDs for accessibility
                            $member_item_id = Promen_Accessibility_Utils::generate_id('member-item-' . $member_index);
                            $member_name_id = Promen_Accessibility_Utils::generate_id('member-name-' . $member_index);
                            $member_title_id = Promen_Accessibility_Utils::generate_id('member-title-' . $member_index);
                    ?>
                        <article class="member-card swiper-slide" 
                                 role="listitem" 
                                 tabindex="0"
                                 aria-labelledby="<?php echo esc_attr($member_name_id); ?>"
                                 aria-describedby="<?php echo esc_attr($member_title_id); ?>"
                                 id="<?php echo esc_attr($member_item_id); ?>">
                            <?php if ($settings['show_member_image'] === 'yes' && has_post_thumbnail()) : ?>
                                <figure class="member-image" role="img" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php the_post_thumbnail('full'); ?>
                                </figure>
                            <?php endif; ?>
                            
                            <div class="member-content">
                                <?php if ($settings['show_member_name'] === 'yes') : 
                                    $member_name_tag = $settings['member_name_tag'];
                                ?>
                                    <<?php echo esc_attr($member_name_tag); ?> class="member-name" id="<?php echo esc_attr($member_name_id); ?>"><?php the_title(); ?></<?php echo esc_attr($member_name_tag); ?>>
                                <?php endif; ?>
                                
                                <?php if ($settings['show_member_title'] === 'yes' && !empty($member_title)) : ?>
                                    <p class="member-title" id="<?php echo esc_attr($member_title_id); ?>"><?php echo esc_html($member_title); ?></p>
                                <?php endif; ?>
                                
                                <?php if ($settings['show_linkedin'] === 'yes' && !empty($linkedin_url)) : ?>
                                    <a href="<?php echo esc_url($linkedin_url); ?>" class="member-linkedin" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr__('LinkedIn profile of ', 'promen-elementor-widgets') . esc_attr(get_the_title()); ?>">
                                        <i class="fab fa-linkedin" aria-hidden="true"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php 
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                        <div class="swiper-slide">
                            <p><?php esc_html_e('Geen teamleden gevonden.', 'promen-elementor-widgets'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Add pagination if needed -->
                <?php if ($settings['show_pagination'] === 'yes') : ?>
                <div class="swiper-pagination" role="group" aria-label="<?php esc_attr_e('Paginering om door verschillende teamleden pagina\'s te navigeren', 'promen-elementor-widgets'); ?>"></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section> 