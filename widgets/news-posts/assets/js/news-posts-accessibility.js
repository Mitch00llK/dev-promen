/**
 * News Posts Widget Accessibility Enhancements
 * 
 * This script provides additional accessibility features for the News Posts widget
 * to ensure WCAG 2.2 compliance.
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
            modalClosed: 'Modal closed',
            loadedItems: 'Loaded {0} {1}',
            item: 'item',
            items: 'items',
            newsCarouselLabel: 'Content carousel',
            previousSlide: 'Previous slide',
            nextSlide: 'Next slide',
            sliderPagination: 'Slider pagination',
            goToSlide: 'Go to slide {0}',
            skipToContent: 'Skip to content'
        };
        let str = fallbacks[key] || key;
        args.forEach((arg, index) => {
            str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
        });
        return str;
    }

    // Initialize accessibility features when DOM is ready
    $(document).ready(function () {
        initializeAccessibilityFeatures();
    });

    /**
     * Re-initialize for dynamically loaded content
     */
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_content_posts_grid.default', function ($element) {
                initializeAccessibilityFeatures();
            });
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

    function initializeAccessibilityFeatures() {
        enhanceKeyboardNavigation();
        addSkipLinks();
        enhanceScreenReaderSupport();
        enhanceModalAccessibility();
        enhanceScreenReaderSupport();
        enhanceModalAccessibility();
        enhanceSliderAccessibility();

        // Add reduced motion support
        $('.promen-content-posts-widget').each(function () {
            PromenAccessibility.setupReducedMotion(this);
        });
    }

    /**
     * Enhance keyboard navigation for all interactive elements
     */
    function enhanceKeyboardNavigation() {
        // Add keyboard support for read more links and buttons
        $(document).on('keydown', '.promen-content-read-more, .promen-content-header-button, .promen-content-footer-button', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                // Simulate click or navigation
                if (this.tagName === 'A') {
                    window.location.href = this.href;
                } else {
                    $(this).click();
                }
            }
        });

        // Add escape key support for modals or overlays
        $(document).on('keydown', function (e) {
            if (e.key === 'Escape') {
                // Close any open modals or overlays
                const $activeModal = $('.promen-content-modal.active, .promen-content-overlay.active');
                if ($activeModal.length) {
                    $activeModal.removeClass('active');
                    $activeModal.trigger('modalClosed');
                    PromenAccessibility.announce(getString('modalClosed'));
                }
            }
        });
    }

    /**
     * Add skip links for keyboard navigation
     */
    function addSkipLinks() {
        $('.promen-content-posts-widget').each(function () {
            const $widget = $(this);
            const widgetId = $widget.attr('id') || 'promen-content-widget-' + Math.random().toString(36).substr(2, 9);

            if (!$widget.find('.promen-content-skip-link').length) {
                const skipLinkText = getString('skipToContent');
                const skipLink = $('<a href="#' + widgetId + '" class="promen-content-skip-link skip-link">' + skipLinkText + '</a>');
                $widget.prepend(skipLink);
                $widget.attr('id', widgetId);

                // Add basic skip link behavior if standard one isn't caught
                skipLink.on('click', function (e) {
                    e.preventDefault();
                    const targetId = $(this).attr('href');
                    const $target = $(targetId);
                    $target.attr('tabindex', '-1').focus();
                });
            }
        });
    }

    /**
     * Enhance screen reader support
     */
    function enhanceScreenReaderSupport() {
        // Announce when content is loaded
        $('.promen-content-posts-widget').each(function () {
            const $widget = $(this);
            // Verify if this is a fresh load or dynamic update before announcing to avoid spam
            if (!$widget.data('announced-load')) {
                const postCount = $widget.find('.promen-content-card-wrapper').length;
                if (postCount > 0) {
                    // Debounce announcement slightly to ensure it's not buried
                    setTimeout(() => {
                        const itemWord = postCount === 1 ? getString('item') : getString('items');
                        PromenAccessibility.announce(getString('loadedItems', postCount, itemWord));
                    }, 500);
                    $widget.data('announced-load', true);
                }
            }
        });

        // Add descriptive text for images
        $('.promen-content-image').each(function () {
            const $img = $(this);
            const alt = $img.attr('alt');

            if (!alt || alt.trim() === '') {
                $img.attr('alt', 'Content image');
            }
        });
    }

    /**
     * Enhance modal accessibility
     */
    function enhanceModalAccessibility() {
        // Use global focus trap when modals are opened
        // Assuming there's a trigger for opening modals, we should hook into it.
        // For now, we'll initialize focus trap on any existing active modals or when they become active.

        // Watch for class changes to detect modal opening if no direct event is available
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.attributeName === 'class') {
                    const $target = $(mutation.target);
                    if ($target.hasClass('active') && ($target.hasClass('promen-content-modal') || $target.hasClass('promen-content-overlay'))) {
                        PromenAccessibility.initFocusTrap($target[0]);
                        $target.find(':focusable').first().focus();
                    }
                }
            });
        });

        $('.promen-content-modal, .promen-content-overlay').each(function () {
            observer.observe(this, { attributes: true });
        });
    }

    /**
     * Enhance slider accessibility
     */
    function enhanceSliderAccessibility() {
        $('.promen-news-slider').each(function () {
            const $slider = $(this);
            const sliderId = $slider.attr('id');

            if (sliderId) {
                // Add proper ARIA labels
                $slider.attr('aria-label', getString('newsCarouselLabel'));

                // Enhance navigation buttons
                $slider.find('.swiper-button-prev, .swiper-button-next').each(function () {
                    const $button = $(this);
                    const isPrev = $button.hasClass('swiper-button-prev');
                    const label = isPrev ? getString('previousSlide') : getString('nextSlide');

                    $button.attr({
                        'aria-label': label,
                        'type': 'button',
                        'role': 'button',
                        'tabindex': '0'
                    });

                    // Add keyboard support specifically for these
                    PromenAccessibility.addKeyboardClick(this);
                });

                // Enhance pagination
                const $pagination = $slider.find('.swiper-pagination');
                if ($pagination.length) {
                    $pagination.attr({
                        'role': 'tablist',
                        'aria-label': getString('sliderPagination')
                    });

                    $pagination.find('.swiper-pagination-bullet').each(function (index) {
                        $(this).attr({
                            'role': 'tab',
                            'aria-label': getString('goToSlide', index + 1),
                            'tabindex': '0'
                        });
                        PromenAccessibility.addKeyboardClick(this);
                    });
                }
            }
        });
    }

})(jQuery);