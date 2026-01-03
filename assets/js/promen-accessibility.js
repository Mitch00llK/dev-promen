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
            this.lastFocusedElement = null; // Track last focus
            this.animationControllers = []; // Track animators for global pause
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
         * Get localized string with optional placeholder replacement
         * @param {string} key String key from promenA11yStrings
         * @param {...string} args Values to replace {0}, {1}, etc.
         * @returns {string} Localized string or fallback
         */
        getString(key, ...args) {
            const strings = window.promenA11yStrings || {};
            let str = strings[key] || key;

            // Replace placeholders {0}, {1}, etc.
            args.forEach((arg, index) => {
                str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
            });

            return str;
        }

        /**
         * Save currently focused element
         */
        saveFocus() {
            this.lastFocusedElement = document.activeElement;
        }

        /**
         * Restore focus to saved element
         */
        restoreFocus() {
            if (this.lastFocusedElement) {
                this.lastFocusedElement.focus();
                this.lastFocusedElement = null;
            }
        }

        /**
         * Register an animation controller to be stopped globally
         * @param {Object} controller Object with a stop() or pause() method
         */
        registerAnimation(controller) {
            if (controller && (typeof controller.stop === 'function' || typeof controller.pause === 'function')) {
                this.animationControllers.push(controller);
            }
        }

        /**
         * Pause all registered animations
         */
        pauseAllAnimations() {
            this.animationControllers.forEach(ctrl => {
                if (typeof ctrl.stop === 'function') ctrl.stop();
                else if (typeof ctrl.pause === 'function') ctrl.pause();
            });
            this.announce('All animations paused');
        }

        /**
         * Standardized Tabs Setup
         * Expects container with [role="tablist"], [role="tab"], [role="tabpanel"]
         */
        setupTabs(container) {
            const tabs = container.querySelectorAll('[role="tab"]');
            const panels = container.querySelectorAll('[role="tabpanel"]');

            if (!tabs.length) return;

            // Helper to switch tabs
            const activateTab = (tab) => {
                // Deactivate all
                tabs.forEach(t => {
                    t.setAttribute('aria-selected', 'false');
                    t.setAttribute('tabindex', '-1');
                });
                panels.forEach(p => {
                    p.hidden = true;
                    // Support removing custom hidden classes if needed, but standard prop is best
                    p.style.display = 'none';
                });

                // Activate target
                tab.setAttribute('aria-selected', 'true');
                tab.setAttribute('tabindex', '0');
                const controls = tab.getAttribute('aria-controls');
                const targetPanel = document.getElementById(controls);
                if (targetPanel) {
                    targetPanel.hidden = false;
                    targetPanel.style.display = 'block';
                }
                tab.focus();

                const label = tab.textContent || tab.getAttribute('aria-label');
                this.announce(`Tab ${label} selected`);
            };

            tabs.forEach((tab, index) => {
                tab.addEventListener('click', () => activateTab(tab));

                tab.addEventListener('keydown', (e) => {
                    let targetIndex = index;
                    if (e.key === 'ArrowRight') targetIndex = (index + 1) % tabs.length;
                    if (e.key === 'ArrowLeft') targetIndex = (index - 1 + tabs.length) % tabs.length;
                    if (e.key === 'Home') targetIndex = 0;
                    if (e.key === 'End') targetIndex = tabs.length - 1;

                    if (targetIndex !== index) {
                        e.preventDefault();
                        activateTab(tabs[targetIndex]);
                    }
                });
            });
        }

        /**
         * Standardized Accordion Setup
         * Expects triggers with [aria-expanded] and targets with [hidden]
         */
        setupAccordion(triggers) {
            triggers.forEach(trigger => {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
                    const controls = trigger.getAttribute('aria-controls');
                    const content = document.getElementById(controls);

                    if (!content) return;

                    // Toggle
                    trigger.setAttribute('aria-expanded', !isExpanded);
                    content.hidden = isExpanded; // If it was expanded, now hidden (true)

                    // Optional: Close others? (Accordion vs Details)
                    // For now, allow independent toggle (Details pattern)
                });
            });
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

        /**
         * Check if reduced motion is preferred
         * @returns {boolean}
         */
        isReducedMotion() {
            return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        }

        /**
         * Setup reduced motion handling for a specific element/component
         * @param {HTMLElement} element The container element
         * @param {Object} options Options for handling reduced motion
         * @param {Function} options.onMotionReduced Callback when motion should be reduced
         * @param {Function} options.onMotionRestored Callback when motion can be restored
         */
        setupReducedMotion(element, options = {}) {
            if (!element) return;

            const mediaQuery = window.matchMedia('(prefers-reduced-motion: reduce)');

            const handleMotion = (matches) => {
                if (matches) {
                    element.classList.add('promen-disable-motion');
                    if (typeof options.onMotionReduced === 'function') options.onMotionReduced();
                } else {
                    element.classList.remove('promen-disable-motion');
                    if (typeof options.onMotionRestored === 'function') options.onMotionRestored();
                }
            };

            // Initial check
            handleMotion(mediaQuery.matches);

            // Listen for changes
            mediaQuery.addEventListener('change', (e) => handleMotion(e.matches));
        }

        /**
         * Create or reuse a skip link
         * @param {HTMLElement} contextElement The element to skip to
         * @param {string} label Label for the link
         */
        setupSkipLink(contextElement, label = 'Skip to content') {
            if (!contextElement) return;

            const existingLink = contextElement.querySelector('.promen-skip-link');
            if (existingLink) return;

            const targetId = contextElement.id || `skip-target-${Math.random().toString(36).substr(2, 9)}`;
            if (!contextElement.id) contextElement.id = targetId;

            const link = document.createElement('a');
            link.href = `#${targetId}`;
            link.className = 'promen-skip-link sr-only focus:not-sr-only'; // Tailored classes or custom
            link.style.cssText = 'position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;';
            link.textContent = label;

            link.addEventListener('focus', () => {
                link.style.cssText = 'position: absolute; z-index: 9999; background: white; color: black; padding: 10px; top: 10px; left: 10px; width: auto; height: auto; overflow: visible;';
            });

            link.addEventListener('blur', () => {
                link.style.cssText = 'position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;';
            });

            link.addEventListener('click', (e) => {
                e.preventDefault();
                contextElement.focus();
                contextElement.scrollIntoView({ behavior: 'smooth' });
                this.announce(`Navigated to ${label}`);
            });

            contextElement.prepend(link);
        }

        /**
         * Validate a form field and show/announce error
         * @param {HTMLElement} field Input element to validate
         * @returns {boolean} isValid
         */
        validateField(field) {
            const value = field.value.trim();
            const isRequired = field.hasAttribute('required');
            const fieldType = field.type;
            let isValid = true;
            let errorMessage = '';

            // Required check
            if (isRequired && !value) {
                isValid = false;
                errorMessage = field.getAttribute('data-error-required') || 'This field is required.';
            }

            // Email check
            if (isValid && fieldType === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = field.getAttribute('data-error-email') || 'Please enter a valid email address.';
                }
            }

            // Update UI
            if (isValid) {
                this.clearFieldError(field);
            } else {
                this.showFieldError(field, errorMessage);
            }

            return isValid;
        }

        /**
         * Show error message for a field
         */
        showFieldError(field, message) {
            field.setAttribute('aria-invalid', 'true');
            const errorId = field.id + '-error';
            field.setAttribute('aria-describedby', errorId);

            let errorElement = document.getElementById(errorId);
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.id = errorId;
                errorElement.className = 'promen-field-error error-message'; // Standard class
                errorElement.style.color = '#dc3232'; // Default WP error red
                errorElement.style.fontSize = '0.9em';
                errorElement.style.marginTop = '5px';
                errorElement.setAttribute('role', 'alert');
                field.parentNode.appendChild(errorElement);
            }

            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        /**
         * Clear error message for a field
         */
        clearFieldError(field) {
            field.removeAttribute('aria-invalid');
            const errorId = field.id + '-error';
            const describedBy = (field.getAttribute('aria-describedby') || '').replace(errorId, '').trim();
            if (describedBy) field.setAttribute('aria-describedby', describedBy);
            else field.removeAttribute('aria-describedby');

            const errorElement = document.getElementById(errorId);
            if (errorElement) {
                errorElement.style.display = 'none';
                errorElement.textContent = '';
            }
        }

        /**
         * Ensure focused element is visible (not obscured by sticky headers)
         */
        ensureFocusVisible(element) {
            if (!element) return;

            const rect = element.getBoundingClientRect();
            const stickyHeaderHeight = 120; // Approximate height of sticky headers + buffer

            if (rect.top < stickyHeaderHeight) {
                window.scrollBy({
                    top: rect.top - stickyHeaderHeight,
                    behavior: 'smooth'
                });
            }
        }
    }

    // Initialize Global Instance
    new PromenAccessibilityClass();

})(window, document, jQuery);
