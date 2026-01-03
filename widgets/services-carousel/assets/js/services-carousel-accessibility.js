/**
 * Services Carousel Accessibility Enhancements
 * WCAG 2.2 AA Compliance
 * 
 * Uses global PromenAccessibility core library.
 */

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

        // Wait for Swiper to be initialized
        this.waitForSwiper();

        // Add keyboard navigation
        this.addKeyboardNavigation();

        // Add focus management
        this.addFocusManagement();

        this.isInitialized = true;
    }

    waitForSwiper() {
        const checkSwiper = () => {
            if (this.carousel.swiper) {
                this.swiper = this.carousel.swiper;
                this.totalSlides = this.swiper.slides.length;
                this.setupSwiperEvents();
            } else {
                setTimeout(checkSwiper, 100);
            }
        };
        checkSwiper();
    }

    setupSwiperEvents() {
        if (!this.swiper) return;

        // Update current slide index on slide change
        this.swiper.on('slideChange', () => {
            this.currentSlideIndex = this.swiper.activeIndex;
            this.makeAnnouncement();
            this.updateNavigationStates();
        });

        // Announce when carousel starts/stops autoplay
        this.swiper.on('autoplayStart', () => {
            PromenAccessibility.announce('Carousel autoplay started');
        });

        this.swiper.on('autoplayStop', () => {
            PromenAccessibility.announce('Carousel autoplay stopped');
        });
    }

    addKeyboardNavigation() {
        // Add keyboard support to navigation buttons
        const prevButton = this.carousel.parentNode.querySelector('.carousel-arrow-prev');
        const nextButton = this.carousel.parentNode.querySelector('.carousel-arrow-next');

        if (prevButton) {
            prevButton.addEventListener('keydown', (e) => this.handleNavigationKeydown(e, 'prev'));
        }

        if (nextButton) {
            nextButton.addEventListener('keydown', (e) => this.handleNavigationKeydown(e, 'next'));
        }

        // Add keyboard support to carousel container
        this.carousel.addEventListener('keydown', (e) => this.handleCarouselKeydown(e));

        // Make carousel focusable if not already
        if (!this.carousel.hasAttribute('tabindex')) {
            this.carousel.setAttribute('tabindex', '0');
        }
    }

    handleNavigationKeydown(event, direction) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            this.navigateSlide(direction);
        } else if ((event.key === 'ArrowLeft' && direction === 'prev') ||
            (event.key === 'ArrowRight' && direction === 'next')) {
            event.preventDefault();
            this.navigateSlide(direction);
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
                // Stop autoplay if running
                if (this.swiper && this.swiper.autoplay && this.swiper.autoplay.running) {
                    this.swiper.autoplay.stop();
                    PromenAccessibility.announce('Autoplay stopped');
                }
                break;
        }
    }

    navigateSlide(direction) {
        if (!this.swiper) return;

        if (direction === 'prev') {
            this.swiper.slidePrev();
        } else if (direction === 'next') {
            this.swiper.slideNext();
        }
    }

    goToSlide(index) {
        if (!this.swiper || index < 0 || index >= this.totalSlides) return;
        this.swiper.slideTo(index);
    }

    addFocusManagement() {
        // Manage focus when slides change
        if (this.swiper) {
            this.swiper.on('slideChangeTransitionEnd', () => {
                this.manageFocusAfterSlideChange();
            });
        }
    }

    manageFocusAfterSlideChange() {
        // Focus the active slide for screen readers
        const activeSlide = this.carousel.querySelector('.swiper-slide-active');
        if (activeSlide) {
            const link = activeSlide.querySelector('a');
            if (link) {
                // Temporarily focus the link, then return focus to carousel
                // This ensures VO reads the new slide content
                link.focus();
                setTimeout(() => {
                    this.carousel.focus();
                }, 100);
            }
        }
    }

    makeAnnouncement() {
        if (!this.swiper) return;

        const currentSlide = this.swiper.slides[this.currentSlideIndex];
        const titleEl = currentSlide ? currentSlide.querySelector('.service-title') : null;
        const slideTitle = titleEl ? titleEl.textContent : '';

        const announcement = `Slide ${this.currentSlideIndex + 1} of ${this.totalSlides}${slideTitle ? `: ${slideTitle}` : ''}`;

        // Use Global Core Library
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

    // Public methods for external control
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

// Make the class globally available
window.ServicesCarouselAccessibility = ServicesCarouselAccessibility;