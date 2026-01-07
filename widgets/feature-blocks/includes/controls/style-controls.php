<?php
namespace Promen\Widgets\FeatureBlocks\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promen_Feature_Blocks_Style_Controls {

	public static function register_controls( $widget ) {
		self::register_positioning_section( $widget );
		self::register_widget_title_style_section( $widget );
		self::register_main_image_style_section( $widget );
		self::register_feature_block_style_section( $widget );
		self::register_icon_style_section( $widget );
		self::register_title_style_section( $widget );
		self::register_content_style_section( $widget );
		self::register_button_style_section( $widget );
	}

	private static function register_positioning_section( $widget ) {
		$widget->start_controls_section(
			'section_positioning',
			[
				'label' => esc_html__( 'Positioning', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		for ( $i = 1; $i <= 4; $i++ ) {
			$widget->add_control(
				'block_' . $i . '_position_heading',
				[
					'label' => sprintf( esc_html__( 'Block %d Position', 'promen-elementor-widgets' ), $i ),
					'type' => Controls_Manager::HEADING,
					'separator' => 'before',
					'condition' => [
						'show_block_' . $i => 'yes',
					],
				]
			);

			$widget->add_responsive_control(
				'block_' . $i . '_position_top',
				[
					'label' => esc_html__( 'Top Position (%)', 'promen-elementor-widgets' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => self::get_default_top_position( $i ),
					],
					'selectors' => [
						'{{WRAPPER}} .feature-block-' . $i => 'top: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'show_block_' . $i => 'yes',
					],
				]
			);

			$widget->add_responsive_control(
				'block_' . $i . '_position_left',
				[
					'label' => esc_html__( 'Left Position (%)', 'promen-elementor-widgets' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ '%' ],
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
					'default' => [
						'unit' => '%',
						'size' => self::get_default_left_position( $i ),
					],
					'selectors' => [
						'{{WRAPPER}} .feature-block-' . $i => 'left: {{SIZE}}{{UNIT}};',
					],
					'condition' => [
						'show_block_' . $i => 'yes',
					],
				]
			);
		}

		$widget->end_controls_section();
	}

	private static function register_widget_title_style_section( $widget ) {
		$widget->start_controls_section(
			'section_widget_title_style',
			[
				'label' => esc_html__( 'Widget Title Style', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_widget_title' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_title_color',
			[
				'label' => esc_html__( 'Title Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .widget-title' => 'color: {{VALUE}}',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'widget_title_typography',
				'selector' => '{{WRAPPER}} .widget-title',
			]
		);

		$widget->add_responsive_control(
			'widget_title_margin',
			[
				'label' => esc_html__( 'Margin', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .widget-title-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '0',
					'right' => '0',
					'bottom' => '30',
					'left' => '0',
					'unit' => 'px',
					'isLinked' => false,
				],
			]
		);

		$widget->add_responsive_control(
			'widget_title_padding',
			[
				'label' => esc_html__( 'Padding', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .widget-title-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_section();
	}

	private static function register_main_image_style_section( $widget ) {
		$widget->start_controls_section(
			'section_main_image_style',
			[
				'label' => esc_html__( 'Main Image Style', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'main_image_border',
				'selector' => '{{WRAPPER}} .promen-feature-main-image img',
			]
		);

		$widget->add_responsive_control(
			'main_image_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .promen-feature-main-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'main_image_box_shadow',
				'selector' => '{{WRAPPER}} .promen-feature-main-image img',
			]
		);

		$widget->add_control(
			'overlay_heading',
			[
				'label' => esc_html__( 'Overlay Image Style', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->add_responsive_control(
			'overlay_image_width',
			[
				'label' => esc_html__( 'Width', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 500,
						'step' => 1,
					],
					'%' => [
						'min' => 1,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .overlay-image img' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_overlay_image' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'overlay_image_rotation',
			[
				'label' => esc_html__( 'Rotation (deg)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'deg' ],
				'range' => [
					'deg' => [
						'min' => -45,
						'max' => 45,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'deg',
					'size' => -5,
				],
				'selectors' => [
					'{{WRAPPER}} .overlay-image img' => 'transform: rotate({{SIZE}}deg);',
				],
				'condition' => [
					'show_overlay_image' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'overlay_image_position',
			[
				'label' => esc_html__( 'Position', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'center center' => esc_html__( 'Center Center', 'promen-elementor-widgets' ),
					'center left' => esc_html__( 'Center Left', 'promen-elementor-widgets' ),
					'center right' => esc_html__( 'Center Right', 'promen-elementor-widgets' ),
					'top center' => esc_html__( 'Top Center', 'promen-elementor-widgets' ),
					'top left' => esc_html__( 'Top Left', 'promen-elementor-widgets' ),
					'top right' => esc_html__( 'Top Right', 'promen-elementor-widgets' ),
					'bottom center' => esc_html__( 'Bottom Center', 'promen-elementor-widgets' ),
					'bottom left' => esc_html__( 'Bottom Left', 'promen-elementor-widgets' ),
					'bottom right' => esc_html__( 'Bottom Right', 'promen-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .overlay-image' => 'justify-content: {{VALUE}};',
				],
				'condition' => [
					'show_overlay_image' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'overlay_vertical_position',
			[
				'label' => esc_html__( 'Vertical Position', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
				'range' => [
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => '%',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .overlay-image' => 'bottom: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'show_overlay_image' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'overlay_image_shadow',
				'selector' => '{{WRAPPER}} .overlay-image img',
				'condition' => [
					'show_overlay_image' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'overlay_image_margin',
			[
				'label' => esc_html__( 'Margin', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .overlay-image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition' => [
					'show_overlay_image' => 'yes',
				],
			]
		);

		$widget->add_control(
			'overlay_background_color',
			[
				'label' => esc_html__( 'Overlay Background Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => 'rgba(0, 0, 0, 0.5)',
				'selectors' => [
					'{{WRAPPER}} .overlay-image' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'show_overlay_image' => 'yes',
				],
			]
		);

		$widget->end_controls_section();
	}

	private static function register_feature_block_style_section( $widget ) {
		$widget->start_controls_section(
			'section_feature_block_style',
			[
				'label' => esc_html__( 'Feature Block Style', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'block_background_color',
			[
				'label' => esc_html__( 'Block Background Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .promen-feature-block' => 'background-color: {{VALUE}}',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'block_border',
				'selector' => '{{WRAPPER}} .promen-feature-block',
			]
		);

		$widget->add_responsive_control(
			'block_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .promen-feature-block' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'block_box_shadow',
				'selector' => '{{WRAPPER}} .promen-feature-block',
			]
		);

		$widget->add_responsive_control(
			'block_padding',
			[
				'label' => esc_html__( 'Padding', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .promen-feature-block' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'default' => [
					'top' => '20',
					'right' => '20',
					'bottom' => '20',
					'left' => '20',
					'unit' => 'px',
					'isLinked' => true,
				],
			]
		);

		$widget->end_controls_section();
	}

	private static function register_icon_style_section( $widget ) {
		$widget->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon Style', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4054b2',
				'selectors' => [
					'{{WRAPPER}} .feature-icon i' => 'color: {{VALUE}}',
					'{{WRAPPER}} .feature-icon svg' => 'fill: {{VALUE}}',
				],
			]
		);

		$widget->add_responsive_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .feature-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .feature-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$widget->add_responsive_control(
			'icon_margin',
			[
				'label' => esc_html__( 'Margin', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .feature-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_section();
	}

	private static function register_title_style_section( $widget ) {
		$widget->start_controls_section(
			'section_title_style',
			[
				'label' => esc_html__( 'Title Style', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Title Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#333333',
				'selectors' => [
					'{{WRAPPER}} .feature-title' => 'color: {{VALUE}}',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .feature-title',
			]
		);

		$widget->add_responsive_control(
			'title_margin',
			[
				'label' => esc_html__( 'Margin', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .feature-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_section();
	}

	private static function register_content_style_section( $widget ) {
		$widget->start_controls_section(
			'section_content_style',
			[
				'label' => esc_html__( 'Content Style', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'content_color',
			[
				'label' => esc_html__( 'Content Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#666666',
				'selectors' => [
					'{{WRAPPER}} .feature-content' => 'color: {{VALUE}}',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'selector' => '{{WRAPPER}} .feature-content',
			]
		);

		$widget->add_responsive_control(
			'content_margin',
			[
				'label' => esc_html__( 'Margin', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .feature-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_section();
	}

	private static function register_button_style_section( $widget ) {
		$widget->start_controls_section(
			'section_button_style',
			[
				'label' => esc_html__( 'Button Style', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_block_4' => 'yes',
					'show_block_4_button' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .feature-button',
			]
		);

		$widget->start_controls_tabs( 'button_style_tabs' );

		$widget->start_controls_tab(
			'button_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'promen-elementor-widgets' ),
			]
		);

		$widget->add_control(
			'button_text_color',
			[
				'label' => esc_html__( 'Text Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .feature-button' => 'color: {{VALUE}}',
				],
			]
		);

		$widget->add_control(
			'button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#4054b2',
				'selectors' => [
					'{{WRAPPER}} .feature-button' => 'background-color: {{VALUE}}',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .feature-button',
			]
		);

		$widget->add_responsive_control(
			'button_border_radius',
			[
				'label' => esc_html__( 'Border Radius', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .feature-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_responsive_control(
			'button_padding',
			[
				'label' => esc_html__( 'Padding', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .feature-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'button_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'promen-elementor-widgets' ),
			]
		);

		$widget->add_control(
			'button_hover_text_color',
			[
				'label' => esc_html__( 'Text Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .feature-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$widget->add_control(
			'button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#3443a0',
				'selectors' => [
					'{{WRAPPER}} .feature-button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$widget->add_control(
			'button_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .feature-button:hover' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'button_border_border!' => '',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} .feature-button:hover',
			]
		);

		$widget->add_control(
			'button_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::HOVER_ANIMATION,
			]
		);

		$widget->end_controls_tab();

		$widget->end_controls_tabs();

		$widget->end_controls_section();
	}

	private static function get_default_top_position( $block_number ) {
		$positions = [
			1 => 15, // Top left
			2 => 15, // Top right
			3 => 60, // Bottom left
			4 => 60, // Bottom right
		];

		return isset( $positions[ $block_number ] ) ? $positions[ $block_number ] : 0;
	}

	private static function get_default_left_position( $block_number ) {
		$positions = [
			1 => 5,  // Top left
			2 => 75, // Top right
			3 => 5,  // Bottom left
			4 => 75, // Bottom right
		];

		return isset( $positions[ $block_number ] ) ? $positions[ $block_number ] : 0;
	}
}
