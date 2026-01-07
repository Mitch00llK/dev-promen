/**
 * News Posts Widget Initialization
 * 
 * This script ensures the grid is visible and removes loading state.
 */

(function ($) {
    'use strict';

    // Function to show grid and remove loading state
    function initializeWidget() {
        $('.promen-content-posts-widget').each(function () {
            var $widget = $(this);
            var $grid = $widget.find('.promen-content-grid');

            // Ensure widget is ready
            if (!$widget.length || !$grid.length) {
                return;
            }

            // Always show grid - remove any inline styles that might hide it
            $grid.css({
                'display': 'grid',
                'visibility': 'visible',
                'opacity': '1'
            });

            // Remove loading class to show content
            $widget.removeClass('promen-widget-loading');
        });
    }

    // Initialize immediately
    function initImmediate() {
        // Mark widget as JS-enabled for CSS fallback
        $('.promen-content-posts-widget').addClass('js-enabled');

        // Show grid immediately
        $('.promen-content-posts-widget .promen-content-grid').css({
            'display': 'grid',
            'visibility': 'visible',
            'opacity': '1'
        });

        // Remove loading class immediately
        $('.promen-content-posts-widget').removeClass('promen-widget-loading');
    }

    // Run immediately if DOM is ready, otherwise wait
    if (document.readyState === 'loading') {
        $(document).ready(function () {
            initImmediate();
            initializeWidget();
        });
    } else {
        initImmediate();
        initializeWidget();
    }

    // Initialize on document ready (for widgets added dynamically)
    $(document).ready(function () {
        // Fallback: Show widget after 500ms if initialization hasn't completed
        var fallbackTimer = setTimeout(function () {
            $('.promen-content-posts-widget.promen-widget-loading').each(function () {
                var $widget = $(this);
                var $grid = $widget.find('.promen-content-grid');

                $grid.css({
                    'display': 'grid',
                    'visibility': 'visible',
                    'opacity': '1'
                });

                $widget.removeClass('promen-widget-loading');
            });
        }, 500);

        // Initialize after a short delay to ensure DOM is ready
        setTimeout(function () {
            initializeWidget();
            clearTimeout(fallbackTimer);
        }, 50);

        // Also handle window load to ensure images are loaded
        $(window).on('load', function () {
            initializeWidget();
        });

        // Handle Elementor frontend init (for when widget is added or edited in Elementor)
        const initElementorHooks = () => {
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction('frontend/element_ready/promen_content_posts_grid.default', function ($element) {
                    setTimeout(function () {
                        initializeWidget();
                    }, 50);
                });
            }
        };

        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            initElementorHooks();
        } else {
            window.addEventListener('elementor/frontend/init', initElementorHooks);
        }
    });

})(jQuery);