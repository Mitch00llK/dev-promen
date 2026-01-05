/**
 * Image Text Slider Content Logic
 * 
 * Simplified for unified slider architecture.
 * Most content visibility functions are no longer needed since
 * content is now inside each slide (no separate content Swiper).
 */
(function (window) {
    "use strict";

    /**
     * Log the current order of slides for debugging purposes
     * @param {Swiper} swiper - The Swiper instance
     * @param {string} context - Context message for the log
     */
    function logSlideOrder(swiper, context) {
        if (!swiper || !swiper.slides || swiper.slides.length === 0) return;

        if (window.debugImageTextSlider) {
            console.log(`[Slider Debug] ${context}`, {
                activeIndex: swiper.activeIndex,
                realIndex: swiper.realIndex,
                slideCount: swiper.slides.length
            });
        }
    }

    /**
     * Ensures content has the correct alignment in the frontend view.
     * Simplified for unified slider - just handles single-slide detection.
     */
    function ensureStaticContentAlignment() {
        // Only apply to non-editor views
        if (document.body.classList.contains('elementor-editor-active')) {
            return;
        }

        // Get all slider containers
        document.querySelectorAll('.image-text-slider-container').forEach(slider => {
            // Check if this is a single-slide setup
            const slideCount = slider.querySelectorAll('.swiper .swiper-slide').length;
            if (slideCount <= 1) {
                slider.classList.add('single-slide');
            } else {
                slider.classList.remove('single-slide');
            }
        });
    }

    // Expose helpers needed by main slider logic via namespace
    // Note: updateContentSlideVisibility and forceHideInactiveContentSlides
    // are no longer needed with unified slider architecture
    window.PromenSliderContent = {
        logSlideOrder,
        ensureStaticContentAlignment,
        // Keep empty stubs for backward compatibility if called from elsewhere
        updateSlideVisibility: function () { },
        updateContentSlideVisibility: function () { },
        forceHideInactiveContentSlides: function () { }
    };

    // Also expose global functions for legacy/init compatibility
    window.ensureStaticContentAlignment = ensureStaticContentAlignment;
    window.forceHideInactiveContentSlides = function () { }; // No-op stub

})(window);
