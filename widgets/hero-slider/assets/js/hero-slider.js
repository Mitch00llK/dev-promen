/**
 * Hero Slider Widget JavaScript
 * 
 * Optimized version with improved performance and structure
 */

(function ($) {
    'use strict';

    // Check if Swiper is available
    var isSwiperAvailable = typeof Swiper !== 'undefined';

    if (!isSwiperAvailable) { }

    /**
     * Load remaining slides progressively after page load
     */
    function loadRemainingSlides($container) {
        const $remainingSlidesScript = $container.find('.hero-slider-remaining-slides');
        if (!$remainingSlidesScript.length) {
            return Promise.resolve(); // No remaining slides to load
        }

        try {
            const remainingSlidesData = JSON.parse($remainingSlidesScript.text());
            const $wrapper = $container.find('.swiper-wrapper');

            if (!remainingSlidesData || !Array.isArray(remainingSlidesData) || remainingSlidesData.length === 0) {
                return Promise.resolve();
            }

            // Append remaining slides to the wrapper
            remainingSlidesData.forEach(function (slideData) {
                if (slideData.html) {
                    const $slideHtml = $(slideData.html);
                    $wrapper.append($slideHtml);

                    // Mark content containers in newly loaded slides to prevent duplicate processing
                    $slideHtml.find('.hero-slide-content-container').each(function () {
                        const $container = $(this);
                        if (!$container.data('content-initialized')) {
                            $container.data('content-initialized', true);
                        }
                    });

                    $slideHtml.find('.hero-slide-content-wrapper').each(function () {
                        const $wrapper = $(this);
                        if (!$wrapper.data('content-initialized')) {
                            $wrapper.data('content-initialized', true);
                        }
                    });
                }
            });

            // Remove the script tag after loading
            $remainingSlidesScript.remove();

            return Promise.resolve();
        } catch (error) {
            console.error('Error loading remaining slides:', error);
            return Promise.resolve(); // Continue even if there's an error
        }
    }

    /**
     * Initialize Hero Slider
     */
    function initHeroSlider() {
        $('.hero-slider-container').each(function () {
            try {
                const $container = $(this);
                const sliderId = $container.attr('id');
                const displayType = $container.data('display-type') || 'slider';

                // Check if already initialized to prevent double initialization
                if ($container.data('hero-slider-initialized')) {
                    return;
                }

                if (!sliderId) {
                    const randomId = 'hero-slider-' + Math.floor(Math.random() * 10000);
                    $container.attr('id', randomId);
                }

                // If static mode, just ensure proper styling and exit
                if (displayType === 'static') {
                    $container.addClass('hero-static-mode');
                    $container.removeClass('hero-slider-mode');
                    $container.data('hero-slider-initialized', true);
                    return;
                }

                // Get the slider element
                const $slider = $container.find('.hero-slider');
                if (!$slider.length) {
                    return;
                }

                // Check if Swiper is already initialized on this element
                const $swiperElement = $container.find('.swiper')[0];
                if ($swiperElement && $swiperElement.swiper) {
                    // Swiper already exists, just mark as initialized and return
                    $container.data('hero-slider-initialized', true);
                    $container.data('swiper', $swiperElement.swiper);
                    return;
                }

                // Load remaining slides first, then initialize Swiper
                loadRemainingSlides($container).then(function () {
                    initializeSwiper($container, sliderId);
                });
            } catch (mainError) { }
        });
    }

    /**
     * Initialize Swiper instance
     */
    function initializeSwiper($container, sliderId) {
        try {

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
                $container.data('hero-slider-initialized', true);
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
                    init: function () {
                        // Handle overflow for Elementor
                        handleOverflow($container);

                        // Make sure navigation arrows are visible
                        ensureNavigationVisible($container);
                    },
                    slideChange: function () {
                        // Ensure navigation arrows remain visible during slide transitions
                        ensureNavigationVisible($container);
                    },
                    resize: function () {
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
                // Mark as initialized to prevent re-initialization
                $container.data('hero-slider-initialized', true);
            } catch (error) {
                applyFallbackStyles($container, $slider);
                $container.data('hero-slider-initialized', true);
            }
        } catch (error) {
            console.error('Error initializing Swiper:', error);
        }
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
                // Track if overflow has been applied to prevent redundant processing
                const overflowApplied = $container.data('overflow-applied');

                // Add overflow visible to all parent elements up to 5 levels (only once)
                if (!overflowApplied) {
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

                    $container.data('overflow-applied', true);
                }

                // Always ensure slide and content containers have proper overflow
                // (needed for newly loaded slides)
                $container.find('.hero-slide, .hero-slide-content-container').css({
                    'overflow': 'visible',
                    'margin-bottom': '0'
                });

                // Ensure Swiper elements have proper overflow
                $container.find('.swiper, .swiper-wrapper, .swiper-slide').css({
                    'overflow': 'visible'
                });

                // Ensure content wrapper has proper styling (only apply once per wrapper)
                $container.find('.hero-slide-content-wrapper').each(function () {
                    const $wrapper = $(this);
                    if (!$wrapper.data('overflow-styled')) {
                        $wrapper.css({
                            'z-index': '10',
                            'margin-bottom': '0'
                        });
                        $wrapper.data('overflow-styled', true);
                    }
                });
            }
        } catch (error) { }
    }

    /**
     * Handle overflow specifically for Elementor editor
     */
    function handleEditorOverflow($container) {
        try {
            if (!$container || !$container.length) {
                return;
            }

            // Prevent multiple initializations
            if ($container.data('editor-overflow-initialized')) {
                return;
            }

            // Check if we're in the editor
            if (!window.elementor && !window.elementorFrontend) {
                return;
            }

            // Mark as initialized
            $container.data('editor-overflow-initialized', true);

            // Fix for vertical positioning in editor
            fixVerticalPositioningInEditor($container);

            // Check if container has overflow classes
            if ($container.hasClass('content-overflow-yes')) {
                // Force editor to respect overflow (only once)
                $('.elementor-editor-active .elementor-inner, .elementor-editor-active .elementor-widget-wrap').css({
                    'overflow': 'visible'
                });

                // Make sure the content wrapper has a high z-index (only once per wrapper)
                $container.find('.hero-slide-content-wrapper').each(function () {
                    const $wrapper = $(this);
                    if (!$wrapper.data('editor-z-index-applied')) {
                        $wrapper.css({
                            'z-index': '999'
                        });
                        $wrapper.data('editor-z-index-applied', true);
                    }
                });

                // Apply to all parent elements in the editor (only once)
                $container.parents().css({
                    'overflow': 'visible'
                });

                // Force editor to update (only once)
                setTimeout(function () {
                    $(window).trigger('resize');
                }, 500);
            }
        } catch (error) { }
    }

    /**
     * Fix vertical positioning in the Elementor editor
     * This prevents the content wrapper from jumping to the top when vertical position controls are used
     */
    function fixVerticalPositioningInEditor($container) {
        // Prevent multiple initializations
        if ($container.data('vertical-positioning-initialized')) {
            return;
        }

        // Get the content container and wrapper
        const $contentContainer = $container.find('.hero-slide-content-container');
        const $contentWrapper = $container.find('.hero-slide-content-wrapper');

        if (!$contentContainer.length || !$contentWrapper.length) {
            return;
        }

        // Mark as initialized to prevent duplicate observers
        $container.data('vertical-positioning-initialized', true);

        // Disconnect existing observer if one exists
        const existingObserver = $container.data('positionObserver');
        if (existingObserver && existingObserver.disconnect) {
            existingObserver.disconnect();
        }

        // Set up a mutation observer to watch for style changes
        if (window.MutationObserver) {
            const observer = new MutationObserver(function (mutations) {
                mutations.forEach(function (mutation) {
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
            $(window.elementor.$window).on('elementor/frontend/init', function () {
                elementor.channels.editor.on('change', function () {
                    // Re-apply the vertical positioning fix after a short delay
                    setTimeout(function () {
                        fixVerticalPositioningInEditor($container);
                    }, 300);
                });
            });
        }
    }

    // Track if document ready initialization has run
    let documentReadyInitialized = false;

    // Initialize on document ready - wait for full page load for progressive loading
    $(document).ready(function () {
        if (!documentReadyInitialized) {
            // Wait for window load to ensure all resources are loaded before loading remaining slides
            if (document.readyState === 'complete') {
                initHeroSlider();
            } else {
                $(window).on('load', function () {
                    initHeroSlider();
                });
            }
            documentReadyInitialized = true;
        }
    });

    // Initialize in Elementor frontend
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/hero_slider.default', function ($scope) {
                // Only initialize if not already initialized
                const $container = $scope.find('.hero-slider-container');
                if ($container.length && !$container.data('hero-slider-initialized')) {
                    initHeroSlider();
                }

                // Also handle editor-specific initialization
                if ($('body').hasClass('elementor-editor-active')) {
                    handleEditorOverflow($container);
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