<?php
/**
 * Checklist Comparison Widget Content Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Checklist_Comparison_Content_Controls {

    /**
     * Register content controls for the widget
     */
    public static function register_controls($widget) {
        self::register_left_column_section($widget);
        self::register_right_column_section($widget);
        self::register_layout_settings_section($widget);
    }

    /**
     * Register left column section controls
     */
    private static function register_left_column_section($widget) {
        $widget->start_controls_section(
            'section_left_column',
            [
                'label' => esc_html__('Left Column', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_left_heading',
            [
                'label' => esc_html__('Show Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'left_heading',
            [
                'label' => esc_html__('Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Wie ben jij?', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter left column heading', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_left_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'left_heading_tag',
            [
                'label' => esc_html__('Heading Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'show_left_heading' => 'yes',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label' => esc_html__('Item Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter checklist item text', 'promen-elementor-widgets'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'icon_type',
            [
                'label' => esc_html__('Icon Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'icon_type' => 'custom',
                ],
            ]
        );

        $widget->add_control(
            'left_checklist_items',
            [
                'label' => esc_html__('Checklist Items', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_text' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                    ],
                    [
                        'item_text' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                    ],
                    [
                        'item_text' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                    ],
                    [
                        'item_text' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register right column section controls
     */
    private static function register_right_column_section($widget) {
        $widget->start_controls_section(
            'section_right_column',
            [
                'label' => esc_html__('Right Column', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_right_heading',
            [
                'label' => esc_html__('Show Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'right_heading',
            [
                'label' => esc_html__('Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Wat bieden wij?', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter right column heading', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_right_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'right_heading_tag',
            [
                'label' => esc_html__('Heading Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'show_right_heading' => 'yes',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'item_text',
            [
                'label' => esc_html__('Item Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter checklist item text', 'promen-elementor-widgets'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'icon_type',
            [
                'label' => esc_html__('Icon Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
                ],
            ]
        );

        $repeater->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'icon_type' => 'custom',
                ],
            ]
        );

        $widget->add_control(
            'right_checklist_items',
            [
                'label' => esc_html__('Checklist Items', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'item_text' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                    ],
                    [
                        'item_text' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                    ],
                    [
                        'item_text' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                    ],
                    [
                        'item_text' => esc_html__('Een afgeronde HBO/WO opleiding, bij voorkeur in een communicatie richting', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register layout settings section
     */
    private static function register_layout_settings_section($widget) {
        $widget->start_controls_section(
            'section_layout_settings',
            [
                'label' => esc_html__('Layout Settings', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_responsive_control(
            'columns_gap',
            [
                'label' => esc_html__('Columns Gap', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
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
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__container' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'items_spacing',
            [
                'label' => esc_html__('Items Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
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
                    'unit' => 'px',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-checklist-comparison__item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .promen-checklist-comparison__item:last-child' => 'margin-bottom: 0;',
                ],
            ]
        );

        $widget->end_controls_section();
        
        // Add Default Icons Section
        self::register_default_icons_section($widget);
    }
    
    /**
     * Register default icons section
     */
    private static function register_default_icons_section($widget) {
        $widget->start_controls_section(
            'section_default_icons',
            [
                'label' => esc_html__('Default Icon', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $widget->add_control(
            'custom_default_icon',
            [
                'label' => esc_html__('Use Custom Default Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Set a custom default icon for all list items. Individual items with custom icons will override this default.', 'promen-elementor-widgets'),
            ]
        );
        
        $widget->add_control(
            'default_icon',
            [
                'label' => esc_html__('Default Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'custom_default_icon' => 'yes',
                ],
            ]
        );
        
        $widget->end_controls_section();
    }
} 