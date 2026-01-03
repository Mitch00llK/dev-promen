<?php
/**
 * Employee Info Block Style Controls for Contact Info Card Widget
 * 
 * Handles the registration of employee info block style controls for the contact info card widget.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register employee info block style controls for the contact info card widget.
 * 
 * @param Contact_Info_Card_Widget $widget The widget instance
 */
function register_employee_info_block_style_controls($widget) {
    // Employee Info Block Style Section
    $widget->start_controls_section(
        'section_employee_info_block_style',
        [
            'label' => esc_html__('Employee Info Block Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'right_side_content_type' => 'employee_info',
            ],
        ]
    );

    $widget->add_control(
        'employee_info_block_background',
        [
            'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__employee-info-block' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'employee_info_block_padding',
        [
            'label' => esc_html__('Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__employee-info-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'employee_info_block_border_radius',
        [
            'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__employee-info-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();
} 