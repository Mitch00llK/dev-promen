<?php
/**
 * Image Text Block Widget Style Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Image_Text_Block_Style_Controls {

    /**
     * Register style controls for the widget
     */
    public static function register_controls($widget) {
        self::register_image_style_section($widget);
        self::register_content_style_section($widget);
        self::register_title_style_section($widget);
        self::register_description_style_section($widget);
        self::register_button_style_section($widget);
        self::register_tabs_style_section($widget);
    }

    /**
     * Register image style section controls
     */
    private static function register_image_style_section($widget) {
        $widget->start_controls_section(
            'section_image_style',
            [
                'label' => esc_html__('Image Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );

        $widget->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $widget->add_control(
            'image_height_behavior',
            [
                'label' => esc_html__('Image Height Behavior', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'content',
                'options' => [
                    'content' => esc_html__('Match Content Height', 'promen-elementor-widgets'),
                    'custom' => esc_html__('Custom Height', 'promen-elementor-widgets'),
                    'auto' => esc_html__('Auto (Original Ratio)', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'image-height-',
                'selectors' => [
                    '{{WRAPPER}}.image-height-auto .promen-image-text-block__image, {{WRAPPER}}.image-height-auto .promen-image-text-block__image img' => 'height: auto;',
                    '{{WRAPPER}}.image-height-content .promen-image-text-block__image-wrapper' => 'display: flex; flex-direction: column;',
                    '{{WRAPPER}}.image-height-content .promen-image-text-block__image' => 'display: flex; flex-direction: column; height: 100%;',
                    '{{WRAPPER}}.image-height-content .promen-image-text-block__image img' => 'height: 100%; object-fit: cover;',
                    '{{WRAPPER}}.image-height-custom .promen-image-text-block__image img' => 'height: {{image_height.SIZE}}{{image_height.UNIT}}; object-fit: cover;',
                ],
            ]
        );

        $widget->add_responsive_control(
            'image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover', 'promen-elementor-widgets'),
                    'contain' => esc_html__('Contain', 'promen-elementor-widgets'),
                    'fill' => esc_html__('Fill', 'promen-elementor-widgets'),
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .promen-image-text-block__image img',
            ]
        );

        $widget->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .promen-image-text-block__image img',
            ]
        );

        $widget->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label' => esc_html__('Content Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );

        $widget->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_control(
            'content_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__content' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .promen-image-text-block__content',
            ]
        );

        $widget->add_responsive_control(
            'content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .promen-image-text-block__content',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register title style section controls
     */
    private static function register_title_style_section($widget) {
        $widget->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );

        // Regular title styling (when split title is not used)
        $widget->add_control(
            'title_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'split_title!' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__title',
                'condition' => [
                    'split_title!' => 'yes',
                ],
            ]
        );

        // Title Part 1 Styling
        $widget->add_control(
            'title_part1_heading',
            [
                'label' => esc_html__('Title Part 1 Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'split_title' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'title_part1_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-title-part-1' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'split_title' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_part1_typography',
                'selector' => '{{WRAPPER}} .promen-title-part-1',
                'condition' => [
                    'split_title' => 'yes',
                ],
            ]
        );

        // Title Part 2 Styling
        $widget->add_control(
            'title_part2_heading',
            [
                'label' => esc_html__('Title Part 2 Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'split_title' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'title_part2_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-title-part-2' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'split_title' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_part2_typography',
                'selector' => '{{WRAPPER}} .promen-title-part-2',
                'condition' => [
                    'split_title' => 'yes',
                ],
            ]
        );

        // Common styling options for both split and non-split titles
        $widget->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'title_text_align',
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
                    '{{WRAPPER}} .promen-image-text-block__title-wrapper' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register description style section controls
     */
    private static function register_description_style_section($widget) {
        $widget->start_controls_section(
            'section_description_style',
            [
                'label' => esc_html__('Description Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );

        $widget->add_control(
            'description_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__description',
            ]
        );

        $widget->add_responsive_control(
            'description_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register button style section controls
     */
    private static function register_button_style_section($widget) {
        $widget->start_controls_section(
            'section_button_style',
            [
                'label' => esc_html__('Button Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__button',
            ]
        );

        $widget->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->start_controls_tabs('button_style_tabs');

        $widget->start_controls_tab(
            'button_style_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .promen-image-text-block__button',
            ]
        );

        $widget->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'button_style_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'button_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'button_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'button_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__button:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_border_border!' => '',
                ],
            ]
        );

        $widget->add_control(
            'button_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }

    /**
     * Register tabs style section controls
     */
    private static function register_tabs_style_section($widget) {
        $widget->start_controls_section(
            'section_tabs_style',
            [
                'label' => esc_html__('Tabs Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        // Tabs Image Style

        $widget->add_control(
            'tabs_image_heading',
            [
                'label' => esc_html__('Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'tabs_image_width',
            [
                'label' => esc_html__('Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 100,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block--tabs .promen-image-text-block__image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'tabs_image_height',
            [
                'label' => esc_html__('Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block--tabs .promen-image-text-block__image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $widget->add_control(
            'tabs_image_height_behavior',
            [
                'label' => esc_html__('Image Height Behavior', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'content',
                'options' => [
                    'content' => esc_html__('Match Content Height', 'promen-elementor-widgets'),
                    'custom' => esc_html__('Custom Height', 'promen-elementor-widgets'),
                    'auto' => esc_html__('Auto (Original Ratio)', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'tabs-image-height-',
                'selectors' => [
                    '{{WRAPPER}}.tabs-image-height-auto .promen-image-text-block--tabs .promen-image-text-block__image, {{WRAPPER}}.tabs-image-height-auto .promen-image-text-block--tabs .promen-image-text-block__image img' => 'height: auto;',
                    '{{WRAPPER}}.tabs-image-height-content .promen-image-text-block--tabs .promen-image-text-block__image-wrapper' => 'display: flex; flex-direction: column;',
                    '{{WRAPPER}}.tabs-image-height-content .promen-image-text-block--tabs .promen-image-text-block__image' => 'display: flex; flex-direction: column; height: 100%;',
                    '{{WRAPPER}}.tabs-image-height-content .promen-image-text-block--tabs .promen-image-text-block__image img' => 'height: 100%; object-fit: cover;',
                    '{{WRAPPER}}.tabs-image-height-custom .promen-image-text-block--tabs .promen-image-text-block__image img' => 'height: {{tabs_image_height.SIZE}}{{tabs_image_height.UNIT}}; object-fit: cover;',
                ],
            ]
        );

        $widget->add_responsive_control(
            'tabs_image_object_fit',
            [
                'label' => esc_html__('Object Fit', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'cover',
                'options' => [
                    'cover' => esc_html__('Cover', 'promen-elementor-widgets'),
                    'contain' => esc_html__('Contain', 'promen-elementor-widgets'),
                    'fill' => esc_html__('Fill', 'promen-elementor-widgets'),
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block--tabs .promen-image-text-block__image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tabs_image_border',
                'selector' => '{{WRAPPER}} .promen-image-text-block--tabs .promen-image-text-block__image img',
            ]
        );

        $widget->add_responsive_control(
            'tabs_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block--tabs .promen-image-text-block__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Tab Navigation Section
        $widget->add_control(
            'tabs_nav_heading',
            [
                'label' => esc_html__('Tab Navigation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'tab_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_active_background_color',
            [
                'label' => esc_html__('Active Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_active_color',
            [
                'label' => esc_html__('Active Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab.active .promen-image-text-block__tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__tab-title',
            ]
        );

        $widget->add_responsive_control(
            'tab_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'tab_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Tab Content Title Style
        $widget->add_control(
            'tab_content_title_heading',
            [
                'label' => esc_html__('Tab Content Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Regular title styling (when split title is not used)
        $widget->add_control(
            'tab_content_title_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_content_title_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__tab-content .promen-title',
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        // Title Part 1 Styling for tabs
        $widget->add_control(
            'tab_title_part1_heading',
            [
                'label' => esc_html__('Tab Title Part 1 Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        $widget->add_control(
            'tab_title_part1_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-title-part-1' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_title_part1_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__tab-content .promen-title-part-1',
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        // Title Part 2 Styling for tabs
        $widget->add_control(
            'tab_title_part2_heading',
            [
                'label' => esc_html__('Tab Title Part 2 Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        $widget->add_control(
            'tab_title_part2_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-title-part-2' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_title_part2_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__tab-content .promen-title-part-2',
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        // Tab Content Description Style
        $widget->add_control(
            'tab_content_description_heading',
            [
                'label' => esc_html__('Tab Content Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'tab_content_description_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-description' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_content_description_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__tab-content .promen-description',
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        $widget->add_responsive_control(
            'tab_content_description_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        // Tab Button Style
        $widget->add_control(
            'tab_button_heading',
            [
                'label' => esc_html__('Tab Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'tab_button_typography',
                'selector' => '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button',
            ]
        );

        $widget->add_responsive_control(
            'tab_button_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'tab_button_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->start_controls_tabs('tab_button_style_tabs');

        $widget->start_controls_tab(
            'tab_button_style_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'tab_button_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_button_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_button_border',
                'selector' => '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button',
            ]
        );

        $widget->add_responsive_control(
            'tab_button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'tab_button_style_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'tab_button_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_button_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_button_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-content .promen-image-text-block__button:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'tab_button_border_border!' => '',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->start_controls_tabs('tabs_style_tabs');

        $widget->start_controls_tab(
            'tabs_style_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'tab_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'tab_border',
                'selector' => '{{WRAPPER}} .promen-image-text-block__tab',
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'tabs_style_active',
            [
                'label' => esc_html__('Active', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'tab_active_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab.active .promen-image-text-block__tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_active_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab.active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_active_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab.active' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'tab_border_border!' => '',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->start_controls_tab(
            'tabs_style_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'tab_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab:not(.active):hover .promen-image-text-block__tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab:not(.active):hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'tab_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-image-text-block__tab:not(.active):hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'tab_border_border!' => '',
                ],
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        $widget->end_controls_section();
    }
} 