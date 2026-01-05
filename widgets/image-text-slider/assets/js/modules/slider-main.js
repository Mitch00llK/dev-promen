/**
 * Image Text Slider Core Logic
 * Handles initialization and management of the slider instances
 * 
 * Aggregates functionality from focused modules:
 * - slider-config.js
 * - slider-spacer.js
 * - slider-content.js
 * - slider-editor.js
 */
(function (window, $) {
    "use strict";

    // Dependencies - with defensive checks
    const AccessibilityUtils = window.PromenAccessibilityUtils || {};
    const Utils = window.PromenSliderUtils || {};
    const debounce = Utils.debounce || function (fn) { return fn; };
    const throttle = Utils.throttle || function (fn) { return fn; };
    const BrowserCompatibility = Utils.BrowserCompatibility || { applyBrowserFixes: function (el, opt) { return opt; } };

    // Modules - with defensive checks
    const ContentUtils = window.PromenSliderContent || {};
    const Config = window.PromenSliderConfig || { isMobile: false, isLowEndDevice: false };

    /**
     * Initialize all image text sliders on the page
     */
    function initImageTextSliders() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function (slider) {
            initImageTextSlider(slider);
        });
    }

    /**
     * Initialize a single slider with Swiper
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function initImageTextSlider(sliderEl) {
        if (!sliderEl) {
            return;
        }

        // Retry if Swiper is not loaded yet
        if (typeof Swiper === 'undefined') {
            setTimeout(function () {
                initImageTextSlider(sliderEl);
            }, 500);
            return;
        }

        // If slider already initialized, destroy it first
        if (sliderEl.swiper) {
            sliderEl.swiper.destroy(true, true);
        }

        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.destroy(true, true);
        }

        // Get slider options from data attribute with mobile optimizations
        let options = {};
        try {
            options = JSON.parse(sliderEl.getAttribute('data-options')) || {};

            // Apply accessibility preferences
            options = AccessibilityUtils.handleReducedMotionPreference(options);

            // Apply browser compatibility fixes
            options = BrowserCompatibility.applyBrowserFixes(sliderEl, options);

            // Mobile performance adjustments
            if (Config.isMobile || Config.isLowEndDevice) {
                options.speed = Math.max(options.speed || 500, 300); // Faster transitions
                options.enableGsapAnimations = false; // Disable GSAP on mobile
                options.effect = 'slide'; // Force slide effect (more performant)
            }
        } catch (e) {
            // Error parsing slider options
        }

        // Add mobile optimization class
        if (Config.isMobile) {
            sliderEl.classList.add('mobile-optimized');
        }

        // Get transition speed
        const transitionSpeed = options.speed || 500;

        // Set transition speed as CSS variable for reliable synchronization
        sliderEl.style.setProperty('--swiper-transition-duration', transitionSpeed + 'ms');

        // Get slide count for proper initialization
        const slideCount = sliderEl.querySelectorAll('.swiper .swiper-slide').length;
        const useLoop = slideCount > 1 && (options.infinite !== undefined ? options.infinite : true);

        // Add transitioning class to handle content visibility during transitions
        sliderEl.classList.add('initializing');

        // Configure Swiper options
        const swiperOptions = {
            slidesPerView: 1,
            spaceBetween: 0,
            // Force fade effect for Unified Slider to ensure content "replaces" in place
            // instead of swiping away, which resolves the user's synchronization/visual preference
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            speed: 600, // Slightly slower for smoother fade replacement
            loop: useLoop,
            loopedSlides: useLoop ? slideCount : null,
            autoHeight: false,
            watchSlidesProgress: !Config.isMobile,
            grabCursor: true,
            observer: !Config.isMobile,
            observeParents: !Config.isMobile,
            observeSlideChildren: !Config.isMobile,
            simulateTouch: true,
            preventInteractionOnTransition: true,
            preventClicksPropagation: false,
            slideToClickedSlide: false,

            // Mobile-specific optimizations
            touchRatio: Config.isMobile ? 1.2 : 1,
            touchAngle: Config.isMobile ? 35 : 45,
            longSwipesRatio: Config.isMobile ? 0.3 : 0.5,
            threshold: Config.isMobile ? 5 : 0,

            // Navigation
            navigation: {
                nextEl: sliderEl.querySelector('.swiper-button-next'),
                prevEl: sliderEl.querySelector('.swiper-button-prev'),
            },

            // Pagination
            pagination: {
                el: sliderEl.querySelector('.swiper-pagination'),
                clickable: true,
                type: options.paginationType || 'bullets'
            },

            // Events - simplified for unified slider architecture
            on: {
                init: function () {
                    // Remove initializing class after short delay
                    setTimeout(() => {
                        sliderEl.classList.remove('initializing');
                    }, 50);
                },
                transitionStart: function () {
                    sliderEl.classList.add('transitioning');
                },
                transitionEnd: function () {
                    setTimeout(() => {
                        sliderEl.classList.remove('transitioning');
                    }, 50);
                }
            }
        };

        // Add autoplay if enabled
        if (options.autoplay) {
            swiperOptions.autoplay = {
                delay: options.autoplaySpeed || 5000,
                disableOnInteraction: options.pauseOnHover ? true : false
            };
        }

        // Make sure there are slides before initializing
        if (sliderEl.querySelectorAll('.swiper .swiper-slide').length === 0) {
            return;
        }

        try {
            // Initialize unified Swiper (image + content in each slide)
            const swiper = new Swiper(sliderEl.querySelector('.swiper'), swiperOptions);

            // Store instance for performance monitoring
            const sliderId = sliderEl.id || 'slider-' + Date.now();
            sliderEl.id = sliderId;
            window.imageTextSliderInstances.set(sliderId, {
                swiper: swiper,
                element: sliderEl,
                options: options,
                isMobile: Config.isMobile,
                isLowEnd: Config.isLowEndDevice
            });

            // Store swiper instance in the element
            sliderEl.swiper = swiper;

            // Update spacer after initialization
            let spacer = sliderEl.querySelector('.slider-bottom-spacer');
            if (spacer && window.updateSpacerPosition) {
                setTimeout(() => window.updateSpacerPosition(sliderEl, spacer), 300);
            }

            // Update spacer on slide change if needed
            swiper.on('slideChange', function () {
                spacer = sliderEl.querySelector('.slider-bottom-spacer');
                if (spacer && window.updateSpacerPosition) {
                    setTimeout(() => window.updateSpacerPosition(sliderEl, spacer), 300);
                }
            });

            // Initialize accessibility features
            if (AccessibilityUtils && typeof AccessibilityUtils.initSliderAccessibility === 'function') {
                AccessibilityUtils.initSliderAccessibility(sliderEl, swiper, options);
            }

            // Remove initializing class after everything is set up
            setTimeout(() => {
                sliderEl.classList.remove('initializing');
            }, 300);

        } catch (error) {
            console.error('Slider Init Error:', error);
            sliderEl.classList.remove('initializing');
            sliderEl.classList.remove('transitioning');
        }
    }

    // Expose initialization function for external use
    window.initImageTextSliders = initImageTextSliders;
    window.initImageTextSlider = initImageTextSlider;

})(window, jQuery);
