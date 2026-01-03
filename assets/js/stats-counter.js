(function($) {
    'use strict';

    // Counter animation function
    function animateCounter(element, duration) {
        const $counters = $(element).find('.promen-counter-number');

        $counters.each(function() {
            const $this = $(this);
            const finalValue = parseInt($this.attr('data-count'), 10);

            // Only animate if we have a valid number
            if (!isNaN(finalValue)) {
                $({ countValue: 0 }).animate({ countValue: finalValue }, {
                    duration: duration || 2000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countValue));
                    },
                    complete: function() {
                        $this.text(finalValue);
                    }
                });
            }
        });
    }

    // Make animateCounter globally available for accessibility module
    window.animateCounter = animateCounter;

    // Initialize counters on page load
    $(document).ready(function() {
        // Function to check if element is in viewport
        function isElementInViewport(el) {
            if (!el.length) return false;

            const rect = el[0].getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        }

        // Handle counter animation on scroll
        const $counterContainers = $('.promen-stats-counter-container[data-animation="true"]');

        if ($counterContainers.length) {
            // Store which containers have been animated
            const animatedContainers = new Set();

            // Check on scroll and on page load
            function checkCounters() {
                $counterContainers.each(function() {
                    const $container = $(this);
                    const containerId = $container.attr('id') || $container.index();

                    // Skip if already animated
                    if (animatedContainers.has(containerId)) return;

                    if (isElementInViewport($container)) {
                        const duration = parseInt($container.attr('data-animation-duration'), 10) || 2000;
                        animateCounter($container, duration);
                        animatedContainers.add(containerId);
                    }
                });

                // If all containers are animated, remove scroll listener
                if (animatedContainers.size === $counterContainers.length) {
                    $(window).off('scroll.statsCounter');
                }
            }

            // Initial check
            checkCounters();

            // Check on scroll
            $(window).on('scroll.statsCounter', checkCounters);
        }

        // For Elementor editor
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_stats_counter.default', function($scope) {
                const $container = $scope.find('.promen-stats-counter-container');

                // Initialize accessibility features
                if (typeof StatsCounterAccessibility !== 'undefined') {
                    new StatsCounterAccessibility($container[0]);
                }

                if ($container.attr('data-animation') === 'true') {
                    const duration = parseInt($container.attr('data-animation-duration'), 10) || 2000;
                    animateCounter($container, duration);
                }
            });
        }
    });

})(jQuery);