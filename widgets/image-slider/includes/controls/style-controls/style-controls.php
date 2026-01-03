<?php
/**
 * Style Controls for Business Catering Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Use standardized split title style controls
promen_add_split_title_style_controls(
    $this,
    'section_title_style',
    ['show_title' => 'yes'],
    'promen-slider'
);

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
            '{{WRAPPER}} .promen-slider-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} .promen-slider-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Border::get_type(),
    [
        'name' => 'image_border',
        'selector' => '{{WRAPPER}} .promen-slider-image',
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'image_box_shadow',
        'selector' => '{{WRAPPER}} .promen-slider-image',
    ]
);

$this->add_responsive_control(
    'image_padding',
    [
        'label' => esc_html__('Padding', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .promen-slider-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            '{{WRAPPER}} .promen-slider-image-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'image_background_color',
    [
        'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .promen-slider-image' => 'background-color: {{VALUE}};',
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
            '{{WRAPPER}} .promen-slider-overlay' => 'background-color: {{VALUE}} !important;',
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
            '{{WRAPPER}} .promen-slider-overlay-title' => 'color: {{VALUE}} !important;',
            '{{WRAPPER}} .promen-slider-overlay-title a' => 'color: {{VALUE}} !important;',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'overlay_title_typography',
        'selector' => '{{WRAPPER}} .promen-slider-overlay-title',
    ]
);

$this->add_control(
    'overlay_description_color',
    [
        'label' => esc_html__('Description Color', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::COLOR,
        'default' => '#ffffff',
        'selectors' => [
            '{{WRAPPER}} .promen-slider-overlay-description' => 'color: {{VALUE}} !important;',
            '{{WRAPPER}} .promen-slider-overlay-description a' => 'color: {{VALUE}} !important;',
        ],
    ]
);

$this->add_group_control(
    \Elementor\Group_Control_Typography::get_type(),
    [
        'name' => 'overlay_description_typography',
        'selector' => '{{WRAPPER}} .promen-slider-overlay-description',
    ]
);

$this->add_responsive_control(
    'overlay_padding',
    [
        'label' => esc_html__('Padding', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .promen-slider-overlay' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
            '{{WRAPPER}} .promen-slider-overlay' => 'text-align: {{VALUE}};',
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

// Layout Settings Section
$this->start_controls_section(
    'section_layout_settings',
    [
        'label' => esc_html__('Slides Per View', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_responsive_control(
    'slides_to_show',
    [
        'label' => esc_html__('Slides to Show', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '3',
        'tablet_default' => '2',
        'mobile_default' => '1',
        'options' => [
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
        ],
        'frontend_available' => true,
    ]
);

$this->add_responsive_control(
    'space_between',
    [
        'label' => esc_html__('Space Between Slides', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SLIDER,
        'size_units' => ['px'],
        'default' => [
            'size' => 30,
        ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
            ],
        ],
        'frontend_available' => true,
    ]
);

$this->end_controls_section(); 