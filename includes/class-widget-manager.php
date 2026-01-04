<?php
/**
 * Widget Manager Class
 * 
 * Handles registration of Elementor widgets.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Promen_Widget_Manager {
    
    /**
     * Widget definitions (file path => class name)
     */
    private $widgets = [
        'feature-blocks/feature-blocks-widget.php' => [
            'class' => 'Promen_Feature_Blocks_Widget',
            'name' => 'promen_feature_blocks'
        ],
        'services-carousel/services-carousel-widget.php' => [
            'class' => 'Promen_Services_Carousel_Widget',
            'name' => 'promen_services_carousel'
        ],
        'image-text-block/image-text-block-widget.php' => [
            'class' => 'Promen_Image_Text_Block_Widget',
            'name' => 'promen_image_text_block'
        ],
        'news-posts/news-posts-widget.php' => [
            'class' => 'Promen_News_Posts_Widget',
            'name' => 'promen_news_posts'
        ],
        'stats-counter/stats-counter-widget.php' => [
            'class' => 'Promen_Stats_Counter_Widget',
            'name' => 'promen_stats_counter'
        ],
        'contact-info-card/contact-info-card-widget.php' => [
            'class' => 'Contact_Info_Card_Widget',
            'name' => 'contact_info_card'
        ],
        'team-members-carousel/team-members-carousel-widget.php' => [
            'class' => 'Promen_Team_Members_Carousel_Widget',
            'name' => 'promen_team_members_carousel'
        ],
        'certification-logos/certification-logos.php' => [
            'class' => 'Promen_Certification_Logos_Widget',
            'name' => 'promen_certification_logos'
        ],
        'services-grid/services-grid-wrapper.php' => [
            'class' => 'Promen_Services_Grid',
            'name' => 'promen_services_grid'
        ],
        'worker-testimonial/worker-testimonial.php' => [
            'class' => 'Promen_Worker_Testimonial_Widget',
            'name' => 'promen_worker_testimonial'
        ],
        'benefits-widget/benefits-widget.php' => [
            'class' => 'Promen_Benefits_Widget',
            'name' => 'promen_benefits'
        ],
        'hero-slider/hero-slider-wrapper.php' => [
            'class' => 'Promen_Hero_Slider',
            'name' => 'promen_hero_slider'
        ],
        'text-content-block/text-content-block-wrapper.php' => [
            'class' => 'Promen_Text_Content_Block_Widget',
            'name' => 'promen_text_content_block'
        ],
        'image-slider/image-slider-widget.php' => [
            'class' => 'Promen_Image_Slider_Widget',
            'name' => 'promen_image_slider'
        ],
        'related-services/related-services-widget.php' => [
            'class' => 'Promen_Related_Services',
            'name' => 'promen_related_services'
        ],
        'text-column-repeater/text-column-repeater-widget.php' => [
            'class' => 'Promen_Text_Column_Repeater_Widget',
            'name' => 'promen_text_column_repeater'
        ],
        'solicitation-timeline/solicitation-timeline-widget.php' => [
            'class' => 'Promen_Solicitation_Timeline_Widget',
            'name' => 'promen_solicitation_timeline'
        ],
        'business-catering/business-catering-widget.php' => [
            'class' => 'Promen_Business_Catering_Widget',
            'name' => 'promen_business_catering'
        ],
        'testimonial-card/testimonial-card-widget.php' => [
            'class' => 'Promen_Testimonial_Card_Widget',
            'name' => 'promen_testimonial_card'
        ],
        'image-text-slider/image-text-slider-widget.php' => [
            'class' => 'Promen_Image_Text_Slider_Widget',
            'name' => 'image_text_slider'
        ],
        'checklist-comparison/checklist-comparison-widget.php' => [
            'class' => 'Promen_Checklist_Comparison_Widget',
            'name' => 'promen_checklist_comparison'
        ],
        'contact-info-blocks/contact-info-blocks-widget.php' => [
            'class' => 'Promen_Contact_Info_Blocks_Widget',
            'name' => 'promen_contact_info_blocks'
        ],
        'locations-display/locations-display-widget.php' => [
            'class' => 'Promen_Locations_Display_Widget',
            'name' => 'promen_locations_display'
        ],
        'document-info-list/document-info-list-widget.php' => [
            'class' => 'Promen_Document_Info_List_Widget',
            'name' => 'document_info_list'
        ],
        'hamburger-menu/hamburger-menu-widget.php' => [
            'class' => 'Promen_Hamburger_Menu_Widget',
            'name' => 'promen_hamburger_menu'
        ]
    ];
    
    /**
     * Constructor
     */
    public function __construct() {
        // Register widgets
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
    }
    
    /**
     * Get disabled widgets from options
     * 
     * @return array
     */
    private function get_disabled_widgets() {
        return get_option('promen_disabled_widgets', []);
    }
    
    /**
     * Check if a widget is disabled
     * 
     * @param string $widget_name
     * @return bool
     */
    public function is_widget_disabled($widget_name) {
        $disabled = $this->get_disabled_widgets();
        return in_array($widget_name, $disabled);
    }
    
    /**
     * Get all widget definitions
     * 
     * @return array
     */
    public function get_all_widgets() {
        return $this->widgets;
    }
    
    /**
     * Register widgets
     */
    public function register_widgets($widgets_manager) {
        // Get disabled widgets
        $disabled_widgets = $this->get_disabled_widgets();
        
        // Include and register each widget
        foreach ($this->widgets as $file => $widget_data) {
            // Skip disabled widgets
            if (in_array($widget_data['name'], $disabled_widgets)) {
                continue;
            }
            
            // Include file
            $file_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/' . $file;
            if (file_exists($file_path)) {
                require_once($file_path);
                
                // Register widget if class exists
                if (class_exists($widget_data['class'])) {
                    $widgets_manager->register(new $widget_data['class']());
                }
            }
        }
        
        // Ensure Swiper is loaded for widgets that need it
        wp_enqueue_script('swiper-bundle');
    }
}
 