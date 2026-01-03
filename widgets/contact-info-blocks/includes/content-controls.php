<?php
/**
 * Content Controls
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;

// Content Tab
$this->start_controls_section(
    'section_contact_blocks',
    [
        'label' => esc_html__('Contact Blocks', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'layout',
    [
        'label' => esc_html__('Layout', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
        'default' => 'horizontal',
        'options' => [
            'horizontal' => esc_html__('Horizontal', 'promen-elementor-widgets'),
            'vertical' => esc_html__('Vertical', 'promen-elementor-widgets'),
        ],
    ]
);

// Address Block
$this->add_control(
    'address_block_heading',
    [
        'label' => esc_html__('Address Block', 'promen-elementor-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'show_address_block',
    [
        'label' => esc_html__('Show Address Block', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
    ]
);

$this->add_control(
    'address_title',
    [
        'label' => esc_html__('Title', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('Postadres', 'promen-elementor-widgets'),
        'condition' => [
            'show_address_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'address_title_tag',
    [
        'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
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
            'show_address_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'address_icon',
    [
        'label' => esc_html__('Icon', 'promen-elementor-widgets'),
        'type' => Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-map-marker-alt',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_address_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'address_content',
    [
        'label' => esc_html__('Address Content', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXTAREA,
        'default' => esc_html__('Postbus 247, 2800 AE Gouda', 'promen-elementor-widgets'),
        'condition' => [
            'show_address_block' => 'yes',
        ],
    ]
);

// Phone Block
$this->add_control(
    'phone_block_heading',
    [
        'label' => esc_html__('Phone Block', 'promen-elementor-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'show_phone_block',
    [
        'label' => esc_html__('Show Phone Block', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
    ]
);

$this->add_control(
    'phone_title',
    [
        'label' => esc_html__('Title', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('Telefoonnummer', 'promen-elementor-widgets'),
        'condition' => [
            'show_phone_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'phone_title_tag',
    [
        'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
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
            'show_phone_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'phone_icon',
    [
        'label' => esc_html__('Icon', 'promen-elementor-widgets'),
        'type' => Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-phone',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_phone_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'phone_number',
    [
        'label' => esc_html__('Phone Number', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('088 98 98 000', 'promen-elementor-widgets'),
        'condition' => [
            'show_phone_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'phone_link',
    [
        'label' => esc_html__('Make Phone Clickable', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
        'condition' => [
            'show_phone_block' => 'yes',
        ],
    ]
);

// Email Block
$this->add_control(
    'email_block_heading',
    [
        'label' => esc_html__('Email Block', 'promen-elementor-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'show_email_block',
    [
        'label' => esc_html__('Show Email Block', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
    ]
);

$this->add_control(
    'email_title',
    [
        'label' => esc_html__('Title', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('E-mailadres', 'promen-elementor-widgets'),
        'condition' => [
            'show_email_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'email_title_tag',
    [
        'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
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
            'show_email_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'email_icon',
    [
        'label' => esc_html__('Icon', 'promen-elementor-widgets'),
        'type' => Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-envelope',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_email_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'email_address',
    [
        'label' => esc_html__('Email Address', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('info@promen.nl', 'promen-elementor-widgets'),
        'condition' => [
            'show_email_block' => 'yes',
        ],
    ]
);

$this->add_control(
    'email_link',
    [
        'label' => esc_html__('Make Email Clickable', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
        'condition' => [
            'show_email_block' => 'yes',
        ],
    ]
);

// Animation
$this->add_control(
    'animation_heading',
    [
        'label' => esc_html__('Animation', 'promen-elementor-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'enable_animation',
    [
        'label' => esc_html__('Enable GSAP Animation', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'no',
    ]
);

$this->add_control(
    'animation_type',
    [
        'label' => esc_html__('Animation Type', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
        'default' => 'fade-in',
        'options' => [
            'fade-in' => esc_html__('Fade In', 'promen-elementor-widgets'),
            'slide-up' => esc_html__('Slide Up', 'promen-elementor-widgets'),
            'slide-in' => esc_html__('Slide In', 'promen-elementor-widgets'),
            'scale-in' => esc_html__('Scale In', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'enable_animation' => 'yes',
        ],
    ]
);

$this->add_control(
    'animation_delay',
    [
        'label' => esc_html__('Stagger Delay (ms)', 'promen-elementor-widgets'),
        'type' => Controls_Manager::NUMBER,
        'default' => 200,
        'min' => 0,
        'max' => 2000,
        'step' => 50,
        'condition' => [
            'enable_animation' => 'yes',
        ],
    ]
);

$this->end_controls_section(); 