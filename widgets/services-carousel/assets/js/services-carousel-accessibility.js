/**
 * Services Carousel Accessibility Enhancements
 * WCAG 2.2 AA Compliance
 * 
 * Uses global PromenAccessibility core library.
 */

/**
 * Get localized string helper
 */
function getString(key, ...args) {
    if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.getString) {
        return PromenAccessibility.getString(key, ...args);
    }
    const fallbacks = {
        servicesCarouselLabel: 'Services Carousel',
        slideOf: 'Slide {0} of {1}',
        previousService: 'Previous service',
        nextService: 'Next service',
        slideshowPlaying: 'Carousel autoplay started',
        slideshowPaused: 'Carousel autoplay stopped',
        autoplayStopped: 'Autoplay stopped'
    };
    let str = fallbacks[key] || key;
    args.forEach((arg, index) => {
        str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
    });
    return str;
}

class ServicesCarouselAccessibility {
    constructor(carouselElement) {
        this.carousel = carouselElement;
        this.swiper = null;
        this.currentSlideIndex = 0;
        this.totalSlides = 0;
        this.isInitialized = false;

        this.init();
    }

    init() {
        if (!this.carousel) return;

        // Use Core Library for reduced motion check
        const prefersReducedMotion = PromenAccessibility.isReducedMotion();

        // Wait for Swiper to be initialized
        this.waitForSwiper(prefersReducedMotion);

        // Add keyboard navigation
        this.addKeyboardNavigation();

        // Add focus management
        this.addFocusManagement();

        this.isInitialized = true;
    }

    waitForSwiper(prefersReducedMotion) {
        const checkSwiper = () => {
            if (this.carousel.swiper) {
                this.swiper = this.carousel.swiper;
                this.totalSlides = this.swiper.slides.length;

                if (prefersReducedMotion && this.swiper.autoplay && this.swiper.autoplay.running) {
                    this.swiper.autoplay.stop();
                }

                this.setupSwiperEvents();
                this.registerWithGlobalPause();
            } else {
                setTimeout(checkSwiper, 100);
            }
        };
        checkSwiper();
    }

    setupSwiperEvents() {
        if (!this.swiper) return;

        // Use Core Library helper for swiper announcements if applicable, 
        // or keep custom if it's more specific.
        this.swiper.on('slideChange', () => {
            this.currentSlideIndex = this.swiper.activeIndex;
            this.makeAnnouncement();
            this.updateNavigationStates();
        });

        // Announce when carousel starts/stops autoplay
        this.swiper.on('autoplayStart', () => {
            PromenAccessibility.announce(getString('slideshowPlaying'));
        });

        this.swiper.on('autoplayStop', () => {
            PromenAccessibility.announce(getString('slideshowPaused'));
        });
    }

    /**
     * Register with Core Library for Global Pause control
     */
    registerWithGlobalPause() {
        if (!this.swiper || !this.swiper.autoplay) return;

        PromenAccessibility.registerAnimation({
            stop: () => {
                if (this.swiper.autoplay.running) {
                    this.swiper.autoplay.stop();
                    PromenAccessibility.announce(getString('slideshowPaused'));
                }
            },
            pause: () => {
                if (this.swiper.autoplay.running) {
                    this.swiper.autoplay.stop();
                }
            }
        });
    }

    addKeyboardNavigation() {
        const prevButton = this.carousel.parentNode.querySelector('.carousel-arrow-prev');
        const nextButton = this.carousel.parentNode.querySelector('.carousel-arrow-next');

        if (prevButton) {
            PromenAccessibility.addKeyboardClick(prevButton, () => this.navigateSlide('prev'));
        }

        if (nextButton) {
            PromenAccessibility.addKeyboardClick(nextButton, () => this.navigateSlide('next'));
        }

        this.carousel.addEventListener('keydown', (e) => this.handleCarouselKeydown(e));

        if (!this.carousel.hasAttribute('tabindex')) {
            this.carousel.setAttribute('tabindex', '0');
        }
    }

    handleCarouselKeydown(event) {
        switch (event.key) {
            case 'ArrowLeft':
                event.preventDefault();
                this.navigateSlide('prev');
                break;
            case 'ArrowRight':
                event.preventDefault();
                this.navigateSlide('next');
                break;
            case 'Home':
                event.preventDefault();
                this.goToSlide(0);
                break;
            case 'End':
                event.preventDefault();
                this.goToSlide(this.totalSlides - 1);
                break;
            case 'Escape':
                if (this.swiper && this.swiper.autoplay && this.swiper.autoplay.running) {
                    this.swiper.autoplay.stop();
                    PromenAccessibility.announce(getString('autoplayStopped'));
                }
                break;
        }
    }

    navigateSlide(direction) {
        if (!this.swiper) return;
        if (direction === 'prev') this.swiper.slidePrev();
        else if (direction === 'next') this.swiper.slideNext();

        // Announce immediately on manual navigation for better feedback
        setTimeout(() => this.makeAnnouncement(), 50);
    }

    goToSlide(index) {
        if (!this.swiper || index < 0 || index >= this.totalSlides) return;
        this.swiper.slideTo(index);
    }

    addFocusManagement() {
        if (this.swiper) {
            this.swiper.on('slideChangeTransitionEnd', () => {
                this.manageFocusAfterSlideChange();
            });
        }
    }

    manageFocusAfterSlideChange() {
        // Only focus if the carousel itself or a child was already focused
        if (this.carousel.contains(document.activeElement)) {
            const activeSlide = this.carousel.querySelector('.swiper-slide-active');
            if (activeSlide) {
                const link = activeSlide.querySelector('a');
                if (link) link.focus();
            }
        }
    }

    makeAnnouncement() {
        if (!this.swiper) return;

        const currentSlide = this.swiper.slides[this.currentSlideIndex];
        const titleEl = currentSlide ? currentSlide.querySelector('.service-title') : null;
        const slideTitle = titleEl ? titleEl.textContent : '';

        const announcement = getString('slideOf', this.currentSlideIndex + 1, this.totalSlides) + (slideTitle ? `: ${slideTitle}` : '');
        PromenAccessibility.announce(announcement);
    }

    updateNavigationStates() {
        if (!this.swiper) return;

        const prevButton = this.carousel.parentNode.querySelector('.carousel-arrow-prev');
        const nextButton = this.carousel.parentNode.querySelector('.carousel-arrow-next');

        if (prevButton) {
            const isDisabled = this.swiper.isBeginning && !this.swiper.params.loop;
            prevButton.setAttribute('aria-disabled', isDisabled);
            prevButton.disabled = isDisabled;
        }

        if (nextButton) {
            const isDisabled = this.swiper.isEnd && !this.swiper.params.loop;
            nextButton.setAttribute('aria-disabled', isDisabled);
            nextButton.disabled = isDisabled;
        }
    }

    destroy() {
        if (this.swiper) {
            this.swiper.off('slideChange');
            this.swiper.off('autoplayStart');
            this.swiper.off('autoplayStop');
            this.swiper.off('slideChangeTransitionEnd');
        }
        this.isInitialized = false;
    }
}

window.ServicesCarouselAccessibility = ServicesCarouselAccessibility;

// Self-initialize for any carousels on the page
document.addEventListener('DOMContentLoaded', () => {
    const carousels = document.querySelectorAll('.promen-services-carousel');
    carousels.forEach(el => {
        if (!el.dataset.accessibilityInitialized) {
            new ServicesCarouselAccessibility(el);
            el.dataset.accessibilityInitialized = 'true';
        }
    });
});