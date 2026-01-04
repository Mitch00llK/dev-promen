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
                    if (slide !== activeSlide) {
                        // Apply strong hiding
                        slide.style.opacity = "0";
                        slide.style.visibility = "hidden";
                        slide.style.pointerEvents = "none";
                        slide.style.position = "absolute";
                        slide.style.zIndex = "0";
                    } else {
                        // Ensure active slide is fully visible
                        slide.style.opacity = "1";
                        slide.style.visibility = "visible";
                        slide.style.pointerEvents = "auto";
                        slide.style.position = "absolute";
                        slide.style.zIndex = "2";
                    }
                });
            }
        });
    }

    /**
     * Reset the content of a slide for GSAP animation
     */
    function resetSlideContent(slide) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');

        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow]);

        if (breadcrumbAbove) gsap.set(breadcrumbAbove, { opacity: 0, y: -15 });
        if (title) gsap.set(title, { opacity: 0, y: 20 });
        if (description) gsap.set(description, { opacity: 0, y: 20 });
        if (buttons) gsap.set(buttons, { opacity: 0, y: 20 });
        if (breadcrumbBelow) gsap.set(breadcrumbBelow, { opacity: 0, y: 15 });
    }

    /**
     * Show slide content immediately without animation
     */
    function showSlideContentWithoutAnimation(slide) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');

        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow]);

        if (breadcrumbAbove) gsap.set(breadcrumbAbove, { opacity: 1, y: 0, clearProps: "all" });
        if (title) gsap.set(title, { opacity: 1, y: 0, clearProps: "all" });
        if (description) gsap.set(description, { opacity: 1, y: 0, clearProps: "all" });
        if (buttons) gsap.set(buttons, { opacity: 1, y: 0, clearProps: "all" });
        if (breadcrumbBelow) gsap.set(breadcrumbBelow, { opacity: 1, y: 0, clearProps: "all" });
    }

    /**
     * Animate the content of a slide with GSAP
     */
    function animateSlideContent(slide, duration) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');

        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow]);

        const timeline = gsap.timeline({
            defaults: { duration: duration, ease: "power2.out", clearProps: "all" }
        });

        if (breadcrumbAbove) timeline.fromTo(breadcrumbAbove, { opacity: 0, y: -15 }, { opacity: 1, y: 0, duration: duration * 0.6 });
        if (title) timeline.fromTo(title, { opacity: 0, y: 20 }, { opacity: 1, y: 0 }, breadcrumbAbove ? "-=0.2" : 0);
        if (description) timeline.fromTo(description, { opacity: 0, y: 20 }, { opacity: 1, y: 0 }, "-=0.2");
        if (buttons) timeline.fromTo(buttons, { opacity: 0, y: 20 }, { opacity: 1, y: 0 }, "-=0.2");
        if (breadcrumbBelow) timeline.fromTo(breadcrumbBelow, { opacity: 0, y: 15 }, { opacity: 1, y: 0, duration: duration * 0.6 }, "-=0.2");
    }

    /**
     * Setup GSAP animations for the slider
     */
    function setupGsapAnimations(sliderEl, swiper, options) {
        if (!window.gsap) return;

        const duration = options.animationDuration || 0.7;
        const useLoop = swiper.params.loop;
        const animatedSlides = new Set();

        // Animate initial slide
        const initialSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
        if (initialSlide) {
            animateSlideContent(initialSlide, duration);
            const slideId = initialSlide.className.split(' ').find(cls => cls.startsWith('elementor-repeater-item-content-'));
            if (slideId) animatedSlides.add(slideId);
        }

        // Add event listeners for slide changes
        swiper.on('slideChangeTransitionStart', function () {
            const targetIndex = useLoop ? this.realIndex : this.activeIndex;
            const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
            contentSlides.forEach(slide => resetSlideContent(slide));

            if (sliderEl.contentSwiper && sliderEl.contentSwiper.slides) {
                const targetSlide = Array.from(sliderEl.contentSwiper.slides).find((slide, index) => {
                    if (useLoop) {
                        return (index % (sliderEl.contentSwiper.slides.length / 3)) === targetIndex;
                    } else {
                        return index === targetIndex;
                    }
                });

                if (targetSlide) {
                    showSlideContentWithoutAnimation(targetSlide);
                }
            }
        });

        swiper.on('slideChangeTransitionEnd', function () {
            const activeSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
            if (!activeSlide) return;

            const slideId = activeSlide.className.split(' ').find(cls => cls.startsWith('elementor-repeater-item-content-'));

            if (slideId && !animatedSlides.has(slideId)) {
                animateSlideContent(activeSlide, duration);
                animatedSlides.add(slideId);
            } else {
                showSlideContentWithoutAnimation(activeSlide);
            }
        });

        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.on('slideChangeTransitionEnd', function () {
                const activeSlide = this.slides[this.activeIndex];
                if (!activeSlide) return;
                const slideId = activeSlide.className.split(' ').find(cls => cls.startsWith('elementor-repeater-item-content-'));
                if (slideId && !animatedSlides.has(slideId)) {
                    animateSlideContent(activeSlide, duration);
                    animatedSlides.add(slideId);
                }
            });
        }
    }

    // Expose helpers needed by main slider logic via namespace
    window.PromenSliderContent = {
        logSlideOrder,
        updateSlideVisibility,
        updateContentSlideVisibility,
        setupGsapAnimations,
        resetSlideContent,
        showSlideContentWithoutAnimation,
        ensureStaticContentAlignment,
        forceHideInactiveContentSlides
    };

    // Also expose global functions for legacy/init compatibility
    window.ensureStaticContentAlignment = ensureStaticContentAlignment;
    window.forceHideInactiveContentSlides = forceHideInactiveContentSlides;

})(window);
