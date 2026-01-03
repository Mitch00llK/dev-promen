// Define initCarousel as a global function immediately
window.initCarousel = function(carouselId) {
    try {
        var $carousel = jQuery('#' + carouselId);

        // If carousel element doesn't exist, return
        if (!$carousel.length) {
            return;
        }

        // Check if Swiper is available
        if (typeof Swiper === 'undefined') {
            return;
        }

        // Get settings from data attributes
        var cardsDesktop = parseInt($carousel.data('cards-desktop')) || 3;
        var cardsTablet = parseInt($carousel.data('cards-tablet')) || 2;
        var cardsMobile = parseInt($carousel.data('cards-mobile')) || 1;
        var centerMode = $carousel.data('center-mode') === true || $carousel.data('center-mode') === 'true';
        var centerPadding = $carousel.data('center-padding') || '50px';
        var infinite = $carousel.data('infinite') === true || $carousel.data('infinite') === 'true';
        var autoplay = $carousel.data('autoplay') === true || $carousel.data('autoplay') === 'true';
        var autoplaySpeed = parseInt($carousel.data('autoplay-speed')) || 3000;
        var speed = parseInt($carousel.data('speed')) || 500;
        var centerModeTablet = $carousel.data('center-mode-tablet') === true || $carousel.data('center-mode-tablet') === 'true';
        var centerPaddingTablet = $carousel.data('center-padding-tablet') || '30px';
        var centerModeMobile = $carousel.data('center-mode-mobile') === true || $carousel.data('center-mode-mobile') === 'true';
        var centerPaddingMobile = $carousel.data('center-padding-mobile') || '20px';

        // Destroy existing Swiper instance if it exists
        if ($carousel.data('swiper')) {
            $carousel.data('swiper').destroy(true, true);
            $carousel.data('swiper', null);
        }

        // Prepare the carousel structure for Swiper if needed
        if (!$carousel.find('.swiper-wrapper').length) {
            $carousel.children().wrapAll('<div class="swiper-wrapper"></div>');
            $carousel.find('> .swiper-wrapper > *').addClass('swiper-slide');
        }

        // Calculate center offset for center mode
        var calculateCenterOffset = function(padding) {
            if (typeof padding === 'string' && padding.endsWith('px')) {
                return parseInt(padding.replace('px', ''));
            }
            return 0;
        };

        // Initialize Swiper
        var swiperOptions = {
            slidesPerView: cardsDesktop,
            spaceBetween: 20,
            loop: infinite,
            speed: speed,
            autoplay: autoplay ? {
                delay: autoplaySpeed,
                disableOnInteraction: false
            } : false,
            centeredSlides: centerMode,
            watchOverflow: true,
            observer: true,
            observeParents: true,
            breakpoints: {
                // Mobile
                320: {
                    slidesPerView: cardsMobile,
                    spaceBetween: 15,
                    centeredSlides: centerModeMobile
                },
                // Tablet
                768: {
                    slidesPerView: cardsTablet,
                    spaceBetween: 20,
                    centeredSlides: centerModeTablet
                },
                // Desktop
                1024: {
                    slidesPerView: cardsDesktop,
                    spaceBetween: 16,
                    centeredSlides: centerMode
                }
            }
        };

        // Add center padding if center mode is enabled
        if (centerMode) {
            var centerOffset = calculateCenterOffset(centerPadding);
            if (centerOffset > 0) {
                swiperOptions.slidesOffsetBefore = centerOffset;
                swiperOptions.slidesOffsetAfter = centerOffset;
            }
        }

        // Create Swiper instance
        var swiper = new Swiper($carousel[0], swiperOptions);

        // Store swiper instance in data attribute
        $carousel.data('swiper', swiper);

        // Set up arrow navigation
        var $prevArrow = jQuery('.carousel-arrow-prev[data-carousel="' + carouselId + '"]');
        var $nextArrow = jQuery('.carousel-arrow-next[data-carousel="' + carouselId + '"]');

        $prevArrow.off('click').on('click', function() {
            if (swiper) {
                swiper.slidePrev();
            }
        });

        $nextArrow.off('click').on('click', function() {
            if (swiper) {
                swiper.slideNext();
            }
        });

        // Update arrow states
        swiper.on('slideChange', function() {
            if (!infinite) {
                if (swiper.isBeginning) {
                    $prevArrow.addClass('swiper-button-disabled');
                } else {
                    $prevArrow.removeClass('swiper-button-disabled');
                }

                if (swiper.isEnd) {
                    $nextArrow.addClass('swiper-button-disabled');
                } else {
                    $nextArrow.removeClass('swiper-button-disabled');
                }
            }
        });

        // Initialize GSAP animations if enabled
        initGsapAnimations($carousel);

    } catch (error) {}
};

// Function to initialize GSAP animations
function initGsapAnimations($carousel) {
    try {
        // Check if GSAP is available
        if (typeof gsap === 'undefined') {
            return;
        }

        // Get the container element (parent of the carousel)
        var $container = $carousel.closest('.promen-services-carousel-container');

        // Check if GSAP animations are enabled
        var gsapEnabled = $container.data('gsap-enabled') === true || $container.data('gsap-enabled') === 'true';

        if (!gsapEnabled) {
            return;
        }

        // Get animation settings from data attributes
        var staggerDuration = parseFloat($container.data('stagger-duration')) || 0.8;
        var staggerDelay = parseFloat($container.data('stagger-delay')) || 0.15;
        var animationEasing = $container.data('animation-easing') || 'power2.out';
        var startOpacity = parseFloat($container.data('start-opacity'));
        var yDistance = parseFloat($container.data('y-distance')) || 30;

        // Set initial state for all slides
        var $slides = $carousel.find('.swiper-slide');

        gsap.set($slides, {
            opacity: startOpacity,
            y: yDistance,
            force3D: true
        });

        // Create timeline for the animation
        var timeline = gsap.timeline({
            defaults: {
                ease: animationEasing
            }
        });

        // Add staggered animation for visible slides
        timeline.to($slides, {
            opacity: 1,
            y: 0,
            duration: staggerDuration,
            stagger: staggerDelay,
            force3D: true,
            onComplete: function() {
                // Reset any slides that might have been missed
                gsap.set($slides, {
                    clearProps: "opacity,y"
                });
            }
        });

        // Handle slide change events
        var swiper = $carousel.data('swiper');
        if (swiper) {
            swiper.on('slideChangeTransitionStart', function() {
                var activeSlides = $carousel.find('.swiper-slide-active, .swiper-slide-visible');
                var inactiveSlides = $carousel.find('.swiper-slide:not(.swiper-slide-active):not(.swiper-slide-visible)');

                // Set initial state for newly visible slides
                gsap.set(inactiveSlides, {
                    opacity: startOpacity,
                    y: yDistance,
                    force3D: true
                });

                // Animate the newly visible slides
                gsap.to(activeSlides, {
                    opacity: 1,
                    y: 0,
                    duration: staggerDuration * 0.6, // Slightly faster on slide change
                    stagger: staggerDelay * 0.5, // Slightly faster stagger on slide change
                    ease: animationEasing,
                    force3D: true
                });
            });
        }
    } catch (error) {}
}

// The rest of the code wrapped in jQuery
(function($) {
    'use strict';

    // Initialize carousel based on context (front-end or editor)
    var initializeCarousel = function(scope) {
        var $carousel = scope.find('.promen-services-carousel');
        if ($carousel.length) {
            var carouselId = $carousel.attr('id');
            if (carouselId) {
                if (typeof Swiper === 'undefined') {
                    // If Swiper is not loaded yet, wait for it
                    var checkInterval = setInterval(function() {
                        if (typeof Swiper !== 'undefined') {
                            clearInterval(checkInterval);
                            window.initCarousel(carouselId);
                        }
                    }, 100);

                    // Set a timeout to stop checking after 5 seconds
                    setTimeout(function() {
                        clearInterval(checkInterval);
                    }, 5000);
                } else {
                    window.initCarousel(carouselId);
                }
            }
        }
    };

    // Initialize on Elementor frontend init
    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_services_carousel.default', initializeCarousel);
    });

    // Initialize on document ready for non-Elementor contexts
    $(document).ready(function() {
        $('.promen-services-carousel').each(function() {
            var carouselId = $(this).attr('id');
            if (carouselId) {
                window.initCarousel(carouselId);
            }
        });
    });

})(jQuery);