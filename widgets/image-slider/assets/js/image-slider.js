/**
 * Image Slider Initialization
 * 
 * This script initializes Swiper sliders for the Image Slider widget
 * when more than 3 images are added.
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
        var speed = parseInt(sliderElement.dataset.speed || 500);
        var centeredSlides = sliderElement.dataset.centeredSlides === 'true';
        var hasSpringEffect = sliderElement.dataset.springEffect === 'true';

        // Get responsive settings
        var slidesPerViewMobile = sliderElement.dataset.slidesPerViewMobile || 1;
        var spaceBetweenMobile = parseInt(sliderElement.dataset.spaceBetweenMobile || 20);
        var slidesPerViewTablet = sliderElement.dataset.slidesPerViewTablet || 2;
        var spaceBetweenTablet = parseInt(sliderElement.dataset.spaceBetweenTablet || 30);

        // Slider configuration
        var config = {
            slidesPerView: slidesPerView,
            spaceBetween: spaceBetween,
            centeredSlides: centeredSlides,
            speed: speed,
            effect: effect,
            loop: loop,
            autoplay: autoplay ? {
                delay: autoplayDelay,
                disableOnInteraction: false
            } : false,
            navigation: hasNavigation ? {
                nextEl: sliderElement.querySelector('.swiper-button-next'),
                prevEl: sliderElement.querySelector('.swiper-button-prev'),
            } : false,
            pagination: hasPagination ? {
                el: sliderElement.querySelector('.swiper-pagination'),
                clickable: true,
            } : false,
            // Responsive breakpoints
            breakpoints: {
                // Mobile breakpoint (0px and up)
                0: {
                    slidesPerView: slidesPerViewMobile,
                    spaceBetween: spaceBetweenMobile
                },
                // Tablet breakpoint (768px and up)
                768: {
                    slidesPerView: slidesPerViewTablet,
                    spaceBetween: spaceBetweenTablet
                },
                // Desktop breakpoint (1025px and up)
                1025: {
                    slidesPerView: slidesPerView,
                    spaceBetween: spaceBetween
                }
            }
        };

        // Add spring effect configuration if enabled
        if (hasSpringEffect || effect === 'spring') {
            config.effect = 'creative';
            config.creativeEffect = {
                prev: {
                    translate: [0, 0, -400],
                    scale: 0.75,
                    rotate: [0, 0, -4],
                    opacity: 0.5,
                    origin: 'left center',
                },
                next: {
                    translate: [0, 0, -400],
                    scale: 0.75,
                    rotate: [0, 0, 4],
                    opacity: 0.5,
                    origin: 'right center',
                }
            };

            // Add custom spring transition
            config.speed = 800;
            config.touchRatio = 1.5;
            config.watchSlidesProgress = true;
            config.virtualTranslate = true;
            config.grabCursor = true;
            config.on = {
                setTransition: function (swiper, duration) {
                    for (let i = 0; i < swiper.slides.length; i++) {
                        swiper.slides[i].style.transition = duration + 'ms';
                        swiper.slides[i].querySelector('.promen-slider-image').style.transition = duration + 'ms';
                    }
                },
                setTranslate: function (swiper, translate) {
                    for (let i = 0; i < swiper.slides.length; i++) {
                        const slideProgress = swiper.slides[i].progress;
                        const springEffect = Math.min(Math.abs(slideProgress), 1);
                        const scale = 1 - (springEffect * 0.25);
                        const translateX = slideProgress * swiper.width * 0.8;
                        const rotateY = slideProgress * 25;
                        const translateZ = -Math.abs(slideProgress) * 200;

                        swiper.slides[i].style.transform =
                            `translateX(${translateX}px) translateZ(${translateZ}px) rotateY(${rotateY}deg)`;
                        swiper.slides[i].querySelector('.promen-slider-image').style.transform =
                            `scale(${scale})`;
                    }
                }
            };
        }

        // Initialize Swiper
        try {
            var swiper = new Swiper(sliderElement, config);
            initializedSliders[sliderId] = swiper;

            // Initialize accessibility features
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.setupSwiperAccessibility(swiper, sliderElement);

                // Add reduced motion support
                PromenAccessibility.setupReducedMotion(sliderElement, {
                    onMotionReduced: () => {
                        if (swiper && swiper.autoplay && swiper.autoplay.running) {
                            swiper.autoplay.stop();
                        }
                    }
                });
            }

            // Add skip link
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.setupSkipLink(sliderElement, PromenAccessibility.getString('skipSlider'));
            }

            // Add resize handler to update slider on window resize
            $(window).on('resize', function () {
                if (swiper) {
                    swiper.update();
                }
            });

            // Pause autoplay when slider is not in viewport to improve performance
            if (autoplay) {
                $(window).on('scroll', function () {
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
            console.error('Image Slider Initialization Error:', error);
            return null;
        }
    }

    // Initialize all sliders on page load
    $(document).ready(function () {
        $('.promen-image-slider').each(function () {
            initializeSlider(this);
        });
    });

    // Initialize sliders when they are created by Elementor frontend
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_image_slider.default', function ($scope) {
                var slider = $scope.find('.promen-image-slider');
                if (slider.length) {
                    initializeSlider(slider[0]);
                }
            });
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

})(jQuery);