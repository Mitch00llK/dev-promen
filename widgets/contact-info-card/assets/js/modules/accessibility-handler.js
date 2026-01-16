/**
 * Contact Info Card Accessibility Handler
 * 
 * Handles accessibility features for the Contact Info Card widget.
 * 
 * @package Promen
 */

class PromenContactInfoCardHandler {

    constructor() {
        this.init();
    }

    init() {
        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => this.initFeatures());
        } else {
            this.initFeatures();
        }

        // Listen for Elementor frontend init
        window.addEventListener('elementor/frontend/init', () => {
            elementorFrontend.hooks.addAction('frontend/element_ready/contact_info_card.default', ($scope) => {
                this.initWidget($scope[0]);
            });
        });
    }

    initFeatures() {
        // Global initialization for existing elements (non-Elementor loaded)
        document.querySelectorAll('.contact-info-card').forEach(card => {
            this.initWidget(card);
        });
    }

    initWidget(card) {
        if (!card) return;

        this.initSkipLinks(card);
        this.initKeyboardNavigation(card);
        this.initFocusManagement(card);
        this.initFormAccessibility(card);
        this.initReducedMotion(card);
    }

    initReducedMotion(card) {
        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.setupReducedMotion(card);
        }
    }

    initSkipLinks(card) {
        if (typeof PromenAccessibility !== 'undefined') {
            // Use Dutch text from i18n
            const skipText = PromenAccessibility.getString ? PromenAccessibility.getString('skipToContent') : 'Ga naar inhoud';
            PromenAccessibility.setupSkipLink(card, skipText);
        }
    }

    initKeyboardNavigation(card) {
        const focusableElements = card.querySelectorAll(
            'a[href], button, input, textarea, select, [tabindex]:not([tabindex="-1"])'
        );

        if (focusableElements.length === 0) return;

        // Handle arrow key navigation within the card
        card.addEventListener('keydown', (e) => {
            const currentIndex = Array.from(focusableElements).indexOf(document.activeElement);
            if (currentIndex === -1) return;

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

    initFocusManagement(card) {
        // Trap focus within custom forms
        const formSections = card.querySelectorAll('.contact-info-card__custom-form');
        formSections.forEach(section => {
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.initFocusTrap(section);
            }
        });
    }

    initFormAccessibility(card) {
        const forms = card.querySelectorAll('.contact-info-card__custom-form form');

        forms.forEach(form => {
            // Add real-time validation feedback
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('blur', function () {
                    if (typeof PromenAccessibility !== 'undefined') {
                        PromenAccessibility.validateField(this);
                    }
                });

                input.addEventListener('input', function () {
                    // Clear error state on input
                    if (this.getAttribute('aria-invalid') === 'true') {
                        if (typeof PromenAccessibility !== 'undefined') {
                            PromenAccessibility.clearFieldError(this);
                        }
                    }
                });
            });

            // Handle form submission with accessibility
            form.addEventListener('submit', function (e) {
                if (typeof PromenAccessibility !== 'undefined') {
                    // Start basic validation loop since validateForm might assume specific structure
                    // Using validateField on all inputs for now
                    let isValid = true;
                    const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
                    inputs.forEach(input => {
                        if (!PromenAccessibility.validateField(input)) {
                            isValid = false;
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        PromenAccessibility.announce('Please correct the errors in the form', 'assertive');
                    } else {
                        PromenAccessibility.announce('Form submitted successfully');
                    }
                }
            });
        });
    }
}
