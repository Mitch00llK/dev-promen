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
     * Widget files
     */
    private $widget_files = [
        'feature-blocks/feature-blocks-widget.php',
        'services-carousel/services-carousel-widget.php',
        'image-text-block/image-text-block-widget.php',
        'news-posts/news-posts-widget.php',
        'stats-counter/stats-counter-widget.php',
        'contact-info-card/contact-info-card-widget.php',
        'team-members-carousel/team-members-carousel-widget.php',
        'certification-logos/certification-logos.php',
        'services-grid/services-grid-wrapper.php',
        'worker-testimonial/worker-testimonial.php',
        'benefits-widget/benefits-widget.php',
        'hero-slider/hero-slider-wrapper.php',
        'text-content-block/text-content-block-wrapper.php',
        'image-slider/image-slider-widget.php',
        'related-services/related-services-widget.php',
        'text-column-repeater/text-column-repeater-widget.php',
        'solicitation-timeline/solicitation-timeline-widget.php',
        'business-catering/business-catering-widget.php',
        'testimonial-card/testimonial-card-widget.php',
        'image-text-slider/image-text-slider-wrapper.php',
        'checklist-comparison/checklist-comparison-widget.php',
        'contact-info-blocks/contact-info-blocks-widget.php',
        'locations-display/locations-display-widget.php',
        'document-info-list/document-info-list-widget.php',
        'hamburger-menu/hamburger-menu-widget.php'
    ];
    
    /**
     * Widget classes
     */
    private $widget_classes = [
        'Promen_Feature_Blocks_Widget',
        'Promen_Services_Carousel_Widget',
        'Promen_Image_Text_Block_Widget',
        'Promen_News_Posts_Widget',
        'Promen_Stats_Counter_Widget',
        'Contact_Info_Card_Widget',
        'Promen_Team_Members_Carousel_Widget',
        'Promen_Certification_Logos_Widget',
        'Promen_Services_Grid',
        'Promen_Worker_Testimonial_Widget',
        'Promen_Benefits_Widget',
        'Promen_Hero_Slider',
        'Promen_Text_Content_Block_Widget',
        'Promen_Image_Slider_Widget',
        'Promen_Related_Services',
        'Promen_Text_Column_Repeater_Widget',
        'Promen_Solicitation_Timeline_Widget',
        'Promen_Business_Catering_Widget',
        'Promen_Testimonial_Card_Widget',
        'Promen_Image_Text_Slider_Widget',
        'Promen_Checklist_Comparison_Widget',
        'Promen_Contact_Info_Blocks_Widget',
        'Promen_Locations_Display_Widget',
        'Promen_Document_Info_List_Widget',
        'Promen_Hamburger_Menu_Widget'
    ];
    
    /**
     * Constructor
     */
    public function __construct() {
        // Register widgets
        add_action('elementor/widgets/register', [$this, 'register_widgets']);
    }
    
    /**
     * Register widgets
     */
    public function register_widgets($widgets_manager) {
        // Include widget files
        $this->include_widget_files();
        
        // Register each widget if its class exists
        foreach ($this->widget_classes as $widget_class) {
            if (class_exists($widget_class)) {
                $widgets_manager->register(new $widget_class());
            }
        }
        
        // Ensure Swiper is loaded for widgets that need it
        wp_enqueue_script('swiper-bundle');
    }
    
    /**
     * Include widget files
     */
    private function include_widget_files() {
        foreach ($this->widget_files as $widget_file) {
            $file_path = PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/' . $widget_file;
            if (file_exists($file_path)) {
                require_once($file_path);
            }
        }
    }
} 