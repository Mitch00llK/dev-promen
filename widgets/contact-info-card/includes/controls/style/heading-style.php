<?php
/**
 * Heading Style Controls for Contact Info Card Widget
 * 
 * Handles the registration of heading style controls for the contact info card widget.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register heading style controls for the contact info card widget.
 * 
 * @param Contact_Info_Card_Widget $widget The widget instance
 */
function register_heading_style_controls($widget) {
    // Heading Style Section
    $widget->start_controls_section(
        'section_heading_style',
        [
            'label' => esc_html__('Heading Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'heading!' => '',
                'show_heading' => 'yes',
            ],
        ]
    );

    // Regular title styling (when split title is not used)
    $widget->add_control(
        'heading_color',
        [
            'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
                '{{WRAPPER}} .promen-title' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'split_title!' => 'yes',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'heading_typography',
            'label' => esc_html__('Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .promen-title',
            'condition' => [
                'split_title!' => 'yes',
            ],
        ]
    );

    // Title Part 1 Styling
    $widget->add_control(
        'title_part1_heading',
        [
            'label' => esc_html__('Title Part 1 Style', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'split_title' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'title_part1_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
                '{{WRAPPER}} .promen-title-part-1' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'split_title' => 'yes',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_part1_typography',
            'label' => esc_html__('Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .promen-title-part-1',
            'condition' => [
                'split_title' => 'yes',
            ],
        ]
    );

    // Title Part 2 Styling
    $widget->add_control(
        'title_part2_heading',
        [
            'label' => esc_html__('Title Part 2 Style', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'split_title' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'title_part2_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#E89C3E',
            'selectors' => [
                '{{WRAPPER}} .promen-title-part-2' => 'color: {{VALUE}};',
            ],
            'condition' => [
                'split_title' => 'yes',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_part2_typography',
            'label' => esc_html__('Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .promen-title-part-2',
            'condition' => [
                'split_title' => 'yes',
            ],
        ]
    );

    $widget->end_controls_section();
} 