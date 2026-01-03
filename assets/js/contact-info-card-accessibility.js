/**
 * Contact Info Card Widget - Accessibility Enhancements
 * WCAG 2.2 AA Compliant Keyboard Navigation and Screen Reader Support
 */

(function() {
    'use strict';

    // Initialize accessibility features when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        initContactInfoCardAccessibility();
    });

    function initContactInfoCardAccessibility() {
        // Initialize skip links
        initSkipLinks();

        // Initialize keyboard navigation
        initKeyboardNavigation();

        // Initialize focus management
        initFocusManagement();

        // Initialize ARIA live regions
        initAriaLiveRegions();

        // Initialize form accessibility
        initFormAccessibility();
    }

    /**
     * Initialize skip links functionality
     */
    function initSkipLinks() {
        const skipLinks = document.querySelectorAll('.skip-link');

        skipLinks.forEach(function(skipLink) {
            skipLink.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    // Focus the target element
                    targetElement.focus();

                    // Scroll to the element if needed
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // Announce to screen readers
                    announceToScreenReader('Navigated to ' + this.textContent);
                }
            });
        });
    }

    /**
     * Initialize keyboard navigation enhancements
     */
    function initKeyboardNavigation() {
        // Handle escape key for closing any open modals or dropdowns
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                // Close any open custom elements
                const openElements = document.querySelectorAll('[aria-expanded="true"]');
                openElements.forEach(function(element) {
                    element.setAttribute('aria-expanded', 'false');
                    element.focus();
                });
            }
        });

        // Handle arrow key navigation for custom components
        const contactCards = document.querySelectorAll('.contact-info-card');
        contactCards.forEach(function(card) {
            initCardKeyboardNavigation(card);
        });
    }

    /**
     * Initialize keyboard navigation for individual contact cards
     */
    function initCardKeyboardNavigation(card) {
        const focusableElements = card.querySelectorAll(
            'a[href], button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
        );

        if (focusableElements.length === 0) return;

        // Handle arrow key navigation within the card
        card.addEventListener('keydown', function(e) {
            const currentIndex = Array.from(focusableElements).indexOf(document.activeElement);

            if (e.key === 'ArrowDown' || e.key === 'ArrowRight') {
                e.preventDefault();
                const nextIndex = (currentIndex + 1) % focusableElements.length;
                focusableElements[nextIndex].focus();
            } else if (e.key === 'ArrowUp' || e.key === 'ArrowLeft') {
                e.preventDefault();
                const prevIndex = currentIndex === 0 ? focusableElements.length - 1 : currentIndex - 1;
                focusableElements[prevIndex].focus();
            }
        });
    }

    /**
     * Initialize focus management
     */
    function initFocusManagement() {
        // Trap focus within modals or important sections
        const importantSections = document.querySelectorAll('.contact-info-card__custom-form');

        importantSections.forEach(function(section) {
            initFocusTrap(section);
        });

        // Handle focus indicators for better visibility
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });

        document.addEventListener('mousedown', function() {
            document.body.classList.remove('keyboard-navigation');
        });
    }

    /**
     * Initialize focus trap for important sections
     */
    function initFocusTrap(container) {
        const focusableElements = container.querySelectorAll(
            'a[href], button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
        );

        if (focusableElements.length === 0) return;

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        container.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    // Shift + Tab
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    // Tab
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        });
    }

    /**
     * Initialize ARIA live regions for dynamic content
     */
    function initAriaLiveRegions() {
        // Create a live region for announcements if it doesn't exist
        let liveRegion = document.getElementById('contact-info-live-region');
        if (!liveRegion) {
            liveRegion = document.createElement('div');
            liveRegion.id = 'contact-info-live-region';
            liveRegion.setAttribute('aria-live', 'polite');
            liveRegion.setAttribute('aria-atomic', 'true');
            liveRegion.className = 'sr-only';
            document.body.appendChild(liveRegion);
        }

        // Monitor form submissions and other dynamic changes
        const forms = document.querySelectorAll('.contact-info-card__custom-form form');
        forms.forEach(function(form) {
            form.addEventListener('submit', function() {
                announceToScreenReader('Form submitted successfully');
            });
        });
    }

    /**
     * Initialize form accessibility enhancements
     */
    function initFormAccessibility() {
        const forms = document.querySelectorAll('.contact-info-card__custom-form form');

        forms.forEach(function(form) {
            // Add real-time validation feedback
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(function(input) {
                input.addEventListener('blur', function() {
                    validateField(this);
                });

                input.addEventListener('input', function() {
                    // Clear error state on input
                    if (this.getAttribute('aria-invalid') === 'true') {
                        clearFieldError(this);
                    }
                });
            });

            // Handle form submission with accessibility
            form.addEventListener('submit', function(e) {
                if (!validateForm(this)) {
                    e.preventDefault();
                    announceToScreenReader('Please correct the errors in the form');
                }
            });
        });
    }

    /**
     * Validate individual form field
     */
    function validateField(field) {
        const value = field.value.trim();
        const isRequired = field.hasAttribute('required');
        const fieldType = field.type;
        let isValid = true;
        let errorMessage = '';

        // Required field validation
        if (isRequired && !value) {
            isValid = false;
            errorMessage = 'This field is required.';
        }

        // Email validation
        if (fieldType === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address.';
            }
        }

        // Phone validation
        if (fieldType === 'tel' && value) {
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            if (!phoneRegex.test(value.replace(/[\s\-\(\)]/g, ''))) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number.';
            }
        }

        // File validation
        if (fieldType === 'file' && field.files.length > 0) {
            const file = field.files[0];
            const allowedTypes = ['.pdf', '.doc', '.docx'];
            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

            if (!allowedTypes.includes(fileExtension)) {
                isValid = false;
                errorMessage = 'Please select a PDF, DOC, or DOCX file.';
            }
        }

        // Update field state
        if (isValid) {
            clearFieldError(field);
        } else {
            showFieldError(field, errorMessage);
        }

        return isValid;
    }

    /**
     * Validate entire form
     */
    function validateForm(form) {
        const fields = form.querySelectorAll('input[required], textarea[required], select[required]');
        let isFormValid = true;

        fields.forEach(function(field) {
            if (!validateField(field)) {
                isFormValid = false;
            }
        });

        return isFormValid;
    }

    /**
     * Show field error
     */
    function showFieldError(field, message) {
        field.setAttribute('aria-invalid', 'true');
        field.setAttribute('aria-describedby', field.id + '-error');

        let errorElement = document.getElementById(field.id + '-error');
        if (!errorElement) {
            errorElement = document.createElement('div');
            errorElement.id = field.id + '-error';
            errorElement.className = 'error-message';
            errorElement.setAttribute('role', 'alert');
            errorElement.setAttribute('aria-live', 'polite');
            field.parentNode.appendChild(errorElement);
        }

        errorElement.textContent = message;
        errorElement.style.display = 'block';

        // Announce error to screen readers
        announceToScreenReader('Error: ' + message);
    }

    /**
     * Clear field error
     */
    function clearFieldError(field) {
        field.removeAttribute('aria-invalid');
        field.removeAttribute('aria-describedby');

        const errorElement = document.getElementById(field.id + '-error');
        if (errorElement) {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }
    }

    /**
     * Announce message to screen readers
     */
    function announceToScreenReader(message) {
        const liveRegion = document.getElementById('contact-info-live-region');
        if (liveRegion) {
            liveRegion.textContent = message;

            // Clear the message after a short delay
            setTimeout(function() {
                liveRegion.textContent = '';
            }, 1000);
        }
    }

    /**
     * Handle reduced motion preferences
     */
    function handleReducedMotion() {
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

        function updateMotionPreference() {
            if (prefersReducedMotion.matches) {
                document.documentElement.style.setProperty('--animation-duration', '0.01ms');
                document.documentElement.style.setProperty('--animation-iteration-count', '1');
            } else {
                document.documentElement.style.removeProperty('--animation-duration');
                document.documentElement.style.removeProperty('--animation-iteration-count');
            }
        }

        updateMotionPreference();
        prefersReducedMotion.addEventListener('change', updateMotionPreference);
    }

    // Initialize reduced motion handling
    handleReducedMotion();

    // Handle high contrast mode
    function handleHighContrast() {
        const prefersHighContrast = window.matchMedia('(prefers-contrast: high)');

        function updateContrastPreference() {
            if (prefersHighContrast.matches) {
                document.documentElement.classList.add('high-contrast');
            } else {
                document.documentElement.classList.remove('high-contrast');
            }
        }

        updateContrastPreference();
        prefersHighContrast.addEventListener('change', updateContrastPreference);
    }

    // Initialize high contrast handling
    handleHighContrast();

})();