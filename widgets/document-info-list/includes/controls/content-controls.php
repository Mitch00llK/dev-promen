<?php
namespace Promen\Widgets\DocumentInfoList\Controls;

use Elementor\Controls_Manager;
use Elementor\Repeater;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promen_Document_Info_List_Content_Controls {

	public static function register_controls( $widget ) {
		// Title Section
		$widget->start_controls_section(
			'section_title',
			[
				'label' => esc_html__( 'Title', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'promen-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Documents', 'promen-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter title', 'promen-elementor-widgets' ),
			]
		);

		$widget->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'promen-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		$widget->end_controls_section();

		// Year Sections
		$widget->start_controls_section(
			'section_years',
			[
				'label' => esc_html__( 'Year Sections', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$year_repeater = new Repeater();

		$year_repeater->add_control(
			'year',
			[
				'label'       => esc_html__( 'Publication Year', 'promen-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( '2023', 'promen-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter year', 'promen-elementor-widgets' ),
			]
		);

		$document_repeater = new Repeater();

		$document_repeater->add_control(
			'document_title',
			[
				'label'       => esc_html__( 'Document Title', 'promen-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Document Title', 'promen-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter document title', 'promen-elementor-widgets' ),
				'label_block' => true,
			]
		);

		$document_repeater->add_control(
			'document_icon',
			[
				'label'   => esc_html__( 'Icon', 'promen-elementor-widgets' ),
				'type'    => Controls_Manager::ICONS,
				'default' => [
					'value'   => 'fas fa-file-pdf',
					'library' => 'fa-solid',
				],
			]
		);

		$document_repeater->add_control(
			'document_file',
			[
				'label'       => esc_html__( 'Document File', 'promen-elementor-widgets' ),
				'type'        => Controls_Manager::MEDIA,
				'media_type'  => 'document',
				'default'     => [
					'id'  => 0,
					'url' => '',
				],
				'description' => esc_html__( 'Upload or select a document file (PDF, DOCX, etc.)', 'promen-elementor-widgets' ),
			]
		);

		$year_repeater->add_control(
			'documents',
			[
				'label'       => esc_html__( 'Documents', 'promen-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $document_repeater->get_controls(),
				'default'     => [
					[
						'document_title' => esc_html__( 'Annual Report', 'promen-elementor-widgets' ),
						'document_icon'  => [
							'value'   => 'fas fa-file-pdf',
							'library' => 'fa-solid',
						],
					],
					[
						'document_title' => esc_html__( 'Financial Statement', 'promen-elementor-widgets' ),
						'document_icon'  => [
							'value'   => 'fas fa-file-pdf',
							'library' => 'fa-solid',
						],
					],
				],
				'title_field' => '{{{ document_title }}}',
			]
		);

		$widget->add_control(
			'year_sections',
			[
				'label'       => esc_html__( 'Year Sections', 'promen-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $year_repeater->get_controls(),
				'default'     => [
					[
						'year' => '2023',
					],
					[
						'year' => '2022',
					],
				],
				'title_field' => '{{{ year }}}',
			]
		);

		$widget->add_control(
			'year_tag',
			[
				'label'   => esc_html__( 'Year HTML Tag', 'promen-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
			]
		);

		$widget->end_controls_section();

		// Layout Settings
		$widget->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout Settings', 'promen-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'column_layout',
			[
				'label'   => esc_html__( 'Column Layout', 'promen-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'two-columns',
				'options' => [
					'two-columns' => esc_html__( 'Two Columns', 'promen-elementor-widgets' ),
					'one-column'  => esc_html__( 'One Column', 'promen-elementor-widgets' ),
				],
			]
		);

		$widget->add_control(
			'tooltip_text',
			[
				'label'       => esc_html__( 'Download Tooltip Text', 'promen-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Download bestand', 'promen-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter tooltip text', 'promen-elementor-widgets' ),
				'description' => esc_html__( 'Text that appears when hovering over download links', 'promen-elementor-widgets' ),
			]
		);

		$widget->end_controls_section();

		// Animation Section

	}
}
