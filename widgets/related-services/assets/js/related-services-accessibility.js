/**
 * Related Services Widget Accessibility
 * 
 * Handles keyboard navigation, screen reader announcements, and focus management
 * for the Related Services widget to ensure WCAG 2.2 compliance.
 * 
 * @package Promen
 */

class RelatedServicesAccessibility {
    constructor() {
        this.init();
    }

    init() {
        this.setupKeyboardNavigation();
        this.setupScreenReaderSupport();
        this.setupFocusManagement();
        this.setupHoverEffects();
    }

    /**
     * Setup keyboard navigation for service items
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            const serviceItems = document.querySelectorAll('.related-services-container .related-service-card[tabindex="0"]');

            if (serviceItems.length === 0) return;

            const currentIndex = Array.from(serviceItems).indexOf(document.activeElement);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextItem(serviceItems, currentIndex);
                    break;

                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousItem(serviceItems, currentIndex);
                    break;

                case 'Home':
                    e.preventDefault();
                    this.focusFirstItem(serviceItems);
                    break;

                case 'End':
                    e.preventDefault();
                    this.focusLastItem(serviceItems);
                    break;

                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.activateService(e.target);
                    break;
            }
        });
    }

    /**
     * Focus next service item
     */
    focusNextItem(items, currentIndex) {
        const nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
        items[nextIndex].focus();
        this.announceServiceDetails(items[nextIndex]);
    }

    /**
     * Focus previous service item
     */
    focusPreviousItem(items, currentIndex) {
        const prevIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
        items[prevIndex].focus();
        this.announceServiceDetails(items[prevIndex]);
    }

    /**
     * Focus first service item
     */
    focusFirstItem(items) {
        if (items.length > 0) {
            items[0].focus();
            this.announceServiceDetails(items[0]);
        }
    }

    /**
     * Focus last service item
     */
    focusLastItem(items) {
        if (items.length > 0) {
            items[items.length - 1].focus();
            this.announceServiceDetails(items[items.length - 1]);
        }
    }

    /**
     * Activate service (click the link)
     */
    activateService(element) {
        const link = element.querySelector('.related-service-link');
        if (link) {
            link.click();
        }
    }

    /**
     * Announce service details to screen readers
     */
    announceServiceDetails(element) {
        const serviceTitle = element.querySelector('.related-service-title');

        if (serviceTitle) {
            const title = serviceTitle.textContent.trim();
            this.announceToScreenReader(`Service: ${title}`);
        }
    }

    /**
     * Setup screen reader support
     */
    setupScreenReaderSupport() {
        // Create live region for announcements
        if (!document.getElementById('related-services-live-region')) {
            const liveRegion = document.createElement('div');
            liveRegion.id = 'related-services-live-region';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'screen-reader-text';
            document.body.appendChild(liveRegion);
        }

        // Announce when services are loaded
        const servicesContainer = document.querySelector('.related-services-container');
        if (servicesContainer) {
            const serviceItems = servicesContainer.querySelectorAll('.related-service-card');
            if (serviceItems.length > 0) {
                this.announceToScreenReader(
                    `Related services loaded. ${serviceItems.length} service${serviceItems.length > 1 ? 's' : ''} available. Use arrow keys to navigate.`
                );
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
            .related-service-card:focus {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .related-service-card:focus-visible {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .related-service-link:focus {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .related-service-link:focus-visible {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
        `;
        document.head.appendChild(style);
    }

    /**
     * Setup hover effects with reduced motion support
     */
    setupHoverEffects() {
        // Check for reduced motion preference
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            // Disable hover animations for users who prefer reduced motion
            const animatedElements = document.querySelectorAll('.related-service-card');
            animatedElements.forEach(element => {
                element.classList.remove('hover-translateY', 'hover-scale');
            });
        }
    }

    /**
     * Announce message to screen readers
     */
    announceToScreenReader(message) {
        const liveRegion = document.getElementById('related-services-live-region');
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
            const animatedElements = document.querySelectorAll('.related-service-card');
            animatedElements.forEach(element => {
                element.classList.remove('hover-translateY', 'hover-scale');
                element.style.transition = 'none';
                element.style.transform = 'none';
            });
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new RelatedServicesAccessibility();
});

// Handle reduced motion preferences
if (window.matchMedia) {
    const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    reducedMotionQuery.addListener(() => {
        new RelatedServicesAccessibility().handleReducedMotion();
    });
}