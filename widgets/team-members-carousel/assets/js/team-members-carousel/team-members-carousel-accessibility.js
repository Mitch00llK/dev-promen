/**
 * Team Members Carousel Widget Accessibility
 * 
 * Handles keyboard navigation, screen reader announcements, and focus management
 * for the Team Members Carousel widget to ensure WCAG 2.2 compliance.
 * 
 * @package Promen
 */

class TeamMembersCarouselAccessibility {
    constructor() {
        this.init();
    }

    init() {
        this.setupKeyboardNavigation();
        this.setupScreenReaderSupport();
        this.setupCarouselAccessibility();
        this.setupFocusManagement();
    }

    /**
     * Setup keyboard navigation for team member items
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            const memberItems = document.querySelectorAll('.team-members-carousel-container .member-card[tabindex="0"]');

            if (memberItems.length === 0) return;

            const currentIndex = Array.from(memberItems).indexOf(document.activeElement);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextItem(memberItems, currentIndex);
                    break;

                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousItem(memberItems, currentIndex);
                    break;

                case 'Home':
                    e.preventDefault();
                    this.focusFirstItem(memberItems);
                    break;

                case 'End':
                    e.preventDefault();
                    this.focusLastItem(memberItems);
                    break;

                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.announceMemberDetails(e.target);
                    break;
            }
        });
    }

    /**
     * Focus next team member item
     */
    focusNextItem(items, currentIndex) {
        const nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
        items[nextIndex].focus();
        this.announceMemberDetails(items[nextIndex]);
    }

    /**
     * Focus previous team member item
     */
    focusPreviousItem(items, currentIndex) {
        const prevIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
        items[prevIndex].focus();
        this.announceMemberDetails(items[prevIndex]);
    }

    /**
     * Focus first team member item
     */
    focusFirstItem(items) {
        if (items.length > 0) {
            items[0].focus();
            this.announceMemberDetails(items[0]);
        }
    }

    /**
     * Focus last team member item
     */
    focusLastItem(items) {
        if (items.length > 0) {
            items[items.length - 1].focus();
            this.announceMemberDetails(items[items.length - 1]);
        }
    }

    /**
     * Announce team member details to screen readers
     */
    announceMemberDetails(element) {
        const memberName = element.querySelector('.member-name');
        const memberTitle = element.querySelector('.member-title');

        if (memberName) {
            const name = memberName.textContent.trim();
            const title = memberTitle ? memberTitle.textContent.trim() : '';
            const announcement = title ? `${name}, ${title}` : name;
            this.announceToScreenReader(`Team member: ${announcement}`);
        }
    }

    /**
     * Setup screen reader support
     */
    setupScreenReaderSupport() {
        // Create live region for announcements
        if (!document.getElementById('team-members-live-region')) {
            const liveRegion = document.createElement('div');
            liveRegion.id = 'team-members-live-region';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'screen-reader-text';
            document.body.appendChild(liveRegion);
        }

        // Announce when team members are loaded
        const teamContainer = document.querySelector('.team-members-carousel-container');
        if (teamContainer) {
            const memberItems = teamContainer.querySelectorAll('.member-card');
            if (memberItems.length > 0) {
                this.announceToScreenReader(
                    `Team members carousel loaded. ${memberItems.length} team member${memberItems.length > 1 ? 's' : ''} available. Use arrow keys to navigate.`
                );
            }
        }
    }

    /**
     * Setup carousel accessibility
     */
    setupCarouselAccessibility() {
        const carousel = document.querySelector('.team-members-carousel');
        if (!carousel) return;

        // Update ARIA attributes when slide changes
        const swiper = carousel.swiper;
        if (swiper) {
            swiper.on('slideChange', () => {
                this.updateCarouselAccessibility(swiper);
            });
        }

        // Setup navigation button accessibility
        const prevButton = carousel.querySelector('.carousel-arrow-prev');
        const nextButton = carousel.querySelector('.carousel-arrow-next');

        if (prevButton) {
            prevButton.addEventListener('click', () => {
                this.announceToScreenReader('Previous team members');
            });
        }

        if (nextButton) {
            nextButton.addEventListener('click', () => {
                this.announceToScreenReader('Next team members');
            });
        }
    }

    /**
     * Update carousel accessibility attributes
     */
    updateCarouselAccessibility(swiper) {
        const slides = swiper.slides;
        const activeIndex = swiper.activeIndex;

        slides.forEach((slide, index) => {
            const isActive = index === activeIndex;
            slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
            slide.setAttribute('aria-current', isActive ? 'true' : 'false');
        });

        // Announce current slide
        const activeSlide = slides[activeIndex];
        if (activeSlide) {
            const memberName = activeSlide.querySelector('.member-name');
            if (memberName) {
                this.announceToScreenReader(`Now viewing: ${memberName.textContent.trim()}`);
            }
        }
    }

    /**
     * Setup focus management
     */
    setupFocusManagement() {
        // Add focus indicators
        const style = document.createElement('style');
        style.textContent = `
            .member-card:focus {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .member-card:focus-visible {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .carousel-arrow:focus {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .carousel-arrow:focus-visible {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .member-linkedin:focus {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .member-linkedin:focus-visible {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Announce message to screen readers
     */
    announceToScreenReader(message) {
        const liveRegion = document.getElementById('team-members-live-region');
        if (liveRegion) {
            liveRegion.textContent = message;

            // Clear after announcement
            setTimeout(() => {
                liveRegion.textContent = '';
            }, 1000);
        }
    }

    /**
     * Handle reduced motion preferences
     */
    handleReducedMotion() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            // Disable animations for users who prefer reduced motion
            const animatedElements = document.querySelectorAll('.team-members-carousel-container');
            animatedElements.forEach(element => {
                element.style.animation = 'none';
                element.style.transition = 'none';
            });
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new TeamMembersCarouselAccessibility();
});

// Handle reduced motion preferences
if (window.matchMedia) {
    const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    reducedMotionQuery.addListener(() => {
        new TeamMembersCarouselAccessibility().handleReducedMotion();
    });
}