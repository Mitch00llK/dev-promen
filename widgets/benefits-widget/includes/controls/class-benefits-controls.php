<?php
/**
 * Benefits Widget Controls
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Benefits Widget Controls Class
 */
class Promen_Benefits_Controls {

    /**
     * Register Benefits Widget Controls
     */
    public static function register($widget) {
        // Header Section
        $widget->start_controls_section(
            'section_header',
            [
                'label' => esc_html__('Header', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_header',
            [
                'label' => esc_html__('Show Header', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Use the standardized split title controls
        promen_add_split_title_controls(
            $widget, 
            'section_header', 
            ['show_header' => 'yes'], 
            esc_html__('Benefits of Business Catering', 'promen-elementor-widgets')
        );

        $widget->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Discover how our business catering services can benefit your organization', 'promen-elementor-widgets'),
                'label_block' => true,
            ]
        );

        $widget->end_controls_section();

        // Benefits Section
        $widget->start_controls_section(
            'section_benefits',
            [
                'label' => esc_html__('Benefits', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'benefits_list',
            [
                'label' => esc_html__('Benefits List', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => [
                    [
                        'name' => 'benefit_title',
                        'label' => esc_html__('Benefit Title', 'promen-elementor-widgets'),
                        'type' => \Elementor\Controls_Manager::TEXT,
                        'default' => esc_html__('Benefit Title', 'promen-elementor-widgets'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'benefit_description',
                        'label' => esc_html__('Benefit Description', 'promen-elementor-widgets'),
                        'type' => \Elementor\Controls_Manager::TEXTAREA,
                        'default' => esc_html__('Benefit description goes here', 'promen-elementor-widgets'),
                        'label_block' => true,
                    ],
                    [
                        'name' => 'benefit_icon',
                        'label' => esc_html__('Icon', 'promen-elementor-widgets'),
                        'type' => \Elementor\Controls_Manager::ICONS,
                        'default' => [
                            'value' => 'fas fa-check',
                            'library' => 'fa-solid',
                        ],
                    ],
                ],
                'default' => [
                    [
                        'benefit_title' => esc_html__('Time Saving', 'promen-elementor-widgets'),
                        'benefit_description' => esc_html__('Save valuable time with our efficient catering service', 'promen-elementor-widgets'),
                    ],
                    [
                        'benefit_title' => esc_html__('Professional Service', 'promen-elementor-widgets'),
                        'benefit_description' => esc_html__('Expert staff ensuring smooth service delivery', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ benefit_title }}}',
            ]
        );

        $widget->end_controls_section();

        // Image Section
        $widget->start_controls_section(
            'section_image',
            [
                'label' => esc_html__('Media', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'media_type',
            [
                'label' => esc_html__('Media Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'image',
                'options' => [
                    'image' => esc_html__('Image', 'promen-elementor-widgets'),
                    'video' => esc_html__('Video', 'promen-elementor-widgets'),
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
                'condition' => [
                    'media_type' => 'image',
                ],
            ]
        );

        $widget->add_control(
            'video_source',
            [
                'label' => esc_html__('Video Source', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'upload',
                'options' => [
                    'upload' => esc_html__('Upload Video', 'promen-elementor-widgets'),
                    'external' => esc_html__('External URL', 'promen-elementor-widgets'),
                    'embedded' => esc_html__('Embedded Video (YouTube/Vimeo)', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $widget->add_control(
            'video_upload',
            [
                'label' => esc_html__('Choose Video', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_types' => ['video'],
                'condition' => [
                    'media_type' => 'video',
                    'video_source' => 'upload',
                ],
            ]
        );

        $widget->add_control(
            'video_url',
            [
                'label' => esc_html__('Video URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://example.com/video.mp4', 'promen-elementor-widgets'),
                'options' => ['url', 'is_external', 'nofollow'],
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
                'description' => esc_html__('Enter a direct link to an MP4 video file. For YouTube or Vimeo, use the Embedded Video option instead.', 'promen-elementor-widgets'),
                'condition' => [
                    'media_type' => 'video',
                    'video_source' => 'external',
                ],
            ]
        );

        $widget->add_control(
            'embedded_video_url',
            [
                'label' => esc_html__('Embedded Video URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('https://www.youtube.com/watch?v=VIDEO_ID or https://vimeo.com/VIDEO_ID', 'promen-elementor-widgets'),
                'description' => esc_html__('Enter a YouTube or Vimeo URL to embed the video.', 'promen-elementor-widgets'),
                'condition' => [
                    'media_type' => 'video',
                    'video_source' => 'embedded',
                ],
            ]
        );

        $widget->add_control(
            'embedded_video_ratio',
            [
                'label' => esc_html__('Aspect Ratio', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '16:9',
                'options' => [
                    '16:9' => '16:9',
                    '4:3' => '4:3',
                    '3:2' => '3:2',
                    '1:1' => '1:1',
                ],
                'condition' => [
                    'media_type' => 'video',
                    'video_source' => 'embedded',
                ],
            ]
        );

        $widget->add_control(
            'video_autoplay',
            [
                'label' => esc_html__('Autoplay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $widget->add_control(
            'video_loop',
            [
                'label' => esc_html__('Loop', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $widget->add_control(
            'video_controls',
            [
                'label' => esc_html__('Controls', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $widget->add_control(
            'video_mute',
            [
                'label' => esc_html__('Mute', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Tab - Header
        $widget->start_controls_section(
            'section_style_header',
            [
                'label' => esc_html__('Header Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $widget->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefits-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_header' => 'yes',
                    'use_split_heading!' => 'yes',
                ],
            ]
        );

        // Split Heading Colors
        $widget->add_control(
            'title_part_1_color',
            [
                'label' => esc_html__('Title Part 1 Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefits-title .title-part-1' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_header' => 'yes',
                    'use_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'title_part_2_color',
            [
                'label' => esc_html__('Title Part 2 Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefits-title .title-part-2' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_header' => 'yes',
                    'use_split_heading' => 'yes',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .benefits-title',
            ]
        );

        $widget->add_control(
            'description_color',
            [
                'label' => esc_html__('Description Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefits-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'selector' => '{{WRAPPER}} .benefits-description',
            ]
        );

        $widget->end_controls_section();

        // Style Tab - Benefits
        $widget->start_controls_section(
            'section_style_benefits',
            [
                'label' => esc_html__('Benefits Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Benefits Alignment
        $widget->add_responsive_control(
            'benefits_alignment',
            [
                'label' => esc_html__('Benefits Alignment', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .benefit-item' => 'text-align: {{VALUE}}; align-items: {{VALUE}};',
                ],
            ]
        );

        // Grid Layout Controls
        $widget->add_responsive_control(
            'benefits_columns',
            [
                'label' => esc_html__('Grid Columns', 'promen-elementor-widgets'),
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
                    '{{WRAPPER}} .benefits-container' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'benefits_gap',
            [
                'label' => esc_html__('Grid Gap', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
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
                ],
                'default' => [
                    'size' => 2,
                    'unit' => 'rem',
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-container' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Benefit Item Box Shadow
        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'benefit_item_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .benefit-item',
            ]
        );

        // Benefit Item Hover Box Shadow
        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'benefit_item_hover_box_shadow',
                'label' => esc_html__('Hover Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .benefit-item:hover',
            ]
        );

        $widget->add_control(
            'benefit_title_color',
            [
                'label' => esc_html__('Benefit Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefit-title' => 'color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        // Icon Style Controls
        $widget->add_control(
            'icon_style_heading',
            [
                'label' => esc_html__('Icon Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        // Icon Position
        $widget->add_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'top',
                'options' => [
                    'top' => esc_html__('Top', 'promen-elementor-widgets'),
                    'left' => esc_html__('Left', 'promen-elementor-widgets'),
                    'right' => esc_html__('Right', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'benefit-icon-position-',
            ]
        );

        $widget->add_responsive_control(
            'icon_horizontal_alignment',
            [
                'label' => esc_html__('Horizontal Alignment', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'promen-elementor-widgets'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'promen-elementor-widgets'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'promen-elementor-widgets'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .benefit-icon' => 'align-self: {{VALUE}};',
                ],
                'condition' => [
                    'icon_position' => 'top',
                ],
            ]
        );

        $widget->add_responsive_control(
            'icon_vertical_alignment',
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
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}}.benefit-icon-position-left .benefit-item, {{WRAPPER}}.benefit-icon-position-right .benefit-item' => 'align-items: {{VALUE}};',
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'icon_position',
                            'operator' => '==',
                            'value' => 'left',
                        ],
                        [
                            'name' => 'icon_position',
                            'operator' => '==',
                            'value' => 'right',
                        ],
                    ],
                ],
            ]
        );

        $widget->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'promen-elementor-widgets'),
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
                    'size' => 2,
                    'unit' => 'rem',
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefit-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .benefit-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'icon_container_size',
            [
                'label' => esc_html__('Container Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 2,
                        'max' => 20,
                    ],
                    'rem' => [
                        'min' => 2,
                        'max' => 20,
                    ],
                ],
                'default' => [
                    'size' => 4,
                    'unit' => 'rem',
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefit-icon' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
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
                ],
                'default' => [
                    'size' => 1,
                    'unit' => 'rem',
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefit-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        // Icon Colors
        $widget->start_controls_tabs('icon_style_tabs');

        // Normal State
        $widget->start_controls_tab(
            'icon_style_normal',
            [
                'label' => esc_html__('Normal', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefit-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .benefit-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefit-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->end_controls_tab();

        // Hover State
        $widget->start_controls_tab(
            'icon_style_hover',
            [
                'label' => esc_html__('Hover', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__('Icon Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefit-item:hover .benefit-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .benefit-item:hover .benefit-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'icon_hover_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefit-item:hover .benefit-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $widget->add_control(
            'icon_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefit-item:hover .benefit-icon' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'icon_border_border!' => '',
                ],
            ]
        );

        $widget->add_control(
            'icon_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
            ]
        );

        $widget->end_controls_tab();

        $widget->end_controls_tabs();

        // Icon Border
        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'icon_border',
                'selector' => '{{WRAPPER}} .benefit-icon',
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'icon_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'top' => '50',
                    'right' => '50',
                    'bottom' => '50',
                    'left' => '50',
                    'unit' => '%',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefit-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        // Icon Box Shadow
        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'icon_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .benefit-icon',
            ]
        );

        $widget->end_controls_section();

        // Style Tab - Image
        $widget->start_controls_section(
            'section_style_image',
            [
                'label' => esc_html__('Image Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'media_type' => 'image',
                ],
            ]
        );

        $widget->add_control(
            'image_position',
            [
                'label' => esc_html__('Image Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__('Left', 'promen-elementor-widgets'),
                    'right' => esc_html__('Right', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'benefits-image-position-',
            ]
        );

        $widget->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-image' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh', '%', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'image_max_height',
            [
                'label' => esc_html__('Max Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-img' => 'max-height: {{SIZE}}{{UNIT}}; object-fit: cover;',
                ],
            ]
        );

        $widget->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .benefits-image' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'image_border',
                'selector' => '{{WRAPPER}} .benefits-img',
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'selectors' => [
                    '{{WRAPPER}} .benefits-img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .benefits-img',
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Css_Filter::get_type(),
            [
                'name' => 'image_css_filters',
                'selector' => '{{WRAPPER}} .benefits-img',
            ]
        );

        $widget->add_control(
            'image_opacity',
            [
                'label' => esc_html__('Opacity', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-img' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $widget->add_control(
            'image_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefits-image' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        // Hover Controls
        $widget->add_control(
            'image_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'image_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-img' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Tab - Video
        $widget->start_controls_section(
            'section_style_video',
            [
                'label' => esc_html__('Video Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'media_type' => 'video',
                ],
            ]
        );

        $widget->add_control(
            'video_position',
            [
                'label' => esc_html__('Video Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'left' => esc_html__('Left', 'promen-elementor-widgets'),
                    'right' => esc_html__('Right', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'benefits-video-position-',
            ]
        );

        $widget->add_control(
            'video_alignment_heading',
            [
                'label' => esc_html__('Video Alignment', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'video_horizontal_align',
            [
                'label' => esc_html__('Horizontal Alignment', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'promen-elementor-widgets'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'promen-elementor-widgets'),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'promen-elementor-widgets'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .benefits-media' => 'align-items: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'video_vertical_align',
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
                    'space-between' => [
                        'title' => esc_html__('Space Between', 'promen-elementor-widgets'),
                        'icon' => 'eicon-v-align-stretch',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .benefits-media' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'video_width',
            [
                'label' => esc_html__('Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-video' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .benefits-video-embed' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'video_max_width',
            [
                'label' => esc_html__('Max Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-video' => 'max-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .benefits-video-embed' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_responsive_control(
            'video_height',
            [
                'label' => esc_html__('Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-video' => 'height: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'video_source!' => 'embedded',
                ],
            ]
        );

        $widget->add_responsive_control(
            'video_padding',
            [
                'label' => esc_html__('Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .benefits-video' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .benefits-video-embed' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'video_border',
                'selector' => '{{WRAPPER}} .benefits-video, {{WRAPPER}} .benefits-video-embed',
                'separator' => 'before',
            ]
        );

        $widget->add_responsive_control(
            'video_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem'],
                'default' => [
                    'top' => '8',
                    'right' => '8',
                    'bottom' => '8',
                    'left' => '8',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-video' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .benefits-video-embed' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .benefits-video-embed iframe' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $widget->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'video_box_shadow',
                'selector' => '{{WRAPPER}} .benefits-video, {{WRAPPER}} .benefits-video-embed',
            ]
        );

        $widget->add_control(
            'video_background_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .benefits-media' => 'background-color: {{VALUE}};',
                ],
                'separator' => 'before',
            ]
        );

        // Video Overlay
        $widget->add_control(
            'video_overlay_heading',
            [
                'label' => esc_html__('Video Overlay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'video_source!' => 'embedded',
                ],
            ]
        );

        $widget->add_control(
            'video_overlay',
            [
                'label' => esc_html__('Enable Overlay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'video_source!' => 'embedded',
                ],
            ]
        );

        $widget->add_control(
            'video_overlay_color',
            [
                'label' => esc_html__('Overlay Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => 'rgba(0,0,0,0.5)',
                'selectors' => [
                    '{{WRAPPER}} .benefits-video-overlay' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'video_overlay' => 'yes',
                    'video_source!' => 'embedded',
                ],
            ]
        );

        // Hover Controls
        $widget->add_control(
            'video_hover_animation',
            [
                'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HOVER_ANIMATION,
                'separator' => 'before',
            ]
        );

        $widget->add_control(
            'video_hover_transition',
            [
                'label' => esc_html__('Transition Duration', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'default' => [
                    'size' => 0.3,
                ],
                'range' => [
                    'px' => [
                        'max' => 3,
                        'step' => 0.1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .benefits-video' => 'transition-duration: {{SIZE}}s',
                    '{{WRAPPER}} .benefits-video-embed' => 'transition-duration: {{SIZE}}s',
                ],
            ]
        );

        $widget->end_controls_section();

        // Style Tab - Title
        promen_add_split_title_style_controls(
            $widget, 
            'section_style_title', 
            ['show_header' => 'yes'], 
            'benefits'
        );
    }
}
