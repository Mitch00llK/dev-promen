<?php
/**
 * Layout Style Controls for Contact Info Card Widget
 * 
 * Handles the layout settings including gaps between containers.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register layout style controls for the contact info card widget.
 * 
 * @param Contact_Info_Card_Widget $widget The widget instance
 */
function register_layout_style_controls($widget) {
    $widget->start_controls_section(
        'section_layout_style',
        [
            'label' => esc_html__('Layout Settings', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Layout Direction
    $widget->add_responsive_control(
        'layout_direction',
        [
            'label' => esc_html__('Layout Direction', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'row',
            'options' => [
                'row' => esc_html__('Row', 'promen-elementor-widgets'),
                'column' => esc_html__('Column', 'promen-elementor-widgets'),
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card' => 'display: flex; flex-direction: {{VALUE}};',
                '{{WRAPPER}} .contact-info-card__content-wrapper' => 'display: flex; flex-direction: {{VALUE}};',
            ],
            'condition' => [
                'right_side_content_type!' => 'combined_layout',
            ],
        ]
    );

    // Container Gap
    $widget->add_responsive_control(
        'container_gap',
        [
            'label' => esc_html__('Container Gap', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem', '%'],
            'default' => [
                'size' => 8,
                'unit' => 'rem',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card' => 'gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .contact-info-card__main-content' => 'gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .contact-info-card__employee-info-block' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .employee-position-left .contact-info-card__employee-info-block' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
                '{{WRAPPER}} .contact-info-card__content-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Container Widths Heading
    $widget->add_control(
        'container_widths_heading',
        [
            'label' => esc_html__('Container Widths', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'layout_direction' => 'row',
                'right_side_content_type!' => 'combined_layout',
            ],
        ]
    );

    // Main Content Width
    $widget->add_responsive_control(
        'main_content_width',
        [
            'label' => esc_html__('Main Content Width', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'vw'],
            'default' => [
                'size' => 60,
                'unit' => '%',
            ],
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 90,
                    'step' => 1,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 1000,
                    'step' => 10,
                ],
                'vw' => [
                    'min' => 10,
                    'max' => 90,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__main-content' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .contact-info-card__content-wrapper .contact-info-card__left-column' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout_direction' => 'row',
                'right_side_content_type!' => 'combined_layout',
            ],
        ]
    );

    // Employee Info Width
    $widget->add_responsive_control(
        'employee_info_width',
        [
            'label' => esc_html__('Employee Info Width', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'vw'],
            'default' => [
                'size' => 30,
                'unit' => '%',
            ],
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 90,
                    'step' => 1,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 1000,
                    'step' => 10,
                ],
                'vw' => [
                    'min' => 10,
                    'max' => 90,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__employee-info-block' => 'width: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .contact-info-card__content-wrapper .contact-info-card__right-column' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout_direction' => 'row',
                'right_side_content_type!' => 'combined_layout',
            ],
        ]
    );

    // Combined Layout Width Ratio (only for combined layout)
    $widget->add_control(
        'combined_width_ratio_heading',
        [
            'label' => esc_html__('Combined Layout Width Ratio', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'right_side_content_type' => 'combined_layout',
            ],
        ]
    );

    $widget->add_responsive_control(
        'combined_left_column_width',
        [
            'label' => esc_html__('Left Column Width', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'vw'],
            'default' => [
                'size' => 40,
                'unit' => '%',
            ],
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 90,
                    'step' => 1,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 1000,
                    'step' => 10,
                ],
                'vw' => [
                    'min' => 10,
                    'max' => 90,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__content-wrapper .contact-info-card__left-column' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'right_side_content_type' => 'combined_layout',
            ],
        ]
    );

    $widget->add_responsive_control(
        'combined_right_column_width',
        [
            'label' => esc_html__('Right Column Width', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'vw'],
            'default' => [
                'size' => 55,
                'unit' => '%',
            ],
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 90,
                    'step' => 1,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 1000,
                    'step' => 10,
                ],
                'vw' => [
                    'min' => 10,
                    'max' => 90,
                    'step' => 1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__content-wrapper .contact-info-card__right-column' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'right_side_content_type' => 'combined_layout',
            ],
        ]
    );

    // Content Vertical Spacing
    $widget->add_responsive_control(
        'content_vertical_spacing',
        [
            'label' => esc_html__('Content Vertical Spacing', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'default' => [
                'size' => 2,
                'unit' => 'rem',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 0.1,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .contact-info-card__heading-wrapper' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .contact-info-card__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Flex Alignment
    $widget->add_responsive_control(
        'content_alignment',
        [
            'label' => esc_html__('Content Alignment', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Start', 'promen-elementor-widgets'),
                    'icon' => 'eicon-h-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'promen-elementor-widgets'),
                    'icon' => 'eicon-h-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('End', 'promen-elementor-widgets'),
                    'icon' => 'eicon-h-align-right',
                ],
                'space-between' => [
                    'title' => esc_html__('Space Between', 'promen-elementor-widgets'),
                    'icon' => 'eicon-h-align-stretch',
                ],
            ],
            'default' => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .contact-info-card' => 'justify-content: {{VALUE}};',
                '{{WRAPPER}} .contact-info-card__content-wrapper' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'layout_direction' => 'row',
            ],
        ]
    );

    $widget->end_controls_section();
} 