<?php
/**
 * Promen Testimonial Card Widget
 * 
 * A widget that displays testimonials in a card format.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Testimonial_Card_Widget extends \Promen_Widget_Base {

    /**
     * Get widget name.
     */
    public function get_name() {
        return 'promen_testimonial_card';
    }

    /**
     * Get widget title.
     */
    public function get_title() {
        return esc_html__('Testimonial Card', 'promen-elementor-widgets');
    }

    /**
     * Get widget icon.
     */
    public function get_icon() {
        return 'eicon-testimonial-carousel';
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
        return ['testimonial', 'card', 'review', 'feedback'];
    }

    /**
     * Get widget style dependencies.
     */
    public function get_style_depends() {
        return ['promen-testimonial-card-style'];
    }

    /**
     * Get widget script dependencies.
     */
    public function get_script_depends() {
        // Register accessibility script
        wp_register_script(
            'promen-testimonial-card-accessibility',
            PROMEN_ELEMENTOR_WIDGETS_URL . 'widgets/testimonial-card/assets/js/testimonial-card-accessibility.js',
            ['jquery', 'promen-accessibility'],
            filemtime(__DIR__ . '/assets/js/testimonial-card-accessibility.js'),
            true
        );
        
        return ['promen-testimonial-card-script', 'promen-testimonial-card-accessibility'];
    }

    /**
     * Register widget controls.
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_image',
            [
                'label' => esc_html__('Show Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'testimonial_image',
            [
                'label' => esc_html__('Testimonial Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                'condition' => [
                    'show_image' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'testimonial_content',
            [
                'label' => esc_html__('Testimonial Content', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 10,
                'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter testimonial content', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Name', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('John Doe', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter name', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'testimonial_job',
            [
                'label' => esc_html__('Job Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('CEO', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter job title', 'promen-elementor-widgets'),
            ]
        );

        $this->add_control(
            'testimonial_company',
            [
                'label' => esc_html__('Company', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Company Name', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter company name', 'promen-elementor-widgets'),
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'card_background_color',
            [
                'label' => esc_html__('Card Background Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-card' => 'background-color: {{VALUE}};',
                ],
                'default' => '#ffffff',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'card_box_shadow',
                'label' => esc_html__('Card Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .testimonial-card',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Content Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-content' => 'color: {{VALUE}};',
                ],
                'default' => '#333333',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Name Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-name' => 'color: {{VALUE}};',
                ],
                'default' => '#000000',
            ]
        );

        $this->add_control(
            'job_color',
            [
                'label' => esc_html__('Job Title Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-job' => 'color: {{VALUE}};',
                ],
                'default' => '#666666',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        // Generate unique IDs for accessibility
        $widget_id = $this->get_id();
        $testimonial_id = Promen_Accessibility_Utils::generate_id('testimonial-' . $widget_id);
        $testimonial_content_id = Promen_Accessibility_Utils::generate_id('testimonial-content-' . $widget_id);
        $testimonial_author_id = Promen_Accessibility_Utils::generate_id('testimonial-author-' . $widget_id);
        ?>
        <article class="testimonial-card" 
                 role="article" 
                 tabindex="0"
                 aria-labelledby="<?php echo esc_attr($testimonial_author_id); ?>"
                 aria-describedby="<?php echo esc_attr($testimonial_content_id); ?>"
                 id="<?php echo esc_attr($testimonial_id); ?>">
            <?php if ('yes' === $settings['show_image'] && !empty($settings['testimonial_image']['url'])) : ?>
                <figure class="testimonial-image" role="img" aria-label="<?php echo esc_attr('Foto van ' . $settings['testimonial_name']); ?>">
                    <img src="<?php echo esc_url($settings['testimonial_image']['url']); ?>" 
                         alt="<?php echo esc_attr($settings['testimonial_name']); ?>"
                         width="100" 
                         height="100"
                         loading="lazy">
                </figure>
            <?php endif; ?>
            
            <blockquote class="testimonial-content" id="<?php echo esc_attr($testimonial_content_id); ?>">
                <?php echo wp_kses_post($settings['testimonial_content']); ?>
            </blockquote>
            
            <footer class="testimonial-meta">
                <h4 class="testimonial-name" id="<?php echo esc_attr($testimonial_author_id); ?>"><?php echo esc_html($settings['testimonial_name']); ?></h4>
                <div class="testimonial-position">
                    <span class="testimonial-job"><?php echo esc_html($settings['testimonial_job']); ?></span>
                    <?php if (!empty($settings['testimonial_company'])) : ?>
                        <span class="testimonial-company"><?php echo esc_html($settings['testimonial_company']); ?></span>
                    <?php endif; ?>
                </div>
            </footer>
        </article>
        <?php
    }
} 