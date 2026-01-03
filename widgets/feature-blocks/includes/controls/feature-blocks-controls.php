<?php
/**
 * Feature Blocks Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register content controls for the feature blocks widget
 */
function register_feature_blocks_content_controls($widget) {
    // Widget Title Section
    $widget->start_controls_section(
        'section_widget_title',
        [
            'label' => esc_html__('Widget Title', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'show_widget_title',
        [
            'label' => esc_html__('Show Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'no',
        ]
    );

    $widget->add_control(
        'widget_title',
        [
            'label' => esc_html__('Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Feature Blocks', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Enter your title', 'promen-elementor-widgets'),
            'condition' => [
                'show_widget_title' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'widget_title_html_tag',
        [
            'label' => esc_html__('HTML Tag', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
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
            'default' => 'h3',
            'condition' => [
                'show_widget_title' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'widget_title_align',
        [
            'label' => esc_html__('Alignment', 'promen-elementor-widgets'),
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
                '{{WRAPPER}} .widget-title-wrapper' => 'text-align: {{VALUE}};',
            ],
            'condition' => [
                'show_widget_title' => 'yes',
            ],
        ]
    );

    $widget->end_controls_section();

    // Main Image Section
    $widget->start_controls_section(
        'section_main_image',
        [
            'label' => esc_html__('Main Image', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'main_image',
        [
            'label' => esc_html__('Choose Image', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
        ]
    );

    $widget->add_control(
        'overlay_image',
        [
            'label' => esc_html__('Overlay Image', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
            'description' => esc_html__('Upload an image to display as overlay instead of text', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'show_overlay_image',
        [
            'label' => esc_html__('Show Overlay Image', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->end_controls_section();

    // Feature Blocks Section
    for ($i = 1; $i <= 4; $i++) {
        $widget->start_controls_section(
            'section_block_' . $i,
            [
                'label' => esc_html__('Feature Block ' . $i, 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_block_' . $i,
            [
                'label' => esc_html__('Show Block ' . $i, 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'block_' . $i . '_icon',
            [
                'label' => esc_html__('Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_block_' . $i => 'yes',
                ],
            ]
        );

        // Use the standardized split title controls for each block
        promen_add_split_title_controls(
            $widget, 
            'section_block_' . $i, 
            ['show_block_' . $i => 'yes'], 
            get_default_title($i),
            'block_' . $i . '_title'
        );

        // Override the default HTML tag to 'span' for feature blocks
        $widget->update_control(
            'block_' . $i . '_title_html_tag',
            [
                'default' => 'span',
            ]
        );

        $widget->add_control(
            'block_' . $i . '_content',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Feature block content goes here. Describe the feature in detail.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter content', 'promen-elementor-widgets'),
                'condition' => [
                    'show_block_' . $i => 'yes',
                ],
            ]
        );

        // Add button controls only for block 4
        if ($i === 4) {
            $widget->add_control(
                'show_block_4_button',
                [
                    'label' => esc_html__('Show Button', 'promen-elementor-widgets'),
                    'type' => \Elementor\Controls_Manager::SWITCHER,
                    'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                    'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                    'return_value' => 'yes',
                    'default' => 'yes',
                    'condition' => [
                        'show_block_4' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'block_4_button_text',
                [
                    'label' => esc_html__('Button Text', 'promen-elementor-widgets'),
                    'type' => \Elementor\Controls_Manager::TEXT,
                    'default' => esc_html__('Learn More', 'promen-elementor-widgets'),
                    'placeholder' => esc_html__('Enter button text', 'promen-elementor-widgets'),
                    'condition' => [
                        'show_block_4' => 'yes',
                        'show_block_4_button' => 'yes',
                    ],
                ]
            );

            $widget->add_control(
                'block_4_button_url',
                [
                    'label' => esc_html__('Button URL', 'promen-elementor-widgets'),
                    'type' => \Elementor\Controls_Manager::URL,
                    'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                    'default' => [
                        'url' => '#',
                    ],
                    'condition' => [
                        'show_block_4' => 'yes',
                        'show_block_4_button' => 'yes',
                    ],
                ]
            );
        }

        $widget->end_controls_section();
    }
}

/**
 * Register layout controls for the feature blocks widget
 */
function register_feature_blocks_layout_controls($widget) {
    // Layout Settings
    $widget->start_controls_section(
        'section_layout_settings',
        [
            'label' => esc_html__('Layout Settings', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'background_color',
        [
            'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#f5f5f5',
            'selectors' => [
                '{{WRAPPER}} .promen-feature-blocks-container' => 'background-color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_control(
        'stack_on_tablet',
        [
            'label' => esc_html__('Stack on Tablet', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'stack_on_mobile',
        [
            'label' => esc_html__('Stack on Mobile', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->end_controls_section();
}

/**
 * Register style controls for the feature blocks widget
 */
function register_feature_blocks_style_controls($widget) {
    // Widget Title Style
    $widget->start_controls_section(
        'section_widget_title_style',
        [
            'label' => esc_html__('Widget Title Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_widget_title' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'widget_title_color',
        [
            'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#333333',
            'selectors' => [
                '{{WRAPPER}} .widget-title' => 'color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'widget_title_typography',
            'selector' => '{{WRAPPER}} .widget-title',
        ]
    );

    $widget->add_responsive_control(
        'widget_title_margin',
        [
            'label' => esc_html__('Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .widget-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => [
                'top' => '0',
                'right' => '0',
                'bottom' => '30',
                'left' => '0',
                'unit' => 'px',
                'isLinked' => false,
            ],
        ]
    );

    $widget->add_responsive_control(
        'widget_title_padding',
        [
            'label' => esc_html__('Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .widget-title-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Main Image Style
    $widget->start_controls_section(
        'section_main_image_style',
        [
            'label' => esc_html__('Main Image Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'main_image_border',
            'selector' => '{{WRAPPER}} .promen-feature-main-image img',
        ]
    );

    $widget->add_responsive_control(
        'main_image_border_radius',
        [
            'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .promen-feature-main-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'main_image_box_shadow',
            'selector' => '{{WRAPPER}} .promen-feature-main-image img',
        ]
    );

    $widget->add_control(
        'overlay_heading',
        [
            'label' => esc_html__('Overlay Image Style', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );

    $widget->add_responsive_control(
        'overlay_image_width',
        [
            'label' => esc_html__('Width', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 500,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 1,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 50,
            ],
            'selectors' => [
                '{{WRAPPER}} .overlay-image img' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'show_overlay_image' => 'yes',
            ],
        ]
    );

    $widget->add_responsive_control(
        'overlay_image_rotation',
        [
            'label' => esc_html__('Rotation (deg)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['deg'],
            'range' => [
                'deg' => [
                    'min' => -45,
                    'max' => 45,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'deg',
                'size' => -5,
            ],
            'selectors' => [
                '{{WRAPPER}} .overlay-image img' => 'transform: rotate({{SIZE}}deg);',
            ],
            'condition' => [
                'show_overlay_image' => 'yes',
            ],
        ]
    );

    $widget->add_responsive_control(
        'overlay_image_position',
        [
            'label' => esc_html__('Position', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'center center',
            'options' => [
                'center center' => esc_html__('Center Center', 'promen-elementor-widgets'),
                'center left' => esc_html__('Center Left', 'promen-elementor-widgets'),
                'center right' => esc_html__('Center Right', 'promen-elementor-widgets'),
                'top center' => esc_html__('Top Center', 'promen-elementor-widgets'),
                'top left' => esc_html__('Top Left', 'promen-elementor-widgets'),
                'top right' => esc_html__('Top Right', 'promen-elementor-widgets'),
                'bottom center' => esc_html__('Bottom Center', 'promen-elementor-widgets'),
                'bottom left' => esc_html__('Bottom Left', 'promen-elementor-widgets'),
                'bottom right' => esc_html__('Bottom Right', 'promen-elementor-widgets'),
            ],
            'selectors' => [
                '{{WRAPPER}} .overlay-image' => 'justify-content: {{VALUE}};',
            ],
            'condition' => [
                'show_overlay_image' => 'yes',
            ],
        ]
    );

    $widget->add_responsive_control(
        'overlay_vertical_position',
        [
            'label' => esc_html__('Vertical Position', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%'],
            'range' => [
                '%' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 10,
            ],
            'selectors' => [
                '{{WRAPPER}} .overlay-image' => 'bottom: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'show_overlay_image' => 'yes',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'overlay_image_shadow',
            'selector' => '{{WRAPPER}} .overlay-image img',
            'condition' => [
                'show_overlay_image' => 'yes',
            ],
        ]
    );

    $widget->add_responsive_control(
        'overlay_image_margin',
        [
            'label' => esc_html__('Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em'],
            'selectors' => [
                '{{WRAPPER}} .overlay-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'show_overlay_image' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'overlay_background_color',
        [
            'label' => esc_html__('Overlay Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => 'rgba(0, 0, 0, 0.5)',
            'selectors' => [
                '{{WRAPPER}} .overlay-image' => 'background-color: {{VALUE}};',
            ],
            'condition' => [
                'show_overlay_image' => 'yes',
            ],
        ]
    );

    $widget->end_controls_section();

    // Feature Block Style
    $widget->start_controls_section(
        'section_feature_block_style',
        [
            'label' => esc_html__('Feature Block Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_control(
        'block_background_color',
        [
            'label' => esc_html__('Block Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .promen-feature-block' => 'background-color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'block_border',
            'selector' => '{{WRAPPER}} .promen-feature-block',
        ]
    );

    $widget->add_responsive_control(
        'block_border_radius',
        [
            'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .promen-feature-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'block_box_shadow',
            'selector' => '{{WRAPPER}} .promen-feature-block',
        ]
    );

    $widget->add_responsive_control(
        'block_padding',
        [
            'label' => esc_html__('Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .promen-feature-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => [
                'top' => '20',
                'right' => '20',
                'bottom' => '20',
                'left' => '20',
                'unit' => 'px',
                'isLinked' => true,
            ],
        ]
    );

    $widget->end_controls_section();

    // Icon Style
    $widget->start_controls_section(
        'section_icon_style',
        [
            'label' => esc_html__('Icon Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_control(
        'icon_color',
        [
            'label' => esc_html__('Icon Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#4054b2',
            'selectors' => [
                '{{WRAPPER}} .feature-icon i' => 'color: {{VALUE}}',
                '{{WRAPPER}} .feature-icon svg' => 'fill: {{VALUE}}',
            ],
        ]
    );

    $widget->add_responsive_control(
        'icon_size',
        [
            'label' => esc_html__('Icon Size', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 30,
            ],
            'selectors' => [
                '{{WRAPPER}} .feature-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'icon_margin',
        [
            'label' => esc_html__('Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .feature-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Title Style
    $widget->start_controls_section(
        'section_title_style',
        [
            'label' => esc_html__('Title Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_control(
        'title_color',
        [
            'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#333333',
            'selectors' => [
                '{{WRAPPER}} .feature-title' => 'color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .feature-title',
        ]
    );

    $widget->add_responsive_control(
        'title_margin',
        [
            'label' => esc_html__('Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .feature-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Content Style
    $widget->start_controls_section(
        'section_content_style',
        [
            'label' => esc_html__('Content Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_control(
        'content_color',
        [
            'label' => esc_html__('Content Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#666666',
            'selectors' => [
                '{{WRAPPER}} .feature-content' => 'color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'content_typography',
            'selector' => '{{WRAPPER}} .feature-content',
        ]
    );

    $widget->add_responsive_control(
        'content_margin',
        [
            'label' => esc_html__('Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .feature-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Button Style
    $widget->start_controls_section(
        'section_button_style',
        [
            'label' => esc_html__('Button Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_block_4' => 'yes',
                'show_block_4_button' => 'yes',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'button_typography',
            'selector' => '{{WRAPPER}} .feature-button',
        ]
    );

    $widget->start_controls_tabs('button_style_tabs');

    $widget->start_controls_tab(
        'button_normal_tab',
        [
            'label' => esc_html__('Normal', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'button_text_color',
        [
            'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .feature-button' => 'color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_control(
        'button_background_color',
        [
            'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#4054b2',
            'selectors' => [
                '{{WRAPPER}} .feature-button' => 'background-color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'button_border',
            'selector' => '{{WRAPPER}} .feature-button',
        ]
    );

    $widget->add_responsive_control(
        'button_border_radius',
        [
            'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .feature-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'button_padding',
        [
            'label' => esc_html__('Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .feature-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_tab();

    $widget->start_controls_tab(
        'button_hover_tab',
        [
            'label' => esc_html__('Hover', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'button_hover_text_color',
        [
            'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .feature-button:hover' => 'color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_control(
        'button_hover_background_color',
        [
            'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#3443a0',
            'selectors' => [
                '{{WRAPPER}} .feature-button:hover' => 'background-color: {{VALUE}}',
            ],
        ]
    );

    $widget->add_control(
        'button_hover_border_color',
        [
            'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .feature-button:hover' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                'button_border_border!' => '',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'button_hover_box_shadow',
            'selector' => '{{WRAPPER}} .feature-button:hover',
        ]
    );

    $widget->add_control(
        'button_hover_animation',
        [
            'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
        ]
    );

    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();
}

/**
 * Register feature blocks positioning controls
 */
function register_feature_blocks_positioning_controls($widget) {
    // Positioning Section
    $widget->start_controls_section(
        'section_positioning',
        [
            'label' => esc_html__('Positioning', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    for ($i = 1; $i <= 4; $i++) {
        $widget->add_control(
            'block_' . $i . '_position_heading',
            [
                'label' => sprintf(esc_html__('Block %d Position', 'promen-elementor-widgets'), $i),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_block_' . $i => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'block_' . $i . '_position_top',
            [
                'label' => esc_html__('Top Position (%)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => get_default_top_position($i),
                ],
                'selectors' => [
                    '{{WRAPPER}} .feature-block-' . $i => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_block_' . $i => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'block_' . $i . '_position_left',
            [
                'label' => esc_html__('Left Position (%)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => get_default_left_position($i),
                ],
                'selectors' => [
                    '{{WRAPPER}} .feature-block-' . $i => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_block_' . $i => 'yes',
                ],
            ]
        );
    }

    $widget->end_controls_section();
}

/**
 * Helper function to get default title based on block number
 */
function get_default_title($block_number) {
    $titles = [
        1 => esc_html__('Feature One', 'promen-elementor-widgets'),
        2 => esc_html__('Feature Two', 'promen-elementor-widgets'),
        3 => esc_html__('Feature Three', 'promen-elementor-widgets'),
        4 => esc_html__('Feature Four', 'promen-elementor-widgets'),
    ];
    
    return isset($titles[$block_number]) ? $titles[$block_number] : '';
}

/**
 * Helper function to get default top position based on block number
 */
function get_default_top_position($block_number) {
    $positions = [
        1 => 15, // Top left
        2 => 15, // Top right
        3 => 60, // Bottom left
        4 => 60, // Bottom right
    ];
    
    return isset($positions[$block_number]) ? $positions[$block_number] : 0;
}

/**
 * Helper function to get default left position based on block number
 */
function get_default_left_position($block_number) {
    $positions = [
        1 => 5,  // Top left
        2 => 75, // Top right
        3 => 5,  // Bottom left
        4 => 75, // Bottom right
    ];
    
    return isset($positions[$block_number]) ? $positions[$block_number] : 0;
} 