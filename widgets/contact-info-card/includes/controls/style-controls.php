<?php
/**
 * Style Controls for Contact Info Card Widget
 * 
 * Handles the registration of style controls for the contact info card widget by including separate style control files.
 * This modular approach makes the code more maintainable.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Include all style control modules
require_once(__DIR__ . '/style/card-style.php');
require_once(__DIR__ . '/style/employee-info-block-style.php');
require_once(__DIR__ . '/style/heading-style.php');
require_once(__DIR__ . '/style/description-style.php');
require_once(__DIR__ . '/style/layout-style.php');
// Add additional style module imports here as needed

class Promen_Contact_Info_Card_Style_Controls {

    /**
     * Register style controls for the contact info card widget.
     * 
     * @param Contact_Info_Card_Widget $widget The widget instance
     */
    public static function register_controls($widget) {
        // Register layout style controls
        register_layout_style_controls($widget);
        
        // Register card style controls
        register_card_style_controls($widget);
        
        // Register employee info block style controls
        register_employee_info_block_style_controls($widget);
        
        // Register heading style controls
        register_heading_style_controls($widget);
        
        // Register description style controls
        register_description_style_controls($widget);
        
        // Add style section for the icon list
        $widget->start_controls_section(
            'section_icon_list_style',
            [
                'label' => esc_html__('Icon List', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'content_type' => 'icon_list',
                    'show_description' => 'yes',
                ],
            ]
        );

        // Icon Style
        $widget->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .contact-info-card__icon-list-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .contact-info-card__icon-list-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-card__icon-list-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .contact-info-card__icon-list-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Text Style
        $widget->add_control(
            'list_text_color',
            [
                'label' => esc_html__('Text Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .contact-info-card__icon-list-text' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'list_typography',
                'selector' => '{{WRAPPER}} .contact-info-card__icon-list-text',
            ]
        );

        // List Item Spacing
        $widget->add_responsive_control(
            'list_item_spacing',
            [
                'label' => esc_html__('List Item Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 16,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-card__icon-list-item:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        // Icon Spacing
        $widget->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default' => [
                    'size' => 10,
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .contact-info-card__icon-list-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->end_controls_section();
    }
}
 