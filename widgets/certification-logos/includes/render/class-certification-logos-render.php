<?php
/**
 * Certification Logos Widget Render
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Certification Logos Widget Render Class
 */
class Promen_Certification_Logos_Render {

    /**
     * Render Certification Logos Widget
     */
    public static function render($widget) {
        $settings = $widget->get_settings_for_display();
        $logos = isset($settings['logos_list']) ? $settings['logos_list'] : [];
        $enable_slider = isset($settings['enable_slider']) ? $settings['enable_slider'] : 'no';
        
        // Generate accessibility attributes
        $widget_id = $widget->get_id();
        $container_id = Promen_Accessibility_Utils::generate_id('certification-logos', $widget_id);
        $title_id = Promen_Accessibility_Utils::generate_id('certification-title', $widget_id);
        $description_id = Promen_Accessibility_Utils::generate_id('certification-description', $widget_id);

        // Wrapper classes
        $wrapper_classes = ['promen-certification-logos', 'promen-widget'];
        ?>
        <section class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>" 
                 id="<?php echo esc_attr($container_id); ?>"
                 role="region" 
                 <?php if ($settings['show_title'] === 'yes') : ?>aria-labelledby="<?php echo esc_attr($title_id); ?>"<?php endif; ?>
                 <?php if ($settings['show_description'] === 'yes' && !empty($settings['description_text'])) : ?>aria-describedby="<?php echo esc_attr($description_id); ?>"<?php endif; ?>
                 aria-label="<?php echo esc_attr__('Overzicht van alle certificeringen en kwaliteitskeurmerken die wij hebben behaald', 'promen-elementor-widgets'); ?>">
            
            <?php if ($settings['show_title'] === 'yes'): ?>
                <header class="certification-title-wrapper">
                    <?php 
                    $title_settings = $settings;
                    $title_settings['title_id'] = $title_id;
                    echo promen_render_split_title($widget, $title_settings, 'title', 'certification'); 
                    ?>
                </header>
            <?php endif; ?>

            <?php if ($settings['show_description'] === 'yes' && !empty($settings['description_text'])): ?>
                <p class="certification-description" id="<?php echo esc_attr($description_id); ?>">
                    <?php echo esc_html($settings['description_text']); ?>
                </p>
            <?php endif; ?>

            <div class="logos-grid" 
                 role="list" 
                 aria-label="<?php echo esc_attr__('Overzicht van alle certificeringen en kwaliteitskeurmerken die wij hebben behaald', 'promen-elementor-widgets'); ?>">
                <?php foreach ($logos as $index => $logo): ?>
                    <div class="certification-logo" 
                         role="listitem"
                         tabindex="0"
                         aria-label="<?php echo esc_attr(sprintf(__('Certificeringslogo %d van %d in het overzicht', 'promen-elementor-widgets'), $index + 1, count($logos))); ?>">
                        <?php if (!empty($logo['logo_link']['url'])): ?>
                            <a href="<?php echo esc_url($logo['logo_link']['url']); ?>"
                               <?php echo $logo['logo_link']['is_external'] ? ' target="_blank"' : ''; ?>
                               <?php echo $logo['logo_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                               aria-label="<?php echo esc_attr(sprintf(__('Bezoek de certificeringspagina van %s voor meer informatie', 'promen-elementor-widgets'), $logo['logo_name'])); ?>">
                        <?php endif; ?>

                        <?php if (!empty($logo['logo_image']['url'])): ?>
                            <img src="<?php echo esc_url($logo['logo_image']['url']); ?>"
                                 alt="<?php echo esc_attr($logo['logo_name'] ?: sprintf(__('Certificeringslogo %d', 'promen-elementor-widgets'), $index + 1)); ?>"
                                 loading="lazy">
                        <?php endif; ?>

                        <?php if (!empty($logo['logo_link']['url'])): ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($enable_slider === 'yes'): ?>
            <div class="mobile-slider swiper" 
                 style="display: none;"
                 role="region" 
                 aria-label="<?php echo esc_attr__('Interactieve carrousel met certificeringslogo\'s die u kunt doorbladeren', 'promen-elementor-widgets'); ?>"
                 aria-live="polite">
                <div class="swiper-wrapper" role="list" aria-label="<?php echo esc_attr__('Certificeringslogo\'s', 'promen-elementor-widgets'); ?>">
                    <?php foreach ($logos as $index => $logo): ?>
                        <div class="certification-logo swiper-slide" 
                             role="listitem"
                             tabindex="0"
                             aria-label="<?php echo esc_attr(sprintf(__('Certificeringslogo %d van %d in het overzicht', 'promen-elementor-widgets'), $index + 1, count($logos))); ?>">
                            <?php if (!empty($logo['logo_link']['url'])): ?>
                                <a href="<?php echo esc_url($logo['logo_link']['url']); ?>"
                                   <?php echo $logo['logo_link']['is_external'] ? ' target="_blank"' : ''; ?>
                                   <?php echo $logo['logo_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                                   aria-label="<?php echo esc_attr(sprintf(__('Bezoek de certificeringspagina van %s voor meer informatie', 'promen-elementor-widgets'), $logo['logo_name'])); ?>">
                            <?php endif; ?>

                            <?php if (!empty($logo['logo_image']['url'])): ?>
                                <img src="<?php echo esc_url($logo['logo_image']['url']); ?>"
                                     alt="<?php echo esc_attr($logo['logo_name'] ?: sprintf(__('Certificeringslogo %d', 'promen-elementor-widgets'), $index + 1)); ?>"
                                     loading="lazy">
                            <?php endif; ?>

                            <?php if (!empty($logo['logo_link']['url'])): ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Add Navigation -->
                <button class="swiper-button-next" 
                        type="button"
                        aria-label="<?php echo esc_attr__('Ga naar het volgende certificeringslogo in de carrousel', 'promen-elementor-widgets'); ?>">
                    <span class="screen-reader-text"><?php echo esc_html__('Volgend certificeringslogo', 'promen-elementor-widgets'); ?></span>
                </button>
                <button class="swiper-button-prev" 
                        type="button"
                        aria-label="<?php echo esc_attr__('Ga naar het vorige certificeringslogo in de carrousel', 'promen-elementor-widgets'); ?>">
                    <span class="screen-reader-text"><?php echo esc_html__('Vorig certificeringslogo', 'promen-elementor-widgets'); ?></span>
                </button>
                <!-- Add Pagination -->
                <div class="swiper-pagination" 
                     role="group" 
                     aria-label="<?php echo esc_attr__('Paginering om door verschillende certificeringslogo\'s te navigeren', 'promen-elementor-widgets'); ?>"></div>
            </div>
            <?php endif; ?>
        </section>
        <?php
    }
}
