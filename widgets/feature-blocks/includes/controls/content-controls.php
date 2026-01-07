<?php
namespace Promen\Widgets\FeatureBlocks\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promen_Feature_Blocks_Content_Controls {

	public static function register_controls( $widget ) {
		self::register_widget_title_section( $widget );
		self::register_main_image_section( $widget );
		self::register_feature_blocks_sections( $widget );
		self::register_layout_settings_section( $widget );
	}

	private static function register_widget_title_section( $widget ) {
		$widget->start_controls_section(
			'section_widget_title',
			[
				'label' => esc_html__( 'Widget Title', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'show_widget_title',
			[
				'label' => esc_html__( 'Show Title', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$widget->add_control(
			'widget_title',
			[
				'label' => esc_html__( 'Title', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Feature Blocks', 'promen-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter your title', 'promen-elementor-widgets' ),
				'condition' => [
					'show_widget_title' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_title_html_tag',
			[
				'label' => esc_html__( 'HTML Tag', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
				'condition' => [
					'show_widget_title' => 'yes',
				],
			]
		);

		$widget->add_control(
			'widget_title_align',
			[
				'label' => esc_html__( 'Alignment', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'promen-elementor-widgets' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'promen-elementor-widgets' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'promen-elementor-widgets' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .widget-title-wrapper' => 'text-align: {{VALUE}};',
				],
				'condition' => [
					'show_widget_title' => 'yes',
				],
			]
		);

		$widget->end_controls_section();
	}

	private static function register_main_image_section( $widget ) {
		$widget->start_controls_section(
			'section_main_image',
			[
				'label' => esc_html__( 'Main Image', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'main_image',
			[
				'label' => esc_html__( 'Choose Image', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);

		$widget->add_control(
			'overlay_image',
			[
				'label' => esc_html__( 'Overlay Image', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'description' => esc_html__( 'Upload an image to display as overlay instead of text', 'promen-elementor-widgets' ),
			]
		);

		$widget->add_control(
			'show_overlay_image',
			[
				'label' => esc_html__( 'Show Overlay Image', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->end_controls_section();
	}

	private static function register_feature_blocks_sections( $widget ) {
		for ( $i = 1; $i <= 4; $i++ ) {
			$widget->start_controls_section(
				'section_block_' . $i,
				[
					'label' => esc_html__( 'Feature Block ' . $i, 'promen-elementor-widgets' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);

			$widget->add_control(
				'show_block_' . $i,
				[
					'label' => esc_html__( 'Show Block ' . $i, 'promen-elementor-widgets' ),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => esc_html__( 'Show', 'promen-elementor-widgets' ),
					'label_off' => esc_html__( 'Hide', 'promen-elementor-widgets' ),
					'return_value' => 'yes',
					'default' => 'yes',
				]
			);

			$widget->add_control(
				'block_' . $i . '_icon',
				[
					'label' => esc_html__( 'Icon', 'promen-elementor-widgets' ),
					'type' => Controls_Manager::ICONS,
					'default' => [
						'value' => 'fas fa-star',
						'library' => 'fa-solid',
					],
					'condition' => [
						'show_block_' . $i => 'yes',
					],
				]
			);

            // Use global helper if available, or assume it is.
            if ( function_exists( 'promen_add_split_title_controls' ) ) {
                promen_add_split_title_controls(
                    $widget, 
                    'section_block_' . $i, 
                    ['show_block_' . $i => 'yes'], 
                    self::get_default_title($i),
                    'block_' . $i . '_title'
                );
            } else {
                 // Fallback if function not found - implementing basic title control
                 $widget->add_control(
                    'block_' . $i . '_title',
                    [
                        'label' => esc_html__( 'Title', 'promen-elementor-widgets' ),
                        'type' => Controls_Manager::TEXT,
                        'default' => self::get_default_title($i),
                        'condition' => [
                            'show_block_' . $i => 'yes',
                        ],
                    ]
                );
            }


			// Override the default HTML tag to 'span' for feature blocks
			$widget->update_control(
				'block_' . $i . '_title_html_tag',
				[
					'default' => 'span',
				]
			);

			$widget->add_control(
				'block_' . $i . '_content',
				[
					'label' => esc_html__( 'Content', 'promen-elementor-widgets' ),
					'type' => Controls_Manager::TEXTAREA,
					'default' => esc_html__( 'Feature block content goes here. Describe the feature in detail.', 'promen-elementor-widgets' ),
					'placeholder' => esc_html__( 'Enter content', 'promen-elementor-widgets' ),
					'condition' => [
						'show_block_' . $i => 'yes',
					],
				]
			);

			// Add button controls only for block 4
			if ( 4 === $i ) {
				$widget->add_control(
					'show_block_4_button',
					[
						'label' => esc_html__( 'Show Button', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Show', 'promen-elementor-widgets' ),
						'label_off' => esc_html__( 'Hide', 'promen-elementor-widgets' ),
						'return_value' => 'yes',
						'default' => 'yes',
						'condition' => [
							'show_block_4' => 'yes',
						],
					]
				);

				$widget->add_control(
					'block_4_button_text',
					[
						'label' => esc_html__( 'Button Text', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Learn More', 'promen-elementor-widgets' ),
						'placeholder' => esc_html__( 'Enter button text', 'promen-elementor-widgets' ),
						'condition' => [
							'show_block_4' => 'yes',
							'show_block_4_button' => 'yes',
						],
					]
				);

				$widget->add_control(
					'block_4_button_url',
					[
						'label' => esc_html__( 'Button URL', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::URL,
						'placeholder' => esc_html__( 'https://your-link.com', 'promen-elementor-widgets' ),
						'default' => [
							'url' => '#',
						],
						'condition' => [
							'show_block_4' => 'yes',
							'show_block_4_button' => 'yes',
						],
					]
				);
			}

			$widget->end_controls_section();
		}
	}

	private static function register_layout_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_layout_settings',
			[
				'label' => esc_html__( 'Layout Settings', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#f5f5f5',
				'selectors' => [
					'{{WRAPPER}} .promen-feature-blocks-container' => 'background-color: {{VALUE}}',
				],
			]
		);

		$widget->add_control(
			'stack_on_tablet',
			[
				'label' => esc_html__( 'Stack on Tablet', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'stack_on_mobile',
			[
				'label' => esc_html__( 'Stack on Mobile', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->end_controls_section();
	}

	private static function get_default_title( $block_number ) {
		$titles = [
			1 => esc_html__( 'Feature One', 'promen-elementor-widgets' ),
			2 => esc_html__( 'Feature Two', 'promen-elementor-widgets' ),
			3 => esc_html__( 'Feature Three', 'promen-elementor-widgets' ),
			4 => esc_html__( 'Feature Four', 'promen-elementor-widgets' ),
		];

		return isset( $titles[ $block_number ] ) ? $titles[ $block_number ] : '';
	}
}
