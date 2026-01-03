/**
 * Worker Testimonial Widget - Accessibility Enhancements
 * 
 * @package Promen\Widgets
 * @since 1.0.0
 */

(function($) {
    'use strict';

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
            this.setupScreenReaderSupport();
            this.setupFocusManagement();
            this.setupReducedMotion();
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
                }
            });

            // Make testimonial focusable
            $(document).on('focus', '.worker-testimonial', function() {
                $(this).attr('tabindex', '0');
            });

            $(document).on('blur', '.worker-testimonial', function() {
                $(this).removeAttr('tabindex');
            });
        }

        /**
         * Setup screen reader support
         */
        setupScreenReaderSupport() {
            // Add live region for dynamic announcements
            if (!$('#worker-testimonial-live-region').length) {
                $('body').append('<div id="worker-testimonial-live-region" class="sr-only" aria-live="polite" aria-atomic="true"></div>');
            }

            // Announce testimonial content on focus
            $(document).on('focus', '.worker-testimonial', (e) => {
                const $widget = $(e.currentTarget);
                this.announceTestimonial($widget);
            });
        }

        /**
         * Setup focus management
         */
        setupFocusManagement() {
            // Ensure proper focus indicators
            $(document).on('focusin', '.worker-testimonial', function() {
                $(this).addClass('worker-testimonial--focused');
            });

            $(document).on('focusout', '.worker-testimonial', function() {
                $(this).removeClass('worker-testimonial--focused');
            });

            // Handle focus trap for better navigation
            $(document).on('keydown', '.worker-testimonial', (e) => {
                if (e.key === 'Tab') {
                    this.handleTabNavigation(e);
                }
            });
        }

        /**
         * Setup reduced motion support
         */
        setupReducedMotion() {
            // Check for reduced motion preference
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                $('.worker-testimonial').addClass('worker-testimonial--reduced-motion');
            }

            // Listen for changes in motion preference
            window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', (e) => {
                if (e.matches) {
                    $('.worker-testimonial').addClass('worker-testimonial--reduced-motion');
                } else {
                    $('.worker-testimonial').removeClass('worker-testimonial--reduced-motion');
                }
            });
        }

        /**
         * Announce testimonial content to screen readers
         * @param {jQuery} $widget - The testimonial widget element
         */
        announceTestimonial($widget) {
            const quote = $widget.find('.worker-testimonial__quote').text().trim();
            const name = $widget.find('.worker-testimonial__name').text().trim();

            let announcement = '';
            if (quote) {
                announcement += `Testimonial: ${quote}`;
            }
            if (name) {
                announcement += ` by ${name}`;
            }

            if (announcement) {
                $('#worker-testimonial-live-region').text(announcement);
            }
        }

        /**
         * Handle tab navigation within testimonial
         * @param {Event} e - The keyboard event
         */
        handleTabNavigation(e) {
            const $widget = $(e.currentTarget);
            const $focusableElements = $widget.find('a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])');

            if ($focusableElements.length === 0) {
                // If no focusable elements, make the widget itself focusable
                $widget.attr('tabindex', '0');
            }
        }

        /**
         * Validate color contrast
         */
        validateColorContrast() {
            $('.worker-testimonial').each(function() {
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
                // Add warning class if contrast might be insufficient
                // This is a simplified check - in production, use a proper contrast calculation library
                if (color === backgroundColor) {
                    $element.addClass('contrast-warning');
                }
            }
        }
    }

    /**
     * Initialize when DOM is ready
     */
    $(document).ready(function() {
        new WorkerTestimonialAccessibility();
    });

    /**
     * Re-initialize for dynamically loaded content
     */
    $(document).on('elementor/popup/show', function() {
        setTimeout(() => {
            new WorkerTestimonialAccessibility();
        }, 100);
    });

})(jQuery);