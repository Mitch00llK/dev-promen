<?php
/**
 * Image Text Block Widget Content Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Image_Text_Block_Content_Controls {

    /**
     * Register content controls for the widget
     */
    public static function register_controls($widget) {
        self::register_display_mode_section($widget);
        self::register_content_section($widget);
        self::register_tab_settings_section($widget);
    }

    /**
     * Register display mode section controls
     */
    private static function register_display_mode_section($widget) {
        $widget->start_controls_section(
            'section_display_mode',
            [
                'label' => esc_html__('Display Mode', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'display_mode',
            [
                'label' => esc_html__('Display Mode', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'normal',
                'options' => [
                    'normal' => esc_html__('Normal', 'promen-elementor-widgets'),
                    'tabs' => esc_html__('Tabs', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'image-left',
                'options' => [
                    'image-left' => esc_html__('Image Left', 'promen-elementor-widgets'),
                    'image-right' => esc_html__('Image Right', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );
        
        $widget->add_control(
            'responsive_heading',
            [
                'label' => esc_html__('Responsive Options', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );
        
        $widget->add_control(
            'stack_on_tablet',
            [
                'label' => esc_html__('Stack on Tablet', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Stack image and content vertically on tablet devices', 'promen-elementor-widgets'),
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );
        
        $widget->add_control(
            'stack_on_mobile',
            [
                'label' => esc_html__('Stack on Mobile', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Stack image and content vertically on mobile devices', 'promen-elementor-widgets'),
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );
        
        $widget->add_control(
            'element_order_heading',
            [
                'label' => esc_html__('Element Order', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );
        
        $widget->add_control(
            'tablet_image_order',
            [
                'label' => esc_html__('Tablet Image Order', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'first' => esc_html__('First', 'promen-elementor-widgets'),
                    'last' => esc_html__('Last', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'display_mode' => 'normal',
                    'stack_on_tablet' => 'yes',
                ],
            ]
        );
        
        $widget->add_control(
            'mobile_image_order',
            [
                'label' => esc_html__('Mobile Image Order', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'first' => esc_html__('First', 'promen-elementor-widgets'),
                    'last' => esc_html__('Last', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'display_mode' => 'normal',
                    'stack_on_mobile' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register content section controls
     */
    private static function register_content_section($widget) {
        $widget->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'display_mode' => 'normal',
                ],
            ]
        );

        $widget->add_control(
            'image',
            [
                'label' => esc_html__('Choose Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Use the standardized split title controls
        promen_add_split_title_controls(
            $widget, 
            'section_content', 
            [], 
            esc_html__('Wil jij ook iets betekenen in het leven van de ander?', 'promen-elementor-widgets')
        );

        $widget->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Lorem ipsum dolor sit amet consectetur. Malesuada nulla lobortis quis orci bibendum faucibus tempor nisl. In ullamcorper nec etiam feugiat eu interdum nisl vulputate. Accumsan tempor ornare odio tortor accumsan. Molestie eget enim commodo vulputate mattis gravida condimentum sit.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter description', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'button_text',
            [
                'label' => esc_html__('Button Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Werken bij Promen', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter button text', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'button_url',
            [
                'label' => esc_html__('Button URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $widget->add_control(
            'show_button',
            [
                'label' => esc_html__('Show Button', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Toggle button visibility', 'promen-elementor-widgets'),
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register tab settings section controls
     */
    private static function register_tab_settings_section($widget) {
        $widget->start_controls_section(
            'section_tab_settings',
            [
                'label' => esc_html__('Tab Settings', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'display_mode' => 'tabs',
                ],
            ]
        );

        $widget->add_control(
            'tab_responsive_heading',
            [
                'label' => esc_html__('Responsive Options', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $widget->add_control(
            'tab_stack_on_tablet',
            [
                'label' => esc_html__('Stack on Tablet', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Stack image and content vertically on tablet devices', 'promen-elementor-widgets'),
            ]
        );
        
        $widget->add_control(
            'tab_stack_on_mobile',
            [
                'label' => esc_html__('Stack on Mobile', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Stack image and content vertically on mobile devices', 'promen-elementor-widgets'),
            ]
        );
        
        $widget->add_control(
            'tab_element_order_heading',
            [
                'label' => esc_html__('Element Order', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        
        $widget->add_control(
            'tab_tablet_image_order',
            [
                'label' => esc_html__('Tablet Image Order', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'first' => esc_html__('First', 'promen-elementor-widgets'),
                    'last' => esc_html__('Last', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'tab_stack_on_tablet' => 'yes',
                ],
            ]
        );
        
        $widget->add_control(
            'tab_mobile_image_order',
            [
                'label' => esc_html__('Mobile Image Order', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'first' => esc_html__('First', 'promen-elementor-widgets'),
                    'last' => esc_html__('Last', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'tab_stack_on_mobile' => 'yes',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label' => esc_html__('Tab Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Tab Title', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter tab title', 'promen-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'tab_image',
            [
                'label' => esc_html__('Tab Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        // Add tab title controls
        $repeater->add_control(
            'tab_title_text',
            [
                'label' => esc_html__('Tab Content Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Content Title', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter content title', 'promen-elementor-widgets'),
                'condition' => [
                    'tab_split_title!' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'tab_split_title',
            [
                'label' => esc_html__('Use Split Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        
        $repeater->add_control(
            'tab_title_part_1',
            [
                'label' => esc_html__('Title Part 1', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('First part of', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter first part of title', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'tab_split_title' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'tab_title_part_2',
            [
                'label' => esc_html__('Title Part 2', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('your split title', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter second part of title', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'tab_split_title' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'tab_description',
            [
                'label' => esc_html__('Tab Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('Tab content description goes here.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter tab description', 'promen-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'tab_button_text',
            [
                'label' => esc_html__('Tab Button Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Learn More', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter button text', 'promen-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'tab_button_url',
            [
                'label' => esc_html__('Tab Button URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
            ]
        );

        $widget->add_control(
            'tabs',
            [
                'label' => esc_html__('Tabs', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'tab_title' => esc_html__('Tab #1', 'promen-elementor-widgets'),
                        'tab_title_text' => esc_html__('First Tab Content', 'promen-elementor-widgets'),
                        'tab_description' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'promen-elementor-widgets'),
                    ],
                    [
                        'tab_title' => esc_html__('Tab #2', 'promen-elementor-widgets'),
                        'tab_title_text' => esc_html__('Second Tab Content', 'promen-elementor-widgets'),
                        'tab_description' => esc_html__('Ut enim ad minim veniam, quis nostrud exercitation ullamco.', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $widget->end_controls_section();
    }
} 