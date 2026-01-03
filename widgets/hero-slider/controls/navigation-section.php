<?php
/**
 * Navigation Section Controls
 * 
 * Controls for the slider navigation, including arrows and pagination.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Hero_Slider_Navigation_Controls {
    /**
     * Register navigation controls
     */
    protected function register_navigation_controls() {
        $this->start_controls_section(
            'section_navigation',
            [
                'label' => esc_html__('Navigation', 'elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'display_type' => 'slider',
                ],
            ]
        );

        // Arrows
        $this->add_control(
            'arrows_heading',
            [
                'label' => esc_html__('Arrows', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'show_arrows',
            [
                'label' => esc_html__('Show Arrows', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'arrows_position',
            [
                'label' => esc_html__('Arrows Position', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'content',
                'options' => [
                    'content' => esc_html__('Inside Content', 'elementor-widgets'),
                    'outside' => esc_html__('Outside Content', 'elementor-widgets'),
                    'sides' => esc_html__('On Sides', 'elementor-widgets'),
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                ],
                'prefix_class' => 'arrows-position-',
            ]
        );

        $this->add_control(
            'prev_arrow_icon',
            [
                'label' => esc_html__('Previous Arrow Icon', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-left',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'next_arrow_icon',
            [
                'label' => esc_html__('Next Arrow Icon', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );

        // Pagination
        $this->add_control(
            'pagination_heading',
            [
                'label' => esc_html__('Pagination', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => esc_html__('Show Pagination', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pagination_type',
            [
                'label' => esc_html__('Pagination Type', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bullets',
                'options' => [
                    'bullets' => esc_html__('Bullets', 'elementor-widgets'),
                    'fraction' => esc_html__('Fraction', 'elementor-widgets'),
                    'progressbar' => esc_html__('Progress Bar', 'elementor-widgets'),
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pagination_position',
            [
                'label' => esc_html__('Pagination Position', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom-center',
                'options' => [
                    'bottom-left' => esc_html__('Bottom Left', 'elementor-widgets'),
                    'bottom-center' => esc_html__('Bottom Center', 'elementor-widgets'),
                    'bottom-right' => esc_html__('Bottom Right', 'elementor-widgets'),
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
                'prefix_class' => 'pagination-',
            ]
        );

        $this->end_controls_section();
    }
} 