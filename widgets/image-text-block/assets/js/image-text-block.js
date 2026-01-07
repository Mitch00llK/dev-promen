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

})(jQuery);