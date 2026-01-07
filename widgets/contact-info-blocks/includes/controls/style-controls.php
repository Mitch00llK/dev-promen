<?php
/**
 * Contact Info Blocks Style Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

class Promen_Contact_Info_Blocks_Style_Controls {

    /**
     * Register style controls for the widget
     */
    public static function register_controls($widget) {
        self::register_container_style_section($widget);
        self::register_info_blocks_style_section($widget);
        self::register_title_style_section($widget);
        self::register_content_style_section($widget);
        self::register_icon_style_section($widget);
        self::register_responsive_style_section($widget);
    }

    /**
     * Register container style section
     */
    private static function register_container_style_section($widget) {
        $widget->start_controls_section(
            'section_container_style',
            [
                'label' => esc_html__('Container', 'promen-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'container_spacing',
            [
                'label' => esc_html__('Spacing', 'promen-elementor-widgets'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-blocks' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'container_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-blocks' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'container_background',
                'label' => esc_html__('Background', 'promen-elementor-widgets'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .contact-info-blocks',
            ]
        );

        $widget->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'container_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .contact-info-blocks',
            ]
        );

        $widget->add_responsive_control(
            'container_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-blocks' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'container_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .contact-info-blocks',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register info blocks style section
     */
    private static function register_info_blocks_style_section($widget) {
        $widget->start_controls_section(
            'section_info_blocks_style',
            [
                'label' => esc_html__('Info Blocks', 'promen-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'blocks_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'blocks_background',
                'label' => esc_html__('Background', 'promen-elementor-widgets'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .contact-info-block',
            ]
        );

        $widget->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'blocks_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .contact-info-block',
            ]
        );

        $widget->add_responsive_control(
            'blocks_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'blocks_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .contact-info-block',
            ]
        );

        $widget->add_responsive_control(
            'blocks_align',
            [
                'label' => esc_html__('Alignment', 'promen-elementor-widgets'),
                'type' => Controls_Manager::CHOOSE,
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
                'selectors' => [
                    '{{WRAPPER}} .contact-info-block' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'blocks_text_align',
            [
                'label' => esc_html__('Text Alignment', 'promen-elementor-widgets'),
                'type' => Controls_Manager::CHOOSE,
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
                'selectors' => [
                    '{{WRAPPER}} .contact-info-block' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register title style section
     */
    private static function register_title_style_section($widget) {
        $widget->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'promen-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .contact-info-title',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
            ]
        );

        $widget->add_responsive_control(
            'title_bottom_spacing',
            [
                'label' => esc_html__('Bottom Spacing', 'promen-elementor-widgets'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .contact-info-title' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register content style section
     */
    private static function register_content_style_section($widget) {
        $widget->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .contact-info-content, {{WRAPPER}} .contact-info-content a',
                'global' => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );

        $widget->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .contact-info-content, {{WRAPPER}} .contact-info-content a' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
            ]
        );

        $widget->add_control(
            'content_hover_color',
            [
                'label' => esc_html__('Link Hover Color', 'promen-elementor-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .contact-info-content a:hover' => 'color: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_ACCENT,
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register icon style section
     */
    private static function register_icon_style_section($widget) {
        $widget->start_controls_section(
            'section_icon_style',
            [
                'label' => esc_html__('Icon', 'promen-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'promen-elementor-widgets'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .contact-info-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Spacing', 'promen-elementor-widgets'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .contact-info-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .contact-info-icon svg' => 'fill: {{VALUE}};',
                ],
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
            ]
        );

        $widget->add_control(
            'icon_background_options',
            [
                'label' => esc_html__('Background Options', 'promen-elementor-widgets'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'icon_background_show',
            [
                'label' => esc_html__('Show Background', 'promen-elementor-widgets'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $widget->add_responsive_control(
            'icon_background_size',
            [
                'label' => esc_html__('Background Size', 'promen-elementor-widgets'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'em'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'rem' => [
                        'min' => 2,
                        'max' => 20,
                        'step' => 0.1,
                    ],
                    'em' => [
                        'min' => 2,
                        'max' => 20,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-icon.with-bg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_background_show' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'icon_background',
                'label' => esc_html__('Background', 'promen-elementor-widgets'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .contact-info-icon.with-bg',
                'condition' => [
                    'icon_background_show' => 'yes',
                ],
            ]
        );

        $widget->add_responsive_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-icon.with-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'icon_background_show' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register responsive style section
     */
    private static function register_responsive_style_section($widget) {
        $widget->start_controls_section(
            'section_responsive_style',
            [
                'label' => esc_html__('Responsive', 'promen-elementor-widgets'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'responsive_layout',
            [
                'label' => esc_html__('Mobile Layout', 'promen-elementor-widgets'),
                'type' => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'stack' => esc_html__('Stack', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->add_control(
            'tablet_breakpoint',
            [
                'label' => esc_html__('Tablet Breakpoint', 'promen-elementor-widgets'),
                'type' => Controls_Manager::NUMBER,
                'default' => 768,
                'min' => 300,
                'max' => 1200,
            ]
        );

        $widget->add_control(
            'mobile_breakpoint',
            [
                'label' => esc_html__('Mobile Breakpoint', 'promen-elementor-widgets'),
                'type' => Controls_Manager::NUMBER,
                'default' => 480,
                'min' => 300,
                'max' => 600,
            ]
        );

        $widget->end_controls_section();
    }
}
