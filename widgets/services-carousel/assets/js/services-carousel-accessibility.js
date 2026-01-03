/**
 * Services Carousel Accessibility Enhancements
 * WCAG 2.2 AA Compliance
 */

class ServicesCarouselAccessibility {
    constructor(carouselElement) {
        this.carousel = carouselElement;
        this.swiper = null;
        this.announcementsElement = null;
        this.currentSlideIndex = 0;
        this.totalSlides = 0;
        this.isInitialized = false;

        this.init();
    }

    init() {
        if (!this.carousel) return;

        // Wait for Swiper to be initialized
        this.waitForSwiper();

        // Set up announcements element
        this.setupAnnouncements();

        // Add keyboard navigation
        this.addKeyboardNavigation();

        // Add focus management
        this.addFocusManagement();

        // Add screen reader support
        this.addScreenReaderSupport();

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
            this.updateSlideAnnouncements();
            this.updateNavigationStates();
        });

        // Announce when carousel starts/stops autoplay
        this.swiper.on('autoplayStart', () => {
            this.announce('Carousel autoplay started');
        });

        this.swiper.on('autoplayStop', () => {
            this.announce('Carousel autoplay stopped');
        });
    }

    setupAnnouncements() {
        const carouselId = this.carousel.id;
        this.announcementsElement = document.getElementById(carouselId + '-announcements');

        if (!this.announcementsElement) {
            // Create announcements element if it doesn't exist
            this.announcementsElement = document.createElement('div');
            this.announcementsElement.className = 'sr-only';
            this.announcementsElement.setAttribute('aria-live', 'polite');
            this.announcementsElement.setAttribute('aria-atomic', 'true');
            this.announcementsElement.id = carouselId + '-announcements';
            this.carousel.parentNode.appendChild(this.announcementsElement);
        }
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

        // Make carousel focusable
        this.carousel.setAttribute('tabindex', '0');
    }

    handleNavigationKeydown(event, direction) {
        switch (event.key) {
            case 'Enter':
            case ' ':
                event.preventDefault();
                this.navigateSlide(direction);
                break;
            case 'ArrowLeft':
                if (direction === 'prev') {
                    event.preventDefault();
                    this.navigateSlide('prev');
                }
                break;
            case 'ArrowRight':
                if (direction === 'next') {
                    event.preventDefault();
                    this.navigateSlide('next');
                }
                break;
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
                    this.announce('Autoplay stopped');
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

        // Add focus indicators
        this.addFocusIndicators();
    }

    manageFocusAfterSlideChange() {
        // Focus the active slide for screen readers
        const activeSlide = this.carousel.querySelector('.swiper-slide-active');
        if (activeSlide) {
            const link = activeSlide.querySelector('a');
            if (link) {
                // Temporarily focus the link, then return focus to carousel
                link.focus();
                setTimeout(() => {
                    this.carousel.focus();
                }, 100);
            }
        }
    }

    addFocusIndicators() {
        // Add focus styles via JavaScript to ensure they're always present
        const style = document.createElement('style');
        style.textContent = `
            .promen-services-carousel:focus {
                outline: 2px solid #005fcc;
                outline-offset: 2px;
            }
            
            .carousel-arrow:focus {
                outline: 2px solid #005fcc;
                outline-offset: 2px;
            }
            
            .service-card:focus {
                outline: 2px solid #005fcc;
                outline-offset: 2px;
            }
            
            .service-card:focus-within {
                outline: 2px solid #005fcc;
                outline-offset: 2px;
            }
            
            /* High contrast mode support */
            @media (prefers-contrast: high) {
                .promen-services-carousel:focus,
                .carousel-arrow:focus,
                .service-card:focus,
                .service-card:focus-within {
                    outline: 3px solid;
                    outline-offset: 3px;
                }
            }
            
            /* Reduced motion support */
            @media (prefers-reduced-motion: reduce) {
                .promen-services-carousel * {
                    animation-duration: 0.01ms !important;
                    animation-iteration-count: 1 !important;
                    transition-duration: 0.01ms !important;
                }
            }
        `;
        document.head.appendChild(style);
    }

    addScreenReaderSupport() {
        // Add screen reader specific attributes
        this.updateSlideAnnouncements();
        this.updateNavigationStates();
    }

    updateSlideAnnouncements() {
        if (!this.announcementsElement || !this.swiper) return;

        const currentSlide = this.swiper.slides[this.currentSlideIndex];
        const titleEl = currentSlide ? currentSlide.querySelector('.service-title') : null;
        const slideTitle = titleEl ? titleEl.textContent : '';

        const announcement = `Slide ${this.currentSlideIndex + 1} of ${this.totalSlides}${slideTitle ? `: ${slideTitle}` : ''}`;
        this.announce(announcement);
    }

    updateNavigationStates() {
        if (!this.swiper) return;

        const prevButton = this.carousel.parentNode.querySelector('.carousel-arrow-prev');
        const nextButton = this.carousel.parentNode.querySelector('.carousel-arrow-next');

        // Update button states
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

    announce(message) {
        if (!this.announcementsElement) return;

        // Clear previous announcement
        this.announcementsElement.textContent = '';

        // Add new announcement
        setTimeout(() => {
            this.announcementsElement.textContent = message;
        }, 100);
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

    getCurrentSlide() {
        return this.currentSlideIndex;
    }

    getTotalSlides() {
        return this.totalSlides;
    }
}

// Make the class globally available
window.ServicesCarouselAccessibility = ServicesCarouselAccessibility;