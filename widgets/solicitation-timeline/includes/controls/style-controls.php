<?php
/**
 * Solicitation Timeline Widget Style Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Solicitation_Timeline_Style_Controls {

    /**
     * Register style controls for the widget
     */
    public static function register_controls($widget) {
        self::register_layout_section($widget);
        self::register_heading_style_section($widget);
        self::register_timeline_style_section($widget);
        self::register_step_marker_style_section($widget);
        self::register_step_content_style_section($widget);
        self::register_responsive_style_section($widget);
    }

    /**
     * Register layout section controls
     */
    private static function register_layout_section($widget) {
        $widget->start_controls_section(
            'section_layout_style',
            [
                'label' => esc_html__('Layout', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__('Columns Gap', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
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
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__container' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'column_reverse',
            [
                'label' => esc_html__('Reverse Columns', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__container' => 'flex-direction: row-reverse;',
                ],
                'condition' => [
                    'column_reverse_tablet!' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'column_reverse_tablet',
            [
                'label' => esc_html__('Stack on Tablet', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '(tablet){{WRAPPER}} .solicitation-timeline__container' => 'flex-direction: column;',
                ],
            ]
        );

        $widget->add_responsive_control(
            'text_column_width',
            [
                'label' => esc_html__('Text Column Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
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
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__text-column' => 'flex-basis: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'column_reverse_tablet!' => 'yes',
                ],
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
                'label' => esc_html__('Heading Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'heading_color',
            [
                'label' => esc_html__('Heading Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'heading_split_color',
            [
                'label' => esc_html__('Split Heading Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__heading .bold' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'heading_margin',
            [
                'label' => esc_html__('Heading Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'intro_text_color',
            [
                'label' => esc_html__('Intro Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__intro-text' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_intro_text' => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'intro_text_margin',
            [
                'label' => esc_html__('Intro Text Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__intro-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_intro_text' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register timeline style section controls
     */
    private static function register_timeline_style_section($widget) {
        $widget->start_controls_section(
            'section_timeline_style',
            [
                'label' => esc_html__('Timeline Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'timeline_spacing',
            [
                'label' => esc_html__('Timeline Spacing', 'promen-elementor-widgets'),
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
                'default' => [
                    'unit' => 'rem',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__step:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'timeline_line_color',
            [
                'label' => esc_html__('Timeline Line Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e6e6e6',
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__line' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'timeline_line_width',
            [
                'label' => esc_html__('Timeline Line Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__line' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'timeline_padding',
            [
                'label' => esc_html__('Timeline Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register step marker style section controls
     */
    private static function register_step_marker_style_section($widget) {
        $widget->start_controls_section(
            'section_step_marker_style',
            [
                'label' => esc_html__('Step Marker Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'marker_size',
            [
                'label' => esc_html__('Marker Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__marker' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'marker_background_color',
            [
                'label' => esc_html__('Marker Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#F5A623',
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__marker' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'marker_border_color',
            [
                'label' => esc_html__('Marker Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__marker' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'marker_border_width',
            [
                'label' => esc_html__('Marker Border Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__marker' => 'border-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register step content style section controls
     */
    private static function register_step_content_style_section($widget) {
        $widget->start_controls_section(
            'section_step_content_style',
            [
                'label' => esc_html__('Step Content Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'step_number_color',
            [
                'label' => esc_html__('Step Number Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__step-number' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'step_number_spacing',
            [
                'label' => esc_html__('Step Number Spacing', 'promen-elementor-widgets'),
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
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__step-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'step_title_color',
            [
                'label' => esc_html__('Step Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__step-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'step_title_spacing',
            [
                'label' => esc_html__('Step Title Spacing', 'promen-elementor-widgets'),
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
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__step-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'step_description_color',
            [
                'label' => esc_html__('Step Description Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__step-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'step_content_padding',
            [
                'label' => esc_html__('Step Content Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__step-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register responsive style section controls
     */
    private static function register_responsive_style_section($widget) {
        $widget->start_controls_section(
            'section_responsive_style',
            [
                'label' => esc_html__('Responsive Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'timeline_alignment',
            [
                'label' => esc_html__('Timeline Alignment', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .solicitation-timeline' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'content_offset',
            [
                'label' => esc_html__('Content Offset', 'promen-elementor-widgets'),
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
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .solicitation-timeline__step-content' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'timeline_alignment' => 'left',
                ],
            ]
        );

        $widget->end_controls_section();
    }
} 