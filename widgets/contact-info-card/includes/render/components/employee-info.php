<?php
/**
 * Employee Info Component for Contact Info Card Widget
 * 
 * Renders the employee information section with image, name, and contact details.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Renders the employee information section.
 * 
 * @param array $settings Widget settings
 */
function render_employee_info($settings) {
    ?>
    <div class="contact-info-card__employee-info-block">
        <div class="contact-info-card__employee-info">
        <?php if (isset($settings['show_employee_image']) && 'yes' === $settings['show_employee_image'] && !empty($settings['employee_image']['url'])) : ?>
                <figure class="contact-info-card__employee-image">
                    <img src="<?php echo esc_url($settings['employee_image']['url']); ?>" 
                         alt="<?php echo esc_attr($settings['employee_name'] ?? __('Employee photo', 'promen-elementor-widgets')); ?>"
                         width="60" 
                         height="60">
                </figure>
            <?php endif; ?>
            <?php if (isset($settings['show_contact_heading']) && 'yes' === $settings['show_contact_heading'] && !empty($settings['contact_heading'])) : ?>
                <?php
                $contact_heading_tag = !empty($settings['contact_heading_tag']) ? $settings['contact_heading_tag'] : 'h3';
                ?>
                <<?php echo esc_attr($contact_heading_tag); ?> class="contact-info-card__contact-heading"><?php echo esc_html($settings['contact_heading']); ?></<?php echo esc_attr($contact_heading_tag); ?>>
            <?php endif; ?>
            
            <?php if (isset($settings['show_employee_name']) && 'yes' === $settings['show_employee_name'] && !empty($settings['employee_name'])) : ?>
                <div class="contact-info-card__employee-name"><?php echo esc_html($settings['employee_name']); ?></div>
            <?php endif; ?>
            
            <div class="contact-info-card__contact-items">
                <?php if (!empty($settings['contact_items']) && is_array($settings['contact_items'])) : ?>
                    <?php foreach ($settings['contact_items'] as $item) : ?>
                        <?php if (!empty($item['contact_value']) && !empty($item['contact_type'])) : ?>
                            <div class="contact-info-card__contact-item contact-info-card__<?php echo esc_attr($item['contact_type']); ?>">
                                <span class="contact-info-card__contact-icon" aria-hidden="true">
                                    <?php if ($item['contact_type'] === 'email') : ?>
                                        <i class="fas fa-envelope"></i>
                                    <?php else : ?>
                                        <i class="fas fa-phone-alt"></i>
                                    <?php endif; ?>
                                </span>
                                <?php if ($item['contact_type'] === 'email') : ?>
                                    <a href="mailto:<?php echo esc_attr($item['contact_value']); ?>">
                                        <?php echo esc_html($item['contact_value']); ?>
                                    </a>
                                <?php else : ?>
                                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $item['contact_value'])); ?>">
                                        <?php echo esc_html($item['contact_value']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
    <?php
} 