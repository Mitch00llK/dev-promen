<?php

class Promen_Lenis_Settings {
    private $options;
    private static $instance = null;

    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'register_settings'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_ajax_test_lenis_speed', array($this, 'test_lenis_speed'));
    }

    public function add_settings_page() {
        add_options_page(
            'Lenis Scroll Settings',
            'Lenis Scroll',
            'manage_options',
            'lenis-scroll-settings',
            array($this, 'render_settings_page')
        );
    }

    public function register_settings() {
        register_setting('lenis_scroll_settings', 'lenis_scroll_options', array(
            'sanitize_callback' => array($this, 'sanitize_settings')
        ));

        add_settings_section(
            'lenis_scroll_main_section',
            'Scroll Settings',
            array($this, 'section_callback'),
            'lenis-scroll-settings'
        );

        add_settings_field(
            'enable_lenis',
            'Enable Lenis Smooth Scroll',
            array($this, 'enable_lenis_callback'),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );

        add_settings_field(
            'scroll_duration',
            'Scroll Duration (seconds)',
            array($this, 'duration_callback'),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );

        add_settings_field(
            'scroll_easing',
            'Scroll Easing',
            array($this, 'easing_callback'),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );

        add_settings_field(
            'mouse_multiplier',
            'Mouse Wheel Multiplier',
            array($this, 'mouse_multiplier_callback'),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );

        add_settings_field(
            'touch_multiplier',
            'Touch Multiplier',
            array($this, 'touch_multiplier_callback'),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );
    }

    public function sanitize_settings($input) {
        $sanitized = array();
        
        $sanitized['enable_lenis'] = isset($input['enable_lenis']) && $input['enable_lenis'] == '1';
        
        $sanitized['scroll_duration'] = isset($input['scroll_duration']) ? 
            floatval($input['scroll_duration']) : 1.2;
        
        $sanitized['scroll_easing'] = isset($input['scroll_easing']) ? 
            sanitize_text_field($input['scroll_easing']) : 'ease-out-expo';
        
        $sanitized['mouse_multiplier'] = isset($input['mouse_multiplier']) ? 
            floatval($input['mouse_multiplier']) : 1;
        
        $sanitized['touch_multiplier'] = isset($input['touch_multiplier']) ? 
            floatval($input['touch_multiplier']) : 2;

        return $sanitized;
    }

    public function section_callback() {
        echo '<p>Configure the Lenis smooth scroll settings below. You can completely disable smooth scrolling by unchecking the enable option.</p>';
    }

    public function enable_lenis_callback() {
        $options = get_option('lenis_scroll_options', array(
            'enable_lenis' => true
        ));
        ?>
        <input type="checkbox" 
               name="lenis_scroll_options[enable_lenis]" 
               value="1" 
               <?php checked(isset($options['enable_lenis']) ? $options['enable_lenis'] : true, true); ?> />
        <p class="description">Enable or disable Lenis smooth scroll globally. When disabled, standard browser scrolling will be used.</p>
        <?php
    }

    public function duration_callback() {
        $options = get_option('lenis_scroll_options', array(
            'scroll_duration' => 1.2
        ));
        ?>
        <input type="number" 
               step="0.1" 
               min="0.1" 
               max="5" 
               name="lenis_scroll_options[scroll_duration]" 
               value="<?php echo esc_attr($options['scroll_duration']); ?>" />
        <p class="description">Controls how long the scroll animation takes (in seconds)</p>
        <?php
    }

    public function easing_callback() {
        $options = get_option('lenis_scroll_options', array(
            'scroll_easing' => 'ease-out-expo'
        ));
        $easing_options = array(
            'ease-out-expo' => 'Ease Out Expo',
            'ease-out-cubic' => 'Ease Out Cubic',
            'ease-out-quad' => 'Ease Out Quad',
            'linear' => 'Linear'
        );
        ?>
        <select name="lenis_scroll_options[scroll_easing]">
            <?php foreach ($easing_options as $value => $label) : ?>
                <option value="<?php echo esc_attr($value); ?>" 
                    <?php selected($options['scroll_easing'], $value); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description">The easing function for the scroll animation</p>
        <?php
    }

    public function mouse_multiplier_callback() {
        $options = get_option('lenis_scroll_options', array(
            'mouse_multiplier' => 1
        ));
        ?>
        <input type="number" 
               step="0.1" 
               min="0.1" 
               max="10" 
               name="lenis_scroll_options[mouse_multiplier]" 
               value="<?php echo esc_attr($options['mouse_multiplier']); ?>" />
        <p class="description">Multiplier for mouse wheel scrolling speed</p>
        <?php
    }

    public function touch_multiplier_callback() {
        $options = get_option('lenis_scroll_options', array(
            'touch_multiplier' => 2
        ));
        ?>
        <input type="number" 
               step="0.1" 
               min="0.1" 
               max="10" 
               name="lenis_scroll_options[touch_multiplier]" 
               value="<?php echo esc_attr($options['touch_multiplier']); ?>" />
        <p class="description">Multiplier for touch scrolling speed</p>
        <?php
    }

    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('lenis_scroll_settings');
                do_settings_sections('lenis-scroll-settings');
                submit_button('Save Settings');
                ?>
            </form>
            <div id="lenis-test-area" style="margin-top: 20px;">
                <h2>Test Scroll Settings</h2>
                <p>Click the button below to test your current scroll settings:</p>
                <button type="button" id="test-lenis-settings" class="button button-secondary">
                    Test Scroll Settings
                </button>
            </div>
        </div>
        <?php
    }

    public function enqueue_admin_scripts($hook) {
        if ('settings_page_lenis-scroll-settings' !== $hook) {
            return;
        }

        wp_enqueue_script(
            'lenis-admin-settings',
            plugins_url('/assets/js/lenis-admin-settings.js', dirname(dirname(__FILE__))),
            array('jquery'),
            '1.0.0',
            true
        );

        // Enqueue scripts for testing (including CDN Lenis)
        wp_enqueue_script(
            'lenis-js',
            'https://cdn.jsdelivr.net/gh/studio-freight/lenis@1.0.19/bundled/lenis.min.js',
            [],
            '1.0.19',
            true
        );

        wp_localize_script('lenis-admin-settings', 'lenisSettings', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('lenis_test_nonce')
        ));
    }

    public function test_lenis_speed() {
        check_ajax_referer('lenis_test_nonce', 'nonce');
        
        if (!current_user_can('manage_options')) {
            wp_send_json_error('Unauthorized');
        }

        $options = get_option('lenis_scroll_options');
        wp_send_json_success($options);
    }
}

// Initialize the settings
Promen_Lenis_Settings::get_instance(); 