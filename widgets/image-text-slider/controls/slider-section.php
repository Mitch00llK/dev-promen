<?php
/**
 * Slider Section Controls
 * 
 * Controls for the slider behavior, including autoplay, navigation, and pagination.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Image_Text_Slider_Slider_Controls {
    /**
     * Register slider controls
     */
    protected function register_slider_controls() {
        $this->start_controls_section(
            'section_slider',
            [
                'label' => esc_html__('Slider Settings', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
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
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
                'min' => 1000,
                'max' => 15000,
                'step' => 500,
                'condition' => [
                    'autoplay' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
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
            ]
        );

        $this->add_control(
            'transition_speed',
            [
                'label' => esc_html__('Transition Speed', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 500,
                'min' => 100,
                'max' => 5000,
                'step' => 100,
            ]
        );

        $this->add_control(
            'transition_effect',
            [
                'label' => esc_html__('Transition Effect', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'slide' => esc_html__('Slide', 'promen-elementor-widgets'),
                    'fade' => esc_html__('Fade', 'promen-elementor-widgets'),
                    'cube' => esc_html__('Cube', 'promen-elementor-widgets'),
                    'coverflow' => esc_html__('Coverflow', 'promen-elementor-widgets'),
                    'flip' => esc_html__('Flip', 'promen-elementor-widgets'),
                ],
            ]
        );

        $this->add_control(
            'navigation_heading',
            [
                'label' => esc_html__('Navigation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Show Navigation Arrows', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Navigation arrows will appear inside the content container below the buttons', 'promen-elementor-widgets'),
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
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label' => esc_html__('Pagination Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bullets',
                'options' => [
                    'bullets' => esc_html__('Bullets', 'promen-elementor-widgets'),
                    'fraction' => esc_html__('Fraction', 'promen-elementor-widgets'),
                    'progressbar' => esc_html__('Progress Bar', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pagination_position',
            [
                'label' => esc_html__('Pagination Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom-center',
                'options' => [
                    'bottom-left' => esc_html__('Bottom Left', 'promen-elementor-widgets'),
                    'bottom-center' => esc_html__('Bottom Center', 'promen-elementor-widgets'),
                    'bottom-right' => esc_html__('Bottom Right', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'enable_gsap_animations',
            [
                'label' => esc_html__('Enable GSAP Animations', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'animation_duration',
            [
                'label' => esc_html__('Animation Duration (seconds)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.1,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 0.7,
                ],
                'condition' => [
                    'enable_gsap_animations' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }
} 