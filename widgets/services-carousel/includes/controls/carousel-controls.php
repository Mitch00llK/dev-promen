<?php
/**
 * Services Carousel Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register content controls for the services carousel widget
 */
function register_services_carousel_content_controls($widget) {
    // Content Section
    $widget->start_controls_section(
        'section_content',
        [
            'label' => esc_html__('Content', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    // Use the standardized split title controls
    promen_add_split_title_controls(
        $widget, 
        'section_content', 
        [], 
        esc_html__('Our Services', 'promen-elementor-widgets'),
        'section_title'
    );
    
    // Override the default HTML tag to H2 for services title
    $widget->update_control(
        'title_html_tag',
        [
            'default' => 'h2',
        ]
    );

    $widget->add_control(
        'section_title_color',
        [
            'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#002266',
            'selectors' => [
                '{{WRAPPER}} .promen-services-title' => 'color: {{VALUE}}',
                '{{WRAPPER}} .promen-title' => 'color: {{VALUE}}',
                '{{WRAPPER}} .promen-title-part-1' => 'color: {{VALUE}}',
                '{{WRAPPER}} .promen-title-part-2' => 'color: {{VALUE}}',
            ],
        ]
    );

    // Services Repeater
    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
        'service_icon',
        [
            'label' => esc_html__('Icon', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-gem',
                'library' => 'fa-solid',
            ],
            'recommended' => [
                'fa-solid' => [
                    'gem',
                    'briefcase',
                    'users',
                    'graduation-cap',
                    'search',
                    'file-alt',
                    'chart-line',
                ],
            ],
        ]
    );

    $repeater->add_control(
        'service_title',
        [
            'label' => esc_html__('Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Service Title', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Enter service title', 'promen-elementor-widgets'),
        ]
    );

    $repeater->add_control(
        'service_title_html_tag',
        [
            'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'span',
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
        ]
    );

    $repeater->add_control(
        'service_link',
        [
            'label' => esc_html__('Link', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::URL,
            'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
            'default' => [
                'url' => '#',
                'is_external' => false,
                'nofollow' => false,
            ],
        ]
    );

    $repeater->add_control(
        'service_icon_color',
        [
            'label' => esc_html__('Icon Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#002266',
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .service-icon' => 'color: {{VALUE}}',
                '{{WRAPPER}} {{CURRENT_ITEM}} .service-icon svg' => 'fill: {{VALUE}}',
            ],
        ]
    );

    $repeater->add_control(
        'service_title_color',
        [
            'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#002266',
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} .service-title' => 'color: {{VALUE}}',
            ],
        ]
    );

    $repeater->add_control(
        'service_background_color',
        [
            'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#DFEBD1',
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'background-color: {{VALUE}}',
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
                    'service_icon' => [
                        'value' => 'fas fa-gem',
                        'library' => 'fa-solid',
                    ],
                    'service_title' => esc_html__('Talentenplein', 'promen-elementor-widgets'),
                    'service_link' => [
                        'url' => '#',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                ],
                [
                    'service_icon' => [
                        'value' => 'fas fa-briefcase',
                        'library' => 'fa-solid',
                    ],
                    'service_title' => esc_html__('Werkbedrijf', 'promen-elementor-widgets'),
                    'service_link' => [
                        'url' => '#',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                ],
                [
                    'service_icon' => [
                        'value' => 'fas fa-users',
                        'library' => 'fa-solid',
                    ],
                    'service_title' => esc_html__('Jobcoaching', 'promen-elementor-widgets'),
                    'service_link' => [
                        'url' => '#',
                        'is_external' => false,
                        'nofollow' => false,
                    ],
                ],
            ],
            'title_field' => '{{{ service_title }}}',
        ]
    );

    $widget->end_controls_section();
}

/**
 * Register layout controls for the services carousel widget
 */
function register_services_carousel_layout_controls($widget) {
    // Layout Section
    $widget->start_controls_section(
        'section_layout',
        [
            'label' => esc_html__('Layout', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'fullwidth_carousel',
        [
            'label' => esc_html__('Fullwidth Carousel', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'no',
        ]
    );

    $widget->add_control(
        'cards_per_view',
        [
            'label' => esc_html__('Cards Per View (Desktop)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'default' => 3,
        ]
    );

    $widget->add_control(
        'cards_per_view_tablet',
        [
            'label' => esc_html__('Cards Per View (Tablet)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'default' => 2,
        ]
    );

    $widget->add_control(
        'cards_per_view_mobile',
        [
            'label' => esc_html__('Cards Per View (Mobile)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'default' => 1,
        ]
    );

    $widget->add_control(
        'center_mode',
        [
            'label' => esc_html__('Center Mode', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'no',
        ]
    );

    $widget->add_control(
        'center_padding',
        [
            'label' => esc_html__('Center Padding (Desktop)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 50,
            ],
            'condition' => [
                'center_mode' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'center_mode_tablet',
        [
            'label' => esc_html__('Center Mode (Tablet)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'center_mode' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'center_padding_tablet',
        [
            'label' => esc_html__('Center Padding (Tablet)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 30,
            ],
            'condition' => [
                'center_mode' => 'yes',
                'center_mode_tablet' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'center_mode_mobile',
        [
            'label' => esc_html__('Center Mode (Mobile)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'condition' => [
                'center_mode' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'center_padding_mobile',
        [
            'label' => esc_html__('Center Padding (Mobile)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 200,
                    'step' => 1,
                ],
                '%' => [
                    'min' => 0,
                    'max' => 50,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'px',
                'size' => 20,
            ],
            'condition' => [
                'center_mode' => 'yes',
                'center_mode_mobile' => 'yes',
            ],
        ]
    );

    $widget->end_controls_section();
}

/**
 * Register style controls for the services carousel widget
 */
function register_services_carousel_style_controls($widget) {
    // Style Section - Cards
    $widget->start_controls_section(
        'section_style_cards',
        [
            'label' => esc_html__('Cards', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_responsive_control(
        'card_padding',
        [
            'label' => esc_html__('Card Padding', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => [
                '{{WRAPPER}} .service-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => [
                'top' => '2',
                'right' => '2',
                'bottom' => '2',
                'left' => '2',
                'unit' => 'rem',
                'isLinked' => true,
            ],
        ]
    );

    $widget->add_responsive_control(
        'card_margin',
        [
            'label' => esc_html__('Card Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => [
                '{{WRAPPER}} .service-card' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => [
                'top' => '0',
                'right' => '0.5',
                'bottom' => '0',
                'left' => '0.5',
                'unit' => 'rem',
                'isLinked' => false,
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'card_border',
            'selector' => '{{WRAPPER}} .service-card',
        ]
    );

    $widget->add_responsive_control(
        'card_border_radius',
        [
            'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'selectors' => [
                '{{WRAPPER}} .service-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'default' => [
                'top' => '1',
                'right' => '1',
                'bottom' => '1',
                'left' => '1',
                'unit' => 'rem',
                'isLinked' => true,
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'card_box_shadow',
            'selector' => '{{WRAPPER}} .service-card',
        ]
    );

    $widget->end_controls_section();

    // Style Section - Icons
    $widget->start_controls_section(
        'section_style_icons',
        [
            'label' => esc_html__('Icons', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_responsive_control(
        'icon_size',
        [
            'label' => esc_html__('Icon Size', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 200,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 1,
                    'max' => 20,
                    'step' => 0.1,
                ],
                'rem' => [
                    'min' => 1,
                    'max' => 20,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 'rem',
                'size' => 3,
            ],
            'selectors' => [
                '{{WRAPPER}} .service-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .service-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'icon_margin_bottom',
        [
            'label' => esc_html__('Icon Bottom Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                    'step' => 1,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 0.1,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 10,
                    'step' => 0.1,
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

    // Style Section - Title
    $widget->start_controls_section(
        'section_style_title',
        [
            'label' => esc_html__('Title', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .service-title',
        ]
    );

    $widget->end_controls_section();
}

/**
 * Register animation controls for the services carousel widget
 */
function register_services_carousel_animation_controls($widget) {
    // Carousel Settings Section
    $widget->start_controls_section(
        'section_carousel_settings',
        [
            'label' => esc_html__('Carousel Settings', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'infinite',
        [
            'label' => esc_html__('Infinite Loop', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'autoplay',
        [
            'label' => esc_html__('Autoplay', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'autoplay_speed',
        [
            'label' => esc_html__('Autoplay Speed', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 1000,
            'max' => 10000,
            'step' => 500,
            'default' => 3000,
            'condition' => [
                'autoplay' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'speed',
        [
            'label' => esc_html__('Animation Speed', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'min' => 100,
            'max' => 5000,
            'step' => 100,
            'default' => 500,
        ]
    );

    $widget->add_control(
        'show_arrows',
        [
            'label' => esc_html__('Show Arrows', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'prev_arrow_icon',
        [
            'label' => esc_html__('Previous Arrow Icon', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-chevron-left',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'show_arrows' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'next_arrow_icon',
        [
            'label' => esc_html__('Next Arrow Icon', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value' => 'fas fa-chevron-right',
                'library' => 'fa-solid',
            ],
            'condition' => [
                'show_arrows' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'arrows_position_type',
        [
            'label' => esc_html__('Arrows Position', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'outside',
            'options' => [
                'outside' => esc_html__('Outside', 'promen-elementor-widgets'),
                'inside' => esc_html__('Inside', 'promen-elementor-widgets'),
            ],
            'condition' => [
                'show_arrows' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'gradient_overlay',
        [
            'label' => esc_html__('Gradient Overlay', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'gradient_intensity',
        [
            'label' => esc_html__('Gradient Intensity', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'medium',
            'options' => [
                'light' => esc_html__('Light', 'promen-elementor-widgets'),
                'medium' => esc_html__('Medium', 'promen-elementor-widgets'),
                'strong' => esc_html__('Strong', 'promen-elementor-widgets'),
            ],
            'condition' => [
                'gradient_overlay' => 'yes',
            ],
        ]
    );

    $widget->end_controls_section();
    
    // GSAP Animation Section
    $widget->start_controls_section(
        'section_gsap_animation',
        [
            'label' => esc_html__('GSAP Animation', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'enable_gsap_animation',
        [
            'label' => esc_html__('Enable Stagger Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'stagger_duration',
        [
            'label' => esc_html__('Animation Duration', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['s'],
            'range' => [
                's' => [
                    'min' => 0.1,
                    'max' => 3,
                    'step' => 0.1,
                ],
            ],
            'default' => [
                'unit' => 's',
                'size' => 0.8,
            ],
            'condition' => [
                'enable_gsap_animation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'stagger_delay',
        [
            'label' => esc_html__('Stagger Delay', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['s'],
            'range' => [
                's' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.05,
                ],
            ],
            'default' => [
                'unit' => 's',
                'size' => 0.15,
            ],
            'condition' => [
                'enable_gsap_animation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'animation_easing',
        [
            'label' => esc_html__('Easing', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
            'default' => 'power2.out',
            'options' => [
                'power1.out' => esc_html__('Power1 Out', 'promen-elementor-widgets'),
                'power2.out' => esc_html__('Power2 Out', 'promen-elementor-widgets'),
                'power3.out' => esc_html__('Power3 Out', 'promen-elementor-widgets'),
                'power4.out' => esc_html__('Power4 Out', 'promen-elementor-widgets'),
                'back.out' => esc_html__('Back Out', 'promen-elementor-widgets'),
                'elastic.out' => esc_html__('Elastic Out', 'promen-elementor-widgets'),
                'sine.out' => esc_html__('Sine Out', 'promen-elementor-widgets'),
                'expo.out' => esc_html__('Expo Out', 'promen-elementor-widgets'),
                'bounce.out' => esc_html__('Bounce Out', 'promen-elementor-widgets'),
            ],
            'condition' => [
                'enable_gsap_animation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'start_opacity',
        [
            'label' => esc_html__('Start Opacity', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.05,
                ],
            ],
            'default' => [
                'size' => 0,
            ],
            'condition' => [
                'enable_gsap_animation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'y_distance',
        [
            'label' => esc_html__('Y Distance', 'promen-elementor-widgets'),
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
                'size' => 30,
            ],
            'condition' => [
                'enable_gsap_animation' => 'yes',
            ],
        ]
    );

    $widget->end_controls_section();
} 