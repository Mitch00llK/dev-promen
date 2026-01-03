<?php
/**
 * Style Controls for Business Catering Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Title Style Section
$this->start_controls_section(
    'section_title_style',
    [
        'label' => esc_html__('Title Style', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
        'condition' => [
            'section_title!' => '',
        ],
    ]
);

$this->add_control(
    'title_color',
    [
        'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .promen-catering-title' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'title_highlight_color',
    [
        'label' => esc_html__('Title Highlight Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .promen-catering-title .highlight' => 'color: {{VALUE}};',
        ],
        'condition' => [
            'split_title' => 'yes',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'title_typography',
        'selector' => '{{WRAPPER}} .promen-catering-title',
    ]
);

$this->add_responsive_control(
    'title_margin',
    [
        'label' => esc_html__('Margin', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .promen-catering-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'title_padding',
    [
        'label' => esc_html__('Padding', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .promen-catering-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
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
            '{{WRAPPER}} .promen-catering-title-wrapper' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

// Images Style Section
$this->start_controls_section(
    'section_images_style',
    [
        'label' => esc_html__('Images Style', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'image_border_radius',
    [
        'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'selectors' => [
            '{{WRAPPER}} .promen-catering-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} .promen-catering-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'image_border',
        'selector' => '{{WRAPPER}} .promen-catering-image',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'image_box_shadow',
        'selector' => '{{WRAPPER}} .promen-catering-image',
    ]
);

$this->add_responsive_control(
    'image_padding',
    [
        'label' => esc_html__('Padding', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .promen-catering-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'image_margin',
    [
        'label' => esc_html__('Margin', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .promen-catering-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'image_background_color',
    [
        'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .promen-catering-image' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'image_hover_animation',
    [
        'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
    ]
);

$this->end_controls_section();

// Overlay Style Section
$this->start_controls_section(
    'section_overlay_style',
    [
        'label' => esc_html__('Overlay Style', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'overlay_background_color',
    [
        'label' => esc_html__('Overlay Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => 'rgba(0, 0, 0, 0.5)',
        'selectors' => [
            '{{WRAPPER}} .promen-catering-overlay' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'overlay_title_color',
    [
        'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
            '{{WRAPPER}} .promen-catering-overlay-title' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'overlay_title_typography',
        'selector' => '{{WRAPPER}} .promen-catering-overlay-title',
    ]
);

$this->add_control(
    'overlay_description_color',
    [
        'label' => esc_html__('Description Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
            '{{WRAPPER}} .promen-catering-overlay-description' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'overlay_description_typography',
        'selector' => '{{WRAPPER}} .promen-catering-overlay-description',
    ]
);

$this->add_responsive_control(
    'overlay_padding',
    [
        'label' => esc_html__('Padding', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .promen-catering-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'overlay_text_alignment',
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
            '{{WRAPPER}} .promen-catering-overlay' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->end_controls_section();

// Slider Navigation Style Section
$this->start_controls_section(
    'section_slider_navigation_style',
    [
        'label' => esc_html__('Slider Navigation Style', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
    'arrow_size',
    [
        'label' => esc_html__('Arrow Size', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 20,
                'max' => 60,
                'step' => 1,
            ],
        ],
        'default' => [
            'unit' => 'px',
            'size' => 44,
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'arrow_color',
    [
        'label' => esc_html__('Arrow Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next:after, {{WRAPPER}} .swiper-button-prev:after' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'arrow_background_color',
    [
        'label' => esc_html__('Arrow Background Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'arrow_border',
        'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
    ]
);

$this->add_control(
    'arrow_border_radius',
    [
        'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%'],
        'default' => [
            'top' => '50',
            'right' => '50',
            'bottom' => '50',
            'left' => '50',
            'unit' => '%',
            'isLinked' => true,
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'arrow_box_shadow',
        'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
    ]
);

$this->add_control(
    'pagination_heading',
    [
        'label' => esc_html__('Pagination', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'pagination_color',
    [
        'label' => esc_html__('Pagination Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#cccccc',
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'pagination_active_color',
    [
        'label' => esc_html__('Pagination Active Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#000000',
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'pagination_size',
    [
        'label' => esc_html__('Pagination Size', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 5,
                'max' => 20,
                'step' => 1,
            ],
        ],
        'default' => [
            'unit' => 'px',
            'size' => 10,
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'pagination_spacing',
    [
        'label' => esc_html__('Pagination Spacing', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 20,
                'step' => 1,
            ],
        ],
        'default' => [
            'unit' => 'px',
            'size' => 5,
        ],
        'selectors' => [
            '{{WRAPPER}} .swiper-pagination-bullet' => 'margin: 0 {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section(); 