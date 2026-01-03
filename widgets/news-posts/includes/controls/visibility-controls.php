<?php
/**
 * Visibility and Responsive Controls for News Posts Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Responsive Section
$this->start_controls_section(
    'section_responsive',
    [
        'label' => esc_html__('Responsive', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

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

$this->end_controls_section(); 