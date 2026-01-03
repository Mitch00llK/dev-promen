<?php
/**
 * Hamburger Menu Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register content controls for hamburger menu widget
 */
function register_hamburger_menu_content_controls($widget) {
    // Content Controls Section
    $widget->start_controls_section(
        'section_content',
        [
            'label' => esc_html__('Menu Settings', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    // Menu Selection
    $menus = wp_get_nav_menus();
    $menu_options = [];
    
    foreach ($menus as $menu) {
        $menu_options[$menu->term_id] = $menu->name;
    }
    
    if (empty($menu_options)) {
        $menu_options[''] = esc_html__('No menus found', 'promen-elementor-widgets');
    }
    
    $widget->add_control(
        'menu_selection',
        [
            'label' => esc_html__('Select Menu', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => $menu_options,
            'default' => array_keys($menu_options)[0],
            'description' => sprintf(
                /* translators: %s: URL to create a new menu */
                __('Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'promen-elementor-widgets'),
                admin_url('nav-menus.php')
            ),
        ]
    );
    
    // Menu Toggle Label
    $widget->add_control(
        'menu_toggle_label',
        [
            'label' => esc_html__('Menu Toggle Label', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Menu', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Menu', 'promen-elementor-widgets'),
        ]
    );
    
    $widget->add_control(
        'show_toggle_label',
        [
            'label' => esc_html__('Show Toggle Label', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );
    
    $widget->add_control(
        'section_animation_heading',
        [
            'label' => esc_html__('Animation Settings', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );
    
    // Animation Duration
    $widget->add_control(
        'animation_duration',
        [
            'label' => esc_html__('Animation Duration (seconds)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['s'],
            'range' => [
                's' => [
                    'min' => 0.1,
                    'max' => 2,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 's',
                'size' => 0.5,
            ],
        ]
    );
    
    // Animation Easing
    $widget->add_control(
        'animation_easing',
        [
            'label' => esc_html__('Animation Easing', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'power3.out',
            'options' => [
                'power1.out' => esc_html__('Power1 (Linear)', 'promen-elementor-widgets'),
                'power2.out' => esc_html__('Power2 (Quad)', 'promen-elementor-widgets'),
                'power3.out' => esc_html__('Power3 (Cubic)', 'promen-elementor-widgets'),
                'power4.out' => esc_html__('Power4 (Strong)', 'promen-elementor-widgets'),
                'back.out' => esc_html__('Back (Overshoot)', 'promen-elementor-widgets'),
                'elastic.out' => esc_html__('Elastic', 'promen-elementor-widgets'),
                'bounce.out' => esc_html__('Bounce', 'promen-elementor-widgets'),
                'expo.out' => esc_html__('Exponential', 'promen-elementor-widgets'),
            ],
            'description' => esc_html__('Select the animation easing function for smooth motion', 'promen-elementor-widgets'),
        ]
    );
    
    // Stagger Animation Delay
    $widget->add_control(
        'stagger_delay',
        [
            'label' => esc_html__('Menu Items Stagger Delay (seconds)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['s'],
            'range' => [
                's' => [
                    'min' => 0.01,
                    'max' => 0.5,
                    'step' => 0.01,
                ],
            ],
            'default' => [
                'unit' => 's',
                'size' => 0.08,
            ],
        ]
    );
    
    // Menu Panel Animation
    $widget->add_control(
        'panel_animation',
        [
            'label' => esc_html__('Menu Panel Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'slide-right',
            'options' => [
                'slide-down' => esc_html__('Slide Down', 'promen-elementor-widgets'),
                'slide-left' => esc_html__('Slide Left', 'promen-elementor-widgets'),
                'slide-right' => esc_html__('Slide Right', 'promen-elementor-widgets'),
                'slide-up' => esc_html__('Slide Up', 'promen-elementor-widgets'),
                'fade' => esc_html__('Fade', 'promen-elementor-widgets'),
            ],
        ]
    );
    
    // Menu Items Animation
    $widget->add_control(
        'menu_items_animation',
        [
            'label' => esc_html__('Menu Items Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'fade-up',
            'options' => [
                'fade-up' => esc_html__('Fade Up', 'promen-elementor-widgets'),
                'fade-down' => esc_html__('Fade Down', 'promen-elementor-widgets'),
                'fade-left' => esc_html__('Fade Left', 'promen-elementor-widgets'),
                'fade-right' => esc_html__('Fade Right', 'promen-elementor-widgets'),
                'zoom-in' => esc_html__('Zoom In', 'promen-elementor-widgets'),
                'zoom-out' => esc_html__('Zoom Out', 'promen-elementor-widgets'),
                'slide-in-up' => esc_html__('Slide In Up', 'promen-elementor-widgets'),
                'slide-in-down' => esc_html__('Slide In Down', 'promen-elementor-widgets'),
                'slide-in-left' => esc_html__('Slide In Left', 'promen-elementor-widgets'),
                'slide-in-right' => esc_html__('Slide In Right', 'promen-elementor-widgets'),
                'none' => esc_html__('None', 'promen-elementor-widgets'),
            ],
        ]
    );
    
    // Push Content Animation
    $widget->add_control(
        'enable_push_animation',
        [
            'label' => esc_html__('Enable Push Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'panel_animation' => ['slide-left', 'slide-right', 'slide-up', 'slide-down'],
            ],
            'description' => esc_html__('Push page content when menu opens.', 'promen-elementor-widgets'),
        ]
    );
    
    // Push Content Distance
    $widget->add_control(
        'push_distance',
        [
            'label' => esc_html__('Push Distance', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['%', 'px', 'vw', 'vh'],
            'range' => [
                '%' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 5,
                ],
                'px' => [
                    'min' => 100,
                    'max' => 1000,
                    'step' => 10,
                ],
                'vw' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 5,
                ],
                'vh' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 5,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 30,
            ],
            'condition' => [
                'enable_push_animation' => 'yes',
                'panel_animation' => ['slide-left', 'slide-right', 'slide-up', 'slide-down'],
            ],
            'description' => esc_html__('Distance to push content when menu opens.', 'promen-elementor-widgets'),
        ]
    );
    
    // Use GPU Acceleration
    $widget->add_control(
        'use_gpu_acceleration',
        [
            'label' => esc_html__('GPU Acceleration', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Enable GPU acceleration for smoother animations (recommended).', 'promen-elementor-widgets'),
        ]
    );
    
    // Contact Info Section
    $widget->add_control(
        'section_contact_heading',
        [
            'label' => esc_html__('Contact Information', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
        ]
    );
    
    $widget->add_control(
        'show_contact_info',
        [
            'label' => esc_html__('Show Contact Info', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'no',
        ]
    );
    
    $widget->add_control(
        'contact_title',
        [
            'label' => esc_html__('Contact Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Contact Us', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Contact Us', 'promen-elementor-widgets'),
            'condition' => [
                'show_contact_info' => 'yes',
            ],
        ]
    );
    
    $widget->add_control(
        'contact_phone',
        [
            'label' => esc_html__('Phone Number', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '',
            'placeholder' => esc_html__('+1 (123) 456-7890', 'promen-elementor-widgets'),
            'condition' => [
                'show_contact_info' => 'yes',
            ],
        ]
    );
    
    $widget->add_control(
        'contact_email',
        [
            'label' => esc_html__('Email Address', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => '',
            'placeholder' => esc_html__('info@example.com', 'promen-elementor-widgets'),
            'condition' => [
                'show_contact_info' => 'yes',
            ],
        ]
    );
    
    $widget->add_control(
        'contact_address',
        [
            'label' => esc_html__('Address', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'default' => '',
            'placeholder' => esc_html__('123 Main St, City, Country', 'promen-elementor-widgets'),
            'condition' => [
                'show_contact_info' => 'yes',
            ],
        ]
    );
    
    $widget->end_controls_section();
}

/**
 * Register style controls for hamburger menu widget
 */
function register_hamburger_menu_style_controls($widget) {
    // Hamburger Icon Style Section
    $widget->start_controls_section(
        'section_hamburger_icon_style',
        [
            'label' => esc_html__('Hamburger Icon', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Icon Type
    $widget->add_control(
        'hamburger_icon_type',
        [
            'label' => esc_html__('Icon Type', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'classic',
            'options' => [
                'classic' => esc_html__('Classic', 'promen-elementor-widgets'),
                'spin' => esc_html__('Spin', 'promen-elementor-widgets'),
                'elastic' => esc_html__('Elastic', 'promen-elementor-widgets'),
                'arrow' => esc_html__('Arrow', 'promen-elementor-widgets'),
                'minus' => esc_html__('Minus', 'promen-elementor-widgets'),
            ],
        ]
    );

    // Icon Size
    $widget->add_responsive_control(
        'hamburger_icon_size',
        [
            'label' => esc_html__('Icon Size', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 15,
                    'max' => 100,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 6,
                ],
                'rem' => [
                    'min' => 1,
                    'max' => 6,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 24,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .hamburger-bar' => 'width: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Bar Height
    $widget->add_responsive_control(
        'hamburger_bar_height',
        [
            'label' => esc_html__('Bar Height', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 10,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 2,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-bar' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Bar Spacing
    $widget->add_responsive_control(
        'hamburger_bar_spacing',
        [
            'label' => esc_html__('Bar Spacing', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 3,
                    'max' => 15,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 6,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-bar + .hamburger-bar' => 'margin-top: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Bar Border Radius
    $widget->add_control(
        'hamburger_bar_border_radius',
        [
            'label' => esc_html__('Bar Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'default' => [
                'top' => 0,
                'right' => 0,
                'bottom' => 0,
                'left' => 0,
                'unit' => 'px',
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-bar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    // Colors Tab
    $widget->start_controls_tabs('hamburger_colors');

    // Normal State
    $widget->start_controls_tab(
        'hamburger_colors_normal',
        [
            'label' => esc_html__('Normal', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'hamburger_bar_color',
        [
            'label' => esc_html__('Bar Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#000000',
            'selectors' => [
                '{{WRAPPER}} .hamburger-bar' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_tab();

    // Hover State
    $widget->start_controls_tab(
        'hamburger_colors_hover',
        [
            'label' => esc_html__('Hover', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'hamburger_bar_color_hover',
        [
            'label' => esc_html__('Bar Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#666666',
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__toggle:hover .hamburger-bar' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_tab();

    // Active State
    $widget->start_controls_tab(
        'hamburger_colors_active',
        [
            'label' => esc_html__('Active', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'hamburger_bar_color_active',
        [
            'label' => esc_html__('Bar Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#333333',
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__toggle.is-active .hamburger-bar' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_tab();

    $widget->end_controls_tabs();

    $widget->end_controls_section();

    // Submenu Style Section
    $widget->start_controls_section(
        'section_submenu_style',
        [
            'label' => esc_html__('Submenu', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Submenu Animation
    $widget->add_control(
        'submenu_animation',
        [
            'label' => esc_html__('Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'slide',
            'options' => [
                'slide' => esc_html__('Slide', 'promen-elementor-widgets'),
                'fade' => esc_html__('Fade', 'promen-elementor-widgets'),
                'zoom' => esc_html__('Zoom', 'promen-elementor-widgets'),
            ],
        ]
    );

    // Submenu Animation Duration
    $widget->add_control(
        'submenu_animation_duration',
        [
            'label' => esc_html__('Animation Duration', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['s'],
            'range' => [
                's' => [
                    'min' => 0.1,
                    'max' => 1,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 's',
                'size' => 0.3,
            ],
        ]
    );

    // Submenu Indent
    $widget->add_responsive_control(
        'submenu_indent',
        [
            'label' => esc_html__('Submenu Indent', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', '%'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 5,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 30,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 20,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__items .sub-menu' => 'padding-left: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Submenu Icon
    $widget->add_control(
        'submenu_icon',
        [
            'label' => esc_html__('Submenu Indicator', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'chevron',
            'options' => [
                'none' => esc_html__('None', 'promen-elementor-widgets'),
                'chevron' => esc_html__('Chevron', 'promen-elementor-widgets'),
                'plus' => esc_html__('Plus', 'promen-elementor-widgets'),
                'arrow' => esc_html__('Arrow', 'promen-elementor-widgets'),
            ],
        ]
    );

    $widget->end_controls_section();

    // Menu Panel Style
    $widget->start_controls_section(
        'section_menu_panel_style',
        [
            'label' => esc_html__('Menu Panel', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );
    
    // Panel Background
    $widget->add_control(
        'panel_background',
        [
            'label' => esc_html__('Panel Background', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel' => 'background-color: {{VALUE}};',
            ],
            'default' => '#000000',
        ]
    );
    
    // Panel Overlay Opacity
    $widget->add_control(
        'panel_overlay_opacity',
        [
            'label' => esc_html__('Background Opacity', 'promen-elementor-widgets'),
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
                'size' => 90,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel' => 'opacity: calc({{SIZE}} / 100);',
            ],
        ]
    );
    
    // Panel Width
    $widget->add_responsive_control(
        'panel_width',
        [
            'label' => esc_html__('Panel Width', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'vw'],
            'range' => [
                'px' => [
                    'min' => 200,
                    'max' => 1000,
                    'step' => 10,
                ],
                '%' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 1,
                ],
                'vw' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => '%',
                'size' => 100,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'panel_animation' => ['slide-left', 'slide-right', 'fade'],
            ],
        ]
    );
    
    // Panel Height
    $widget->add_responsive_control(
        'panel_height',
        [
            'label' => esc_html__('Panel Height', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'vh'],
            'range' => [
                'px' => [
                    'min' => 200,
                    'max' => 1000,
                    'step' => 10,
                ],
                '%' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 1,
                ],
                'vh' => [
                    'min' => 10,
                    'max' => 100,
                    'step' => 1,
                ],
            ],
            'default' => [
                'unit' => 'vh',
                'size' => 100,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel' => 'height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
    
    // Panel Padding
    $widget->add_responsive_control(
        'panel_padding',
        [
            'label' => esc_html__('Panel Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => [
                'top' => '50',
                'right' => '30',
                'bottom' => '50',
                'left' => '30',
                'unit' => 'px',
                'isLinked' => false,
            ],
        ]
    );
    
    $widget->end_controls_section();
    
    // Menu Items Style
    $widget->start_controls_section(
        'section_menu_items_style',
        [
            'label' => esc_html__('Menu Items', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );
    
    // Menu Item Color
    $widget->add_control(
        'menu_item_color',
        [
            'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel .menu-item > a' => 'color: {{VALUE}};',
            ],
            'default' => '#ffffff',
        ]
    );
    
    // Menu Item Hover Color
    $widget->add_control(
        'menu_item_hover_color',
        [
            'label' => esc_html__('Text Hover Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel .menu-item > a:hover, {{WRAPPER}} .hamburger-menu__panel .menu-item > a:focus' => 'color: {{VALUE}};',
            ],
            'default' => '#cccccc',
        ]
    );
    
    // Menu Item Active Color
    $widget->add_control(
        'menu_item_active_color',
        [
            'label' => esc_html__('Active Text Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel .current-menu-item > a, {{WRAPPER}} .hamburger-menu__panel .current-menu-ancestor > a' => 'color: {{VALUE}};',
            ],
            'default' => '#cccccc',
        ]
    );
    
    // Menu Item Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'menu_item_typography',
            'selector' => '{{WRAPPER}} .hamburger-menu__panel .menu-item > a',
        ]
    );
    
    // Menu Item Spacing
    $widget->add_control(
        'menu_item_spacing',
        [
            'label' => esc_html__('Item Vertical Spacing', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 15,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel .menu-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
    
    // Menu Item Alignment
    $widget->add_responsive_control(
        'menu_item_alignment',
        [
            'label' => esc_html__('Menu Alignment', 'promen-elementor-widgets'),
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
            'default' => 'center',
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__panel nav' => 'align-items: {{VALUE}};',
            ],
        ]
    );
    
    // Menu Item Entrance Animation
    $widget->add_control(
        'menu_items_animation',
        [
            'label' => esc_html__('Menu Items Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'fade-up',
            'options' => [
                'fade-up' => esc_html__('Fade Up', 'promen-elementor-widgets'),
                'fade-down' => esc_html__('Fade Down', 'promen-elementor-widgets'),
                'fade-left' => esc_html__('Fade Left', 'promen-elementor-widgets'),
                'fade-right' => esc_html__('Fade Right', 'promen-elementor-widgets'),
                'zoom-in' => esc_html__('Zoom In', 'promen-elementor-widgets'),
                'zoom-out' => esc_html__('Zoom Out', 'promen-elementor-widgets'),
                'none' => esc_html__('None', 'promen-elementor-widgets'),
            ],
        ]
    );
    
    $widget->end_controls_section();

    // Close Button Style Section
    $widget->start_controls_section(
        'section_close_button_style',
        [
            'label' => esc_html__('Close Button', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Close Button Size
    $widget->add_responsive_control(
        'close_button_size',
        [
            'label' => esc_html__('Size', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 20,
                    'max' => 60,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 4,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 24,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__close svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Close Button Color
    $widget->add_control(
        'close_button_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__close' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Close Button Hover Color
    $widget->add_control(
        'close_button_hover_color',
        [
            'label' => esc_html__('Hover Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#cccccc',
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__close:hover' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Close Button Position
    $widget->add_control(
        'close_button_position',
        [
            'label' => esc_html__('Position', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'top-right',
            'options' => [
                'top-right' => esc_html__('Top Right', 'promen-elementor-widgets'),
                'top-left' => esc_html__('Top Left', 'promen-elementor-widgets'),
            ],
        ]
    );

    // Close Button Spacing
    $widget->add_responsive_control(
        'close_button_spacing',
        [
            'label' => esc_html__('Spacing', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'default' => [
                'top' => '20',
                'right' => '20',
                'bottom' => '0',
                'left' => '0',
                'unit' => 'px',
                'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .hamburger-menu__close' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Submenu Indicator Style Section
    $widget->start_controls_section(
        'section_submenu_indicator_style',
        [
            'label' => esc_html__('Submenu Indicator', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Indicator Size
    $widget->add_responsive_control(
        'submenu_indicator_size',
        [
            'label' => esc_html__('Size', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0.5,
                    'max' => 3,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 24,
            ],
            'selectors' => [
                '{{WRAPPER}} .submenu-toggle svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Indicator Color
    $widget->add_control(
        'submenu_indicator_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .submenu-toggle' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Indicator Hover Color
    $widget->add_control(
        'submenu_indicator_hover_color',
        [
            'label' => esc_html__('Hover Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#cccccc',
            'selectors' => [
                '{{WRAPPER}} .submenu-toggle:hover' => 'color: {{VALUE}};',
            ],
        ]
    );

    // Indicator Spacing
    $widget->add_responsive_control(
        'submenu_indicator_spacing',
        [
            'label' => esc_html__('Spacing', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 3,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 8,
            ],
            'selectors' => [
                '{{WRAPPER}} .submenu-toggle' => 'margin-left: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    // Indicator Background
    $widget->add_control(
        'submenu_indicator_background',
        [
            'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .submenu-toggle' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    // Indicator Padding
    $widget->add_responsive_control(
        'submenu_indicator_padding',
        [
            'label' => esc_html__('Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em'],
            'selectors' => [
                '{{WRAPPER}} .submenu-toggle' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => [
                'top' => '4',
                'right' => '4',
                'bottom' => '4',
                'left' => '4',
                'unit' => 'px',
                'isLinked' => true,
            ],
        ]
    );

    // Indicator Border
    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'submenu_indicator_border',
            'selector' => '{{WRAPPER}} .submenu-toggle',
        ]
    );

    // Indicator Border Radius
    $widget->add_control(
        'submenu_indicator_border_radius',
        [
            'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors' => [
                '{{WRAPPER}} .submenu-toggle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();
} 