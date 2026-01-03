<?php
/**
 * Slider Controls for Services Grid Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Add slider controls to the services grid widget
 * 
 * @param \Elementor\Widget_Base $widget The widget instance
 */
function add_services_grid_slider_controls($widget) {
    // Slider Section
    $widget->start_controls_section(
        'section_slider',
        [
            'label' => esc_html__('Mobile Slider', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'enable_mobile_slider',
        [
            'label' => esc_html__('Enable Mobile Slider', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Enable slider view on mobile devices (< 992px)', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'slider_template',
        [
            'label' => esc_html__('Slider Template', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'default',
            'options' => [
                'default' => esc_html__('Default', 'promen-elementor-widgets'),
                'cards' => esc_html__('Cards', 'promen-elementor-widgets'),
                'fade' => esc_html__('Fade', 'promen-elementor-widgets'),
            ],
            'condition' => [
                'enable_mobile_slider' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'slider_navigation',
        [
            'label' => esc_html__('Show Navigation Arrows', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'enable_mobile_slider' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'slider_pagination',
        [
            'label' => esc_html__('Show Pagination Dots', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'enable_mobile_slider' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'slider_loop',
        [
            'label' => esc_html__('Enable Loop', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'enable_mobile_slider' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'slider_autoplay',
        [
            'label' => esc_html__('Enable Autoplay', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'no',
            'condition' => [
                'enable_mobile_slider' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'slider_autoplay_delay',
        [
            'label' => esc_html__('Autoplay Delay (ms)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1000,
            'max' => 10000,
            'step' => 500,
            'default' => 5000,
            'condition' => [
                'enable_mobile_slider' => 'yes',
                'slider_autoplay' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'slider_effect',
        [
            'label' => esc_html__('Transition Effect', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => [
                'slide' => esc_html__('Slide', 'promen-elementor-widgets'),
                'fade' => esc_html__('Fade', 'promen-elementor-widgets'),
                'cube' => esc_html__('Cube', 'promen-elementor-widgets'),
                'coverflow' => esc_html__('Coverflow', 'promen-elementor-widgets'),
                'flip' => esc_html__('Flip', 'promen-elementor-widgets'),
            ],
            'condition' => [
                'enable_mobile_slider' => 'yes',
                'slider_template' => ['default'],
            ],
        ]
    );

    $widget->add_control(
        'slider_speed',
        [
            'label' => esc_html__('Transition Speed (ms)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 100,
            'max' => 3000,
            'step' => 100,
            'default' => 300,
            'condition' => [
                'enable_mobile_slider' => 'yes',
            ],
        ]
    );

    // Advanced slider settings heading
    $widget->add_control(
        'advanced_slider_heading',
        [
            'label' => esc_html__('Advanced Settings', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => [
                'enable_mobile_slider' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'slides_per_view',
        [
            'label' => esc_html__('Slides Per View', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '1',
            'options' => [
                '1' => '1',
                '1.2' => '1.2',
                '1.5' => '1.5',
                '2' => '2',
                'auto' => esc_html__('Auto', 'promen-elementor-widgets'),
            ],
            'condition' => [
                'enable_mobile_slider' => 'yes',
                'slider_template!' => 'fade',
            ],
        ]
    );

    $widget->add_control(
        'space_between',
        [
            'label' => esc_html__('Space Between Slides (px)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 0,
            'max' => 100,
            'step' => 5,
            'default' => 30,
            'condition' => [
                'enable_mobile_slider' => 'yes',
                'slider_template!' => 'fade',
            ],
        ]
    );

    $widget->add_control(
        'centered_slides',
        [
            'label' => esc_html__('Center Slides', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'no',
            'condition' => [
                'enable_mobile_slider' => 'yes',
                'slider_template' => ['default', 'cards'],
                'slides_per_view!' => '1',
            ],
        ]
    );

    $widget->end_controls_section();

    // Slider Style Section
    $widget->start_controls_section(
        'section_slider_style',
        [
            'label' => esc_html__('Mobile Slider Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'enable_mobile_slider' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'navigation_color',
        [
            'label' => esc_html__('Navigation Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#003B5C',
            'selectors' => [
                '{{WRAPPER}} .services-slider .swiper-button-next, {{WRAPPER}} .services-slider .swiper-button-prev' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'slider_navigation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'navigation_background',
        [
            'label' => esc_html__('Navigation Background', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(255, 255, 255, 0.8)',
            'selectors' => [
                '{{WRAPPER}} .services-slider .swiper-button-next, {{WRAPPER}} .services-slider .swiper-button-prev' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'slider_navigation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'navigation_hover_color',
        [
            'label' => esc_html__('Navigation Hover Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
                '{{WRAPPER}} .services-slider .swiper-button-next:hover, {{WRAPPER}} .services-slider .swiper-button-prev:hover' => 'color: {{VALUE}}',
            ],
            'condition' => [
                'slider_navigation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'navigation_hover_background',
        [
            'label' => esc_html__('Navigation Hover Background', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#003B5C',
            'selectors' => [
                '{{WRAPPER}} .services-slider .swiper-button-next:hover, {{WRAPPER}} .services-slider .swiper-button-prev:hover' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'slider_navigation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'pagination_color',
        [
            'label' => esc_html__('Pagination Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#CCCCCC',
            'selectors' => [
                '{{WRAPPER}} .services-slider .swiper-pagination-bullet' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'slider_pagination' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'pagination_active_color',
        [
            'label' => esc_html__('Pagination Active Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#003B5C',
            'selectors' => [
                '{{WRAPPER}} .services-slider .swiper-pagination-bullet-active' => 'background-color: {{VALUE}}',
            ],
            'condition' => [
                'slider_pagination' => 'yes',
            ],
        ]
    );

    $widget->end_controls_section();
} 