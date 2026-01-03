/**
 * Testimonial Card Widget JavaScript
 */

(function($) {
    'use strict';

    // Initialize when Elementor frontend is loaded
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_testimonial_card.default', function($scope) {
            // Add any JavaScript functionality here if needed
            const $testimonialCard = $scope.find('.testimonial-card');

            // Example: Add a click event to the testimonial card
            $testimonialCard.on('click', function() {
                // Custom functionality when card is clicked
                // This is just a placeholder for future functionality
            });
        });
    });

})(jQuery);