<?php
/**
 * Style Section Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Hero_Slider_Style_Controls {
    protected function register_style_controls() {
        // Background Image Style
        $this->start_controls_section(
            'section_background_style',
            [
                'label' => esc_html__('Background Image', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 1200,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 10,
                        'max' => 75,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-slide' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Overlay Style
        $this->start_controls_section(
            'section_overlay_style',
            [
                'label' => esc_html__('Overlay', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'overlay_type',
            [
                'label' => esc_html__('Overlay Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                    'color' => esc_html__('Color', 'promen-elementor-widgets'),
                    'gradient' => esc_html__('Gradient', 'promen-elementor-widgets'),
                ],
            ]
        );

        $this->add_control(
            'overlay_color',
            [
                'label' => esc_html__('Overlay Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.3)',
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-overlay' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'overlay_type' => 'color',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'overlay_gradient',
                'types' => ['gradient'],
                'selector' => '{{WRAPPER}} .hero-slide-overlay',
                'condition' => [
                    'overlay_type' => 'gradient',
                ],
            ]
        );

        $this->end_controls_section();

        // Tilted Divider Style
        $this->start_controls_section(
            'section_tilted_divider_style',
            [
                'label' => esc_html__('Tilted Divider', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'show_tilted_divider',
            [
                'label' => esc_html__('Show Tilted Divider', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'prefix_class' => 'tilted-divider-',
            ]
        );

        $this->add_control(
            'divider_position',
            [
                'label' => esc_html__('Divider Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'top' => esc_html__('Top', 'promen-elementor-widgets'),
                    'bottom' => esc_html__('Bottom', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
                'prefix_class' => 'divider-position-',
            ]
        );

        $this->add_control(
            'divider_tilt_angle',
            [
                'label' => esc_html__('Tilt Angle', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['deg'],
                'range' => [
                    'deg' => [
                        'min' => -10,
                        'max' => 10,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'deg',
                    'size' => 3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-tilted-divider' => 'transform: skewY({{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'divider_height',
            [
                'label' => esc_html__('Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 0.5,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 0.5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}} .hero-tilted-divider' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f5f5f5',
                'selectors' => [
                    '{{WRAPPER}} .hero-tilted-divider' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Content Box Style
        $this->start_controls_section(
            'section_content_box_style',
            [
                'label' => esc_html__('Content Box', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'content_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-content-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-content-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0.5',
                    'right' => '0.5',
                    'bottom' => '0.5',
                    'left' => '0.5',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .hero-slide-content-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '2',
                    'right' => '2',
                    'bottom' => '2',
                    'left' => '2',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .hero-slide-content-wrapper',
                'fields_options' => [
                    'box_shadow_type' => [
                        'default' => 'yes',
                    ],
                    'box_shadow' => [
                        'default' => [
                            'horizontal' => 0,
                            'vertical' => 4,
                            'blur' => 10,
                            'spread' => 0,
                            'color' => 'rgba(0, 0, 0, 0.1)',
                        ],
                    ],
                ],
            ]
        );

        $this->end_controls_section();

        // Button Styles
        $this->start_controls_section(
            'section_buttons_style',
            [
                'label' => esc_html__('Buttons', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_1_heading',
            [
                'label' => esc_html__('Primary Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_1_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_1_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00a0df',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-1' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_1_hover_text_color',
            [
                'label' => esc_html__('Hover Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-1:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_1_hover_background_color',
            [
                'label' => esc_html__('Hover Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0082b3',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-1:hover' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_heading',
            [
                'label' => esc_html__('Secondary Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'button_2_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00a0df',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-2' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00a0df',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-2' => 'border-color: {{VALUE}}; border-width: 2px; border-style: solid;',
                ],
            ]
        );

        $this->add_control(
            'button_2_hover_text_color',
            [
                'label' => esc_html__('Hover Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-2:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_hover_background_color',
            [
                'label' => esc_html__('Hover Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00a0df',
                'selectors' => [
                    '{{WRAPPER}} .hero-button-2:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Navigation Style
        $this->start_controls_section(
            'section_navigation_style',
            [
                'label' => esc_html__('Navigation', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_type' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => esc_html__('Arrows Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-arrow' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_background_color',
            [
                'label' => esc_html__('Arrows Background', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0a2240',
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-arrow' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => esc_html__('Pagination Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#cccccc',
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label' => esc_html__('Pagination Active Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#00a0df',
                'selectors' => [
                    '{{WRAPPER}} .hero-slider-pagination .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }
} 