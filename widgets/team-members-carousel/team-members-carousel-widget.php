<?php
/**
 * Team Members Carousel Widget
 * 
 * @package Promen
 * @subpackage Elementor Widgets
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Load traits
require_once(__DIR__ . '/controls/content-section.php');
require_once(__DIR__ . '/controls/layout-section.php');
require_once(__DIR__ . '/controls/carousel-section.php');
require_once(__DIR__ . '/controls/navigation-section.php');
require_once(__DIR__ . '/controls/style-section.php');
require_once(__DIR__ . '/controls/typography-section.php');

class Promen_Team_Members_Carousel_Widget extends \Promen_Widget_Base {
    use Team_Members_Carousel_Content_Controls;
    use Team_Members_Carousel_Layout_Controls;
    use Team_Members_Carousel_Carousel_Controls;
    use Team_Members_Carousel_Navigation_Controls;
    use Team_Members_Carousel_Style_Controls;
    use Team_Members_Carousel_Typography_Controls;

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_team_members_carousel';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Team Members Carousel', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-carousel';
    }

    /**
     * Get widget categories.
     */
    public function get_categories() {
        return ['promen-widgets'];
    }

    /**
     * Get widget keywords.
     */
    public function get_keywords() {
        return ['team', 'members', 'carousel', 'slider', 'promen'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        return ['promen-team-members-carousel-widget', 'promen-team-members-carousel-accessibility'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['swiper-bundle-css', 'promen-team-members-carousel-widget'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        $this->register_content_controls();
        $this->register_layout_controls();
        $this->register_carousel_controls();
        $this->register_navigation_controls();
        $this->register_style_controls();
        $this->register_typography_controls();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        include(__DIR__ . '/templates/render.php');
    }
} 