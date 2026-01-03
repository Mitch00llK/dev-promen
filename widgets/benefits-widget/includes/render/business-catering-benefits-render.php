<?php
/**
 * Business Catering Benefits Widget Render
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render Business Catering Benefits Widget
 */
function render_business_catering_benefits($widget) {
    $settings = $widget->get_settings_for_display();
    ?>
    <div class="business-catering-benefits-container">
        <div class="business-catering-benefits-header">
            <?php if ('yes' === $settings['show_title']) : ?>
                <?php
                $title_tag = $settings['title_tag'];
                echo "<{$title_tag} class='business-catering-benefits-title'>";
                ?>
                    <span class="title-part-1"><?php echo esc_html($settings['title_part_1']); ?></span>
                    <span class="title-part-2"><?php echo esc_html($settings['title_part_2']); ?></span>
                <?php echo "</{$title_tag}>"; ?>
            <?php endif; ?>

            <?php if ('yes' === $settings['show_description']) : ?>
                <p class="business-catering-benefits-description">
                    <?php echo esc_html($settings['description']); ?>
                </p>
            <?php endif; ?>
        </div>

        <div class="business-catering-benefits-grid">
            <?php
            foreach ($settings['benefits'] as $benefit) :
                if ('yes' !== $benefit['show_benefit']) continue;
            ?>
                <div class="benefit-card">
                    <?php if (!empty($benefit['benefit_icon']['value'])) : ?>
                        <div class="benefit-icon">
                            <?php \Elementor\Icons_Manager::render_icon($benefit['benefit_icon'], ['aria-hidden' => 'true']); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($benefit['benefit_title'])) : ?>
                        <h3 class="benefit-title"><?php echo esc_html($benefit['benefit_title']); ?></h3>
                    <?php endif; ?>

                    <?php if (!empty($benefit['benefit_description'])) : ?>
                        <p class="benefit-description"><?php echo esc_html($benefit['benefit_description']); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
} 