/**
 * Image Text Slider Configuration
 * Performance settings and global state
 */
(function (window) {
    "use strict";

    // Global instances tracker
    window.imageTextSliderInstances = window.imageTextSliderInstances || new Map();

    // Debug flag
    window.debugImageTextSlider = false;

    // Configuration and Environment Check
    window.PromenSliderConfig = {
        isMobile: window.innerWidth <= 768,
        isLowEndDevice: navigator.hardwareConcurrency <= 2 ||
            navigator.deviceMemory <= 4 ||
            /Android.*4\.|iPhone.*OS [5-9]_/.test(navigator.userAgent)
    };

    /**
     * Monitor performance and adjust settings for mobile
     */
    function monitorPerformance() {
        if (!window.imageTextSliderInstances || !window.PromenSliderConfig.isMobile) return;

        window.imageTextSliderInstances.forEach((instance, id) => {
            const { swiper, element, options } = instance;

            // Check if autoplay is causing performance issues
            if (swiper && swiper.autoplay && swiper.autoplay.running) {
                const rect = element.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

                // Pause autoplay when slider is out of viewport
                if (!isVisible && !swiper.autoplay.paused) {
                    swiper.autoplay.pause();
                } else if (isVisible && swiper.autoplay.paused) {
                    swiper.autoplay.start();
                }
            }

            // Disable observers on very low-end devices after a while
            if (window.PromenSliderConfig.isLowEndDevice && swiper) {
                swiper.observer = false;
                swiper.observeParents = false;
                swiper.observeSlideChildren = false;
            }
        });
    }

    // Expose performance monitor
    window.monitorPerformance = monitorPerformance;

})(window);
