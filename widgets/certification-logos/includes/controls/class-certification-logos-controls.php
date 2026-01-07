<?php
/**
 * Certification Logos Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Certification Logos Widget Controls Class
 */
class Promen_Certification_Logos_Controls {

    /**
     * Register Certification Logos Widget Controls
     */
    public static function register($widget) {
        // Title Section
        $widget->start_controls_section(
            'section_title',
            [
                'label' => esc_html__('Title', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

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

        // Use the standardized split title controls
        promen_add_split_title_controls(
            $widget, 
            'section_title', 
            ['show_title' => 'yes'], 
            esc_html__('Onze certificeringen en keurmerken', 'promen-elementor-widgets'),
            'title'
        );

        $widget->add_control(
            'show_description',
            [
                'label' => esc_html__('Show Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'description_text',
            [
                'label' => esc_html__('Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Wij zijn trots op onze certificeringen en keurmerken die onze kwaliteit en expertise bevestigen.', 'promen-elementor-widgets'),
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();

        // Logos Section
        $widget->start_controls_section(
            'section_logos',
            [
                'label' => esc_html__('Logos', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'logo_name',
            [
                'label' => esc_html__('Logo Name', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Logo Name', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter logo name', 'promen-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'logo_image',
            [
                'label' => esc_html__('Logo Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'logo_link',
            [
                'label' => esc_html__('Logo Link', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $widget->add_control(
            'logos_list',
            [
                'label' => esc_html__('Logos', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'logo_name' => esc_html__('Logo #1', 'promen-elementor-widgets'),
                    ],
                    [
                        'logo_name' => esc_html__('Logo #2', 'promen-elementor-widgets'),
                    ],
                    [
                        'logo_name' => esc_html__('Logo #3', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ logo_name }}}',
            ]
        );

        $widget->end_controls_section();

        // Layout Section
        $widget->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'selectors' => [
                    '{{WRAPPER}} .logos-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $widget->add_control(
            'enable_slider',
            [
                'label' => esc_html__('Enable Mobile Slider', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'slides_to_show',
            [
                'label' => esc_html__('Slides to Show', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],
                'condition' => [
                    'enable_slider' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Tab - Title
        promen_add_split_title_style_controls(
            $widget,
            'section_title_style',
            ['show_title' => 'yes'],
            'certification',
            'title'
        );

        // Description Style Section
        $widget->start_controls_section(
            'section_description_style',
            [
                'label' => esc_html__('Description Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .certification-description',
            ]
        );

        $widget->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .certification-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'description_spacing',
            [
                'label' => esc_html__('Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .certification-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();

        // Logos Style Section
        $widget->start_controls_section(
            'section_logos_style',
            [
                'label' => esc_html__('Logos Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'logo_height',
            [
                'label' => esc_html__('Logo Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo img' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'logo_width',
            [
                'label' => esc_html__('Logo Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'logo_padding',
            [
                'label' => esc_html__('Logo Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'logo_margin',
            [
                'label' => esc_html__('Logo Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'logo_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .certification-logo',
            ]
        );

        $widget->add_responsive_control(
            'logo_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'logo_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .certification-logo',
            ]
        );

        $widget->end_controls_section();
    }
}
