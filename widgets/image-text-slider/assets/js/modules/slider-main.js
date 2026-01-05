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
            effect: options.effect || 'fade',
            speed: transitionSpeed,
            loop: useLoop,
            // Explicitly set loopedSlides to the number of slides if loop is enabled
            loopedSlides: useLoop ? slideCount : null,
            autoHeight: false,
            watchSlidesProgress: !Config.isMobile, // Disable on mobile for performance
            grabCursor: true,
            observer: !Config.isMobile, // Disable heavy observers on mobile
            observeParents: !Config.isMobile,
            observeSlideChildren: !Config.isMobile, // Disable on mobile for performance
            simulateTouch: true,
            preventInteractionOnTransition: true, // Prevent interaction during transition to avoid glitches
            preventClicksPropagation: false,
            // Ensure slides maintain proper order
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

            // Events for managing visibility and transitions
            on: {
                init: function () {
                    // Add a short delay before showing content for initial load
                    setTimeout(() => {
                        sliderEl.classList.remove('initializing');
                    }, 50);
                },
                beforeTransitionStart: function () {
                    // Controller handles sync, just add class
                    sliderEl.classList.add('transitioning');
                },
                slideChange: function () {
                    // Controller handles sync, but we add explicit sync as a safeguard
                    const currentIndex = this.realIndex;

                    // Use sliderEl.contentSwiper to reference the stored instance
                    if (sliderEl.contentSwiper && sliderEl.contentSwiper.realIndex !== currentIndex) {
                        sliderEl.contentSwiper.slideTo(currentIndex, 0, false);
                    }
                },
                transitionStart: function () {
                    // No special logic needed here anymore without GSAP
                },
                transitionEnd: function () {
                    // Remove transitioning class when finished
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
            // Initialize Main Image Swiper
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

            // Initialize content slider with matching settings to ensure perfect synchronization
            const contentSwiperOptions = {
                slidesPerView: 1,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 0, // Set to 0 for instant transitions - critical fix
                allowTouchMove: true, // Enable touch interaction
                grabCursor: true,     // Show grab cursor
                observer: true,
                observeParents: true,
                observeSlideChildren: true,
                loop: useLoop, // Match loop setting of main slider
                loopedSlides: useLoop ? slideCount : null, // match main slider loopedSlides perfectly
                preventInteractionOnTransition: true,
                on: {
                    init: function () {
                        // Controller handles initial sync mostly, but we set it just in case
                        // this.slideTo(swiper.realIndex, 0, false);
                    },
                    slideChange: function () {
                        // Ensure main swiper is synchronized when content swiper changes
                        const currentIndex = this.realIndex;

                        // Use sliderEl.swiper to reference the stored instance
                        if (sliderEl.swiper && sliderEl.swiper.realIndex !== currentIndex) {
                            sliderEl.swiper.slideTo(currentIndex, 0, false);
                        }
                    }
                }
            };

            const contentSwiper = new Swiper(sliderEl.querySelector('.swiper-content-slider'), contentSwiperOptions);

            // Store swiper instances in the element
            sliderEl.swiper = swiper;
            sliderEl.contentSwiper = contentSwiper;

            // Update instance tracking with content swiper
            const instance = window.imageTextSliderInstances.get(sliderId);
            if (instance) {
                instance.contentSwiper = contentSwiper;
            }

            // SETUP CONTROLLER SYNC
            swiper.controller.control = contentSwiper;
            contentSwiper.controller.control = swiper;

            // Add event listener for navigation clicks to ensure sync - using querySelectorAll fix naturally
            sliderEl.querySelectorAll('.swiper-button-next, .swiper-button-prev').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();

                    const isNext = btn.classList.contains('swiper-button-next');

                    // Add transitioning class
                    sliderEl.classList.add('transitioning');

                    if (isNext) {
                        swiper.slideNext();
                    } else {
                        swiper.slidePrev();
                    }
                });
            });

            // Listen for autoplay
            if (options.autoplay) {
                swiper.on('autoplay', function () {
                    sliderEl.classList.add('transitioning');
                    // Controller handles sync
                });
            }

            // Add CSS helper to handle transitions better
            if (!document.getElementById('image-text-slider-transition-styles')) {
                const styleEl = document.createElement('style');
                styleEl.id = 'image-text-slider-transition-styles';
                styleEl.innerHTML = `
                    .image-text-slider-container.transitioning .swiper-content-slider .swiper-slide:not(.swiper-slide-active),
                    .image-text-slider-container.initializing .swiper-content-slider .swiper-slide:not(.swiper-slide-active) {
                        opacity: 0 !important;
                        visibility: hidden !important;
                        transition: none !important;
                    }
                `;
                document.head.appendChild(styleEl);
            }

            // Update spacer after initialization
            let spacer = sliderEl.querySelector('.slider-bottom-spacer');
            if (spacer && window.updateSpacerPosition) {
                setTimeout(() => window.updateSpacerPosition(sliderEl, spacer), 300);
            }

            // Add event listener to handle slide changes and update spacer if needed
            swiper.on('slideChange', function () {
                spacer = sliderEl.querySelector('.slider-bottom-spacer');
                if (spacer && window.updateSpacerPosition) {
                    setTimeout(() => window.updateSpacerPosition(sliderEl, spacer), 300);
                }
            });

            // Content visibility is now handled by Swiper's fade effect with crossFade: true
            // No manual visibility management needed - this was causing the content to disappear

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
            // Clean up in case of error
            sliderEl.classList.remove('initializing');
            sliderEl.classList.remove('transitioning');
        }
    }

    // Expose initialization function for external use
    window.initImageTextSliders = initImageTextSliders;
    window.initImageTextSlider = initImageTextSlider;

})(window, jQuery);
