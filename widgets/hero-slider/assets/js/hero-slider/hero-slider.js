/**
 * Hero Slider Widget JavaScript
 * 
 * Optimized version with improved performance and structure
 */

(function($) {
    'use strict';

    // Check if Swiper is available
    var isSwiperAvailable = typeof Swiper !== 'undefined';

    if (!isSwiperAvailable) {}

    /**
     * Initialize Hero Slider
     */
    function initHeroSlider() {
        $('.hero-slider-container').each(function() {
            try {
                const $container = $(this);
                const sliderId = $container.attr('id');
                const displayType = $container.data('display-type') || 'slider';

                if (!sliderId) {
                    const randomId = 'hero-slider-' + Math.floor(Math.random() * 10000);
                    $container.attr('id', randomId);
                }

                // If static mode, just ensure proper styling and exit
                if (displayType === 'static') {
                    $container.addClass('hero-static-mode');
                    $container.removeClass('hero-slider-mode');
                    return;
                }

                // Get the slider element
                const $slider = $container.find('.hero-slider');
                if (!$slider.length) {
                    return;
                }

                // Get options from data attributes
                let options = {};
                try {
                    options = $container.data('options') || {};
                } catch (dataError) {
                    options = {};
                }

                // Default options
                const defaults = {
                    autoplay: false,
                    autoplaySpeed: 5000,
                    pauseOnHover: true,
                    infinite: true,
                    speed: 500,
                    effect: 'fade',
                    heightMode: 'fixed'
                };

                // Merge options
                const settings = $.extend({}, defaults, options);

                // Check if Swiper is available
                if (!isSwiperAvailable) {
                    applyFallbackStyles($container, $slider);
                    return;
                }

                // Swiper configuration
                const swiperConfig = {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    effect: settings.effect,
                    speed: settings.speed,
                    loop: settings.infinite,
                    autoplay: settings.autoplay ? {
                        delay: settings.autoplaySpeed,
                        disableOnInteraction: !settings.pauseOnHover
                    } : false,
                    pagination: {
                        el: `#${sliderId} .swiper-pagination`,
                        clickable: true,
                        type: settings.paginationType || 'bullets'
                    },
                    navigation: {
                        nextEl: `#${sliderId} .swiper-button-next`,
                        prevEl: `#${sliderId} .swiper-button-prev`
                    },
                    on: {
                        init: function() {
                            // Handle overflow for Elementor
                            handleOverflow($container);

                            // Make sure navigation arrows are visible
                            ensureNavigationVisible($container);
                        },
                        slideChange: function() {
                            // Ensure navigation arrows remain visible during slide transitions
                            ensureNavigationVisible($container);
                        },
                        resize: function() {
                            // Handle overflow for Elementor on resize
                            handleOverflow($container);

                            // Ensure navigation arrows remain visible on resize
                            ensureNavigationVisible($container);
                        }
                    }
                };

                // Initialize Swiper
                try {
                    const swiper = new Swiper(`#${sliderId} .swiper`, swiperConfig);

                    // Store swiper instance in data attribute for future reference
                    $container.data('swiper', swiper);
                } catch (error) {
                    applyFallbackStyles($container, $slider);
                }
            } catch (mainError) {}
        });
    }

    /**
     * Ensure navigation arrows are always visible
     */
    function ensureNavigationVisible($container) {
        if (!$container || !$container.length) {
            return;
        }

        const $navigation = $container.find('.hero-slide-navigation');
        if ($navigation.length) {
            $navigation.css({
                'opacity': '1',
                'visibility': 'visible',
                'z-index': '10'
            });

            // Ensure arrows are clickable
            $navigation.find('.hero-slider-arrow').css({
                'pointer-events': 'auto'
            });
        }
    }

    /**
     * Apply fallback styles when Swiper fails to initialize
     */
    function applyFallbackStyles($container, $slider) {
        $container.addClass('hero-slider-fallback');
        $slider.find('.swiper-wrapper').css('display', 'block');
        $slider.find('.swiper-slide').css({
            'display': 'block',
            'width': '100%',
            'height': 'auto'
        });

        // Hide navigation elements
        $slider.find('.swiper-pagination, .swiper-button-prev, .swiper-button-next').hide();
    }

    /**
     * Handle overflow for Elementor
     */
    function handleOverflow($container) {
        try {
            if (!$container || !$container.length) {
                return;
            }

            // Check if container has overflow classes
            if ($container.hasClass('content-overflow-yes')) {
                // Add overflow visible to all parent elements up to 5 levels
                let parent = $container.parent();
                for (let i = 0; i < 5; i++) {
                    if (parent.length) {
                        parent.css({
                            'overflow': 'visible'
                        });
                        parent = parent.parent();
                    }
                }

                // Also add to the column, section, and container
                const $column = $container.closest('.elementor-column, .e-con');
                const $section = $container.closest('.elementor-section, .e-container');
                const $widgetContainer = $container.closest('.elementor-widget-container');

                if ($column.length) $column.css({
                    'overflow': 'visible'
                });
                if ($section.length) $section.css({
                    'overflow': 'visible'
                });
                if ($widgetContainer.length) $widgetContainer.css({
                    'overflow': 'visible'
                });

                // Add a class to the body for global CSS
                $('body').addClass('has-hero-slider-overflow');

                // Ensure the slide and content container have proper overflow
                $container.find('.hero-slide, .hero-slide-content-container').css({
                    'overflow': 'visible',
                    'margin-bottom': '0'
                });

                // Ensure Swiper elements have proper overflow
                $container.find('.swiper, .swiper-wrapper, .swiper-slide').css({
                    'overflow': 'visible'
                });

                // Ensure content wrapper has proper styling
                $container.find('.hero-slide-content-wrapper').css({
                    // 'position': 'relative',
                    'z-index': '10',
                    'margin-bottom': '0'
                });
            }
        } catch (error) {}
    }

    /**
     * Handle overflow specifically for Elementor editor
     */
    function handleEditorOverflow($container) {
        try {
            if (!$container || !$container.length) {
                return;
            }

            // Check if we're in the editor
            if (!window.elementor && !window.elementorFrontend) {
                return;
            }

            // Fix for vertical positioning in editor
            fixVerticalPositioningInEditor($container);

            // Check if container has overflow classes
            if ($container.hasClass('content-overflow-yes')) {
                // Force editor to respect overflow
                $('.elementor-editor-active .elementor-inner, .elementor-editor-active .elementor-widget-wrap').css({
                    'overflow': 'visible'
                });

                // Make sure the content wrapper has a high z-index
                $container.find('.hero-slide-content-wrapper').css({
                    // 'position': 'relative',
                    'z-index': '999'
                });

                // Apply to all parent elements in the editor
                $container.parents().css({
                    'overflow': 'visible'
                });

                // Force editor to update
                setTimeout(function() {
                    $(window).trigger('resize');
                }, 500);
            }
        } catch (error) {}
    }

    /**
     * Fix vertical positioning in the Elementor editor
     * This prevents the content wrapper from jumping to the top when vertical position controls are used
     */
    function fixVerticalPositioningInEditor($container) {
        // Get the content container and wrapper
        const $contentContainer = $container.find('.hero-slide-content-container');
        const $contentWrapper = $container.find('.hero-slide-content-wrapper');

        if (!$contentContainer.length || !$contentWrapper.length) {
            return;
        }

        // Set up a mutation observer to watch for style changes
        if (window.MutationObserver) {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.attributeName === 'style') {
                        // Get the current align-items value
                        const alignItems = $contentContainer.css('align-items');

                        // Fix for content overlap in editor
                        if ($container.hasClass('content-overlap-yes')) {
                            if (alignItems === 'flex-start') {
                                $contentWrapper.css({
                                    'position': 'absolute',
                                    'top': '0',
                                    'transform': 'translateY(var(--hero-content-vertical-position-offset-top, 3rem))'
                                });
                            } else if (alignItems === 'center') {
                                $contentWrapper.css({
                                    'position': 'absolute',
                                    'top': '50%',
                                    'transform': 'translateY(-50%)'
                                });
                            } else if (alignItems === 'flex-end') {
                                $contentWrapper.css({
                                    'position': 'absolute',
                                    'top': '100%',
                                    'transform': 'translateY(-50px)'
                                });
                            }
                        }

                        // Ensure the content container maintains its height
                        $contentContainer.css({
                            'min-height': '100%',
                            'height': 'auto'
                        });
                    }
                });
            });

            // Start observing the content container for style changes
            observer.observe($contentContainer[0], { attributes: true, attributeFilter: ['style'] });

            // Store the observer in the container's data for cleanup
            $container.data('positionObserver', observer);
        }

        // Also handle initial state
        const alignItems = $contentContainer.css('align-items');
        if ($container.hasClass('content-overlap-yes')) {
            if (alignItems === 'flex-start') {
                $contentWrapper.css({
                    'position': 'absolute',
                    'top': '0',
                    'transform': 'translateY(var(--hero-content-vertical-position-offset-top, 3rem))'
                });
            } else if (alignItems === 'center') {
                $contentWrapper.css({
                    'position': 'absolute',
                    'top': '50%',
                    'transform': 'translateY(-50%)'
                });
            } else if (alignItems === 'flex-end') {
                $contentWrapper.css({
                    'position': 'absolute',
                    'top': '100%',
                    'transform': 'translateY(-50px)'
                });
            }
        }

        // Listen for Elementor control changes
        if (window.elementor) {
            $(window.elementor.$window).on('elementor/frontend/init', function() {
                elementor.channels.editor.on('change', function() {
                    // Re-apply the vertical positioning fix after a short delay
                    setTimeout(function() {
                        fixVerticalPositioningInEditor($container);
                    }, 300);
                });
            });
        }
    }

    // Initialize on document ready
    $(document).ready(function() {
        initHeroSlider();
    });

    // Initialize in Elementor frontend
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/hero_slider.default', function($scope) {
                initHeroSlider();

                // Also handle editor-specific initialization
                if ($('body').hasClass('elementor-editor-active')) {
                    const $container = $scope.find('.hero-slider-container');
                    handleEditorOverflow($container);
                }
            });
        }
    });

})(jQuery);