/**
 * Locations Display Widget Accessibility
 * 
 * Handles keyboard navigation, screen reader announcements, and focus management
 * for the Locations Display widget to ensure WCAG 2.2 compliance.
 * 
 * @package Promen
 */

class LocationsDisplayAccessibility {
    constructor() {
        this.init();
    }

    init() {
        this.setupKeyboardNavigation();
        this.setupScreenReaderSupport();
        this.setupFocusManagement();
        this.setupSkipLinks();
    }

    /**
     * Setup skip links
     */
    setupSkipLinks() {
        if (typeof PromenAccessibility !== 'undefined') {
            const containers = document.querySelectorAll('.locations-container');
            containers.forEach(container => {
                PromenAccessibility.setupSkipLink(container, 'Sla over locaties');
            });
        }
    }

    /**
     * Setup keyboard navigation for location items
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            const locationItems = document.querySelectorAll('.locations-container .location-item[tabindex="0"]');

            if (locationItems.length === 0) return;

            const currentIndex = Array.from(locationItems).indexOf(document.activeElement);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextItem(locationItems, currentIndex);
                    break;

                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousItem(locationItems, currentIndex);
                    break;

                case 'Home':
                    e.preventDefault();
                    this.focusFirstItem(locationItems);
                    break;

                case 'End':
                    e.preventDefault();
                    this.focusLastItem(locationItems);
                    break;

                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.announceLocationDetails(e.target);
                    break;
            }
        });
    }

    /**
     * Focus next location item
     */
    focusNextItem(items, currentIndex) {
        const nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
        items[nextIndex].focus();
        this.announceLocationDetails(items[nextIndex]);
    }

    /**
     * Focus previous location item
     */
    focusPreviousItem(items, currentIndex) {
        const prevIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
        items[prevIndex].focus();
        this.announceLocationDetails(items[prevIndex]);
    }

    /**
     * Focus first location item
     */
    focusFirstItem(items) {
        if (items.length > 0) {
            items[0].focus();
            this.announceLocationDetails(items[0]);
        }
    }

    /**
     * Focus last location item
     */
    focusLastItem(items) {
        if (items.length > 0) {
            items[items.length - 1].focus();
            this.announceLocationDetails(items[items.length - 1]);
        }
    }

    /**
     * Announce location details to screen readers
     */
    announceLocationDetails(element) {
        const locationName = element.querySelector('.location-name');
        const locationAddress = element.querySelector('.location-address');

        if (locationName && locationAddress) {
            const name = locationName.textContent.trim();
            const address = locationAddress.textContent.trim();

            this.announceToScreenReader(`${name}. ${address}`);
        }
    }

    /**
     * Setup screen reader support
     */
    setupScreenReaderSupport() {
        // Live region handled by PromenAccessibility

        // Announce when locations are loaded
        const locationsContainer = document.querySelector('.locations-container');
        if (locationsContainer) {
            const locationItems = locationsContainer.querySelectorAll('.location-item');
            if (locationItems.length > 0) {
                this.announceToScreenReader(
                    `Locations loaded. ${locationItems.length} location${locationItems.length > 1 ? 's' : ''} available. Use arrow keys to navigate.`
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
            .location-item:focus {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .location-item:focus-visible {
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
            const animatedElements = document.querySelectorAll('.locations-animated');
            animatedElements.forEach(element => {
                element.style.animation = 'none';
                element.style.transition = 'none';
            });
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new LocationsDisplayAccessibility();
});

// Handle reduced motion preferences
if (window.matchMedia) {
    const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    reducedMotionQuery.addListener(() => {
        new LocationsDisplayAccessibility().handleReducedMotion();
    });
}