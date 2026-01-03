/**
 * Promen Image Text Block Widget JavaScript
 * Handles layout switching and responsive behavior.
 * Tab functionality is delegated to the accessibility script.
 */
(function ($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function () {
        $('.promen-image-text-block').each(function () {
            initImageTextBlock($(this));
        });
    });

    // Initialize when Elementor frontend is initialized (for editor preview)
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_image_text_block.default', function ($scope) {
                initImageTextBlock($scope.find('.promen-image-text-block'));
            });
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

    /**
     * Initialize a single image text block
     */
    function initImageTextBlock($block) {
        if ($block.length === 0) return;

        // Handle layout switching in the Elementor editor
        if (typeof elementor !== 'undefined') {
            elementor.channels.editor.on('change', function (view) {
                var changedElement = view.elementSettingsModel;
                if (changedElement.get('layout')) {
                    updateLayout($block, changedElement.get('layout'));
                }
            });
        }

        // Handle resize events for responsive layout
        $(window).on('resize', function () {
            adjustLayoutForScreenSize($block);
        });
        adjustLayoutForScreenSize($block);
    }

    /**
     * Update the layout direction (image-left or image-right)
     */
    function updateLayout($block, layout) {
        $block.removeClass('image-left image-right promen-image-text-block--left promen-image-text-block--right');
        $block.addClass(layout);

        if (layout === 'image-left') {
            $block.addClass('promen-image-text-block--left');
        } else if (layout === 'image-right') {
            $block.addClass('promen-image-text-block--right');
        }
    }

    /**
     * Adjust layout based on screen size and stacking settings
     */
    function adjustLayoutForScreenSize($block) {
        var windowWidth = $(window).width();
        var isTablet = windowWidth <= 1024 && windowWidth > 767;
        var isMobile = windowWidth <= 767;

        var stackOnTablet = $block.hasClass('stack-on-tablet');
        var stackOnMobile = $block.hasClass('stack-on-mobile');

        var $contentWrapper = $block.find('.promen-image-text-content-wrapper, .promen-image-text-block__content-wrapper');
        var $imageWrapper = $block.find('.promen-image-text-image-wrapper, .promen-image-text-block__image-wrapper');

        if ((isTablet && stackOnTablet) || (isMobile && stackOnMobile)) {
            // Stacked: content first, image second
            $contentWrapper.css('order', '1');
            $imageWrapper.css('order', '2');
        } else {
            // Desktop: order based on layout class
            var isImageRight = $block.hasClass('image-right') || $block.hasClass('promen-image-text-block--right');
            if (isImageRight) {
                $contentWrapper.css('order', '1');
                $imageWrapper.css('order', '2');
            } else {
                $contentWrapper.css('order', '2');
                $imageWrapper.css('order', '1');
            }
        }
    }

})(jQuery);