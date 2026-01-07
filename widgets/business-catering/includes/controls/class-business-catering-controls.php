<?php
/**
 * Business Catering Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Business Catering Widget Controls Class
 */
class Promen_Business_Catering_Controls {

    /**
     * Register Business Catering Widget Controls
     */
    public static function register($widget) {
        // Content Section
        $widget->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Use the standardized split title controls
        promen_add_split_title_controls(
            $widget, 
            'section_content', 
            ['show_title' => 'yes'], 
            esc_html__('Impressie van onze bedrijfscatering', 'promen-elementor-widgets'),
            'section_title'
        );

        // Catering Images
        $widget->add_control(
            'catering_images',
            [
                'label' => esc_html__('Catering Images', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'image',
                        'label' => esc_html__('Image', 'promen-elementor-widgets'),
                        'type' => \Elementor\Controls_Manager::MEDIA,
                        'default' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                    ],
                    [
                        'name' => 'title',
                        'label' => esc_html__('Title', 'promen-elementor-widgets'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__('Image Title', 'promen-elementor-widgets'),
                        'placeholder' => esc_html__('Enter image title', 'promen-elementor-widgets'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'description',
                        'label' => esc_html__('Description', 'promen-elementor-widgets'),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => esc_html__('Image description goes here', 'promen-elementor-widgets'),
                        'placeholder' => esc_html__('Enter image description', 'promen-elementor-widgets'),
                        'rows' => 5,
                        'label_block' => true,
                    ],
                    [
                        'name' => 'show_overlay',
                        'label' => esc_html__('Show Overlay', 'promen-elementor-widgets'),
                        'type' => \Elementor\Controls_Manager::SWITCHER,
                        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                        'return_value' => 'yes',
                        'default' => 'no',
                    ],
                ],
                'default' => [
                    [
                        'image' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'title' => esc_html__('Catering Image 1', 'promen-elementor-widgets'),
                        'description' => esc_html__('Description for catering image 1', 'promen-elementor-widgets'),
                        'show_overlay' => 'no',
                    ],
                    [
                        'image' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'title' => esc_html__('Catering Image 2', 'promen-elementor-widgets'),
                        'description' => esc_html__('Description for catering image 2', 'promen-elementor-widgets'),
                        'show_overlay' => 'no',
                    ],
                    [
                        'image' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'title' => esc_html__('Catering Image 3', 'promen-elementor-widgets'),
                        'description' => esc_html__('Description for catering image 3', 'promen-elementor-widgets'),
                        'show_overlay' => 'no',
                    ],
                ],
                'title_field' => '{{{ title }}}',
            ]
        );

        // Layout Settings
        $widget->add_control(
            'layout_heading',
            [
                'label' => esc_html__('Layout Settings', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Columns Desktop
        $widget->add_control(
            'columns_desktop',
            [
                'label' => esc_html__('Columns (Desktop)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                ],
            ]
        );

        // Columns Tablet
        $widget->add_control(
            'columns_tablet',
            [
                'label' => esc_html__('Columns (Tablet)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],
            ]
        );

        // Columns Mobile
        $widget->add_control(
            'columns_mobile',
            [
                'label' => esc_html__('Columns (Mobile)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                ],
            ]
        );

        // Image Size
        $widget->add_control(
            'image_size',
            [
                'label' => esc_html__('Image Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'large',
                'options' => [
                    'thumbnail' => esc_html__('Thumbnail', 'promen-elementor-widgets'),
                    'medium' => esc_html__('Medium', 'promen-elementor-widgets'),
                    'large' => esc_html__('Large', 'promen-elementor-widgets'),
                    'full' => esc_html__('Full', 'promen-elementor-widgets'),
                ],
            ]
        );

        // Image Height
        $widget->add_control(
            'image_height',
            [
                'label' => esc_html__('Image Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
                ],
            ]
        );

        // Custom Image Height
        $widget->add_responsive_control(
            'custom_image_height',
            [
                'label' => esc_html__('Custom Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%'],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                        'step' => 10,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-catering-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ],
                'condition' => [
                    'image_height' => 'custom',
                ],
            ]
        );

        $widget->end_controls_section();

        // Slider Section
        $widget->start_controls_section(
            'section_slider',
            [
                'label' => esc_html__('Slider Settings', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'slider_info',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => esc_html__('The slider will automatically activate when more than 3 images are added.', 'promen-elementor-widgets'),
                'content_classes' => 'elementor-descriptor',
            ]
        );

        $widget->add_control(
            'slider_template',
            [
                'label' => esc_html__('Slider Template', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'promen-elementor-widgets'),
                    'fade' => esc_html__('Fade', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->add_control(
            'slider_navigation',
            [
                'label' => esc_html__('Show Navigation Arrows', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'slider_pagination',
            [
                'label' => esc_html__('Show Pagination Dots', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'slider_loop',
            [
                'label' => esc_html__('Enable Loop', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'slider_autoplay',
            [
                'label' => esc_html__('Enable Autoplay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'slider_autoplay_delay',
            [
                'label' => esc_html__('Autoplay Delay (ms)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1000,
                'max' => 10000,
                'step' => 500,
                'default' => 5000,
                'condition' => [
                    'slider_autoplay' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'slider_speed',
            [
                'label' => esc_html__('Transition Speed (ms)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 100,
                'max' => 3000,
                'step' => 100,
                'default' => 500,
            ]
        );

        $widget->add_control(
            'slider_effect',
            [
                'label' => esc_html__('Transition Effect', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => esc_html__('Slide', 'promen-elementor-widgets'),
                    'fade' => esc_html__('Fade', 'promen-elementor-widgets'),
                    'cube' => esc_html__('Cube', 'promen-elementor-widgets'),
                    'coverflow' => esc_html__('Coverflow', 'promen-elementor-widgets'),
                    'flip' => esc_html__('Flip', 'promen-elementor-widgets'),
                ],
            ]
        );

        $widget->add_control(
            'slides_per_view',
            [
                'label' => esc_html__('Slides Per View', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    'auto' => esc_html__('Auto', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'slider_effect' => 'slide',
                ],
            ]
        );

        $widget->add_control(
            'space_between',
            [
                'label' => esc_html__('Space Between Slides', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 30,
                ],
                'condition' => [
                    'slider_effect' => 'slide',
                ],
            ]
        );

        $widget->add_control(
            'centered_slides',
            [
                'label' => esc_html__('Center Slides', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'slider_effect' => 'slide',
                ],
            ]
        );

        $widget->add_control(
            'gradient_overlay',
            [
                'label' => esc_html__('Enable Gradient Overlay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Adds gradient overlays on the left and right sides of the slider', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'gradient_color_start',
            [
                'label' => esc_html__('Gradient Start Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#ffffff',
                'condition' => [
                    'gradient_overlay' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'gradient_opacity',
            [
                'label' => esc_html__('Gradient Opacity', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 5,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 90,
                ],
                'condition' => [
                    'gradient_overlay' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'gradient_width',
            [
                'label' => esc_html__('Gradient Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 15,
                ],
                'condition' => [
                    'gradient_overlay' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();

        // Visibility Section
        $widget->start_controls_section(
            'section_visibility',
            [
                'label' => esc_html__('Visibility', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'show_image_title',
            [
                'label' => esc_html__('Show Image Titles', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $widget->add_control(
            'show_image_description',
            [
                'label' => esc_html__('Show Image Descriptions', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $widget->add_control(
            'show_overlay_on_hover',
            [
                'label' => esc_html__('Show Overlay on Hover', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'show_image_title' => 'yes',
                    'show_image_description' => 'yes',
                ],
            ]
        );

        // Responsive Visibility
        $widget->add_control(
            'responsive_visibility_heading',
            [
                'label' => esc_html__('Responsive Visibility', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'hide_on_desktop',
            [
                'label' => esc_html__('Hide On Desktop', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'prefix_class' => 'elementor-',
                'selectors' => [
                    '(desktop){{WRAPPER}}' => 'display: none',
                ],
            ]
        );

        $widget->add_control(
            'hide_on_tablet',
            [
                'label' => esc_html__('Hide On Tablet', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'prefix_class' => 'elementor-',
                'selectors' => [
                    '(tablet){{WRAPPER}}' => 'display: none',
                ],
            ]
        );

        $widget->add_control(
            'hide_on_mobile',
            [
                'label' => esc_html__('Hide On Mobile', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'prefix_class' => 'elementor-',
                'selectors' => [
                    '(mobile){{WRAPPER}}' => 'display: none',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Tab - Title
        promen_add_split_title_style_controls(
            $widget, 
            'section_title_style', 
            ['show_title' => 'yes'], 
            'promen-catering',
            'section_title'
        );

        // Images Style Section
        $widget->start_controls_section(
            'section_images_style',
            [
                'label' => esc_html__('Images Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
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

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .promen-catering-image',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .promen-catering-image',
            ]
        );

        $widget->add_responsive_control(
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

        $widget->add_responsive_control(
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

        $widget->add_control(
            'image_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .promen-catering-image' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'image_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $widget->end_controls_section();

        // Overlay Style Section
        $widget->start_controls_section(
            'section_overlay_style',
            [
                'label' => esc_html__('Overlay Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'overlay_title_typography',
                'selector' => '{{WRAPPER}} .promen-catering-overlay-title',
            ]
        );

        $widget->add_control(
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

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'overlay_description_typography',
                'selector' => '{{WRAPPER}} .promen-catering-overlay-description',
            ]
        );

        $widget->add_responsive_control(
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

        $widget->add_responsive_control(
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

        $widget->end_controls_section();

        // Slider Navigation Style Section
        $widget->start_controls_section(
            'section_slider_navigation_style',
            [
                'label' => esc_html__('Slider Navigation Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'arrow_border',
                'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
            ]
        );

        $widget->add_control(
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

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrow_box_shadow',
                'selector' => '{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev',
            ]
        );

        $widget->add_control(
            'pagination_heading',
            [
                'label' => esc_html__('Pagination', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_control(
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

        $widget->add_responsive_control(
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

        $widget->end_controls_section();
    }
}
