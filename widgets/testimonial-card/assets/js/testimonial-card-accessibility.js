/**
 * Testimonial Card Widget Accessibility
 * 
 * Handles keyboard navigation, screen reader announcements, and focus management
 * for the Testimonial Card widget to ensure WCAG 2.2 compliance.
 * 
 * @package Promen
 */

class TestimonialCardAccessibility {
    constructor() {
        this.init();
    }

    init() {
        this.setupKeyboardNavigation();
        this.setupScreenReaderSupport();
        this.setupFocusManagement();
    }

    /**
     * Setup keyboard navigation for testimonial cards
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            const testimonialCards = document.querySelectorAll('.testimonial-card[tabindex="0"]');

            if (testimonialCards.length === 0) return;

            const currentIndex = Array.from(testimonialCards).indexOf(document.activeElement);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextCard(testimonialCards, currentIndex);
                    break;

                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousCard(testimonialCards, currentIndex);
                    break;

                case 'Home':
                    e.preventDefault();
                    this.focusFirstCard(testimonialCards);
                    break;

                case 'End':
                    e.preventDefault();
                    this.focusLastCard(testimonialCards);
                    break;

                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.announceTestimonialDetails(e.target);
                    break;
            }
        });
    }

    /**
     * Focus next testimonial card
     */
    focusNextCard(cards, currentIndex) {
        const nextIndex = currentIndex < cards.length - 1 ? currentIndex + 1 : 0;
        cards[nextIndex].focus();
        this.announceTestimonialDetails(cards[nextIndex]);
    }

    /**
     * Focus previous testimonial card
     */
    focusPreviousCard(cards, currentIndex) {
        const prevIndex = currentIndex > 0 ? currentIndex - 1 : cards.length - 1;
        cards[prevIndex].focus();
        this.announceTestimonialDetails(cards[prevIndex]);
    }

    /**
     * Focus first testimonial card
     */
    focusFirstCard(cards) {
        if (cards.length > 0) {
            cards[0].focus();
            this.announceTestimonialDetails(cards[0]);
        }
    }

    /**
     * Focus last testimonial card
     */
    focusLastCard(cards) {
        if (cards.length > 0) {
            cards[cards.length - 1].focus();
            this.announceTestimonialDetails(cards[cards.length - 1]);
        }
    }

    /**
     * Announce testimonial details to screen readers
     */
    announceTestimonialDetails(element) {
        const testimonialName = element.querySelector('.testimonial-name');
        const testimonialContent = element.querySelector('.testimonial-content');
        const testimonialJob = element.querySelector('.testimonial-job');
        const testimonialCompany = element.querySelector('.testimonial-company');

        if (testimonialName && testimonialContent) {
            const name = testimonialName.textContent.trim();
            const content = testimonialContent.textContent.trim();
            const job = testimonialJob ? testimonialJob.textContent.trim() : '';
            const company = testimonialCompany ? testimonialCompany.textContent.trim() : '';

            let announcement = `Testimonial by ${name}`;
            if (job) announcement += `, ${job}`;
            if (company) announcement += ` at ${company}`;
            announcement += `. ${content}`;

            this.announceToScreenReader(announcement);
        }
    }

    /**
     * Setup screen reader support
     */
    setupScreenReaderSupport() {
        // Live region handled by PromenAccessibility

        // Announce when testimonials are loaded
        const testimonialCards = document.querySelectorAll('.testimonial-card');
        if (testimonialCards.length > 0) {
            this.announceToScreenReader(
                `Testimonials loaded. ${testimonialCards.length} testimonial${testimonialCards.length > 1 ? 's' : ''} available. Use arrow keys to navigate.`
            );
        }
    }

    /**
     * Setup focus management
     */
    setupFocusManagement() {
        // Add focus indicators
        const style = document.createElement('style');
        style.textContent = `
            .testimonial-card:focus {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .testimonial-card:focus-visible {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .testimonial-card:focus .testimonial-content {
                outline: none;
            }
            
            .testimonial-card:focus .testimonial-name {
                outline: none;
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Announce message to screen readers
     */
    announceToScreenReader(message) {
        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.announce(message);
        }
    }

    /**
     * Handle reduced motion preferences
     */
    handleReducedMotion() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            // Disable animations for users who prefer reduced motion
            const animatedElements = document.querySelectorAll('.testimonial-card');
            animatedElements.forEach(element => {
                element.style.animation = 'none';
                element.style.transition = 'none';
            });
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new TestimonialCardAccessibility();
});

// Handle reduced motion preferences
if (window.matchMedia) {
    const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    reducedMotionQuery.addListener(() => {
        new TestimonialCardAccessibility().handleReducedMotion();
    });
}