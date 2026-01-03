/**
 * Promen Image Text Block Widget Accessibility JavaScript
 * Implements WCAG 2.2 compliant keyboard navigation and ARIA management
 * 
 * Uses global PromenAccessibility core library.
 */
(function ($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function () {
        initImageTextBlockAccessibility();
    });

    // Initialize when Elementor frontend is initialized (for editor preview)
    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_image_text_block.default', initImageTextBlockAccessibility);
        }
    });

    /**
     * Initialize accessibility features for all image text blocks
     */
    function initImageTextBlockAccessibility() {
        $('.promen-image-text-block').each(function () {
            initSingleBlockAccessibility($(this));
        });
    }

    /**
     * Initialize accessibility features for a single image text block
     */
    function initSingleBlockAccessibility($block) {
        if ($block.length === 0) {
            return;
        }

        // Initialize tabs accessibility if in tabs mode
        if ($block.hasClass('promen-image-text-block--tabs') || $block.hasClass('promen-tabs-mode')) {
            initTabsAccessibility($block);
        }

        // Initialize button accessibility
        initButtonAccessibility($block);

        // Initialize image accessibility
        initImageAccessibility($block);

        // Initialize skip links
        initSkipLinks($block);

        // Initialize reduced motion
        PromenAccessibility.setupReducedMotion($block[0]);
    }

    /**
     * Initialize tabs accessibility with keyboard navigation
     */
    /**
     * Initialize tabs accessibility with Core Library
     */
    function initTabsAccessibility($block) {
        PromenAccessibility.setupTabs($block[0]);

        // Add event listener to sync images when tabs change (custom logic needing preservation)
        const tabs = $block.find('[role="tab"]');
        tabs.on('click keydown', function (e) {
            // Wait for core to update attributes
            setTimeout(() => {
                const activeTabId = $block.find('[role="tab"][aria-selected="true"]').attr('id');
                if (activeTabId) {
                    syncTabImages($block, activeTabId);
                }
            }, 10);
        });
    }

    function syncTabImages($block, tabId) {
        $block.find('.promen-tab-image').each(function () {
            var $this = $(this);
            var isActive = $this.data('tab') === tabId;

            $this.toggleClass('active', isActive);
            $this.toggleClass('promen-tab-hidden', !isActive);
            $this.attr('aria-hidden', !isActive);

            if (isActive) {
                $this.css({ 'display': 'block', 'opacity': '1', 'visibility': 'visible' });
            } else {
                $this.css({ 'display': 'none', 'opacity': '0', 'visibility': 'hidden' });
            }
        });
    }

    /**
     * Initialize button accessibility
     */
    function initButtonAccessibility($block) {
        var $buttons = $block.find('.promen-image-text-block__button');

        $buttons.each(function () {
            var $button = $(this);

            // Ensure proper focus indicators
            $button.on('focus', function () {
                $(this).addClass('focused');
            }).on('blur', function () {
                $(this).removeClass('focused');
            });

            // Handle keyboard activation
            $button.on('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    }

    /**
     * Initialize image accessibility
     */
    function initImageAccessibility($block) {
        var $images = $block.find('img');

        $images.each(function () {
            var $img = $(this);

            // Ensure all images have alt attributes
            if (!$img.attr('alt')) {
                $img.attr('alt', 'Content image');
            }

            // Add loading and decoding attributes for performance
            if (!$img.attr('loading')) {
                $img.attr('loading', 'lazy');
            }
            if (!$img.attr('decoding')) {
                $img.attr('decoding', 'async');
            }
        });
    }

    /**
     * Initialize skip links for keyboard navigation
     */
    /**
     * Initialize skip links for keyboard navigation
     */
    function initSkipLinks($block) {
        PromenAccessibility.setupSkipLink($block[0], 'Skip to Image Text Block content');
    }

    /**
     * Programmatically switch to a specific tab
     * @param {jQuery} $block The widget block element
     * @param {string} tabId The ID of the tab to switch to
     */
    function switchToTab($block, tabId) {
        const tab = $block.find(`[role="tab"][id="${tabId}"]`);
        if (tab.length > 0) {
            tab.click();
        }
    }

    // Expose functions for external use
    window.PromenImageTextBlockAccessibility = {
        switchToTab: switchToTab,
        initSingleBlockAccessibility: initSingleBlockAccessibility
    };

})(jQuery);