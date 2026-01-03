<?php
/**
 * Text Content Block Widget Style Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Text_Content_Block_Style_Controls {

    /**
     * Register style controls for the widget
     */
    public static function register_controls($widget) {
        self::register_container_style_section($widget);
        self::register_heading_style_section($widget);
        self::register_content_style_section($widget);
        self::register_list_style_section($widget);
        self::register_blockquote_style_section($widget);
        self::register_flexible_content_style_section($widget);
        self::register_collapsible_block_style_section($widget);
        self::register_social_sharing_style_section($widget);
        self::register_job_vacancy_style_section($widget);
        self::register_additional_text_style_section($widget);
        self::register_contact_sidebar_style_section($widget);
    }

    /**
     * Register container style section controls
     */
    private static function register_container_style_section($widget) {
        $widget->start_controls_section(
            'section_container_style',
            [
                'label' => esc_html__('Container', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Add container gap control
        $widget->add_responsive_control(
            'container_gap',
            [
                'label' => esc_html__('Container Gap', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
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
                    '%' => [
                        'min' => 0,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__container' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Add container width controls heading
        $widget->add_control(
            'container_width_heading',
            [
                'label' => esc_html__('Container Widths', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        // Add main content width control
        $widget->add_responsive_control(
            'main_content_width',
            [
                'label' => esc_html__('Main Content Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 50,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 400,
                        'max' => 1200,
                        'step' => 10,
                    ],
                    'vw' => [
                        'min' => 50,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 70,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__container.has-sidebar .promen-text-content-block__main-content' => 'width: {{SIZE}}{{UNIT}}; flex: none;',
                ],
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        // Add sidebar width control
        $widget->add_responsive_control(
            'sidebar_width',
            [
                'label' => esc_html__('Sidebar Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 200,
                        'max' => 600,
                        'step' => 10,
                    ],
                    'vw' => [
                        'min' => 10,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar' => 'width: {{SIZE}}{{UNIT}}; flex: none;',
                ],
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'container_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'container_background',
                'label' => esc_html__('Background', 'promen-elementor-widgets'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .promen-text-content-block',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block',
            ]
        );

        $widget->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register heading style section controls
     */
    private static function register_heading_style_section($widget) {
        $widget->start_controls_section(
            'section_heading_style',
            [
                'label' => esc_html__('Heading', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__heading' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__heading',
            ]
        );

        $widget->add_responsive_control(
            'heading_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'heading_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__heading' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'heading_alignment',
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
                    '{{WRAPPER}} .promen-text-content-block__heading' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register content style section controls
     */
    private static function register_content_style_section($widget) {
        $widget->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Main Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_main_content' => 'yes',
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->add_control(
            'content_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__content',
            ]
        );

        $widget->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'content_alignment',
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
                    'justify' => [
                        'title' => esc_html__('Justify', 'promen-elementor-widgets'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Link Styles
        $widget->add_control(
            'content_links_heading',
            [
                'label' => esc_html__('Links', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->start_controls_tabs('content_links_tabs');

        $widget->start_controls_tab(
            'content_links_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'content_link_color',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'content_link_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__content a',
            ]
        );

        $widget->add_control(
            'content_link_text_decoration',
            [
                'label' => esc_html__('Text Decoration', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'underline',
                'options' => [
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                    'underline' => esc_html__('Underline', 'promen-elementor-widgets'),
                    'overline' => esc_html__('Overline', 'promen-elementor-widgets'),
                    'line-through' => esc_html__('Line Through', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a' => 'text-decoration: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'content_links_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'content_link_color_hover',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'content_link_text_decoration_hover',
            [
                'label' => esc_html__('Text Decoration', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'underline',
                'options' => [
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                    'underline' => esc_html__('Underline', 'promen-elementor-widgets'),
                    'overline' => esc_html__('Overline', 'promen-elementor-widgets'),
                    'line-through' => esc_html__('Line Through', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a:hover' => 'text-decoration: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'content_link_transition',
            [
                'label' => esc_html__('Transition Duration', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s', 'ms'],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                    'ms' => [
                        'min' => 0,
                        'max' => 3000,
                        'step' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a' => 'transition: color {{SIZE}}{{UNIT}} ease, text-decoration {{SIZE}}{{UNIT}} ease;',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'content_links_focus',
            [
                'label' => esc_html__('Focus', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'content_link_color_focus',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'content_link_focus_outline_color',
            [
                'label' => esc_html__('Outline Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a:focus' => 'outline-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'content_link_focus_outline_width',
            [
                'label' => esc_html__('Outline Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a:focus' => 'outline-width: {{SIZE}}{{UNIT}}; outline-style: solid;',
                ],
            ]
        );

        $widget->add_responsive_control(
            'content_link_focus_outline_offset',
            [
                'label' => esc_html__('Outline Offset', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__content a:focus' => 'outline-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }

    /**
     * Register list style section controls
     */
    private static function register_list_style_section($widget) {
        $widget->start_controls_section(
            'section_list_style',
            [
                'label' => esc_html__('List Items', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_list' => 'yes',
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->add_control(
            'list_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list li' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'list_marker_color',
            [
                'label' => esc_html__('Marker Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list.bullet li::before' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .promen-text-content-block__list.numbered li::marker' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'list_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__list li',
            ]
        );

        $widget->add_responsive_control(
            'list_margin',
            [
                'label' => esc_html__('List Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'list_padding',
            [
                'label' => esc_html__('List Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'list_item_spacing',
            [
                'label' => esc_html__('Item Spacing', 'promen-elementor-widgets'),
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
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list li:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'list_text_alignment',
            [
                'label' => esc_html__('Text Alignment', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .promen-text-content-block__list li' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Link Styles
        $widget->add_control(
            'list_links_heading',
            [
                'label' => esc_html__('Links', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->start_controls_tabs('list_links_tabs');

        $widget->start_controls_tab(
            'list_links_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'list_link_color',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'list_links_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'list_link_color_hover',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'list_links_focus',
            [
                'label' => esc_html__('Focus', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'list_link_color_focus',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'list_link_focus_outline_color',
            [
                'label' => esc_html__('Outline Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__list a:focus' => 'outline-color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }

    /**
     * Register blockquote style section controls
     */
    private static function register_blockquote_style_section($widget) {
        $widget->start_controls_section(
            'section_blockquote_style',
            [
                'label' => esc_html__('Blockquote', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_blockquote' => 'yes',
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->add_control(
            'blockquote_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'blockquote_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__blockquote',
            ]
        );

        $widget->add_responsive_control(
            'blockquote_text_alignment',
            [
                'label' => esc_html__('Text Alignment', 'promen-elementor-widgets'),
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
                    'justify' => [
                        'title' => esc_html__('Justify', 'promen-elementor-widgets'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Divider settings
        $widget->add_control(
            'blockquote_divider_heading',
            [
                'label' => esc_html__('Divider', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'blockquote_divider_color',
            [
                'label' => esc_html__('Divider Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote' => 'border-left-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'blockquote_divider_width',
            [
                'label' => esc_html__('Divider Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote' => 'border-left-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'blockquote_divider_style',
            [
                'label' => esc_html__('Divider Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'solid',
                'options' => [
                    'solid' => esc_html__('Solid', 'promen-elementor-widgets'),
                    'dashed' => esc_html__('Dashed', 'promen-elementor-widgets'),
                    'dotted' => esc_html__('Dotted', 'promen-elementor-widgets'),
                    'double' => esc_html__('Double', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote' => 'border-left-style: {{VALUE}};',
                ],
            ]
        );

        // Quote marks settings
        $widget->add_control(
            'blockquote_quotes_heading',
            [
                'label' => esc_html__('Quote Marks', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'blockquote_quotes_color',
            [
                'label' => esc_html__('Quote Marks Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e0e0e0',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote::before, {{WRAPPER}} .promen-text-content-block__blockquote::after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'blockquote_show_quotes',
            [
                'label' => esc_html__('Show Quote Marks', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote.hide-quotes::before, {{WRAPPER}} .promen-text-content-block__blockquote.hide-quotes::after' => 'display: none;',
                ],
            ]
        );

        // Continue with existing controls
        $widget->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'blockquote_background',
                'label' => esc_html__('Background', 'promen-elementor-widgets'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .promen-text-content-block__blockquote',
                'separator' => 'before',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'blockquote_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block__blockquote',
            ]
        );

        $widget->add_responsive_control(
            'blockquote_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'blockquote_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '1.5',
                    'right' => '1.5',
                    'bottom' => '1.5',
                    'left' => '1.5',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
            ]
        );

        $widget->add_responsive_control(
            'blockquote_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'blockquote_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block__blockquote',
            ]
        );

        // Link Styles
        $widget->add_control(
            'blockquote_links_heading',
            [
                'label' => esc_html__('Links', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->start_controls_tabs('blockquote_links_tabs');

        $widget->start_controls_tab(
            'blockquote_links_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'blockquote_link_color',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'blockquote_links_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'blockquote_link_color_hover',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'blockquote_links_focus',
            [
                'label' => esc_html__('Focus', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'blockquote_link_color_focus',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'blockquote_link_focus_outline_color',
            [
                'label' => esc_html__('Outline Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__blockquote a:focus' => 'outline-color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }

    /**
     * Register flexible content style section controls
     */
    private static function register_flexible_content_style_section($widget) {
        $widget->start_controls_section(
            'section_flexible_content_style',
            [
                'label' => esc_html__('Flexible Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'content_view_type' => 'flexible',
                ],
            ]
        );

        // Text content style controls
        $widget->add_control(
            'flexible_text_heading',
            [
                'label' => esc_html__('Text Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'flexible_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'flexible_text_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__flexible-text',
            ]
        );

        $widget->add_responsive_control(
            'flexible_text_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Image style controls
        $widget->add_control(
            'flexible_image_heading',
            [
                'label' => esc_html__('Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'flexible_image_width',
            [
                'label' => esc_html__('Max Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1200,
                        'step' => 5,
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
                    '{{WRAPPER}} .promen-text-content-block__flexible-image img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'flexible_image_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'flexible_image_border',
                'selector' => '{{WRAPPER}} .promen-text-content-block__flexible-image img',
            ]
        );

        $widget->add_responsive_control(
            'flexible_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'flexible_image_box_shadow',
                'selector' => '{{WRAPPER}} .promen-text-content-block__flexible-image img',
            ]
        );

        // Image caption style
        $widget->add_control(
            'flexible_image_caption_heading',
            [
                'label' => esc_html__('Image Caption', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'flexible_image_caption_color',
            [
                'label' => esc_html__('Caption Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-image figcaption' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'flexible_image_caption_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__flexible-image figcaption',
            ]
        );

        $widget->add_responsive_control(
            'flexible_image_caption_margin',
            [
                'label' => esc_html__('Caption Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-image figcaption' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'flexible_image_caption_align',
            [
                'label' => esc_html__('Caption Alignment', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .promen-text-content-block__flexible-image figcaption' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Spacing between items
        $widget->add_control(
            'flexible_content_spacing_heading',
            [
                'label' => esc_html__('Content Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'flexible_content_spacing',
            [
                'label' => esc_html__('Space Between Items', 'promen-elementor-widgets'),
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
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Link Styles
        $widget->add_control(
            'flexible_content_links_heading',
            [
                'label' => esc_html__('Links', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->start_controls_tabs('flexible_content_links_tabs');

        $widget->start_controls_tab(
            'flexible_content_links_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'flexible_content_link_color',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-text a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'flexible_content_links_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'flexible_content_link_color_hover',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-text a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'flexible_content_links_focus',
            [
                'label' => esc_html__('Focus', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'flexible_content_link_color_focus',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-text a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'flexible_content_link_focus_outline_color',
            [
                'label' => esc_html__('Outline Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-text a:focus' => 'outline-color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }

    /**
     * Register collapsible block style section controls
     */
    private static function register_collapsible_block_style_section($widget) {
        $widget->start_controls_section(
            'section_collapsible_block_style',
            [
                'label' => esc_html__('Collapsible Block Trigger', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Normal State
        $widget->add_control(
            'collapsible_trigger_normal_heading',
            [
                'label' => esc_html__('Normal State', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $widget->add_control(
            'collapsible_trigger_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'collapsible_trigger_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger .promen-text-content-block__collapsible-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'collapsible_trigger_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__collapsible-trigger',
            ]
        );

        $widget->add_responsive_control(
            'collapsible_trigger_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'collapsible_trigger_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block__collapsible-trigger',
            ]
        );

        $widget->add_responsive_control(
            'collapsible_trigger_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Hover State
        $widget->add_control(
            'collapsible_trigger_hover_heading',
            [
                'label' => esc_html__('Hover State', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'collapsible_trigger_background_color_hover',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'collapsible_trigger_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:hover .promen-text-content-block__collapsible-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'collapsible_trigger_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'collapsible_trigger_box_shadow_hover',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:hover',
            ]
        );

        $widget->add_control(
            'collapsible_trigger_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s', 'ms'],
                'range' => [
                    's' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                    'ms' => [
                        'min' => 0,
                        'max' => 3000,
                        'step' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger' => 'transition: background-color {{SIZE}}{{UNIT}} ease, color {{SIZE}}{{UNIT}} ease, border-color {{SIZE}}{{UNIT}} ease, box-shadow {{SIZE}}{{UNIT}} ease;',
                ],
            ]
        );

        // Focus State
        $widget->add_control(
            'collapsible_trigger_focus_heading',
            [
                'label' => esc_html__('Focus State', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'collapsible_trigger_background_color_focus',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'collapsible_trigger_text_color_focus',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:focus' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:focus .promen-text-content-block__collapsible-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'collapsible_trigger_border_color_focus',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'collapsible_trigger_focus_outline_color',
            [
                'label' => esc_html__('Outline Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:focus' => 'outline-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'collapsible_trigger_focus_outline_width',
            [
                'label' => esc_html__('Outline Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:focus' => 'outline-width: {{SIZE}}{{UNIT}}; outline-style: solid;',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'collapsible_trigger_box_shadow_focus',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block__collapsible-trigger:focus',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register social sharing style section controls
     */
    private static function register_social_sharing_style_section($widget) {
        $widget->start_controls_section(
            'section_social_sharing_style',
            [
                'label' => esc_html__('Social Sharing', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__social-sharing-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__social-sharing-title',
            ]
        );

        $widget->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Title Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__social-sharing-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'social_sharing_padding',
            [
                'label' => esc_html__('Container Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__social-sharing' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'social_sharing_margin',
            [
                'label' => esc_html__('Container Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__social-sharing' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'icon_colors_heading',
            [
                'label' => esc_html__('Icon Colors', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->start_controls_tabs('social_icons_colors');

        $widget->start_controls_tab(
            'social_icons_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'facebook_color',
            [
                'label' => esc_html__('Facebook Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3b5998',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.facebook .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_facebook' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'twitter_color',
            [
                'label' => esc_html__('Twitter/X Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1da1f2',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.twitter .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_twitter' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'linkedin_color',
            [
                'label' => esc_html__('LinkedIn Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0077b5',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.linkedin .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_linkedin' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'whatsapp_color',
            [
                'label' => esc_html__('WhatsApp Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#25d366',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.whatsapp .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_whatsapp' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'email_color',
            [
                'label' => esc_html__('Email Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#808080',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.email .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_email' => 'yes',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'social_icons_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'facebook_color_hover',
            [
                'label' => esc_html__('Facebook Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2d4373',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.facebook:hover .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_facebook' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'twitter_color_hover',
            [
                'label' => esc_html__('Twitter/X Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0c85d0',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.twitter:hover .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_twitter' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'linkedin_color_hover',
            [
                'label' => esc_html__('LinkedIn Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#005983',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.linkedin:hover .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_linkedin' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'whatsapp_color_hover',
            [
                'label' => esc_html__('WhatsApp Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#1da851',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.whatsapp:hover .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_whatsapp' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'email_color_hover',
            [
                'label' => esc_html__('Email Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#606060',
                'selectors' => [
                    '{{WRAPPER}} .social-share-item.email:hover .social-sharing-icon' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'share_email' => 'yes',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }

    /**
     * Register job vacancy style section controls
     */
    private static function register_job_vacancy_style_section($widget) {
        $widget->start_controls_section(
            'section_job_vacancy_style',
            [
                'label' => esc_html__('Job Vacancy', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                    'show_job_vacancies' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_title_color',
            [
                'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'job_vacancy_title_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__job-vacancy-title',
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_title_margin',
            [
                'label' => esc_html__('Title Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '1',
                    'left' => '0',
                    'unit' => 'rem',
                    'isLinked' => false,
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_label_heading',
            [
                'label' => esc_html__('Labels', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'job_vacancy_label_color',
            [
                'label' => esc_html__('Label Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#333333',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-item-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'job_vacancy_label_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__job-vacancy-item-label',
            ]
        );

        $widget->add_control(
            'job_vacancy_value_heading',
            [
                'label' => esc_html__('Values', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'job_vacancy_value_color',
            [
                'label' => esc_html__('Value Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-item-value' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'job_vacancy_value_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__job-vacancy-item-value',
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_item_spacing',
            [
                'label' => esc_html__('Item Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'job_vacancy_button_heading',
            [
                'label' => esc_html__('Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->start_controls_tabs('job_vacancy_button_style_tabs');

        $widget->start_controls_tab(
            'job_vacancy_button_normal_tab',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'job_vacancy_button_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_button_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ff8d3f',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'job_vacancy_button_hover_tab',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'job_vacancy_button_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button:hover' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button:hover' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_button_background_color_hover',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e67e35',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button:hover' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button:hover' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'job_vacancy_button_focus_tab',
            [
                'label' => esc_html__('Focus', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'job_vacancy_button_text_color_focus',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button:focus' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button:focus' => 'color: {{VALUE}} !important;',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_button_background_color_focus',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e67e35',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button:focus' => 'background-color: {{VALUE}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button:focus' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_button_focus_outline_color',
            [
                'label' => esc_html__('Outline Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button:focus' => 'outline-color: {{VALUE}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button:focus' => 'outline-color: {{VALUE}} !important;',
                ],
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_button_focus_outline_width',
            [
                'label' => esc_html__('Outline Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button:focus' => 'outline-width: {{SIZE}}{{UNIT}} !important; outline-style: solid !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button:focus' => 'outline-width: {{SIZE}}{{UNIT}} !important; outline-style: solid !important;',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'job_vacancy_button_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__job-vacancy-button, {{WRAPPER}} a.promen-text-content-block__job-vacancy-button',
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_button_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'default' => [
                    'top' => '0.75',
                    'right' => '1.5',
                    'bottom' => '0.75',
                    'left' => '1.5',
                    'unit' => 'rem',
                    'isLinked' => false,
                ],
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    '{{WRAPPER}} a.promen-text-content-block__job-vacancy-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                ],
                'default' => [
                    'top' => '0.25',
                    'right' => '0.25',
                    'bottom' => '0.25',
                    'left' => '0.25',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_button_margin_top',
            [
                'label' => esc_html__('Button Top Margin', 'promen-elementor-widgets'),
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
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 1.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy-button-wrapper' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_container_heading',
            [
                'label' => esc_html__('Container', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '1.5',
                    'right' => '1.5',
                    'bottom' => '1.5',
                    'left' => '1.5',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => '0.5',
                    'right' => '0.5',
                    'bottom' => '0.5',
                    'left' => '0.5',
                    'unit' => 'rem',
                    'isLinked' => true,
                ],
            ]
        );

        $widget->add_responsive_control(
            'job_vacancy_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'job_vacancy_box_shadow',
                'selector' => '{{WRAPPER}} .promen-text-content-block__job-vacancy',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register additional text style section controls
     */
    private static function register_additional_text_style_section($widget) {
        $widget->start_controls_section(
            'section_additional_text_style',
            [
                'label' => esc_html__('Additional Text', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_additional_text' => 'yes',
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->add_control(
            'additional_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__additional-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'additional_text_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__additional-text',
            ]
        );

        $widget->add_responsive_control(
            'additional_text_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__additional-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'additional_text_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__additional-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'additional_text_alignment',
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
                    'justify' => [
                        'title' => esc_html__('Justify', 'promen-elementor-widgets'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__additional-text' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Link Styles
        $widget->add_control(
            'additional_text_links_heading',
            [
                'label' => esc_html__('Links', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->start_controls_tabs('additional_text_links_tabs');

        $widget->start_controls_tab(
            'additional_text_links_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'additional_text_link_color',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__additional-text a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'additional_text_links_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'additional_text_link_color_hover',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__additional-text a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'additional_text_links_focus',
            [
                'label' => esc_html__('Focus', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'additional_text_link_color_focus',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__additional-text a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'additional_text_link_focus_outline_color',
            [
                'label' => esc_html__('Outline Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__additional-text a:focus' => 'outline-color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }

    /**
     * Register contact sidebar style section controls
     */
    private static function register_contact_sidebar_style_section($widget) {
        $widget->start_controls_section(
            'section_contact_sidebar_style',
            [
                'label' => esc_html__('Contact Sidebar', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        // Add height control
        $widget->add_responsive_control(
            'sidebar_height',
            [
                'label' => esc_html__('Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'auto',
                'options' => [
                    'auto' => esc_html__('Auto', 'promen-elementor-widgets'),
                    'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->add_responsive_control(
            'sidebar_custom_height',
            [
                'label' => esc_html__('Custom Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 400,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'sidebar_height' => 'custom',
                ],
            ]
        );

        $widget->add_control(
            'sidebar_vertical_alignment',
            [
                'label' => esc_html__('Vertical Alignment', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'promen-elementor-widgets'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__('Middle', 'promen-elementor-widgets'),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Bottom', 'promen-elementor-widgets'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'promen-elementor-widgets'),
                        'icon' => 'eicon-v-align-stretch',
                    ],
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'sidebar_height' => 'custom',
                ],
            ]
        );

        $widget->add_control(
            'sidebar_overflow',
            [
                'label' => esc_html__('Overflow', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'visible',
                'options' => [
                    'visible' => esc_html__('Visible', 'promen-elementor-widgets'),
                    'hidden' => esc_html__('Hidden', 'promen-elementor-widgets'),
                    'auto' => esc_html__('Auto', 'promen-elementor-widgets'),
                    'scroll' => esc_html__('Scroll', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar' => 'overflow: {{VALUE}};',
                ],
                'condition' => [
                    'sidebar_height' => 'custom',
                ],
            ]
        );

        $widget->add_control(
            'sidebar_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#f8f8f8',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'sidebar_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block__sidebar',
            ]
        );

        $widget->add_responsive_control(
            'sidebar_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'sidebar_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            'sidebar_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'sidebar_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block__sidebar',
            ]
        );

        // Sidebar Title Style
        $widget->add_control(
            'sidebar_title_heading',
            [
                'label' => esc_html__('Sidebar Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'sidebar_title_color',
            [
                'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'sidebar_title_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__sidebar-title',
            ]
        );

        $widget->add_responsive_control(
            'sidebar_title_margin',
            [
                'label' => esc_html__('Title Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'sidebar_title_alignment',
            [
                'label' => esc_html__('Title Alignment', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .promen-text-content-block__sidebar-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Contact Person Style
        $widget->add_control(
            'contact_person_heading',
            [
                'label' => esc_html__('Contact Person', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'contact_person_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-person' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'contact_person_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__contact-person',
            ]
        );

        $widget->add_responsive_control(
            'contact_person_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-person' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'contact_person_alignment',
            [
                'label' => esc_html__('Text Alignment', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .promen-text-content-block__contact-person' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        // Contact Details Style
        $widget->add_control(
            'contact_details_heading',
            [
                'label' => esc_html__('Contact Details', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'contact_details_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-details a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->start_controls_tabs('contact_details_links_tabs');

        $widget->start_controls_tab(
            'contact_details_links_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        // Normal state is already defined above with contact_details_color
        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'contact_details_links_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'contact_details_hover_color',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-details a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'contact_details_links_focus',
            [
                'label' => esc_html__('Focus', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'contact_details_focus_color',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-details a:focus' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'contact_details_focus_outline_color',
            [
                'label' => esc_html__('Outline Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-details a:focus' => 'outline-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'contact_details_focus_outline_width',
            [
                'label' => esc_html__('Outline Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 2,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-details a:focus' => 'outline-width: {{SIZE}}{{UNIT}}; outline-style: solid;',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->add_control(
            'contact_details_icon_color',
            [
                'label' => esc_html__('Icon Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-details .icon' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'contact_details_typography',
                'selector' => '{{WRAPPER}} .promen-text-content-block__contact-details a',
            ]
        );

        $widget->add_responsive_control(
            'contact_details_alignment',
            [
                'label' => esc_html__('Text Alignment', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .promen-text-content-block__contact-details a' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'contact_details_spacing',
            [
                'label' => esc_html__('Item Spacing', 'promen-elementor-widgets'),
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
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-details .contact-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Contact Image Style
        $widget->add_control(
            'contact_image_heading',
            [
                'label' => esc_html__('Contact Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'contact_image_width',
            [
                'label' => esc_html__('Image Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'contact_image_height',
            [
                'label' => esc_html__('Image Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'auto'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'unit' => 'auto',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'contact_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'contact_image_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .promen-text-content-block__contact-image img',
            ]
        );

        $widget->add_responsive_control(
            'contact_image_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__contact-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }
} 