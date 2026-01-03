/**
 * Services Grid Slider Initialization
 * 
 * This script initializes Swiper sliders for the Services Grid widget
 * when the viewport is smaller than 992px.
 */

(function ($) {
    'use strict';

    // Store all initialized sliders
    var initializedSliders = {};

    // Function to check if element is in viewport
    function isElementInViewport(el) {
        if (!el) return false;
        var rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    // Function to initialize a slider
    function initializeSlider(sliderElement) {
        if (!sliderElement || initializedSliders[sliderElement.id]) return;

        var sliderId = sliderElement.id;
        var slidesPerView = sliderElement.dataset.slidesPerView || 1;
        var spaceBetween = parseInt(sliderElement.dataset.spaceBetween || 30);
        var hasNavigation = sliderElement.dataset.navigation === 'true';
        var hasPagination = sliderElement.dataset.pagination === 'true';
        var loop = sliderElement.dataset.loop === 'true';
        var autoplay = sliderElement.dataset.autoplay === 'true';
        var autoplayDelay = parseInt(sliderElement.dataset.autoplayDelay || 5000);
        var effect = sliderElement.dataset.effect || 'slide';
        var centeredSlides = sliderElement.dataset.centeredSlides === 'true';

        // Set all slides to 50% opacity initially
        $(sliderElement).find('.swiper-slide').css('opacity', '0.5');

        // Prepare slider options
        var swiperOptions = {
            slidesPerView: slidesPerView,
            spaceBetween: spaceBetween,
            loop: loop,
            centeredSlides: centeredSlides,
            effect: effect,
            watchOverflow: true,
            watchSlidesProgress: true, // Enable to track slide visibility
            a11y: {
                enabled: true,
                prevSlideMessage: 'Previous slide',
                nextSlideMessage: 'Next slide',
                firstSlideMessage: 'This is the first slide',
                lastSlideMessage: 'This is the last slide',
                paginationBulletMessage: 'Go to slide {{index}}'
            },
            on: {
                init: function (swiper) {
                    // Set active slide to 100% opacity after initialization
                    setTimeout(function () {
                        $(swiper.slides[swiper.activeIndex]).css('opacity', '1');
                    }, 50);
                },
                slideChange: function (swiper) {
                    // Reset all slides to 50% opacity
                    $(swiper.slides).css('opacity', '0.5');
                    // Set active slide to 100% opacity
                    $(swiper.slides[swiper.activeIndex]).css('opacity', '1');
                },
                slideChangeTransitionEnd: function (swiper) {
                    // Ensure active slide is 100% opacity after transition
                    $(swiper.slides).css('opacity', '0.5');
                    $(swiper.slides[swiper.activeIndex]).css('opacity', '1');
                }
            }
        };

        // Add navigation if enabled
        if (hasNavigation) {
            swiperOptions.navigation = {
                nextEl: '#' + sliderId + ' .swiper-button-next',
                prevEl: '#' + sliderId + ' .swiper-button-prev',
            };
        }

        // Add pagination if enabled
        if (hasPagination) {
            swiperOptions.pagination = {
                el: '#' + sliderId + ' .swiper-pagination',
                clickable: true
            };
        }

        // Add autoplay if enabled
        if (autoplay) {
            swiperOptions.autoplay = {
                delay: autoplayDelay,
                disableOnInteraction: false
            };
        }

        // Add fade effect options if using fade
        if (effect === 'fade') {
            try {
                var fadeEffectOptions = JSON.parse(sliderElement.dataset.fadeEffect || '{"crossFade":true}');
                swiperOptions.fadeEffect = fadeEffectOptions;
            } catch (e) {
                swiperOptions.fadeEffect = { crossFade: true };
            }
        }

        // Add breakpoints if available
        if (sliderElement.dataset.breakpoints) {
            try {
                var breakpointsData = JSON.parse(sliderElement.dataset.breakpoints);
                var breakpoints = {};

                // Convert string keys to numbers
                Object.keys(breakpointsData).forEach(function (key) {
                    breakpoints[parseInt(key)] = breakpointsData[key];
                });

                swiperOptions.breakpoints = breakpoints;
            } catch (e) { }
        }

        // Initialize Swiper
        initializedSliders[sliderId] = new Swiper('#' + sliderId, swiperOptions);

        // Double-check active slide opacity after a short delay
        setTimeout(function () {
            if (initializedSliders[sliderId]) {
                var activeIndex = initializedSliders[sliderId].activeIndex;
                $(initializedSliders[sliderId].slides).css('opacity', '0.5');
                $(initializedSliders[sliderId].slides[activeIndex]).css('opacity', '1');
            }
        }, 500);
    }

    // Function to destroy a slider
    function destroySlider(sliderId) {
        if (initializedSliders[sliderId]) {
            initializedSliders[sliderId].destroy(true, true);
            delete initializedSliders[sliderId];
        }
    }

    // Function to handle responsive behavior
    function handleResponsiveSliders() {
        var isMobile = window.innerWidth < 992;

        $('.services-grid-container').each(function () {
            var $container = $(this);
            var $grid = $container.find('.services-grid');
            var $sliderContainer = $container.find('.services-slider-container');

            if (isMobile) {
                // Mobile view - show slider if it exists
                if ($sliderContainer.length) {
                    $grid.hide();
                    $sliderContainer.show();

                    // Initialize slider if in viewport
                    var sliderElement = $sliderContainer.find('.swiper')[0];
                    if (sliderElement && isElementInViewport(sliderElement)) {
                        initializeSlider(sliderElement);
                    }
                }
            } else {
                // Desktop view - show grid
                $grid.show();
                if ($sliderContainer.length) {
                    $sliderContainer.hide();

                    // Destroy slider if it was initialized
                    var sliderId = $sliderContainer.find('.swiper').attr('id');
                    if (sliderId) {
                        destroySlider(sliderId);
                    }
                }
            }
        });
    }

    // Initialize on document ready
    $(document).ready(function () {
        handleResponsiveSliders();

        // Initialize sliders when they come into view
        $(window).on('scroll', function () {
            if (window.innerWidth < 992) {
                $('.swiper:not(.swiper-initialized)').each(function () {
                    if (isElementInViewport(this)) {
                        initializeSlider(this);
                    }
                });
            }
        });

        // Handle resize events
        var resizeTimer;
        $(window).on('resize', function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(handleResponsiveSliders, 250);
        });

        // Handle Elementor frontend init (for when widget is added or edited in Elementor)
        const initElementorHooks = () => {
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction('frontend/element_ready/promen_services_grid.default', function ($element) {
                    handleResponsiveSliders();
                });
            }
        };

        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            initElementorHooks();
        } else {
            window.addEventListener('elementor/frontend/init', initElementorHooks);
        }
    });

})(jQuery);