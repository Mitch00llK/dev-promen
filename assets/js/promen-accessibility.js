/**
 * Promen Accessibility Core Library
 * Centralizes WCAG 2.2 compliance logic for all widgets.
 * 
 * Features:
 * - Focus Management (Trapping, Restoration)
 * - ARIA Live Announcements
 * - Keyboard Navigation Helpers
 * - reduced-motion & high-contrast detection
 */

(function (window, document, $) {
    'use strict';

    class PromenAccessibilityClass {
        constructor() {
            this.liveRegion = null;
            this.init();
        }

        init() {
            this.setupLiveRegion();
            this.handleReducedMotion();
            this.handleHighContrast();

            // Expose globally
            window.PromenAccessibility = this;
        }

        /**
         * Setup a hidden ARIA live region for voiceover announcements
         */
        setupLiveRegion() {
            let region = document.getElementById('promen-global-live-region');
            if (!region) {
                region = document.createElement('div');
                region.id = 'promen-global-live-region';
                region.className = 'sr-only';
                region.setAttribute('aria-live', 'polite');
                region.setAttribute('aria-atomic', 'true');
                document.body.appendChild(region);
            }
            this.liveRegion = region;
        }

        /**
         * Announce message to screen readers
         * @param {string} message Text to announce
         * @param {string} priority 'polite' or 'assertive' (default: polite)
         */
        announce(message, priority = 'polite') {
            if (!this.liveRegion) return;

            this.liveRegion.setAttribute('aria-live', priority);
            this.liveRegion.textContent = ''; // Clear first to ensure repeat messages are read

            setTimeout(() => {
                this.liveRegion.textContent = message;
            }, 50);
        }

        /**
         * Initialize a focus trap within a container
         * @param {HTMLElement} containerElement The element to trap focus within
         * @param {boolean} active Whether the trap is currently active
         */
        initFocusTrap(containerElement) {
            if (!containerElement) return;

            const focusableElementsSelector = 'a[href], button, input, textarea, select, details, [tabindex]:not([tabindex="-1"])';

            containerElement.addEventListener('keydown', (e) => {
                const isTabPressed = e.key === 'Tab' || e.keyCode === 9;
                if (!isTabPressed) return;

                const focusableContent = containerElement.querySelectorAll(focusableElementsSelector);
                if (focusableContent.length === 0) return;

                const firstFocusableElement = focusableContent[0];
                const lastFocusableElement = focusableContent[focusableContent.length - 1];

                if (e.shiftKey) { // Shift + Tab
                    if (document.activeElement === firstFocusableElement) {
                        lastFocusableElement.focus();
                        e.preventDefault();
                    }
                } else { // Tab
                    if (document.activeElement === lastFocusableElement) {
                        firstFocusableElement.focus();
                        e.preventDefault();
                    }
                }
            });
        }

        /**
         * Helper to add keyboard support to a clickable element (Enter/Space)
         * @param {HTMLElement} element 
         * @param {Function} callback 
         */
        addKeyboardClick(element, callback) {
            if (!element) return;
            element.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    callback(e);
                }
            });
        }

        /**
         * Setup common Swiper accessibility logic
         * @param {Object} swiperInstance Swiper instance
         * @param {HTMLElement} containerElement Widget container
         */
        setupSwiperAccessibility(swiperInstance, containerElement) {
            if (!swiperInstance) return;

            // Announce slide changes
            swiperInstance.on('slideChange', () => {
                const index = swiperInstance.activeIndex + 1;
                const total = swiperInstance.slides.length;
                this.announce(`Showing slide ${index} of ${total}`);
            });

            // Focus management after slide change if needed
            // (Optional: focus the active slide's first link or container)
        }

        handleReducedMotion() {
            const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
            const updateMotion = () => {
                if (mediaQuery.matches) {
                    document.documentElement.style.setProperty('--promen-transition-duration', '0.01ms');
                } else {
                    document.documentElement.style.removeProperty('--promen-transition-duration');
                }
            };
            updateMotion();
            mediaQuery.addEventListener('change', updateMotion);
        }

        handleHighContrast() {
            const mediaQuery = window.matchMedia('(prefers-contrast: high)');
            const updateContrast = () => {
                if (mediaQuery.matches) {
                    document.body.classList.add('promen-high-contrast');
                } else {
                    document.body.classList.remove('promen-high-contrast');
                }
            };
            updateContrast();
            mediaQuery.addEventListener('change', updateContrast);
        }
    }

    // Initialize Global Instance
    new PromenAccessibilityClass();

})(window, document, jQuery);
