<?php
/**
 * Slider Controls for Business Catering Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Slider Section
$this->start_controls_section(
    'section_slider',
    [
        'label' => esc_html__('Slider Settings', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'slider_info',
    [
        'type' => \Elementor\Controls_Manager::RAW_HTML,
        'raw' => esc_html__('The slider will automatically activate when more than 3 images are added.', 'promen-elementor-widgets'),
        'content_classes' => 'elementor-descriptor',
    ]
);

$this->add_control(
    'slider_template',
    [
        'label' => esc_html__('Slider Template', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'default',
        'options' => [
            'default' => esc_html__('Default', 'promen-elementor-widgets'),
            'fade' => esc_html__('Fade', 'promen-elementor-widgets'),
        ],
    ]
);

$this->add_control(
    'slider_navigation',
    [
        'label' => esc_html__('Show Navigation Arrows', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'slider_pagination',
    [
        'label' => esc_html__('Show Pagination Dots', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'slider_loop',
    [
        'label' => esc_html__('Enable Loop', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'slider_autoplay',
    [
        'label' => esc_html__('Enable Autoplay', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'slider_autoplay_delay',
    [
        'label' => esc_html__('Autoplay Delay (ms)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1000,
        'max' => 10000,
        'step' => 500,
        'default' => 5000,
        'condition' => [
            'slider_autoplay' => 'yes',
        ],
    ]
);

$this->add_control(
    'slider_speed',
    [
        'label' => esc_html__('Transition Speed (ms)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 100,
        'max' => 3000,
        'step' => 100,
        'default' => 500,
    ]
);

$this->add_control(
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
            'spring' => esc_html__('Spring', 'promen-elementor-widgets'),
        ],
    ]
);

$this->add_control(
    'slides_per_view',
    [
        'label' => esc_html__('Slides Per View (Desktop)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '3',
        'options' => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            'auto' => esc_html__('Auto', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'slider_effect' => 'slide',
        ],
    ]
);

$this->add_control(
    'slides_per_view_tablet',
    [
        'label' => esc_html__('Slides Per View (Tablet)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '2',
        'options' => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            'auto' => esc_html__('Auto', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'slider_effect' => 'slide',
        ],
    ]
);

$this->add_control(
    'slides_per_view_mobile',
    [
        'label' => esc_html__('Slides Per View (Mobile)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '1',
        'options' => [
            '1' => '1',
            '2' => '2',
            'auto' => esc_html__('Auto', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'slider_effect' => 'slide',
        ],
    ]
);

$this->add_control(
    'space_between',
    [
        'label' => esc_html__('Space Between Slides', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
                'step' => 5,
            ],
        ],
        'default' => [
            'unit' => 'px',
            'size' => 30,
        ],
        'condition' => [
            'slider_effect' => 'slide',
        ],
    ]
);

$this->add_control(
    'space_between_tablet',
    [
        'label' => esc_html__('Space Between Slides (Tablet)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
                'step' => 5,
            ],
        ],
        'default' => [
            'unit' => 'px',
            'size' => 30,
        ],
        'condition' => [
            'slider_effect' => 'slide',
        ],
    ]
);

$this->add_control(
    'space_between_mobile',
    [
        'label' => esc_html__('Space Between Slides (Mobile)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
                'step' => 5,
            ],
        ],
        'default' => [
            'unit' => 'px',
            'size' => 30,
        ],
        'condition' => [
            'slider_effect' => 'slide',
        ],
    ]
);

$this->add_control(
    'centered_slides',
    [
        'label' => esc_html__('Center Slides', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
        'condition' => [
            'slider_effect' => 'slide',
        ],
    ]
);

$this->add_control(
    'gradient_overlay',
    [
        'label' => esc_html__('Enable Gradient Overlay', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
        'description' => esc_html__('Adds gradient overlays on the left and right sides of the slider', 'promen-elementor-widgets'),
    ]
);

$this->add_control(
    'gradient_color_start',
    [
        'label' => esc_html__('Gradient Start Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'condition' => [
            'gradient_overlay' => 'yes',
        ],
    ]
);

$this->add_control(
    'gradient_opacity',
    [
        'label' => esc_html__('Gradient Opacity', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['%'],
        'range' => [
            '%' => [
                'min' => 0,
                'max' => 100,
                'step' => 5,
            ],
        ],
        'default' => [
            'unit' => '%',
            'size' => 90,
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
        'size_units' => ['%'],
        'range' => [
            '%' => [
                'min' => 0,
                'max' => 50,
                'step' => 1,
            ],
        ],
        'default' => [
            'unit' => '%',
            'size' => 15,
        ],
        'condition' => [
            'gradient_overlay' => 'yes',
        ],
    ]
);

$this->end_controls_section(); 