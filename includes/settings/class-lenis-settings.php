<?php
/**
 * Manages Lenis smooth scroll settings in WordPress admin.
 *
 * @since 1.0.0
 */
class Promen_Lenis_Settings {

    /**
     * Singleton instance.
     *
     * @var Promen_Lenis_Settings|null
     */
    private static $instance = null;

    /**
     * CDN URL for Lenis library.
     */
    private const LENIS_CDN_URL = 'https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js';

    /**
     * Lenis library version.
     */
    private const LENIS_VERSION = '1.1.18';

    /**
     * Default option values.
     */
    private const DEFAULTS = [
        'enable_lenis'      => true,
        'scroll_duration'   => 1.2,
        'scroll_easing'     => 'ease-out-expo',
        'mouse_multiplier'  => 1.0,
        'touch_multiplier'  => 2.0,
    ];

    /**
     * Valid easing options with labels.
     */
    private const VALID_EASING = [
        'ease-out-expo'  => 'Ease Out Expo',
        'ease-out-cubic' => 'Ease Out Cubic',
        'ease-out-quad'  => 'Ease Out Quad',
        'linear'         => 'Linear',
    ];

    /**
     * Returns the singleton instance.
     *
     * @return Promen_Lenis_Settings
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private constructor to enforce singleton pattern.
     */
    private function __construct() {
        add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        add_action( 'wp_ajax_test_lenis_speed', array( $this, 'test_lenis_speed' ) );
    }

    /**
     * Retrieves merged options with defaults.
     *
     * @return array
     */
    private function get_options() {
        return wp_parse_args(
            get_option( 'lenis_scroll_options', [] ),
            self::DEFAULTS
        );
    }

    /**
     * Registers the settings page under WordPress Settings menu.
     */
    public function add_settings_page() {
        add_options_page(
            __( 'Lenis Scroll Settings', 'promen' ),
            __( 'Lenis Scroll', 'promen' ),
            'manage_options',
            'lenis-scroll-settings',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Registers settings, sections, and fields.
     */
    public function register_settings() {
        register_setting( 'lenis_scroll_settings', 'lenis_scroll_options', array(
            'sanitize_callback' => array( $this, 'sanitize_settings' ),
        ) );

        add_settings_section(
            'lenis_scroll_main_section',
            __( 'Scroll Settings', 'promen' ),
            array( $this, 'section_callback' ),
            'lenis-scroll-settings'
        );

        add_settings_field(
            'enable_lenis',
            __( 'Enable Lenis Smooth Scroll', 'promen' ),
            array( $this, 'enable_lenis_callback' ),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );

        add_settings_field(
            'scroll_duration',
            __( 'Scroll Duration (seconds)', 'promen' ),
            array( $this, 'duration_callback' ),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );

        add_settings_field(
            'scroll_easing',
            __( 'Scroll Easing', 'promen' ),
            array( $this, 'easing_callback' ),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );

        add_settings_field(
            'mouse_multiplier',
            __( 'Mouse Wheel Multiplier', 'promen' ),
            array( $this, 'mouse_multiplier_callback' ),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );

        add_settings_field(
            'touch_multiplier',
            __( 'Touch Multiplier', 'promen' ),
            array( $this, 'touch_multiplier_callback' ),
            'lenis-scroll-settings',
            'lenis_scroll_main_section'
        );
    }

    /**
     * Sanitizes and validates settings input.
     *
     * @param array $input Raw input from settings form.
     * @return array Sanitized settings.
     */
    public function sanitize_settings( $input ) {
        $sanitized = [];

        $sanitized['enable_lenis'] = ! empty( $input['enable_lenis'] ) && '1' === $input['enable_lenis'];

        $sanitized['scroll_duration'] = max( 0.1, min( 5.0,
            floatval( $input['scroll_duration'] ?? self::DEFAULTS['scroll_duration'] )
        ) );

        $sanitized['scroll_easing'] = array_key_exists( $input['scroll_easing'] ?? '', self::VALID_EASING )
            ? $input['scroll_easing']
            : self::DEFAULTS['scroll_easing'];

        $sanitized['mouse_multiplier'] = max( 0.1, min( 10.0,
            floatval( $input['mouse_multiplier'] ?? self::DEFAULTS['mouse_multiplier'] )
        ) );

        $sanitized['touch_multiplier'] = max( 0.1, min( 10.0,
            floatval( $input['touch_multiplier'] ?? self::DEFAULTS['touch_multiplier'] )
        ) );

        return $sanitized;
    }

    /**
     * Renders the section description.
     */
    public function section_callback() {
        echo '<p>' . esc_html__( 'Configure the Lenis smooth scroll settings below. You can completely disable smooth scrolling by unchecking the enable option.', 'promen' ) . '</p>';
    }

    /**
     * Renders the enable Lenis checkbox field.
     */
    public function enable_lenis_callback() {
        $options = $this->get_options();
        ?>
        <input type="checkbox" 
               name="lenis_scroll_options[enable_lenis]" 
               value="1" 
               <?php checked( $options['enable_lenis'], true ); ?> />
        <p class="description"><?php esc_html_e( 'Enable or disable Lenis smooth scroll globally. When disabled, standard browser scrolling will be used.', 'promen' ); ?></p>
        <?php
    }

    /**
     * Renders the scroll duration number field.
     */
    public function duration_callback() {
        $options = $this->get_options();
        ?>
        <input type="number" 
               step="0.1" 
               min="0.1" 
               max="5" 
               name="lenis_scroll_options[scroll_duration]" 
               value="<?php echo esc_attr( $options['scroll_duration'] ); ?>" />
        <p class="description"><?php esc_html_e( 'Controls how long the scroll animation takes (in seconds)', 'promen' ); ?></p>
        <?php
    }

    /**
     * Renders the easing select field.
     */
    public function easing_callback() {
        $options = $this->get_options();
        ?>
        <select name="lenis_scroll_options[scroll_easing]">
            <?php foreach ( self::VALID_EASING as $value => $label ) : ?>
                <option value="<?php echo esc_attr( $value ); ?>" 
                    <?php selected( $options['scroll_easing'], $value ); ?>>
                    <?php echo esc_html( $label ); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <p class="description"><?php esc_html_e( 'The easing function for the scroll animation', 'promen' ); ?></p>
        <?php
    }

    /**
     * Renders the mouse multiplier number field.
     */
    public function mouse_multiplier_callback() {
        $options = $this->get_options();
        ?>
        <input type="number" 
               step="0.1" 
               min="0.1" 
               max="10" 
               name="lenis_scroll_options[mouse_multiplier]" 
               value="<?php echo esc_attr( $options['mouse_multiplier'] ); ?>" />
        <p class="description"><?php esc_html_e( 'Multiplier for mouse wheel scrolling speed', 'promen' ); ?></p>
        <?php
    }

    /**
     * Renders the touch multiplier number field.
     */
    public function touch_multiplier_callback() {
        $options = $this->get_options();
        ?>
        <input type="number" 
               step="0.1" 
               min="0.1" 
               max="10" 
               name="lenis_scroll_options[touch_multiplier]" 
               value="<?php echo esc_attr( $options['touch_multiplier'] ); ?>" />
        <p class="description"><?php esc_html_e( 'Multiplier for touch scrolling speed', 'promen' ); ?></p>
        <?php
    }

    /**
     * Renders the settings page HTML.
     */
    public function render_settings_page() {
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }
        ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                settings_fields( 'lenis_scroll_settings' );
                do_settings_sections( 'lenis-scroll-settings' );
                submit_button( __( 'Save Settings', 'promen' ) );
                ?>
            </form>
            <div id="lenis-test-area" class="lenis-test-area">
                <h2><?php esc_html_e( 'Test Scroll Settings', 'promen' ); ?></h2>
                <p><?php esc_html_e( 'Click the button below to test your current scroll settings:', 'promen' ); ?></p>
                <button type="button" id="test-lenis-settings" class="button button-secondary">
                    <?php esc_html_e( 'Test Scroll Settings', 'promen' ); ?>
                </button>
            </div>
        </div>
        <style>
            .lenis-test-area { margin-top: 20px; }
        </style>
        <?php
    }

    /**
     * Enqueues admin scripts and styles for the settings page.
     *
     * @param string $hook Current admin page hook.
     */
    public function enqueue_admin_scripts( $hook ) {
        if ( 'settings_page_lenis-scroll-settings' !== $hook ) {
            return;
        }

        wp_enqueue_script(
            'lenis-admin-settings',
            plugins_url( '/assets/js/lenis-admin-settings.js', dirname( dirname( __FILE__ ) ) ),
            array( 'jquery' ),
            '1.0.0',
            true
        );

        wp_enqueue_script(
            'lenis-js',
            self::LENIS_CDN_URL,
            [],
            self::LENIS_VERSION,
            true
        );

        wp_localize_script( 'lenis-admin-settings', 'lenisSettings', array(
            'ajaxurl' => admin_url( 'admin-ajax.php' ),
            'nonce'   => wp_create_nonce( 'lenis_test_nonce' ),
        ) );
    }

    /**
     * Handles AJAX request to test Lenis speed settings.
     */
    public function test_lenis_speed() {
        check_ajax_referer( 'lenis_test_nonce', 'nonce' );

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( __( 'Unauthorized', 'promen' ) );
        }

        wp_send_json_success( $this->get_options() );
    }
}

// Initialize the settings.
Promen_Lenis_Settings::get_instance();