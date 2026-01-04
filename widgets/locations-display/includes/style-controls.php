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

// Heading Style
$this->start_controls_section(
    'section_heading_style',
    [
        'label' => esc_html__('Heading', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
        'condition' => [
            'show_heading_section' => 'yes',
        ],
    ]
);

// Heading Alignment
$this->add_responsive_control(
    'heading_alignment',
    [
        'label' => esc_html__('Heading Section Alignment', 'promen-elementor-widgets'),
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
        'default' => 'center',
        'selectors' => [
            '{{WRAPPER}} .locations-heading' => 'text-align: {{VALUE}};',
        ],
    ]
);

// Use standardized split title style controls
promen_add_split_title_style_controls(
    $this, 
    'section_heading_style_controls', 
    ['show_heading_section' => 'yes'], 
    'locations'
);

// Override part 1 color default
$this->update_control(
    'title_part_1_color',
    [
        'default' => '#002868',
    ]
);

// Override part 2 color default
$this->update_control(
    'title_part_2_color',
    [
        'default' => '#00a0e3',
    ]
);

// Heading Alignment is already handled at the section level above with 'heading_alignment'
// but the helper adds 'title_alignment' which maps to 'locations-title'
// 'locations-title' is the container for split titles as well.


// Title Spacing
$this->add_responsive_control(
    'title_spacing',
    [
        'label' => esc_html__('Title Bottom Spacing', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SLIDER,
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
        'selectors' => [
            '{{WRAPPER}} .locations-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        'separator' => 'before',
    ]
);

// Description Typography
$this->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name' => 'description_typography',
        'label' => esc_html__('Description Typography', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .locations-heading-description',
        'global' => [
            'default' => Global_Typography::TYPOGRAPHY_TEXT,
        ],
        'condition' => [
            'show_heading_description' => 'yes',
        ],
    ]
);

// Description Color
$this->add_control(
    'description_color',
    [
        'label' => esc_html__('Description Color', 'promen-elementor-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .locations-heading-description' => 'color: {{VALUE}};',
        ],
        'global' => [
            'default' => Global_Colors::COLOR_TEXT,
        ],
        'condition' => [
            'show_heading_description' => 'yes',
        ],
    ]
);

// Description Alignment
$this->add_responsive_control(
    'description_alignment',
    [
        'label' => esc_html__('Description Alignment', 'promen-elementor-widgets'),
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
        'condition' => [
            'show_heading_description' => 'yes',
        ],
        'selectors' => [
            '{{WRAPPER}} .locations-heading-description' => 'text-align: {{VALUE}};',
        ],
    ]
);

// Description Spacing
$this->add_responsive_control(
    'description_margin',
    [
        'label' => esc_html__('Description Margin', 'promen-elementor-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'rem', 'em'],
        'selectors' => [
            '{{WRAPPER}} .locations-heading-description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'condition' => [
            'show_heading_description' => 'yes',
        ],
        'default' => [
            'top' => '0',
            'right' => '0',
            'bottom' => '2',
            'left' => '0',
            'unit' => 'rem',
            'isLinked' => false,
        ],
    ]
);

$this->end_controls_section();

// Locations Grid Style
$this->start_controls_section(
    'section_grid_style',
    [
        'label' => esc_html__('Locations Grid', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'grid_gap',
    [
        'label' => esc_html__('Gap', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'rem', 'em'],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 100,
                'step' => 1,
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
        'default' => [
            'unit' => 'rem',
            'size' => 2,
        ],
        'selectors' => [
            '{{WRAPPER}} .locations-grid' => 'gap: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'grid_alignment',
    [
        'label' => esc_html__('Grid Alignment', 'promen-elementor-widgets'),
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
            '{{WRAPPER}} .locations-grid' => 'justify-content: {{VALUE}};',
        ],
        'condition' => [
            'columns!' => '1',
        ],
    ]
);

$this->add_responsive_control(
    'grid_margin',
    [
        'label' => esc_html__('Margin', 'promen-elementor-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'rem', 'em'],
        'selectors' => [
            '{{WRAPPER}} .locations-grid' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->end_controls_section();

// Location Item Style
$this->start_controls_section(
    'section_location_item_style',
    [
        'label' => esc_html__('Location Item', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'location_item_padding',
    [
        'label' => esc_html__('Padding', 'promen-elementor-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'rem', 'em'],
        'selectors' => [
            '{{WRAPPER}} .location-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'location_item_content_alignment',
    [
        'label' => esc_html__('Content Alignment', 'promen-elementor-widgets'),
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
            '{{WRAPPER}} .location-info' => 'align-items: {{VALUE}};',
        ],
    ]
);

$this->add_group_control(
    Group_Control_Background::get_type(),
    [
        'name' => 'location_item_background',
        'label' => esc_html__('Background', 'promen-elementor-widgets'),
        'types' => ['classic', 'gradient'],
        'selector' => '{{WRAPPER}} .location-item',
    ]
);

$this->add_group_control(
    Group_Control_Border::get_type(),
    [
        'name' => 'location_item_border',
        'label' => esc_html__('Border', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .location-item',
    ]
);

$this->add_responsive_control(
    'location_item_border_radius',
    [
        'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'rem', 'em'],
        'selectors' => [
            '{{WRAPPER}} .location-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            '{{WRAPPER}} .location-item .location-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 0;',
        ],
    ]
);

$this->add_group_control(
    Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'location_item_box_shadow',
        'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .location-item',
    ]
);

$this->end_controls_section();

// Location Image Style
$this->start_controls_section(
    'section_image_style',
    [
        'label' => esc_html__('Location Image', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_responsive_control(
    'image_height',
    [
        'label' => esc_html__('Height', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SLIDER,
        'size_units' => ['px', 'vh', 'rem'],
        'range' => [
            'px' => [
                'min' => 100,
                'max' => 500,
                'step' => 10,
            ],
            'vh' => [
                'min' => 10,
                'max' => 50,
                'step' => 1,
            ],
            'rem' => [
                'min' => 5,
                'max' => 30,
                'step' => 1,
            ],
        ],
        'default' => [
            'unit' => 'px',
            'size' => 250,
        ],
        'selectors' => [
            '{{WRAPPER}} .location-image' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
        ],
    ]
);

$this->add_responsive_control(
    'image_object_position',
    [
        'label' => esc_html__('Image Focus Position', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
        'default' => 'center center',
        'options' => [
            'center center' => esc_html__('Center Center', 'promen-elementor-widgets'),
            'center top' => esc_html__('Center Top', 'promen-elementor-widgets'),
            'center bottom' => esc_html__('Center Bottom', 'promen-elementor-widgets'),
            'left center' => esc_html__('Left Center', 'promen-elementor-widgets'),
            'left top' => esc_html__('Left Top', 'promen-elementor-widgets'),
            'left bottom' => esc_html__('Left Bottom', 'promen-elementor-widgets'),
            'right center' => esc_html__('Right Center', 'promen-elementor-widgets'),
            'right top' => esc_html__('Right Top', 'promen-elementor-widgets'),
            'right bottom' => esc_html__('Right Bottom', 'promen-elementor-widgets'),
        ],
        'selectors' => [
            '{{WRAPPER}} .location-image img' => 'object-position: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'image_border_radius',
    [
        'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'rem', 'em'],
        'selectors' => [
            '{{WRAPPER}} .location-image, {{WRAPPER}} .location-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
    ]
);

$this->add_group_control(
    Group_Control_Box_Shadow::get_type(),
    [
        'name' => 'image_box_shadow',
        'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .location-image',
    ]
);

$this->end_controls_section();

// Location Name Style
$this->start_controls_section(
    'section_name_style',
    [
        'label' => esc_html__('Location Name', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name' => 'location_name_typography',
        'label' => esc_html__('Typography', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .location-name',
        'global' => [
            'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
        ],
    ]
);

$this->add_control(
    'location_name_color',
    [
        'label' => esc_html__('Color', 'promen-elementor-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .location-name' => 'color: {{VALUE}};',
        ],
        'global' => [
            'default' => Global_Colors::COLOR_SECONDARY,
        ],
    ]
);

$this->add_responsive_control(
    'location_name_alignment',
    [
        'label' => esc_html__('Alignment', 'promen-elementor-widgets'),
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
            '{{WRAPPER}} .location-name' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'location_name_margin',
    [
        'label' => esc_html__('Margin', 'promen-elementor-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'rem', 'em'],
        'selectors' => [
            '{{WRAPPER}} .location-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default' => [
            'top' => '1',
            'right' => '0',
            'bottom' => '0.5',
            'left' => '0',
            'unit' => 'rem',
            'isLinked' => false,
        ],
    ]
);

$this->end_controls_section();

// Address Info Style
$this->start_controls_section(
    'section_address_style',
    [
        'label' => esc_html__('Address Info', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_STYLE,
    ]
);

$this->add_group_control(
    Group_Control_Typography::get_type(),
    [
        'name' => 'address_typography',
        'label' => esc_html__('Typography', 'promen-elementor-widgets'),
        'selector' => '{{WRAPPER}} .location-address',
        'global' => [
            'default' => Global_Typography::TYPOGRAPHY_TEXT,
        ],
    ]
);

$this->add_control(
    'address_color',
    [
        'label' => esc_html__('Color', 'promen-elementor-widgets'),
        'type' => Controls_Manager::COLOR,
        'selectors' => [
            '{{WRAPPER}} .location-address' => 'color: {{VALUE}};',
        ],
        'global' => [
            'default' => Global_Colors::COLOR_TEXT,
        ],
    ]
);

$this->add_responsive_control(
    'address_alignment',
    [
        'label' => esc_html__('Alignment', 'promen-elementor-widgets'),
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
            '{{WRAPPER}} .location-address' => 'text-align: {{VALUE}};',
        ],
    ]
);

$this->add_responsive_control(
    'address_margin',
    [
        'label' => esc_html__('Margin', 'promen-elementor-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'rem', 'em'],
        'selectors' => [
            '{{WRAPPER}} .location-address' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default' => [
            'top' => '0',
            'right' => '0',
            'bottom' => '0',
            'left' => '0',
            'unit' => 'rem',
            'isLinked' => false,
        ],
    ]
);

$this->add_responsive_control(
    'address_padding',
    [
        'label' => esc_html__('Padding', 'promen-elementor-widgets'),
        'type' => Controls_Manager::DIMENSIONS,
        'size_units' => ['px', '%', 'rem', 'em'],
        'selectors' => [
            '{{WRAPPER}} .location-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
        'default' => [
            'top' => '1',
            'right' => '1',
            'bottom' => '1',
            'left' => '1',
            'unit' => 'rem',
            'isLinked' => true,
        ],
    ]
);

$this->end_controls_section(); 