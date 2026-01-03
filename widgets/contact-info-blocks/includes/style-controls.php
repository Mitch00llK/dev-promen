<?php
/**
 * Style Controls
 */

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

// Container Style
$this->start_controls_section(
    'section_container_style',
    [
        'label' => esc_html__('Container', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
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

$this->add_responsive_control(
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

$this->add_group_control(
    Group_Control_Background::get_type(),
    [
        'name' => 'container_background',
        'label' => esc_html__('Background', 'promen-elementor-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .contact-info-blocks',
    ]
);

$this->add_group_control(
    Group_Control_Border::get_type(),
    [
        'name' => 'container_border',
        'label' => esc_html__('Border', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .contact-info-blocks',
    ]
);

$this->add_responsive_control(
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

$this->add_group_control(
    Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'container_box_shadow',
        'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .contact-info-blocks',
    ]
);

$this->end_controls_section();

// Info Blocks Style
$this->start_controls_section(
    'section_info_blocks_style',
    [
        'label' => esc_html__('Info Blocks', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
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

$this->add_group_control(
    Group_Control_Background::get_type(),
    [
        'name' => 'blocks_background',
        'label' => esc_html__('Background', 'promen-elementor-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .contact-info-block',
    ]
);

$this->add_group_control(
    Group_Control_Border::get_type(),
    [
        'name' => 'blocks_border',
        'label' => esc_html__('Border', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .contact-info-block',
    ]
);

$this->add_responsive_control(
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

$this->add_group_control(
    Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'blocks_box_shadow',
        'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .contact-info-block',
    ]
);

$this->add_responsive_control(
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

$this->add_responsive_control(
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

$this->end_controls_section();

// Title Style
$this->start_controls_section(
    'section_title_style',
    [
        'label' => esc_html__('Title', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
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

$this->add_responsive_control(
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

$this->add_control(
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

$this->end_controls_section();

// Content Style
$this->start_controls_section(
    'section_content_style',
    [
        'label' => esc_html__('Content', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
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

$this->add_control(
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

$this->add_control(
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

$this->end_controls_section();

// Icon Style
$this->start_controls_section(
    'section_icon_style',
    [
        'label' => esc_html__('Icon', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
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

$this->add_responsive_control(
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

$this->add_control(
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

$this->add_control(
    'icon_background_options',
    [
        'label' => esc_html__('Background Options', 'promen-elementor-widgets'),
        'type' => Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

$this->add_control(
    'icon_background_show',
    [
        'label' => esc_html__('Show Background', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'no',
    ]
);

$this->add_responsive_control(
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

$this->add_group_control(
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

$this->add_responsive_control(
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

$this->end_controls_section();

// Responsive Controls
$this->start_controls_section(
    'section_responsive_style',
    [
        'label' => esc_html__('Responsive', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_control(
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

$this->add_control(
    'tablet_breakpoint',
    [
        'label' => esc_html__('Tablet Breakpoint', 'promen-elementor-widgets'),
        'type' => Controls_Manager::NUMBER,
        'default' => 768,
        'min' => 300,
        'max' => 1200,
    ]
);

$this->add_control(
    'mobile_breakpoint',
    [
        'label' => esc_html__('Mobile Breakpoint', 'promen-elementor-widgets'),
        'type' => Controls_Manager::NUMBER,
        'default' => 480,
        'min' => 300,
        'max' => 600,
    ]
);

$this->end_controls_section(); 