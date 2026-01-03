/**
 * Promen Image Text Block Widget JavaScript
 */
(function ($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function () {
        initImageTextBlocks();
    });

    // Initialize when Elementor frontend is initialized (for editor preview)
    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_image_text_block.default', initImageTextBlock);
        }
    });

    // Initialize all image text blocks
    function initImageTextBlocks() {
        $('.promen-image-text-block').each(function () {
            initImageTextBlock($(this));
        });
    }

    // Initialize a single image text block
    function initImageTextBlock($scope) {
        var $block = $scope.hasClass('promen-image-text-block') ? $scope : $scope.find('.promen-image-text-block');

        if ($block.length === 0) {
            return;
        }


        // Handle layout switching in the Elementor editor
        if (typeof elementor !== 'undefined') {
            // This code runs only in the Elementor editor
            elementor.channels.editor.on('change', function (view) {
                var changedElement = view.elementSettingsModel;

                // Check if the changed control is the layout control
                if (changedElement.get('layout')) {
                    var newLayout = changedElement.get('layout');
                    updateLayout($block, newLayout);
                }

                // Check if the display mode has changed
                if (changedElement.get('display_mode')) {
                    var displayMode = changedElement.get('display_mode');
                }

                // Check if responsive stacking options have changed
                if (changedElement.get('stack_on_tablet') !== undefined || changedElement.get('stack_on_mobile') !== undefined) {
                    // Re-apply layout to handle stacking changes
                    var currentLayout = $block.hasClass('image-right') ? 'image-right' : 'image-left';
                    updateLayout($block, currentLayout);
                }
            });
        }

        // Initialize tabs if in tabs mode
        if ($block.hasClass('promen-image-text-block--tabs') || $block.hasClass('promen-tabs-mode')) {
            initTabs($block);

            // Handle resize events for responsive behavior
            $(window).on('resize', function () {
                adjustTabsForScreenSize($block);
            });

            // Initial adjustment
            adjustTabsForScreenSize($block);
        }
    }

    // Update the layout of the block
    function updateLayout($block, layout) {
        // Remove existing layout classes
        $block.removeClass('image-left image-right');
        $block.removeClass('promen-image-text-block--left promen-image-text-block--right');

        // Add the new layout class
        $block.addClass(layout);

        // Set the appropriate class based on the layout
        if (layout === 'image-left') {
            $block.addClass('promen-image-text-block--left');
        } else if (layout === 'image-right') {
            $block.addClass('promen-image-text-block--right');
        }

        // Get the content and image wrappers
        var $contentWrapper = $block.find('.promen-image-text-content-wrapper, .promen-image-text-block__content-wrapper');
        var $imageWrapper = $block.find('.promen-image-text-image-wrapper, .promen-image-text-block__image-wrapper');

        // Check window width for responsive behavior
        var windowWidth = $(window).width();
        var isTablet = windowWidth <= 1024 && windowWidth > 767;
        var isMobile = windowWidth <= 767;

        // Check if stacking is enabled for current device
        var stackOnTablet = $block.hasClass('stack-on-tablet');
        var stackOnMobile = $block.hasClass('stack-on-mobile');

        // Determine if we should stack based on device and settings
        var shouldStack = (isTablet && stackOnTablet) || (isMobile && stackOnMobile);

        if (shouldStack) {
            // Stack vertically - content always comes before image on mobile/tablet
            $contentWrapper.css('order', '1');
            $imageWrapper.css('order', '2');
        } else {
            // Set the order based on layout for desktop or when stacking is disabled
            if (layout === 'image-right') {
                $contentWrapper.css('order', '1');
                $imageWrapper.css('order', '2');
            } else {
                $contentWrapper.css('order', '2');
                $imageWrapper.css('order', '1');
            }
        }

    }

    // Adjust tabs based on screen size
    function adjustTabsForScreenSize($block) {
        var windowWidth = $(window).width();
        var layout = $block.hasClass('image-right') ? 'image-right' : 'image-left';
        var isTablet = windowWidth <= 1024 && windowWidth > 767;
        var isMobile = windowWidth <= 767;

        // Check if stacking is enabled for current device
        var stackOnTablet = $block.hasClass('stack-on-tablet');
        var stackOnMobile = $block.hasClass('stack-on-mobile');

        // Determine if we should stack based on device and settings
        var shouldStack = (isTablet && stackOnTablet) || (isMobile && stackOnMobile);

        if (shouldStack) {
            // Mobile/tablet view adjustments
            var $contentWrapper = $block.find('.promen-image-text-content-wrapper, .promen-image-text-block__content-wrapper');
            var $imageWrapper = $block.find('.promen-image-text-image-wrapper, .promen-image-text-block__image-wrapper');

            // Make sure content comes before image on mobile/tablet
            $contentWrapper.css('order', '1');
            $imageWrapper.css('order', '2');
        } else {
            // Desktop view - reset order based on layout
            updateLayout($block, layout);
        }
    }

    // Initialize tabs functionality
    function initTabs($block) {

        // Find all tab elements
        var $tabTitles = $block.find('.promen-tab-title, .promen-image-text-block__tab');
        var $tabContents = $block.find('.promen-tab-content, .promen-image-text-block__tab-content');
        var $tabImages = $block.find('.promen-tab-image, .promen-image-text-block__image');
        var $tabsContentWrapper = $block.find('.promen-tabs-content-wrapper, .promen-image-text-block__tabs-content');


        // First, remove any existing click handlers to prevent duplicates
        $tabTitles.off('click');

        // Calculate and set the maximum height of all tab contents to prevent jumping
        function setTabContentHeight() {
            // Reset height first
            $tabsContentWrapper.css('height', 'auto');

            // Store the current scroll position
            var scrollTop = $(window).scrollTop();

            // Find the tallest tab content
            var maxHeight = 0;
            $tabContents.each(function () {
                // Determine if this content is active/visible
                // We check this BEFORE resetting styles because the reset below wipes inline display styles
                var isVisible = $content.css('display') === 'block';
                var hasHiddenAttr = $content.is('[hidden]');
                var hasActiveClass = $content.hasClass('active');
                var ariaHiddenFalse = $content.attr('aria-hidden') === 'false';

                // It is active if:
                // 1. It has .active class (Legacy & Sync)
                // 2. It does NOT have the [hidden] attribute (Core A11y)
                // 3. It currently has display: block (Core A11y inline style)
                var isActive = hasActiveClass || !hasHiddenAttr || isVisible || ariaHiddenFalse;

                // Temporarily make it visible to measure
                $content.css({
                    'position': 'relative',
                    'visibility': 'hidden',
                    'display': 'block',
                    'opacity': 0,
                    'height': 'auto'
                });

                // Get the full height including all children
                var contentHeight = $content.outerHeight(true);
                maxHeight = Math.max(maxHeight, contentHeight);

                // Reset back
                $content.css({
                    'position': '',
                    'visibility': '',
                    'display': '',
                    'opacity': '',
                    'height': ''
                });

                if (isActive) {
                    $content.css({
                        'display': 'block',
                        'opacity': 1,
                        'visibility': 'visible',
                        'position': 'relative'
                    });
                    // Ensure [hidden] is removed if we are forcing it visible
                    $content.removeAttr('hidden');
                } else {
                    $content.css({
                        'display': 'none',
                        'opacity': 0,
                        'visibility': 'hidden'
                    });
                    // Ensure [hidden] is added if we are forcing it hidden
                    $content.attr('hidden', '');
                }
            });

            // Set the height of the container to the max height plus some padding
            if (maxHeight > 0) {
                $tabsContentWrapper.css('height', (maxHeight + 20) + 'px');

                // After a short delay, restore the scroll position
                setTimeout(function () {
                    $(window).scrollTop(scrollTop);
                }, 10);
            }
        }

        // Then add our new click handler (accessibility-compatible)
        $tabTitles.on('click', function (e) {
            e.preventDefault();
            // Use accessibility-compatible tab switching
            if (typeof window.PromenImageTextBlockAccessibility !== 'undefined') {
                // Do nothing, let event bubble to PromenAccessibility core
            } else {
                e.stopPropagation();
                // Fallback to original method
                switchTabLegacy($clickedTab, $block, tabId);
            }

        });

        // Initialize the first tab
        if ($tabTitles.length > 0) {
            // Ensure first tab is properly active
            var $firstTab = $tabTitles.first();
            var firstTabId = $firstTab.data('tab');

            // Clear all active states first
            $tabTitles.removeClass('active');
            $tabContents.removeClass('active').addClass('promen-tab-hidden');
            $tabImages.removeClass('active').addClass('promen-tab-hidden');

            // Set first tab as active
            $firstTab.addClass('active');

            if (firstTabId) {
                var $firstContent = $block.find('[data-tab="' + firstTabId + '"].promen-tab-content, [data-tab="' + firstTabId + '"].promen-image-text-block__tab-content');
                var $firstImage = $block.find('[data-tab="' + firstTabId + '"].promen-tab-image');

                if ($firstContent.length === 0) {
                    $firstContent = $block.find('#' + firstTabId);
                }

                if ($firstContent.length > 0) {
                    $firstContent.removeClass('promen-tab-hidden').addClass('active').css({
                        'display': 'block',
                        'opacity': 1,
                        'visibility': 'visible',
                        'position': 'relative'
                    });
                }

                if ($firstImage.length > 0) {
                    $firstImage.removeClass('promen-tab-hidden').addClass('active').css({
                        'display': 'block',
                        'opacity': 1,
                        'visibility': 'visible'
                    });
                }
            }


        }
    }

    /**
     * Legacy tab switching function (fallback)
     */
    function switchTabLegacy($clickedTab, $block, tabId) {
        var $tabTitles = $block.find('.promen-tab-title, .promen-image-text-block__tab');
        var $tabContents = $block.find('.promen-tab-content, .promen-image-text-block__tab-content');
        var $tabImages = $block.find('.promen-tab-image, .promen-image-text-block__image');

        // 1. Update active state for tab titles
        $tabTitles.removeClass('active');
        $clickedTab.addClass('active');

        // 2. Hide all content and images
        $tabContents.removeClass('active').addClass('promen-tab-hidden').css({
            'display': 'none',
            'opacity': 0,
            'visibility': 'hidden'
        });

        $tabImages.removeClass('active').addClass('promen-tab-hidden').css({
            'display': 'none',
            'opacity': 0,
            'visibility': 'hidden'
        });

        // 3. Show the selected content and image
        var $selectedContent = $block.find('[data-tab="' + tabId + '"].promen-tab-content, [data-tab="' + tabId + '"].promen-image-text-block__tab-content');
        var $selectedImage = $block.find('[data-tab="' + tabId + '"].promen-tab-image');

        // If we couldn't find the content by data-tab, try by ID
        if ($selectedContent.length === 0) {
            $selectedContent = $block.find('#' + tabId);
        }

        // Show the content and image with animation
        if ($selectedContent.length > 0) {
            $selectedContent.removeClass('promen-tab-hidden').addClass('active').css({
                'display': 'block',
                'opacity': 1,
                'visibility': 'visible',
                'position': 'relative'
            });
        }

        if ($selectedImage.length > 0) {
            $selectedImage.removeClass('promen-tab-hidden').addClass('active').css({
                'display': 'block',
                'opacity': 1,
                'visibility': 'visible'
            });

            // Add animation to the image
            $selectedImage.removeClass('tab-image-animate');
            setTimeout(function () {
                $selectedImage.addClass('tab-image-animate');
            }, 10);
        }
    }

})(jQuery);