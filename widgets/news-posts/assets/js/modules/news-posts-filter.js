/**
 * News Posts Widget Filter Functionality
 */

(function ($) {
    'use strict';

    function initFiltering() {
        $('.promen-content-posts-widget').each(function () {
            var $widget = $(this);
            var widgetId = $widget.attr('id');
            var $grid = $widget.find('.promen-content-grid');

            if (!$grid.length) return;

            var $filterButtons = $widget.find('.content-filter-button');
            if (!$filterButtons.length) return;

            // Initial state: show all
            $grid.find('.promen-content-card-wrapper').show();

            $filterButtons.off('click').on('click', function () {
                var $btn = $(this);

                // Update active state
                $filterButtons.removeClass('active').attr('aria-selected', 'false');
                $btn.addClass('active').attr('aria-selected', 'true');

                var filter = $btn.data('filter');
                var filterText = $btn.text().trim();

                // Announce to screen readers
                var announcement = document.createElement('div');
                announcement.setAttribute('aria-live', 'polite');
                announcement.setAttribute('aria-atomic', 'true');
                announcement.className = 'sr-only';
                announcement.textContent = 'Filtered to show ' + (filter === 'all' ? 'all job listings' : filterText + ' job listings');
                document.body.appendChild(announcement);
                setTimeout(function () {
                    document.body.removeChild(announcement);
                }, 1000);

                // Filter items
                var visibleCount = 0;
                $grid.find('.promen-content-card-wrapper').each(function () {
                    var $item = $(this);
                    if (filter === 'all') {
                        $item.show();
                        visibleCount++;
                    } else {
                        var categories = $item.data('categories');
                        if (categories && categories.toString().includes(filter)) {
                            $item.show();
                            visibleCount++;
                        } else {
                            $item.hide();
                        }
                    }
                });

                // Update grid aria label
                $grid.attr('aria-label', 'Job listings grid showing ' + visibleCount + (visibleCount === 1 ? ' listing' : ' listings'));
            });

            // Keyboard accessibility
            $filterButtons.on('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    $(this).click();
                }
            });
        });
    }

    // Initialize on document ready
    $(document).ready(function () {
        initFiltering();
    });

    // Initialize on Elementor frontend action
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_news_posts.default', function ($scope) {
            initFiltering();
        });
    });

})(jQuery);
