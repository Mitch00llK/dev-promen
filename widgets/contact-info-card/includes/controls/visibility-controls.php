<?php
/**
 * Visibility Controls for Contact Info Card Widget
 * 
 * Handles the registration of visibility controls for the contact info card widget.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Contact_Info_Card_Visibility_Controls {

    /**
     * Register visibility controls for the contact info card widget.
     * 
     * @param Contact_Info_Card_Widget $widget The widget instance
     */
    public static function register_controls($widget) {
        // Visibility Section
        $widget->start_controls_section(
            'section_visibility',
            [
                'label' => esc_html__('Element Visibility', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Main Content Elements
        $widget->add_control(
            'main_content_heading',
            [
                'label' => esc_html__('Main Content Elements', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Show Heading
        $widget->add_control(
            'show_heading',
            [
                'label' => esc_html__('Show Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
            ]
        );

        // Show Description
        $widget->add_control(
            'show_description',
            [
                'label' => esc_html__('Show Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
            ]
        );

        // Show CTA Button
        $widget->add_control(
            'show_cta_button',
            [
                'label' => esc_html__('Show CTA Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
            ]
        );

        // Employee Info Elements
        $widget->add_control(
            'employee_info_heading',
            [
                'label' => esc_html__('Employee Info Elements', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'right_side_content_type' => ['employee_info', 'combined_layout'],
                ],
            ]
        );

        // Show Employee Image
        $widget->add_control(
            'show_employee_image',
            [
                'label' => esc_html__('Show Employee Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => ['employee_info', 'combined_layout'],
                ],
            ]
        );

        // Show Contact Heading
        $widget->add_control(
            'show_contact_heading',
            [
                'label' => esc_html__('Show Contact Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => ['employee_info', 'combined_layout'],
                ],
            ]
        );

        // Show Employee Name
        $widget->add_control(
            'show_employee_name',
            [
                'label' => esc_html__('Show Employee Name', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => ['employee_info', 'combined_layout'],
                ],
            ]
        );

        // Show Email
        $widget->add_control(
            'show_email',
            [
                'label' => esc_html__('Show Email', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => ['employee_info', 'combined_layout'],
                ],
            ]
        );

        // Show Phone
        $widget->add_control(
            'show_phone',
            [
                'label' => esc_html__('Show Phone', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => ['employee_info', 'combined_layout'],
                ],
            ]
        );

        // Gravity Form Elements
        $widget->add_control(
            'gravity_form_heading',
            [
                'label' => esc_html__('Gravity Form Elements', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'right_side_content_type' => ['gravity_form', 'combined_layout'],
                ],
            ]
        );

        // Show Gravity Form
        $widget->add_control(
            'show_gravity_form',
            [
                'label' => esc_html__('Show Gravity Form', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => ['gravity_form', 'combined_layout'],
                ],
            ]
        );

        // Custom Form Elements
        $widget->add_control(
            'custom_form_heading',
            [
                'label' => esc_html__('Custom Form Elements', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                ],
            ]
        );

        // Show Custom Form
        $widget->add_control(
            'show_custom_form',
            [
                'label' => esc_html__('Show Custom Form', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                ],
            ]
        );

        // Show Name Field
        $widget->add_control(
            'show_name_field',
            [
                'label' => esc_html__('Show Name Field', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                    'show_custom_form' => 'yes',
                ],
            ]
        );

        // Show Phone Field
        $widget->add_control(
            'show_phone_field',
            [
                'label' => esc_html__('Show Phone Field', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                    'show_custom_form' => 'yes',
                ],
            ]
        );

        // Show Email Field
        $widget->add_control(
            'show_email_field',
            [
                'label' => esc_html__('Show Email Field', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                    'show_custom_form' => 'yes',
                ],
            ]
        );

        // Show CV Field
        $widget->add_control(
            'show_cv_field',
            [
                'label' => esc_html__('Show CV Field', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                    'show_custom_form' => 'yes',
                ],
            ]
        );

        // Show Motivation Field
        $widget->add_control(
            'show_motivation_field',
            [
                'label' => esc_html__('Show Motivation Field', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                    'show_custom_form' => 'yes',
                ],
            ]
        );

        // Show Submit Button
        $widget->add_control(
            'show_submit_button',
            [
                'label' => esc_html__('Show Submit Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'default' => 'yes',
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                    'show_custom_form' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }
}
 