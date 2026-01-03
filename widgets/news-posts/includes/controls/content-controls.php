<?php
/**
 * Content Controls for News Posts Widget
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Post Type Section
$this->start_controls_section(
    'section_post_type',
    [
        'label' => esc_html__('Content Source', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

$this->add_control(
    'post_type',
    [
        'label' => esc_html__('Post Type', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'post',
        'options' => [
            'post' => esc_html__('Posts', 'promen-elementor-widgets'),
            'succesvolle-verhalen' => esc_html__('Succesvolle Verhalen', 'promen-elementor-widgets'),
            'vacatures' => esc_html__('Vacatures', 'promen-elementor-widgets'),
        ],
    ]
);

// Content Selection Method
$this->add_control(
    'content_selection',
    [
        'label' => esc_html__('Content Selection', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'automatic',
        'options' => [
            'automatic' => esc_html__('Automatic (Latest Posts)', 'promen-elementor-widgets'),
            'taxonomy' => esc_html__('By Taxonomy', 'promen-elementor-widgets'),
            'manual' => esc_html__('Manual Selection', 'promen-elementor-widgets'),
        ],
    ]
);

$this->add_control(
    'posts_per_page',
    [
        'label' => esc_html__('Number of Posts', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 1,
        'max' => 12,
        'step' => 1,
        'default' => 3,
        'condition' => [
            'content_selection!' => 'manual',
        ],
    ]
);

// Dynamic Taxonomy Selection
$this->add_control(
    'selected_taxonomy',
    [
        'label' => esc_html__('Select Taxonomy', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => '',
        'options' => $this->get_available_taxonomies(),
        'condition' => [
            'content_selection' => 'taxonomy',
        ],
    ]
);

// Taxonomy Terms Selection
$this->add_control(
    'selected_terms',
    [
        'label' => esc_html__('Select Terms', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => true,
        'options' => $this->get_available_terms(),
        'label_block' => true,
        'description' => esc_html__('Leave empty to show posts from all terms in the selected taxonomy', 'promen-elementor-widgets'),
        'condition' => [
            'content_selection' => 'taxonomy',
            'selected_taxonomy!' => '',
        ],
    ]
);

// Manual Post Selection
$this->add_control(
    'selected_posts',
    [
        'label' => esc_html__('Select Posts', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT2,
        'multiple' => true,
        'options' => $this->get_available_posts(),
        'label_block' => true,
        'description' => esc_html__('Search and select specific posts to display', 'promen-elementor-widgets'),
        'condition' => [
            'content_selection' => 'manual',
        ],
    ]
);

// Order and Sort Options for Automatic and Taxonomy selections
$this->add_control(
    'orderby',
    [
        'label' => esc_html__('Order By', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'date',
        'options' => [
            'date' => esc_html__('Date', 'promen-elementor-widgets'),
            'title' => esc_html__('Title', 'promen-elementor-widgets'),
            'menu_order' => esc_html__('Menu Order', 'promen-elementor-widgets'),
            'rand' => esc_html__('Random', 'promen-elementor-widgets'),
            'comment_count' => esc_html__('Comment Count', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'content_selection!' => 'manual',
        ],
    ]
);

$this->add_control(
    'order',
    [
        'label' => esc_html__('Order', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'DESC',
        'options' => [
            'ASC' => esc_html__('Ascending', 'promen-elementor-widgets'),
            'DESC' => esc_html__('Descending', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'content_selection!' => 'manual',
            'orderby!' => 'rand',
        ],
    ]
);

$this->add_control(
    'excerpt_length',
    [
        'label' => esc_html__('Excerpt Length (characters)', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::NUMBER,
        'min' => 10,
        'max' => 500,
        'step' => 10,
        'default' => 120,
        'description' => esc_html__('Set the maximum number of characters for the excerpt', 'promen-elementor-widgets'),
    ]
);

// Add taxonomy filter for vacatures
$this->add_control(
    'show_vacature_filter',
    [
        'label' => esc_html__('Show Frontend Category Filters', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'no',
        'condition' => [
            'post_type' => 'vacatures',
        ],
    ]
);

$this->add_control(
    'filter_all_text',
    [
        'label' => esc_html__('All Items Text', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Alle vacatures', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter text for "All" filter button', 'promen-elementor-widgets'),
        'condition' => [
            'post_type' => 'vacatures',
            'show_vacature_filter' => 'yes',
        ],
    ]
);

$this->add_control(
    'filter_alignment',
    [
        'label' => esc_html__('Filter Alignment', 'promen-elementor-widgets'),
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
        'toggle' => true,
        'selectors' => [
            '{{WRAPPER}} .content-filter-buttons' => 'text-align: {{VALUE}};',
        ],
        'condition' => [
            'post_type' => 'vacatures',
            'show_vacature_filter' => 'yes',
        ],
    ]
);

$this->add_control(
    'filter_spacing',
    [
        'label' => esc_html__('Filter Spacing', 'promen-elementor-widgets'),
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
        'default' => [
            'unit' => 'px',
            'size' => 30,
        ],
        'selectors' => [
            '{{WRAPPER}} .content-filter-buttons' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        'condition' => [
            'post_type' => 'vacatures',
            'show_vacature_filter' => 'yes',
        ],
    ]
);

$this->end_controls_section();

// Content Section
$this->start_controls_section(
    'section_content',
    [
        'label' => esc_html__('Content', 'promen-elementor-widgets'),
        'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
    ]
);

// Use the standardized split title controls
promen_add_split_title_controls(
    $this, 
    'section_content', 
    [], 
    esc_html__('Blijf op de hoogte met het laatste Nieuws', 'promen-elementor-widgets'),
    'section_title'
);

$this->add_control(
    'show_section_title',
    [
        'label' => esc_html__('Show Section Title', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'show_header_button',
    [
        'label' => esc_html__('Show Header Button', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'header_button_text',
    [
        'label' => esc_html__('Header Button Text', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Meer nieuws', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter button text', 'promen-elementor-widgets'),
        'dynamic' => [
            'active' => true,
        ],
        'condition' => [
            'show_header_button' => 'yes',
        ],
    ]
);

$this->add_control(
    'header_button_icon',
    [
        'label' => esc_html__('Icon', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-arrow-right',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_header_button' => 'yes',
        ],
    ]
);

$this->add_control(
    'header_button_icon_position',
    [
        'label' => esc_html__('Icon Position', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'after',
        'options' => [
            'before' => esc_html__('Before', 'promen-elementor-widgets'),
            'after' => esc_html__('After', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'show_header_button' => 'yes',
            'header_button_icon[value]!' => '',
        ],
    ]
);

$this->add_control(
    'header_button_url',
    [
        'label' => esc_html__('Header Button URL', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
        'default' => [
            'url' => '#',
            'is_external' => false,
            'nofollow' => false,
        ],
        'dynamic' => [
            'active' => true,
        ],
        'condition' => [
            'show_header_button' => 'yes',
        ],
    ]
);

$this->add_control(
    'show_footer_button',
    [
        'label' => esc_html__('Show Footer Button', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SWITCHER,
        'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
        'label_off' => esc_html__('No', 'promen-elementor-widgets'),
        'return_value' => 'yes',
        'default' => 'yes',
    ]
);

$this->add_control(
    'footer_button_text',
    [
        'label' => esc_html__('Footer Button Text', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Meer nieuws', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter button text', 'promen-elementor-widgets'),
        'dynamic' => [
            'active' => true,
        ],
        'condition' => [
            'show_footer_button' => 'yes',
        ],
    ]
);

$this->add_control(
    'footer_button_icon',
    [
        'label' => esc_html__('Icon', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-arrow-right',
            'library' => 'fa-solid',
        ],
        'condition' => [
            'show_footer_button' => 'yes',
        ],
    ]
);

$this->add_control(
    'footer_button_icon_position',
    [
        'label' => esc_html__('Icon Position', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'after',
        'options' => [
            'before' => esc_html__('Before', 'promen-elementor-widgets'),
            'after' => esc_html__('After', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'show_footer_button' => 'yes',
            'footer_button_icon[value]!' => '',
        ],
    ]
);

$this->add_control(
    'footer_button_url',
    [
        'label' => esc_html__('Footer Button URL', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::URL,
        'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
        'default' => [
            'url' => '#',
            'is_external' => false,
            'nofollow' => false,
        ],
        'dynamic' => [
            'active' => true,
        ],
        'condition' => [
            'show_footer_button' => 'yes',
        ],
    ]
);

$this->add_control(
    'read_more_text',
    [
        'label' => esc_html__('Read More Text', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::TEXT,
        'default' => esc_html__('Lees meer', 'promen-elementor-widgets'),
        'placeholder' => esc_html__('Enter read more text', 'promen-elementor-widgets'),
        'dynamic' => [
            'active' => true,
        ],
        'condition' => [
            'show_footer_button' => 'yes',
        ],
    ]
);

$this->add_control(
    'read_more_icon',
    [
        'label' => esc_html__('Read More Icon', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::ICONS,
        'default' => [
            'value' => 'fas fa-arrow-right',
            'library' => 'fa-solid',
        ],
    ]
);

$this->add_control(
    'read_more_icon_position',
    [
        'label' => esc_html__('Icon Position', 'promen-elementor-widgets'),
        'type' => \Elementor\Controls_Manager::SELECT,
        'default' => 'after',
        'options' => [
            'before' => esc_html__('Before', 'promen-elementor-widgets'),
            'after' => esc_html__('After', 'promen-elementor-widgets'),
        ],
        'condition' => [
            'read_more_icon[value]!' => '',
        ],
    ]
);

$this->end_controls_section(); 