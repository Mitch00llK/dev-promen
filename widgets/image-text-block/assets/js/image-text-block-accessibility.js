/**
 * Promen Image Text Block Widget Accessibility JavaScript
 * Handles WCAG 2.2 compliant tab switching, keyboard navigation, and ARIA management.
 */
(function ($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function () {
        $('.promen-image-text-block').each(function () {
            initAccessibility($(this));
        });
    });

    // Initialize when Elementor frontend is initialized
    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_image_text_block.default', function ($scope) {
                initAccessibility($scope.find('.promen-image-text-block'));
            });
        }
    });

    /**
     * Initialize accessibility features for a block
     */
    function initAccessibility($block) {
        if ($block.length === 0) return;

        // Only init tabs if in tabs mode
        if ($block.hasClass('promen-image-text-block--tabs') || $block.hasClass('promen-tabs-mode')) {
            initTabs($block);
        }

        // Setup reduced motion
        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.setupReducedMotion($block[0]);
            PromenAccessibility.setupSkipLink($block[0], PromenAccessibility.getString('skipImageTextBlock'));
        }
    }

    /**
     * Initialize tabs with proper accessibility and visual switching
     */
    function initTabs($block) {
        var $tabs = $block.find('[role="tab"]');
        var $panels = $block.find('[role="tabpanel"]');
        var $images = $block.find('.promen-tab-image');

        if ($tabs.length === 0) return;

        // Click handler for tabs
        $tabs.on('click', function (e) {
            e.preventDefault();
            activateTab($(this), $block, $tabs, $panels, $images);
        });

        // Keyboard navigation
        $tabs.on('keydown', function (e) {
            var $currentTab = $(this);
            var currentIndex = $tabs.index($currentTab);
            var targetIndex = currentIndex;

            switch (e.key) {
                case 'ArrowRight':
                    targetIndex = (currentIndex + 1) % $tabs.length;
                    break;
                case 'ArrowLeft':
                    targetIndex = (currentIndex - 1 + $tabs.length) % $tabs.length;
                    break;
                case 'Home':
                    targetIndex = 0;
                    break;
                case 'End':
                    targetIndex = $tabs.length - 1;
                    break;
                default:
                    return; // Don't prevent default for other keys
            }

            if (targetIndex !== currentIndex) {
                e.preventDefault();
                activateTab($tabs.eq(targetIndex), $block, $tabs, $panels, $images);
            }
        });
    }

    /**
     * Activate a specific tab and show its content
     */
    function activateTab($tab, $block, $tabs, $panels, $images) {
        var panelId = $tab.attr('aria-controls');
        var tabId = $tab.attr('id');

        // Deactivate all tabs
        $tabs.attr('aria-selected', 'false').attr('tabindex', '-1').removeClass('active');

        // Hide all panels
        $panels.each(function () {
            $(this)
                .attr('hidden', '')
                .attr('aria-hidden', 'true')
                .attr('tabindex', '-1')
                .removeClass('active')
                .addClass('promen-tab-hidden');
        });

        // Hide all images
        $images.each(function () {
            $(this)
                .attr('aria-hidden', 'true')
                .removeClass('active')
                .addClass('promen-tab-hidden');
        });

        // Activate clicked tab
        $tab.attr('aria-selected', 'true').attr('tabindex', '0').addClass('active');
        $tab.focus();

        // Show corresponding panel
        var $panel = $block.find('#' + panelId);
        if ($panel.length) {
            $panel
                .removeAttr('hidden')
                .attr('aria-hidden', 'false')
                .attr('tabindex', '0')
                .addClass('active')
                .removeClass('promen-tab-hidden');
        }

        // Show corresponding image (match by data-tab attribute)
        $images.each(function () {
            var $image = $(this);
            if ($image.data('tab') === tabId) {
                $image
                    .attr('aria-hidden', 'false')
                    .addClass('active')
                    .removeClass('promen-tab-hidden');
            }
        });

        // Announce to screen readers
        if (typeof PromenAccessibility !== 'undefined') {
            var label = $tab.text() || $tab.attr('aria-label');
            PromenAccessibility.announce('Tab ' + label + ' selected');
        }
    }

    // Expose for external use if needed
    window.PromenImageTextBlockAccessibility = {
        initAccessibility: initAccessibility
    };

})(jQuery);