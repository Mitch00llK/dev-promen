<?php
namespace Promen\Widgets\DocumentInfoList\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promen_Document_Info_List_Style_Controls {

	public static function register_controls( $widget ) {
		// Year Title Style
		$widget->start_controls_section(
			'section_year_title_style',
			[
				'label' => esc_html__( 'Year Title', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'year_title_color',
			[
				'label'     => esc_html__( 'Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-year-title' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'year_title_typography',
				'selector' => '{{WRAPPER}} .document-info-year-title',
			]
		);

		$widget->add_responsive_control(
			'year_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-year-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_responsive_control(
			'year_title_padding',
			[
				'label'      => esc_html__( 'Padding', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-year-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_control(
			'year_title_border_bottom',
			[
				'label'   => esc_html__( 'Border Bottom', 'promen-elementor-widgets' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'year_title_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#eeeeee',
				'selectors' => [
					'{{WRAPPER}} .document-info-year-title.has-border' => 'border-bottom-color: {{VALUE}};',
				],
				'condition' => [
					'year_title_border_bottom' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'year_title_border_width',
			[
				'label'     => esc_html__( 'Border Width', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 1,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 10,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .document-info-year-title.has-border' => 'border-bottom-width: {{SIZE}}{{UNIT}}; border-bottom-style: solid;',
				],
				'condition' => [
					'year_title_border_bottom' => 'yes',
				],
			]
		);

		$widget->end_controls_section();

		// Year Section Style
		$widget->start_controls_section(
			'section_year_section_style',
			[
				'label' => esc_html__( 'Year Section', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_responsive_control(
			'year_section_spacing',
			[
				'label'     => esc_html__( 'Spacing Between Sections', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 40,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .document-info-year-section' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .document-info-year-section:last-child' => 'margin-bottom: 0;',
				],
			]
		);

		$widget->add_control(
			'year_section_background',
			[
				'label'     => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-year-section' => 'background-color: {{VALUE}};',
				],
			]
		);

		$widget->add_responsive_control(
			'year_section_padding',
			[
				'label'      => esc_html__( 'Padding', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-year-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'year_section_border',
				'selector' => '{{WRAPPER}} .document-info-year-section',
			]
		);

		$widget->add_control(
			'year_section_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-year-section' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'year_section_box_shadow',
				'selector' => '{{WRAPPER}} .document-info-year-section',
			]
		);

		$widget->end_controls_section();

		// List Item Style
		$widget->start_controls_section(
			'section_list_item_style',
			[
				'label' => esc_html__( 'Document Items', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_responsive_control(
			'list_item_spacing',
			[
				'label'     => esc_html__( 'Spacing Between Items', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 20,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .document-info-item' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .document-info-item:last-child' => 'margin-bottom: 0;',
				],
			]
		);

		$widget->add_responsive_control(
			'column_gap',
			[
				'label'     => esc_html__( 'Column Gap', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .document-info-list.two-columns' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'column_layout' => 'two-columns',
				],
			]
		);

		$widget->add_control(
			'list_item_background',
			[
				'label'     => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-item' => 'background-color: {{VALUE}};',
				],
			]
		);

		$widget->add_responsive_control(
			'list_item_padding',
			[
				'label'      => esc_html__( 'Padding', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'list_item_border',
				'selector' => '{{WRAPPER}} .document-info-item',
			]
		);

		$widget->add_control(
			'list_item_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'list_item_box_shadow',
				'selector' => '{{WRAPPER}} .document-info-item',
			]
		);

		$widget->end_controls_section();

		// Document Title Style
		$widget->start_controls_section(
			'section_document_title_style',
			[
				'label' => esc_html__( 'Document Title', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'document_title_color',
			[
				'label'     => esc_html__( 'Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-document-title' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'document_title_typography',
				'selector' => '{{WRAPPER}} .document-info-document-title',
			]
		);

		$widget->add_responsive_control(
			'document_title_margin',
			[
				'label'      => esc_html__( 'Margin', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-document-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_control(
			'document_title_animation_heading',
			[
				'label'     => esc_html__( 'Hover Animation', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->add_control(
			'document_title_hover_animation',
			[
				'label'     => esc_html__( 'Underline Animation', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'selectors' => [
					'{{WRAPPER}} .document-info-document-title' => 'position: relative; display: inline-block; padding-bottom: 2px;',
					'{{WRAPPER}} .document-info-document-title::after' => 'content: ""; position: absolute; bottom: 0; left: 0; width: 100%; height: 1px; background-color: currentColor; transform: scaleX(0); transform-origin: left; transition: transform 0.35s cubic-bezier(0.23, 1, 0.32, 1);',
					'{{WRAPPER}} .document-info-item:hover .document-info-document-title::after' => 'transform: scaleX(1);',
				],
			]
		);

		$widget->add_control(
			'document_title_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-item:hover .document-info-document-title' => 'color: {{VALUE}};',
				],
				'condition' => [
					'document_title_hover_animation' => 'yes',
				],
			]
		);

		$widget->add_control(
			'document_title_underline_color',
			[
				'label'     => esc_html__( 'Underline Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-document-title::after' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'document_title_hover_animation' => 'yes',
				],
			]
		);

		$widget->add_control(
			'document_title_underline_height',
			[
				'label'     => esc_html__( 'Underline Height', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range'     => [
					'px' => [
						'min'  => 1,
						'max'  => 5,
						'step' => 1,
					],
				],
				'default'   => [
					'unit' => 'px',
					'size' => 1,
				],
				'selectors' => [
					'{{WRAPPER}} .document-info-document-title::after' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'document_title_hover_animation' => 'yes',
				],
			]
		);

		$widget->end_controls_section();

		// Icon Style
		$widget->start_controls_section(
			'section_icon_style',
			[
				'label' => esc_html__( 'Icon', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-icon i'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .document-info-icon svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$widget->add_responsive_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Size', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 24,
				],
				'range'     => [
					'px' => [
						'min' => 12,
						'max' => 48,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .document-info-icon i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .document-info-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$widget->add_control(
			'icon_background_show',
			[
				'label'   => esc_html__( 'Show Background', 'promen-elementor-widgets' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'icon_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#f5f5f5',
				'selectors' => [
					'{{WRAPPER}} .document-info-icon.with-bg' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'icon_background_show' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'icon_background_size',
			[
				'label'     => esc_html__( 'Background Size', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 48,
				],
				'range'     => [
					'px' => [
						'min' => 30,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .document-info-icon.with-bg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'icon_background_show' => 'yes',
				],
			]
		);

		$widget->add_control(
			'icon_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => '50',
					'right'    => '50',
					'bottom'   => '50',
					'left'     => '50',
					'unit'     => '%',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .document-info-icon.with-bg' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'icon_background_show' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'icon_margin',
			[
				'label'      => esc_html__( 'Margin', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_section();

		// Document Download Style
		$widget->start_controls_section(
			'section_document_link_style',
			[
				'label' => esc_html__( 'Document Download', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->start_controls_tabs( 'document_link_style_tabs' );

		$widget->start_controls_tab(
			'document_link_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'promen-elementor-widgets' ),
			]
		);

		$widget->add_control(
			'document_link_background',
			[
				'label'     => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-download-link' => 'background-color: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'document_link_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-download-link' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->add_responsive_control(
			'document_link_padding',
			[
				'label'      => esc_html__( 'Padding', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .document-info-download-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->start_controls_tab(
			'document_link_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'promen-elementor-widgets' ),
			]
		);

		$widget->add_control(
			'document_link_hover_background',
			[
				'label'     => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-download-link:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'document_link_hover_title_color',
			[
				'label'     => esc_html__( 'Title Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .document-info-download-link:hover .document-info-document-title' => 'color: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'document_link_hover_transform',
			[
				'label'     => esc_html__( 'Hover Effect', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'translateY(-2px)',
				'options'   => [
					'none'                       => esc_html__( 'None', 'promen-elementor-widgets' ),
					'translateY(-2px)'           => esc_html__( 'Lift Up', 'promen-elementor-widgets' ),
					'scale(1.02)'                => esc_html__( 'Scale', 'promen-elementor-widgets' ),
					'translateY(-2px) scale(1.02)' => esc_html__( 'Lift + Scale', 'promen-elementor-widgets' ),
				],
				'selectors' => [
					'{{WRAPPER}} .document-info-download-link:hover' => 'transform: {{VALUE}};',
				],
			]
		);

		$widget->end_controls_tab();

		$widget->end_controls_tabs();

		$widget->end_controls_section();

		// Tooltip Style
		$widget->start_controls_section(
			'section_tooltip_style',
			[
				'label' => esc_html__( 'Tooltip', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'tooltip_enable',
			[
				'label'                => esc_html__( 'Enable Tooltip', 'promen-elementor-widgets' ),
				'type'                 => Controls_Manager::SWITCHER,
				'default'              => 'yes',
				'selectors'            => [
					'{{WRAPPER}} .document-tooltip' => 'display: inline;',
				],
				'selectors_dictionary' => [
					''    => 'none',
					'yes' => 'inline',
				],
			]
		);

		$widget->add_control(
			'tooltip_text',
			[
				'label'     => esc_html__( 'Tooltip Text', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Download bestand', 'promen-elementor-widgets' ),
				'condition' => [
					'tooltip_enable' => 'yes',
				],
			]
		);

		$widget->add_control(
			'tooltip_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.9)',
				'selectors' => [
					'{{WRAPPER}} .document-info-download-link::before' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_enable' => 'yes',
				],
			]
		);

		$widget->add_control(
			'tooltip_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'promen-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .document-info-download-link::before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'tooltip_enable' => 'yes',
				],
			]
		);

		$widget->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'tooltip_typography',
				'selector'  => '{{WRAPPER}} .document-info-download-link::before',
				'condition' => [
					'tooltip_enable' => 'yes',
				],
			]
		);

		$widget->add_control(
			'tooltip_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '4',
					'right'    => '4',
					'bottom'   => '4',
					'left'     => '4',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .document-info-download-link::before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'tooltip_enable' => 'yes',
				],
			]
		);

		$widget->add_responsive_control(
			'tooltip_padding',
			[
				'label'      => esc_html__( 'Padding', 'promen-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'      => '8',
					'right'    => '12',
					'bottom'   => '8',
					'left'     => '12',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .document-info-download-link::before' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'  => [
					'tooltip_enable' => 'yes',
				],
			]
		);

		$widget->end_controls_section();

		// Responsive Settings
		$widget->start_controls_section(
			'section_responsive_settings',
			[
				'label' => esc_html__( 'Responsive Settings', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$widget->add_control(
			'tablet_breakpoint',
			[
				'label'   => esc_html__( 'Tablet Breakpoint (px)', 'promen-elementor-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 768,
				'min'     => 320,
				'max'     => 1200,
			]
		);

		$widget->add_control(
			'mobile_breakpoint',
			[
				'label'   => esc_html__( 'Mobile Breakpoint (px)', 'promen-elementor-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 480,
				'min'     => 320,
				'max'     => 900,
			]
		);

		$widget->end_controls_section();
	}
}
