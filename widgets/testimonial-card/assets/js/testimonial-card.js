/**
 * Testimonial Card Widget JavaScript
 */

(function ($) {
    'use strict';

    // Initialize when Elementor frontend is loaded
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_testimonial_card.default', function ($scope) {
                // Add any JavaScript functionality here if needed
                const $testimonialCard = $scope.find('.testimonial-card');

                // Example: Add a click event to the testimonial card
                $testimonialCard.on('click', function () {
                    // Custom functionality when card is clicked
                    // This is just a placeholder for future functionality
                });
            });
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

})(jQuery);