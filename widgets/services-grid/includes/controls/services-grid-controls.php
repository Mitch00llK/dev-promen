<?php
/**
 * Services Grid Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include slider controls
require_once(__DIR__ . '/slider-controls/slider-controls.php');

/**
 * Register Services Grid Widget Controls
 */
function register_services_grid_controls($widget) {
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
            'default' => esc_html__('Onze', 'promen-elementor-widgets'),
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
            'default' => esc_html__('diensten', 'promen-elementor-widgets'),
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

    // Services Repeater
    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
        'show_service',
        [
            'label' => esc_html__('Show Service', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $repeater->add_control(
        'service_icon',
        [
            'label' => esc_html__('Icon', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-star',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'show_service' => 'yes',
            ],
        ]
    );

    $repeater->add_control(
        'service_title',
        [
            'label' => esc_html__('Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Service Title', 'promen-elementor-widgets'),
            'label_block' => true,
            'condition' => [
                'show_service' => 'yes',
            ],
        ]
    );


    $repeater->add_control(
        'service_link',
        [
            'label' => esc_html__('Link', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
            'show_external' => true,
            'default' => [
                'url' => '',
                'is_external' => false,
                'nofollow' => false,
            ],
            'condition' => [
                'show_service' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'services',
        [
            'label' => esc_html__('Services', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'service_title' => esc_html__('Individuele detachering', 'promen-elementor-widgets'),
                    'show_service' => 'yes',
                ],
                [
                    'service_title' => esc_html__('Techniek & Verpakken', 'promen-elementor-widgets'),
                    'show_service' => 'yes',
                ],
                [
                    'service_title' => esc_html__('Bedrijfscatering', 'promen-elementor-widgets'),
                    'show_service' => 'yes',
                ],
                [
                    'service_title' => esc_html__('Logistiek', 'promen-elementor-widgets'),
                    'show_service' => 'yes',
                ],
                [
                    'service_title' => esc_html__('Groen & schoon', 'promen-elementor-widgets'),
                    'show_service' => 'yes',
                ],
                [
                    'service_title' => esc_html__('Contractvervoer', 'promen-elementor-widgets'),
                    'show_service' => 'yes',
                ],
            ],
            'title_field' => '{{{ service_title }}}',
        ]
    );

    // End content section before adding slider controls
    $widget->end_controls_section();

    // Add slider controls
    add_services_grid_slider_controls($widget);

    // Layout Section
    $widget->start_controls_section(
        'layout_section',
        [
            'label' => esc_html__('Layout', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Layout Type
    $widget->add_responsive_control(
        'layout_type',
        [
            'label' => esc_html__('Layout Type', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'two_column',
            'options' => [
                'two_column' => esc_html__('Two Column (Text Left, Grid Right)', 'promen-elementor-widgets'),
                'stacked' => esc_html__('Stacked (Text Top, Grid Bottom)', 'promen-elementor-widgets'),
            ],
            'prefix_class' => 'services-grid-layout-',
        ]
    );

    // Content Container Width
    $widget->add_responsive_control(
        'content_container_width',
        [
            'label' => esc_html__('Content Container Width', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'rem'],
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 100,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 1000,
                ],
                'rem' => [
                    'min' => 10,
                    'max' => 100,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 30,
            ],
            'selectors' => [
                '{{WRAPPER}} .services-grid-content' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout_type' => 'two_column',
            ],
        ]
    );

    // Content Container Alignment
    $widget->add_responsive_control(
        'content_container_alignment',
        [
            'label' => esc_html__('Content Container Alignment', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Left', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('Right', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .services-grid-content' => 'align-self: {{VALUE}};',
            ],
            'condition' => [
                'layout_type' => 'two_column',
            ],
        ]
    );

    // Grid Container Width
    $widget->add_responsive_control(
        'grid_container_width',
        [
            'label' => esc_html__('Grid Container Width', 'promen-elementor-widgets'),
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
                'size' => 70,
            ],
            'selectors' => [
                '{{WRAPPER}} .services-grid-wrapper' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout_type' => 'two_column',
            ],
        ]
    );

    // Grid Container Alignment
    $widget->add_responsive_control(
        'grid_container_alignment',
        [
            'label' => esc_html__('Grid Container Alignment', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Left', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('Right', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-right',
                ],
            ],
            'default' => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .services-grid-wrapper' => 'align-self: {{VALUE}};',
            ],
            'condition' => [
                'layout_type' => 'two_column',
            ],
        ]
    );

    // Main Container Alignment
    $widget->add_responsive_control(
        'main_container_alignment',
        [
            'label' => esc_html__('Main Container Alignment', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'flex-start' => [
                    'title' => esc_html__('Left', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-left',
                ],
                'center' => [
                    'title' => esc_html__('Center', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-center',
                ],
                'flex-end' => [
                    'title' => esc_html__('Right', 'promen-elementor-widgets'),
                    'icon' => 'eicon-text-align-right',
                ],
                'space-between' => [
                    'title' => esc_html__('Space Between', 'promen-elementor-widgets'),
                    'icon' => 'eicon-justify-space-between-h',
                ],
                'space-around' => [
                    'title' => esc_html__('Space Around', 'promen-elementor-widgets'),
                    'icon' => 'eicon-justify-space-around-h',
                ],
            ],
            'default' => 'flex-start',
            'selectors' => [
                '{{WRAPPER}} .services-grid-container' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'layout_type' => 'two_column',
            ],
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
                    'max' => 50,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 500,
                ],
                'rem' => [
                    'min' => 10,
                    'max' => 50,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 30,
            ],
            'selectors' => [
                '{{WRAPPER}} .services-grid-content' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout_type' => 'two_column',
            ],
        ]
    );

    // Content Spacing
    $widget->add_responsive_control(
        'content_spacing',
        [
            'label' => esc_html__('Content Spacing', 'promen-elementor-widgets'),
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
                '{{WRAPPER}} .services-grid-container' => 'gap: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.services-grid-layout-stacked .services-grid-content' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Columns
    $widget->add_responsive_control(
        'columns',
        [
            'label' => esc_html__('Grid Columns', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '3',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
                '4' => '4',
            ],
            'selectors' => [
                '{{WRAPPER}} .services-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ]
    );

    // Column Gap
    $widget->add_responsive_control(
        'column_gap',
        [
            'label' => esc_html__('Column Gap', 'promen-elementor-widgets'),
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
                'size' => 1.5,
            ],
            'selectors' => [
                '{{WRAPPER}} .services-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Row Gap
    $widget->add_responsive_control(
        'row_gap',
        [
            'label' => esc_html__('Row Gap', 'promen-elementor-widgets'),
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
                'size' => 1.5,
            ],
            'selectors' => [
                '{{WRAPPER}} .services-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Mobile Slider Options
    $widget->add_control(
        'mobile_slider_heading',
        [
            'label' => esc_html__('Mobile Slider Options', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    // Mobile Breakpoint
    $widget->add_control(
        'mobile_breakpoint',
        [
            'label' => esc_html__('Mobile Breakpoint', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 992,
            'min' => 320,
            'max' => 1200,
            'step' => 1,
            'description' => esc_html__('Screen width in pixels where the grid becomes a slider', 'promen-elementor-widgets'),
        ]
    );

    // Slides Per View
    $widget->add_responsive_control(
        'slides_per_view',
        [
            'label' => esc_html__('Slides Per View', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => '2',
            'tablet_default' => '2',
            'mobile_default' => '1',
            'options' => [
                '1' => '1',
                '2' => '2',
                '3' => '3',
            ],
        ]
    );

    // Pagination Color
    $widget->add_control(
        'pagination_color',
        [
            'label' => esc_html__('Pagination Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .services-slider .swiper-pagination-bullet-active' => 'background: {{VALUE}};',
            ],
            'default' => '#003B5C',
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
            'selector' => '{{WRAPPER}} .services-grid-title .title-part-1',
        ]
    );

    // Title Part 1 Color
    $widget->add_control(
        'title_part_1_color',
        [
            'label' => esc_html__('Title Part 1 Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .services-grid-title .title-part-1' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Title Part 2 Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_part_2_typography',
            'label' => esc_html__('Title Part 2 Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .services-grid-title .title-part-2',
        ]
    );

    // Title Part 2 Color
    $widget->add_control(
        'title_part_2_color',
        [
            'label' => esc_html__('Title Part 2 Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .services-grid-title .title-part-2' => 'color: {{VALUE}};',
            ],
            'default' => '#003B5C',
        ]
    );

    // Title Spacing
    $widget->add_responsive_control(
        'title_spacing',
        [
            'label' => esc_html__('Title Bottom Spacing', 'promen-elementor-widgets'),
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
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} .services-grid-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
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
            'label' => esc_html__('Description Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .services-grid-description',
        ]
    );

    // Description Color
    $widget->add_control(
        'description_color',
        [
            'label' => esc_html__('Description Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .services-grid-description' => 'color: {{VALUE}};',
            ],
            'default' => '#333',
        ]
    );

    // Description Spacing
    $widget->add_responsive_control(
        'description_spacing',
        [
            'label' => esc_html__('Description Bottom Spacing', 'promen-elementor-widgets'),
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
                'size' => 3,
            ],
            'selectors' => [
                '{{WRAPPER}} .services-grid-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Style Section - Cards
    $widget->start_controls_section(
        'cards_style_section',
        [
            'label' => esc_html__('Cards Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Card Background Color
    $widget->add_control(
        'card_background_color',
        [
            'label' => esc_html__('Card Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .service-card' => 'background-color: {{VALUE}};',
            ],
            'default' => '#A7D3E3',
        ]
    );

    // Card Border Radius
    $widget->add_responsive_control(
        'card_border_radius',
        [
            'label' => esc_html__('Card Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'default' => [
                'top' => '0.5',
                'right' => '0.5',
                'bottom' => '0.5',
                'left' => '0.5',
                'unit' => 'rem',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .service-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    // Card Padding
    $widget->add_responsive_control(
        'card_padding',
        [
            'label' => esc_html__('Card Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem'],
            'default' => [
                'top' => '2',
                'right' => '2',
                'bottom' => '2',
                'left' => '2',
                'unit' => 'rem',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .service-card a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    // Card Box Shadow
    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'card_box_shadow',
            'label' => esc_html__('Card Box Shadow', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .service-card',
        ]
    );

    // Card Hover Animation
    $widget->add_control(
        'card_hover_animation',
        [
            'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'translateY',
            'options' => [
                'none' => esc_html__('None', 'promen-elementor-widgets'),
                'translateY' => esc_html__('Move Up', 'promen-elementor-widgets'),
                'scale' => esc_html__('Scale', 'promen-elementor-widgets'),
                'both' => esc_html__('Move Up & Scale', 'promen-elementor-widgets'),
            ],
        ]
    );

    $widget->end_controls_section();

    // Style Section - Icon
    $widget->start_controls_section(
        'icon_style_section',
        [
            'label' => esc_html__('Icon Style', 'promen-elementor-widgets'),
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
                '{{WRAPPER}} .service-icon i' => 'color: {{VALUE}};',
                '{{WRAPPER}} .service-icon svg' => 'fill: {{VALUE}};',
            ],
            'default' => '#003B5C',
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
                '{{WRAPPER}} .service-icon i' => 'font-size: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .service-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Icon Spacing
    $widget->add_responsive_control(
        'icon_spacing',
        [
            'label' => esc_html__('Icon Bottom Spacing', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 5,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 5,
                ],
            ],
            'default' => [
                'unit' => 'rem',
                'size' => 1,
            ],
            'selectors' => [
                '{{WRAPPER}} .service-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Style Section - Service Title
    $widget->start_controls_section(
        'service_title_style_section',
        [
            'label' => esc_html__('Service Title Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Service Title Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'service_title_typography',
            'label' => esc_html__('Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .service-title',
        ]
    );

    // Service Title Color
    $widget->add_control(
        'service_title_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .service-title' => 'color: {{VALUE}};',
            ],
            'default' => '#003B5C',
        ]
    );

    $widget->end_controls_section();
} 