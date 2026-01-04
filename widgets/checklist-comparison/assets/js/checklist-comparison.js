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
            // Setup reduced motion
            var $widgetEl = $widget[0];
            if ($widgetEl) {
                PromenAccessibility.setupReducedMotion($widgetEl);
                PromenAccessibility.setupSkipLink($widgetEl, getString('skipToContent'));
            }
        }
    };

    // Make sure we initialize the widget when it's ready in Elementor
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_checklist_comparison.default', ChecklistComparisonHandler);
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

})(jQuery);