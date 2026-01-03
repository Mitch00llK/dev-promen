<?php
/**
 * Split Title Controls
 * 
 * Standardized controls for implementing split titles across all widgets.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add split title controls to a widget
 * 
 * @param \Elementor\Widget_Base $widget The widget instance
 * @param string $section_name The section name to add controls to
 * @param array $condition Optional condition for when to show these controls
 * @param string $default_title Default title text
 * @param string $title_control_name Optional custom name for the title control (default: 'title')
 */
function promen_add_split_title_controls($widget, $section_name = 'section_header', $condition = [], $default_title = '', $title_control_name = 'title') {
    // Add the title control
    $widget->add_control(
        $title_control_name,
        [
            'label' => esc_html__('Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => $default_title ?: esc_html__('Your Title Here', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Enter your title', 'promen-elementor-widgets'),
            'label_block' => true,
            'condition' => array_merge($condition, ['split_title!' => 'yes']),
        ]
    );

    // Add the split title switcher
    $widget->add_control(
        'split_title',
        [
            'label' => esc_html__('Use Split Title', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
            'label_off' => esc_html__('No', 'promen-elementor-widgets'),
            'return_value' => 'yes',
            'default' => 'no',
            'condition' => $condition,
        ]
    );

    // Add the split title parts
    $widget->add_control(
        'title_part_1',
        [
            'label' => esc_html__('Title Part 1', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('First part of', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Enter first part of title', 'promen-elementor-widgets'),
            'label_block' => true,
            'condition' => array_merge($condition, ['split_title' => 'yes']),
        ]
    );

    $widget->add_control(
        'title_part_2',
        [
            'label' => esc_html__('Title Part 2', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__('your split title', 'promen-elementor-widgets'),
            'placeholder' => esc_html__('Enter second part of title', 'promen-elementor-widgets'),
            'label_block' => true,
            'condition' => array_merge($condition, ['split_title' => 'yes']),
        ]
    );

    // Add title HTML tag selector
    $widget->add_control(
        'title_html_tag',
        [
            'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::SELECT,
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
            'condition' => $condition,
        ]
    );
}

/**
 * Add style controls for split title parts
 * 
 * @param \Elementor\Widget_Base $widget The widget instance
 * @param string $section_name The section name to add controls to
 * @param array $condition Optional condition for when to show these controls
 * @param string $class_prefix Optional prefix for CSS classes (default: 'promen')
 * @param string $title_control_name Optional custom name for the title control (default: 'title')
 */
function promen_add_split_title_style_controls($widget, $section_name = 'section_title_style', $condition = [], $class_prefix = 'promen', $title_control_name = 'title') {
    // Start Style Section
    $widget->start_controls_section(
        $section_name,
        [
            'label' => esc_html__('Title Style', 'promen-elementor-widgets'),
            'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        ]
    );

    // Title Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_typography',
            'label' => esc_html__('Title Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .' . $class_prefix . '-title',
            'condition' => array_merge($condition, ['split_title!' => 'yes']),
        ]
    );

    // Title Color
    $widget->add_control(
        'title_color',
        [
            'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .' . $class_prefix . '-title' => 'color: {{VALUE}};',
            ],
            'condition' => array_merge($condition, ['split_title!' => 'yes']),
        ]
    );

    // Split Title Part 1 Heading
    $widget->add_control(
        'title_part_1_heading',
        [
            'label' => esc_html__('Title Part 1 Style', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array_merge($condition, ['split_title' => 'yes']),
        ]
    );

    // Title Part 1 Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_part_1_typography',
            'label' => esc_html__('Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .' . $class_prefix . '-title-part-1',
            'condition' => array_merge($condition, ['split_title' => 'yes']),
        ]
    );

    // Title Part 1 Color
    $widget->add_control(
        'title_part_1_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .' . $class_prefix . '-title-part-1' => 'color: {{VALUE}};',
            ],
            'condition' => array_merge($condition, ['split_title' => 'yes']),
        ]
    );

    // Split Title Part 2 Heading
    $widget->add_control(
        'title_part_2_heading',
        [
            'label' => esc_html__('Title Part 2 Style', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::HEADING,
            'separator' => 'before',
            'condition' => array_merge($condition, ['split_title' => 'yes']),
        ]
    );

    // Title Part 2 Typography
    $widget->add_group_control(
        \Elementor\Group_Control_Typography::get_type(),
        [
            'name' => 'title_part_2_typography',
            'label' => esc_html__('Typography', 'promen-elementor-widgets'),
            'selector' => '{{WRAPPER}} .' . $class_prefix . '-title-part-2',
            'condition' => array_merge($condition, ['split_title' => 'yes']),
        ]
    );

    // Title Part 2 Color
    $widget->add_control(
        'title_part_2_color',
        [
            'label' => esc_html__('Color', 'promen-elementor-widgets'),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .' . $class_prefix . '-title-part-2' => 'color: {{VALUE}};',
            ],
            'condition' => array_merge($condition, ['split_title' => 'yes']),
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
            'selectors' => [
                '{{WRAPPER}} .' . $class_prefix . '-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
            ],
            'separator' => 'before',
        ]
    );

    // Title Alignment
    $widget->add_responsive_control(
        'title_alignment',
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
            'default' => 'left',
            'selectors' => [
                '{{WRAPPER}} .' . $class_prefix . '-title' => 'text-align: {{VALUE}};',
            ],
        ]
    );

    $widget->end_controls_section();
}

/**
 * Render a split title
 * 
 * @param \Elementor\Widget_Base $widget The widget instance
 * @param array $settings The widget settings
 * @param string $title_control_name Optional custom name for the title control (default: 'title')
 * @param string $class_prefix Optional prefix for CSS classes (default: 'promen')
 * @return string The rendered HTML
 */
function promen_render_split_title($widget, $settings, $title_control_name = 'title', $class_prefix = 'promen') {
    $html = '';
    // Default to h2 for promen-services-title, otherwise h3
    $default_tag = ($class_prefix === 'promen-services') ? 'h2' : 'h3';
    $title_tag = isset($settings['title_html_tag']) && !empty($settings['title_html_tag']) ? $settings['title_html_tag'] : $default_tag;
    
    if (isset($settings['split_title']) && $settings['split_title'] === 'yes') {
        // Render split title
        if (!empty($settings['title_part_1']) || !empty($settings['title_part_2'])) {
            $html .= '<' . $title_tag . ' class="' . $class_prefix . '-title ' . $class_prefix . '-split-title">';
            
            if (!empty($settings['title_part_1'])) {
                $html .= '<span class="' . $class_prefix . '-title-part-1">' . esc_html($settings['title_part_1']) . '</span>';
            }
            
            if (!empty($settings['title_part_2'])) {
                $html .= ' <span class="' . $class_prefix . '-title-part-2">' . esc_html($settings['title_part_2']) . '</span>';
            }
            
            $html .= '</' . $title_tag . '>';
        }
    } else {
        // Render regular title
        if (!empty($settings[$title_control_name])) {
            $html .= '<' . $title_tag . ' class="' . $class_prefix . '-title">';
            $html .= esc_html($settings[$title_control_name]);
            $html .= '</' . $title_tag . '>';
        }
    }
    
    return $html;
} 