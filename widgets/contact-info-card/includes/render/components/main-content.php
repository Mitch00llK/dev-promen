<?php
/**
 * Main Content Component for Contact Info Card Widget
 * 
 * Renders the main content section with heading, description, and CTA button.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Renders the main content section.
 * 
 * @param array $settings Widget settings
 */
function render_main_content($settings) {
    ?>
    <div class="contact-info-card__main-content">
        <?php if ('yes' === $settings['show_heading']) : ?>
            <div class="contact-info-card__heading-wrapper">
                <?php
                $heading_tag = $settings['title_html_tag'] ?: 'h3';
                
                if ('yes' === $settings['split_title']) {
                    ?>
                    <<?php echo $heading_tag; ?> class="promen-split-title">
                        <span class="promen-title-part-1"><?php echo esc_html($settings['title_part_1'] ?: ''); ?></span>
                        <span class="promen-title-part-2"><?php echo esc_html($settings['title_part_2'] ?: ''); ?></span>
                    </<?php echo $heading_tag; ?>>
                    <?php
                } elseif (!empty($settings['heading'])) {
                    ?>
                    <<?php echo $heading_tag; ?> class="promen-title">
                        <?php echo esc_html($settings['heading']); ?>
                    </<?php echo $heading_tag; ?>>
                    <?php
                }
                ?>
            </div>
        <?php endif; ?>
        
        <?php if ('yes' === $settings['show_description']) : ?>
            <?php if ($settings['content_type'] === 'description' && !empty($settings['description'])) : ?>
                <div class="contact-info-card__description"><?php echo wp_kses_post($settings['description']); ?></div>
            <?php elseif ($settings['content_type'] === 'icon_list' && !empty($settings['icon_list_items'])) : ?>
                <ul class="contact-info-card__icon-list">
                    <?php foreach ($settings['icon_list_items'] as $index => $item) : ?>
                        <li class="contact-info-card__icon-list-item">
                            <?php if (!empty($item['item_icon']['value'])) : ?>
                                <span class="contact-info-card__icon-list-icon" aria-hidden="true">
                                    <?php \Elementor\Icons_Manager::render_icon($item['item_icon'], ['aria-hidden' => 'true']); ?>
                                </span>
                            <?php endif; ?>
                            <span class="contact-info-card__icon-list-text"><?php echo esc_html($item['item_text']); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php if ('yes' === $settings['show_cta_button'] && !empty($settings['cta_button_text'])) : ?>
            <?php
            $button_url = !empty($settings['cta_button_link']['url']) ? $settings['cta_button_link']['url'] : '#';
            $button_target = !empty($settings['cta_button_link']['is_external']) ? ' target="_blank"' : '';
            $button_nofollow = !empty($settings['cta_button_link']['nofollow']) ? ' rel="nofollow"' : '';
            ?>
            <a href="<?php echo esc_url($button_url); ?>" 
               class="contact-info-card__button"
               <?php echo $button_target . $button_nofollow; ?>>
                <?php echo esc_html($settings['cta_button_text']); ?>
                <?php 
                if (!empty($settings['cta_button_icon']['value'])) : 
                    \Elementor\Icons_Manager::render_icon($settings['cta_button_icon'], ['aria-hidden' => 'true']);
                endif; 
                ?>
            </a>
        <?php endif; ?>
    </div>
    <?php
} 