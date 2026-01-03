<?php
/**
 * Certification Logos Widget
 * 
 * Displays a collection of certification and quality mark logos with title
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Certification_Logos_Widget extends \Elementor\Widget_Base {

    /**
     * Register widget scripts and styles.
     */
    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);

        wp_register_script(
            'promen-certification-logos-accessibility',
            plugins_url('assets/js/certification-logos-accessibility.js', __FILE__),
            ['jquery', 'promen-accessibility'],
            '1.0.0',
            true
        );
    }

    public function get_name() {
        return 'promen_certification_logos';
    }

    public function get_title() {
        return esc_html__('Certification Logos', 'promen-elementor-widgets');
    }

    public function get_icon() {
        return 'eicon-logo';
    }

    public function get_categories() {
        return ['promen-widgets'];
    }

    public function get_keywords() {
        return ['certification', 'logos', 'quality marks', 'certificates'];
    }

    /**
     * Get script dependencies.
     */
    public function get_script_depends() {
        return ['promen-certification-logos-accessibility'];
    }

    protected function register_controls() {
        // Title Section
        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__('Title', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => esc_html__('Show Title', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        // Use the standardized split title controls
        promen_add_split_title_controls(
            $this, 
            'section_title', 
            ['show_title' => 'yes'], 
            esc_html__('Onze certificeringen en keurmerken', 'promen-elementor-widgets'),
            'title'
        );

        $this->add_control(
            'show_description',
            [
                'label' => esc_html__('Show Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'promen-elementor-widgets'),
                'label_off' => esc_html__('Hide', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'description_text',
            [
                'label' => esc_html__('Description', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => esc_html__('Wij zijn trots op onze certificeringen en keurmerken die onze kwaliteit en expertise bevestigen.', 'promen-elementor-widgets'),
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Title Style Section - Use standardized style controls
        promen_add_split_title_style_controls(
            $this,
            'section_title_style',
            ['show_title' => 'yes'],
            'certification'
        );

        // Description Style Section
        $this->start_controls_section(
            'section_description_style',
            [
                'label' => esc_html__('Description Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_description' => 'yes',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'description_typography',
                'label' => esc_html__('Typography', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .certification-description',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .certification-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_spacing',
            [
                'label' => esc_html__('Spacing', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .certification-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Logos Section
        $this->start_controls_section(
            'section_logos',
            [
                'label' => esc_html__('Logos', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'logo_name',
            [
                'label' => esc_html__('Logo Name', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Logo Name', 'promen-elementor-widgets'),
                'placeholder' => esc_html__('Enter logo name', 'promen-elementor-widgets'),
            ]
        );

        $repeater->add_control(
            'logo_image',
            [
                'label' => esc_html__('Logo Image', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'logo_link',
            [
                'label' => esc_html__('Logo Link', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => esc_html__('https://your-link.com', 'promen-elementor-widgets'),
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );

        $this->add_control(
            'logos_list',
            [
                'label' => esc_html__('Logos', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'logo_name' => esc_html__('Logo #1', 'promen-elementor-widgets'),
                    ],
                    [
                        'logo_name' => esc_html__('Logo #2', 'promen-elementor-widgets'),
                    ],
                    [
                        'logo_name' => esc_html__('Logo #3', 'promen-elementor-widgets'),
                    ],
                ],
                'title_field' => '{{{ logo_name }}}',
            ]
        );

        $this->end_controls_section();

        // Layout Section
        $this->start_controls_section(
            'section_layout',
            [
                'label' => esc_html__('Layout', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => esc_html__('Columns', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '4',
                'options' => [
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                    '6' => '6',
                ],
                'selectors' => [
                    '{{WRAPPER}} .logos-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
                ],
            ]
        );

        $this->add_control(
            'enable_slider',
            [
                'label' => esc_html__('Enable Mobile Slider', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'promen-elementor-widgets'),
                'label_off' => esc_html__('No', 'promen-elementor-widgets'),
                'return_value' => 'yes',
                'default' => 'yes',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'slides_to_show',
            [
                'label' => esc_html__('Slides to Show', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                ],
                'condition' => [
                    'enable_slider' => 'yes',
                ],
            ]
        );

        $this->end_controls_section();

        // Logos Style Section
        $this->start_controls_section(
            'section_logos_style',
            [
                'label' => esc_html__('Logos Style', 'promen-elementor-widgets'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'logo_height',
            [
                'label' => esc_html__('Logo Height', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo img' => 'max-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => esc_html__('Logo Width', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem', '%'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 300,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_padding',
            [
                'label' => esc_html__('Logo Padding', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_margin',
            [
                'label' => esc_html__('Logo Margin', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'logo_border',
                'label' => esc_html__('Border', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .certification-logo',
            ]
        );

        $this->add_responsive_control(
            'logo_border_radius',
            [
                'label' => esc_html__('Border Radius', 'promen-elementor-widgets'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .certification-logo' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'logo_box_shadow',
                'label' => esc_html__('Box Shadow', 'promen-elementor-widgets'),
                'selector' => '{{WRAPPER}} .certification-logo',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $logos = $settings['logos_list'];
        $enable_slider = $settings['enable_slider'];
        $slides_to_show = $settings['slides_to_show'];
        $unique_id = 'promen-certification-logos-' . $this->get_id();

        // Generate accessibility attributes
        $widget_id = $this->get_id();
        $container_id = Promen_Accessibility_Utils::generate_id('certification-logos', $widget_id);
        $title_id = Promen_Accessibility_Utils::generate_id('certification-title', $widget_id);
        $description_id = Promen_Accessibility_Utils::generate_id('certification-description', $widget_id);

        // Wrapper classes
        $wrapper_classes = ['promen-certification-logos', 'promen-widget'];
        
        // Start output
        ?>
        <section class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>" 
                 id="<?php echo esc_attr($container_id); ?>"
                 role="region" 
                 aria-labelledby="<?php echo $settings['show_title'] === 'yes' ? esc_attr($title_id) : ''; ?>"
                 aria-describedby="<?php echo $settings['show_description'] === 'yes' && !empty($settings['description_text']) ? esc_attr($description_id) : ''; ?>"
                 aria-label="<?php echo esc_attr__('Overzicht van alle certificeringen en kwaliteitskeurmerken die wij hebben behaald', 'promen-elementor-widgets'); ?>">
            
            <?php if ($settings['show_title'] === 'yes'): ?>
                <header class="certification-title-wrapper">
                    <?php 
                    $title_settings = $settings;
                    $title_settings['title_id'] = $title_id;
                    echo promen_render_split_title($this, $title_settings, 'title', 'certification'); 
                    ?>
                </header>
            <?php endif; ?>

            <?php if ($settings['show_description'] === 'yes' && !empty($settings['description_text'])): ?>
                <p class="certification-description" id="<?php echo esc_attr($description_id); ?>">
                    <?php echo esc_html($settings['description_text']); ?>
                </p>
            <?php endif; ?>

            <div class="logos-grid" 
                 role="list" 
                 aria-label="<?php echo esc_attr__('Overzicht van alle certificeringen en kwaliteitskeurmerken die wij hebben behaald', 'promen-elementor-widgets'); ?>">
                <?php foreach ($logos as $index => $logo): ?>
                    <div class="certification-logo" 
                         role="listitem"
                         tabindex="0"
                         aria-label="<?php echo esc_attr(sprintf(__('Certificeringslogo %d van %d in het overzicht', 'promen-elementor-widgets'), $index + 1, count($logos))); ?>">
                        <?php if (!empty($logo['logo_link']['url'])): ?>
                            <a href="<?php echo esc_url($logo['logo_link']['url']); ?>"
                               <?php echo $logo['logo_link']['is_external'] ? ' target="_blank"' : ''; ?>
                               <?php echo $logo['logo_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                               aria-label="<?php echo esc_attr(sprintf(__('Bezoek de certificeringspagina van %s voor meer informatie', 'promen-elementor-widgets'), $logo['logo_name'])); ?>">
                        <?php endif; ?>

                        <?php if (!empty($logo['logo_image']['url'])): ?>
                            <img src="<?php echo esc_url($logo['logo_image']['url']); ?>"
                                 alt="<?php echo esc_attr($logo['logo_name'] ?: sprintf(__('Certification logo %d', 'promen-elementor-widgets'), $index + 1)); ?>"
                                 loading="lazy">
                        <?php endif; ?>

                        <?php if (!empty($logo['logo_link']['url'])): ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if ($enable_slider === 'yes'): ?>
            <div class="mobile-slider swiper" 
                 style="display: none;"
                 role="region" 
                 aria-label="<?php echo esc_attr__('Interactieve carrousel met certificeringslogo\'s die u kunt doorbladeren', 'promen-elementor-widgets'); ?>"
                 aria-live="polite">
                <div class="swiper-wrapper" role="list" aria-label="<?php echo esc_attr__('Certification logos', 'promen-elementor-widgets'); ?>">
                    <?php foreach ($logos as $index => $logo): ?>
                        <div class="certification-logo swiper-slide" 
                             role="listitem"
                             tabindex="0"
                             aria-label="<?php echo esc_attr(sprintf(__('Certificeringslogo %d van %d in het overzicht', 'promen-elementor-widgets'), $index + 1, count($logos))); ?>">
                            <?php if (!empty($logo['logo_link']['url'])): ?>
                                <a href="<?php echo esc_url($logo['logo_link']['url']); ?>"
                                   <?php echo $logo['logo_link']['is_external'] ? ' target="_blank"' : ''; ?>
                                   <?php echo $logo['logo_link']['nofollow'] ? ' rel="nofollow"' : ''; ?>
                                   aria-label="<?php echo esc_attr(sprintf(__('Bezoek de certificeringspagina van %s voor meer informatie', 'promen-elementor-widgets'), $logo['logo_name'])); ?>">
                            <?php endif; ?>

                            <?php if (!empty($logo['logo_image']['url'])): ?>
                                <img src="<?php echo esc_url($logo['logo_image']['url']); ?>"
                                     alt="<?php echo esc_attr($logo['logo_name'] ?: sprintf(__('Certification logo %d', 'promen-elementor-widgets'), $index + 1)); ?>"
                                     loading="lazy">
                            <?php endif; ?>

                            <?php if (!empty($logo['logo_link']['url'])): ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Add Navigation -->
                <button class="swiper-button-next" 
                        type="button"
                        aria-label="<?php echo esc_attr__('Ga naar het volgende certificeringslogo in de carrousel', 'promen-elementor-widgets'); ?>">
                    <span class="screen-reader-text"><?php echo esc_html__('Next certification logo', 'promen-elementor-widgets'); ?></span>
                </button>
                <button class="swiper-button-prev" 
                        type="button"
                        aria-label="<?php echo esc_attr__('Ga naar het vorige certificeringslogo in de carrousel', 'promen-elementor-widgets'); ?>">
                    <span class="screen-reader-text"><?php echo esc_html__('Previous certification logo', 'promen-elementor-widgets'); ?></span>
                </button>
                <!-- Add Pagination -->
                <div class="swiper-pagination" 
                     role="tablist" 
                     aria-label="<?php echo esc_attr__('Paginering om door verschillende certificeringslogo\'s te navigeren', 'promen-elementor-widgets'); ?>"></div>
            </div>
            <?php endif; ?>
        </section>

        <?php if ($enable_slider === 'yes'): ?>
        <script>
            jQuery(document).ready(function($) {
                let logoSwiper = null;
                const mobileSlider = $('#<?php echo esc_js($unique_id); ?> .mobile-slider');
                const logosGrid = $('#<?php echo esc_js($unique_id); ?> .logos-grid');

                const initSwiper = function() {
                    if (window.innerWidth < 1024) {
                        if (!logoSwiper) {
                            mobileSlider.show();
                            logosGrid.hide();
                            
                            logoSwiper = new Swiper('#<?php echo esc_js($unique_id); ?> .mobile-slider', {
                                slidesPerView: 1,
                                spaceBetween: 30,
                                watchOverflow: true,
                                loop: <?php echo count($logos) > 1 ? 'true' : 'false'; ?>,
                                autoplay: {
                                    delay: 3000,
                                    disableOnInteraction: false,
                                },
                                pagination: {
                                    el: '#<?php echo esc_js($unique_id); ?> .swiper-pagination',
                                    clickable: true,
                                },
                                navigation: {
                                    nextEl: '#<?php echo esc_js($unique_id); ?> .swiper-button-next',
                                    prevEl: '#<?php echo esc_js($unique_id); ?> .swiper-button-prev',
                                },
                                breakpoints: {
                                    320: {
                                        slidesPerView: 1,
                                        spaceBetween: 20
                                    },
                                    480: {
                                        slidesPerView: 2,
                                        spaceBetween: 20
                                    },
                                    768: {
                                        slidesPerView: 3,
                                        spaceBetween: 30
                                    }
                                }
                            });
                        }
                    } else {
                        if (logoSwiper) {
                            logoSwiper.destroy(true, true);
                            logoSwiper = null;
                            mobileSlider.hide();
                            logosGrid.show();
                        }
                    }
                };

                // Initialize on page load
                initSwiper();

                // Handle window resize
                let resizeTimer;
                $(window).on('resize', function() {
                    clearTimeout(resizeTimer);
                    resizeTimer = setTimeout(function() {
                        initSwiper();
                    }, 250);
                });

                // Handle Elementor editor changes
                if (window.elementorFrontend && window.elementorFrontend.hooks) {
                    elementorFrontend.hooks.addAction('frontend/element_ready/promen_certification_logos.default', function() {
                        initSwiper();
                    });
                }
            });
        </script>
        <?php endif;
    }
} 