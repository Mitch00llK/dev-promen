/**
 * Optimized Image Text Slider JavaScript
 * Performance improvements for mobile devices
 */
(function() {
    "use strict";

    // Performance optimization: Use RAF for smooth animations
    const requestAnimFrame = window.requestAnimationFrame ||
        window.webkitRequestAnimationFrame ||
        window.mozRequestAnimationFrame ||
        function(callback) { setTimeout(callback, 16); };

    // Debounce utility with immediate execution option
    function debounce(func, wait, immediate = false) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                timeout = null;
                if (!immediate) func.apply(this, args);
            };
            const callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(this, args);
        };
    }

    // Throttle utility for high-frequency events
    function throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    }

    // Global state management
    const SliderManager = {
        instances: new Map(),
        isInitializing: false,

        register(id, instance) {
            this.instances.set(id, instance);
        },

        get(id) {
            return this.instances.get(id);
        },

        destroy(id) {
            const instance = this.instances.get(id);
            if (instance) {
                instance.cleanup();
                this.instances.delete(id);
            }
        }
    };

    document.addEventListener('DOMContentLoaded', function() {
        const isElementorEditor = document.body.classList.contains('elementor-editor-active');

        if (!isElementorEditor) {
            initImageTextSliders();
        } else {
            setupEditorView();
        }

        // Optimized event handlers with debouncing
        const debouncedResize = debounce(handleSliderResize, 250);
        const throttledScroll = throttle(handleSliderScroll, 100);

        window.addEventListener('resize', debouncedResize);
        window.addEventListener('scroll', throttledScroll, { passive: true });

        // Elementor integration
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/image_text_slider.default', function($scope) {
                const slider = $scope.find('.image-text-slider-container')[0];
                if (slider && !isElementorEditor) {
                    initImageTextSlider(slider);
                }
            });
        }
    });

    /**
     * Initialize all sliders with performance optimizations
     */
    function initImageTextSliders() {
        const sliders = document.querySelectorAll('.image-text-slider-container');

        // Use intersection observer to lazy load sliders
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        initImageTextSlider(entry.target);
                        observer.unobserve(entry.target);
                    }
                });
            }, { rootMargin: '50px' });

            sliders.forEach(slider => observer.observe(slider));
        } else {
            // Fallback for older browsers
            sliders.forEach(slider => initImageTextSlider(slider));
        }
    }

    /**
     * Optimized slider initialization
     */
    function initImageTextSlider(sliderEl) {
        if (!sliderEl || SliderManager.get(sliderEl.id)) return;

        const sliderId = sliderEl.id;

        // Parse options once
        let options = {};
        try {
            options = JSON.parse(sliderEl.getAttribute('data-options')) || {};
        } catch (e) {
            console.error('Error parsing slider options:', e);
        }

        const slideCount = sliderEl.querySelectorAll('.swiper .swiper-slide').length;
        if (slideCount === 0) return;

        const useLoop = slideCount > 1 && (options.infinite !== false);
        const transitionSpeed = options.speed || 500;

        // Optimized Swiper configuration
        const imageConfig = {
            slidesPerView: 1,
            effect: options.effect || 'fade',
            speed: transitionSpeed,
            loop: useLoop,
            loopedSlides: useLoop ? slideCount : null,
            autoplay: options.autoplay ? {
                delay: options.autoplaySpeed || 5000,
                disableOnInteraction: false,
                pauseOnMouseEnter: options.pauseOnHover || false
            } : false,
            pagination: sliderEl.querySelector('.swiper-pagination') ? {
                el: sliderEl.querySelector('.swiper-pagination'),
                clickable: true,
                type: options.paginationType || 'bullets'
            } : false,
            navigation: {
                nextEl: sliderEl.querySelector('.swiper-button-next'),
                prevEl: sliderEl.querySelector('.swiper-button-prev'),
            },
            // Performance optimizations
            watchSlidesProgress: false,
            watchOverflow: true,
            preventInteractionOnTransition: true,
            observer: false, // Disable for better performance
            observeParents: false,
            on: {
                init: function() {
                    SliderManager.register(sliderId, new SliderInstance(sliderEl, this, null, options));
                }
            }
        };

        // Content slider with minimal configuration
        const contentConfig = {
            slidesPerView: 1,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 0, // Instant transitions
            loop: useLoop,
            loopedSlides: useLoop ? slideCount : null,
            allowTouchMove: false,
            watchSlidesProgress: false,
            observer: false,
            observeParents: false,
            preventInteractionOnTransition: true
        };

        try {
            const imageSwiper = new Swiper(sliderEl.querySelector('.swiper'), imageConfig);
            const contentSwiper = new Swiper(sliderEl.querySelector('.swiper-content-slider'), contentConfig);

            // Simple synchronization without heavy DOM manipulation
            imageSwiper.on('slideChange', function() {
                const targetIndex = useLoop ? this.realIndex : this.activeIndex;

                requestAnimFrame(() => {
                    if (useLoop) {
                        contentSwiper.slideToLoop(targetIndex, 0, false);
                    } else {
                        contentSwiper.slideTo(targetIndex, 0, false);
                    }
                });
            });

            // Store instances
            sliderEl.imageSwiper = imageSwiper;
            sliderEl.contentSwiper = contentSwiper;

        } catch (error) {
            console.error('Error initializing slider:', error);
        }
    }

    /**
     * Simplified slider instance management
     */
    class SliderInstance {
        constructor(element, imageSwiper, contentSwiper, options) {
            this.element = element;
            this.imageSwiper = imageSwiper;
            this.contentSwiper = contentSwiper;
            this.options = options;
            this.isAnimating = false;

            this.initAnimations();
        }

        initAnimations() {
            if (!this.options.enableGsapAnimations || !window.gsap) return;

            const duration = this.options.animationDuration || 0.7;

            // Simplified GSAP animations
            this.imageSwiper.on('slideChangeTransitionEnd', () => {
                if (this.isAnimating) return;
                this.isAnimating = true;

                const activeSlide = this.element.querySelector('.swiper-content-slider .swiper-slide-active');
                if (activeSlide) {
                    this.animateSlideContent(activeSlide, duration);
                }

                setTimeout(() => {
                    this.isAnimating = false;
                }, duration * 1000);
            });
        }

        animateSlideContent(slide, duration) {
            const elements = [
                slide.querySelector('.slide-title'),
                slide.querySelector('.slide-description'),
                slide.querySelector('.slide-buttons')
            ].filter(Boolean);

            if (elements.length === 0) return;

            gsap.fromTo(elements, { opacity: 0, y: 20 }, {
                opacity: 1,
                y: 0,
                duration: duration,
                stagger: 0.1,
                ease: "power2.out"
            });
        }

        cleanup() {
            if (this.imageSwiper) {
                this.imageSwiper.destroy(true, true);
            }
            if (this.contentSwiper) {
                this.contentSwiper.destroy(true, true);
            }
        }
    }

    /**
     * Optimized resize handler
     */
    function handleSliderResize() {
        SliderManager.instances.forEach((instance) => {
            if (instance.imageSwiper) {
                instance.imageSwiper.update();
            }
            if (instance.contentSwiper) {
                instance.contentSwiper.update();
            }
        });
    }

    /**
     * Optimized scroll handler
     */
    function handleSliderScroll() {
        // Minimal scroll handling
        // Only update if absolutely necessary
    }

    /**
     * Editor view setup
     */
    function setupEditorView() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(slider => {
            const firstSlide = slider.querySelector('.swiper-slide:first-child');
            const firstContent = slider.querySelector('.swiper-content-slider .swiper-slide:first-child');

            if (firstSlide) {
                firstSlide.style.zIndex = '2';
                firstSlide.style.opacity = '1';
                firstSlide.classList.add('swiper-slide-active');
            }

            if (firstContent) {
                firstContent.style.zIndex = '2';
                firstContent.style.opacity = '1';
                firstContent.classList.add('swiper-slide-active');
            }
        });
    }

    // Expose necessary functions
    window.initImageTextSliders = initImageTextSliders;
    window.setupEditorView = setupEditorView;

})();