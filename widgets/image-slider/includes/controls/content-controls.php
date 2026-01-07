<?php
namespace Promen\Widgets\ImageSlider\Controls;

use Elementor\Controls_Manager;
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Promen_Image_Slider_Content_Controls {

	public static function register_controls( $widget ) {
		self::register_content_section( $widget );
		self::register_slider_section( $widget );
		self::register_layout_section( $widget );
		self::register_visibility_section( $widget );
	}

	private static function register_content_section( $widget ) {
		$widget->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'show_title',
			[
				'label' => esc_html__( 'Show Title', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Show', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'Hide', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		// Use the standardized split title controls
		if ( function_exists( 'promen_add_split_title_controls' ) ) {
			promen_add_split_title_controls(
				$widget, 
				'section_content', 
				['show_title' => 'yes'], 
				esc_html__( 'Image Gallery', 'promen-elementor-widgets' ),
				'section_title'
			);
		}

		$widget->add_control(
			'slider_images',
			[
				'label' => esc_html__( 'Images', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::REPEATER,
				'fields' => [
					[
						'name' => 'image',
						'label' => esc_html__( 'Image', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::MEDIA,
						'default' => [
							'url' => Utils::get_placeholder_image_src(),
						],
					],
					[
						'name' => 'use_image_title',
						'label' => esc_html__( 'Use Image Title', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
						'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
						'return_value' => 'yes',
						'default' => 'yes',
						'description' => esc_html__( 'Use the title from the Media Library metadata', 'promen-elementor-widgets' ),
					],
					[
						'name' => 'title',
						'label' => esc_html__( 'Custom Title', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::TEXT,
						'default' => esc_html__( 'Image Title', 'promen-elementor-widgets' ),
						'placeholder' => esc_html__( 'Enter custom image title', 'promen-elementor-widgets' ),
						'label_block' => true,
						'condition' => [
							'use_image_title!' => 'yes',
						],
					],
					[
						'name' => 'use_image_description',
						'label' => esc_html__( 'Use Image Description', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
						'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
						'return_value' => 'yes',
						'default' => 'yes',
						'description' => esc_html__( 'Use the description/caption from the Media Library metadata', 'promen-elementor-widgets' ),
					],
					[
						'name' => 'description',
						'label' => esc_html__( 'Custom Description', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::TEXTAREA,
						'default' => esc_html__( 'Image description goes here', 'promen-elementor-widgets' ),
						'placeholder' => esc_html__( 'Enter custom image description', 'promen-elementor-widgets' ),
						'rows' => 5,
						'label_block' => true,
						'condition' => [
							'use_image_description!' => 'yes',
						],
					],
					[
						'name' => 'show_overlay',
						'label' => esc_html__( 'Show Overlay', 'promen-elementor-widgets' ),
						'type' => Controls_Manager::SWITCHER,
						'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
						'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
						'return_value' => 'yes',
						'default' => 'no',
					],
				],
				'default' => [
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'use_image_title' => 'yes',
						'title' => esc_html__( 'Image 1', 'promen-elementor-widgets' ),
						'use_image_description' => 'yes',
						'description' => esc_html__( 'Description for image 1', 'promen-elementor-widgets' ),
						'show_overlay' => 'no',
					],
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'use_image_title' => 'yes',
						'title' => esc_html__( 'Image 2', 'promen-elementor-widgets' ),
						'use_image_description' => 'yes',
						'description' => esc_html__( 'Description for image 2', 'promen-elementor-widgets' ),
						'show_overlay' => 'no',
					],
					[
						'image' => [
							'url' => Utils::get_placeholder_image_src(),
						],
						'use_image_title' => 'yes',
						'title' => esc_html__( 'Image 3', 'promen-elementor-widgets' ),
						'use_image_description' => 'yes',
						'description' => esc_html__( 'Description for image 3', 'promen-elementor-widgets' ),
						'show_overlay' => 'no',
					],
				],
				'title_field' => '{{{ title }}}',
			]
		);

		$widget->add_control(
			'layout_heading',
			[
				'label' => esc_html__( 'Layout Settings', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->add_control(
			'columns_desktop',
			[
				'label' => esc_html__( 'Columns (Desktop)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
			]
		);

		$widget->add_control(
			'columns_tablet',
			[
				'label' => esc_html__( 'Columns (Tablet)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
				],
			]
		);

		$widget->add_control(
			'columns_mobile',
			[
				'label' => esc_html__( 'Columns (Mobile)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
				],
			]
		);

		$widget->add_control(
			'image_size',
			[
				'label' => esc_html__( 'Image Size', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => [
					'thumbnail' => esc_html__( 'Thumbnail', 'promen-elementor-widgets' ),
					'medium' => esc_html__( 'Medium', 'promen-elementor-widgets' ),
					'large' => esc_html__( 'Large', 'promen-elementor-widgets' ),
					'full' => esc_html__( 'Full', 'promen-elementor-widgets' ),
				],
			]
		);

		$widget->add_control(
			'image_height',
			[
				'label' => esc_html__( 'Image Height', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'promen-elementor-widgets' ),
					'custom' => esc_html__( 'Custom', 'promen-elementor-widgets' ),
					'aspect_ratio' => esc_html__( 'Aspect Ratio', 'promen-elementor-widgets' ),
				],
			]
		);

		$widget->add_responsive_control(
			'custom_image_height',
			[
				'label' => esc_html__( 'Custom Height', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', '%' ],
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
					'{{WRAPPER}} .promen-slider-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
				],
				'condition' => [
					'image_height' => 'custom',
				],
			]
		);

		$widget->add_responsive_control(
			'image_aspect_ratio',
			[
				'label' => esc_html__( 'Aspect Ratio', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => '16:9',
				'options' => [
					'1:1' => esc_html__( '1:1 (Square)', 'promen-elementor-widgets' ),
					'3:2' => esc_html__( '3:2', 'promen-elementor-widgets' ),
					'4:3' => esc_html__( '4:3', 'promen-elementor-widgets' ),
					'16:9' => esc_html__( '16:9', 'promen-elementor-widgets' ),
					'21:9' => esc_html__( '21:9', 'promen-elementor-widgets' ),
					'custom' => esc_html__( 'Custom', 'promen-elementor-widgets' ),
				],
				'condition' => [
					'image_height' => 'aspect_ratio',
				],
				'selectors_dictionary' => [
					'1:1' => '100%',
					'3:2' => 'calc(2 / 3 * 100%)',
					'4:3' => 'calc(3 / 4 * 100%)',
					'16:9' => 'calc(9 / 16 * 100%)',
					'21:9' => 'calc(9 / 21 * 100%)',
				],
				'selectors' => [
					'{{WRAPPER}} .promen-slider-image' => 'aspect-ratio: 16/9; padding-bottom: {{VALUE}};',
					'{{WRAPPER}} .promen-slider-image img' => 'position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;',
				],
			]
		);

		$widget->add_responsive_control(
			'custom_aspect_width',
			[
				'label' => esc_html__( 'Custom Aspect Width', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 16,
				'condition' => [
					'image_height' => 'aspect_ratio',
					'image_aspect_ratio' => 'custom',
				],
			]
		);

		$widget->add_responsive_control(
			'custom_aspect_height',
			[
				'label' => esc_html__( 'Custom Aspect Height', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 9,
				'selectors' => [
					'{{WRAPPER}} .promen-slider-image' => 'aspect-ratio: {{custom_aspect_width.VALUE}}/{{VALUE}}; padding-bottom: calc({{VALUE}} / {{custom_aspect_width.VALUE}} * 100%);',
					'{{WRAPPER}} .promen-slider-image img' => 'position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;',
				],
				'condition' => [
					'image_height' => 'aspect_ratio',
					'image_aspect_ratio' => 'custom',
				],
			]
		);

		$widget->add_control(
			'image_object_fit',
			[
				'label' => esc_html__( 'Object Fit', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'cover',
				'options' => [
					'cover' => esc_html__( 'Cover', 'promen-elementor-widgets' ),
					'contain' => esc_html__( 'Contain', 'promen-elementor-widgets' ),
					'fill' => esc_html__( 'Fill', 'promen-elementor-widgets' ),
					'none' => esc_html__( 'None', 'promen-elementor-widgets' ),
				],
				'condition' => [
					'image_height!' => 'default',
				],
				'selectors' => [
					'{{WRAPPER}} .promen-slider-image img' => 'object-fit: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'image_object_position',
			[
				'label' => esc_html__( 'Object Position', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'center center',
				'options' => [
					'center center' => esc_html__( 'Center Center', 'promen-elementor-widgets' ),
					'center top' => esc_html__( 'Center Top', 'promen-elementor-widgets' ),
					'center bottom' => esc_html__( 'Center Bottom', 'promen-elementor-widgets' ),
					'left center' => esc_html__( 'Left Center', 'promen-elementor-widgets' ),
					'left top' => esc_html__( 'Left Top', 'promen-elementor-widgets' ),
					'left bottom' => esc_html__( 'Left Bottom', 'promen-elementor-widgets' ),
					'right center' => esc_html__( 'Right Center', 'promen-elementor-widgets' ),
					'right top' => esc_html__( 'Right Top', 'promen-elementor-widgets' ),
					'right bottom' => esc_html__( 'Right Bottom', 'promen-elementor-widgets' ),
				],
				'condition' => [
					'image_height!' => 'default',
					'image_object_fit!' => 'fill',
				],
				'selectors' => [
					'{{WRAPPER}} .promen-slider-image img' => 'object-position: {{VALUE}};',
				],
			]
		);

		$widget->add_control(
			'image_hover_animation',
			[
				'label' => esc_html__( 'Hover Animation', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none' => esc_html__( 'None', 'promen-elementor-widgets' ),
					'grow' => esc_html__( 'Grow', 'promen-elementor-widgets' ),
					'shrink' => esc_html__( 'Shrink', 'promen-elementor-widgets' ),
					'pulse' => esc_html__( 'Pulse', 'promen-elementor-widgets' ),
					'buzz' => esc_html__( 'Buzz', 'promen-elementor-widgets' ),
					'float' => esc_html__( 'Float', 'promen-elementor-widgets' ),
					'bob' => esc_html__( 'Bob', 'promen-elementor-widgets' ),
					'hang' => esc_html__( 'Hang', 'promen-elementor-widgets' ),
					'wobble-horizontal' => esc_html__( 'Wobble Horizontal', 'promen-elementor-widgets' ),
					'wobble-vertical' => esc_html__( 'Wobble Vertical', 'promen-elementor-widgets' ),
				],
			]
		);

		$widget->add_control(
			'overlay_heading',
			[
				'label' => esc_html__( 'Overlay Settings', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->add_control(
			'show_overlay_on_hover',
			[
				'label' => esc_html__( 'Show Overlay on Hover', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'show_image_title',
			[
				'label' => esc_html__( 'Show Image Title', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'show_image_description',
			[
				'label' => esc_html__( 'Show Image Description', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->end_controls_section();
	}

	private static function register_slider_section( $widget ) {
		$widget->start_controls_section(
			'section_slider',
			[
				'label' => esc_html__( 'Slider Settings', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'slider_info',
			[
				'type' => Controls_Manager::RAW_HTML,
				'raw' => esc_html__( 'The slider will automatically activate when more than 3 images are added.', 'promen-elementor-widgets' ),
				'content_classes' => 'elementor-descriptor',
			]
		);

		$widget->add_control(
			'slider_template',
			[
				'label' => esc_html__( 'Slider Template', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => esc_html__( 'Default', 'promen-elementor-widgets' ),
					'fade' => esc_html__( 'Fade', 'promen-elementor-widgets' ),
				],
			]
		);

		$widget->add_control(
			'slider_navigation',
			[
				'label' => esc_html__( 'Show Navigation Arrows', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'slider_pagination',
			[
				'label' => esc_html__( 'Show Pagination Dots', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'slider_loop',
			[
				'label' => esc_html__( 'Enable Loop', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'slider_autoplay',
			[
				'label' => esc_html__( 'Enable Autoplay', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'slider_autoplay_delay',
			[
				'label' => esc_html__( 'Autoplay Delay (ms)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::NUMBER,
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
				'label' => esc_html__( 'Transition Speed (ms)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 100,
				'max' => 3000,
				'step' => 100,
				'default' => 500,
			]
		);

		$widget->add_control(
			'slider_effect',
			[
				'label' => esc_html__( 'Transition Effect', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'promen-elementor-widgets' ),
					'fade' => esc_html__( 'Fade', 'promen-elementor-widgets' ),
					'cube' => esc_html__( 'Cube', 'promen-elementor-widgets' ),
					'coverflow' => esc_html__( 'Coverflow', 'promen-elementor-widgets' ),
					'flip' => esc_html__( 'Flip', 'promen-elementor-widgets' ),
					'spring' => esc_html__( 'Spring', 'promen-elementor-widgets' ),
				],
			]
		);

		$widget->add_control(
			'slides_per_view',
			[
				'label' => esc_html__( 'Slides Per View (Desktop)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'auto' => esc_html__( 'Auto', 'promen-elementor-widgets' ),
				],
				'condition' => [
					'slider_effect' => 'slide',
				],
			]
		);

		$widget->add_control(
			'slides_per_view_tablet',
			[
				'label' => esc_html__( 'Slides Per View (Tablet)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => '2',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'auto' => esc_html__( 'Auto', 'promen-elementor-widgets' ),
				],
				'condition' => [
					'slider_effect' => 'slide',
				],
			]
		);

		$widget->add_control(
			'slides_per_view_mobile',
			[
				'label' => esc_html__( 'Slides Per View (Mobile)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'auto' => esc_html__( 'Auto', 'promen-elementor-widgets' ),
				],
				'condition' => [
					'slider_effect' => 'slide',
				],
			]
		);

		$widget->add_control(
			'space_between',
			[
				'label' => esc_html__( 'Space Between Slides', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
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
			'space_between_tablet',
			[
				'label' => esc_html__( 'Space Between Slides (Tablet)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
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
			'space_between_mobile',
			[
				'label' => esc_html__( 'Space Between Slides (Mobile)', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
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
				'label' => esc_html__( 'Center Slides', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
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
				'label' => esc_html__( 'Enable Gradient Overlay', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
				'description' => esc_html__( 'Adds gradient overlays on the left and right sides of the slider', 'promen-elementor-widgets' ),
			]
		);

		$widget->add_control(
			'gradient_color_start',
			[
				'label' => esc_html__( 'Gradient Start Color', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#ffffff',
				'condition' => [
					'gradient_overlay' => 'yes',
				],
			]
		);

		$widget->add_control(
			'gradient_opacity',
			[
				'label' => esc_html__( 'Gradient Opacity', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
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
				'label' => esc_html__( 'Gradient Width', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ '%' ],
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
	}

	private static function register_layout_section( $widget ) {
		$widget->start_controls_section(
			'section_layout_settings',
			[
				'label' => esc_html__( 'Slides Per View', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_responsive_control(
			'slides_to_show',
			[
				'label' => esc_html__( 'Slides to Show', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				],
				'frontend_available' => true,
			]
		);

		$widget->add_responsive_control(
			'space_between_layout',
			[
				'label' => esc_html__( 'Space Between Slides', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'size' => 30,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'frontend_available' => true,
			]
		);

		$widget->end_controls_section();
	}

	private static function register_visibility_section( $widget ) {
		$widget->start_controls_section(
			'section_visibility',
			[
				'label' => esc_html__( 'Visibility', 'promen-elementor-widgets' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		$widget->add_control(
			'show_title_visibility',
			[
				'label' => esc_html__( 'Show Title', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$widget->add_control(
			'show_image_title_visibility',
			[
				'label' => esc_html__( 'Show Image Titles', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$widget->add_control(
			'show_image_description_visibility',
			[
				'label' => esc_html__( 'Show Image Descriptions', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$widget->add_control(
			'show_overlay_on_hover_visibility',
			[
				'label' => esc_html__( 'Show Overlay on Hover', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
				'selectors' => [
					'{{WRAPPER}} .promen-slider-overlay.hover-overlay' => 'opacity: 0 !important; transition: all 0.3s ease !important;',
					'{{WRAPPER}} .promen-slider-image:hover .promen-slider-overlay.hover-overlay' => 'opacity: 1 !important;',
				],
			]
		);

		$widget->add_control(
			'responsive_visibility_heading',
			[
				'label' => esc_html__( 'Responsive Visibility', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$widget->add_control(
			'hide_on_desktop',
			[
				'label' => esc_html__( 'Hide On Desktop', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
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
				'label' => esc_html__( 'Hide On Tablet', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
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
				'label' => esc_html__( 'Hide On Mobile', 'promen-elementor-widgets' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Yes', 'promen-elementor-widgets' ),
				'label_off' => esc_html__( 'No', 'promen-elementor-widgets' ),
				'return_value' => 'yes',
				'default' => 'no',
				'prefix_class' => 'elementor-',
				'selectors' => [
					'(mobile){{WRAPPER}}' => 'display: none',
				],
			]
		);

		$widget->end_controls_section();
	}
}