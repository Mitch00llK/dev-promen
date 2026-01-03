/**
 * Team Members Carousel Widget JavaScript
 * 
 * Handles the initialization and functionality of the team members carousel.
 * Uses SwiperJS with proper initialization according to Swiper documentation.
 */

(function($) {
    'use strict';

    /**
     * Initialize Team Members Carousel
     */
    var TeamMembersCarousel = {
        /**
         * Initialize the carousel
         */
        init: function() {
            if (typeof window.Swiper === 'undefined') {
                return;
            }

            $('.team-members-carousel').each(function() {
                var $carousel = $(this);
                TeamMembersCarousel.initSwiper($carousel);
            });
        },

        /**
         * Initialize Swiper carousel
         * 
         * @param {jQuery} $carousel - The carousel element
         */
        initSwiper: function($carousel) {
            // Prevent multiple initializations
            if ($carousel.data('swiper-initialized')) {
                return;
            }

            // Get carousel settings directly from the carousel element
            var cardsDesktop = parseInt($carousel.data('cards-desktop')) || 4;
            var cardsTablet = parseInt($carousel.data('cards-tablet')) || 2;
            var cardsMobile = parseInt($carousel.data('cards-mobile')) || 1;
            var isInfinite = $carousel.data('infinite') === 'true';
            var isAutoplay = $carousel.data('autoplay') === 'true';
            var autoplaySpeed = parseInt($carousel.data('autoplay-speed')) || 3000;
            var speed = parseInt($carousel.data('speed')) || 500;
            var isCentered = $carousel.data('centered') === 'true';
            var slideToClicked = $carousel.data('slide-to-clicked') === 'true';

            // Count actual slides
            var totalSlides = $carousel.find('.swiper-slide').length;

            // Improved loop logic - be more conservative about enabling loops
            // Only enable loop when we have significantly more slides than needed
            var maxSlidesPerView = Math.max(cardsDesktop, cardsTablet, cardsMobile);
            var shouldEnableLoop = isInfinite && (totalSlides > maxSlidesPerView + 2);

            // For cases where we have exactly the right number of slides or fewer,
            // we need to ensure proper navigation without loops
            var needsSpecialHandling = totalSlides <= maxSlidesPerView;

            // Log debug information

            // Get navigation elements
            var carouselId = $carousel.attr('id');
            var $prevButton = $('.carousel-arrow-prev[data-carousel="' + carouselId + '"]');
            var $nextButton = $('.carousel-arrow-next[data-carousel="' + carouselId + '"]');

            // Get pagination element if it exists
            var $pagination = $carousel.find('.swiper-pagination');

            try {
                // Calculate appropriate slides per view to ensure all slides are accessible
                var calculateSlidesPerView = function(requestedSlides, totalSlides, centered) {
                    if (centered) return 'auto';
                    if (totalSlides <= 1) return 1;

                    // For non-loop mode, ensure we can reach all slides
                    if (!shouldEnableLoop) {
                        // Calculate the maximum slides per view that still allows navigation to all slides
                        var maxAllowedSlides = Math.max(1, totalSlides - 1);
                        return Math.min(requestedSlides, maxAllowedSlides);
                    }

                    return Math.min(requestedSlides, totalSlides);
                };

                // Calculate responsive slides per view
                var finalCardsDesktop = calculateSlidesPerView(cardsDesktop, totalSlides, isCentered);
                var finalCardsTablet = calculateSlidesPerView(cardsTablet, totalSlides, isCentered);
                var finalCardsMobile = calculateSlidesPerView(cardsMobile, totalSlides, isCentered);

                // Swiper configuration
                var swiperOptions = {
                    // Core parameters
                    slidesPerView: finalCardsDesktop,
                    centeredSlides: isCentered,
                    spaceBetween: 30,
                    loop: shouldEnableLoop,
                    speed: speed,
                    grabCursor: true,
                    slideToClickedSlide: slideToClicked,
                    watchOverflow: true,
                    observer: true,
                    observeParents: true,
                    freeMode: false,
                    resistance: true,
                    resistanceRatio: 0.85,
                    threshold: 5, // Minimum threshold to start slide change

                    // Ensure smooth transitions
                    touchRatio: 1,
                    touchAngle: 45,
                    grabCursor: true,
                    preventInteractionOnTransition: false,

                    // Navigation arrows
                    navigation: {
                        nextEl: $nextButton.length ? $nextButton[0] : null,
                        prevEl: $prevButton.length ? $prevButton[0] : null,
                    },

                    // Pagination
                    pagination: $pagination.length ? {
                        el: $pagination[0],
                        clickable: true,
                    } : false,

                    // Autoplay - only enable if we have multiple slides
                    autoplay: (isAutoplay && totalSlides > 1) ? {
                        delay: autoplaySpeed,
                        disableOnInteraction: false,
                        pauseOnMouseEnter: true
                    } : false,

                    // Responsive breakpoints
                    breakpoints: {
                        320: {
                            slidesPerView: finalCardsMobile,
                            spaceBetween: 15
                        },
                        768: {
                            slidesPerView: finalCardsTablet,
                            spaceBetween: 20
                        },
                        1024: {
                            slidesPerView: finalCardsDesktop,
                            spaceBetween: 30
                        }
                    }
                };

                // Special handling for edge cases
                if (needsSpecialHandling && !shouldEnableLoop) {
                    // Force allowTouchMove to ensure navigation works
                    swiperOptions.allowTouchMove = true;
                    swiperOptions.simulateTouch = true;

                    // Ensure we can navigate to all slides
                    if (totalSlides > 1) {
                        swiperOptions.slidesPerView = Math.min(finalCardsDesktop, totalSlides - 1);
                        swiperOptions.breakpoints[1024].slidesPerView = Math.min(finalCardsDesktop, totalSlides - 1);
                        swiperOptions.breakpoints[768].slidesPerView = Math.min(finalCardsTablet, totalSlides - 1);
                        swiperOptions.breakpoints[320].slidesPerView = Math.min(finalCardsMobile, totalSlides - 1);
                    }
                }

                // Initialize Swiper
                var swiper = new Swiper($carousel.find('.swiper')[0], swiperOptions);

                // Mark as initialized
                $carousel.data('swiper-initialized', true);
                $carousel.data('swiper-instance', swiper);

                // Add initialized class
                $carousel.addClass('swiper-initialized');

                // Handle special styling for centered mode
                if (isCentered) {
                    $carousel.find('.swiper-slide').css('width', 'auto');

                    // Set initial opacity state for centered mode
                    $carousel.find('.swiper-slide').css('opacity', '0.6');
                    $carousel.find('.swiper-slide-active').css('opacity', '1');
                }

                // Add event listeners for centered mode
                if (isCentered) {
                    swiper.on('slideChange', function() {
                        // Reset all slides to inactive opacity
                        $carousel.find('.swiper-slide').css('opacity', '0.6');

                        // Set active slide to full opacity
                        setTimeout(function() {
                            $carousel.find('.swiper-slide-active').css('opacity', '1');
                        }, 10);
                    });
                }

                // Handle click events when slideToClickedSlide is enabled
                if (slideToClicked && isCentered) {
                    swiper.on('click', function() {
                        setTimeout(function() {
                            $carousel.find('.swiper-slide').css('opacity', '0.6');
                            $carousel.find('.swiper-slide-active').css('opacity', '1');
                        }, 50);
                    });
                }

                // Handle navigation button states when loop is disabled
                if (!shouldEnableLoop && totalSlides > 1) {
                    var updateNavigationStates = function() {
                        setTimeout(function() {
                            if (swiper.isBeginning) {
                                $prevButton.addClass('swiper-button-disabled');
                            } else {
                                $prevButton.removeClass('swiper-button-disabled');
                            }

                            if (swiper.isEnd) {
                                $nextButton.addClass('swiper-button-disabled');
                            } else {
                                $nextButton.removeClass('swiper-button-disabled');
                            }
                        }, 50);
                    };

                    swiper.on('slideChange', updateNavigationStates);
                    swiper.on('resize', updateNavigationStates);
                    swiper.on('update', updateNavigationStates);

                    // Set initial states
                    setTimeout(updateNavigationStates, 200);
                }

                // Force update for edge cases
                if (needsSpecialHandling) {
                    setTimeout(function() {
                        swiper.update();
                        swiper.updateSlides();
                        swiper.updateProgress();
                        swiper.updateSlidesClasses();

                        // Ensure navigation works properly
                        if (!shouldEnableLoop && totalSlides > 1) {
                            // Force recalculation of slide positions
                            swiper.setTranslate(swiper.getTranslate());
                        }
                    }, 300);
                }

                // Add a custom method to ensure we can navigate to the last slide
                if (!shouldEnableLoop && totalSlides > 1) {
                    var originalSlideTo = swiper.slideTo;
                    swiper.slideTo = function(index, speed, runCallbacks) {
                        // Ensure we can navigate to any slide, including the last one
                        var maxIndex = totalSlides - 1;
                        var targetIndex = Math.min(index, maxIndex);
                        return originalSlideTo.call(this, targetIndex, speed, runCallbacks);
                    };
                }

                // Log success

            } catch (error) {}
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        TeamMembersCarousel.init();
    });

    // Re-initialize on Elementor frontend init (for editor preview)
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_team_members_carousel.default', function() {
                TeamMembersCarousel.init();
            });
        }
    });

})(jQuery);