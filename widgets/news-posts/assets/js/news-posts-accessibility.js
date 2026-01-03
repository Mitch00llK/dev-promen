/**
 * News Posts Widget Accessibility Enhancements
 * 
 * This script provides additional accessibility features for the News Posts widget
 * to ensure WCAG 2.2 compliance.
 */

(function($) {
    'use strict';

    // Initialize accessibility features when DOM is ready
    $(document).ready(function() {
        initializeAccessibilityFeatures();
    });

    // Initialize when Elementor frontend is ready
    $(document).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_content_posts_grid.default', function($element) {
                initializeAccessibilityFeatures();
            });
        }
    });

    function initializeAccessibilityFeatures() {
        enhanceKeyboardNavigation();
        addSkipLinks();
        enhanceScreenReaderSupport();
        addFocusManagement();
        enhanceSliderAccessibility();
    }

    /**
     * Enhance keyboard navigation for all interactive elements
     */
    function enhanceKeyboardNavigation() {
        // Add keyboard support for read more links
        $('.promen-content-read-more').each(function() {
            const $link = $(this);

            $link.on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    window.location.href = this.href;
                }
            });
        });

        // Add keyboard support for header and footer buttons
        $('.promen-content-header-button, .promen-content-footer-button').each(function() {
            const $button = $(this);

            $button.on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    window.location.href = this.href;
                }
            });
        });

        // Add escape key support for modals or overlays
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                // Close any open modals or overlays
                $('.promen-content-modal, .promen-content-overlay').removeClass('active');
            }
        });
    }

    /**
     * Add skip links for keyboard navigation
     */
    function addSkipLinks() {
        $('.promen-content-posts-widget').each(function() {
            const $widget = $(this);
            const widgetId = $widget.attr('id') || 'promen-content-widget-' + Math.random().toString(36).substr(2, 9);

            if (!$widget.find('.promen-content-skip-link').length) {
                const skipLink = $('<a href="#' + widgetId + '" class="promen-content-skip-link">Sla over naar inhoud</a>');
                $widget.prepend(skipLink);
                $widget.attr('id', widgetId);
            }
        });
    }

    /**
     * Enhance screen reader support
     */
    function enhanceScreenReaderSupport() {
        // Add live regions for dynamic content updates
        if (!$('#promen-live-region').length) {
            $('body').append('<div id="promen-live-region" aria-live="polite" aria-atomic="true" class="sr-only"></div>');
        }

        // Announce when content is loaded
        $('.promen-content-posts-widget').each(function() {
            const $widget = $(this);
            const postCount = $widget.find('.promen-content-card-wrapper').length;

            if (postCount > 0) {
                announceToScreenReader(`Loaded ${postCount} ${postCount === 1 ? 'item' : 'items'}`);
            }
        });

        // Add descriptive text for images
        $('.promen-content-image').each(function() {
            const $img = $(this);
            const alt = $img.attr('alt');

            if (!alt || alt.trim() === '') {
                $img.attr('alt', 'Content image');
            }
        });
    }

    /**
     * Add focus management
     */
    function addFocusManagement() {
        // Ensure focus is visible
        $('*').on('focus', function() {
            $(this).addClass('focus-visible');
        }).on('blur', function() {
            $(this).removeClass('focus-visible');
        });

        // Add focus trap for modals (if any)
        $('.promen-content-modal').each(function() {
            const $modal = $(this);
            const focusableElements = $modal.find('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
            const firstElement = focusableElements.first();
            const lastElement = focusableElements.last();

            $modal.on('keydown', function(e) {
                if (e.key === 'Tab') {
                    if (e.shiftKey) {
                        if (document.activeElement === firstElement[0]) {
                            e.preventDefault();
                            lastElement.focus();
                        }
                    } else {
                        if (document.activeElement === lastElement[0]) {
                            e.preventDefault();
                            firstElement.focus();
                        }
                    }
                }
            });
        });
    }

    /**
     * Enhance slider accessibility
     */
    function enhanceSliderAccessibility() {
        $('.promen-news-slider').each(function() {
            const $slider = $(this);
            const sliderId = $slider.attr('id');

            if (sliderId) {
                // Add proper ARIA labels
                $slider.attr('aria-label', 'Content carousel');

                // Enhance navigation buttons
                $slider.find('.swiper-button-prev, .swiper-button-next').each(function() {
                    const $button = $(this);
                    const isPrev = $button.hasClass('swiper-button-prev');
                    const label = isPrev ? 'Previous slide' : 'Next slide';

                    $button.attr({
                        'aria-label': label,
                        'type': 'button'
                    });
                });

                // Enhance pagination
                const $pagination = $slider.find('.swiper-pagination');
                if ($pagination.length) {
                    $pagination.attr({
                        'role': 'tablist',
                        'aria-label': 'Slider pagination'
                    });

                    $pagination.find('.swiper-pagination-bullet').each(function(index) {
                        $(this).attr({
                            'role': 'tab',
                            'aria-label': `Go to slide ${index + 1}`,
                            'tabindex': '0'
                        });
                    });
                }

                // Add keyboard support for slider
                $slider.on('keydown', function(e) {
                    if (e.key === 'ArrowLeft') {
                        e.preventDefault();
                        $slider.find('.swiper-button-prev').click();
                    } else if (e.key === 'ArrowRight') {
                        e.preventDefault();
                        $slider.find('.swiper-button-next').click();
                    }
                });
            }
        });
    }

    /**
     * Announce messages to screen readers
     */
    function announceToScreenReader(message) {
        const $liveRegion = $('#promen-live-region');
        if ($liveRegion.length) {
            $liveRegion.text(message);

            // Clear the message after a short delay
            setTimeout(function() {
                $liveRegion.text('');
            }, 1000);
        }
    }

    /**
     * Handle reduced motion preferences
     */
    function handleReducedMotion() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            // Disable autoplay for sliders
            $('.promen-news-slider').each(function() {
                const $slider = $(this);
                $slider.attr('data-autoplay', 'false');
            });

            // Add reduced motion class
            $('body').addClass('reduced-motion');
        }
    }

    // Initialize reduced motion handling
    if (window.matchMedia) {
        window.matchMedia('(prefers-reduced-motion: reduce)').addListener(handleReducedMotion);
        handleReducedMotion();
    }

    /**
     * Handle high contrast mode
     */
    function handleHighContrast() {
        if (window.matchMedia('(prefers-contrast: high)').matches) {
            $('body').addClass('high-contrast');
        }
    }

    // Initialize high contrast handling
    if (window.matchMedia) {
        window.matchMedia('(prefers-contrast: high)').addListener(handleHighContrast);
        handleHighContrast();
    }

    /**
     * Handle color scheme preferences
     */
    function handleColorScheme() {
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) {
            $('body').addClass('dark-mode');
        } else {
            $('body').removeClass('dark-mode');
        }
    }

    // Initialize color scheme handling
    if (window.matchMedia) {
        window.matchMedia('(prefers-color-scheme: dark)').addListener(handleColorScheme);
        handleColorScheme();
    }

})(jQuery);