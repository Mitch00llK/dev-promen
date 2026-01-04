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

    // Dependencies
    const AccessibilityUtils = window.PromenAccessibilityUtils;
    const Utils = window.PromenSliderUtils;
    const { debounce, throttle } = Utils;
    const BrowserCompatibility = Utils.BrowserCompatibility;

    // Modules
    const ContentUtils = window.PromenSliderContent;
    const Config = window.PromenSliderConfig;

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
        if (!sliderEl || typeof Swiper === 'undefined') {
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

            // Navigation - FIX APPLIED: TARGET ALL MATCHING BUTTONS
            navigation: {
                nextEl: Array.from(sliderEl.querySelectorAll('.swiper-button-next')),
                prevEl: Array.from(sliderEl.querySelectorAll('.swiper-button-prev')),
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
                        ContentUtils.updateSlideVisibility(this);
                    }, 50);

                    // Store initial slide order for debugging
                    ContentUtils.logSlideOrder(this, 'Main Swiper Init');
                },
                beforeTransitionStart: function () {
                    // Add transitioning class to handle content visibility during transitions
                    sliderEl.classList.add('transitioning');

                    // Force hide all inactive slides
                    ContentUtils.forceHideInactiveContentSlides();

                    // Immediately hide content to prevent flashing
                    const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
                    contentSlides.forEach(slide => {
                        if (!slide.classList.contains('swiper-slide-active')) {
                            slide.style.opacity = "0";
                            slide.style.visibility = "hidden";
                        }
                    });
                },
                slideChange: function () {
                    ContentUtils.updateSlideVisibility(this);
                    ContentUtils.logSlideOrder(this, 'Main Swiper Change');

                    // Manually sync the content slider with the image slider
                    if (sliderEl.contentSwiper) {
                        // Get target slide before animation 
                        const targetIndex = useLoop ? this.realIndex : this.activeIndex;

                        // Reset all content slides immediately
                        if (options.enableGsapAnimations && window.gsap) {
                            const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
                            contentSlides.forEach(slide => ContentUtils.resetSlideContent(slide));
                        }

                        // Set exact same index to ensure synchronization with 0 speed
                        if (useLoop) {
                            // For loop mode, use realIndex
                            sliderEl.contentSwiper.slideToLoop(targetIndex, 0, false);
                        } else {
                            // For non-loop mode, use activeIndex
                            sliderEl.contentSwiper.slideTo(targetIndex, 0, false);
                        }
                    }
                },
                transitionStart: function () {
                    // If using GSAP, prepare content slides
                    if (options.enableGsapAnimations && window.gsap) {
                        const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide:not(.swiper-slide-active)');
                        contentSlides.forEach(slide => ContentUtils.resetSlideContent(slide));
                    }
                },
                transitionEnd: function () {
                    // Remove transitioning class when finished
                    setTimeout(() => {
                        sliderEl.classList.remove('transitioning');

                        // Force correct visibility again after transition
                        ContentUtils.forceHideInactiveContentSlides();
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
                allowTouchMove: false,
                observer: true,
                observeParents: true,
                observeSlideChildren: true,
                loop: useLoop,
                loopedSlides: useLoop ? slideCount : null, // Match loopedSlides with main swiper
                preventInteractionOnTransition: true,
                on: {
                    init: function () {
                        ContentUtils.updateContentSlideVisibility(this);

                        // Set initial slide based on main swiper
                        if (useLoop) {
                            this.slideToLoop(swiper.realIndex, 0, false);
                        } else {
                            this.slideTo(swiper.activeIndex, 0, false);
                        }

                        // Log for debugging
                        ContentUtils.logSlideOrder(this, 'Content Swiper Init');

                        // Initialize GSAP animations for first slide
                        if (options.enableGsapAnimations && window.gsap) {
                            const initialSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
                            if (initialSlide) {
                                // Show slide without animation first to prevent flashing
                                ContentUtils.showSlideContentWithoutAnimation(initialSlide);

                                // Then animate with a slight delay
                                setTimeout(() => {
                                    ContentUtils.resetSlideContent(initialSlide);
                                    ContentUtils.setupGsapAnimations(sliderEl, swiper, options);
                                    // Wait, setupGsapAnimations handles init logic too. 
                                    // But here we might just want to animate the specific slide as setupGsapAnimations adds listeners.
                                    // It seems setupGsapAnimations also handles the initial slide logic.
                                    // So calling setupGsapAnimations below is correct.
                                }, 50);
                            }
                        }

                        // Ensure visibility is set properly for all content slides
                        const slides = this.slides;
                        if (slides && slides.length > 0) {
                            slides.forEach((slide, index) => {
                                if (index === this.activeIndex) {
                                    slide.style.opacity = '1';
                                    slide.style.visibility = 'visible';
                                } else {
                                    slide.style.opacity = '0';
                                    slide.style.visibility = 'hidden';
                                }
                            });
                        }
                    },
                    slideChange: function () {
                        ContentUtils.updateContentSlideVisibility(this);
                        ContentUtils.logSlideOrder(this, 'Content Swiper Change');

                        // Explicitly set visibility based on active state
                        const slides = this.slides;
                        if (slides && slides.length > 0) {
                            slides.forEach((slide, index) => {
                                if (index === this.activeIndex) {
                                    slide.style.opacity = '1';
                                    slide.style.visibility = 'visible';
                                } else {
                                    slide.style.opacity = '0';
                                    slide.style.visibility = 'hidden';
                                }
                            });
                        }
                    },
                    transitionStart: function () {
                        // Hide all non-active slides immediately
                        const slides = this.slides;
                        if (slides && slides.length > 0) {
                            slides.forEach((slide, index) => {
                                if (index !== this.activeIndex) {
                                    slide.style.opacity = '0';
                                    slide.style.visibility = 'hidden';
                                }
                            });
                        }
                    },
                    transitionEnd: function () {
                        // Ensure only active slide is visible after transition
                        setTimeout(ContentUtils.ensureStaticContentAlignment, 50);
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

            // Set initial sync after initialization
            if (useLoop) {
                contentSwiper.slideToLoop(swiper.realIndex, 0, false);
            } else {
                contentSwiper.slideTo(swiper.activeIndex, 0, false);
            }

            // Add event listener for navigation clicks to ensure sync - using querySelectorAll fix naturally
            sliderEl.querySelectorAll('.swiper-button-next, .swiper-button-prev').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    // Swiper handles navigation now via options, but manual listening might still be needed 
                    // if swiper 'navigation' option with array of elements doesn't cover click events automatically?
                    // Swiper DOES handle click events for array elements passed to navigation config.
                    // BUT the original code also had this manual listener. 
                    // It seems to be mainly for adding 'transitioning' class immediately.

                    const isNext = btn.classList.contains('swiper-button-next');

                    // Add transitioning class
                    sliderEl.classList.add('transitioning');

                    // NOTE: Since we passed buttons to Swiper navigation, we don't strictly need to call slideNext/slidePrev here
                    // UNLESS swiper click handling is delayed or we want to force it.
                    // However, Swiper will attach its own listeners. Double listener might be fine or redundant.
                    // Let's keep the transitioning class part but avoid double navigation if possible.
                    // Actually, swiper might not double-trigger if the event is prevented?
                    // Let's call slideNext/Prev just to be safe as per original logic, 
                    // Swiper is robust enough to ignore if busy.

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
                    if (useLoop) {
                        contentSwiper.slideToLoop(swiper.realIndex, 0, false);
                    } else {
                        contentSwiper.slideTo(swiper.activeIndex, 0, false);
                    }
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

            // Add GSAP animation if enabled
            if (options.enableGsapAnimations && window.gsap) {
                ContentUtils.setupGsapAnimations(sliderEl, swiper, options);
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

            // After initialization, ensure static content alignment is preserved
            setTimeout(ContentUtils.ensureStaticContentAlignment, 500);

            // Add event listener to ensure alignment on slide changes
            swiper.on('slideChangeTransitionEnd', function () {
                setTimeout(ContentUtils.ensureStaticContentAlignment, 50);
            });

            // Initialize accessibility features
            if (AccessibilityUtils) {
                AccessibilityUtils.initSliderAccessibility(sliderEl, swiper, options);
            }

            // Remove initializing class after everything is set up
            setTimeout(() => {
                sliderEl.classList.remove('initializing');
                ContentUtils.ensureStaticContentAlignment();
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
