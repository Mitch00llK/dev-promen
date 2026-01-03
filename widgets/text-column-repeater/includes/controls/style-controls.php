<?php
/**
 * Text Column Repeater Widget Style Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Text_Column_Repeater_Style_Controls {

    /**
     * Register style controls for the widget
     */
    public static function register_controls($widget) {
        self::register_container_style_section($widget);
        self::register_heading_style_section($widget);
        self::register_subtitle_style_section($widget);
        self::register_tool_items_style_section($widget);
    }

    /**
     * Register container style section controls
     */
    private static function register_container_style_section($widget) {
        $widget->start_controls_section(
            'section_container_style',
            [
                'label' => esc_html__('Container', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'container_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'container_background',
                'label' => esc_html__('Background', 'promen-elementor-widgets'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .text-column-repeater',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater',
            ]
        );

        $widget->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register heading style section controls
     */
    private static function register_heading_style_section($widget) {
        $widget->start_controls_section(
            'section_heading_style',
            [
                'label' => esc_html__('Heading', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'heading_alignment',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'heading_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater__heading',
                'condition' => [
                    'enable_split_heading!' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__heading' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_split_heading!' => 'yes',
                ],
            ]
        );

        // Split heading styles
        $widget->add_control(
            'split_heading_style_heading',
            [
                'label' => esc_html__('Split Heading Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'split_before_typography',
                'label' => esc_html__('Before Text Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater__heading .light',
                'condition' => [
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'split_before_color',
            [
                'label' => esc_html__('Before Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__heading .light' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'split_after_typography',
                'label' => esc_html__('After Text Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater__heading .bold',
                'condition' => [
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'split_after_color',
            [
                'label' => esc_html__('After Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__heading .bold' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'split_spacing',
            [
                'label' => esc_html__('Split Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__heading .light' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register subtitle style section controls
     */
    private static function register_subtitle_style_section($widget) {
        $widget->start_controls_section(
            'section_subtitle_style',
            [
                'label' => esc_html__('Subtitle', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_heading' => 'yes',
                    'show_subtitle' => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'subtitle_alignment',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__subtitle' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'subtitle_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'subtitle_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater__subtitle',
            ]
        );

        $widget->add_control(
            'subtitle_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__subtitle' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'subtitle_max_width',
            [
                'label' => esc_html__('Max Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__subtitle' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register tool items style section controls
     */
    private static function register_tool_items_style_section($widget) {
        $widget->start_controls_section(
            'section_tool_items_style',
            [
                'label' => esc_html__('Tool Items', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'tool_items_spacing',
            [
                'label' => esc_html__('Items Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
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
                    '{{WRAPPER}} .text-column-repeater__grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'tool_items_margin_top',
            [
                'label' => esc_html__('Items Top Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
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
                ],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__grid' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Tool Item Box Style
        $widget->add_control(
            'tool_item_box_heading',
            [
                'label' => esc_html__('Tool Item Box', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'tool_item_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'tool_item_background',
                'label' => esc_html__('Background', 'promen-elementor-widgets'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .text-column-repeater__item',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tool_item_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater__item',
            ]
        );

        $widget->add_responsive_control(
            'tool_item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'tool_item_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater__item',
            ]
        );

        // Tool Title Style
        $widget->add_control(
            'tool_title_style_heading',
            [
                'label' => esc_html__('Tool Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'tool_title_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tool_title_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater__item-title',
            ]
        );

        $widget->add_control(
            'tool_title_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__item-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Tool Description Style
        $widget->add_control(
            'tool_description_style_heading',
            [
                'label' => esc_html__('Tool Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'tool_description_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__item-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tool_description_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .text-column-repeater__item-description',
            ]
        );

        $widget->add_control(
            'tool_description_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .text-column-repeater__item-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }
} 