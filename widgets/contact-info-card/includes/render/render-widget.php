<?php
/**
 * Render Widget for Contact Info Card Widget
 * 
 * Handles the rendering of the contact info card widget on the frontend.
 * Uses modular components for better maintainability.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include component files
require_once(__DIR__ . '/components/main-content.php');
require_once(__DIR__ . '/components/employee-info.php');
require_once(__DIR__ . '/components/gravity-form.php');
require_once(__DIR__ . '/components/custom-form.php');
// Add additional component imports here as needed

/**
 * Renders the combined layout.
 * 
 * @param array $settings Widget settings
 */
function render_combined_layout($settings) {
    ?>
    <div class="contact-info-card__content-wrapper">
        <div class="contact-info-card__left-column">
            <?php
            // Render main content
            render_main_content($settings);
            
            // Render employee info inside a white box within the main content area
            if (isset($settings['right_side_content_type']) && $settings['right_side_content_type'] === 'combined_layout') {
                ?>
                <div id="employee-contact-info" class="contact-info-card__employee-info-wrapper">
                    <?php render_employee_info($settings); ?>
                </div>
                <?php
            }
            ?>
        </div>
        
        <div id="contact-form" class="contact-info-card__right-column">
            <?php
            // Render gravity form for combined layout
            if (isset($settings['show_gravity_form']) && 'yes' === $settings['show_gravity_form'] && 
                isset($settings['right_side_content_type']) && $settings['right_side_content_type'] === 'combined_layout' &&
                !empty($settings['gravity_form_shortcode'])) {
                render_gravity_form($settings);
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * Render the contact info card widget on the frontend.
 * 
 * @param Contact_Info_Card_Widget $widget The widget instance
 */
function render_contact_info_card_widget($widget) {
    $settings = $widget->get_settings_for_display();
    
    // Container classes
    $container_classes = ['contact-info-card'];
    
    // Add position class based on content type
    if (isset($settings['right_side_content_type'])) {
        if ($settings['right_side_content_type'] === 'none') {
            $container_classes[] = 'no-right-content';
        } elseif ($settings['right_side_content_type'] === 'employee_info') {
            $container_classes[] = 'employee-position-' . ($settings['employee_info_position'] ?? 'right');
        } elseif ($settings['right_side_content_type'] === 'gravity_form') {
            $container_classes[] = 'form-position-' . ($settings['form_position'] ?? 'right');
        } elseif ($settings['right_side_content_type'] === 'custom_form') {
            $container_classes[] = 'form-position-' . ($settings['custom_form_position'] ?? 'right');
        } elseif ($settings['right_side_content_type'] === 'combined_layout') {
            $container_classes[] = 'combined-layout';
            
            // Add ratio class
            if (!empty($settings['combined_layout_ratio'])) {
                $ratio = str_replace('_', '-', $settings['combined_layout_ratio']);
                $container_classes[] = 'ratio-' . $ratio;
            }
        }
    }
    ?>
    
    <!-- Skip Links for Accessibility -->
    <nav class="skip-links" aria-label="<?php echo esc_attr__('Navigatie om direct naar de hoofdinhoud te gaan', 'promen-elementor-widgets'); ?>">
        <a href="#contact-info-main" class="skip-link"><?php echo esc_html__('Sla over naar inhoud', 'promen-elementor-widgets'); ?></a>
        <?php if (isset($settings['right_side_content_type']) && $settings['right_side_content_type'] !== 'none' && in_array($settings['right_side_content_type'], ['employee_info', 'combined_layout'])) : ?>
            <a href="#employee-contact-info" class="skip-link"><?php echo esc_html__('Sla over naar inhoud', 'promen-elementor-widgets'); ?></a>
        <?php endif; ?>
        <?php if (isset($settings['right_side_content_type']) && $settings['right_side_content_type'] !== 'none' && in_array($settings['right_side_content_type'], ['gravity_form', 'custom_form', 'combined_layout'])) : ?>
            <a href="#contact-form" class="skip-link"><?php echo esc_html__('Sla over naar inhoud', 'promen-elementor-widgets'); ?></a>
        <?php endif; ?>
    </nav>
    
    <div class="<?php echo esc_attr(implode(' ', $container_classes)); ?>">
        <?php if (isset($settings['right_side_content_type']) && $settings['right_side_content_type'] === 'combined_layout') : ?>
            <div id="contact-info-main">
                <?php render_combined_layout($settings); ?>
            </div>
        <?php else : ?>
            <div id="contact-info-main">
                <?php render_main_content($settings); ?>
            </div>
        <?php endif; ?>
        
        <?php 
        // Handle employee info section (only if not 'none')
        if (isset($settings['right_side_content_type']) && $settings['right_side_content_type'] === 'employee_info') : ?>
            <div id="employee-contact-info">
                <?php render_employee_info($settings); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($settings['right_side_content_type']) && $settings['right_side_content_type'] === 'gravity_form' && isset($settings['show_gravity_form']) && 'yes' === $settings['show_gravity_form']) : ?>
            <div id="contact-form">
                <?php render_gravity_form($settings); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($settings['right_side_content_type']) && $settings['right_side_content_type'] === 'custom_form' && isset($settings['show_custom_form']) && 'yes' === $settings['show_custom_form']) : ?>
            <div id="contact-form">
                <?php render_custom_form($settings); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
} 