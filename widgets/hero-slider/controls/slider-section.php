<?php
/**
 * Slider Section Controls
 * 
 * Controls for the slider functionality, including autoplay, transition effects, and speed.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Hero_Slider_Slider_Controls {
    /**
     * Register slider controls
     */
    protected function register_slider_controls() {
        $this->start_controls_section(
            'section_slider',
            [
                'label' => esc_html__('Slider Options', 'elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'display_type' => 'slider',
                ],
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 5000,
                'min' => 1000,
                'max' => 15000,
                'step' => 500,
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'infinite',
            [
                'label' => esc_html__('Infinite Loop', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'transition_speed',
            [
                'label' => esc_html__('Transition Speed', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 500,
                'min' => 100,
                'max' => 5000,
                'step' => 100,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'transition_effect',
            [
                'label' => esc_html__('Transition Effect', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => esc_html__('Fade', 'elementor-widgets'),
                    'slide' => esc_html__('Slide', 'elementor-widgets'),
                    'cube' => esc_html__('Cube', 'elementor-widgets'),
                    'coverflow' => esc_html__('Coverflow', 'elementor-widgets'),
                    'flip' => esc_html__('Flip', 'elementor-widgets'),
                ],
                'frontend_available' => true,
            ]
        );

        $this->end_controls_section();
    }
} 