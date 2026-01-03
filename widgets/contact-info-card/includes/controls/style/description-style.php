<?php
/**
 * Description Style Controls for Contact Info Card Widget
 * 
 * Handles the styling of the description text in the contact info card widget.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register description style controls for the contact info card widget.
 * 
 * @param Contact_Info_Card_Widget $widget The widget instance
 */
function register_description_style_controls($widget) {
    $widget->start_controls_section(
        'section_description_style',
        [
            'label' => esc_html__('Description', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_description' => 'yes',
            ],
        ]
    );

    // Description Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'description_typography',
            'selector' => '{{WRAPPER}} .contact-info-card__description',
        ]
    );

    // Description Text Color
    $widget->add_control(
        'description_color',
        [
            'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__description' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Description Margin
    $widget->add_responsive_control(
        'description_margin',
        [
            'label' => esc_html__('Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();
} 