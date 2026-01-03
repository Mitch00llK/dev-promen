<?php
/**
 * Layout Section Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Team_Members_Carousel_Layout_Controls {
    protected function register_layout_controls() {
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'left_offset',
            [
                'label' => esc_html__('Left Offset', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 0,
                        'max' => 30,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-members-carousel-container' => 'padding-left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'enable_right_overflow',
            [
                'label' => esc_html__('Enable Right Overflow', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'gradient_overlay',
            [
                'label' => esc_html__('Right Side Gradient Overlay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Add a gradient overlay to the right side of the carousel, helping to indicate there is more content to scroll.', 'promen-elementor-widgets'),
            ]
        );
        
        $this->add_control(
            'gradient_intensity',
            [
                'label' => esc_html__('Gradient Intensity', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'medium',
                'options' => [
                    'light' => esc_html__('Light', 'promen-elementor-widgets'),
                    'medium' => esc_html__('Medium', 'promen-elementor-widgets'),
                    'strong' => esc_html__('Strong', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'gradient_overlay' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'gradient_width',
            [
                'label' => esc_html__('Gradient Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors' => [
                    '{{WRAPPER}} .carousel-gradient-overlay' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'gradient_overlay' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }
} 