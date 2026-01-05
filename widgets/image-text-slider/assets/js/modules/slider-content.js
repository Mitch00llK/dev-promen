/**
 * Image Text Slider Content Logic
 * Handles slide visibility, content synchronization, and animations
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

        const isMainSwiper = swiper.el.classList.contains('swiper') && !swiper.el.classList.contains('swiper-content-slider');

        if (isMainSwiper) {
            // Only log if debugging is enabled
            if (window.debugImageTextSlider) {
                // Implementation Details...
            }
        }
    }

    /**
     * Update slide visibility based on active, next, prev status
     * @param {Swiper} swiper - The Swiper instance
     */
    function updateSlideVisibility(swiper) {
        if (!swiper || !swiper.slides) return;

        swiper.slides.forEach(function (slide, index) {
            // Set all slides to hidden first
            slide.style.opacity = "0";
            slide.style.visibility = "hidden";

            // Make active, next and prev slides visible
            if (index === swiper.activeIndex ||
                (swiper.loop && (
                    // Handle loop edge cases properly
                    index === swiper.realIndex ||
                    index === swiper.activeIndex - 1 ||
                    index === swiper.activeIndex + 1 ||
                    // Handle wrap-around cases in loop mode
                    (swiper.activeIndex === 0 && index === swiper.slides.length - 1) ||
                    (swiper.activeIndex === swiper.slides.length - 1 && index === 0)
                )) ||
                (!swiper.loop && (
                    index === swiper.activeIndex - 1 ||
                    index === swiper.activeIndex + 1
                ))) {
                slide.style.opacity = "1";
                slide.style.visibility = "visible";
            }
        });
    }

    /**
     * Update content slide visibility based on active status
     * @param {Swiper} contentSwiper - The content Swiper instance
     */
    function updateContentSlideVisibility(contentSwiper) {
        if (!contentSwiper || !contentSwiper.slides) return;

        contentSwiper.slides.forEach(function (slide, index) {
            // Set all slides to hidden first
            slide.style.opacity = "0";
            slide.style.visibility = "hidden";
            slide.style.zIndex = "0";

            // We only want the active slide to be visible
            if (index === contentSwiper.activeIndex) {
                slide.style.opacity = "1";
                slide.style.visibility = "visible";
                slide.style.zIndex = "2";
            }
        });
    }

    /**
     * Ensures content slides have the correct static alignment in the frontend view
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

            // Get all content slides in this slider
            const contentSlides = slider.querySelectorAll('.swiper-content-slider .swiper-slide[class*="elementor-repeater-item-content"]');

            contentSlides.forEach(slide => {
                // Make sure the content slide respects the CSS styles we've defined
                slide.style.position = 'absolute';

                // If it's a multi-slide slider, ensure only active slide is visible
                if (slideCount > 1) {
                    if (slide.classList.contains('swiper-slide-active')) {
                        slide.style.opacity = '1';
                        slide.style.visibility = 'visible';

                        // Make sure content positioning is maintained
                        const slideContent = slide.querySelector('.slide-content-container');
                        if (slideContent) {
                            slideContent.style.visibility = 'visible';
                            slideContent.style.opacity = '1';
                        }
                    } else {
                        slide.style.opacity = '0';
                        slide.style.visibility = 'hidden';
                    }
                } else {
                    // For single slides, always make them visible
                    slide.style.opacity = '1';
                    slide.style.visibility = 'visible';
                }
            });
        });
    }

    /**
     * Forcefully hide all non-active content slides
     */
    function forceHideInactiveContentSlides() {
        document.querySelectorAll('.image-text-slider-container').forEach(slider => {
            const contentSlides = slider.querySelectorAll('.swiper-content-slider .swiper-slide');

            // First identify the active slide
            let activeSlide = null;
            contentSlides.forEach(slide => {
                if (slide.classList.contains('swiper-slide-active')) {
                    activeSlide = slide;
                }
            });

            // If we found an active slide, hide all others
            if (activeSlide) {
                contentSlides.forEach(slide => {
                    const isActive = slide.classList.contains('swiper-slide-active');
                    if (!isActive) {
                        // Apply strong hiding only if not active
                        // We rely on Swiper to handle opacity during transitions usually, 
                        // but to fix ghost clicks we must ensure pointer-events: none
                        // We do NOT strictly force opacity to 0 here to avoid fighting with Swiper's fade effect 
                        slide.style.pointerEvents = "none";
                        slide.style.zIndex = "0";
                    } else {
                        // Ensure active slide is interactive
                        slide.style.pointerEvents = "auto";
                        slide.style.zIndex = "2";
                    }
                });
            }
        });
    }

    // Expose helpers needed by main slider logic via namespace
    window.PromenSliderContent = {
        logSlideOrder,
        updateSlideVisibility,
        updateContentSlideVisibility,
        ensureStaticContentAlignment,
        forceHideInactiveContentSlides
    };

    // Also expose global functions for legacy/init compatibility
    window.ensureStaticContentAlignment = ensureStaticContentAlignment;
    window.forceHideInactiveContentSlides = forceHideInactiveContentSlides;

})(window);
