<?php
/**
 * Text Content Block Widget Content Controls
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Text_Content_Block_Content_Controls {

    /**
     * Register content controls for the widget
     */
    public static function register_controls($widget) {
        self::register_heading_section($widget);
        self::register_content_section($widget);
        self::register_list_section($widget);
        self::register_blockquote_section($widget);
        self::register_flexible_content_section($widget);
        self::register_additional_text_section($widget);
        self::register_social_sharing_section($widget);
        self::register_contact_sidebar_section($widget);
        self::register_job_vacancy_section($widget);
        self::register_newsletter_section($widget);
        self::register_layout_settings_section($widget);
    }

    /**
     * Register heading section controls
     */
    private static function register_heading_section($widget) {
        $widget->start_controls_section(
            'section_heading',
            [
                'label' => esc_html__('Heading', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_heading',
            [
                'label' => esc_html__('Show Heading', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Split Title Control
        $widget->add_control(
            'heading_text',
            [
                'label' => esc_html__('Heading Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Koptekst 2', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter your heading', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'heading_tag',
            [
                'label' => esc_html__('Heading Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'show_heading' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register content section controls
     */
    private static function register_content_section($widget) {
        $widget->start_controls_section(
            'section_content',
            [
                'label' => esc_html__('Main Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'content_view_type',
            [
                'label' => esc_html__('Content View Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'standard',
                'options' => [
                    'standard' => esc_html__('Standard Text Content', 'promen-elementor-widgets'),
                    'flexible' => esc_html__('Flexible Content', 'promen-elementor-widgets'),
                ],
                'description' => esc_html__('Choose between standard text content or flexible content with images.', 'promen-elementor-widgets'),
            ]
        );

        $widget->add_control(
            'show_main_content',
            [
                'label' => esc_html__('Show Main Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->add_control(
            'main_content',
            [
                'label' => esc_html__('Main Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '<p>Mi tincidunt elit, id aliquip feugiat lacinia ac diam, amet. Vel etiam suspendisse morbi eleifend facilisis eget vestibulum felis. Dictum quis montes, sit sit. Tellus aliquam urna urna, oriam. Mauris posuere vulputate arcu amet, vitae nisl. Nibh tincidunt, at feugiat sapien varius id.</p><p>Eget quam in enim, leo luctus pharetra, semper. Eget in vulputate mauris et volutpat lectus velit, sed auctor. Porttitor fames arcu quis fusce augue enim. Quis at habitant mauris at. Semper vulputate volutpat, at ac volutpat.</p>',
                'placeholder' => esc_html__('Enter your content', 'promen-elementor-widgets'),
                'condition' => [
                    'show_main_content' => 'yes',
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register list section controls
     */
    private static function register_list_section($widget) {
        $widget->start_controls_section(
            'section_list',
            [
                'label' => esc_html__('List Items', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->add_control(
            'show_list',
            [
                'label' => esc_html__('Show List', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'list_type',
            [
                'label' => esc_html__('List Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bullet',
                'options' => [
                    'bullet' => esc_html__('Bullet', 'promen-elementor-widgets'),
                    'numbered' => esc_html__('Numbered', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_list' => 'yes',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'list_item_text',
            [
                'label' => esc_html__('List Item', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('List item', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter list item text', 'promen-elementor-widgets'),
                'label_block' => true,
            ]
        );

        $widget->add_control(
            'list_items',
            [
                'label' => esc_html__('List Items', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'list_item_text' => esc_html__('Et nisi in eleifend sed nisi. Pulvinar at orci, proin imperdiet commodo consectetur convallis risus.', 'promen-elementor-widgets'),
                    ],
                    [
                        'list_item_text' => esc_html__('Sed consectetur neque dignissim faucibus adipiscing faucibus consequat urna.', 'promen-elementor-widgets'),
                    ],
                    [
                        'list_item_text' => esc_html__('Viverra purus et eget auctor aliquam. Risus, volutpat vulputate posuere purus sit congue convallis aliquet.', 'promen-elementor-widgets'),
                    ],
                    [
                        'list_item_text' => esc_html__('Mauris, neque ultricies eu vestibulum, bibendum quam lorem id.', 'promen-elementor-widgets'),
                    ],
                    [
                        'list_item_text' => esc_html__('Dolor lacus, eget nunc lectus in tellus, pharetra, porttitor.', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ list_item_text }}}',
                'condition' => [
                    'show_list' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register blockquote section controls
     */
    private static function register_blockquote_section($widget) {
        $widget->start_controls_section(
            'section_blockquote',
            [
                'label' => esc_html__('Blockquote', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->add_control(
            'show_blockquote',
            [
                'label' => esc_html__('Show Blockquote', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'blockquote_content',
            [
                'label' => esc_html__('Blockquote Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Ipsum sit mattis nulla quam nulla. Gravida id gravida ac enim mauris id. Non pellentesque congue eget consectetur turpis. Sapien, dictum molestie sem tempor. Diam elit, orci, tincidunt aenean tempus.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter blockquote content', 'promen-elementor-widgets'),
                'rows' => 5,
                'condition' => [
                    'show_blockquote' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register flexible content section controls
     */
    private static function register_flexible_content_section($widget) {
        $widget->start_controls_section(
            'section_flexible_content',
            [
                'label' => esc_html__('Flexible Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'content_view_type' => 'flexible',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'content_type',
            [
                'label' => esc_html__('Content Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'text',
                'options' => [
                    'text' => esc_html__('Text', 'promen-elementor-widgets'),
                    'heading' => esc_html__('Heading', 'promen-elementor-widgets'),
                    'image' => esc_html__('Image', 'promen-elementor-widgets'),
                    'video' => esc_html__('Video', 'promen-elementor-widgets'),
                    'blockquote' => esc_html__('Blockquote', 'promen-elementor-widgets'),
                    'spacer' => esc_html__('Spacer', 'promen-elementor-widgets'),
                    'collapsible' => esc_html__('Collapsible tekstblok', 'promen-elementor-widgets'),
                ],
            ]
        );

        $repeater->add_control(
            'heading_text',
            [
                'label' => esc_html__('Heading Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Section Heading', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter heading text', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'content_type' => 'heading',
                ],
            ]
        );

        $repeater->add_control(
            'heading_tag',
            [
                'label' => esc_html__('Heading Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h2',
                'options' => [
                    'h1' => 'H1',
                    'h2' => 'H2',
                    'h3' => 'H3',
                    'h4' => 'H4',
                    'h5' => 'H5',
                    'h6' => 'H6',
                ],
                'condition' => [
                    'content_type' => 'heading',
                ],
            ]
        );

        $repeater->add_control(
            'text_content',
            [
                'label' => esc_html__('Text Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '<p>Your content goes here...</p>',
                'placeholder' => esc_html__('Enter your text', 'promen-elementor-widgets'),
                'condition' => [
                    'content_type' => 'text',
                ],
            ]
        );

        $repeater->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'content_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
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
                'condition' => [
                    'content_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'image_alignment',
            [
                'label' => esc_html__('Image Alignment', 'promen-elementor-widgets'),
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
                'condition' => [
                    'content_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'image_caption',
            [
                'label' => esc_html__('Caption', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('Enter your image caption', 'promen-elementor-widgets'),
                'condition' => [
                    'content_type' => 'image',
                ],
            ]
        );

        $repeater->add_control(
            'spacer_height',
            [
                'label' => esc_html__('Spacer Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 200,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 20,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 40,
                ],
                'condition' => [
                    'content_type' => 'spacer',
                ],
            ]
        );

        $repeater->add_control(
            'blockquote_content',
            [
                'label' => esc_html__('Blockquote Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Ipsum sit mattis nulla quam nulla. Gravida id gravida ac enim mauris id. Non pellentesque congue eget consectetur turpis.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter blockquote content', 'promen-elementor-widgets'),
                'rows' => 5,
                'condition' => [
                    'content_type' => 'blockquote',
                ],
            ]
        );
        
        $repeater->add_control(
            'blockquote_show_quotes',
            [
                'label' => esc_html__('Show Quote Marks', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'content_type' => 'blockquote',
                ],
            ]
        );

        $repeater->add_control(
            'collapsible_title',
            [
                'label' => esc_html__('Collapsible titel', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Meer informatie', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Titel voor het uitklapblok', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'content_type' => 'collapsible',
                ],
            ]
        );

        $repeater->add_control(
            'collapsible_document',
            [
                'label' => esc_html__('Bron document', 'promen-elementor-widgets'),
                'description' => esc_html__('Ondersteunt .docx, .txt, .md, .html bestanden. Alleen de tekst wordt uit het document geëxtraheerd, zonder formatting.', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'application',
                'condition' => [
                    'content_type' => 'collapsible',
                ],
            ]
        );

        $repeater->add_control(
            'collapsible_manual_text',
            [
                'label' => esc_html__('Handmatige tekst (fallback)', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'placeholder' => esc_html__('Voeg een fallback tekst toe als het document leeg is.', 'promen-elementor-widgets'),
                'condition' => [
                    'content_type' => 'collapsible',
                ],
            ]
        );

        $repeater->add_control(
            'collapsible_default_state',
            [
                'label' => esc_html__('Startstatus', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'collapsed' => esc_html__('Ingeklapt', 'promen-elementor-widgets'),
                    'expanded' => esc_html__('Uitgeklapt', 'promen-elementor-widgets'),
                ],
                'default' => 'collapsed',
                'condition' => [
                    'content_type' => 'collapsible',
                ],
            ]
        );

        // Video Content Type Controls
        $repeater->add_control(
            'video_type',
            [
                'label' => esc_html__('Video Type', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'youtube',
                'options' => [
                    'youtube' => esc_html__('YouTube', 'promen-elementor-widgets'),
                    'vimeo' => esc_html__('Vimeo', 'promen-elementor-widgets'),
                    'hosted' => esc_html__('Self Hosted', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'content_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'youtube_url',
            [
                'label' => esc_html__('YouTube URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('https://www.youtube.com/watch?v=XHOmBV4js_E', 'promen-elementor-widgets'),
                'default' => '',
                'label_block' => true,
                'condition' => [
                    'content_type' => 'video',
                    'video_type' => 'youtube',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'vimeo_url',
            [
                'label' => esc_html__('Vimeo URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'placeholder' => esc_html__('https://vimeo.com/235215203', 'promen-elementor-widgets'),
                'default' => '',
                'label_block' => true,
                'condition' => [
                    'content_type' => 'video',
                    'video_type' => 'vimeo',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'hosted_video',
            [
                'label' => esc_html__('Video File', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'video',
                'condition' => [
                    'content_type' => 'video',
                    'video_type' => 'hosted',
                ],
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $repeater->add_control(
            'video_poster',
            [
                'label' => esc_html__('Poster', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'condition' => [
                    'content_type' => 'video',
                    'video_type' => 'hosted',
                ],
            ]
        );

        $repeater->add_control(
            'video_autoplay',
            [
                'label' => esc_html__('Autoplay', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'content_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_loop',
            [
                'label' => esc_html__('Loop', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'content_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_controls',
            [
                'label' => esc_html__('Controls', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'content_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_mute',
            [
                'label' => esc_html__('Mute', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'content_type' => 'video',
                ],
            ]
        );

        $repeater->add_control(
            'video_ratio',
            [
                'label' => esc_html__('Aspect Ratio', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    '169' => '16:9',
                    '219' => '21:9',
                    '43' => '4:3',
                    '32' => '3:2',
                    '11' => '1:1',
                ],
                'default' => '169',
                'condition' => [
                    'content_type' => 'video',
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__flexible-video .elementor-video-container' => 'padding-bottom: calc( 100% * var(--aspect-ratio) );',
                ],
                'selectors_dictionary' => [
                    '169' => '0.5625',
                    '219' => '0.4285',
                    '43' => '0.75',
                    '32' => '0.6666',
                    '11' => '1',
                ],
            ]
        );

        $widget->add_control(
            'flexible_content_items',
            [
                'label' => esc_html__('Content Items', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'content_type' => 'heading',
                        'heading_text' => esc_html__('Section Heading', 'promen-elementor-widgets'),
                        'heading_tag' => 'h2',
                    ],
                    [
                        'content_type' => 'text',
                        'text_content' => '<p>Your content goes here. Add images, videos or text in any order you prefer.</p>',
                    ],
                    [
                        'content_type' => 'image',
                        'image' => [
                            'url' => \Elementor\Utils::get_placeholder_image_src(),
                        ],
                        'image_alignment' => 'center',
                    ],
                    [
                        'content_type' => 'video',
                        'video_type' => 'youtube',
                        'youtube_url' => 'https://www.youtube.com/watch?v=XHOmBV4js_E',
                        'video_controls' => 'yes',
                        'video_ratio' => '169',
                    ],
                    [
                        'content_type' => 'blockquote',
                        'blockquote_content' => 'Ipsum sit mattis nulla quam nulla. Gravida id gravida ac enim mauris id. Non pellentesque congue eget consectetur turpis.',
                        'blockquote_show_quotes' => 'no',
                    ],
                ],
                'title_field' => '{{{ content_type.charAt(0).toUpperCase() + content_type.slice(1) + (content_type === "heading" ? ": " + heading_text : "") }}}',
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register additional text section controls
     */
    private static function register_additional_text_section($widget) {
        $widget->start_controls_section(
            'section_additional_text',
            [
                'label' => esc_html__('Additional Text', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'content_view_type' => 'standard',
                ],
            ]
        );

        $widget->add_control(
            'show_additional_text',
            [
                'label' => esc_html__('Show Additional Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'additional_text',
            [
                'label' => esc_html__('Additional Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::WYSIWYG,
                'default' => '<p>Tristique odio senectus nam posuere ornare leo metus, ultricies. Blandit duis ultricies vulputate morbi feugiat cras placerat elit. Aliquam tellus lorem sed ac. Montes, sed mattis pellentesque suscipit accumsan. Cursus viverra aenean magna risus elementum faucibus molestie pellentesque. Arcu ultricies sed mauris vestibulum.</p>',
                'placeholder' => esc_html__('Enter additional text', 'promen-elementor-widgets'),
                'condition' => [
                    'show_additional_text' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register social sharing section controls
     */
    private static function register_social_sharing_section($widget) {
        $widget->start_controls_section(
            'section_social_sharing',
            [
                'label' => esc_html__('Social Sharing', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_social_sharing',
            [
                'label' => esc_html__('Show Social Sharing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $widget->add_control(
            'sharing_title',
            [
                'label' => esc_html__('Sharing Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Deel dit artikel:', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter sharing title', 'promen-elementor-widgets'),
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'sharing_position',
            [
                'label' => esc_html__('Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'bottom',
                'options' => [
                    'top' => esc_html__('Top', 'promen-elementor-widgets'),
                    'bottom' => esc_html__('Bottom', 'promen-elementor-widgets'),
                    'both' => esc_html__('Both Top and Bottom', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'sharing_alignment',
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
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__social-sharing' => 'text-align: {{VALUE}};',
                ],
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'social_networks_heading',
            [
                'label' => esc_html__('Social Networks', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'share_facebook',
            [
                'label' => esc_html__('Facebook', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'share_twitter',
            [
                'label' => esc_html__('Twitter/X', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'share_linkedin',
            [
                'label' => esc_html__('LinkedIn', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'share_whatsapp',
            [
                'label' => esc_html__('WhatsApp', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'share_email',
            [
                'label' => esc_html__('Email', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 12,
                        'max' => 48,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 4,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 4,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 18,
                ],
                'selectors' => [
                    '{{WRAPPER}} .social-sharing-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 15,
                ],
                'selectors' => [
                    '{{WRAPPER}} .social-share-item:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'show_social_sharing' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register contact sidebar section controls
     */
    private static function register_contact_sidebar_section($widget) {
        $widget->start_controls_section(
            'section_contact_sidebar',
            [
                'label' => esc_html__('Contact Sidebar', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // General Settings
        $widget->add_control(
            'sidebar_general_heading',
            [
                'label' => esc_html__('General Settings', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $widget->add_control(
            'show_contact_sidebar',
            [
                'label' => esc_html__('Show Contact Sidebar', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $widget->add_control(
            'sidebar_position',
            [
                'label' => esc_html__('Sidebar Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'right',
                'options' => [
                    'right' => esc_html__('Right', 'promen-elementor-widgets'),
                    'left' => esc_html__('Left', 'promen-elementor-widgets'),
                ],
                'prefix_class' => 'promen-sidebar-position-',
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'sidebar_sticky',
            [
                'label' => esc_html__('Sticky Sidebar', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        // Contact Info Section
        $widget->add_control(
            'contact_info_separator',
            [
                'type' => \Elementor\Controls_Manager::DIVIDER,
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'contact_info_heading',
            [
                'label' => esc_html__('Contact Information', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'sidebar_title',
            [
                'label' => esc_html__('Sidebar Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Wil je meer weten?', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter sidebar title', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'sidebar_title_tag',
            [
                'label' => esc_html__('Title HTML Tag', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'h4',
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
                    'show_contact_sidebar' => 'yes',
                    'sidebar_title!' => '',
                ],
            ]
        );

        $widget->add_control(
            'contact_person_label',
            [
                'label' => esc_html__('Contact Person Label', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('<naam medewerker>', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter contact person label', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'contact_email',
            [
                'label' => esc_html__('Email Address', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('info@promen.nl', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter email address', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'contact_phone',
            [
                'label' => esc_html__('Phone Number', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('088 - 98 99 000', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter phone number', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'contact_image',
            [
                'label' => esc_html__('Contact Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register job vacancy section controls
     */
    private static function register_job_vacancy_section($widget) {
        $widget->start_controls_section(
            'section_job_vacancy',
            [
                'label' => esc_html__('Job Vacancy', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_job_vacancies',
            [
                'label' => esc_html__('Show Job Vacancies', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $widget->add_control(
            'job_vacancy_section_title',
            [
                'label' => esc_html__('Section Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Vacature in het kort', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter section title', 'promen-elementor-widgets'),
                'condition' => [
                    'show_job_vacancies' => 'yes',
                ],
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'vacancy_label',
            [
                'label' => esc_html__('Label', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Functie', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter label', 'promen-elementor-widgets'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'vacancy_value',
            [
                'label' => esc_html__('Value', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Communicatie specialist', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter value', 'promen-elementor-widgets'),
                'label_block' => true,
            ]
        );

        $widget->add_control(
            'job_vacancy_items',
            [
                'label' => esc_html__('Vacancy Details', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'vacancy_label' => esc_html__('Functie', 'promen-elementor-widgets'),
                        'vacancy_value' => esc_html__('Communicatie specialist', 'promen-elementor-widgets'),
                    ],
                    [
                        'vacancy_label' => esc_html__('Uren per week', 'promen-elementor-widgets'),
                        'vacancy_value' => esc_html__('38 uur', 'promen-elementor-widgets'),
                    ],
                    [
                        'vacancy_label' => esc_html__('Opleidingsniveau', 'promen-elementor-widgets'),
                        'vacancy_value' => esc_html__('MBO', 'promen-elementor-widgets'),
                    ],
                    [
                        'vacancy_label' => esc_html__('Locatie', 'promen-elementor-widgets'),
                        'vacancy_value' => esc_html__('Gouda', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ vacancy_label }}}: {{{ vacancy_value }}}',
                'condition' => [
                    'show_job_vacancies' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_button_text',
            [
                'label' => esc_html__('Button Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Solliciteer direct', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter button text', 'promen-elementor-widgets'),
                'condition' => [
                    'show_job_vacancies' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_button_link',
            [
                'label' => esc_html__('Button Link', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => true,
                ],
                'condition' => [
                    'show_job_vacancies' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'job_vacancy_bg_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e8f5f9',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__job-vacancy' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_job_vacancies' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register newsletter section controls
     */
    private static function register_newsletter_section($widget) {
        $widget->start_controls_section(
            'section_newsletter',
            [
                'label' => esc_html__('Newsletter Form', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $widget->add_control(
            'show_newsletter_form',
            [
                'label' => esc_html__('Show Newsletter Form', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $widget->add_control(
            'newsletter_title',
            [
                'label' => esc_html__('Newsletter Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Schrijf je in voor onze nieuwsbrief', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter newsletter title', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_newsletter_form' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'privacy_note',
            [
                'label' => esc_html__('Privacy Note', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Bij het inschrijven ga je akkoord met onze Privacyverklaring', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter privacy note', 'promen-elementor-widgets'),
                'label_block' => true,
                'condition' => [
                    'show_newsletter_form' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'privacy_link',
            [
                'label' => esc_html__('Privacy Policy URL', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => true,
                ],
                'condition' => [
                    'show_newsletter_form' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'subscribe_button_text',
            [
                'label' => esc_html__('Subscribe Button Text', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Schrijf je in', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter button text', 'promen-elementor-widgets'),
                'condition' => [
                    'show_newsletter_form' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'gravity_form_id',
            [
                'label' => esc_html__('Gravity Form ID', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'placeholder' => esc_html__('Enter form ID', 'promen-elementor-widgets'),
                'description' => esc_html__('Enter the Gravity Form ID for newsletter signup. This form should have a single email field.', 'promen-elementor-widgets'),
                'condition' => [
                    'show_newsletter_form' => 'yes',
                ],
            ]
        );

        $widget->add_control(
            'newsletter_bg_color',
            [
                'label' => esc_html__('Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#e6f0f4',
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__newsletter' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'show_newsletter_form' => 'yes',
                ],
            ]
        );

        $widget->end_controls_section();
    }

    /**
     * Register layout settings section
     */
    private static function register_layout_settings_section($widget) {
        $widget->start_controls_section(
            'section_layout_settings',
            [
                'label' => esc_html__('Sidebar Layout', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        // Description
        $widget->add_control(
            'sidebar_layout_description',
            [
                'type' => \Elementor\Controls_Manager::RAW_HTML,
                'raw' => esc_html__('Control the order and position of sidebar elements.', 'promen-elementor-widgets'),
                'content_classes' => 'elementor-descriptor',
            ]
        );

        // Contact position
        $widget->add_control(
            'contact_position',
            [
                'label' => esc_html__('Contact Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('First', 'promen-elementor-widgets'),
                    '2' => esc_html__('Second', 'promen-elementor-widgets'),
                    '3' => esc_html__('Third', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_contact_sidebar' => 'yes',
                ],
            ]
        );

        // Job vacancy position (if enabled)
        $widget->add_control(
            'job_vacancy_position',
            [
                'label' => esc_html__('Job Vacancy Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '2',
                'options' => [
                    '1' => esc_html__('First', 'promen-elementor-widgets'),
                    '2' => esc_html__('Second', 'promen-elementor-widgets'),
                    '3' => esc_html__('Third', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_job_vacancies' => 'yes',
                ],
            ]
        );

        // Newsletter position (if enabled)
        $widget->add_control(
            'newsletter_position',
            [
                'label' => esc_html__('Newsletter Position', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => esc_html__('First', 'promen-elementor-widgets'),
                    '2' => esc_html__('Second', 'promen-elementor-widgets'),
                    '3' => esc_html__('Third', 'promen-elementor-widgets'),
                ],
                'condition' => [
                    'show_newsletter_form' => 'yes',
                ],
            ]
        );

        // Spacing between elements
        $widget->add_control(
            'sidebar_elements_spacing',
            [
                'label' => esc_html__('Spacing Between Elements', 'promen-elementor-widgets'),
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
                    'unit' => 'rem',
                    'size' => 1.5,
                ],
                'selectors' => [
                    '{{WRAPPER}} .promen-text-content-block__sidebar-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
                'separator' => 'before',
            ]
        );

        $widget->end_controls_section();
    }
} 