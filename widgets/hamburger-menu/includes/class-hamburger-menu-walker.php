<?php
/**
 * Custom Walker Class for Hamburger Menu
 * 
 * Extends the WordPress nav walker to customize menu item output 
 * with submenu toggle functionality and icons.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Promen_Hamburger_Menu_Walker
 * 
 * Custom walker for hamburger menu navigation
 */
class Promen_Hamburger_Menu_Walker extends Walker_Nav_Menu {
    /**
     * @var string The type of submenu icon to use
     */
    private $submenu_icon;

    /**
     * Constructor
     *
     * @param string $icon_type The icon type to use for submenu toggles
     */
    public function __construct($icon_type = 'chevron') {
        $this->submenu_icon = $icon_type;
    }

    /**
     * Start element output
     *
     * @param string  $output            Used to append additional content
     * @param WP_Post $item              Menu item data object
     * @param int     $depth             Depth of menu item
     * @param array   $args              An array of wp_nav_menu() arguments
     * @param int     $id                Current item ID
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        
        // Add accessibility and submenu classes
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $classes[] = 'has-submenu';
        }
        
        // Add depth class for styling
        $classes[] = 'menu-depth-' . $depth;
        
        // Generate id attribute based on item ID and depth
        $item_id = 'menu-item-' . $item->ID . '-depth-' . $depth;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $output .= $indent . '<li id="' . esc_attr($item_id) . '"' . $class_names . '>';
        
        // Build menu item attributes
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        
        if (in_array('menu-item-has-children', $classes)) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        // Start the item output
        $item_output = $args->before;
        
        // Wrap in a wrapper div for menu items with children
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= '<div class="menu-item-wrapper">';
        }
        
        // Add the anchor element
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
        $item_output .= '</a>';
        
        // Add submenu toggle button for items with children
        if (in_array('menu-item-has-children', $classes)) {
            $item_output .= $this->get_submenu_toggle_button($item_id);
            $item_output .= '</div>'; // Close the wrapper div
        }
        
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * Start level output
     *
     * @param string  $output Used to append additional content
     * @param int     $depth  Depth of menu item
     * @param array   $args   An array of wp_nav_menu() arguments
     */
    public function start_lvl(&$output, $depth = 0, $args = array()) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\" role=\"menu\">\n";
    }

    /**
     * Get submenu toggle button HTML
     *
     * @param string $item_id The ID of the parent menu item
     * @return string HTML for the submenu toggle button
     */
    private function get_submenu_toggle_button($item_id) {
        $icon_html = $this->get_submenu_icon($this->submenu_icon);
        return sprintf(
            '<button class="submenu-toggle" aria-label="%s" data-icon-type="%s" aria-controls="%s-submenu">%s</button>',
            esc_attr__('Toggle Submenu', 'promen-elementor-widgets'),
            esc_attr($this->submenu_icon),
            esc_attr($item_id),
            $icon_html
        );
    }

    /**
     * Get the SVG icon for submenu toggles
     *
     * @param string $icon_type Type of icon to use
     * @return string SVG markup for the icon
     */
    private function get_submenu_icon($icon_type) {
        $icons = [
            'chevron' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>',
            'plus' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>',
            'arrow' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>'
        ];
        
        return isset($icons[$icon_type]) ? $icons[$icon_type] : $icons['chevron'];
    }
} 