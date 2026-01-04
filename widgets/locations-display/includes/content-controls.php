<?php
/**
 * Content Controls
 */

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

// Heading Section
$this->start_controls_section(
    'section_heading',
    [
        'label' => esc_html__('Heading', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'show_heading_section',
    [
        'label' => esc_html__('Show Heading Section', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
    ]
);

// Title Part 1
$this->add_control(
    'title_part_1',
    [
        'label' => esc_html__('Title Part 1', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('Onze', 'promen-elementor-widgets'),
        'label_block' => true,
        'condition' => [
            'show_heading_section' => 'yes',
        ],
    ]
);

// Title Part 2
$this->add_control(
    'title_part_2',
    [
        'label' => esc_html__('Title Part 2', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('locaties', 'promen-elementor-widgets'),
        'label_block' => true,
        'condition' => [
            'show_heading_section' => 'yes',
        ],
    ]
);

// Title HTML Tag
$this->add_control(
    'title_html_tag',
    [
        'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
        'default' => 'h2',
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
        'condition' => [
            'show_heading_section' => 'yes',
        ],
    ]
);

$this->add_control(
    'show_heading_description',
    [
        'label' => esc_html__('Show Description', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
        'condition' => [
            'show_heading_section' => 'yes',
        ],
    ]
);

$this->add_control(
    'heading_description',
    [
        'label' => esc_html__('Description', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXTAREA,
        'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter description text', 'promen-elementor-widgets'),
        'condition' => [
            'show_heading_section' => 'yes',
            'show_heading_description' => 'yes',
        ],
    ]
);

$this->end_controls_section();

// Locations Section
$this->start_controls_section(
    'section_locations',
    [
        'label' => esc_html__('Locations', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_CONTENT,
    ]
);

// Layout is always grid - removed carousel option

$this->add_responsive_control(
    'columns',
    [
        'label' => esc_html__('Columns', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
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
            '{{WRAPPER}} .locations-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
        ],
    ]
);

$repeater = new Repeater();

$repeater->add_control(
    'location_name',
    [
        'label' => esc_html__('Location Name', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('Location Name', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter location name', 'promen-elementor-widgets'),
    ]
);

$repeater->add_control(
    'location_image',
    [
        'label' => esc_html__('Location Image', 'promen-elementor-widgets'),
        'type' => Controls_Manager::MEDIA,
        'default' => [
            'url' => \Elementor\Utils::get_placeholder_image_src(),
        ],
    ]
);

$repeater->add_group_control(
    Group_Control_Image_Size::get_type(),
    [
        'name' => 'location_image_size',
        'default' => 'medium_large',
        'separator' => 'none',
    ]
);

$repeater->add_control(
    'location_street',
    [
        'label' => esc_html__('Street Address', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('Zuider IJsseldijk 46', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter street address', 'promen-elementor-widgets'),
    ]
);

$repeater->add_control(
    'location_postal_city',
    [
        'label' => esc_html__('Postal Code & City', 'promen-elementor-widgets'),
        'type' => Controls_Manager::TEXT,
        'default' => esc_html__('2808 PB Gouda', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter postal code and city', 'promen-elementor-widgets'),
    ]
);

$repeater->add_control(
    'show_location',
    [
        'label' => esc_html__('Show Location', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
    ]
);

$this->add_control(
    'locations',
    [
        'label' => esc_html__('Locations', 'promen-elementor-widgets'),
        'type' => Controls_Manager::REPEATER,
        'fields' => $repeater->get_controls(),
        'default' => [
            [
                'location_name' => esc_html__('Gouda', 'promen-elementor-widgets'),
                'location_street' => esc_html__('Zuider IJsseldijk 46', 'promen-elementor-widgets'),
                'location_postal_city' => esc_html__('2808 PB Gouda', 'promen-elementor-widgets'),
                'show_location' => 'yes',
            ],
            [
                'location_name' => esc_html__('Capelle aan de IJssel', 'promen-elementor-widgets'),
                'location_street' => esc_html__('Hoofdweg 20', 'promen-elementor-widgets'),
                'location_postal_city' => esc_html__('2908 LC Capelle aan den IJssel', 'promen-elementor-widgets'),
                'show_location' => 'yes',
            ],
        ],
        'title_field' => '{{{ location_name }}}',
    ]
);

$this->end_controls_section();

// Animation Settings
$this->start_controls_section(
    'section_animation',
    [
        'label' => esc_html__('Animation', 'promen-elementor-widgets'),
        'tab' => Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'enable_animation',
    [
        'label' => esc_html__('Enable Animation', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SWITCHER,
        'default' => 'yes',
    ]
);

$this->add_control(
    'animation_type',
    [
        'label' => esc_html__('Animation Type', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SELECT,
        'default' => 'slide-up',
        'options' => [
            'slide-up' => esc_html__('Slide Up', 'promen-elementor-widgets'),
            'slide-in' => esc_html__('Slide In', 'promen-elementor-widgets'),
            'fade-in' => esc_html__('Fade In', 'promen-elementor-widgets'),
            'scale-in' => esc_html__('Scale In', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'enable_animation' => 'yes',
        ],
    ]
);

$this->add_control(
    'animation_delay',
    [
        'label' => esc_html__('Stagger Delay (ms)', 'promen-elementor-widgets'),
        'type' => Controls_Manager::SLIDER,
        'default' => [
            'size' => 200,
        ],
        'range' => [
            'px' => [
                'min' => 0,
                'max' => 1000,
                'step' => 50,
            ],
        ],
        'condition' => [
            'enable_animation' => 'yes',
        ],
    ]
);

$this->end_controls_section(); 