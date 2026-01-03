/**
 * Contact Info Card Widget - Accessibility Enhancements
 * WCAG 2.2 AA Compliant Keyboard Navigation and Screen Reader Support
 * 
 * Uses global PromenAccessibility core library.
 */

(function () {
    'use strict';

    // Initialize accessibility features when DOM is ready
    document.addEventListener('DOMContentLoaded', function () {
        initContactInfoCardAccessibility();
    });

    function initContactInfoCardAccessibility() {
        initSkipLinks();
        initKeyboardNavigation();
        initFocusManagement();
        initFormAccessibility();
    }

    /**
     * Initialize skip links functionality
     */
    /**
     * Initialize skip links functionality
     */
    function initSkipLinks() {
        const contactCards = document.querySelectorAll('.contact-info-card');
        contactCards.forEach(function (card) {
            const title = card.querySelector('.contact-info-card__title')?.textContent || 'Contact Card';
            PromenAccessibility.setupSkipLink(card, `Skip to ${title}`);
        });
    }

    /**
     * Initialize keyboard navigation enhancements
     */
    function initKeyboardNavigation() {
        // Handle arrow key navigation for custom components
        const contactCards = document.querySelectorAll('.contact-info-card');
        contactCards.forEach(function (card) {
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
        card.addEventListener('keydown', function (e) {
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
        // Trap focus within custom forms using Core Library
        const importantSections = document.querySelectorAll('.contact-info-card__custom-form');
        importantSections.forEach(function (section) {
            PromenAccessibility.initFocusTrap(section);
        });
    }

    /**
     * Initialize form accessibility enhancements
     */
    function initFormAccessibility() {
        const forms = document.querySelectorAll('.contact-info-card__custom-form form');

        forms.forEach(function (form) {
            // Add real-time validation feedback
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(function (input) {
                input.addEventListener('blur', function () {
                    validateField(this);
                });

                input.addEventListener('input', function () {
                    // Clear error state on input
                    if (this.getAttribute('aria-invalid') === 'true') {
                        clearFieldError(this);
                    }
                });
            });

            // Handle form submission with accessibility
            form.addEventListener('submit', function (e) {
                if (!validateForm(this)) {
                    e.preventDefault();
                    PromenAccessibility.announce('Please correct the errors in the form', 'assertive');
                } else {
                    PromenAccessibility.announce('Form submitted successfully');
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

        fields.forEach(function (field) {
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
        PromenAccessibility.announce('Error: ' + message);
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

})();