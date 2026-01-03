<?php
/**
 * Carousel Section Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Team_Members_Carousel_Carousel_Controls {
    protected function register_carousel_controls() {
        $this->start_controls_section(
            'section_carousel_settings',
            [
                'label' => esc_html__('Carousel Settings', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_responsive_control(
            'cards_per_view',
            [
                'label' => esc_html__('Cards Per View', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ],
                'devices' => ['desktop', 'tablet', 'mobile'],
                'desktop_default' => '4',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 10000,
                'step' => 500,
                'default' => 3000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => esc_html__('Infinite Loop', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Enable infinite loop. Note: Loop only works when you have more team members than the maximum cards per view setting.', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Animation Speed', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 3000,
                'step' => 100,
                'default' => 500,
            ]
        );

        $this->add_control(
            'centered_slides',
            [
                'label' => esc_html__('Centered Slides', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Enable to center the active slide', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'slide_to_clicked',
            [
                'label' => esc_html__('Slide to Clicked', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Enable to navigate to clicked slide', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Enable to show pagination dots', 'promen-elementor-widgets'),
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => esc_html__('Pagination Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-members-carousel .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'active_slide_scale',
            [
                'label' => esc_html__('Active Slide Scale', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 1,
                        'max' => 1.5,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 1.05,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-members-carousel .swiper-slide-active' => 'transform: scale({{SIZE}});',
                ],
                'condition' => [
                    'centered_slides' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'inactive_slide_opacity',
            [
                'label' => esc_html__('Inactive Slide Opacity', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => [''],
                'range' => [
                    '' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => '',
                    'size' => 0.7,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-members-carousel .swiper-slide' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .team-members-carousel .swiper-slide-active' => 'opacity: 1;',
                ],
                'condition' => [
                    'centered_slides' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'slide_max_width',
            [
                'label' => esc_html__('Slide Max Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                        'step' => 10,
                    ],
                    'rem' => [
                        'min' => 6,
                        'max' => 30,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 18.75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .team-members-carousel .swiper-slide' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }
} 