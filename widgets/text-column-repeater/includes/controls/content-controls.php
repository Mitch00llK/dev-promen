<?php
/**
 * Text Column Repeater Widget Content Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Text_Column_Repeater_Content_Controls {

    /**
     * Register content controls for the widget
     */
    public static function register_controls($widget) {
        self::register_heading_section($widget);
        self::register_tool_items_section($widget);
    }

    /**
     * Register heading section controls
     */
    private static function register_heading_section($widget) {
        $widget->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_heading',
            [
                'label' => esc_html__('Show Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Split Title functionality
        $widget->add_control(
            'enable_split_heading',
            [
                'label' => esc_html__('Enable Split Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'no',
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'heading_text',
            [
                'label' => esc_html__('Heading Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('De verschillende tools', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter your heading', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_heading' => 'yes',
                    'enable_split_heading!' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'split_text_before',
            [
                'label' => esc_html__('Text Before Split', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('De verschillende', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Text before split', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_heading' => 'yes',
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'split_text_after',
            [
                'label' => esc_html__('Text After Split', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('tools', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Text after split', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_heading' => 'yes',
                    'enable_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'heading_tag',
            [
                'label' => esc_html__('Heading Tag', 'promen-elementor-widgets'),
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
                    'show_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'show_subtitle',
            [
                'label' => esc_html__('Show Subtitle', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'subtitle_text',
            [
                'label' => esc_html__('Subtitle Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('In a world of endless possibilities, creativity flows like a river, shaping dreams and igniting passions that inspire us all.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter your subtitle', 'promen-elementor-widgets'),
                'rows' => 3,
                'condition' => [
                    'show_heading' => 'yes',
                    'show_subtitle' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'subtitle_max_chars',
            [
                'label' => esc_html__('Max Characters', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
                'min' => 10,
                'max' => 500,
                'step' => 10,
                'condition' => [
                    'show_heading' => 'yes',
                    'show_subtitle' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register tool items section controls
     */
    private static function register_tool_items_section($widget) {
        $widget->start_controls_section(
            'section_tool_items',
            [
                'label' => esc_html__('Tool Items', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .text-column-repeater__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'show_tool_title',
            [
                'label' => esc_html__('Show Tool Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'tool_title',
            [
                'label' => esc_html__('Tool Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Naam van tool', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter tool title', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_tool_title' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'tool_title_tag',
            [
                'label' => esc_html__('Title Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'show_tool_title' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_tool_description',
            [
                'label' => esc_html__('Show Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'tool_description',
            [
                'label' => esc_html__('Tool Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('In the realm of dreams, where shadows dance and whispers sing, the heart finds solace in the embrace of twilight\'s glow, weaving tales of wonder and joy beneath the starlit sky.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter tool description', 'promen-elementor-widgets'),
                'rows' => 5,
                'condition' => [
                    'show_tool_description' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'description_max_chars',
            [
                'label' => esc_html__('Max Characters', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 200,
                'min' => 10,
                'max' => 500,
                'step' => 10,
                'condition' => [
                    'show_tool_description' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'tool_items',
            [
                'label' => esc_html__('Tool Items', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tool_title' => esc_html__('Naam van tool', 'promen-elementor-widgets'),
                        'tool_description' => esc_html__('In the realm of dreams, where shadows dance and whispers sing, the heart finds solace in the embrace of twilight\'s glow, weaving tales of wonder and joy beneath the starlit sky.', 'promen-elementor-widgets'),
                    ],
                    [
                        'tool_title' => esc_html__('Naam van tool', 'promen-elementor-widgets'),
                        'tool_description' => esc_html__('In the realm of dreams, where shadows dance and whispers sing, the heart finds solace in the embrace of twilight\'s glow, weaving tales of wonder and joy beneath the starlit sky.', 'promen-elementor-widgets'),
                    ],
                    [
                        'tool_title' => esc_html__('Naam van tool', 'promen-elementor-widgets'),
                        'tool_description' => esc_html__('In the realm of dreams, where shadows dance and whispers sing, the heart finds solace in the embrace of twilight\'s glow, weaving tales of wonder and joy beneath the starlit sky.', 'promen-elementor-widgets'),
                    ],
                    [
                        'tool_title' => esc_html__('Naam van tool', 'promen-elementor-widgets'),
                        'tool_description' => esc_html__('In the realm of dreams, where shadows dance and whispers sing, the heart finds solace in the embrace of twilight\'s glow, weaving tales of wonder and joy beneath the starlit sky.', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ tool_title }}}',
            ]
        );

        $widget->end_controls_section();
    }
} 