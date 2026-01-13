<?php
/**
 * Render Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Promen_Contact_Info_Blocks_Render {

    /**
     * Render widget output on the frontend.
     */
    public static function render_widget($widget, $settings) {
        // Generate unique ID for animation and accessibility
        $widget_id = $widget->get_id();
        $container_id = Promen_Accessibility_Utils::generate_id('contact-info-blocks', $widget_id);
        $layout_class = 'horizontal' === ($settings['layout'] ?? 'vertical') ? 'contact-info-blocks--horizontal' : 'contact-info-blocks--vertical';
        $responsive_class = 'default' === ($settings['responsive_layout'] ?? 'default') ? '' : 'contact-info-blocks--stack-mobile';
        
        // Container attributes
        $container_class = "contact-info-blocks promen-widget {$layout_class} {$responsive_class}";
        $container_attributes = '';
        
        // GSAP animation preparation
        if ('yes' === ($settings['enable_animation'] ?? 'no')) {
            $container_class .= ' contact-info-blocks--animated';
            $animation_type = $settings['animation_type'] ?? 'fade-in';
            $animation_delay = $settings['animation_delay'] ?? 100;
            
            $container_attributes .= ' data-animation="' . esc_attr($animation_type) . '"';
            $container_attributes .= ' data-animation-delay="' . esc_attr($animation_delay) . '"';
            $container_attributes .= ' data-animation-id="' . esc_attr($widget_id) . '"';
        }
        
        // Count visible blocks for ARIA
        $visible_blocks_count = 0;
        if ('yes' === ($settings['show_address_block'] ?? 'yes')) $visible_blocks_count++;
        if ('yes' === ($settings['show_phone_block'] ?? 'yes')) $visible_blocks_count++;
        if ('yes' === ($settings['show_email_block'] ?? 'yes')) $visible_blocks_count++;
        ?>
        
        <section class="<?php echo esc_attr($container_class); ?>" 
                 id="<?php echo esc_attr($container_id); ?>"
                 role="region" 
                 aria-labelledby="<?php echo esc_attr($container_id); ?>-heading"
                 aria-describedby="<?php echo esc_attr($container_id); ?>-desc"
                 <?php echo $container_attributes; ?>>
            <h2 id="<?php echo esc_attr($container_id); ?>-heading" class="screen-reader-text">
                <?php echo esc_html__('Contactinformatie', 'promen-elementor-widgets'); ?>
            </h2>
            <p id="<?php echo esc_attr($container_id); ?>-desc" class="screen-reader-text">
                <?php echo esc_html(sprintf(__('Bevat %d contactinformatie blokken. Gebruik pijltjestoetsen om te navigeren.', 'promen-elementor-widgets'), $visible_blocks_count)); ?>
            </p>
            <ul class="contact-info-blocks__list" role="list" aria-label="<?php echo esc_attr__('Contactopties', 'promen-elementor-widgets'); ?>">
            <?php if ('yes' === ($settings['show_address_block'] ?? 'yes')) : 
                $address_id = Promen_Accessibility_Utils::generate_id('address-block', $widget_id);
                $address_heading_id = Promen_Accessibility_Utils::generate_id('address-heading', $widget_id);
            ?>
                <li class="contact-info-block contact-info-block--address" 
                    data-block-type="address"
                    id="<?php echo esc_attr($address_id); ?>"
                    role="listitem">
                    <article class="contact-info-block__inner" 
                             <?php if (!empty($settings['address_title'])) : ?>aria-labelledby="<?php echo esc_attr($address_heading_id); ?>"<?php endif; ?>
                             itemscope
                             itemtype="https://schema.org/PostalAddress">
                        <?php if (!empty($settings['address_icon']['value'])) : ?>
                            <div class="contact-info-icon<?php echo 'yes' === ($settings['icon_background_show'] ?? 'no') ? ' with-bg' : ''; ?>"
                                 aria-hidden="true">
                                <?php \Elementor\Icons_Manager::render_icon($settings['address_icon'], ['aria-hidden' => 'true']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['address_title'])) : 
                            $address_tag = $settings['address_title_tag'];
                        ?>
                            <<?php echo esc_html($address_tag); ?> class="contact-info-title" id="<?php echo esc_attr($address_heading_id); ?>">
                                <?php echo esc_html($settings['address_title']); ?>
                            </<?php echo esc_html($address_tag); ?>>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['address_content'])) : ?>
                            <address class="contact-info-content" itemprop="address">
                                <span itemprop="streetAddress"><?php echo esc_html($settings['address_content']); ?></span>
                            </address>
                        <?php endif; ?>
                    </article>
                </li>
            <?php endif; ?>
            
            <?php if ('yes' === ($settings['show_phone_block'] ?? 'yes')) : 
                $phone_id = Promen_Accessibility_Utils::generate_id('phone-block', $widget_id);
                $phone_heading_id = Promen_Accessibility_Utils::generate_id('phone-heading', $widget_id);
            ?>
                <li class="contact-info-block contact-info-block--phone" 
                    data-block-type="phone"
                    id="<?php echo esc_attr($phone_id); ?>"
                    role="listitem">
                    <article class="contact-info-block__inner" 
                             <?php if (!empty($settings['phone_title'])) : ?>aria-labelledby="<?php echo esc_attr($phone_heading_id); ?>"<?php endif; ?>
                             itemscope
                             itemtype="https://schema.org/ContactPoint">
                        <?php if (!empty($settings['phone_icon']['value'])) : ?>
                            <div class="contact-info-icon<?php echo 'yes' === ($settings['icon_background_show'] ?? 'no') ? ' with-bg' : ''; ?>"
                                 aria-hidden="true">
                                <?php \Elementor\Icons_Manager::render_icon($settings['phone_icon'], ['aria-hidden' => 'true']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['phone_title'])) : 
                            $phone_tag = $settings['phone_title_tag'];
                        ?>
                            <<?php echo esc_html($phone_tag); ?> class="contact-info-title" id="<?php echo esc_attr($phone_heading_id); ?>">
                                <?php echo esc_html($settings['phone_title']); ?>
                            </<?php echo esc_html($phone_tag); ?>>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['phone_number'])) : ?>
                            <div class="contact-info-content">
                                <?php if ('yes' === $settings['phone_link']) : 
                                    $phone_number = preg_replace('/[^0-9+]/', '', $settings['phone_number']);
                                ?>
                                    <a href="tel:<?php echo esc_attr($phone_number); ?>" 
                                       class="contact-info-link contact-info-link--phone"
                                       itemprop="telephone"
                                       aria-label="<?php echo esc_attr(sprintf(__('Bel %s', 'promen-elementor-widgets'), $settings['phone_number'])); ?>"
                                       rel="nofollow">
                                        <span aria-hidden="true"><?php echo esc_html($settings['phone_number']); ?></span>
                                        <span class="screen-reader-text"><?php echo esc_html(sprintf(__('Telefoonnummer: %s (klik om te bellen)', 'promen-elementor-widgets'), $settings['phone_number'])); ?></span>
                                    </a>
                                <?php else : ?>
                                    <span class="contact-info-text" itemprop="telephone"><?php echo esc_html($settings['phone_number']); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                </li>
            <?php endif; ?>
            
            <?php if ('yes' === ($settings['show_email_block'] ?? 'yes')) : 
                $email_id = Promen_Accessibility_Utils::generate_id('email-block', $widget_id);
                $email_heading_id = Promen_Accessibility_Utils::generate_id('email-heading', $widget_id);
            ?>
                <li class="contact-info-block contact-info-block--email" 
                    data-block-type="email"
                    id="<?php echo esc_attr($email_id); ?>"
                    role="listitem">
                    <article class="contact-info-block__inner" 
                             <?php if (!empty($settings['email_title'])) : ?>aria-labelledby="<?php echo esc_attr($email_heading_id); ?>"<?php endif; ?>
                             itemscope
                             itemtype="https://schema.org/ContactPoint">
                        <?php if (!empty($settings['email_icon']['value'])) : ?>
                            <div class="contact-info-icon<?php echo 'yes' === ($settings['icon_background_show'] ?? 'no') ? ' with-bg' : ''; ?>"
                                 aria-hidden="true">
                                <?php \Elementor\Icons_Manager::render_icon($settings['email_icon'], ['aria-hidden' => 'true']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['email_title'])) : 
                            $email_tag = $settings['email_title_tag'];
                        ?>
                            <<?php echo esc_html($email_tag); ?> class="contact-info-title" id="<?php echo esc_attr($email_heading_id); ?>">
                                <?php echo esc_html($settings['email_title']); ?>
                            </<?php echo esc_html($email_tag); ?>>
                        <?php endif; ?>
                        
                        <?php if (!empty($settings['email_address'])) : ?>
                            <div class="contact-info-content">
                                <?php if ('yes' === $settings['email_link']) : ?>
                                    <a href="mailto:<?php echo esc_attr($settings['email_address']); ?>" 
                                       class="contact-info-link contact-info-link--email"
                                       itemprop="email"
                                       aria-label="<?php echo esc_attr(sprintf(__('Stuur een e-mail naar %s', 'promen-elementor-widgets'), $settings['email_address'])); ?>"
                                       rel="nofollow">
                                        <span aria-hidden="true"><?php echo esc_html($settings['email_address']); ?></span>
                                        <span class="screen-reader-text"><?php echo esc_html(sprintf(__('E-mailadres: %s (klik om een e-mail te versturen)', 'promen-elementor-widgets'), $settings['email_address'])); ?></span>
                                    </a>
                                <?php else : ?>
                                    <span class="contact-info-text" itemprop="email"><?php echo esc_html($settings['email_address']); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </article>
                </li>
            <?php endif; ?>
            </ul>
        </section>
        
        <?php if ('yes' === $settings['enable_animation']) : ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof gsap !== 'undefined') {
                const animationContainer = document.querySelector('[data-animation-id="<?php echo esc_attr($widget_id); ?>"]');
                if (!animationContainer) return;
        
                const animationBlocks = animationContainer.querySelectorAll('.contact-info-block');
                const animationType = '<?php echo esc_js($animation_type); ?>';
                const staggerDelay = <?php echo esc_js($animation_delay); ?> / 1000;
                
                // Use PromenAccessibility for reduced motion check
                const prefersReducedMotion = typeof PromenAccessibility !== 'undefined' 
                    ? PromenAccessibility.systemPreferences.reducedMotion 
                    : window.matchMedia('(prefers-reduced-motion: reduce)').matches;
                
                if (prefersReducedMotion) {
                    // Ensure all blocks are visible immediately
                    gsap.set(animationBlocks, { opacity: 1, clearProps: 'all' });
                    return;
                }
                
                // Use Intersection Observer instead of ScrollTrigger for better performance
                const observer = new IntersectionObserver((entries) => {
                    const [entry] = entries;
                    
                    if (entry.isIntersecting) {
                        // Add will-change property just before animation
                        gsap.set(animationBlocks, {
                            willChange: "transform, opacity",
                            opacity: 0,
                            y: animationType === 'slide-up' ? 20 : 0,
                            x: animationType === 'slide-in' ? -20 : 0,
                            scale: animationType === 'scale-in' ? 0.9 : 1,
                            force3D: true // Better performance for transforms
                        });
                        
                        // Run the animation
                        gsap.to(animationBlocks, {
                            opacity: 1,
                            y: 0,
                            x: 0,
                            scale: 1,
                            stagger: staggerDelay,
                            duration: 0.8,
                            ease: 'power2.out',
                            onComplete: function() {
                                // Clean up will-change after animation completes
                                gsap.set(animationBlocks, { willChange: "" });
                                // Announce completion using PromenAccessibility if available
                                if (typeof PromenAccessibility !== 'undefined') {
                                    PromenAccessibility.announce('<?php echo esc_js(__('Contactinformatie geladen', 'promen-elementor-widgets')); ?>');
                                }
                            }
                        });
                        
                        // Once animation has run, disconnect observer
                        observer.disconnect();
                    }
                }, {
                    root: null,
                    threshold: 0.1,
                    rootMargin: '0px 0px -10% 0px'
                });
                
                observer.observe(animationContainer);
            }
        }, { passive: true });
        </script>
        <?php endif; ?>
        
        <?php
        // Generate responsive CSS for mobile breakpoints
        $tablet_breakpoint = isset($settings['tablet_breakpoint']) ? $settings['tablet_breakpoint'] : 768;
        $mobile_breakpoint = isset($settings['mobile_breakpoint']) ? $settings['mobile_breakpoint'] : 480;
        ?>
        <style>
        @media (max-width: <?php echo esc_attr($tablet_breakpoint); ?>px) {
            .contact-info-blocks--horizontal {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 20px;
            }
            
            .contact-info-blocks--horizontal .contact-info-block {
                flex: 0 0 calc(50% - 10px);
            }
        }
        
        @media (max-width: <?php echo esc_attr($mobile_breakpoint); ?>px) {
            .contact-info-blocks--horizontal .contact-info-block {
                flex: 0 0 100%;
            }
            
            .contact-info-blocks--stack-mobile {
                flex-direction: column;
            }
        }
        </style>
        <?php
    }
}
