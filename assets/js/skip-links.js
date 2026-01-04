/**
 * Skip Links JavaScript
 *
 * Handles skip link navigation and focus management for accessibility.
 *
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

(function () {
    'use strict';

    /**
     * Initialize skip links functionality
     */
    function initSkipLinks() {
        var skipLinks = document.querySelectorAll('.widget-skip-link');

        skipLinks.forEach(function (skipLink) {
            var widgetId = skipLink.getAttribute('data-widget-id');
            if (!widgetId) return;

            // Elementor creates wrapper with ID: elementor-widget-{id}
            var elementorWrapperId = 'elementor-widget-' + widgetId;
            var elementorWrapper = document.getElementById(elementorWrapperId);

            if (elementorWrapper) {
                // Ensure the wrapper has scroll-margin for proper scrolling
                elementorWrapper.style.scrollMarginTop = '20px';
                elementorWrapper.style.scrollMarginBottom = '20px';

                // Update skip link href if needed
                var currentHref = skipLink.getAttribute('href');
                if (currentHref !== '#' + elementorWrapperId) {
                    skipLink.setAttribute('href', '#' + elementorWrapperId);
                }

                // Handle click to ensure smooth scroll
                skipLink.addEventListener('click', handleSkipLinkClick);
            }
        });
    }

    /**
     * Handle skip link click
     *
     * @param {Event} e Click event
     */
    function handleSkipLinkClick(e) {
        e.preventDefault();

        var href = this.getAttribute('href');
        if (!href || href === '#') return;

        var targetId = href.substring(1);
        var target = document.getElementById(targetId);

        if (target) {
            // Smooth scroll to target
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Focus the first focusable element in the widget
            var focusable = target.querySelector(
                'a[href], button:not([disabled]), textarea:not([disabled]), ' +
                'input:not([disabled]):not([type="hidden"]), select:not([disabled]), ' +
                '[tabindex]:not([tabindex="-1"])'
            );

            if (focusable) {
                setTimeout(function () {
                    focusable.focus();
                }, 300);
            } else {
                // If no focusable element, make the container temporarily focusable
                if (!target.hasAttribute('tabindex')) {
                    target.setAttribute('tabindex', '-1');
                }
                setTimeout(function () {
                    target.focus();
                }, 300);
            }
        }
    }

    /**
     * Initialize on DOM ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSkipLinks);
    } else {
        initSkipLinks();
    }

    // Re-initialize when Elementor editor updates (for live preview)
    if (typeof elementorFrontend !== 'undefined') {
        jQuery(window).on('elementor/frontend/init', function () {
            elementorFrontend.hooks.addAction('frontend/element_ready/global', function () {
                initSkipLinks();
            });
        });
    }
})();
