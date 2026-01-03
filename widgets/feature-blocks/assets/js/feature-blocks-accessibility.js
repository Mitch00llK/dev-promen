/**
 * Feature Blocks Widget - Lightweight Accessibility Enhancements
 * WCAG 2.2 AA Compliant - No visual changes, only accessibility improvements
 */

(function ($) {
    'use strict';

    // Lightweight accessibility enhancements
    class FeatureBlocksAccessibility {
        constructor() {
            this.init();
        }

        init() {
            this.setupKeyboardNavigation();
            this.setupFocusManagement();
            this.setupARIALiveRegions();
            this.setupSkipLinks();

            // Add reduced motion support
            $('.promen-feature-blocks-container').each(function () {
                if (typeof PromenAccessibility !== 'undefined') {
                    PromenAccessibility.setupReducedMotion(this);
                }
            });
        }

        /**
         * Setup keyboard navigation for buttons and feature blocks
         */
        setupKeyboardNavigation() {
            const containers = document.querySelectorAll('.promen-feature-blocks-container');

            containers.forEach(container => {
                const buttons = container.querySelectorAll('.feature-button');
                const featureBlocks = container.querySelectorAll('.promen-feature-block');

                buttons.forEach(button => {
                    this.enhanceButtonKeyboardSupport(button);
                });

                featureBlocks.forEach(block => {
                    this.enhanceFeatureBlockKeyboardSupport(block);
                });
            });
        }

        /**
         * Enhance button keyboard support
         */
        enhanceButtonKeyboardSupport(button) {
            // Ensure button is focusable
            if (!button.hasAttribute('tabindex')) {
                button.setAttribute('tabindex', '0');
            }

            // Add keyboard event listeners
            button.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.activateButton(button);
                }
            });

            // Add focus indicators
            button.addEventListener('focus', () => {
                button.classList.add('keyboard-navigation');
            });

            button.addEventListener('blur', () => {
                button.classList.remove('keyboard-navigation');
            });
        }

        /**
         * Enhance feature block keyboard support
         */
        enhanceFeatureBlockKeyboardSupport(block) {
            // Ensure block is focusable
            if (!block.hasAttribute('tabindex')) {
                block.setAttribute('tabindex', '0');
            }

            // Add keyboard event listeners
            block.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.activateFeatureBlock(block);
                }
            });

            // Add focus indicators
            block.addEventListener('focus', () => {
                block.classList.add('keyboard-navigation');
                this.announceFeatureBlock(block);
            });

            block.addEventListener('blur', () => {
                block.classList.remove('keyboard-navigation');
            });

            // Add click handler for mouse users
            block.addEventListener('click', (e) => {
                // Only handle if not clicking on a button or link
                if (!e.target.closest('a, button')) {
                    this.activateFeatureBlock(block);
                }
            });
        }

        /**
         * Activate feature block
         */
        activateFeatureBlock(block) {
            const button = block.querySelector('.feature-button');
            if (button) {
                this.activateButton(button);
            } else {
                // Announce the block content
                this.announceFeatureBlock(block);
            }
        }

        /**
         * Announce feature block content to screen readers
         */
        announceFeatureBlock(block) {
            const title = block.querySelector('.feature-title, h1, h2, h3, h4, h5, h6');
            const content = block.querySelector('.feature-content');

            let announcement = '';
            if (title) {
                announcement += title.textContent.trim() + '. ';
            }
            if (content) {
                announcement += content.textContent.trim();
            }

            if (announcement) {
                this.announceToScreenReader(announcement, block.closest('.promen-feature-blocks-container'));
            }
        }

        /**
         * Activate button (handle click programmatically)
         */
        activateButton(button) {
            if (button.tagName === 'A') {
                const url = button.getAttribute('href');
                if (url && url !== '#') {
                    window.location.href = url;
                }
            } else {
                button.click();
            }
        }

        /**
         * Setup focus management with enhanced keyboard navigation
         */
        setupFocusManagement() {
            const containers = document.querySelectorAll('.promen-feature-blocks-container');

            containers.forEach(container => {
                // Use PromenAccessibility focus trap if available
                if (typeof PromenAccessibility !== 'undefined') {
                    PromenAccessibility.initFocusTrap(container);
                }

                // Add keyboard navigation for arrows (custom logic kept for grid navigation)
                container.addEventListener('keydown', (e) => {
                    if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                        // Arrow key navigation between feature blocks
                        this.handleArrowNavigation(e, container);
                    }
                });
            });
        }

        /**
         * Handle arrow key navigation between feature blocks
         */
        handleArrowNavigation(e, container) {
            const featureBlocks = container.querySelectorAll('.promen-feature-block[tabindex]');
            if (featureBlocks.length === 0) return;

            const currentIndex = Array.from(featureBlocks).indexOf(document.activeElement);
            if (currentIndex === -1) return;

            e.preventDefault();
            let nextIndex;

            if (e.key === 'ArrowDown') {
                nextIndex = (currentIndex + 1) % featureBlocks.length;
            } else if (e.key === 'ArrowUp') {
                nextIndex = (currentIndex - 1 + featureBlocks.length) % featureBlocks.length;
            }

            if (nextIndex !== undefined) {
                featureBlocks[nextIndex].focus();
            }
        }

        /**
         * Setup ARIA live regions for announcements
         */
        setupARIALiveRegions() {
            // Handled by PromenAccessibility
        }

        /**
         * Announce message to screen readers
         */
        announceToScreenReader(message, container = null, priority = 'polite') {
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.announce(message, priority);
            }
        }

        /**
         * Announce status update with higher priority
         */
        announceStatusUpdate(message, container = null) {
            this.announceToScreenReader(message, container, 'assertive');
        }

        /**
         * Setup skip links with enhanced functionality
         */
        setupSkipLinks() {
            // Keep existing logic or rely on PHP utils if implemented there.
            // Keeping JS implementation for now as it's dynamic.
            const containers = document.querySelectorAll('.promen-feature-blocks-container');
            containers.forEach(container => {
                if (typeof PromenAccessibility !== 'undefined') {
                    PromenAccessibility.setupSkipLink(container, 'Sla over naar inhoud');
                }
            });
        }

        /**
         * Initialize accessibility features for dynamically added content
         */
        initializeDynamicContent() {
            // Re-initialize for any dynamically added feature blocks
            this.setupKeyboardNavigation();
            this.setupFocusManagement();
            this.setupARIALiveRegions();
            this.setupSkipLinks();
        }
    }

    // Initialize when DOM is ready
    $(document).ready(function () {
        // Initialize accessibility enhancements
        window.featureBlocksAccessibility = new FeatureBlocksAccessibility();

        // Re-initialize for dynamic content (Elementor preview, etc.)
        $(document).on('elementor/popup/show', function () {
            setTimeout(() => {
                window.featureBlocksAccessibility.initializeDynamicContent();
            }, 100);
        });

        // Handle Elementor preview updates
        const initElementorHooks = () => {
            if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
                elementorFrontend.hooks.addAction('frontend/element_ready/promen_feature_blocks.default', function ($scope) {
                    setTimeout(() => {
                        window.featureBlocksAccessibility.initializeDynamicContent();
                    }, 100);
                });
            }
        };

        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            initElementorHooks();
        } else {
            window.addEventListener('elementor/frontend/init', initElementorHooks);
        }
    });

})(jQuery);