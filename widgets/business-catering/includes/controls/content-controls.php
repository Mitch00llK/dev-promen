<?php
/**
 * Content Controls for Business Catering Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Content Section
$this->start_controls_section(
    'section_content',
    [
        'label' => esc_html__('Content', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

// Section Title
$this->add_control(
    'section_title',
    [
        'label' => esc_html__('Section Title', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Impressie van onze bedrijfscatering', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter section title', 'promen-elementor-widgets'),
        'label_block' => true,
    ]
);

// Split Title
$this->add_control(
    'split_title',
    [
        'label' => esc_html__('Split Title', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
        'condition' => [
            'section_title!' => '',
        ],
    ]
);

// Split Title Position
$this->add_control(
    'split_title_position',
    [
        'label' => esc_html__('Split Position', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 100,
        'step' => 1,
        'default' => 1,
        'condition' => [
            'split_title' => 'yes',
            'section_title!' => '',
        ],
        'description' => esc_html__('Enter the word number where to split the title (1 = after first word)', 'promen-elementor-widgets'),
    ]
);

// Title HTML Tag
$this->add_control(
    'title_html_tag',
    [
        'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
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
            'section_title!' => '',
        ],
    ]
);

// Catering Images
$this->add_control(
    'catering_images',
    [
        'label' => esc_html__('Catering Images', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::REPEATER,
        'fields' => [
            [
                'name' => 'image',
                'label' => esc_html__('Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ],
            [
                'name' => 'title',
                'label' => esc_html__('Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Image Title', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter image title', 'promen-elementor-widgets'),
                'label_block' => true,
            ],
            [
                'name' => 'description',
                'label' => esc_html__('Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Image description goes here', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter image description', 'promen-elementor-widgets'),
                'rows' => 5,
                'label_block' => true,
            ],
            [
                'name' => 'show_overlay',
                'label' => esc_html__('Show Overlay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ],
        ],
        'default' => [
            [
                'image' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'title' => esc_html__('Catering Image 1', 'promen-elementor-widgets'),
                'description' => esc_html__('Description for catering image 1', 'promen-elementor-widgets'),
                'show_overlay' => 'no',
            ],
            [
                'image' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'title' => esc_html__('Catering Image 2', 'promen-elementor-widgets'),
                'description' => esc_html__('Description for catering image 2', 'promen-elementor-widgets'),
                'show_overlay' => 'no',
            ],
            [
                'image' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'title' => esc_html__('Catering Image 3', 'promen-elementor-widgets'),
                'description' => esc_html__('Description for catering image 3', 'promen-elementor-widgets'),
                'show_overlay' => 'no',
            ],
        ],
        'title_field' => '{{{ title }}}',
    ]
);

// Layout Settings
$this->add_control(
    'layout_heading',
    [
        'label' => esc_html__('Layout Settings', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

// Columns Desktop
$this->add_control(
    'columns_desktop',
    [
        'label' => esc_html__('Columns (Desktop)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '3',
        'options' => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
        ],
    ]
);

// Columns Tablet
$this->add_control(
    'columns_tablet',
    [
        'label' => esc_html__('Columns (Tablet)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '2',
        'options' => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
        ],
    ]
);

// Columns Mobile
$this->add_control(
    'columns_mobile',
    [
        'label' => esc_html__('Columns (Mobile)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '1',
        'options' => [
            '1' => '1',
            '2' => '2',
        ],
    ]
);

// Image Size
$this->add_control(
    'image_size',
    [
        'label' => esc_html__('Image Size', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'large',
        'options' => [
            'thumbnail' => esc_html__('Thumbnail', 'promen-elementor-widgets'),
            'medium' => esc_html__('Medium', 'promen-elementor-widgets'),
            'large' => esc_html__('Large', 'promen-elementor-widgets'),
            'full' => esc_html__('Full', 'promen-elementor-widgets'),
        ],
    ]
);

// Image Height
$this->add_control(
    'image_height',
    [
        'label' => esc_html__('Image Height', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'default',
        'options' => [
            'default' => esc_html__('Default', 'promen-elementor-widgets'),
            'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
        ],
    ]
);

// Custom Image Height
$this->add_responsive_control(
    'custom_image_height',
    [
        'label' => esc_html__('Custom Height', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px', 'vh', '%'],
        'range' => [
            'px' => [
                'min' => 100,
                'max' => 1000,
                'step' => 10,
            ],
            'vh' => [
                'min' => 10,
                'max' => 100,
                'step' => 1,
            ],
            '%' => [
                'min' => 10,
                'max' => 100,
                'step' => 1,
            ],
        ],
        'default' => [
            'unit' => 'px',
            'size' => 300,
        ],
        'selectors' => [
            '{{WRAPPER}} .promen-catering-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
        ],
        'condition' => [
            'image_height' => 'custom',
        ],
    ]
);

$this->end_controls_section(); 