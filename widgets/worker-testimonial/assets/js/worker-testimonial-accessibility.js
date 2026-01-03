/**
 * Worker Testimonial Widget - Accessibility Enhancements
 * 
 * @package Promen\Widgets
 * @since 1.0.0
 * 
 * Uses global PromenAccessibility core library.
 */

(function ($) {
    'use strict';

    /**
     * Get localized string helper
     */
    function getString(key, ...args) {
        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.getString) {
            return PromenAccessibility.getString(key, ...args);
        }
        const fallbacks = {
            exitedTestimonial: 'Exited testimonial',
            testimonial: 'Testimonial',
            exitedTestimonial: 'Exited testimonial',
            testimonial: 'Testimonial',
            testimonialBy: 'by {0}',
            skipTestimonial: 'Skip worker testimonial'
        };
        let str = fallbacks[key] || key;
        args.forEach((arg, index) => {
            str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
        });
        return str;
    }

    /**
     * Worker Testimonial Accessibility Class
     */
    class WorkerTestimonialAccessibility {
        constructor() {
            this.init();
        }

        /**
         * Initialize accessibility features
         */
        init() {
            this.setupKeyboardNavigation();
            this.setupFocusManagement();
            this.setupFocusManagement();

            // Add reduced motion support and skip links
            $('.worker-testimonial').each(function () {
                PromenAccessibility.setupReducedMotion(this);
                PromenAccessibility.setupSkipLink(this, getString('skipTestimonial', 'Sla over werknemer testimonial'));
            });

            this.validateColorContrast();
        }

        /**
         * Setup keyboard navigation
         */
        setupKeyboardNavigation() {
            $(document).on('keydown', '.worker-testimonial', (e) => {
                const $widget = $(e.currentTarget);

                // Handle Enter and Space key activation
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.announceTestimonial($widget);
                }

                // Handle Escape key to reset focus
                if (e.key === 'Escape') {
                    $widget.blur();
                    PromenAccessibility.announce(getString('exitedTestimonial'));
                }
            });

            // Make testimonial focusable
            $(document).on('focus', '.worker-testimonial', function () {
                $(this).attr('tabindex', '0');
                // Optional: Announce focus via global announcer if needed, or rely on native reading behavior.
            });

            $(document).on('blur', '.worker-testimonial', function () {
                $(this).removeAttr('tabindex');
            });
        }

        /**
         * Setup focus management
         */
        setupFocusManagement() {
            // Ensure proper focus indicators
            $(document).on('focusin', '.worker-testimonial', function () {
                $(this).addClass('worker-testimonial--focused');
            });

            $(document).on('focusout', '.worker-testimonial', function () {
                $(this).removeClass('worker-testimonial--focused');
            });

            // Use Core Focus Trap if navigating inside
            // Note: The original code had a custom tab handler. 
            // If the testimonial has internal interactive elements, we might want a trap, 
            // but usually for a card, we just want flow through. 
            // The original handler was: if no focusable elements, make widget focusable.
            // That logic is covered by setupKeyboardNavigation's focus/blur handlers mostly, 
            // but let's check for focusable elements to ensure keyboard accessibility.

            $(document).on('mouseenter', '.worker-testimonial', function () {
                if ($(this).find('a, button, input').length === 0) {
                    $(this).attr('tabindex', '0');
                }
            });
        }

        /**
         * Announce testimonial content to screen readers via Core
         * @param {jQuery} $widget - The testimonial widget element
         */
        announceTestimonial($widget) {
            const quote = $widget.find('.worker-testimonial__quote').text().trim();
            const name = $widget.find('.worker-testimonial__name').text().trim();

            let announcement = '';
            if (quote) {
                announcement += `${getString('testimonial')}: ${quote}`;
            }
            if (name) {
                announcement += ` ${getString('testimonialBy', name)}`;
            }

            if (announcement) {
                PromenAccessibility.announce(announcement);
            }
        }

        /**
         * Validate color contrast
         */
        validateColorContrast() {
            $('.worker-testimonial').each(function () {
                const $widget = $(this);
                const $quote = $widget.find('.worker-testimonial__quote');
                const $name = $widget.find('.worker-testimonial__name');

                // Check if elements have sufficient contrast
                if ($quote.length) {
                    this.checkContrast($quote);
                }
                if ($name.length) {
                    this.checkContrast($name);
                }
            });
        }

        /**
         * Check color contrast for an element
         * @param {jQuery} $element - The element to check
         */
        checkContrast($element) {
            const color = $element.css('color');
            const backgroundColor = $element.css('background-color');

            // Basic contrast check (simplified)
            if (color && backgroundColor) {
                if (color === backgroundColor) {
                    $element.addClass('contrast-warning');
                }
            }
        }
    }

    /**
     * Initialize when DOM is ready
     */
    $(document).ready(function () {
        new WorkerTestimonialAccessibility();
    });

    /**
     * Re-initialize for dynamically loaded content
     */
    $(document).on('elementor/popup/show', function () {
        setTimeout(() => {
            new WorkerTestimonialAccessibility();
        }, 100);
    });

})(jQuery);