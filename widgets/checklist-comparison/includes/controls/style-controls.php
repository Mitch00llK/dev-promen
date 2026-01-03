<?php
/**
 * Checklist Comparison Widget Style Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Checklist_Comparison_Style_Controls {

    /**
     * Register style controls for the widget
     */
    public static function register_controls($widget) {
        self::register_container_style_section($widget);
        self::register_headings_style_section($widget);
        self::register_checklist_items_style_section($widget);
        self::register_checklist_icon_style_section($widget);
    }

    /**
     * Register container style section
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
                    '{{WRAPPER}} .promen-checklist-comparison' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'selector' => '{{WRAPPER}} .promen-checklist-comparison',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'selector' => '{{WRAPPER}} .promen-checklist-comparison',
            ]
        );

        $widget->add_control(
            'container_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#F0D8A7',
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register headings style section
     */
    private static function register_headings_style_section($widget) {
        $widget->start_controls_section(
            'section_headings_style',
            [
                'label' => esc_html__('Headings', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .promen-checklist-comparison__heading',
            ]
        );

        $widget->add_responsive_control(
            'heading_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '1.5',
                    'left' => '0',
                    'unit' => 'rem',
                    'isLinked' => false,
                ],
            ]
        );

        $widget->add_responsive_control(
            'heading_text_align',
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
                    '{{WRAPPER}} .promen-checklist-comparison__heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register checklist items style section
     */
    private static function register_checklist_items_style_section($widget) {
        $widget->start_controls_section(
            'section_checklist_items_style',
            [
                'label' => esc_html__('Checklist Items', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'item_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .promen-checklist-comparison__item-text',
            ]
        );

        $widget->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'item_border_width',
            [
                'label' => esc_html__('Border Bottom Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'item_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item' => 'border-bottom-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'item_border_style',
            [
                'label' => esc_html__('Border Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                    'solid' => esc_html__('Solid', 'promen-elementor-widgets'),
                    'dashed' => esc_html__('Dashed', 'promen-elementor-widgets'),
                    'dotted' => esc_html__('Dotted', 'promen-elementor-widgets'),
                    'double' => esc_html__('Double', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item' => 'border-bottom-style: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register checklist icon style section
     */
    private static function register_checklist_icon_style_section($widget) {
        $widget->start_controls_section(
            'section_checklist_icon_style',
            [
                'label' => esc_html__('Checklist Icon', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0B1A37',
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .promen-checklist-comparison__item-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 60,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 4,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 4,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .promen-checklist-comparison__item-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 3,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 3,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Vertical Alignment', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'promen-elementor-widgets'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'promen-elementor-widgets'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'promen-elementor-widgets'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item-icon' => 'align-self: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }
} 