/**
 * Image Text Slider JavaScript
 * Initializes Swiper with the appropriate settings and ensures proper synchronization
 * Now with mobile performance optimizations
 */
(function() {
    "use strict";

    // Performance optimizations
    const isMobile = window.innerWidth <= 768;
    const isLowEndDevice = navigator.hardwareConcurrency <= 2 ||
        navigator.deviceMemory <= 4 ||
        /Android.*4\.|iPhone.*OS [5-9]_/.test(navigator.userAgent);

    // Global instances tracker for performance monitoring
    window.imageTextSliderInstances = window.imageTextSliderInstances || new Map();

    // Performance utilities
    const debounce = (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    const throttle = (func, limit) => {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };

    document.addEventListener('DOMContentLoaded', function() {
        // Check if we're in Elementor editor
        const isElementorEditor = document.body.classList.contains('elementor-editor-active');

        // Only initialize sliders if we're not in the editor preview
        if (!isElementorEditor) {
            // Delayed initialization for better page load performance
            const initDelay = isMobile ? 300 : 100;
            setTimeout(initImageTextSliders, initDelay);
        } else {
            // In editor mode, just show the first slide of each slider
            setupEditorView();
        }

        // Handle resize events to ensure proper spacing (debounced for performance)
        window.addEventListener('resize', debounce(handleSliderResize, 250));

        // Handle scroll events to ensure proper positioning (throttled for mobile)
        if (isMobile) {
            const throttle = (func, limit) => {
                let inThrottle;
                return function() {
                    if (!inThrottle) {
                        func.apply(this, arguments);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                }
            };
            window.addEventListener('scroll', throttle(handleSliderScroll, 200), { passive: true });
        } else {
            window.addEventListener('scroll', handleSliderScroll, { passive: true });
        }

        // Initial positioning of the spacer
        setTimeout(positionSliderSpacers, 100);

        // Add a more comprehensive resize handler that prevents overlap issues
        addComprehensiveResizeHandler();

        // Apply static alignment for content slides
        setTimeout(ensureStaticContentAlignment, 300);

        // Check if elementorFrontend and hooks are available
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            // Reinitialize sliders when Elementor frontend is initialized
            elementorFrontend.hooks.addAction('frontend/element_ready/image_text_slider.default', function($scope) {
                if (!isElementorEditor) {
                    initImageTextSlider($scope.find('.image-text-slider-container')[0]);
                } else {
                    setupEditorSlider($scope.find('.image-text-slider-container')[0]);
                }

                // Handle breadcrumb visibility in the editor
                if (window.elementor && window.elementorFrontend.isEditMode()) {
                    const widget = $scope.data('model-cid');

                    if (widget) {
                        // Listen for changes to the breadcrumb settings
                        elementor.channels.editor.on('change', function(view) {
                            const changedWidget = view.model.cid;

                            // Only proceed if this is our widget
                            if (changedWidget !== widget) {
                                return;
                            }

                            // Get the changed control name
                            const changedControlName = view.model.get('name');

                            // If the breadcrumb visibility or position control changed
                            if (changedControlName === 'show_breadcrumb' || changedControlName === 'breadcrumb_position') {
                                // Re-render the widget
                                window.elementor.reloadPreview();
                            }
                        });
                    }
                }
            });

            // Additional handling for editor mode
            if (window.elementorFrontend.isEditMode()) {
                // Initialize on section/column changes in Elementor editor
                elementorFrontend.hooks.addAction('frontend/element_ready/section', function() {
                    setTimeout(function() {
                        setupEditorView();
                    }, 100);
                });

                elementorFrontend.hooks.addAction('frontend/element_ready/column', function() {
                    setTimeout(function() {
                        setupEditorView();
                    }, 100);
                });

                // Initialize when panel is opened
                if (window.elementor && window.elementor.hooks) {
                    window.elementor.hooks.addAction('panel/open_editor/widget', function() {
                        setTimeout(function() {
                            setupEditorView();
                        }, 100);
                    });
                }

                // Initialize on any preview reload
                document.addEventListener('elementor/popup/show', function() {
                    setTimeout(function() {
                        setupEditorView();
                    }, 50);
                });
            }

            // Add resize handler when elements are ready
            elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
                setTimeout(positionSliderSpacers, 100);
            });
        } else {
            // If elementorFrontend hooks are not available, initialize sliders directly
            console.log('Elementor hooks not available, initializing sliders directly');
            // This ensures that sliders will work even if Elementor hooks are not loaded
            setTimeout(function() {
                initImageTextSliders();
                positionSliderSpacers();
            }, 300);
        }

        // Force hide inactive content slides on initial load
        setTimeout(forceHideInactiveContentSlides, 100);
        // And again after a longer delay to catch any late rendering
        setTimeout(forceHideInactiveContentSlides, 500);
        // And again after full page load
        window.addEventListener('load', () => {
            forceHideInactiveContentSlides();
            setTimeout(forceHideInactiveContentSlides, 200);
        });

        // Performance monitoring for mobile
        if (isMobile) {
            // Monitor performance and adjust if needed
            setTimeout(monitorPerformance, 2000);
            setInterval(monitorPerformance, 10000); // Check every 10 seconds
        }
    });

    /**
     * Adds a comprehensive resize handler to prevent container overflow issues
     */
    function addComprehensiveResizeHandler() {
        // Track the last window width to detect actual size changes
        let lastWidth = window.innerWidth;

        // Create a resize observer to watch for container changes
        if ('ResizeObserver' in window) {
            const resizeObserver = new ResizeObserver((entries) => {
                // When any observed element changes size, reposition spacers
                positionSliderSpacers();
                // Add clear spacing after sliders
                ensureProperSpacingAfterSliders();
            });

            // Observe all slider containers
            document.querySelectorAll('.image-text-slider-container').forEach(slider => {
                resizeObserver.observe(slider);

                // Also observe the next element to ensure proper spacing
                if (slider.nextElementSibling) {
                    resizeObserver.observe(slider.nextElementSibling);
                }
            });
        }

        // Enhanced resize handler with debounce
        window.addEventListener('resize', () => {
            // Only process if width actually changed (height changes don't cause overlap issues as much)
            if (window.innerWidth !== lastWidth) {
                lastWidth = window.innerWidth;

                // Clear any existing timeout
                clearTimeout(window.sliderComprehensiveResizeTimer);

                // Set timeout for debounce
                window.sliderComprehensiveResizeTimer = setTimeout(() => {
                    positionSliderSpacers();
                    ensureProperSpacingAfterSliders();

                    // Force a small shift in layout to trigger proper recalculation
                    document.querySelectorAll('.image-text-slider-container').forEach(slider => {
                        // Temporarily add 1px to force layout recalculation
                        const currentHeight = slider.style.height;
                        slider.style.height = (parseInt(getComputedStyle(slider).height) + 1) + 'px';

                        // Reset back after a small delay
                        setTimeout(() => {
                            slider.style.height = currentHeight;
                        }, 50);
                    });
                }, 250);
            }
        });
    }

    /**
     * Ensure proper spacing after sliders to prevent container overflow
     */
    function ensureProperSpacingAfterSliders() {
        document.querySelectorAll('.image-text-slider-container').forEach(slider => {
            // Create or get the spacer element
            let spacer = slider.nextElementSibling;
            if (!spacer || !spacer.classList.contains('slider-bottom-spacer')) {
                // Create spacer if it doesn't exist
                spacer = document.createElement('div');
                spacer.classList.add('slider-bottom-spacer');
                // Insert after slider
                if (slider.nextElementSibling) {
                    slider.parentNode.insertBefore(spacer, slider.nextElementSibling);
                } else {
                    slider.parentNode.appendChild(spacer);
                }
            }

            // Get the slider height including any extended overlays
            const sliderRect = slider.getBoundingClientRect();
            const sliderHeight = sliderRect.height;

            // Find any overlay elements that might extend beyond
            const extendedOverlays = slider.querySelectorAll('.absolute-overlay-image.extend-beyond');
            let maxExtension = 0;

            extendedOverlays.forEach(overlay => {
                if (overlay.classList.contains('position-bottom-left') ||
                    overlay.classList.contains('position-bottom-center') ||
                    overlay.classList.contains('position-bottom-right')) {
                    const overlayRect = overlay.getBoundingClientRect();
                    const extension = (overlayRect.bottom - sliderRect.bottom);
                    maxExtension = Math.max(maxExtension, extension);
                }
            });

            // Apply appropriate height to the spacer
            spacer.style.height = (maxExtension + 1) + 'px';
        });
    }

    /**
     * Handle scroll events for sliders
     */
    function handleSliderScroll() {
        // Debounce the scroll handler
        clearTimeout(window.sliderScrollTimer);
        window.sliderScrollTimer = setTimeout(() => {
            ensureProperSpacingAfterSliders();
        }, 200);
    }

    /**
     * Position the bottom spacers for all sliders
     */
    function positionSliderSpacers() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function(slider) {
            const spacer = slider.nextElementSibling;

            // Create spacer if it doesn't exist
            if (!spacer || !spacer.classList.contains('slider-bottom-spacer')) {
                const newSpacer = document.createElement('div');
                newSpacer.classList.add('slider-bottom-spacer');

                if (slider.nextElementSibling) {
                    slider.parentNode.insertBefore(newSpacer, slider.nextElementSibling);
                } else {
                    slider.parentNode.appendChild(newSpacer);
                }

                updateSpacerPosition(slider, newSpacer);
            } else if (spacer) {
                updateSpacerPosition(slider, spacer);
            }

            // Force the next element to have proper z-index
            if (spacer && spacer.nextElementSibling) {
                spacer.nextElementSibling.style.position = 'relative';
                spacer.nextElementSibling.style.zIndex = '0';
            }
        });
    }

    /**
     * Update the spacer position for a specific slider
     * @param {HTMLElement} slider - The slider container
     * @param {HTMLElement} spacer - The spacer element
     */
    function updateSpacerPosition(slider, spacer) {
        if (!slider || !spacer) return;

        // Get the slider height
        const sliderHeight = slider.offsetHeight;

        // Check if the slider has extended overlays
        const hasExtendedOverlays = slider.classList.contains('has-extended-overlays');

        // Set spacer position
        spacer.style.position = 'relative';
        spacer.style.zIndex = '1';
        spacer.style.marginTop = hasExtendedOverlays ? '0' : '-1px';

        // Add a small delay for overlays to settle
        setTimeout(() => {
            // Find any absolute overlay images that extend beyond
            const extendingOverlays = slider.querySelectorAll('.absolute-overlay-image.extend-beyond');
            let maxExtension = 0;

            // Calculate maximum extension
            extendingOverlays.forEach(overlay => {
                if (overlay.classList.contains('position-bottom-left') ||
                    overlay.classList.contains('position-bottom-center') ||
                    overlay.classList.contains('position-bottom-right')) {
                    const overlayRect = overlay.getBoundingClientRect();
                    const sliderRect = slider.getBoundingClientRect();
                    const extension = (overlayRect.bottom - sliderRect.bottom);
                    if (extension > maxExtension) {
                        maxExtension = extension;
                    }
                }
            });

            // Apply max extension as padding if needed
            if (maxExtension > 0) {
                slider.style.paddingBottom = maxExtension + 'px';
            }
        }, 200);
    }

    /**
     * Handle resize events for all sliders
     */
    function handleSliderResize() {
        // Debounce the resize handler
        clearTimeout(window.sliderResizeTimer);
        window.sliderResizeTimer = setTimeout(() => {
            positionSliderSpacers();
            ensureProperSpacingAfterSliders();

            // Reapply static content alignment
            ensureStaticContentAlignment();

            // Force container below to redraw
            document.querySelectorAll('.image-text-slider-container').forEach(slider => {
                if (slider.nextElementSibling && slider.nextElementSibling.nextElementSibling) {
                    const elem = slider.nextElementSibling.nextElementSibling;
                    const display = elem.style.display;
                    elem.style.display = 'none';
                    void elem.offsetHeight; // Force reflow
                    elem.style.display = display;
                }
            });
        }, 150);
    }

    /**
     * Sets up editor view for all sliders
     */
    function setupEditorView() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function(slider) {
            setupEditorSlider(slider);
        });

        // Ensure proper spacer positioning in editor
        positionSliderSpacers();
    }

    /**
     * Sets up editor view for a single slider
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function setupEditorSlider(sliderEl) {
        if (!sliderEl) return;

        // Show first slide and its content in editor
        const slides = sliderEl.querySelectorAll('.swiper-slide');
        const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');

        // Make sure first slides are visible and have higher z-index
        if (slides.length > 0) {
            slides[0].style.zIndex = '2';
            slides[0].style.opacity = '1';
            slides[0].style.visibility = 'visible';

            // Add active class to first slide for proper styling
            slides[0].classList.add('swiper-slide-active');
        }

        if (contentSlides.length > 0) {
            contentSlides[0].style.zIndex = '2';
            contentSlides[0].style.opacity = '1';
            contentSlides[0].style.visibility = 'visible';

            // Add active class to first content slide for proper styling
            contentSlides[0].classList.add('swiper-slide-active');
        }
    }

    /**
     * Initialize all image text sliders on the page
     */
    function initImageTextSliders() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function(slider) {
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

            // Mobile performance adjustments
            if (isMobile || isLowEndDevice) {
                options.speed = Math.max(options.speed || 500, 300); // Faster transitions
                options.enableGsapAnimations = false; // Disable GSAP on mobile
                options.effect = 'slide'; // Force slide effect (more performant)
            }
        } catch (e) {
            console.error('Error parsing slider options:', e);
        }

        // Add mobile optimization class
        if (isMobile) {
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

        // Configure Swiper options - critical fix: ensure loopedSlides is set properly
        const swiperOptions = {
            slidesPerView: 1,
            spaceBetween: 0,
            effect: options.effect || 'fade',
            speed: transitionSpeed,
            loop: useLoop,
            // Explicitly set loopedSlides to the number of slides if loop is enabled
            loopedSlides: useLoop ? slideCount : null,
            autoHeight: false,
            watchSlidesProgress: !isMobile, // Disable on mobile for performance
            grabCursor: true,
            observer: !isMobile, // Disable heavy observers on mobile
            observeParents: !isMobile,
            observeSlideChildren: !isMobile, // Disable on mobile for performance
            simulateTouch: true,
            preventInteractionOnTransition: true, // Prevent interaction during transition to avoid glitches
            preventClicksPropagation: false,
            // Ensure slides maintain proper order
            slideToClickedSlide: false, // This can cause order issues, disable it

            // Mobile-specific optimizations
            touchRatio: isMobile ? 1.2 : 1,
            touchAngle: isMobile ? 35 : 45,
            longSwipesRatio: isMobile ? 0.3 : 0.5,
            threshold: isMobile ? 5 : 0,

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

            // Events for managing visibility and transitions
            on: {
                init: function() {
                    // Add a short delay before showing content for initial load
                    setTimeout(() => {
                        sliderEl.classList.remove('initializing');
                        updateSlideVisibility(this);
                    }, 50);

                    // Store initial slide order for debugging
                    logSlideOrder(this, 'Main Swiper Init');
                },
                beforeTransitionStart: function() {
                    // Add transitioning class to handle content visibility during transitions
                    sliderEl.classList.add('transitioning');

                    // Force hide all inactive slides
                    forceHideInactiveContentSlides();

                    // Immediately hide content to prevent flashing
                    const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
                    contentSlides.forEach(slide => {
                        if (!slide.classList.contains('swiper-slide-active')) {
                            slide.style.opacity = "0";
                            slide.style.visibility = "hidden";
                        }
                    });
                },
                slideChange: function() {
                    updateSlideVisibility(this);
                    logSlideOrder(this, 'Main Swiper Change');

                    // Manually sync the content slider with the image slider
                    if (sliderEl.contentSwiper) {
                        // Get target slide before animation 
                        const targetIndex = useLoop ? this.realIndex : this.activeIndex;

                        // Reset all content slides immediately
                        if (options.enableGsapAnimations && window.gsap) {
                            const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
                            contentSlides.forEach(slide => resetSlideContent(slide));
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
                transitionStart: function() {
                    // If using GSAP, prepare content slides
                    if (options.enableGsapAnimations && window.gsap) {
                        const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide:not(.swiper-slide-active)');
                        contentSlides.forEach(slide => resetSlideContent(slide));
                    }
                },
                transitionEnd: function() {
                    // Remove transitioning class when finished
                    setTimeout(() => {
                        sliderEl.classList.remove('transitioning');

                        // Force correct visibility again after transition
                        forceHideInactiveContentSlides();
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
            console.warn('No slides found in slider');
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
                isMobile: isMobile,
                isLowEnd: isLowEndDevice
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
                    init: function() {
                        updateContentSlideVisibility(this);

                        // Set initial slide based on main swiper
                        if (useLoop) {
                            this.slideToLoop(swiper.realIndex, 0, false);
                        } else {
                            this.slideTo(swiper.activeIndex, 0, false);
                        }

                        // Log for debugging
                        logSlideOrder(this, 'Content Swiper Init');

                        // Initialize GSAP animations for first slide
                        if (options.enableGsapAnimations && window.gsap) {
                            const initialSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
                            if (initialSlide) {
                                // Show slide without animation first to prevent flashing
                                showSlideContentWithoutAnimation(initialSlide);

                                // Then animate with a slight delay
                                setTimeout(() => {
                                    resetSlideContent(initialSlide);
                                    animateSlideContent(initialSlide, options.animationDuration || 0.7);
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
                    slideChange: function() {
                        updateContentSlideVisibility(this);
                        logSlideOrder(this, 'Content Swiper Change');

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
                    transitionStart: function() {
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
                    transitionEnd: function() {
                        // Ensure only active slide is visible after transition
                        setTimeout(ensureStaticContentAlignment, 50);
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

            // Add event listener for navigation clicks to ensure sync
            sliderEl.querySelectorAll('.swiper-button-next, .swiper-button-prev').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isNext = btn.classList.contains('swiper-button-next');

                    // Add transitioning class
                    sliderEl.classList.add('transitioning');

                    // Handle navigation
                    if (isNext) {
                        swiper.slideNext();
                    } else {
                        swiper.slidePrev();
                    }
                });
            });

            // Listen for autoplay
            if (options.autoplay) {
                swiper.on('autoplay', function() {
                    // Add transitioning class
                    sliderEl.classList.add('transitioning');

                    // Keep content slider in sync with image slider during autoplay
                    if (useLoop) {
                        contentSwiper.slideToLoop(swiper.realIndex, 0, false);
                    } else {
                        contentSwiper.slideTo(swiper.activeIndex, 0, false);
                    }
                });
            }

            // Add CSS helper to handle transitions better
            const styleEl = document.createElement('style');
            styleEl.innerHTML = `
                .image-text-slider-container.transitioning .swiper-content-slider .swiper-slide:not(.swiper-slide-active),
                .image-text-slider-container.initializing .swiper-content-slider .swiper-slide:not(.swiper-slide-active) {
                    opacity: 0 !important;
                    visibility: hidden !important;
                    transition: none !important;
                }
            `;
            document.head.appendChild(styleEl);

            // Add GSAP animation if enabled
            if (options.enableGsapAnimations && window.gsap) {
                setupGsapAnimations(sliderEl, swiper, options);
            }

            // Update spacer after initialization
            const spacer = sliderEl.nextElementSibling;
            if (spacer && spacer.classList.contains('slider-bottom-spacer')) {
                setTimeout(() => updateSpacerPosition(sliderEl, spacer), 300);
            }

            // Add event listener to handle slide changes and update spacer if needed
            swiper.on('slideChange', function() {
                const spacer = sliderEl.nextElementSibling;
                if (spacer && spacer.classList.contains('slider-bottom-spacer')) {
                    setTimeout(() => updateSpacerPosition(sliderEl, spacer), 300);
                }
            });

            // After initialization, ensure static content alignment is preserved
            setTimeout(ensureStaticContentAlignment, 500);

            // Add event listener to ensure alignment on slide changes
            swiper.on('slideChangeTransitionEnd', function() {
                setTimeout(ensureStaticContentAlignment, 50);
            });

            // Remove initializing class after everything is set up
            setTimeout(() => {
                sliderEl.classList.remove('initializing');
                ensureStaticContentAlignment();
            }, 300);

        } catch (error) {
            console.error('Error initializing slider:', error);
            // Clean up in case of error
            sliderEl.classList.remove('initializing');
            sliderEl.classList.remove('transitioning');
        }
    }

    /**
     * Log the current order of slides for debugging purposes
     * @param {Swiper} swiper - The Swiper instance
     * @param {string} context - Context message for the log
     */
    function logSlideOrder(swiper, context) {
        if (!swiper || !swiper.slides || swiper.slides.length === 0) return;

        const isMainSwiper = swiper.el.classList.contains('swiper') && !swiper.el.classList.contains('swiper-content-slider');

        if (isMainSwiper) {
            const slideInfo = {
                context: context,
                activeIndex: swiper.activeIndex,
                realIndex: swiper.realIndex,
                slides: []
            };

            swiper.slides.forEach((slide, index) => {
                // Get slide ID from class (elementor-repeater-item-xxx)
                const classes = slide.className.split(' ');
                const idClass = classes.find(cls => cls.startsWith('elementor-repeater-item-'));
                const id = idClass ? idClass.replace('elementor-repeater-item-', '') : 'unknown';

                slideInfo.slides.push({
                    index: index,
                    id: id,
                    isActive: slide.classList.contains('swiper-slide-active'),
                    isVisible: window.getComputedStyle(slide).visibility !== 'hidden'
                });
            });

            // Only log if debugging is enabled
            if (window.debugImageTextSlider) {
                console.log('Image Text Slider Order:', slideInfo);
            }
        }
    }

    /**
     * Update slide visibility based on active, next, prev status
     * @param {Swiper} swiper - The Swiper instance
     */
    function updateSlideVisibility(swiper) {
        if (!swiper || !swiper.slides) return;

        swiper.slides.forEach(function(slide, index) {
            // Set all slides to hidden first
            slide.style.opacity = "0";
            slide.style.visibility = "hidden";

            // Make active, next and prev slides visible
            if (index === swiper.activeIndex ||
                (swiper.loop && (
                    // Handle loop edge cases properly
                    index === swiper.realIndex ||
                    index === swiper.activeIndex - 1 ||
                    index === swiper.activeIndex + 1 ||
                    // Handle wrap-around cases in loop mode
                    (swiper.activeIndex === 0 && index === swiper.slides.length - 1) ||
                    (swiper.activeIndex === swiper.slides.length - 1 && index === 0)
                )) ||
                (!swiper.loop && (
                    index === swiper.activeIndex - 1 ||
                    index === swiper.activeIndex + 1
                ))) {
                slide.style.opacity = "1";
                slide.style.visibility = "visible";
            }
        });
    }

    /**
     * Update content slide visibility based on active status
     * @param {Swiper} contentSwiper - The content Swiper instance
     */
    function updateContentSlideVisibility(contentSwiper) {
        if (!contentSwiper || !contentSwiper.slides) return;

        contentSwiper.slides.forEach(function(slide, index) {
            // Set all slides to hidden first - use direct style application for stronger effect
            slide.style.opacity = "0";
            slide.style.visibility = "hidden";
            slide.style.zIndex = "0";

            // We only want the active slide to be visible - use direct style application
            if (index === contentSwiper.activeIndex) {
                slide.style.opacity = "1";
                slide.style.visibility = "visible";
                slide.style.zIndex = "2";
            }
        });
    }

    // Expose initialization function for external use (especially in editor)
    window.initImageTextSliders = initImageTextSliders;
    window.setupEditorView = setupEditorView;
    window.positionSliderSpacers = positionSliderSpacers;

    // Add debugging toggle
    window.debugImageTextSlider = false;

    /**
     * Setup GSAP animations for the slider
     * @param {HTMLElement} sliderEl - The slider container element
     * @param {Swiper} swiper - The Swiper instance
     * @param {Object} options - The slider options
     */
    function setupGsapAnimations(sliderEl, swiper, options) {
        if (!window.gsap) return;

        const duration = options.animationDuration || 0.7;
        const useLoop = swiper.params.loop;

        // Keep track of animated slides to prevent re-animation
        const animatedSlides = new Set();

        // Animate initial slide
        const initialSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
        if (initialSlide) {
            animateSlideContent(initialSlide, duration);

            // Add slide ID to animated set
            const slideId = initialSlide.className.split(' ')
                .find(cls => cls.startsWith('elementor-repeater-item-content-'));
            if (slideId) animatedSlides.add(slideId);
        }

        // Add event listeners for slide changes
        swiper.on('slideChangeTransitionStart', function() {
            // Get the target slide index depending on loop mode
            const targetIndex = useLoop ? this.realIndex : this.activeIndex;

            // Reset all content slides first
            const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
            contentSlides.forEach(slide => resetSlideContent(slide));

            // Immediately make the target slide visible for smoother transition
            if (sliderEl.contentSwiper && sliderEl.contentSwiper.slides) {
                const targetSlide = Array.from(sliderEl.contentSwiper.slides).find((slide, index) => {
                    if (useLoop) {
                        // For loop mode, match by realIndex
                        return (index % (sliderEl.contentSwiper.slides.length / 3)) === targetIndex;
                    } else {
                        // For non-loop mode, match by direct index
                        return index === targetIndex;
                    }
                });

                if (targetSlide) {
                    showSlideContentWithoutAnimation(targetSlide);
                }
            }
        });

        swiper.on('slideChangeTransitionEnd', function() {
            // Get active content slide
            const activeSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
            if (!activeSlide) return;

            // Extract slide ID
            const slideId = activeSlide.className.split(' ')
                .find(cls => cls.startsWith('elementor-repeater-item-content-'));

            // Animate if not seen before, otherwise just show
            if (slideId && !animatedSlides.has(slideId)) {
                animateSlideContent(activeSlide, duration);
                animatedSlides.add(slideId);
            } else {
                showSlideContentWithoutAnimation(activeSlide);
            }
        });

        // Handle sync between content slider and animations
        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.on('slideChangeTransitionEnd', function() {
                // Get active slide from content swiper
                const activeSlide = this.slides[this.activeIndex];
                if (!activeSlide) return;

                // Extract slide ID
                const slideId = activeSlide.className.split(' ')
                    .find(cls => cls.startsWith('elementor-repeater-item-content-'));

                // Animate if not seen before
                if (slideId && !animatedSlides.has(slideId)) {
                    animateSlideContent(activeSlide, duration);
                    animatedSlides.add(slideId);
                }
            });
        }
    }

    /**
     * Animate the content of a slide with GSAP
     * @param {HTMLElement} slide - The slide element
     * @param {number} duration - Animation duration in seconds
     */
    function animateSlideContent(slide, duration) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        const navigation = slide.querySelector('.slider-navigation');

        // Kill any existing animations first
        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow, navigation]);

        const timeline = gsap.timeline({
            defaults: {
                duration: duration,
                ease: "power2.out",
                clearProps: "all" // Clear properties after animation to avoid conflicts
            }
        });

        // Animate different elements with sequence
        if (breadcrumbAbove) {
            timeline.fromTo(breadcrumbAbove, { opacity: 0, y: -15 }, { opacity: 1, y: 0, duration: duration * 0.6 });
        }

        if (title) {
            timeline.fromTo(title, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                breadcrumbAbove ? "-=0.2" : 0
            );
        }

        if (description) {
            timeline.fromTo(description, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.2"
            );
        }

        if (buttons) {
            timeline.fromTo(buttons, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.2"
            );
        }

        if (navigation) {
            timeline.fromTo(navigation, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.2"
            );
        }

        if (breadcrumbBelow) {
            timeline.fromTo(breadcrumbBelow, { opacity: 0, y: 15 }, { opacity: 1, y: 0, duration: duration * 0.6 },
                "-=0.2"
            );
        }
    }

    /**
     * Reset the content of a slide for GSAP animation
     * @param {HTMLElement} slide - The slide element
     */
    function resetSlideContent(slide) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        const navigation = slide.querySelector('.slider-navigation');

        // Kill any ongoing animations
        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow, navigation]);

        // Reset all elements to their starting positions
        if (breadcrumbAbove) gsap.set(breadcrumbAbove, { opacity: 0, y: -15 });
        if (title) gsap.set(title, { opacity: 0, y: 20 });
        if (description) gsap.set(description, { opacity: 0, y: 20 });
        if (buttons) gsap.set(buttons, { opacity: 0, y: 20 });
        if (navigation) gsap.set(navigation, { opacity: 0, y: 20 });
        if (breadcrumbBelow) gsap.set(breadcrumbBelow, { opacity: 0, y: 15 });
    }

    /**
     * Show slide content immediately without animation
     * @param {HTMLElement} slide - The slide element
     */
    function showSlideContentWithoutAnimation(slide) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        const navigation = slide.querySelector('.slider-navigation');

        // Kill any ongoing animations
        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow, navigation]);

        // Show all elements immediately at their final positions
        if (breadcrumbAbove) gsap.set(breadcrumbAbove, { opacity: 1, y: 0, clearProps: "all" });
        if (title) gsap.set(title, { opacity: 1, y: 0, clearProps: "all" });
        if (description) gsap.set(description, { opacity: 1, y: 0, clearProps: "all" });
        if (buttons) gsap.set(buttons, { opacity: 1, y: 0, clearProps: "all" });
        if (navigation) gsap.set(navigation, { opacity: 1, y: 0, clearProps: "all" });
        if (breadcrumbBelow) gsap.set(breadcrumbBelow, { opacity: 1, y: 0, clearProps: "all" });
    }

    /**
     * Ensures content slides have the correct static alignment in the frontend view
     */
    function ensureStaticContentAlignment() {
        // Only apply to non-editor views
        if (document.body.classList.contains('elementor-editor-active')) {
            return;
        }

        // Get all slider containers
        document.querySelectorAll('.image-text-slider-container').forEach(slider => {
            // Check if this is a single-slide setup
            const slideCount = slider.querySelectorAll('.swiper .swiper-slide').length;
            if (slideCount <= 1) {
                slider.classList.add('single-slide');
            } else {
                slider.classList.remove('single-slide');
            }

            // Get all content slides in this slider
            const contentSlides = slider.querySelectorAll('.swiper-content-slider .swiper-slide[class*="elementor-repeater-item-content"]');

            contentSlides.forEach(slide => {
                // Make sure the content slide respects the CSS styles we've defined
                slide.style.position = 'absolute';

                // If it's a multi-slide slider, ensure only active slide is visible
                if (slideCount > 1) {
                    if (slide.classList.contains('swiper-slide-active')) {
                        slide.style.opacity = '1';
                        slide.style.visibility = 'visible';

                        // Make sure content positioning is maintained
                        const slideContent = slide.querySelector('.slide-content-container');
                        if (slideContent) {
                            slideContent.style.visibility = 'visible';
                            slideContent.style.opacity = '1';
                        }
                    } else {
                        slide.style.opacity = '0';
                        slide.style.visibility = 'hidden';
                    }
                } else {
                    // For single slides, always make them visible
                    slide.style.opacity = '1';
                    slide.style.visibility = 'visible';
                }
            });
        });
    }

    // Add this new function to forcefully hide all non-active content slides
    function forceHideInactiveContentSlides() {
        document.querySelectorAll('.image-text-slider-container').forEach(slider => {
            const contentSlides = slider.querySelectorAll('.swiper-content-slider .swiper-slide');

            // First identify the active slide
            let activeSlide = null;
            contentSlides.forEach(slide => {
                if (slide.classList.contains('swiper-slide-active')) {
                    activeSlide = slide;
                }
            });

            // If we found an active slide, hide all others
            if (activeSlide) {
                contentSlides.forEach(slide => {
                    if (slide !== activeSlide) {
                        // Apply strong hiding
                        slide.style.opacity = "0";
                        slide.style.visibility = "hidden";
                        slide.style.pointerEvents = "none";
                        slide.style.position = "absolute";
                        slide.style.zIndex = "0";
                    } else {
                        // Ensure active slide is fully visible
                        slide.style.opacity = "1";
                        slide.style.visibility = "visible";
                        slide.style.pointerEvents = "auto";
                        slide.style.position = "absolute";
                        slide.style.zIndex = "2";
                    }
                });
            }
        });
    }

    /**
     * Monitor performance and adjust settings for mobile
     */
    function monitorPerformance() {
        if (!window.imageTextSliderInstances || !isMobile) return;

        window.imageTextSliderInstances.forEach((instance, id) => {
            const { swiper, element, options } = instance;

            // Check if autoplay is causing performance issues
            if (swiper && swiper.autoplay && swiper.autoplay.running) {
                const rect = element.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

                // Pause autoplay when slider is out of viewport
                if (!isVisible && !swiper.autoplay.paused) {
                    swiper.autoplay.pause();
                } else if (isVisible && swiper.autoplay.paused) {
                    swiper.autoplay.start();
                }
            }

            // Disable observers on very low-end devices after a while
            if (isLowEndDevice && swiper) {
                swiper.observer = false;
                swiper.observeParents = false;
                swiper.observeSlideChildren = false;
            }
        });
    }
})();