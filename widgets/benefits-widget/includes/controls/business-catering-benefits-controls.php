<?php
/**
 * Business Catering Benefits Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Business Catering Benefits Widget Controls
 */
function register_business_catering_benefits_controls($widget) {
    // Content Section
    $widget->start_controls_section(
        'content_section',
        [
            'label' => esc_html__('Content', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    // Show/Hide Title
    $widget->add_control(
        'show_title',
        [
            'label' => esc_html__('Show Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    // Split Heading
    $widget->add_control(
        'title_part_1',
        [
            'label' => esc_html__('Title Part 1', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Voordelen van onze', 'promen-elementor-widgets'),
            'label_block' => true,
            'condition' => [
                'show_title' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'title_part_2',
        [
            'label' => esc_html__('Title Part 2', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('bedrijfscatering', 'promen-elementor-widgets'),
            'label_block' => true,
            'condition' => [
                'show_title' => 'yes',
            ],
        ]
    );

    // Title HTML Tag
    $widget->add_control(
        'title_tag',
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
            ],
            'condition' => [
                'show_title' => 'yes',
            ],
        ]
    );

    // Show/Hide Description
    $widget->add_control(
        'show_description',
        [
            'label' => esc_html__('Show Description', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    // Description
    $widget->add_control(
        'description',
        [
            'label' => esc_html__('Description', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'promen-elementor-widgets'),
            'condition' => [
                'show_description' => 'yes',
            ],
        ]
    );

    // Benefits Repeater
    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
        'show_benefit',
        [
            'label' => esc_html__('Show Benefit', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $repeater->add_control(
        'benefit_icon',
        [
            'label' => esc_html__('Icon', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-star',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'show_benefit' => 'yes',
            ],
        ]
    );

    $repeater->add_control(
        'benefit_title',
        [
            'label' => esc_html__('Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Voordeel', 'promen-elementor-widgets'),
            'label_block' => true,
            'condition' => [
                'show_benefit' => 'yes',
            ],
        ]
    );

    $repeater->add_control(
        'benefit_description',
        [
            'label' => esc_html__('Description', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'promen-elementor-widgets'),
            'condition' => [
                'show_benefit' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'benefits',
        [
            'label' => esc_html__('Benefits', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'benefit_title' => esc_html__('Voordeel 1', 'promen-elementor-widgets'),
                    'show_benefit' => 'yes',
                ],
                [
                    'benefit_title' => esc_html__('Voordeel 2', 'promen-elementor-widgets'),
                    'show_benefit' => 'yes',
                ],
                [
                    'benefit_title' => esc_html__('Voordeel 3', 'promen-elementor-widgets'),
                    'show_benefit' => 'yes',
                ],
                [
                    'benefit_title' => esc_html__('Voordeel 4', 'promen-elementor-widgets'),
                    'show_benefit' => 'yes',
                ],
            ],
            'title_field' => '{{{ benefit_title }}}',
        ]
    );

    $widget->end_controls_section();

    // Layout Section
    $widget->start_controls_section(
        'layout_section',
        [
            'label' => esc_html__('Layout', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Content Width
    $widget->add_responsive_control(
        'content_width',
        [
            'label' => esc_html__('Content Width', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'rem'],
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 1500,
                ],
                'rem' => [
                    'min' => 10,
                    'max' => 150,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 100,
            ],
            'selectors' => [
                '{{WRAPPER}} .business-catering-benefits-container' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Content Alignment
    $widget->add_responsive_control(
        'content_alignment',
        [
            'label' => esc_html__('Content Alignment', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_html__('Left', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-center',
                ],
                'right' => [
                    'title' => esc_html__('Right', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .business-catering-benefits-header' => 'text-align: {{VALUE}};',
            ],
        ]
    );

    // Grid Columns
    $widget->add_responsive_control(
        'grid_columns',
        [
            'label' => esc_html__('Grid Columns', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '2',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'selectors' => [
                '{{WRAPPER}} .business-catering-benefits-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ]
    );

    // Grid Gap
    $widget->add_responsive_control(
        'grid_gap',
        [
            'label' => esc_html__('Grid Gap', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'default' => [
                'unit' => 'rem',
                'size' => 2,
            ],
            'selectors' => [
                '{{WRAPPER}} .business-catering-benefits-grid' => 'gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Style Section - Title
    $widget->start_controls_section(
        'title_style_section',
        [
            'label' => esc_html__('Title Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_title' => 'yes',
            ],
        ]
    );

    // Title Part 1 Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_part_1_typography',
            'label' => esc_html__('Title Part 1 Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .title-part-1',
        ]
    );

    // Title Part 1 Color
    $widget->add_control(
        'title_part_1_color',
        [
            'label' => esc_html__('Title Part 1 Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .title-part-1' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Title Part 2 Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_part_2_typography',
            'label' => esc_html__('Title Part 2 Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .title-part-2',
        ]
    );

    // Title Part 2 Color
    $widget->add_control(
        'title_part_2_color',
        [
            'label' => esc_html__('Title Part 2 Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .title-part-2' => 'color: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Style Section - Description
    $widget->start_controls_section(
        'description_style_section',
        [
            'label' => esc_html__('Description Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_description' => 'yes',
            ],
        ]
    );

    // Description Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'description_typography',
            'label' => esc_html__('Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .business-catering-benefits-description',
        ]
    );

    // Description Color
    $widget->add_control(
        'description_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .business-catering-benefits-description' => 'color: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Style Section - Benefits
    $widget->start_controls_section(
        'benefits_style_section',
        [
            'label' => esc_html__('Benefits Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Icon Color
    $widget->add_control(
        'icon_color',
        [
            'label' => esc_html__('Icon Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .benefit-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .benefit-icon svg' => 'fill: {{VALUE}};',
            ],
        ]
    );

    // Icon Size
    $widget->add_responsive_control(
        'icon_size',
        [
            'label' => esc_html__('Icon Size', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 100,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 10,
                ],
                'rem' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ],
            'default' => [
                'unit' => 'rem',
                'size' => 2,
            ],
            'selectors' => [
                '{{WRAPPER}} .benefit-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .benefit-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Benefit Title Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'benefit_title_typography',
            'label' => esc_html__('Title Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .benefit-title',
        ]
    );

    // Benefit Title Color
    $widget->add_control(
        'benefit_title_color',
        [
            'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .benefit-title' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Benefit Description Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'benefit_description_typography',
            'label' => esc_html__('Description Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .benefit-description',
        ]
    );

    // Benefit Description Color
    $widget->add_control(
        'benefit_description_color',
        [
            'label' => esc_html__('Description Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .benefit-description' => 'color: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();
} 