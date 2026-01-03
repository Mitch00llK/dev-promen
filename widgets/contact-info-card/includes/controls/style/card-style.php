<?php
/**
 * Card Style Controls for Contact Info Card Widget
 * 
 * Handles the registration of card style controls for the contact info card widget.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register card style controls for the contact info card widget.
 * 
 * @param Contact_Info_Card_Widget $widget The widget instance
 */
function register_card_style_controls($widget) {
    // Card Style Section
    $widget->start_controls_section(
        'section_card_style',
        [
            'label' => esc_html__('Card Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Card Padding
    $widget->add_responsive_control(
        'card_padding',
        [
            'label' => esc_html__('Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'default' => [
                'top' => '2',
                'right' => '2',
                'bottom' => '2',
                'left' => '2',
                'unit' => 'rem',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    // Card Border Radius
    $widget->add_responsive_control(
        'card_border_radius',
        [
            'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'default' => [
                'top' => '0',
                'right' => '0',
                'bottom' => '0',
                'left' => '0',
                'unit' => 'px',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    // Card Box Shadow
    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'card_box_shadow',
            'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .contact-info-card',
        ]
    );

    $widget->end_controls_section();
} 