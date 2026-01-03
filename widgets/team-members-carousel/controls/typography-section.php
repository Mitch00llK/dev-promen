<?php
/**
 * Typography Section Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Team_Members_Carousel_Typography_Controls {
    protected function register_typography_controls() {
        $this->start_controls_section(
            'section_style_typography',
            [
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Title Typography (for non-split titles)
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'label' => esc_html__('Title Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .team-title',
                'condition' => [
                    'show_section_title' => 'yes',
                    'split_title!' => 'yes',
                ],
            ]
        );

        // Title Color (for non-split titles)
        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_section_title' => 'yes',
                    'split_title!' => 'yes',
                ],
            ]
        );

        // Split Title Part 1 Heading
        $this->add_control(
            'title_part_1_heading',
            [
                'label' => esc_html__('Title Part 1 Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_section_title' => 'yes',
                    'split_title' => 'yes',
                ],
            ]
        );

        // Title Part 1 Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_part_1_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .team-title-part-1',
                'condition' => [
                    'show_section_title' => 'yes',
                    'split_title' => 'yes',
                ],
            ]
        );

        // Title Part 1 Color
        $this->add_control(
            'title_part_1_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-title-part-1' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_section_title' => 'yes',
                    'split_title' => 'yes',
                ],
            ]
        );

        // Split Title Part 2 Heading
        $this->add_control(
            'title_part_2_heading',
            [
                'label' => esc_html__('Title Part 2 Style', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_section_title' => 'yes',
                    'split_title' => 'yes',
                ],
            ]
        );

        // Title Part 2 Typography
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'title_part_2_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .team-title-part-2',
                'condition' => [
                    'show_section_title' => 'yes',
                    'split_title' => 'yes',
                ],
            ]
        );

        // Title Part 2 Color
        $this->add_control(
            'title_part_2_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .team-title-part-2' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_section_title' => 'yes',
                    'split_title' => 'yes',
                ],
            ]
        );

        // Title Spacing
        $this->add_responsive_control(
            'title_spacing',
            [
                'label' => esc_html__('Title Bottom Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
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
                    '{{WRAPPER}} .team-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
                'condition' => [
                    'show_section_title' => 'yes',
                ],
            ]
        );

        // Title Alignment
        $this->add_responsive_control(
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
                    '{{WRAPPER}} .team-title' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'show_section_title' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'member_name_typography',
                'label' => esc_html__('Member Name Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .member-name',
                'condition' => [
                    'show_member_name' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'member_title_typography',
                'label' => esc_html__('Member Title Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .member-title',
                'condition' => [
                    'show_member_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'member_name_color',
            [
                'label' => esc_html__('Member Name Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#000000',
                'selectors' => [
                    '{{WRAPPER}} .member-name' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_member_name' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'member_title_color',
            [
                'label' => esc_html__('Member Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .member-title' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_member_title' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'linkedin_icon_color',
            [
                'label' => esc_html__('LinkedIn Icon Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0077B5',
                'selectors' => [
                    '{{WRAPPER}} .member-linkedin' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_linkedin' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'linkedin_icon_hover_color',
            [
                'label' => esc_html__('LinkedIn Icon Hover Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .member-linkedin:hover' => 'color: {{VALUE}};',
                ],
                'condition' => [
                    'show_linkedin' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'linkedin_background_hover_color',
            [
                'label' => esc_html__('LinkedIn Background Hover Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#0077B5',
                'selectors' => [
                    '{{WRAPPER}} .member-linkedin:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_linkedin' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();
    }
} 