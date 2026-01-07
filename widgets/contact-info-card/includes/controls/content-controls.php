<?php
/**
 * Content Controls for Contact Info Card Widget
 * 
 * Handles the registration of content controls for the contact info card widget.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Contact_Info_Card_Content_Controls {

    /**
     * Register content controls for the contact info card widget.
     * 
     * @param Contact_Info_Card_Widget $widget The widget instance
     */
    public static function register_controls($widget) {
        // Main Content Section
        $widget->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Background Color
        $widget->add_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#2A6B6B',
                'selectors' => [
                    '{{WRAPPER}} .contact-info-card' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        // Use the standardized split title controls
        promen_add_split_title_controls(
            $widget, 
            'section_content', 
            [], 
            esc_html__('Benieuwd wat wij voor je kunnen betekenen?', 'promen-elementor-widgets'),
            'heading'
        );

        // Description
        $widget->add_control(
            'content_type',
            [
                'label' => esc_html__('Content Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'description',
                'options' => [
                    'description' => esc_html__('Text Description', 'promen-elementor-widgets'),
                    'icon_list' => esc_html__('Icon List', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Neem contact met ons op voor meer informatie over onze diensten en hoe wij jou kunnen helpen.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter description', 'promen-elementor-widgets'),
                'condition' => [
                    'content_type' => 'description',
                ],
            ]
        );

        // Icon List
        $list_repeater = new \Elementor\Repeater();

        $list_repeater->add_control(
            'item_icon',
            [
                'label' => esc_html__('Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-check',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $list_repeater->add_control(
            'item_text',
            [
                'label' => esc_html__('Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('List item', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter list item text', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'icon_list_items',
            [
                'label' => esc_html__('List Items', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $list_repeater->get_controls(),
                'default' => [
                    [
                        'item_text' => esc_html__('Professional service', 'promen-elementor-widgets'),
                        'item_icon' => [
                            'value' => 'fas fa-check',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'item_text' => esc_html__('Quick response', 'promen-elementor-widgets'),
                        'item_icon' => [
                            'value' => 'fas fa-check',
                            'library' => 'fa-solid',
                        ],
                    ],
                    [
                        'item_text' => esc_html__('Expert advice', 'promen-elementor-widgets'),
                        'item_icon' => [
                            'value' => 'fas fa-check',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'title_field' => '{{{ item_text }}}',
                'condition' => [
                    'content_type' => 'icon_list',
                ],
            ]
        );

        // CTA Button
        $widget->add_control(
            'cta_button_text',
            [
                'label' => esc_html__('Button Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Neem contact op', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter button text', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'cta_button_link',
            [
                'label' => esc_html__('Button Link', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'cta_button_text!' => '',
                ],
            ]
        );

        $widget->add_control(
            'cta_button_icon',
            [
                'label' => esc_html__('Button Icon', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-right',
                    'library' => 'fa-solid',
                ],
                'condition' => [
                    'cta_button_text!' => '',
                ],
            ]
        );

        $widget->end_controls_section();

        // Right Side Content Type
        $widget->start_controls_section(
            'section_right_side_content_type',
            [
                'label' => esc_html__('Right Side Content Type', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Content Type Selector
        $widget->add_control(
            'right_side_content_type',
            [
                'label' => esc_html__('Content Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'employee_info',
                'options' => [
                    'none' => esc_html__('None (Hide Right Side Content)', 'promen-elementor-widgets'),
                    'employee_info' => esc_html__('Employee Information', 'promen-elementor-widgets'),
                    'gravity_form' => esc_html__('Gravity Form', 'promen-elementor-widgets'),
                    'custom_form' => esc_html__('Custom Form', 'promen-elementor-widgets'),
                    'combined_layout' => esc_html__('Combined Layout (Employee + Form)', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->end_controls_section();

        // Employee Info Section
        $widget->start_controls_section(
            'section_employee',
            [
                'label' => esc_html__('Employee Information', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'right_side_content_type' => ['employee_info', 'combined_layout'],
                ],
            ]
        );

        // Layout Position
        $widget->add_control(
            'employee_info_position',
            [
                'label' => esc_html__('Employee Info Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => esc_html__('Right', 'promen-elementor-widgets'),
                    'left' => esc_html__('Left', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'employee-position-',
            ]
        );

        // Employee Image
        $widget->add_control(
            'employee_image',
            [
                'label' => esc_html__('Employee Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Employee Name
        $widget->add_control(
            'employee_name',
            [
                'label' => esc_html__('Employee Name', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('<naam medewerker>', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter employee name', 'promen-elementor-widgets'),
            ]
        );

        // Heading for Contact Info
        $widget->add_control(
            'contact_heading',
            [
                'label' => esc_html__('Contact Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Wil je meer weten?', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter contact heading', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'contact_heading_tag',
            [
                'label' => esc_html__('Contact Heading HTML Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
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
                'default' => 'h3',
            ]
        );

        // Contact Items Repeater
        $contact_items_repeater = new \Elementor\Repeater();

        $contact_items_repeater->add_control(
            'contact_type',
            [
                'label' => esc_html__('Contact Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'email',
                'options' => [
                    'email' => esc_html__('Email', 'promen-elementor-widgets'),
                    'phone' => esc_html__('Phone', 'promen-elementor-widgets'),
                ],
            ]
        );

        $contact_items_repeater->add_control(
            'contact_value',
            [
                'label' => esc_html__('Contact Value', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__('Enter email or phone number', 'promen-elementor-widgets'),
                'label_block' => true,
            ]
        );

        $widget->add_control(
            'contact_items',
            [
                'label' => esc_html__('Contact Items', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $contact_items_repeater->get_controls(),
                'default' => [
                    [
                        'contact_type' => 'email',
                        'contact_value' => 'info@promen.nl',
                    ],
                    [
                        'contact_type' => 'phone',
                        'contact_value' => '088 - 98 98 000',
                    ],
                ],
                'title_field' => '{{{ contact_type }}}: {{{ contact_value }}}',
            ]
        );

        $widget->end_controls_section();

        // Gravity Form Section
        $widget->start_controls_section(
            'section_gravity_form',
            [
                'label' => esc_html__('Gravity Form', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'right_side_content_type' => ['gravity_form', 'combined_layout'],
                ],
            ]
        );

        // Form Position
        $widget->add_control(
            'form_position',
            [
                'label' => esc_html__('Form Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => esc_html__('Right', 'promen-elementor-widgets'),
                    'left' => esc_html__('Left', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'form-position-',
                'condition' => [
                    'right_side_content_type' => 'gravity_form',
                ],
            ]
        );

        // Gravity Form Shortcode
        $widget->add_control(
            'gravity_form_shortcode',
            [
                'label' => esc_html__('Gravity Form Shortcode', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
                'placeholder' => esc_html__('Enter Gravity Form shortcode. Example: [gravityform id="1" title="false" description="false"]', 'promen-elementor-widgets'),
                'description' => esc_html__('Enter the Gravity Form shortcode. You can create forms in the Gravity Forms menu.', 'promen-elementor-widgets'),
            ]
        );

        $widget->end_controls_section();

        // Combined Layout Section
        $widget->start_controls_section(
            'section_combined_layout',
            [
                'label' => esc_html__('Combined Layout Settings', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'right_side_content_type' => 'combined_layout',
                ],
            ]
        );

        // Layout Configuration
        $widget->add_control(
            'combined_layout_info',
            [
                'label' => esc_html__('Layout Information', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => esc_html__('This layout shows employee information on the left and a Gravity Form on the right. Configure both sections below.', 'promen-elementor-widgets'),
                'content_classes' => 'elementor-descriptor',
            ]
        );

        // Combined Layout Width Ratio
        $widget->add_control(
            'combined_layout_ratio',
            [
                'label' => esc_html__('Content Ratio', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '50_50',
                'options' => [
                    '40_60' => esc_html__('40% Employee / 60% Form', 'promen-elementor-widgets'),
                    '50_50' => esc_html__('50% Employee / 50% Form', 'promen-elementor-widgets'),
                    '60_40' => esc_html__('60% Employee / 40% Form', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->end_controls_section();

        // Custom Form Section
        $widget->start_controls_section(
            'section_custom_form',
            [
                'label' => esc_html__('Custom Form', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'right_side_content_type' => 'custom_form',
                ],
            ]
        );

        // Form Position
        $widget->add_control(
            'custom_form_position',
            [
                'label' => esc_html__('Form Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => esc_html__('Right', 'promen-elementor-widgets'),
                    'left' => esc_html__('Left', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'form-position-',
            ]
        );

        // Form Fields
        $widget->add_control(
            'form_fields_heading',
            [
                'label' => esc_html__('Form Fields', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Name Field Label
        $widget->add_control(
            'name_field_label',
            [
                'label' => esc_html__('Name Field Label', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Volledige naam', 'promen-elementor-widgets'),
            ]
        );

        // Phone Field Label
        $widget->add_control(
            'phone_field_label',
            [
                'label' => esc_html__('Phone Field Label', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Telefoonnummer', 'promen-elementor-widgets'),
            ]
        );

        // Email Field Label
        $widget->add_control(
            'email_field_label',
            [
                'label' => esc_html__('Email Field Label', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('E-mailadres', 'promen-elementor-widgets'),
            ]
        );

        // CV Field Label
        $widget->add_control(
            'cv_field_label',
            [
                'label' => esc_html__('CV Field Label', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('CV', 'promen-elementor-widgets'),
            ]
        );

        // CV Upload Button Text
        $widget->add_control(
            'cv_upload_text',
            [
                'label' => esc_html__('CV Upload Button Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Bestand kiezen', 'promen-elementor-widgets'),
            ]
        );

        // CV No File Text
        $widget->add_control(
            'cv_no_file_text',
            [
                'label' => esc_html__('CV No File Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Geen bestand gekozen', 'promen-elementor-widgets'),
            ]
        );

        // Motivation Field Label
        $widget->add_control(
            'motivation_field_label',
            [
                'label' => esc_html__('Motivation Field Label', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Motivatie', 'promen-elementor-widgets'),
            ]
        );

        // Motivation Upload Button Text
        $widget->add_control(
            'motivation_upload_text',
            [
                'label' => esc_html__('Motivation Upload Button Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Bestand kiezen', 'promen-elementor-widgets'),
            ]
        );

        // Motivation No File Text
        $widget->add_control(
            'motivation_no_file_text',
            [
                'label' => esc_html__('Motivation No File Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Geen bestand gekozen', 'promen-elementor-widgets'),
            ]
        );

        // Submit Button Text
        $widget->add_control(
            'submit_button_text',
            [
                'label' => esc_html__('Submit Button Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Versturen', 'promen-elementor-widgets'),
            ]
        );

        // Form Action
        $widget->add_control(
            'form_action',
            [
                'label' => esc_html__('Form Action URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__('https://your-form-handler.com', 'promen-elementor-widgets'),
            ]
        );

        $widget->end_controls_section();
    }
}
 