/**
 * Checklist Comparison Widget JavaScript
 */

(function ($) {
    "use strict";

    // Initialize widget functionality
    var ChecklistComparisonHandler = function ($scope, $) {
        // Get the widget container
        var $widget = $scope.find('.promen-checklist-comparison');

        if (!$widget.length) {
            return;
        }

        // Initialize any necessary functionality here
        const adjustIconSizes = () => {
            // Find all icon containers
            const $icons = $widget.find('.promen-checklist-comparison__item-icon');

            // Adjust custom icon sizes if needed
            $icons.each(function () {
                const $icon = $(this);
                const $svg = $icon.find('svg');
                const $i = $icon.find('i');

                // Make any adjustments needed to custom icons here
                if ($i.length) {
                    // For example, ensure proper vertical alignment
                    $i.css('line-height', '1');
                }
            });
        };

        // Run adjustments
        adjustIconSizes();

        // Integrate with PromenAccessibility if available
        if (typeof PromenAccessibility !== 'undefined') {
            // Example: Check high contrast mode to potentially adjust icon visibility if needed
            // Currently no specific logic required but connection is established.
        }
    };

    // Make sure we initialize the widget when it's ready in Elementor
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_checklist_comparison.default', ChecklistComparisonHandler);
    });

})(jQuery);