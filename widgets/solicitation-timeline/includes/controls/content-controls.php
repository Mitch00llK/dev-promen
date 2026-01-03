<?php
/**
 * Solicitation Timeline Widget Content Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Solicitation_Timeline_Content_Controls {

    /**
     * Register content controls for the widget
     */
    public static function register_controls($widget) {
        self::register_heading_section($widget);
        self::register_timeline_steps_section($widget);
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
                'default' => esc_html__('Onze sollicitatieprocedure', 'promen-elementor-widgets'),
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
                'default' => esc_html__('Onze', 'promen-elementor-widgets'),
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
                'default' => esc_html__('sollicitatieprocedure', 'promen-elementor-widgets'),
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
            'show_intro_text',
            [
                'label' => esc_html__('Show Intro Text', 'promen-elementor-widgets'),
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
            'intro_text',
            [
                'label' => esc_html__('Intro Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Weet waar je aan toe bent', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter intro text', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_heading' => 'yes',
                    'show_intro_text' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register timeline steps section controls
     */
    private static function register_timeline_steps_section($widget) {
        $widget->start_controls_section(
            'section_timeline_steps',
            [
                'label' => esc_html__('Timeline Steps', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'step_number',
            [
                'label' => esc_html__('Step Number', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Step 1', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Step 1', 'promen-elementor-widgets'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'show_step_title',
            [
                'label' => esc_html__('Show Step Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'step_title',
            [
                'label' => esc_html__('Step Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Sollicitatie', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter step title', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_step_title' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'step_title_tag',
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
                    'show_step_title' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_step_description',
            [
                'label' => esc_html__('Show Step Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'step_description',
            [
                'label' => esc_html__('Step Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter step description', 'promen-elementor-widgets'),
                'rows' => 3,
                'condition' => [
                    'show_step_description' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'timeline_steps',
            [
                'label' => esc_html__('Timeline Steps', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'step_number' => esc_html__('Step 1', 'promen-elementor-widgets'),
                        'step_title' => esc_html__('Sollicitatie', 'promen-elementor-widgets'),
                        'step_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.', 'promen-elementor-widgets'),
                    ],
                    [
                        'step_number' => esc_html__('Step 2', 'promen-elementor-widgets'),
                        'step_title' => esc_html__('Eerste gesprek', 'promen-elementor-widgets'),
                        'step_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.', 'promen-elementor-widgets'),
                    ],
                    [
                        'step_number' => esc_html__('Step 3', 'promen-elementor-widgets'),
                        'step_title' => esc_html__('Tweede gesprek', 'promen-elementor-widgets'),
                        'step_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.', 'promen-elementor-widgets'),
                    ],
                    [
                        'step_number' => esc_html__('Step 4', 'promen-elementor-widgets'),
                        'step_title' => esc_html__('Contractvoorstel', 'promen-elementor-widgets'),
                        'step_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.', 'promen-elementor-widgets'),
                    ],
                    [
                        'step_number' => esc_html__('Step 5', 'promen-elementor-widgets'),
                        'step_title' => esc_html__('Welkom bij ons team!', 'promen-elementor-widgets'),
                        'step_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse varius enim in eros elementum tristique.', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ step_title }}}',
            ]
        );

        $widget->end_controls_section();
    }
} 