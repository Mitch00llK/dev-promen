/**
 * Image Text Slider Main Logic
 * 
 * Handles the initialization and core functionality of the unified image-text slider.
 */
(function (window, $) {
    "use strict";

    // Dependencies
    const Config = window.PromenSliderConfig;
    const ContentUtils = window.PromenSliderContent;
    const AccessibilityUtils = window.PromenSliderAccessibility;

    /**
     * Initialize all sliders on the page
     */
    function initImageTextSliders() {
        const sliders = document.querySelectorAll('.image-text-slider-container:not(.initialized)');
        sliders.forEach(slider => {
            initImageTextSlider(slider);
            slider.classList.add('initialized');
        });
    }

    /**
     * Initialize a single slider instance
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function initImageTextSlider(sliderEl) {
        if (!sliderEl) return;

        // Add initializing class
        sliderEl.classList.add('initializing');

        // Parse configuration from data attributes
        const settings = sliderEl.dataset.settings ? JSON.parse(sliderEl.dataset.settings) : {};
        const slideCount = parseInt(sliderEl.dataset.slideCount || 0);

        // Configuration defaults
        const options = {
            autoplay: settings.autoplay === 'yes',
            autoplaySpeed: parseInt(settings.autoplay_speed || 5000),
            pauseOnHover: settings.pause_on_hover === 'yes',
            effect: settings.effect || 'fade', // Default to fade for unified slider
            paginationType: settings.pagination_type || 'bullets',
            speed: parseInt(settings.transition_speed || 600) // Increased for smoother fade
        };

        const useLoop = settings.loop === 'yes' && slideCount > 1;

        // Configure Swiper options
        const swiperOptions = {
            slidesPerView: 1,
            spaceBetween: 0,
            effect: options.effect || 'fade',
            fadeEffect: {
                crossFade: true // Smooth cross-fade to ensure replacement effect
            },
            speed: options.speed,
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

            // Events
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
                delay: options.autoplaySpeed,
                disableOnInteraction: options.pauseOnHover
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

            // Update spacer on slide change if needed (to handle varying content heights)
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
