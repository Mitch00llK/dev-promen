/**
 * Text Column Repeater Widget Accessibility
 * 
 * Handles keyboard navigation, screen reader announcements, and focus management
 * for the Text Column Repeater widget to ensure WCAG 2.2 compliance.
 * 
 * @package Promen
 */

class TextColumnRepeaterAccessibility {
    constructor() {
        this.init();
    }

    init() {
        this.setupKeyboardNavigation();
        this.setupScreenReaderSupport();
        this.setupFocusManagement();
    }

    /**
     * Setup keyboard navigation for text column items
     */
    setupKeyboardNavigation() {
        document.addEventListener('keydown', (e) => {
            const columnItems = document.querySelectorAll('.text-column-repeater .text-column-repeater__item[tabindex="0"]');

            if (columnItems.length === 0) return;

            const currentIndex = Array.from(columnItems).indexOf(document.activeElement);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextItem(columnItems, currentIndex);
                    break;

                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousItem(columnItems, currentIndex);
                    break;

                case 'Home':
                    e.preventDefault();
                    this.focusFirstItem(columnItems);
                    break;

                case 'End':
                    e.preventDefault();
                    this.focusLastItem(columnItems);
                    break;

                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.announceItemDetails(e.target);
                    break;
            }
        });
    }

    /**
     * Focus next text column item
     */
    focusNextItem(items, currentIndex) {
        const nextIndex = currentIndex < items.length - 1 ? currentIndex + 1 : 0;
        items[nextIndex].focus();
        this.announceItemDetails(items[nextIndex]);
    }

    /**
     * Focus previous text column item
     */
    focusPreviousItem(items, currentIndex) {
        const prevIndex = currentIndex > 0 ? currentIndex - 1 : items.length - 1;
        items[prevIndex].focus();
        this.announceItemDetails(items[prevIndex]);
    }

    /**
     * Focus first text column item
     */
    focusFirstItem(items) {
        if (items.length > 0) {
            items[0].focus();
            this.announceItemDetails(items[0]);
        }
    }

    /**
     * Focus last text column item
     */
    focusLastItem(items) {
        if (items.length > 0) {
            items[items.length - 1].focus();
            this.announceItemDetails(items[items.length - 1]);
        }
    }

    /**
     * Announce item details to screen readers
     */
    announceItemDetails(element) {
        const itemTitle = element.querySelector('.text-column-repeater__item-title');
        const itemDescription = element.querySelector('.text-column-repeater__item-description p');

        if (itemTitle) {
            const title = itemTitle.textContent.trim();
            const description = itemDescription ? itemDescription.textContent.trim() : '';

            let announcement = `Text column: ${title}`;
            if (description) {
                announcement += `. ${description}`;
            }

            this.announceToScreenReader(announcement);
        }
    }

    /**
     * Setup screen reader support
     */
    setupScreenReaderSupport() {
        // Live region handled by PromenAccessibility
    }

    /**
     * Setup focus management
     */
    setupFocusManagement() {
        // Add focus indicators
        const style = document.createElement('style');
        style.textContent = `
            .text-column-repeater__item:focus {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .text-column-repeater__item:focus-visible {
                outline: 2px solid #007cba;
                outline-offset: 2px;
            }
            
            .text-column-repeater__item:focus .text-column-repeater__item-title {
                outline: none;
            }
            
            .text-column-repeater__item:focus .text-column-repeater__item-description {
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
            const animatedElements = document.querySelectorAll('.text-column-repeater');
            animatedElements.forEach(element => {
                element.style.animation = 'none';
                element.style.transition = 'none';
            });
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new TextColumnRepeaterAccessibility();
});

// Handle reduced motion preferences
if (window.matchMedia) {
    const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
    reducedMotionQuery.addListener(() => {
        new TextColumnRepeaterAccessibility().handleReducedMotion();
    });
}