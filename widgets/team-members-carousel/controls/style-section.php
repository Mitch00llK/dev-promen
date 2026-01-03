<?php
/**
 * Style Section Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Team_Members_Carousel_Style_Controls {
    protected function register_style_controls() {
        // Card Style Section
        $this->start_controls_section(
            'section_card_style',
            [
                'label' => esc_html__('Card Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_width',
            [
                'label' => esc_html__('Card Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 500,
                        'step' => 10,
                    ],
                    'rem' => [
                        'min' => 12,
                        'max' => 31.25,
                        'step' => 0.5,
                    ],
                    '%' => [
                        'min' => 20,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 18.75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-members-carousel[data-centered="true"] .swiper-slide' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .team-members-carousel:not([data-centered="true"]) .swiper-slide' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'centered_slides' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'card_spacing',
            [
                'label' => esc_html__('Cards Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 6.25,
                        'step' => 0.25,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-members-carousel .swiper-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'card_background',
                'label' => esc_html__('Card Background', 'promen-elementor-widgets'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .member-card',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'card_border',
                'label' => esc_html__('Card Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .member-card',
            ]
        );

        $this->add_responsive_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem'],
                'default' => [
                    'top' => '0.5',
                    'right' => '0.5',
                    'bottom' => '0.5',
                    'left' => '0.5',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .member-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .member-card',
            ]
        );

        $this->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Card Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem', 'em'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '0',
                    'left' => '0',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .member-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Card Content Padding
        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem', 'em'],
                'default' => [
                    'top' => '0.9375',
                    'right' => '0.9375',
                    'bottom' => '0.9375',
                    'left' => '0.9375',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .member-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Hover Animation
        $this->add_control(
            'enable_hover_animation',
            [
                'label' => esc_html__('Enable Hover Animation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'hover_animation_y_offset',
            [
                'label' => esc_html__('Hover Y Offset', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem'],
                'range' => [
                    'px' => [
                        'min' => -50,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => -3,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => -0.3125,
                ],
                'selectors' => [
                    '{{WRAPPER}} .member-card:hover' => 'transform: translateY({{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'enable_hover_animation' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'hover_box_shadow',
            [
                'label' => esc_html__('Hover Box Shadow', 'promen-elementor-widgets'),
                'type' => \Elementor\Group_Control_Box_Shadow::get_type(),
                'selector' => '{{WRAPPER}} .member-card:hover',
                'condition' => [
                    'enable_hover_animation' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Image Style Section
        $this->start_controls_section(
            'section_image_style',
            [
                'label' => esc_html__('Image Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 10,
                    ],
                    'rem' => [
                        'min' => 6.25,
                        'max' => 31.25,
                        'step' => 0.5,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .member-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .member-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .member-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style Section
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_section_title' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_alignment',
            [
                'label' => esc_html__('Title Alignment', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .team-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .team-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'title_display',
            [
                'label' => esc_html__('Title Display', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'inline',
                'options' => [
                    'inline' => esc_html__('Inline', 'promen-elementor-widgets'),
                    'block' => esc_html__('Block', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-title-prefix, {{WRAPPER}} .team-title-suffix' => 'display: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_prefix_transform',
            [
                'label' => esc_html__('Prefix Text Transform', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                    'uppercase' => esc_html__('Uppercase', 'promen-elementor-widgets'),
                    'lowercase' => esc_html__('Lowercase', 'promen-elementor-widgets'),
                    'capitalize' => esc_html__('Capitalize', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-title-prefix' => 'text-transform: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_suffix_transform',
            [
                'label' => esc_html__('Suffix Text Transform', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                    'uppercase' => esc_html__('Uppercase', 'promen-elementor-widgets'),
                    'lowercase' => esc_html__('Lowercase', 'promen-elementor-widgets'),
                    'capitalize' => esc_html__('Capitalize', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-title-suffix' => 'text-transform: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
} 