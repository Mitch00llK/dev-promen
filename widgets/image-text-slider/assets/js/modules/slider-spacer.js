/**
 * Image Text Slider Spacer Logic
 * Handles dynamic spacing calculations and resize events
 */
(function (window) {
    "use strict";

    /**
     * Position the bottom spacers for all sliders
     */
    function positionSliderSpacers() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function (slider) {
            // Find internal spacer first
            let spacer = slider.querySelector('.slider-bottom-spacer');

            // Fallback: Create spacer if it doesn't exist internally
            if (!spacer) {
                spacer = document.createElement('div');
                spacer.classList.add('slider-bottom-spacer');
                slider.appendChild(spacer);
            }

            updateSpacerPosition(slider, spacer);

            // Force the next element to have proper z-index
            if (slider.nextElementSibling) {
                slider.nextElementSibling.style.position = 'relative';
                slider.nextElementSibling.style.zIndex = '0';
            }
        });
    }

    /**
     * Update the spacer position for a specific slider
     * @param {HTMLElement} slider - The slider container
     * @param {HTMLElement} spacer - The spacer element
     */
    function updateSpacerPosition(slider, spacer) {
        if (!slider || !spacer) return;

        // Function to perform the actual measurement
        const measure = () => {
            // Force reflow
            void slider.offsetHeight;

            const sliderRect = slider.getBoundingClientRect();
            const sliderBottom = sliderRect.bottom;

            // UNCONDITIONAL DEBUG LOG
            // console.log('Running Spacer Measurement:', { id: slider.id, rect: sliderRect, bottom: sliderBottom });

            // Find the active content slide
            // We look for both the active slide in the content swiper AND potentially static content
            let activeContent = slider.querySelector('.swiper-content-slider .swiper-slide-active .slide-content-container');

            // Fallback: if no active slide found (e.g. initialization), try the first visible one
            if (!activeContent) {
                activeContent = slider.querySelector('.swiper-content-slider .swiper-slide .slide-content-container');
            }

            if (!activeContent) {
                // No content found, reset spacer
                spacer.style.height = '1px';
                spacer.style.marginTop = '-1px';
                return;
            }

            // Measure content bottom position
            const contentRect = activeContent.getBoundingClientRect();
            const contentBottom = contentRect.bottom;

            // Calculate overlap
            // If content extends below slider: contentBottom > sliderBottom
            const overlap = contentBottom - sliderBottom;

            if (window.debugImageTextSlider) {
                console.log('Spacer Debug:', {
                    sliderBottom,
                    contentBottom,
                    overlap,
                    contentElement: activeContent
                });
            }

            if (overlap > 0) {
                // Content overlaps, expand spacer
                // Add 30px buffer to be safe
                const newHeight = Math.ceil(overlap + 30);
                spacer.style.height = newHeight + 'px';
                spacer.style.marginTop = '-1px'; // Keep negative margin to start from slider bottom
                spacer.style.display = 'block';
            } else {
                // No overlap, collapse spacer but keep it present
                spacer.style.height = '1px';
            }
        };

        // Run immediately
        measure();

        // And again after a short delay to account for any transitions/rendering
        window.requestAnimationFrame(() => {
            measure();
            // Double check as layout settles
            window.requestAnimationFrame(measure);
        });
    }

    /**
     * Handle resize events for all sliders
     */
    function handleSliderResize() {
        // Debounce the resize handler
        clearTimeout(window.sliderResizeTimer);
        window.sliderResizeTimer = setTimeout(() => {
            positionSliderSpacers();

            // Reapply static content alignment (External dependency, check if exists)
            if (typeof window.ensureStaticContentAlignment === 'function') {
                window.ensureStaticContentAlignment();
            }

            // Force container below to redraw
            document.querySelectorAll('.image-text-slider-container').forEach(slider => {
                const spacer = slider.querySelector('.slider-bottom-spacer');
                if (spacer) {
                    updateSpacerPosition(slider, spacer);
                }
            });
        }, 150);
    }

    /**
     * Ensure proper spacing after sliders to prevent container overflow
     */
    function ensureProperSpacingAfterSliders() {
        positionSliderSpacers();
    }

    // Expose functions
    window.positionSliderSpacers = positionSliderSpacers;
    window.updateSpacerPosition = updateSpacerPosition;
    window.handleSliderResize = handleSliderResize;
    window.ensureProperSpacingAfterSliders = ensureProperSpacingAfterSliders;

})(window);
