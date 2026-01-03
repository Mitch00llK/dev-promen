<?php
/**
 * Content Section Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Team_Members_Carousel_Content_Controls {
    protected function register_content_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_section_title',
            [
                'label' => esc_html__('Show Section Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Use the standardized split title controls
        promen_add_split_title_controls(
            $this, 
            'section_content', 
            ['show_section_title' => 'yes'], 
            esc_html__('Het kloppend hart van Promen', 'promen-elementor-widgets')
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Number of Members', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50,
                'step' => 1,
                'default' => 10,
            ]
        );

        $this->add_control(
            'order_by',
            [
                'label' => esc_html__('Order By', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date' => esc_html__('Date', 'promen-elementor-widgets'),
                    'title' => esc_html__('Title', 'promen-elementor-widgets'),
                    'menu_order' => esc_html__('Menu Order', 'promen-elementor-widgets'),
                    'rand' => esc_html__('Random', 'promen-elementor-widgets'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'DESC',
                'options' => [
                    'DESC' => esc_html__('Descending', 'promen-elementor-widgets'),
                    'ASC' => esc_html__('Ascending', 'promen-elementor-widgets'),
                ],
            ]
        );

        $this->end_controls_section();

        // Member Card Content Section
        $this->start_controls_section(
            'section_member_content',
            [
                'label' => esc_html__('Member Card Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_member_image',
            [
                'label' => esc_html__('Show Member Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_member_name',
            [
                'label' => esc_html__('Show Member Name', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'member_name_tag',
            [
                'label' => esc_html__('Member Name HTML Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'div',
                    'span' => 'span',
                    'p' => 'p',
                ],
                'condition' => [
                    'show_member_name' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_member_title',
            [
                'label' => esc_html__('Show Member Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_linkedin',
            [
                'label' => esc_html__('Show LinkedIn Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }
} 