/**
 * Contact Info Card Widget - Accessibility Enhancements
 * WCAG 2.2 AA Compliant Keyboard Navigation and Screen Reader Support
 * 
 * Uses global PromenAccessibility core library.
 */

(function () {
    'use strict';

    /**
     * Get localized string helper
     */
    function getString(key, ...args) {
        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.getString) {
            return PromenAccessibility.getString(key, ...args);
        }
        const fallbacks = {
            skipToContent: 'Skip to {0}',
            contactCard: 'Contact Card'
        };
        let str = fallbacks[key] || key;
        args.forEach((arg, index) => {
            str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
        });
        return str;
    }

    // Initialize accessibility features when DOM is ready
    document.addEventListener('DOMContentLoaded', function () {
        initContactInfoCardAccessibility();
    });

    function initContactInfoCardAccessibility() {
        initSkipLinks();
        initKeyboardNavigation();
        initFocusManagement();
        initFocusManagement();
        initFormAccessibility();
        initReducedMotion();
    }

    /**
     * Initialize reduced motion handling
     */
    function initReducedMotion() {
        const contactCards = document.querySelectorAll('.contact-info-card');
        contactCards.forEach(function (card) {
            PromenAccessibility.setupReducedMotion(card);
        });
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
        return PromenAccessibility.validateField(field);
    }

    /**
     * Show field error (Delegated to Core)
     */
    function showFieldError(field, message) {
        PromenAccessibility.showFieldError(field, message);
    }

    /**
     * Clear field error (Delegated to Core)
     */
    function clearFieldError(field) {
        PromenAccessibility.clearFieldError(field);
    }

})();