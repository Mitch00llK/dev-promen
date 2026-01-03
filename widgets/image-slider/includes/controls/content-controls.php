<?php
/**
 * Content Controls for Image Slider Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Content Section
$this->start_controls_section(
    'section_content',
    [
        'label' => esc_html__('Content', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

// Add show title control
$this->add_control(
    'show_title',
    [
        'label' => esc_html__('Show Title', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
        'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

// Use the standardized split title controls
promen_add_split_title_controls(
    $this, 
    'section_content', 
    ['show_title' => 'yes'], 
    esc_html__('Image Gallery', 'promen-elementor-widgets'),
    'section_title'
);

// Slider Images
$this->add_control(
    'slider_images',
    [
        'label' => esc_html__('Images', 'promen-elementor-widgets'),
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
                'name' => 'use_image_title',
                'label' => esc_html__('Use Image Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Use the title from the Media Library metadata', 'promen-elementor-widgets'),
            ],
            [
                'name' => 'title',
                'label' => esc_html__('Custom Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Image Title', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter custom image title', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'use_image_title!' => 'yes',
                ],
            ],
            [
                'name' => 'use_image_description',
                'label' => esc_html__('Use Image Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Use the description/caption from the Media Library metadata', 'promen-elementor-widgets'),
            ],
            [
                'name' => 'description',
                'label' => esc_html__('Custom Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Image description goes here', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter custom image description', 'promen-elementor-widgets'),
                'rows' => 5,
                'label_block' => true,
                'condition' => [
                    'use_image_description!' => 'yes',
                ],
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
                'use_image_title' => 'yes',
                'title' => esc_html__('Image 1', 'promen-elementor-widgets'),
                'use_image_description' => 'yes',
                'description' => esc_html__('Description for image 1', 'promen-elementor-widgets'),
                'show_overlay' => 'no',
            ],
            [
                'image' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'use_image_title' => 'yes',
                'title' => esc_html__('Image 2', 'promen-elementor-widgets'),
                'use_image_description' => 'yes',
                'description' => esc_html__('Description for image 2', 'promen-elementor-widgets'),
                'show_overlay' => 'no',
            ],
            [
                'image' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'use_image_title' => 'yes',
                'title' => esc_html__('Image 3', 'promen-elementor-widgets'),
                'use_image_description' => 'yes',
                'description' => esc_html__('Description for image 3', 'promen-elementor-widgets'),
                'show_overlay' => 'no',
            ],
        ],
        'title_field' => '{{{ title }}}',
    ]
);

// Layout Settings
$this->add_control(
    'layout_heading',
    [
        'label' => esc_html__('Layout Settings', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

// Columns Desktop
$this->add_control(
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
$this->add_control(
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
$this->add_control(
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
$this->add_control(
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
$this->add_control(
    'image_height',
    [
        'label' => esc_html__('Image Height', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'default',
        'options' => [
            'default' => esc_html__('Default', 'promen-elementor-widgets'),
            'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
            'aspect_ratio' => esc_html__('Aspect Ratio', 'promen-elementor-widgets'),
        ],
    ]
);

// Custom Image Height
$this->add_responsive_control(
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
            '{{WRAPPER}} .promen-slider-image img' => 'height: {{SIZE}}{{UNIT}}; object-fit: cover;',
        ],
        'condition' => [
            'image_height' => 'custom',
        ],
    ]
);

// Aspect Ratio
$this->add_responsive_control(
    'image_aspect_ratio',
    [
        'label' => esc_html__('Aspect Ratio', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '16:9',
        'options' => [
            '1:1' => esc_html__('1:1 (Square)', 'promen-elementor-widgets'),
            '3:2' => esc_html__('3:2', 'promen-elementor-widgets'),
            '4:3' => esc_html__('4:3', 'promen-elementor-widgets'),
            '16:9' => esc_html__('16:9', 'promen-elementor-widgets'),
            '21:9' => esc_html__('21:9', 'promen-elementor-widgets'),
            'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
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

// Custom Aspect Ratio
$this->add_responsive_control(
    'custom_aspect_width',
    [
        'label' => esc_html__('Custom Aspect Width', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::NUMBER,
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

$this->add_responsive_control(
    'custom_aspect_height',
    [
        'label' => esc_html__('Custom Aspect Height', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::NUMBER,
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

// Object Fit
$this->add_control(
    'image_object_fit',
    [
        'label' => esc_html__('Object Fit', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'cover',
        'options' => [
            'cover' => esc_html__('Cover', 'promen-elementor-widgets'),
            'contain' => esc_html__('Contain', 'promen-elementor-widgets'),
            'fill' => esc_html__('Fill', 'promen-elementor-widgets'),
            'none' => esc_html__('None', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'image_height!' => 'default',
        ],
        'selectors' => [
            '{{WRAPPER}} .promen-slider-image img' => 'object-fit: {{VALUE}};',
        ],
    ]
);

// Object Position
$this->add_control(
    'image_object_position',
    [
        'label' => esc_html__('Object Position', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'center center',
        'options' => [
            'center center' => esc_html__('Center Center', 'promen-elementor-widgets'),
            'center top' => esc_html__('Center Top', 'promen-elementor-widgets'),
            'center bottom' => esc_html__('Center Bottom', 'promen-elementor-widgets'),
            'left center' => esc_html__('Left Center', 'promen-elementor-widgets'),
            'left top' => esc_html__('Left Top', 'promen-elementor-widgets'),
            'left bottom' => esc_html__('Left Bottom', 'promen-elementor-widgets'),
            'right center' => esc_html__('Right Center', 'promen-elementor-widgets'),
            'right top' => esc_html__('Right Top', 'promen-elementor-widgets'),
            'right bottom' => esc_html__('Right Bottom', 'promen-elementor-widgets'),
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

// Image Hover Animation
$this->add_control(
    'image_hover_animation',
    [
        'label' => esc_html__('Hover Animation', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'none',
        'options' => [
            'none' => esc_html__('None', 'promen-elementor-widgets'),
            'grow' => esc_html__('Grow', 'promen-elementor-widgets'),
            'shrink' => esc_html__('Shrink', 'promen-elementor-widgets'),
            'pulse' => esc_html__('Pulse', 'promen-elementor-widgets'),
            'buzz' => esc_html__('Buzz', 'promen-elementor-widgets'),
            'float' => esc_html__('Float', 'promen-elementor-widgets'),
            'bob' => esc_html__('Bob', 'promen-elementor-widgets'),
            'hang' => esc_html__('Hang', 'promen-elementor-widgets'),
            'wobble-horizontal' => esc_html__('Wobble Horizontal', 'promen-elementor-widgets'),
            'wobble-vertical' => esc_html__('Wobble Vertical', 'promen-elementor-widgets'),
        ],
    ]
);

// Overlay Settings
$this->add_control(
    'overlay_heading',
    [
        'label' => esc_html__('Overlay Settings', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::HEADING,
        'separator' => 'before',
    ]
);

// Show Overlay on Hover
$this->add_control(
    'show_overlay_on_hover',
    [
        'label' => esc_html__('Show Overlay on Hover', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

// Show Image Title
$this->add_control(
    'show_image_title',
    [
        'label' => esc_html__('Show Image Title', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

// Show Image Description
$this->add_control(
    'show_image_description',
    [
        'label' => esc_html__('Show Image Description', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->end_controls_section(); 