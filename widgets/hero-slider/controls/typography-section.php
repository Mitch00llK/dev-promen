<?php
/**
 * Typography Section Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Hero_Slider_Typography_Controls {
    protected function register_typography_controls() {
        // Title Typography
        $this->start_controls_section(
            'section_title_typography',
            [
                'label' => esc_html__('Title Typography', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .hero-slide-title',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'size' => '2.5',
                            'unit' => 'rem',
                        ],
                    ],
                    'font_weight' => [
                        'default' => '700',
                    ],
                    'line_height' => [
                        'default' => [
                            'size' => '1.2',
                            'unit' => 'em',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0a2240',
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '1',
                    'left' => '0',
                    'unit' => 'rem',
                    'isLinked' => false,
                ],
            ]
        );

        $this->add_control(
            'title_text_shadow',
            [
                'label' => esc_html__('Text Shadow', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-title' => 'text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content Typography
        $this->start_controls_section(
            'section_content_typography',
            [
                'label' => esc_html__('Content Typography', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .hero-slide-content p',
                'fields_options' => [
                    'font_size' => [
                        'default' => [
                            'size' => '1',
                            'unit' => 'rem',
                        ],
                    ],
                    'line_height' => [
                        'default' => [
                            'size' => '1.5',
                            'unit' => 'em',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Content Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-content p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Content Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '2',
                    'left' => '0',
                    'unit' => 'rem',
                    'isLinked' => false,
                ],
            ]
        );

        $this->add_control(
            'content_text_shadow',
            [
                'label' => esc_html__('Text Shadow', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT_SHADOW,
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-content p' => 'text-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
} 