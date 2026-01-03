<?php
/**
 * Worker Testimonial Widget - Content Controls
 *
 * @package Promen\Widgets
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Content Section
$this->start_controls_section(
    'content_section',
    [
        'label' => esc_html__('Content', 'promen-elementor'),
        'tab' => Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'show_image',
    [
        'label' => esc_html__('Show Image', 'promen-elementor'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'promen-elementor'),
        'label_off' => esc_html__('Hide', 'promen-elementor'),
        'default' => 'yes',
    ]
);

$this->add_control(
    'worker_image',
    [
        'label' => esc_html__('Background Image', 'promen-elementor'),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
        'condition' => [
            'show_image' => 'yes',
        ],
    ]
);

$this->add_control(
    'image_alt_text',
    [
        'label' => esc_html__('Image Alt Text', 'promen-elementor'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('Worker testimonial background image', 'promen-elementor'),
        'description' => esc_html__('Describe the image for screen readers. Leave empty to use image alt text.', 'promen-elementor'),
        'condition' => [
            'show_image' => 'yes',
        ],
    ]
);

$this->add_control(
    'show_quote',
    [
        'label' => esc_html__('Show Quote', 'promen-elementor'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'promen-elementor'),
        'label_off' => esc_html__('Hide', 'promen-elementor'),
        'default' => 'yes',
    ]
);

$this->add_control(
    'quote_icon',
    [
        'label' => esc_html__('Quote Icon', 'promen-elementor'),
        'type' => Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-quote-left',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_quote' => 'yes',
        ],
    ]
);

$this->add_control(
    'quote_text',
    [
        'label' => esc_html__('Quote Text', 'promen-elementor'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('Ik ga elke dag met plezier naar mijn werk toe', 'promen-elementor'),
        'condition' => [
            'show_quote' => 'yes',
        ],
    ]
);

$this->add_control(
    'show_name',
    [
        'label' => esc_html__('Show Name', 'promen-elementor'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'promen-elementor'),
        'label_off' => esc_html__('Hide', 'promen-elementor'),
        'default' => 'yes',
    ]
);

$this->add_control(
    'worker_name',
    [
        'label' => esc_html__('Worker Name', 'promen-elementor'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('John Doe', 'promen-elementor'),
        'condition' => [
            'show_name' => 'yes',
        ],
    ]
);

// Add heading tag selection
$this->add_control(
    'name_tag',
    [
        'label' => esc_html__('Name HTML Tag', 'promen-elementor'),
        'type' => Controls_Manager::SELECT,
        'options' => [
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
            'p' => 'p',
        ],
        'default' => 'h3',
        'condition' => [
            'show_name' => 'yes',
        ],
    ]
);

// Split Heading functionality
$this->add_control(
    'enable_split_heading',
    [
        'label' => esc_html__('Enable Split Heading', 'promen-elementor'),
        'type' => Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor'),
        'label_off' => esc_html__('No', 'promen-elementor'),
        'default' => 'no',
        'condition' => [
            'show_name' => 'yes',
        ],
    ]
);

$this->add_control(
    'split_text_before',
    [
        'label' => esc_html__('Text Before Split', 'promen-elementor'),
        'type' => Controls_Manager::TEXT,
        'condition' => [
            'show_name' => 'yes',
            'enable_split_heading' => 'yes',
        ],
    ]
);

$this->add_control(
    'split_text_after',
    [
        'label' => esc_html__('Text After Split', 'promen-elementor'),
        'type' => Controls_Manager::TEXT,
        'condition' => [
            'show_name' => 'yes',
            'enable_split_heading' => 'yes',
        ],
    ]
);

$this->end_controls_section(); 