<?php
/**
 * Content Section Controls
 * 
 * Controls for the slide content, including title, text, and buttons.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Hero_Slider_Content_Controls {
    /**
     * Register content controls
     */
    protected function register_content_controls() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__('Slides', 'elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'display_type',
            [
                'label' => esc_html__('Display Type', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slider',
                'options' => [
                    'slider' => esc_html__('Slider', 'elementor-widgets'),
                    'static' => esc_html__('Static (Single Slide)', 'elementor-widgets'),
                ],
            ]
        );

        $this->add_control(
            'static_slide_index',
            [
                'label' => esc_html__('Static Slide Index', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 1,
                'max' => 10,
                'step' => 1,
                'condition' => [
                    'display_type' => 'static',
                ],
                'description' => esc_html__('Select which slide to display when in static mode. The first slide is 1.', 'elementor-widgets'),
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'show_slide',
            [
                'label' => esc_html__('Show Slide', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'image_position',
            [
                'label' => esc_html__('Image Position', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'center center' => esc_html__('Center Center', 'elementor-widgets'),
                    'center left' => esc_html__('Center Left', 'elementor-widgets'),
                    'center right' => esc_html__('Center Right', 'elementor-widgets'),
                    'top center' => esc_html__('Top Center', 'elementor-widgets'),
                    'top left' => esc_html__('Top Left', 'elementor-widgets'),
                    'top right' => esc_html__('Top Right', 'elementor-widgets'),
                    'bottom center' => esc_html__('Bottom Center', 'elementor-widgets'),
                    'bottom left' => esc_html__('Bottom Left', 'elementor-widgets'),
                    'bottom right' => esc_html__('Bottom Right', 'elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .hero-slide-background' => 'background-position: {{VALUE}};',
                ],
                'condition' => [
                    'background_image[url]!' => '',
                ],
            ]
        );

        $repeater->add_control(
            'image_size',
            [
                'label' => esc_html__('Image Size', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'full',
                'options' => $this->get_image_sizes(),
                'condition' => [
                    'background_image[url]!' => '',
                ],
            ]
        );

        $repeater->add_control(
            'content_heading',
            [
                'label' => esc_html__('Content', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'title_text',
            [
                'label' => esc_html__('Title', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Slide Title', 'elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_title' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
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
                    'show_title' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_content',
            [
                'label' => esc_html__('Show Content', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor-widgets'),
                'condition' => [
                    'show_content' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'buttons_heading',
            [
                'label' => esc_html__('Buttons', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'show_button_1',
            [
                'label' => esc_html__('Show Button 1', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'button_1_text',
            [
                'label' => esc_html__('Button 1 Text', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'elementor-widgets'),
                'condition' => [
                    'show_button_1' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_1_link',
            [
                'label' => esc_html__('Button 1 Link', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-widgets'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_button_1' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_1_icon',
            [
                'label' => esc_html__('Button 1 Icon', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-arrow-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_button_1' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_button_2',
            [
                'label' => esc_html__('Show Button 2', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'elementor-widgets'),
                'label_off' => esc_html__('No', 'elementor-widgets'),
                'return_value' => 'yes',
                'default' => '',
            ]
        );

        $repeater->add_control(
            'button_2_text',
            [
                'label' => esc_html__('Button 2 Text', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Contact Us', 'elementor-widgets'),
                'condition' => [
                    'show_button_2' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_2_link',
            [
                'label' => esc_html__('Button 2 Link', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'elementor-widgets'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_button_2' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_2_icon',
            [
                'label' => esc_html__('Button 2 Icon', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-envelope',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_button_2' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => esc_html__('Slides', 'elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'show_slide' => 'yes',
                        'title_text' => esc_html__('Slide #1', 'elementor-widgets'),
                        'content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor-widgets'),
                        'button_1_text' => esc_html__('Learn More', 'elementor-widgets'),
                    ],
                    [
                        'show_slide' => 'yes',
                        'title_text' => esc_html__('Slide #2', 'elementor-widgets'),
                        'content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor-widgets'),
                        'button_1_text' => esc_html__('Learn More', 'elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ title_text }}}',
            ]
        );

        $this->end_controls_section();
    }
} 