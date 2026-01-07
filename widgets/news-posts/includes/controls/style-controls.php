<?php
/**
 * Style Controls for News Posts Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_News_Posts_Style_Controls {

    public static function register_controls($widget) {
        self::register_title_style_controls($widget);
        self::register_post_style_controls($widget);
        self::register_button_style_controls($widget);
        self::register_filter_buttons_style_controls($widget);

    }

    protected static function register_title_style_controls($widget) {
        $widget->start_controls_section(
            'section_style_title',
            [
                'label' => esc_html__('Section Title', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'split_title',
            [
                'label' => esc_html__('Split Title Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'title_split_position',
            [
                'label' => esc_html__('Split Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 5,
                'description' => esc_html__('Number of words for the first part of the title', 'promen-elementor-widgets'),
                'condition' => [
                    'split_title' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#05204A',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-title' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'split_title!' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .promen-content-title',
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
                'default' => '#05204A',
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
                'default' => '#54B7D3',
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
                'selector' => '{{WRAPPER}} .promen-title-part-2',
                'condition' => [
                    'split_title' => 'yes',
                ],
            ]
        );

        // Common styling options for both split and non-split titles
        $widget->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-section-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'title_text_align',
            [
                'label' => esc_html__('Alignment', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'promen-elementor-widgets'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'promen-elementor-widgets'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'promen-elementor-widgets'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-section-title-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    protected static function register_post_style_controls($widget) {
        $widget->start_controls_section(
            'section_style_posts',
            [
                'label' => esc_html__('Posts', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'card_background_color',
            [
                'label' => esc_html__('Card Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#F0F8FB',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-card' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $widget->add_control(
            'card_border_radius',
            [
                'label' => esc_html__('Card Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .promen-content-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
                ],
                'default' => [
                    'top' => '8',
                    'right' => '8',
                    'bottom' => '8',
                    'left' => '8',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $widget->add_control(
            'card_padding',
            [
                'label' => esc_html__('Card Content Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '24',
                    'right' => '24',
                    'bottom' => '24',
                    'left' => '24',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $widget->add_control(
            'post_title_color',
            [
                'label' => esc_html__('Post Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#05204A',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-post-title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'post_title_typography',
                'selector' => '{{WRAPPER}} .promen-content-post-title',
            ]
        );

        $widget->end_controls_section();
    }

    protected static function register_button_style_controls($widget) {
        $widget->start_controls_section(
            'section_style_button',
            [
                'label' => esc_html__('Buttons', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Header Button Styles
        $widget->add_control(
            'header_button_heading',
            [
                'label' => esc_html__('Header Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_header_button' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'header_button_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-header-button' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_header_button' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'header_button_background',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#54B7D3',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-header-button' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'show_header_button' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'header_button_typography',
                'selector' => '{{WRAPPER}} .promen-content-header-button',
                'condition' => [
                    'show_header_button' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'header_button_icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-header-button .button-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .promen-content-header-button .button-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_header_button' => 'yes',
                    'header_button_icon[value]!' => '',
                ],
            ]
        );

        $widget->add_responsive_control(
            'header_button_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-header-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_header_button' => 'yes',
                ],
            ]
        );

        // Read More Button Styles
        $widget->add_control(
            'read_more_heading',
            [
                'label' => esc_html__('Read More Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'read_more_icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-read-more .button-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .promen-content-read-more .button-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'read_more_icon[value]!' => '',
                ],
            ]
        );

        $widget->add_control(
            'read_more_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-read-more' => 'color: {{VALUE}}',
                ],
            ]
        );

        $widget->add_control(
            'read_more_background',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#54B7D3',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-read-more' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'read_more_typography',
                'selector' => '{{WRAPPER}} .promen-content-read-more',
            ]
        );

        $widget->add_responsive_control(
            'read_more_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Footer Button Styles
        $widget->add_control(
            'footer_button_heading',
            [
                'label' => esc_html__('Footer Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_footer_button' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'footer_button_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-footer-button' => 'color: {{VALUE}}',
                ],
                'condition' => [
                    'show_footer_button' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'footer_button_background',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#54B7D3',
                'selectors' => [
                    '{{WRAPPER}} .promen-content-footer-button' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'show_footer_button' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'footer_button_typography',
                'selector' => '{{WRAPPER}} .promen-content-footer-button',
                'condition' => [
                    'show_footer_button' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'footer_button_icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-footer-button .button-icon-before' => 'margin-right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .promen-content-footer-button .button-icon-after' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_footer_button' => 'yes',
                    'footer_button_icon[value]!' => '',
                ],
            ]
        );

        $widget->add_responsive_control(
            'footer_button_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-footer-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_footer_button' => 'yes',
                ],
            ]
        );

        // Common Button Styles
        $widget->add_control(
            'common_button_heading',
            [
                'label' => esc_html__('All Buttons', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-content-read-more, {{WRAPPER}} .promen-content-header-button, {{WRAPPER}} .promen-content-footer-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '4',
                    'right' => '4',
                    'bottom' => '4',
                    'left' => '4',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .promen-content-read-more, {{WRAPPER}} .promen-content-header-button, {{WRAPPER}} .promen-content-footer-button',
            ]
        );

        $widget->end_controls_section();
    }

    protected static function register_filter_buttons_style_controls($widget) {
        $widget->start_controls_section(
            'section_filter_buttons_style',
            [
                'label' => esc_html__('Filter Buttons', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'post_type' => 'vacatures',
                    'show_vacature_filter' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'filter_typography',
                'selector' => '{{WRAPPER}} .content-filter-button',
            ]
        );

        $widget->add_responsive_control(
            'filter_button_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'default' => [
                    'top' => '8',
                    'right' => '20',
                    'bottom' => '8',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'filter_button_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '0',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'filter_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Active Button Style
        $widget->add_control(
            'filter_active_heading',
            [
                'label' => esc_html__('Active Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'filter_active_background',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#002D72',
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'filter_active_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button.active' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filter_active_border',
                'selector' => '{{WRAPPER}} .content-filter-button.active',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#002D72',
                    ],
                ],
            ]
        );

        // Inactive Button Style
        $widget->add_control(
            'filter_inactive_heading',
            [
                'label' => esc_html__('Inactive Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'filter_inactive_background',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button:not(.active)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'filter_inactive_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#002D72',
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button:not(.active)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filter_inactive_border',
                'selector' => '{{WRAPPER}} .content-filter-button:not(.active)',
                'fields_options' => [
                    'border' => [
                        'default' => 'solid',
                    ],
                    'width' => [
                        'default' => [
                            'top' => '1',
                            'right' => '1',
                            'bottom' => '1',
                            'left' => '1',
                            'isLinked' => true,
                        ],
                    ],
                    'color' => [
                        'default' => '#002D72',
                    ],
                ],
            ]
        );

        // Hover Button Style
        $widget->add_control(
            'filter_hover_heading',
            [
                'label' => esc_html__('Hover Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'filter_hover_background',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button:hover:not(.active)' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'filter_hover_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .content-filter-button:hover:not(.active)' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'filter_hover_border',
                'selector' => '{{WRAPPER}} .content-filter-button:hover:not(.active)',
            ]
        );

        $widget->end_controls_section();
    }


}