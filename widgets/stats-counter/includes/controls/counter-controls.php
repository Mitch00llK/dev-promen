<?php
/**
 * Stats Counter Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register content controls for the Stats Counter widget
 */
function register_stats_counter_content_controls($widget) {
    // Content Section
    $widget->start_controls_section(
        'section_content',
        [
            'label' => esc_html__('Content', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    // Section Title Controls
    $widget->add_control(
        'show_section_title',
        [
            'label' => esc_html__('Show Section Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'no',
        ]
    );

    // Use the standardized split title controls
    promen_add_split_title_controls(
        $widget, 
        'section_content', 
        ['show_section_title' => 'yes'], 
        esc_html__('Our Statistics', 'promen-elementor-widgets'),
        'section_title'
    );

    $repeater = new \Elementor\Repeater();

    $repeater->add_control(
        'counter_number',
        [
            'label' => esc_html__('Counter Number', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 100,
            'min' => 0,
            'max' => 9999,
            'step' => 1,
        ]
    );

    $repeater->add_control(
        'counter_title',
        [
            'label' => esc_html__('Counter Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Counter Title', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Enter counter title', 'promen-elementor-widgets'),
        ]
    );

    $repeater->add_control(
        'show_counter',
        [
            'label' => esc_html__('Show Counter', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
            'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'counter_items',
        [
            'label' => esc_html__('Counter Items', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'counter_number' => 120,
                    'counter_title' => esc_html__('Re-integratie', 'promen-elementor-widgets'),
                    'show_counter' => 'yes',
                ],
                [
                    'counter_number' => 23,
                    'counter_title' => esc_html__('Talenten ontdekt', 'promen-elementor-widgets'),
                    'show_counter' => 'yes',
                ],
                [
                    'counter_number' => 36,
                    'counter_title' => esc_html__('Tevreden klanten', 'promen-elementor-widgets'),
                    'show_counter' => 'yes',
                ],
            ],
            'title_field' => '{{{ counter_title }}} - {{{ counter_number }}}',
        ]
    );

    $widget->end_controls_section();
}

/**
 * Register layout controls for the Stats Counter widget
 */
function register_stats_counter_layout_controls($widget) {
    // Layout Section
    $widget->start_controls_section(
        'section_layout',
        [
            'label' => esc_html__('Layout', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_responsive_control(
        'columns',
        [
            'label' => esc_html__('Columns', 'promen-elementor-widgets'),
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
                '{{WRAPPER}} .promen-stats-counter-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ]
    );

    $widget->add_responsive_control(
        'column_gap',
        [
            'label' => esc_html__('Columns Gap', 'promen-elementor-widgets'),
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
                '{{WRAPPER}} .promen-stats-counter-container' => 'column-gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'row_gap',
        [
            'label' => esc_html__('Rows Gap', 'promen-elementor-widgets'),
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
                '{{WRAPPER}} .promen-stats-counter-container' => 'row-gap: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'alignment',
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
                '{{WRAPPER}} .promen-stats-counter-item' => 'text-align: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();
}

/**
 * Register style controls for the Stats Counter widget
 */
function register_stats_counter_style_controls($widget) {
    // Section Title Style
    $widget->start_controls_section(
        'section_title_style',
        [
            'label' => esc_html__('Section Title', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            'condition' => [
                'show_section_title' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'section_title_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .promen-stats-counter-section-title' => 'color: {{VALUE}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'section_title_typography',
            'selector' => '{{WRAPPER}} .promen-stats-counter-section-title',
        ]
    );

    $widget->add_responsive_control(
        'section_title_margin',
        [
            'label' => esc_html__('Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'default' => [
                'top' => '0',
                'right' => '0',
                'bottom' => '2',
                'left' => '0',
                'unit' => 'rem',
                'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .promen-stats-counter-section-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_responsive_control(
        'section_title_alignment',
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
                '{{WRAPPER}} .promen-stats-counter-section-title' => 'text-align: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();

    // Counter Circle Style Section
    $widget->start_controls_section(
        'section_counter_circle_style',
        [
            'label' => esc_html__('Counter Circle', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_responsive_control(
        'circle_size',
        [
            'label' => esc_html__('Circle Size', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', 'em', 'rem'],
            'range' => [
                'px' => [
                    'min' => 50,
                    'max' => 300,
                ],
                'em' => [
                    'min' => 3,
                    'max' => 20,
                ],
                'rem' => [
                    'min' => 3,
                    'max' => 20,
                ],
            ],
            'default' => [
                'unit' => 'rem',
                'size' => 10,
            ],
            'selectors' => [
                '{{WRAPPER}} .promen-counter-circle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_control(
        'circle_background_color',
        [
            'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#E99D4E',
            'selectors' => [
                '{{WRAPPER}} .promen-counter-circle' => 'background-color: {{VALUE}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Border::get_type(),
        [
            'name' => 'circle_border',
            'selector' => '{{WRAPPER}} .promen-counter-circle',
        ]
    );

    $widget->add_responsive_control(
        'circle_border_radius',
        [
            'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%', 'em', 'rem'],
            'default' => [
                'top' => '50',
                'right' => '50',
                'bottom' => '50',
                'left' => '50',
                'unit' => '%',
                'isLinked' => true,
            ],
            'selectors' => [
                '{{WRAPPER}} .promen-counter-circle' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name' => 'circle_box_shadow',
            'selector' => '{{WRAPPER}} .promen-counter-circle',
        ]
    );

    $widget->end_controls_section();

    // Counter Number Style Section
    $widget->start_controls_section(
        'section_counter_number_style',
        [
            'label' => esc_html__('Counter Number', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_control(
        'number_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#FFFFFF',
            'selectors' => [
                '{{WRAPPER}} .promen-counter-number' => 'color: {{VALUE}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'number_typography',
            'selector' => '{{WRAPPER}} .promen-counter-number',
            'default' => [
                'font_size' => '3rem',
                'font_weight' => '700',
            ],
        ]
    );

    $widget->end_controls_section();

    // Counter Title Style Section
    $widget->start_controls_section(
        'section_counter_title_style',
        [
            'label' => esc_html__('Counter Title', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    $widget->add_control(
        'title_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'default' => '#0A3254',
            'selectors' => [
                '{{WRAPPER}} .promen-counter-title' => 'color: {{VALUE}};',
            ],
        ]
    );

    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_typography',
            'selector' => '{{WRAPPER}} .promen-counter-title',
            'default' => [
                'font_size' => '1.25rem',
                'font_weight' => '600',
            ],
        ]
    );

    $widget->add_responsive_control(
        'title_margin',
        [
            'label' => esc_html__('Margin', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', 'rem', '%'],
            'default' => [
                'top' => '1',
                'right' => '0',
                'bottom' => '0',
                'left' => '0',
                'unit' => 'rem',
                'isLinked' => false,
            ],
            'selectors' => [
                '{{WRAPPER}} .promen-counter-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

    $widget->end_controls_section();
}

/**
 * Register animation controls for the Stats Counter widget
 */
function register_stats_counter_animation_controls($widget) {
    // Animation Section
    $widget->start_controls_section(
        'section_animation',
        [
            'label' => esc_html__('Animation', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'enable_animation',
        [
            'label' => esc_html__('Enable Animation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
        ]
    );

    $widget->add_control(
        'animation_duration',
        [
            'label' => esc_html__('Animation Duration (ms)', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 2000,
            'min' => 100,
            'max' => 10000,
            'step' => 100,
            'condition' => [
                'enable_animation' => 'yes',
            ],
        ]
    );

    $widget->end_controls_section();
}

/**
 * Register accessibility controls for the Stats Counter widget
 */
function register_stats_counter_accessibility_controls($widget) {
    // Accessibility Section
    $widget->start_controls_section(
        'section_accessibility',
        [
            'label' => esc_html__('Accessibility', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
        ]
    );

    $widget->add_control(
        'stats_aria_label',
        [
            'label' => esc_html__('Statistics Label', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('Statistics', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Enter statistics label for screen readers', 'promen-elementor-widgets'),
            'description' => esc_html__('This label will be announced to screen readers when the statistics section is focused.', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'announce_counter_changes',
        [
            'label' => esc_html__('Announce Counter Changes', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Announce counter animations and changes to screen readers.', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'enable_keyboard_navigation',
        [
            'label' => esc_html__('Enable Keyboard Navigation', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Allow users to navigate between statistics using keyboard.', 'promen-elementor-widgets'),
        ]
    );

    $widget->add_control(
        'pause_animation_on_focus',
        [
            'label' => esc_html__('Pause Animation on Focus', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Pause counter animations when user focuses on the statistics.', 'promen-elementor-widgets'),
            'condition' => [
                'enable_animation' => 'yes',
            ],
        ]
    );

    $widget->add_control(
        'respect_reduced_motion',
        [
            'label' => esc_html__('Respect Reduced Motion', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'yes',
            'description' => esc_html__('Disable animations for users who prefer reduced motion.', 'promen-elementor-widgets'),
        ]
    );

    $widget->end_controls_section();
} 