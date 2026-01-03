<?php
/**
 * Hamburger Menu Widget Render
 * 
 * Handles the frontend rendering of the hamburger menu widget.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render the hamburger menu widget
 *
 * @param \Elementor\Widget_Base $widget The widget instance
 */
function render_hamburger_menu_widget($widget) {
    $settings = $widget->get_settings_for_display();
    
    // Get menu
    $menu_id = $settings['menu_selection'] ?? '';
    
    if (empty($menu_id)) {
        echo '<div class="hamburger-menu-error">' . esc_html__('Please select a menu in the widget settings.', 'promen-elementor-widgets') . '</div>';
        return;
    }
    
    // Generate unique ID for the menu
    $menu_id_attr = 'hamburger-menu-' . $widget->get_id();
    
    // Parse all settings with default values
    $config = parse_hamburger_menu_settings($settings);
    
    // Build data attributes for JavaScript
    $data_attributes_string = build_data_attributes($config);
    
    // Include the Walker class
    require_once PROMEN_ELEMENTOR_WIDGETS_PATH . 'widgets/hamburger-menu/includes/class-hamburger-menu-walker.php';
    
    // Start output
    ?>
    <div id="<?php echo esc_attr($menu_id_attr); ?>" 
         class="hamburger-menu <?php echo esc_attr($config['gpu_class']); ?>" 
         <?php echo $data_attributes_string; ?>>
        
        <!-- Hamburger Toggle Button -->
        <div class="hamburger-menu__toggle-wrapper">
            <button id="<?php echo esc_attr($menu_id_attr); ?>-toggle"
                    class="hamburger-menu__toggle" 
                    aria-expanded="false" 
                    aria-controls="<?php echo esc_attr($menu_id_attr) . '-panel'; ?>"
                    aria-haspopup="true"
                    aria-label="<?php echo esc_attr__('Open navigation menu', 'promen-elementor-widgets'); ?>"
                    data-icon-type="<?php echo esc_attr($config['icon_type']); ?>"
                    type="button">
                <span class="hamburger-bar" aria-hidden="true"></span>
                <span class="hamburger-bar" aria-hidden="true"></span>
                <span class="hamburger-bar" aria-hidden="true"></span>
                <span class="screen-reader-text"><?php echo esc_html__('Toggle Menu', 'promen-elementor-widgets'); ?></span>
            </button>
            
            <?php if ($config['show_toggle_label'] === 'yes') : ?>
                <span class="hamburger-menu__toggle-label"><?php echo esc_html($config['toggle_label']); ?></span>
            <?php endif; ?>
        </div>
        
        <!-- Menu Panel -->
        <div id="<?php echo esc_attr($menu_id_attr) . '-panel'; ?>" 
             class="hamburger-menu__panel <?php echo esc_attr($config['panel_animation_class']); ?>" 
             aria-hidden="true"
             aria-labelledby="<?php echo esc_attr($menu_id_attr); ?>-toggle"
             role="dialog"
             aria-modal="true"
             tabindex="-1">
            
            <!-- Close Button -->
            <button type="button" 
                    class="hamburger-menu__close hamburger-menu__close--<?php echo esc_attr($config['close_button_position']); ?>" 
                    aria-label="<?php echo esc_attr__('Close navigation menu', 'promen-elementor-widgets'); ?>"
                    tabindex="0">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                <span class="screen-reader-text"><?php echo esc_html__('Close navigation menu', 'promen-elementor-widgets'); ?></span>
            </button>
            
            <nav class="hamburger-menu__navigation">
                <?php
                // Display the WordPress menu with our custom walker
                wp_nav_menu([
                    'menu'            => $menu_id,
                    'container'       => false,
                    'menu_class'      => 'hamburger-menu__items',
                    'fallback_cb'     => function() {
                        echo '<ul class="hamburger-menu__items"><li>' . esc_html__('No menu items found', 'promen-elementor-widgets') . '</li></ul>';
                    },
                    'items_wrap'      => '<ul class="hamburger-menu__items">%3$s</ul>',
                    'walker'          => new Promen_Hamburger_Menu_Walker($config['submenu_icon']),
                ]);
                
                // Render contact info section if enabled
                render_contact_info_section($config);
                ?>
            </nav>
        </div>
    </div>
    
    <?php
    // Initialize the menu
    add_action('wp_footer', function() use ($menu_id_attr) {
        if (!is_admin()) { ?>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof initHamburgerMenu === 'function') {
                    initHamburgerMenu('<?php echo esc_js($menu_id_attr); ?>');
                }
            });
            </script>
        <?php }
    });
    
    // For Elementor editor
    if (\Elementor\Plugin::$instance->editor->is_edit_mode()) { ?>
        <script>
        function checkGSAPAndInitMenu() {
            if (typeof gsap !== 'undefined' && typeof initHamburgerMenu === 'function') {
                initHamburgerMenu('<?php echo esc_js($menu_id_attr); ?>');
            } else {
                setTimeout(checkGSAPAndInitMenu, 200);
            }
        }
        checkGSAPAndInitMenu();
        </script>
    <?php }
}

/**
 * Parse and prepare all hamburger menu settings with defaults
 *
 * @param array $settings The widget settings
 * @return array Parsed settings with defaults
 */
function parse_hamburger_menu_settings($settings) {
    // Animation settings
    $animation_duration = $settings['animation_duration']['size'] ?? 0.5;
    $animation_easing = $settings['animation_easing'] ?? 'power3.out';
    $stagger_delay = $settings['stagger_delay']['size'] ?? 0.08;
    $panel_animation = $settings['panel_animation'] ?? 'slide-right';
    $menu_items_animation = $settings['menu_items_animation'] ?? 'fade-up';
    $use_gpu = $settings['use_gpu_acceleration'] ?? 'yes';
    
    // Push animation settings
    $enable_push_animation = $settings['enable_push_animation'] ?? 'yes';
    $push_distance = isset($settings['push_distance']['size']) ? $settings['push_distance']['size'] : 30;
    $push_unit = isset($settings['push_distance']['unit']) ? $settings['push_distance']['unit'] : '%';
    
    // Toggle label
    $toggle_label = $settings['menu_toggle_label'] ?? 'Menu';
    $show_toggle_label = $settings['show_toggle_label'] ?? 'yes';
    
    // Contact info
    $show_contact_info = $settings['show_contact_info'] ?? 'no';
    $contact_title = $settings['contact_title'] ?? 'Contact Us';
    $contact_phone = $settings['contact_phone'] ?? '';
    $contact_email = $settings['contact_email'] ?? '';
    $contact_address = $settings['contact_address'] ?? '';
    
    // Get hamburger icon settings
    $icon_type = $settings['hamburger_icon_type'] ?? 'classic';
    
    // Close button position
    $close_button_position = $settings['close_button_position'] ?? 'top-right';
    
    // Get submenu settings
    $submenu_icon = $settings['submenu_icon'] ?? 'chevron';
    $submenu_animation = $settings['submenu_animation'] ?? 'slide';
    $submenu_duration = $settings['submenu_animation_duration']['size'] ?? 0.3;
    
    // Set up panel animation class
    $panel_animation_class = 'panel-animation-' . $panel_animation;
    
    // Set up GPU acceleration class
    $gpu_class = $use_gpu === 'yes' ? 'use-gpu' : '';
    
    return [
        'animation_duration' => $animation_duration,
        'animation_easing' => $animation_easing,
        'stagger_delay' => $stagger_delay,
        'panel_animation' => $panel_animation,
        'menu_items_animation' => $menu_items_animation,
        'use_gpu' => $use_gpu,
        'enable_push_animation' => $enable_push_animation,
        'push_distance' => $push_distance,
        'push_unit' => $push_unit,
        'toggle_label' => $toggle_label,
        'show_toggle_label' => $show_toggle_label,
        'show_contact_info' => $show_contact_info,
        'contact_title' => $contact_title,
        'contact_phone' => $contact_phone,
        'contact_email' => $contact_email,
        'contact_address' => $contact_address,
        'icon_type' => $icon_type,
        'close_button_position' => $close_button_position,
        'submenu_icon' => $submenu_icon,
        'submenu_animation' => $submenu_animation,
        'submenu_duration' => $submenu_duration,
        'panel_animation_class' => $panel_animation_class,
        'gpu_class' => $gpu_class,
    ];
}

/**
 * Build data attributes string for JavaScript
 *
 * @param array $config Configuration settings
 * @return string Data attributes string
 */
function build_data_attributes($config) {
    $data_attributes = [
        'animation-duration' => $config['animation_duration'],
        'animation-easing' => $config['animation_easing'],
        'stagger-delay' => $config['stagger_delay'],
        'menu-items-animation' => $config['menu_items_animation'],
        'icon-type' => $config['icon_type'],
        'submenu-animation' => $config['submenu_animation'],
        'submenu-duration' => $config['submenu_duration'],
        'submenu-icon' => $config['submenu_icon'],
        'enable-push' => $config['enable_push_animation'],
        'push-distance' => $config['push_distance'],
        'push-unit' => $config['push_unit'],
        'panel-animation' => $config['panel_animation'],
    ];
    
    $data_attributes_string = '';
    foreach ($data_attributes as $key => $value) {
        $data_attributes_string .= ' data-' . esc_attr($key) . '="' . esc_attr($value) . '"';
    }
    
    return $data_attributes_string;
}

/**
 * Render the contact information section
 *
 * @param array $config Configuration settings
 */
function render_contact_info_section($config) {
    if ($config['show_contact_info'] !== 'yes' || 
        (!$config['contact_phone'] && !$config['contact_email'] && !$config['contact_address'])) {
        return;
    }
    ?>
    <div class="hamburger-menu__contact">
        <?php if ($config['contact_title']) : ?>
            <h3 class="hamburger-menu__contact-title"><?php echo esc_html($config['contact_title']); ?></h3>
        <?php endif; ?>
        
        <?php if ($config['contact_phone']) : ?>
            <div class="hamburger-menu__contact-item">
                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $config['contact_phone'])); ?>">
                    <?php echo esc_html($config['contact_phone']); ?>
                </a>
            </div>
        <?php endif; ?>
        
        <?php if ($config['contact_email']) : ?>
            <div class="hamburger-menu__contact-item">
                <a href="mailto:<?php echo esc_attr($config['contact_email']); ?>">
                    <?php echo esc_html($config['contact_email']); ?>
                </a>
            </div>
        <?php endif; ?>
        
        <?php if ($config['contact_address']) : ?>
            <div class="hamburger-menu__contact-item">
                <?php echo wp_kses_post(nl2br($config['contact_address'])); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
} 