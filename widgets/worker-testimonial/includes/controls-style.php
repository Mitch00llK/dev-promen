<?php
/**
 * Worker Testimonial Widget - Style Controls
 *
 * @package Promen\Widgets
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

// Image Style Section
$this->start_controls_section(
    'image_style_section',
    [
        'label' => esc_html__('Image Style', 'promen-elementor'),
        'tab' => Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_image' => 'yes',
        ],
    ]
);

$this->add_responsive_control(
    'image_height',
    [
        'label' => esc_html__('Image Height', 'promen-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'rem', 'vh'],
        'range' => [
            'px' => [
                'min' => 200,
                'max' => 1000,
                'step' => 10,
            ],
            'rem' => [
                'min' => 10,
                'max' => 100,
            ],
            'vh' => [
                'min' => 30,
                'max' => 100,
            ],
        ],
        'default' => [
            'unit' => 'rem',
            'size' => 35,
        ],
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__image-wrapper' => 'height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_control(
    'image_fit',
    [
        'label' => esc_html__('Image Fit', 'promen-elementor'),
        'type' => Controls_Manager::SELECT,
        'default' => 'cover',
        'options' => [
            'cover' => esc_html__('Cover', 'promen-elementor'),
            'contain' => esc_html__('Contain', 'promen-elementor'),
            'fill' => esc_html__('Fill', 'promen-elementor'),
            'none' => esc_html__('None', 'promen-elementor'),
        ],
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__image' => 'object-fit: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'image_position',
    [
        'label' => esc_html__('Image Position', 'promen-elementor'),
        'type' => Controls_Manager::SELECT,
        'default' => 'center center',
        'options' => [
            'top left' => esc_html__('Top Left', 'promen-elementor'),
            'top center' => esc_html__('Top Center', 'promen-elementor'),
            'top right' => esc_html__('Top Right', 'promen-elementor'),
            'center left' => esc_html__('Center Left', 'promen-elementor'),
            'center center' => esc_html__('Center Center', 'promen-elementor'),
            'center right' => esc_html__('Center Right', 'promen-elementor'),
            'bottom left' => esc_html__('Bottom Left', 'promen-elementor'),
            'bottom center' => esc_html__('Bottom Center', 'promen-elementor'),
            'bottom right' => esc_html__('Bottom Right', 'promen-elementor'),
        ],
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__image' => 'object-position: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'image_overlay',
    [
        'label' => esc_html__('Image Overlay', 'promen-elementor'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__image-wrapper::after' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_control(
    'image_overlay_blend_mode',
    [
        'label' => esc_html__('Blend Mode', 'promen-elementor'),
        'type' => Controls_Manager::SELECT,
        'options' => [
            'normal' => esc_html__('Normal', 'promen-elementor'),
            'multiply' => esc_html__('Multiply', 'promen-elementor'),
            'screen' => esc_html__('Screen', 'promen-elementor'),
            'overlay' => esc_html__('Overlay', 'promen-elementor'),
            'darken' => esc_html__('Darken', 'promen-elementor'),
            'lighten' => esc_html__('Lighten', 'promen-elementor'),
            'soft-light' => esc_html__('Soft Light', 'promen-elementor'),
            'hard-light' => esc_html__('Hard Light', 'promen-elementor'),
        ],
        'default' => 'normal',
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__image-wrapper::after' => 'mix-blend-mode: {{VALUE}};',
        ],
        'condition' => [
            'image_overlay!' => '',
        ],
    ]
);

$this->end_controls_section();

// Icon Style Section
$this->start_controls_section(
    'icon_style_section',
    [
        'label' => esc_html__('Icon Style', 'promen-elementor'),
        'tab' => Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_quote' => 'yes',
        ],
    ]
);

// Icon Style
$this->add_control(
    'icon_style_heading',
    [
        'label' => esc_html__('Icon', 'promen-elementor'),
        'type' => Controls_Manager::HEADING,
    ]
);

$this->add_control(
    'quote_icon_color',
    [
        'label' => esc_html__('Color', 'promen-elementor'),
        'type' => Controls_Manager::COLOR,
        'default' => '#002B49',
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__quote-icon' => 'color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'quote_icon_size',
    [
        'label' => esc_html__('Size', 'promen-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'rem', 'em'],
        'range' => [
            'px' => [
                'min' => 16,
                'max' => 100,
            ],
            'rem' => [
                'min' => 1,
                'max' => 10,
            ],
            'em' => [
                'min' => 1,
                'max' => 10,
            ],
        ],
        'default' => [
            'unit' => 'rem',
            'size' => 3,
        ],
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__quote-icon' => 'font-size: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'quote_icon_align',
    [
        'label' => esc_html__('Alignment', 'promen-elementor'),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
            'flex-start' => [
                'title' => esc_html__('Left', 'promen-elementor'),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__('Center', 'promen-elementor'),
                'icon' => 'eicon-text-align-center',
            ],
            'flex-end' => [
                'title' => esc_html__('Right', 'promen-elementor'),
                'icon' => 'eicon-text-align-right',
            ],
        ],
        'default' => 'center',
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__quote-icon' => 'align-self: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'icon_spacing',
    [
        'label' => esc_html__('Bottom Spacing', 'promen-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'rem', 'em'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
            ],
            'rem' => [
                'min' => 0,
                'max' => 10,
            ],
            'em' => [
                'min' => 0,
                'max' => 10,
            ],
        ],
        'default' => [
            'unit' => 'rem',
            'size' => 1.5,
        ],
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__quote-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
    ]
);

// Background Style
$this->add_control(
    'icon_background_heading',
    [
        'label' => esc_html__('Background', 'promen-elementor'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'quote_icon_background',
    [
        'label' => esc_html__('Color', 'promen-elementor'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__quote-icon' => 'background-color: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'quote_icon_padding',
    [
        'label' => esc_html__('Padding', 'promen-elementor'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__quote-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'quote_icon_border_radius',
    [
        'label' => esc_html__('Border Radius', 'promen-elementor'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', 'em', 'rem', '%'],
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__quote-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

// Content Style Section
$this->start_controls_section(
    'content_style_section',
    [
        'label' => esc_html__('Content Style', 'promen-elementor'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

// Position Controls
$this->add_control(
    'content_position_heading',
    [
        'label' => esc_html__('Content Position', 'promen-elementor'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'content_vertical_position',
    [
        'label' => esc_html__('Vertical Position', 'promen-elementor'),
        'type' => Controls_Manager::SELECT,
        'default' => 'bottom-overlap',
        'options' => [
            'bottom-overlap' => esc_html__('Bottom Overlap', 'promen-elementor'),
            'center' => esc_html__('Center', 'promen-elementor'),
        ],
        'prefix_class' => 'worker-testimonial--position-',
    ]
);

$this->add_control(
    'content_alignment',
    [
        'label' => esc_html__('Content Box Alignment', 'promen-elementor'),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
            'left' => [
                'title' => esc_html__('Left', 'promen-elementor'),
                'icon' => 'eicon-h-align-left',
            ],
            'center' => [
                'title' => esc_html__('Center', 'promen-elementor'),
                'icon' => 'eicon-h-align-center',
            ],
            'right' => [
                'title' => esc_html__('Right', 'promen-elementor'),
                'icon' => 'eicon-h-align-right',
            ],
        ],
        'default' => 'center',
        'prefix_class' => 'worker-testimonial--align-',
    ]
);

$this->add_responsive_control(
    'content_width',
    [
        'label' => esc_html__('Content Width', 'promen-elementor'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', '%', 'rem'],
        'range' => [
            'px' => [
                'min' => 200,
                'max' => 1200,
            ],
            '%' => [
                'min' => 10,
                'max' => 100,
            ],
            'rem' => [
                'min' => 20,
                'max' => 100,
            ],
        ],
        'default' => [
            'unit' => '%',
            'size' => 90,
        ],
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__content' => 'width: {{SIZE}}{{UNIT}};',
        ],
    ]
);

// Text Alignment Control
$this->add_responsive_control(
    'text_alignment',
    [
        'label' => esc_html__('Text Alignment', 'promen-elementor'),
        'type' => Controls_Manager::CHOOSE,
        'options' => [
            'left' => [
                'title' => esc_html__('Left', 'promen-elementor'),
                'icon' => 'eicon-text-align-left',
            ],
            'center' => [
                'title' => esc_html__('Center', 'promen-elementor'),
                'icon' => 'eicon-text-align-center',
            ],
            'right' => [
                'title' => esc_html__('Right', 'promen-elementor'),
                'icon' => 'eicon-text-align-right',
            ],
        ],
        'default' => 'center',
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__content' => 'text-align: {{VALUE}};',
            '{{WRAPPER}} .worker-testimonial__quote-wrapper' => 'align-items: {{VALUE}};',
            '{{WRAPPER}} .worker-testimonial__name' => 'text-align: {{VALUE}};',
        ],
    ]
);

// Quote Typography
$this->add_control(
    'quote_style_heading',
    [
        'label' => esc_html__('Quote Style', 'promen-elementor'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => [
            'show_quote' => 'yes',
        ],
    ]
);

$this->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name' => 'quote_typography',
        'label' => esc_html__('Typography', 'promen-elementor'),
        'selector' => '{{WRAPPER}} .worker-testimonial__quote',
        'condition' => [
            'show_quote' => 'yes',
        ],
    ]
);

$this->add_control(
    'quote_color',
    [
        'label' => esc_html__('Text Color', 'promen-elementor'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__quote' => 'color: {{VALUE}};',
        ],
        'condition' => [
            'show_quote' => 'yes',
        ],
    ]
);

// Name Typography
$this->add_control(
    'name_style_heading',
    [
        'label' => esc_html__('Name Style', 'promen-elementor'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => [
            'show_name' => 'yes',
        ],
    ]
);

$this->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name' => 'name_typography',
        'label' => esc_html__('Typography', 'promen-elementor'),
        'selector' => '{{WRAPPER}} .worker-testimonial__name',
        'condition' => [
            'show_name' => 'yes',
        ],
    ]
);

$this->add_control(
    'name_color',
    [
        'label' => esc_html__('Text Color', 'promen-elementor'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__name' => 'color: {{VALUE}};',
        ],
        'condition' => [
            'show_name' => 'yes',
        ],
    ]
);

// Split Heading Styles
$this->add_control(
    'split_heading_style',
    [
        'label' => esc_html__('Split Heading Style', 'promen-elementor'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
        'condition' => [
            'show_name' => 'yes',
            'enable_split_heading' => 'yes',
        ],
    ]
);

$this->add_control(
    'split_text_before_color',
    [
        'label' => esc_html__('Before Text Color', 'promen-elementor'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__name--split .light' => 'color: {{VALUE}};',
        ],
        'condition' => [
            'show_name' => 'yes',
            'enable_split_heading' => 'yes',
        ],
    ]
);

$this->add_control(
    'split_text_after_color',
    [
        'label' => esc_html__('After Text Color', 'promen-elementor'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .worker-testimonial__name--split .bold' => 'color: {{VALUE}};',
        ],
        'condition' => [
            'show_name' => 'yes',
            'enable_split_heading' => 'yes',
        ],
    ]
);

$this->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name' => 'split_text_before_typography',
        'label' => esc_html__('Before Typography', 'promen-elementor'),
        'selector' => '{{WRAPPER}} .worker-testimonial__name--split .light',
        'condition' => [
            'show_name' => 'yes',
            'enable_split_heading' => 'yes',
        ],
    ]
);

$this->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name' => 'split_text_after_typography',
        'label' => esc_html__('After Typography', 'promen-elementor'),
        'selector' => '{{WRAPPER}} .worker-testimonial__name--split .bold',
        'condition' => [
            'show_name' => 'yes',
            'enable_split_heading' => 'yes',
        ],
    ]
);

$this->end_controls_section(); 