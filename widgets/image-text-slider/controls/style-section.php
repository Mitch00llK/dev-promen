<?php
/**
 * Style Section Controls
 * 
 * Controls for styling the slider, including colors, spacing, and layout.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Image_Text_Slider_Style_Controls {
    /**
     * Register style controls
     */
    protected function register_style_controls() {
        // Slider Layout
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'slider_height',
            [
                'label' => esc_html__('Slider Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'custom',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'full' => esc_html__('Full Height', 'promen-elementor-widgets'),
                    'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
                ],
            ]
        );

        $this->add_responsive_control(
            'custom_height',
            [
                'label' => esc_html__('Custom Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['rem', 'px', 'vh', '%'],
                'range' => [
                    'rem' => [
                        'min' => 20,
                        'max' => 80,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 300,
                        'max' => 1200,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper' => 'height: {{SIZE}}{{UNIT}}; min-height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'slider_height' => 'custom',
                ],
                'description' => esc_html__('Minimum recommended height is 40rem', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'content_position',
            [
                'label' => esc_html__('Content Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'left',
                'options' => [
                    'left' => esc_html__('Left', 'promen-elementor-widgets'),
                    'center' => esc_html__('Center', 'promen-elementor-widgets'),
                    'right' => esc_html__('Right', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'content-position-',
            ]
        );

        $this->add_responsive_control(
            'content_width',
            [
                'label' => esc_html__('Content Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 200,
                        'max' => 800,
                        'step' => 10,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-content-container' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_edge_position',
            [
                'label' => esc_html__('Content Edge Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}}.content-position-left .slide-content-container' => 'margin-left: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}}.content-position-right .slide-content-container' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'content_position!' => 'center',
                ],
                'description' => esc_html__('Adjust the position from the container edge to align with other page elements', 'promen-elementor-widgets'),
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Content Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Content Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .slide-content-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_overflow',
            [
                'label' => esc_html__('Content Overflow', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'content_position_vertical',
            [
                'label' => esc_html__('Content Vertical Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-content-container' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'description' => esc_html__('Controls where the content box is positioned vertically on the slide', 'promen-elementor-widgets'),
            ]
        );
        
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Image Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '12',
                    'right' => '12',
                    'bottom' => '12',
                    'left' => '12',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'slider_container_margin_bottom',
            [
                'label' => esc_html__('Slider Bottom Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 150,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 80,
                ],
                'selectors' => [
                    '{{WRAPPER}}' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'description' => esc_html__('Add bottom margin to the widget to account for the overflowing content', 'promen-elementor-widgets'),
            ]
        );

        $this->end_controls_section();

        // Tilted Divider Section
        $this->start_controls_section(
            'section_tilted_divider',
            [
                'label' => esc_html__('Tilted Divider', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'show_tilted_divider',
            [
                'label' => esc_html__('Show Tilted Divider', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Enable a tilted divider behind the content block', 'promen-elementor-widgets'),
                'prefix_class' => 'has-tilted-divider-',
            ]
        );

        $this->add_control(
            'divider_tilt_angle',
            [
                'label' => esc_html__('Tilt Angle', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'deg' => [
                        'min' => -45,
                        'max' => 45,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'deg',
                    'size' => -12,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper::after' => 'transform: skewY({{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'divider_flip_direction',
            [
                'label' => esc_html__('Flip Direction', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'prefix_class' => 'divider-flipped-',
                'selectors' => [
                    '{{WRAPPER}}.divider-flipped-yes .swiper::after' => 'transform: skewY(calc(-1 * {{divider_tilt_angle.SIZE}}{{divider_tilt_angle.UNIT}}));',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
                'description' => esc_html__('Flip the tilt direction of the divider', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'divider_tilt_degrees',
            [
                'label' => esc_html__('Divider Angle (Degrees)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -45,
                'max' => 45,
                'step' => 1,
                'default' => 12,
                'description' => esc_html__('Set the exact angle in degrees for the divider tilt', 'promen-elementor-widgets'),
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper::after' => 'transform: skewY({{VALUE}}deg);',
                    '{{WRAPPER}}.divider-flipped-yes .swiper::after' => 'transform: skewY(calc(-1 * {{VALUE}}deg));',
                ],
            ]
        );

        $this->add_control(
            'divider_color',
            [
                'label' => esc_html__('Divider Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'selectors' => [
                    '{{WRAPPER}} .swiper::after' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'divider_opacity',
            [
                'label' => esc_html__('Opacity', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.01,
                    ],
                ],
                'default' => [
                    'size' => 0.8,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper::after' => 'opacity: {{SIZE}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'divider_width',
            [
                'label' => esc_html__('Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => 100,
                        'max' => 2000,
                        'step' => 10,
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
                    '{{WRAPPER}} .swiper::after' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'divider_height',
            [
                'label' => esc_html__('Divider Depth', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'rem', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'vh' => [
                        'min' => 5,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'rem',
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper::after' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
                'description' => esc_html__('Controls how much the divider extends beyond the bottom of the image', 'promen-elementor-widgets'),
            ]
        );

        $this->add_responsive_control(
            'divider_position_x',
            [
                'label' => esc_html__('Horizontal Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper::after' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'divider_position_y',
            [
                'label' => esc_html__('Vertical Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 10,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper::after' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'divider_z_index',
            [
                'label' => esc_html__('Z-Index', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -10,
                'max' => 10,
                'step' => 1,
                'default' => 5,
                'selectors' => [
                    '{{WRAPPER}} .swiper::after' => 'z-index: {{VALUE}};',
                ],
                'condition' => [
                    'show_tilted_divider' => 'yes',
                ],
                'description' => esc_html__('Adjusts stacking order. Higher values appear on top.', 'promen-elementor-widgets'),
            ]
        );

        $this->end_controls_section();

        // Content Box Style
        $this->start_controls_section(
            'section_content_box',
            [
                'label' => esc_html__('Content Box', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'content_background',
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .slide-content',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'selector' => '{{WRAPPER}} .slide-content',
            ]
        );

        $this->add_responsive_control(
            'content_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .slide-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'content_box_shadow',
                'selector' => '{{WRAPPER}} .slide-content',
            ]
        );

        $this->end_controls_section();

        // Slider Navigation Style
        $this->start_controls_section(
            'section_navigation_style',
            [
                'label' => esc_html__('Navigation', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'arrows_style_heading',
            [
                'label' => esc_html__('Navigation Arrows', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'arrows_size',
            [
                'label' => esc_html__('Arrows Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 15,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'navigation_spacing',
            [
                'label' => esc_html__('Navigation Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 20,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slider-navigation' => 'margin-top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'navigation_gap',
            [
                'label' => esc_html__('Arrows Gap', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .content-position-center .slider-navigation' => 'gap: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .content-position-right .slider-navigation' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_arrows' => 'yes',
                    'content_position!' => 'left',
                ],
            ]
        );

        $this->start_controls_tabs(
            'arrows_style_tabs',
            [
                'condition' => [
                    'show_arrows' => 'yes',
                ],
            ]
        );

        $this->start_controls_tab(
            'arrows_normal_tab',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.5)',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'arrows_hover_tab',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'arrows_hover_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev:hover, {{WRAPPER}} .swiper-button-next:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'arrows_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0, 0, 0, 0.8)',
                'selectors' => [
                    '{{WRAPPER}} .swiper-button-prev:hover, {{WRAPPER}} .swiper-button-next:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'pagination_style_heading',
            [
                'label' => esc_html__('Pagination', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pagination_size',
            [
                'label' => esc_html__('Dots Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                    'pagination_type' => 'bullets',
                ],
            ]
        );

        $this->add_control(
            'pagination_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 0.5)',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-progressbar' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-fraction' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'pagination_active_color',
            [
                'label' => esc_html__('Active Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-fraction .current' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_pagination' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Button Styles
        $this->start_controls_section(
            'section_buttons_style',
            [
                'label' => esc_html__('Buttons', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'button_1_style_heading',
            [
                'label' => esc_html__('Button 1', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('button_1_style_tabs');

        $this->start_controls_tab(
            'button_1_normal_tab',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'button_1_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-1' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_1_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2980b9',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-1' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_1_border',
                'selector' => '{{WRAPPER}} .slide-button.button-1',
            ]
        );

        $this->add_responsive_control(
            'button_1_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '4',
                    'right' => '4',
                    'bottom' => '4',
                    'left' => '4',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-1' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_1_hover_tab',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'button_1_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-1:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_1_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#3498db',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-1:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_1_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-1:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_1_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'button_2_style_heading',
            [
                'label' => esc_html__('Button 2', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->start_controls_tabs('button_2_style_tabs');

        $this->start_controls_tab(
            'button_2_normal_tab',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'button_2_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2980b9',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-2' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(255, 255, 255, 0)',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-2' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_2_border',
                'selector' => '{{WRAPPER}} .slide-button.button-2',
                'default' => [
                    'color' => '#2980b9',
                    'width' => '1',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_2_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '4',
                    'right' => '4',
                    'bottom' => '4',
                    'left' => '4',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-2' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_2_hover_tab',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'button_2_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-2:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2980b9',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-2:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_2_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2980b9',
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-2:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'button_2_border_border!' => '',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'buttons_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'separator' => 'before',
                'default' => [
                    'top' => '10',
                    'right' => '20',
                    'bottom' => '10',
                    'left' => '20',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'buttons_spacing',
            [
                'label' => esc_html__('Buttons Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-button.button-1' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
        
        // Breadcrumb Style Section
        $this->start_controls_section(
            'section_breadcrumb_style',
            [
                'label' => esc_html__('Breadcrumb', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_breadcrumb' => 'yes',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'breadcrumb_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'breadcrumb_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_control(
            'breadcrumb_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'breadcrumb_typography',
                'selector' => '{{WRAPPER}} .image-text-slider-breadcrumb',
            ]
        );
        
        $this->start_controls_tabs('breadcrumb_style_tabs');
        
        $this->start_controls_tab(
            'breadcrumb_normal_tab',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );
        
        $this->add_control(
            'breadcrumb_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'breadcrumb_link_color',
            [
                'label' => esc_html__('Link Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb a' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->start_controls_tab(
            'breadcrumb_hover_tab',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );
        
        $this->add_control(
            'breadcrumb_link_hover_color',
            [
                'label' => esc_html__('Link Hover Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );
        
        $this->end_controls_tab();
        
        $this->end_controls_tabs();
        
        $this->add_control(
            'breadcrumb_separator_color',
            [
                'label' => esc_html__('Separator Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb .separator' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );
        
        $this->add_responsive_control(
            'breadcrumb_separator_size',
            [
                'label' => esc_html__('Separator Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 8,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0.5,
                        'max' => 3,
                    ],
                    'rem' => [
                        'min' => 0.5,
                        'max' => 3,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb .separator' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'breadcrumb_spacing',
            [
                'label' => esc_html__('Items Spacing', 'promen-elementor-widgets'),
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
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 3,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .image-text-slider-breadcrumb .separator' => 'margin: 0 {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->end_controls_section();

        // Back Link Style
        $this->start_controls_section(
            'section_back_link_style',
            [
                'label' => esc_html__('Back Link', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'back_link_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-back-link a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'back_link_hover_color',
            [
                'label' => esc_html__('Hover Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-back-link a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'back_link_typography',
                'selector' => '{{WRAPPER}} .slide-back-link a',
            ]
        );

        $this->add_responsive_control(
            'back_link_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .slide-back-link' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Publication Date Style
        $this->start_controls_section(
            'section_publication_date_style',
            [
                'label' => esc_html__('Publication Date', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'publication_date_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .slide-publication-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'publication_date_typography',
                'selector' => '{{WRAPPER}} .slide-publication-date',
            ]
        );

        $this->add_responsive_control(
            'publication_date_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .slide-publication-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Overlay Image Style
        $this->start_controls_section(
            'section_overlay_image_style',
            [
                'label' => esc_html__('Overlay Image', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Image Container Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .slide-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'description' => esc_html__('Add padding to the slider image container', 'promen-elementor-widgets'),
            ]
        );

        $this->add_responsive_control(
            'overlay_image_width',
            [
                'label' => esc_html__('Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-image .overlay-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'overlay_image_position_right',
            [
                'label' => esc_html__('Position Right', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-image .overlay-image' => 'right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'overlay_image_position_bottom',
            [
                'label' => esc_html__('Position Bottom', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .slide-image .overlay-image' => 'bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'overlay_image_z_index',
            [
                'label' => esc_html__('Z-Index', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -10,
                'max' => 10,
                'step' => 1,
                'default' => 5,
                'selectors' => [
                    '{{WRAPPER}} .slide-image .overlay-image' => 'z-index: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'overlay_image_border',
                'selector' => '{{WRAPPER}} .slide-image .overlay-image img',
            ]
        );

        $this->add_responsive_control(
            'overlay_image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .slide-image .overlay-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'overlay_image_box_shadow',
                'selector' => '{{WRAPPER}} .slide-image .overlay-image img',
            ]
        );

        $this->end_controls_section();

        // Absolute Overlay Image Style
        $this->start_controls_section(
            'section_absolute_overlay_style',
            [
                'label' => esc_html__('Absolute Overlay Image', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        
        $this->add_responsive_control(
            'absolute_overlay_max_width',
            [
                'label' => esc_html__('Max Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .absolute-overlay-image' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'absolute_overlay_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .absolute-overlay-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'absolute_overlay_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .absolute-overlay-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_responsive_control(
            'absolute_overlay_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .absolute-overlay-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .absolute-overlay-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'absolute_overlay_border',
                'selector' => '{{WRAPPER}} .absolute-overlay-image',
            ]
        );
        
        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'absolute_overlay_box_shadow',
                'selector' => '{{WRAPPER}} .absolute-overlay-image',
            ]
        );
        
        $this->add_responsive_control(
            'absolute_overlay_object_fit',
            [
                'label' => esc_html__('Object Fit', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'contain',
                'options' => [
                    'contain' => esc_html__('Contain', 'promen-elementor-widgets'),
                    'cover' => esc_html__('Cover', 'promen-elementor-widgets'),
                    'fill' => esc_html__('Fill', 'promen-elementor-widgets'),
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                    'scale-down' => esc_html__('Scale Down', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} .absolute-overlay-image img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'absolute_overlay_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .absolute-overlay-image' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        
        $this->add_control(
            'absolute_overlay_opacity',
            [
                'label' => esc_html__('Opacity', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .absolute-overlay-image' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        
        $this->add_control(
            'absolute_overlay_overflow_divider',
            [
                'label' => esc_html__('Overflow Divider', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Enable this to ensure the overlay image can overflow above the tilted divider', 'promen-elementor-widgets'),
                'prefix_class' => 'overlay-overflow-',
                'separator' => 'before',
            ]
        );
        
        $this->add_control(
            'absolute_overlay_z_index',
            [
                'label' => esc_html__('Z-Index', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 100,
                'step' => 1,
                'default' => 10,
                'description' => esc_html__('Increase this value to display the overlay image above other elements', 'promen-elementor-widgets'),
                'selectors' => [
                    '{{WRAPPER}} .absolute-overlay-image' => 'z-index: {{VALUE}} !important;',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
} 