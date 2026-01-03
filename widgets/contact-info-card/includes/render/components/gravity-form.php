<?php
/**
 * Gravity Form Component for Contact Info Card Widget
 * 
 * Renders the gravity form section.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Renders the gravity form section.
 * 
 * @param array $settings Widget settings
 */
function render_gravity_form($settings) {
    ?>
    <section class="contact-info-card__gravity-form" role="region" aria-labelledby="gravity-form-heading" aria-label="<?php echo esc_attr__('Contactformulier om een bericht te sturen', 'promen-elementor-widgets'); ?>">
        <h2 id="gravity-form-heading" class="sr-only"><?php echo esc_html__('Contact Form', 'promen-elementor-widgets'); ?></h2>
        <?php if (!empty($settings['gravity_form_shortcode'])) : 
            echo do_shortcode($settings['gravity_form_shortcode']);
        endif; ?>
    </section>
    <?php
} 