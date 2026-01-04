/**
 * Image Text Slider Editor Logic
 * Handles Elementor editor specific functionality
 */
(function (window) {
    "use strict";

    // Dependencies
    const AccessibilityUtils = window.PromenAccessibilityUtils;

    /**
     * Initialize sliders specifically for editor mode
     */
    function initEditorSliders() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function (slider) {
            initImageTextSliderForEditor(slider);
        });

        // Ensure proper spacer positioning in editor
        if (typeof window.positionSliderSpacers === 'function') {
            window.positionSliderSpacers();
        }

        // Update spacing indicators
        setTimeout(function () {
            updateEditorSpacingIndicators();
        }, 200);
    }

    /**
     * Initialize a single slider for editor mode with basic functionality
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function initImageTextSliderForEditor(sliderEl) {
        if (!sliderEl || typeof Swiper === 'undefined') {
            setupEditorSlider(sliderEl);
            return;
        }

        // Check if already initialized to prevent conflicts
        if (sliderEl.classList.contains('editor-initialized')) {
            return;
        }

        // If slider already initialized, destroy it first
        if (sliderEl.swiper) {
            sliderEl.swiper.destroy(true, true);
            sliderEl.swiper = null;
        }

        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.destroy(true, true);
            sliderEl.contentSwiper = null;
        }

        // Mark as initialized
        sliderEl.classList.add('editor-initialized');

        // Get slider options from data attribute
        let options = {};
        try {
            options = JSON.parse(sliderEl.getAttribute('data-options')) || {};
        } catch (e) {
            // Error parsing slider options
        }

        // Editor-specific settings (simpler configuration)
        const editorOptions = {
            ...options,
            autoplay: false, // Disable autoplay in editor
            enableGsapAnimations: false, // Disable animations in editor
            speed: 300 // Faster transitions for better UX in editor
        };

        // Get slide count for proper initialization
        const slideCount = sliderEl.querySelectorAll('.swiper .swiper-slide').length;
        const useLoop = slideCount > 1;

        // Store reference for content swiper to be used in callbacks
        let contentSwiper = null;

        // Initialize main image slider with basic settings
        try {
            const swiper = new Swiper(sliderEl.querySelector('.swiper'), {
                slidesPerView: 1,
                effect: 'slide', // Use slide effect for better editor performance
                speed: editorOptions.speed,
                loop: useLoop,
                loopedSlides: useLoop ? slideCount : null, // Ensure proper loop handling
                autoplay: false,
                preventInteractionOnTransition: true,
                pagination: sliderEl.querySelector('.swiper-pagination') ? {
                    el: sliderEl.querySelector('.swiper-pagination'),
                    clickable: true,
                    type: 'bullets'
                } : false,
                navigation: {
                    nextEl: Array.from(sliderEl.querySelectorAll('.swiper-button-next')),
                    prevEl: Array.from(sliderEl.querySelectorAll('.swiper-button-prev')),
                },
                allowTouchMove: true,
                grabCursor: true,
                on: {
                    init: function () { },
                    slideChange: function () {
                        // Sync content slider if available - use proper index handling
                        if (contentSwiper && typeof contentSwiper.slideTo === 'function') {
                            const targetIndex = useLoop ? this.realIndex : this.activeIndex;
                            if (useLoop) {
                                contentSwiper.slideToLoop(targetIndex, 0, false);
                            } else {
                                contentSwiper.slideTo(targetIndex, 0, false);
                            }
                        }
                    }
                }
            });

            // Initialize content slider with matching settings
            contentSwiper = new Swiper(sliderEl.querySelector('.swiper-content-slider'), {
                slidesPerView: 1,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 0, // Instant transitions for content
                allowTouchMove: false,
                loop: useLoop,
                loopedSlides: useLoop ? slideCount : null, // Match main swiper settings
                preventInteractionOnTransition: true,
                on: {
                    init: function () {
                        // Set initial slide to match main swiper
                        const initialIndex = useLoop ? swiper.realIndex : swiper.activeIndex;
                        if (useLoop) {
                            this.slideToLoop(initialIndex, 0, false);
                        } else {
                            this.slideTo(initialIndex, 0, false);
                        }
                    }
                }
            });

            // Store swiper instances
            sliderEl.swiper = swiper;
            sliderEl.contentSwiper = contentSwiper;

            // Check slide count and toggle controls visibility for editor
            if (AccessibilityUtils && typeof AccessibilityUtils.checkSlideCountAndToggleControls === 'function') {
                AccessibilityUtils.checkSlideCountAndToggleControls(sliderEl, swiper);
            }

            // Ensure initial synchronization after both sliders are ready
            setTimeout(function () {
                if (swiper && contentSwiper) {
                    const initialIndex = useLoop ? swiper.realIndex : swiper.activeIndex;
                    if (useLoop) {
                        contentSwiper.slideToLoop(initialIndex, 0, false);
                    } else {
                        contentSwiper.slideTo(initialIndex, 0, false);
                    }
                }
            }, 50);

            // Add navigation event handlers with better error handling
            const prevBtns = sliderEl.querySelectorAll('.swiper-button-prev');
            const nextBtns = sliderEl.querySelectorAll('.swiper-button-next');

            prevBtns.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (swiper && typeof swiper.slidePrev === 'function') {
                        swiper.slidePrev();
                    }
                });
            });

            nextBtns.forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (swiper && typeof swiper.slideNext === 'function') {
                        swiper.slideNext();
                    }
                });
            });

        } catch (error) {
            // Clean up on error
            sliderEl.classList.remove('editor-initialized');
            if (sliderEl.swiper) {
                sliderEl.swiper.destroy(true, true);
                sliderEl.swiper = null;
            }
            if (sliderEl.contentSwiper) {
                sliderEl.contentSwiper.destroy(true, true);
                sliderEl.contentSwiper = null;
            }
            // Fallback to static display
            setupEditorSlider(sliderEl);
        }
    }

    /**
     * Sets up editor view for all sliders
     */
    function setupEditorView() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function (slider) {
            setupEditorSlider(slider);
        });

        // Ensure proper spacer positioning in editor
        if (typeof window.positionSliderSpacers === 'function') {
            window.positionSliderSpacers();
        }
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
            slides[0].classList.add('swiper-slide-active');
        }

        if (contentSlides.length > 0) {
            contentSlides[0].style.zIndex = '2';
            contentSlides[0].style.opacity = '1';
            contentSlides[0].style.visibility = 'visible';
            contentSlides[0].classList.add('swiper-slide-active');
        }

        // Check slide count and toggle controls visibility for static editor view
        const slideCount = slides.length;
        const controlsContainer = sliderEl.querySelector('.image-text-slider-controls-persistent');
        const fractionIndicator = sliderEl.querySelector('.slider-fraction-indicator-persistent');

        if (slideCount >= 3) {
            if (controlsContainer) {
                controlsContainer.style.display = '';
                controlsContainer.setAttribute('aria-hidden', 'false');
            }
            if (fractionIndicator) {
                fractionIndicator.style.display = '';
                fractionIndicator.setAttribute('aria-hidden', 'false');
            }
        } else {
            if (controlsContainer) {
                controlsContainer.style.display = 'none';
                controlsContainer.setAttribute('aria-hidden', 'true');
            }
            if (fractionIndicator) {
                fractionIndicator.style.display = 'none';
                fractionIndicator.setAttribute('aria-hidden', 'true');
            }
        }
    }

    /**
     * Reset editor slider initialization (useful for debugging)
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function resetEditorSlider(sliderEl) {
        if (!sliderEl) return;

        sliderEl.classList.remove('editor-initialized');
        if (sliderEl.swiper) {
            sliderEl.swiper.destroy(true, true);
            sliderEl.swiper = null;
        }
        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.destroy(true, true);
            sliderEl.contentSwiper = null;
        }
        setTimeout(function () {
            initImageTextSliderForEditor(sliderEl);
        }, 100);
    }

    /**
     * Update visual spacing indicators in the editor
     */
    function updateEditorSpacingIndicators() {
        if (!window.elementorFrontend || !window.elementorFrontend.isEditMode()) return;

        const sliderWidgets = document.querySelectorAll('.elementor-widget-image_text_slider');
        sliderWidgets.forEach(function (widget) {
            const spacingIndicator = widget.querySelector('.editor-spacing-indicator');
            if (!spacingIndicator) return;

            const computedStyle = window.getComputedStyle(widget);
            const marginBottom = computedStyle.marginBottom;

            if (marginBottom && marginBottom !== '0px') {
                const marginValue = parseInt(marginBottom, 10);
                const span = spacingIndicator.querySelector('span');
                if (span) {
                    span.textContent = `Bottom Spacing Area (${marginValue}px)`;
                }
            }
        });
    }

    window.initEditorSliders = initEditorSliders;
    window.initImageTextSliderForEditor = initImageTextSliderForEditor;
    window.setupEditorView = setupEditorView;
    window.resetEditorSlider = resetEditorSlider;
    window.updateEditorSpacingIndicators = updateEditorSpacingIndicators;

})(window);
