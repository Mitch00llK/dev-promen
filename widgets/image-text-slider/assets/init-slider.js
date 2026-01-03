/**
 * Image Text Slider Initialization
 * 
 * Initializes the slider with the provided ID and options
 */
function initImageTextSlider(sliderId) {
    // Skip re-initialization if already initialized for this slider
    if (window.initializedSliders && window.initializedSliders.includes(sliderId)) {
        return;
    }

    // Safety check for Swiper availability - important for archive pages
    if (typeof Swiper === 'undefined') {
        console.warn('Swiper not available yet for slider:', sliderId);

        // Retry initialization after a short delay
        setTimeout(function() {
            initImageTextSlider(sliderId);
        }, 500);

        return;
    }

    // Safety check for GSAP for better error handling
    const hasGsap = typeof gsap !== 'undefined';
    if (!hasGsap) {
        console.warn('GSAP not available for slider animations:', sliderId);
    }

    // Store initialized sliders
    if (!window.initializedSliders) window.initializedSliders = [];
    window.initializedSliders.push(sliderId);

    const slider = document.getElementById(sliderId);
    if (!slider) {
        console.warn('Slider element not found:', sliderId);
        return;
    }

    // Get options from data attribute
    let options = {};
    try {
        options = JSON.parse(slider.getAttribute('data-options') || '{}');
    } catch (e) {
        console.error('Error parsing slider options:', e);
    }

    // Global animation state flag
    let isAnimating = false;

    // Pre-initialize GSAP animations - hide all content to prevent FOUC
    if (options.enableGsapAnimations && hasGsap) {
        preInitializeAnimations(slider);
    }

    // Get slide count
    const slideCount = slider.querySelectorAll('.swiper .swiper-slide').length;
    const useLoop = slideCount > 1 && (options.infinite !== undefined ? options.infinite : true);

    // Initialize main image slider
    const imageSwiper = new Swiper(slider.querySelector('.swiper'), {
        slidesPerView: 1,
        effect: options.effect || 'fade',
        speed: options.speed || 500,
        loop: useLoop,
        loopedSlides: useLoop ? slideCount : null,
        autoplay: options.autoplay ? {
            delay: options.autoplaySpeed || 5000,
            disableOnInteraction: options.pauseOnHover || false,
            pauseOnMouseEnter: options.pauseOnHover || false
        } : false,
        pagination: slider.querySelector('.swiper-pagination') ? {
            el: slider.querySelector('.swiper-pagination'),
            clickable: true,
            type: options.paginationType || 'bullets'
        } : false,
        slideToClickedSlide: false,
        watchSlidesProgress: true,
        nested: false,
        preventInteractionOnTransition: true,
        allowTouchMove: !isAnimating, // Disable touch during animations
        on: {
            init: function() {
                // Force overflow visible
                this.el.style.overflow = 'visible';
                this.wrapperEl.style.overflow = 'visible';
                this.slides.forEach(slide => slide.style.overflow = 'visible');

                // Force parent containers to allow overflow
                let parent = this.el.parentElement;
                while (parent && parent !== document.body) {
                    if (getComputedStyle(parent).overflow === 'hidden') {
                        parent.style.overflow = 'visible';
                    }
                    parent = parent.parentElement;
                }

                // Debug logging if enabled
                if (window.debugImageTextSlider) {
                    console.log(`Image Slider Init: ${sliderId}`, {
                        slideCount: slideCount,
                        useLoop: useLoop,
                        initialIndex: this.activeIndex,
                        realIndex: this.realIndex
                    });
                }
            },
            slideChangeTransitionStart: function() {
                // Set animating flag to prevent multiple transitions
                isAnimating = true;
                this.params.allowTouchMove = false;

                // Sync content slider
                if (contentSwiper) {
                    // Temporarily disable transitions on content slider
                    contentSwiper.params.speed = 0;
                    contentSwiper.params.allowTouchMove = false;

                    if (useLoop) {
                        contentSwiper.slideToLoop(this.realIndex, 0, false);
                    } else {
                        contentSwiper.slideTo(this.activeIndex, 0, false);
                    }

                    // Restore original transition speed
                    setTimeout(() => {
                        contentSwiper.params.speed = options.speed || 500;
                    }, 50);
                }
            },
            slideChangeTransitionEnd: function() {
                // Re-enable interactions after transition completes
                setTimeout(() => {
                    isAnimating = false;
                    this.params.allowTouchMove = true;
                    if (contentSwiper) {
                        contentSwiper.params.allowTouchMove = true;
                    }
                }, (options.animationDuration || 0.7) * 1000 + 100);
            }
        }
    });

    // Initialize content slider
    const contentSwiper = new Swiper(slider.querySelector('.swiper-content-slider'), {
        slidesPerView: 1,
        effect: 'fade',
        fadeEffect: {
            crossFade: true
        },
        allowTouchMove: false,
        speed: options.speed || 500,
        loop: useLoop,
        loopedSlides: useLoop ? slideCount : null,
        preventInteractionOnTransition: true,
        on: {
            init: function() {
                // Set initial slide
                if (useLoop) {
                    this.slideToLoop(imageSwiper.realIndex, 0, false);
                }

                // Debug logging
                if (window.debugImageTextSlider) {
                    console.log(`Content Slider Init: ${sliderId}`, {
                        slideCount: this.slides.length,
                        useLoop: useLoop,
                        initialIndex: this.activeIndex,
                        realIndex: this.realIndex
                    });
                }
            }
        }
    });

    // Store swiper instances in the element
    slider.imageSwiper = imageSwiper;
    slider.contentSwiper = contentSwiper;

    // Add navigation event handlers
    const prevBtns = slider.querySelectorAll('.swiper-button-prev');
    const nextBtns = slider.querySelectorAll('.swiper-button-next');

    prevBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!isAnimating && !imageSwiper.animating) {
                imageSwiper.slidePrev();
            }
        });
    });

    nextBtns.forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!isAnimating && !imageSwiper.animating) {
                imageSwiper.slideNext();
            }
        });
    });

    // Initialize GSAP animations with a slight delay to ensure everything is properly loaded
    if (options.enableGsapAnimations && hasGsap) {
        // Wait until DOM is fully ready and initial layout is complete
        setTimeout(() => {
            initSliderAnimations(slider, imageSwiper, contentSwiper, options, isAnimating);
        }, 300);
    }

    // Set up bottom spacer for proper layout
    const spacer = slider.querySelector('.slider-bottom-spacer');
    if (spacer) {
        updateSliderSpacerPosition(slider, spacer);

        // Update on resize and slide change
        window.addEventListener('resize', debounce(function() {
            updateSliderSpacerPosition(slider, spacer);
        }, 150));

        imageSwiper.on('slideChange', function() {
            setTimeout(() => updateSliderSpacerPosition(slider, spacer), 300);
        });
    }

    // Create diagnostic function for this slider
    window[`debug_${sliderId}`] = function() {
        window.debugImageTextSlider = true;
        console.log('Debugging enabled for slider:', sliderId);
        return 'Use window.debugImageTextSlider = false to disable debugging';
    };
}

/**
 * Pre-initialize animations to prevent flash of unstyled content
 */
function preInitializeAnimations(slider) {
    if (!window.gsap) return;

    // Hide all content elements initially
    const contentSlides = slider.querySelectorAll('.swiper-content-slider .swiper-slide');
    contentSlides.forEach(slide => {
        // Set initial visibility
        gsap.set(slide, { autoAlpha: 0 });

        const elements = [
            slide.querySelector('.slide-title'),
            slide.querySelector('.slide-description'),
            slide.querySelector('.slide-buttons'),
            slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb'),
            slide.querySelector('.slider-navigation'),
            slide.querySelector('.slide-back-link'),
            slide.querySelector('.slide-publication-date')
        ].filter(Boolean);

        // Set initial state for elements
        gsap.set(elements, { opacity: 0, y: 20 });

        // Breadcrumbs need special handling
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        const backLink = slide.querySelector('.slide-back-link');

        if (breadcrumbAbove) gsap.set(breadcrumbAbove, { opacity: 0, y: -15 });
        if (breadcrumbBelow) gsap.set(breadcrumbBelow, { opacity: 0, y: 15 });
        if (backLink) gsap.set(backLink, { opacity: 0, x: -15 });
    });

    // Make first slide content visible for active state
    const activeSlide = slider.querySelector('.swiper-content-slider .swiper-slide-active');
    if (activeSlide) {
        gsap.set(activeSlide, { autoAlpha: 1 });
    }
}

/**
 * Update the spacer position for a specific slider
 */
function updateSliderSpacerPosition(slider, spacer) {
    if (!slider || !spacer) return;

    const hasExtendedOverlays = slider.classList.contains('has-extended-overlays');

    spacer.style.position = 'relative';
    spacer.style.zIndex = '1';
    spacer.style.marginTop = hasExtendedOverlays ? '0' : '-1px';

    // Calculate extension for overlays
    setTimeout(() => {
        const extendingOverlays = slider.querySelectorAll('.absolute-overlay-image.extend-beyond');
        let maxExtension = 0;

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

        if (maxExtension > 0) {
            slider.style.paddingBottom = maxExtension + 'px';
        }
    }, 200);
}

/**
 * Initialize GSAP animations for a slider
 */
function initSliderAnimations(slider, imageSwiper, contentSwiper, options) {
    if (!window.gsap) return;

    // Prepare animation parameters
    const duration = options.animationDuration || 0.7;
    const useLoop = imageSwiper.params.loop;
    const animatedSlides = new Set();

    // Create a flag to track if we're currently animating
    let isAnimating = false;

    // Animate initial slide with a slight delay
    setTimeout(() => {
        const initialSlide = slider.querySelector('.swiper-content-slider .swiper-slide-active');
        if (initialSlide) {
            // Ensure slide is visible before animating
            gsap.set(initialSlide, { autoAlpha: 1 });
            setTimeout(() => {
                animateSlideContent(initialSlide, duration);

                // Add slide to animated set
                const slideId = initialSlide.className.split(' ')
                    .find(cls => cls.startsWith('elementor-repeater-item-content-'));
                if (slideId) animatedSlides.add(slideId);
            }, 100);
        }
    }, 300);

    // Setup animation events
    imageSwiper.on('slideChangeTransitionStart', function() {
        if (isAnimating) return;
        isAnimating = true;

        // Get target slide index
        const targetIndex = useLoop ? this.realIndex : this.activeIndex;

        // Reset all content slides
        const contentSlides = slider.querySelectorAll('.swiper-content-slider .swiper-slide');
        contentSlides.forEach(slide => resetSlideContent(slide));

        // Find and prepare target slide
        if (contentSwiper && contentSwiper.slides) {
            const targetSlide = Array.from(contentSwiper.slides).find((slide, index) => {
                if (useLoop) {
                    return (index % (contentSwiper.slides.length / 3)) === targetIndex;
                } else {
                    return index === targetIndex;
                }
            });

            if (targetSlide) {
                gsap.set(targetSlide, { autoAlpha: 1 });
            }
        }
    });

    imageSwiper.on('slideChangeTransitionEnd', function() {
        const activeSlide = slider.querySelector('.swiper-content-slider .swiper-slide-active');
        if (!activeSlide) {
            isAnimating = false;
            return;
        }

        const slideId = activeSlide.className.split(' ')
            .find(cls => cls.startsWith('elementor-repeater-item-content-'));

        // Small delay to ensure slide transition is complete
        setTimeout(() => {
            if (slideId && !animatedSlides.has(slideId)) {
                animateSlideContent(activeSlide, duration);
                animatedSlides.add(slideId);
            } else {
                animateSlideContent(activeSlide, duration);
            }

            // Reset animation flag after animation completes
            setTimeout(() => {
                isAnimating = false;
            }, duration * 1000 + 100);
        }, 50);
    });

    // Animation helper functions
    function animateSlideContent(slide, duration) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        const navigation = slide.querySelector('.slider-navigation');
        const backLink = slide.querySelector('.slide-back-link');
        const publicationDate = slide.querySelector('.slide-publication-date');

        // Kill any existing animations
        const elements = [title, description, buttons, breadcrumbAbove, breadcrumbBelow, navigation, backLink, publicationDate].filter(Boolean);
        gsap.killTweensOf(elements);

        const timeline = gsap.timeline({
            defaults: {
                duration: duration,
                ease: "power2.out",
                clearProps: "transform,opacity"
            }
        });

        // Create animation sequence
        if (breadcrumbAbove) {
            timeline.fromTo(breadcrumbAbove, { opacity: 0, y: -15 }, { opacity: 1, y: 0, duration: duration * 0.6 });
        }

        if (backLink) {
            timeline.fromTo(backLink, { opacity: 0, x: -15 }, { opacity: 1, x: 0 },
                breadcrumbAbove ? "-=0.2" : 0
            );
        }

        if (title) {
            timeline.fromTo(title, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                breadcrumbAbove || backLink ? "-=0.2" : 0
            );
        }

        if (description) {
            timeline.fromTo(description, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.3"
            );
        }

        if (publicationDate) {
            timeline.fromTo(publicationDate, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.3"
            );
        }

        if (buttons) {
            timeline.fromTo(buttons, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.3"
            );
        }

        if (navigation) {
            timeline.fromTo(navigation, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.3"
            );
        }

        if (breadcrumbBelow) {
            timeline.fromTo(breadcrumbBelow, { opacity: 0, y: 15 }, { opacity: 1, y: 0, duration: duration * 0.6 },
                "-=0.3"
            );
        }
    }

    function resetSlideContent(slide) {
        if (!window.gsap) return;

        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const navigation = slide.querySelector('.slider-navigation');
        const backLink = slide.querySelector('.slide-back-link');
        const publicationDate = slide.querySelector('.slide-publication-date');

        // Kill any animations
        const elements = [breadcrumbAbove, breadcrumbBelow, title, description, buttons, navigation, backLink, publicationDate].filter(Boolean);
        gsap.killTweensOf(elements);

        // Reset slide visibility
        gsap.set(slide, { autoAlpha: 0 });

        // Reset positions
        if (breadcrumbAbove) gsap.set(breadcrumbAbove, { opacity: 0, y: -15 });
        if (breadcrumbBelow) gsap.set(breadcrumbBelow, { opacity: 0, y: 15 });
        if (title) gsap.set(title, { opacity: 0, y: 20 });
        if (description) gsap.set(description, { opacity: 0, y: 20 });
        if (buttons) gsap.set(buttons, { opacity: 0, y: 20 });
        if (navigation) gsap.set(navigation, { opacity: 0, y: 20 });
        if (backLink) gsap.set(backLink, { opacity: 0, x: -15 });
        if (publicationDate) gsap.set(publicationDate, { opacity: 0, y: 20 });
    }
}

/**
 * Simple debounce function
 */
function debounce(func, wait) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

// Set up global flag for debugging
window.debugImageTextSlider = false;