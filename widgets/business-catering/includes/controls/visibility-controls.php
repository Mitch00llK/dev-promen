<?php
/**
 * Visibility Controls for Business Catering Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Visibility Section
$this->start_controls_section(
    'section_visibility',
    [
        'label' => esc_html__('Visibility', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'show_title',
    [
        'label' => esc_html__('Show Title', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'show_image_title',
    [
        'label' => esc_html__('Show Image Titles', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
    ]
);

$this->add_control(
    'show_image_description',
    [
        'label' => esc_html__('Show Image Descriptions', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
    ]
);

$this->add_control(
    'show_overlay_on_hover',
    [
        'label' => esc_html__('Show Overlay on Hover', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
        'condition' => [
            'show_image_title' => 'yes',
            'show_image_description' => 'yes',
        ],
    ]
);

// Responsive Visibility
$this->add_control(
    'responsive_visibility_heading',
    [
        'label' => esc_html__('Responsive Visibility', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'hide_on_desktop',
    [
        'label' => esc_html__('Hide On Desktop', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
        'prefix_class' => 'elementor-',
        'selectors' => [
            '(desktop){{WRAPPER}}' => 'display: none',
        ],
    ]
);

$this->add_control(
    'hide_on_tablet',
    [
        'label' => esc_html__('Hide On Tablet', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
        'prefix_class' => 'elementor-',
        'selectors' => [
            '(tablet){{WRAPPER}}' => 'display: none',
        ],
    ]
);

$this->add_control(
    'hide_on_mobile',
    [
        'label' => esc_html__('Hide On Mobile', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
        'prefix_class' => 'elementor-',
        'selectors' => [
            '(mobile){{WRAPPER}}' => 'display: none',
        ],
    ]
);

$this->end_controls_section(); 