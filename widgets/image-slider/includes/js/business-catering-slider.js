/**
 * Business Catering Slider Initialization
 * 
 * This script initializes Swiper sliders for the Business Catering widget
 * when more than 3 images are added.
 */

(function($) {
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
        var speed = parseInt(sliderElement.dataset.speed || 500);
        var centeredSlides = sliderElement.dataset.centeredSlides === 'true';

        // Prepare slider options
        var swiperOptions = {
            slidesPerView: slidesPerView,
            spaceBetween: spaceBetween,
            loop: loop,
            centeredSlides: centeredSlides,
            effect: effect,
            speed: speed,
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
                init: function() {
                    // Trigger a custom event when the slider is initialized
                    $(sliderElement).trigger('swiperInitialized');
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

        // Add special effect options
        if (effect === 'fade') {
            swiperOptions.fadeEffect = {
                crossFade: true
            };
        } else if (effect === 'coverflow') {
            swiperOptions.coverflowEffect = {
                rotate: 30,
                slideShadows: false,
                depth: 100,
                stretch: 0
            };
        } else if (effect === 'cube') {
            swiperOptions.cubeEffect = {
                slideShadows: false,
                shadow: false
            };
        } else if (effect === 'flip') {
            swiperOptions.flipEffect = {
                slideShadows: false
            };
        }

        // Initialize Swiper
        try {
            var swiper = new Swiper('#' + sliderId, swiperOptions);
            initializedSliders[sliderId] = swiper;

            // Add resize handler to update slider on window resize
            $(window).on('resize', function() {
                if (swiper) {
                    swiper.update();
                }
            });

            // Pause autoplay when slider is not in viewport to improve performance
            if (autoplay) {
                $(window).on('scroll', function() {
                    if (isElementInViewport(sliderElement)) {
                        if (swiper.autoplay && swiper.autoplay.paused) {
                            swiper.autoplay.start();
                        }
                    } else {
                        if (swiper.autoplay && !swiper.autoplay.paused) {
                            swiper.autoplay.pause();
                        }
                    }
                });
            }

            return swiper;
        } catch (error) {
            return null;
        }
    }

    // Initialize all sliders on page load
    $(document).ready(function() {
        $('.promen-catering-slider').each(function() {
            initializeSlider(this);
        });
    });

    // Initialize sliders when they are created by Elementor frontend
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_business_catering.default', function($scope) {
                var slider = $scope.find('.promen-catering-slider');
                if (slider.length) {
                    initializeSlider(slider[0]);
                }
            });
        }
    });

})(jQuery);