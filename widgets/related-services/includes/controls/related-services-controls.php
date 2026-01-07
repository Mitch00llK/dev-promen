<?php
/**
 * Related Services Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Promen_Related_Services_Controls {

    /**
     * Register Related Services Widget Controls
     */
    public static function register_controls($widget) {
        // Content Section
        $widget->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Show/Hide Title
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

        // Split Heading
        $widget->add_control(
            'title_part_1',
            [
                'label' => esc_html__('Title Part 1', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Bekijk ook onze andere', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'title_part_2',
            [
                'label' => esc_html__('Title Part 2', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('werkuitbestedingen', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        // Title HTML Tag
        $widget->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        // Services Repeater
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'show_service',
            [
                'label' => esc_html__('Show Service', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'service_icon',
            [
                'label' => esc_html__('Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-graduation-cap',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'show_service' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'service_title',
            [
                'label' => esc_html__('Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Service Title', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_service' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'service_title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                    'div' => 'DIV',
                    'span' => 'SPAN',
                    'p' => 'P',
                ],
                'condition' => [
                    'show_service' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'service_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#8ECBDE',
                'selectors' => [
                    '{{WRAPPER}} .related-service-card.service-id-{{ID}}' => 'background-color: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_service' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'service_link',
            [
                'label' => esc_html__('Link', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'show_service' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'services',
            [
                'label' => esc_html__('Services', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'service_title' => esc_html__('Individuele detachering', 'promen-elementor-widgets'),
                        'show_service' => 'yes',
                    ],
                    [
                        'service_title' => esc_html__('Techniek & Verpakken', 'promen-elementor-widgets'),
                        'show_service' => 'yes',
                    ],
                ],
                'title_field' => '{{{ service_title }}}',
            ]
        );

        $widget->end_controls_section();

        // Style Section - Layout
        $widget->start_controls_section(
            'layout_section',
            [
                'label' => esc_html__('Layout', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Layout Type
        $widget->add_control(
            'layout_type',
            [
                'label' => esc_html__('Layout Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'two-column',
                'options' => [
                    'two-column' => esc_html__('Two Column (Title Left, Cards Right)', 'promen-elementor-widgets'),
                    'stacked' => esc_html__('Stacked (Title Top, Cards Bottom)', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'related-services-layout-',
            ]
        );

        // Title Column Width
        $widget->add_responsive_control(
            'title_column_width',
            [
                'label' => esc_html__('Title Column Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                    'px' => [
                        'min' => 100,
                        'max' => 500,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .related-services-title-column' => 'flex-basis: {{SIZE}}{{UNIT}}; max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .related-services-cards-column' => 'flex-basis: calc(100% - {{SIZE}}{{UNIT}} - 30px);',
                ],
                'condition' => [
                    'layout_type' => 'two-column',
                ],
            ]
        );

        // Vertical Alignment
        $widget->add_control(
            'vertical_alignment',
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
                ],
                'default' => 'flex-start',
                'selectors' => [
                    '{{WRAPPER}} .related-services-wrapper' => 'align-items: {{VALUE}};',
                ],
                'condition' => [
                    'layout_type' => 'two-column',
                ],
            ]
        );

        // Columns
        $widget->add_responsive_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '2',
                'tablet_default' => '2',
                'mobile_default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
                'selectors' => [
                    '{{WRAPPER}} .related-services-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        // Gap Between Items
        $widget->add_responsive_control(
            'column_gap',
            [
                'label' => esc_html__('Columns Gap', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .related-services-grid' => 'column-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'row_gap',
            [
                'label' => esc_html__('Rows Gap', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 10,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} .related-services-grid' => 'row-gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Section - Title
        $widget->start_controls_section(
            'title_style_section',
            [
                'label' => esc_html__('Title', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_title' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .related-services-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .related-services-title',
            ]
        );

        $widget->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .related-services-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
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
                    '{{WRAPPER}} .related-services-title' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Section - Service Cards
        $widget->start_controls_section(
            'service_cards_style_section',
            [
                'label' => esc_html__('Service Cards', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Card Background
        $widget->add_control(
            'card_background_color',
            [
                'label' => esc_html__('Default Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#8ECBDE',
                'selectors' => [
                    '{{WRAPPER}} .related-service-card' => 'background-color: {{VALUE}};',
                ],
                'description' => esc_html__('This will be used as the default background color for all cards. Individual card background colors will override this setting.', 'promen-elementor-widgets'),
            ]
        );

        // Card Border Radius
        $widget->add_responsive_control(
            'card_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'default' => [
                    'top' => '10',
                    'right' => '10',
                    'bottom' => '10',
                    'left' => '10',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .related-service-card' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Card Padding
        $widget->add_responsive_control(
            'card_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'default' => [
                    'top' => '30',
                    'right' => '30',
                    'bottom' => '30',
                    'left' => '30',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .related-service-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Card Hover Animation
        $widget->add_control(
            'card_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'promen-elementor-widgets'),
                    'translateY' => esc_html__('Move Up', 'promen-elementor-widgets'),
                    'scale' => esc_html__('Scale', 'promen-elementor-widgets'),
                    'both' => esc_html__('Move Up & Scale', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Section - Icon
        $widget->start_controls_section(
            'icon_style_section',
            [
                'label' => esc_html__('Icon', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Icon Color
        $widget->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0A2D5E',
                'selectors' => [
                    '{{WRAPPER}} .related-service-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .related-service-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        // Icon Size
        $widget->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 10,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'selectors' => [
                    '{{WRAPPER}} .related-service-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .related-service-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Icon Margin
        $widget->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .related-service-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Section - Service Title
        $widget->start_controls_section(
            'service_title_style_section',
            [
                'label' => esc_html__('Service Title', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Service Title Color
        $widget->add_control(
            'service_title_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0A2D5E',
                'selectors' => [
                    '{{WRAPPER}} .related-service-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Service Title Typography
        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'service_title_typography',
                'selector' => '{{WRAPPER}} .related-service-title',
            ]
        );

        // Service Title Margin
        $widget->add_responsive_control(
            'service_title_margin',
            [
                'label' => esc_html__('Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .related-service-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Section - Arrow
        $widget->start_controls_section(
            'arrow_style_section',
            [
                'label' => esc_html__('Arrow', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Show/Hide Arrow
        $widget->add_control(
            'show_arrow',
            [
                'label' => esc_html__('Show Arrow', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Arrow Color
        $widget->add_control(
            'arrow_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0A2D5E',
                'selectors' => [
                    '{{WRAPPER}} .related-service-arrow' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_arrow' => 'yes',
                ],
            ]
        );

        // Arrow Size
        $widget->add_responsive_control(
            'arrow_size',
            [
                'label' => esc_html__('Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 5,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .related-service-arrow' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_arrow' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }
}