<?php
/**
 * Content Section Controls
 * 
 * Controls for the slide content, including title, text, and buttons.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

trait Image_Text_Slider_Content_Controls {
    /**
     * Register content controls
     */
    protected function register_content_controls() {
        $this->start_controls_section(
            'section_slides',
            [
                'label' => esc_html__('Slides', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'show_slide',
            [
                'label' => esc_html__('Show Slide', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'show_slide' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_overlay_image',
            [
                'label' => esc_html__('Show Overlay Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'show_slide' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'overlay_image',
            [
                'label' => esc_html__('Overlay Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'show_slide' => 'yes',
                    'show_overlay_image' => 'yes',
                ],
            ]
        );

        // Add absolute overlay image controls
        $repeater->add_control(
            'show_absolute_overlay_image',
            [
                'label' => esc_html__('Show Absolute Overlay Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'show_slide' => 'yes',
                ],
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'absolute_overlay_image',
            [
                'label' => esc_html__('Absolute Overlay Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => '',
                ],
                'condition' => [
                    'show_slide' => 'yes',
                    'show_absolute_overlay_image' => 'yes',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'absolute_overlay_position',
            [
                'label' => esc_html__('Overlay Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom-right',
                'options' => [
                    'top-left' => esc_html__('Top Left', 'promen-elementor-widgets'),
                    'top-center' => esc_html__('Top Center', 'promen-elementor-widgets'),
                    'top-right' => esc_html__('Top Right', 'promen-elementor-widgets'),
                    'middle-left' => esc_html__('Middle Left', 'promen-elementor-widgets'),
                    'middle-center' => esc_html__('Middle Center', 'promen-elementor-widgets'),
                    'middle-right' => esc_html__('Middle Right', 'promen-elementor-widgets'),
                    'bottom-left' => esc_html__('Bottom Left', 'promen-elementor-widgets'),
                    'bottom-center' => esc_html__('Bottom Center', 'promen-elementor-widgets'),
                    'bottom-right' => esc_html__('Bottom Right', 'promen-elementor-widgets'),
                    'custom' => esc_html__('Custom', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_slide' => 'yes',
                    'show_absolute_overlay_image' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'absolute_overlay_extend_beyond',
            [
                'label' => esc_html__('Extend Beyond Boundaries', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Allows image to extend beyond slide boundaries and overflow the divider', 'promen-elementor-widgets'),
                'condition' => [
                    'show_slide' => 'yes',
                    'show_absolute_overlay_image' => 'yes',
                ],
                'prefix_class' => 'overlay-extend-',
            ]
        );

        $repeater->add_responsive_control(
            'absolute_overlay_width',
            [
                'label' => esc_html__('Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 1000,
                        'step' => 5,
                    ],
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 30,
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .absolute-overlay-image' => 'width: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_slide' => 'yes',
                    'show_absolute_overlay_image' => 'yes',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'absolute_overlay_custom_position_top',
            [
                'label' => esc_html__('Top Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .absolute-overlay-image' => 'top: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_slide' => 'yes',
                    'show_absolute_overlay_image' => 'yes',
                    'absolute_overlay_position' => 'custom',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'absolute_overlay_custom_position_left',
            [
                'label' => esc_html__('Left Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -500,
                        'max' => 500,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .absolute-overlay-image' => 'left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_slide' => 'yes',
                    'show_absolute_overlay_image' => 'yes',
                    'absolute_overlay_position' => 'custom',
                ],
            ]
        );

        $repeater->add_responsive_control(
            'absolute_overlay_z_index',
            [
                'label' => esc_html__('Z-Index', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => -10,
                'max' => 100,
                'step' => 1,
                'default' => 10,
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .absolute-overlay-image' => 'z-index: {{VALUE}} !important;',
                ],
                'condition' => [
                    'show_slide' => 'yes',
                    'show_absolute_overlay_image' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'image_position',
            [
                'label' => esc_html__('Image Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'center center',
                'options' => [
                    'center center' => esc_html__('Center Center', 'promen-elementor-widgets'),
                    'center left' => esc_html__('Center Left', 'promen-elementor-widgets'),
                    'center right' => esc_html__('Center Right', 'promen-elementor-widgets'),
                    'top center' => esc_html__('Top Center', 'promen-elementor-widgets'),
                    'top left' => esc_html__('Top Left', 'promen-elementor-widgets'),
                    'top right' => esc_html__('Top Right', 'promen-elementor-widgets'),
                    'bottom center' => esc_html__('Bottom Center', 'promen-elementor-widgets'),
                    'bottom left' => esc_html__('Bottom Left', 'promen-elementor-widgets'),
                    'bottom right' => esc_html__('Bottom Right', 'promen-elementor-widgets'),
                ],
                'selectors' => [
                    '{{WRAPPER}} {{CURRENT_ITEM}} .slide-image img' => 'object-position: {{VALUE}};',
                ],
                'condition' => [
                    'background_image[url]!' => '',
                ],
            ]
        );

        $repeater->add_control(
            'image_size',
            [
                'label' => esc_html__('Image Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'full',
                'options' => $this->get_image_sizes(),
                'condition' => [
                    'background_image[url]!' => '',
                ],
            ]
        );

        $repeater->add_control(
            'content_heading',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'show_back_link',
            [
                'label' => esc_html__('Show Back Link', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $repeater->add_control(
            'back_link_text',
            [
                'label' => esc_html__('Back Link Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Terug naar overzicht', 'promen-elementor-widgets'),
                'condition' => [
                    'show_back_link' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'back_link_url',
            [
                'label' => esc_html__('Back Link URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'show_external' => true,
                'default' => [
                    'url' => '',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'condition' => [
                    'show_back_link' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_publication_date',
            [
                'label' => esc_html__('Show Publication Date', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'description' => esc_html__('Displays the post publication date automatically', 'promen-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'title_text',
            [
                'label' => esc_html__('Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Werken met Promen', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_title' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
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
                    'show_title' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_content',
            [
                'label' => esc_html__('Show Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'content',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => esc_html__('De juiste balans tussen dagelijks werk en leven en tijd besteden met je gezin. 100 locaties.', 'promen-elementor-widgets'),
                'condition' => [
                    'show_content' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'buttons_heading',
            [
                'label' => esc_html__('Buttons', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $repeater->add_control(
            'show_button_1',
            [
                'label' => esc_html__('Show Button 1', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'button_1_text',
            [
                'label' => esc_html__('Button 1 Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Meer informatie', 'promen-elementor-widgets'),
                'condition' => [
                    'show_button_1' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_1_link',
            [
                'label' => esc_html__('Button 1 Link', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_button_1' => 'yes',
                ],
            ]
        );

        $repeater->add_control(
            'show_button_2',
            [
                'label' => esc_html__('Show Button 2', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $repeater->add_control(
            'button_2_text',
            [
                'label' => esc_html__('Button 2 Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Bekijkportfolio', 'promen-elementor-widgets'),
                'condition' => [
                    'show_button_2' => 'yes',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'button_2_link',
            [
                'label' => esc_html__('Button 2 Link', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '#',
                ],
                'condition' => [
                    'show_button_2' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'slides',
            [
                'label' => esc_html__('Slides', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'show_slide' => 'yes',
                        'show_back_link' => 'no',
                        'show_publication_date' => 'no',
                        'title_text' => esc_html__('Werken met Promen', 'promen-elementor-widgets'),
                        'content' => esc_html__('De juiste balans tussen dagelijks werk en leven en tijd besteden met je gezin. 100 locaties.', 'promen-elementor-widgets'),
                        'button_1_text' => esc_html__('Meer informatie', 'promen-elementor-widgets'),
                        'button_2_text' => esc_html__('Bekijkportfolio', 'promen-elementor-widgets'),
                    ],
                    [
                        'show_slide' => 'yes',
                        'show_back_link' => 'no',
                        'show_publication_date' => 'no',
                        'title_text' => esc_html__('Slide #2', 'promen-elementor-widgets'),
                        'content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'promen-elementor-widgets'),
                        'button_1_text' => esc_html__('Learn More', 'promen-elementor-widgets'),
                        'button_2_text' => esc_html__('Contact Us', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ title_text }}}',
            ]
        );

        $this->end_controls_section();
        
        // Breadcrumb Controls Section
        $this->start_controls_section(
            'section_breadcrumb',
            [
                'label' => esc_html__('Breadcrumb', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );
        
        $this->add_control(
            'show_breadcrumb',
            [
                'label' => esc_html__('Show Breadcrumb', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        
        $this->add_control(
            'breadcrumb_position',
            [
                'label' => esc_html__('Breadcrumb Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'above',
                'options' => [
                    'above' => esc_html__('Above Content Container', 'promen-elementor-widgets'),
                    'below' => esc_html__('Below Content Container', 'promen-elementor-widgets'),
                    'overlay' => esc_html__('Overlay on Content Container', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_breadcrumb' => 'yes',
                ],
            ]
        );
        
        $this->add_control(
            'breadcrumb_separator',
            [
                'label' => esc_html__('Separator', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '›',
                'condition' => [
                    'show_breadcrumb' => 'yes',
                ],
            ]
        );
        
        $this->end_controls_section();
    }
} 