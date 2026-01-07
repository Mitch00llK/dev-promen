/**
 * News Posts Slider Initialization
 * 
 * This script initializes Swiper sliders for the News Posts widget
 * when the viewport is smaller than 992px.
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
        if (!sliderId) {
            // Ensure every slider has a usable ID for Swiper selectors
            sliderId = 'promen-news-slider-' + Math.random().toString(36).substr(2, 9);
            sliderElement.id = sliderId;
        }
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
            keyboard: {
                enabled: true,
                onlyInViewport: true,
            },
            a11y: {
                enabled: true,
                prevSlideMessage: 'Previous slide',
                nextSlideMessage: 'Next slide',
                firstSlideMessage: 'This is the first slide',
                lastSlideMessage: 'This is the last slide',
                paginationBulletMessage: 'Go to slide {{index}}',
                containerMessage: 'Content carousel',
                containerRoleDescriptionMessage: 'carousel',
                itemRoleDescriptionMessage: 'slide',
            },
            on: {
                init: function(swiper) {
                    // Set active slide to 100% opacity after initialization
                    setTimeout(function() {
                        $(swiper.slides[swiper.activeIndex]).css('opacity', '1');
                    }, 50);
                },
                slideChange: function(swiper) {
                    // Reset all slides to 50% opacity
                    $(swiper.slides).css('opacity', '0.5');
                    // Set active slide to 100% opacity
                    $(swiper.slides[swiper.activeIndex]).css('opacity', '1');
                },
                slideChangeTransitionEnd: function(swiper) {
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
                Object.keys(breakpointsData).forEach(function(key) {
                    breakpoints[parseInt(key)] = breakpointsData[key];
                });

                swiperOptions.breakpoints = breakpoints;
            } catch (e) {}
        }

        // Initialize Swiper
        initializedSliders[sliderId] = new Swiper('#' + sliderId, swiperOptions);

        // Double-check active slide opacity after a short delay
        setTimeout(function() {
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

        $('.promen-content-posts-widget').each(function() {
            var $widget = $(this);
            var $grid = $widget.find('.promen-content-grid');
            var $sliderContainer = $widget.find('.promen-news-slider-container');

            // Ensure widget is ready before manipulating visibility
            if (!$widget.length || ($grid.length === 0 && $sliderContainer.length === 0)) {
                return;
            }

            // Use requestAnimationFrame to ensure layout is calculated
            requestAnimationFrame(function() {
                if (isMobile) {
                    // Mobile view - show slider if it exists
                    if ($sliderContainer.length) {
                        $grid.css({ 'display': 'none', 'visibility': 'hidden' });
                        $sliderContainer.css({ 'display': '', 'visibility': 'visible' });

                        // Initialize slider if in viewport
                        var sliderElement = $sliderContainer.find('.swiper')[0];
                        if (sliderElement && isElementInViewport(sliderElement)) {
                            // Small delay to ensure container is visible before initializing
                            setTimeout(function() {
                                initializeSlider(sliderElement);
                            }, 50);
                        }
                    } else {
                        // No slider container, show grid
                        $grid.css({ 'display': '', 'visibility': 'visible' });
                    }
                } else {
                    // Desktop view - show grid
                    $grid.css({ 'display': '', 'visibility': 'visible' });
                    if ($sliderContainer.length) {
                        $sliderContainer.css({ 'display': 'none', 'visibility': 'hidden' });

                        // Destroy slider if it was initialized
                        var sliderId = $sliderContainer.find('.swiper').attr('id');
                        if (sliderId) {
                            destroySlider(sliderId);
                        }
                    }
                }

                // Remove loading class to show content
                $widget.removeClass('promen-widget-loading');
            });
        });
    }

    // Initialize on document ready
    $(document).ready(function() {
        // Mark widget as JS-enabled for CSS fallback
        $('.promen-content-posts-widget').addClass('js-enabled');
        
        // Fallback: Show widget after 2 seconds if initialization hasn't completed
        var fallbackTimer = setTimeout(function() {
            $('.promen-content-posts-widget.promen-widget-loading').each(function() {
                var $widget = $(this);
                var $grid = $widget.find('.promen-content-grid');
                var $sliderContainer = $widget.find('.promen-news-slider-container');
                
                // Show appropriate view based on viewport
                if (window.innerWidth < 992 && $sliderContainer.length) {
                    $grid.css({ 'display': 'none', 'visibility': 'hidden' });
                    $sliderContainer.css({ 'display': '', 'visibility': 'visible' });
                } else {
                    $grid.css({ 'display': '', 'visibility': 'visible' });
                    if ($sliderContainer.length) {
                        $sliderContainer.css({ 'display': 'none', 'visibility': 'hidden' });
                    }
                }
                
                $widget.removeClass('promen-widget-loading');
            });
        }, 2000);
        
        // Wait for layout to be calculated before initial manipulation
        // Use both requestAnimationFrame and a small delay to ensure CSS is applied
        requestAnimationFrame(function() {
            setTimeout(function() {
                handleResponsiveSliders();
                // Clear fallback timer since initialization completed
                clearTimeout(fallbackTimer);
            }, 100);
        });

        // Initialize sliders when they come into view
        $(window).on('scroll', function() {
            if (window.innerWidth < 992) {
                $('.swiper:not(.swiper-initialized)').each(function() {
                    if (isElementInViewport(this)) {
                        initializeSlider(this);
                    }
                });
            }
        });

        // Handle resize events
        var resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                requestAnimationFrame(handleResponsiveSliders);
            }, 250);
        });

        // Also handle window load to ensure images are loaded
        $(window).on('load', function() {
            requestAnimationFrame(function() {
                handleResponsiveSliders();
            });
        });

        // Handle Elementor frontend init (for when widget is added or edited in Elementor)
        $(document).on('elementor/frontend/init', function() {
            if (typeof elementorFrontend !== 'undefined') {
                elementorFrontend.hooks.addAction('frontend/element_ready/promen_content_posts_grid.default', function($element) {
                    requestAnimationFrame(function() {
                        setTimeout(function() {
                            handleResponsiveSliders();
                        }, 100);
                    });
                });
            }
        });
    });

})(jQuery);