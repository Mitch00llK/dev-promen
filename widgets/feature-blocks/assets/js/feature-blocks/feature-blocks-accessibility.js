/**
 * Feature Blocks Widget - Lightweight Accessibility Enhancements
 * WCAG 2.2 AA Compliant - No visual changes, only accessibility improvements
 */

(function($) {
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
                const focusableElements = container.querySelectorAll(
                    'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
                );

                if (focusableElements.length === 0) return;

                const firstElement = focusableElements[0];
                const lastElement = focusableElements[focusableElements.length - 1];

                // Enhanced keyboard navigation
                container.addEventListener('keydown', (e) => {
                    if (e.key === 'Tab') {
                        if (e.shiftKey) {
                            if (document.activeElement === firstElement) {
                                e.preventDefault();
                                lastElement.focus();
                            }
                        } else {
                            if (document.activeElement === lastElement) {
                                e.preventDefault();
                                firstElement.focus();
                            }
                        }
                    } else if (e.key === 'Escape') {
                        // Allow escape to blur current element
                        if (document.activeElement && container.contains(document.activeElement)) {
                            document.activeElement.blur();
                        }
                    } else if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                        // Arrow key navigation between feature blocks
                        this.handleArrowNavigation(e, container);
                    }
                });

                // Add focus trap for better accessibility
                this.setupFocusTrap(container, focusableElements);
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
         * Setup focus trap for better keyboard navigation
         */
        setupFocusTrap(container, focusableElements) {
            // Add focus trap class for CSS styling
            container.classList.add('focus-trap');

            // Ensure proper focus order
            focusableElements.forEach((element, index) => {
                element.setAttribute('data-focus-order', index);
            });
        }

        /**
         * Setup ARIA live regions for announcements
         */
        setupARIALiveRegions() {
            const containers = document.querySelectorAll('.promen-feature-blocks-container');

            containers.forEach(container => {
                // Create live region if it doesn't exist
                let liveRegion = container.querySelector('.feature-blocks-live-region');
                if (!liveRegion) {
                    liveRegion = document.createElement('div');
                    liveRegion.className = 'feature-blocks-live-region';
                    liveRegion.setAttribute('aria-live', 'polite');
                    liveRegion.setAttribute('aria-atomic', 'true');
                    liveRegion.setAttribute('aria-label', 'Aankondigingen voor screen readers');
                    liveRegion.style.position = 'absolute';
                    liveRegion.style.left = '-10000px';
                    liveRegion.style.width = '1px';
                    liveRegion.style.height = '1px';
                    liveRegion.style.overflow = 'hidden';
                    container.appendChild(liveRegion);
                }

                // Create status region for important updates
                let statusRegion = container.querySelector('.feature-blocks-status-region');
                if (!statusRegion) {
                    statusRegion = document.createElement('div');
                    statusRegion.className = 'feature-blocks-status-region';
                    statusRegion.setAttribute('aria-live', 'assertive');
                    statusRegion.setAttribute('aria-atomic', 'true');
                    statusRegion.setAttribute('aria-label', 'Status updates en wijzigingen');
                    statusRegion.style.position = 'absolute';
                    statusRegion.style.left = '-10000px';
                    statusRegion.style.width = '1px';
                    statusRegion.style.height = '1px';
                    statusRegion.style.overflow = 'hidden';
                    container.appendChild(statusRegion);
                }

                // Store references for announcements
                container._liveRegion = liveRegion;
                container._statusRegion = statusRegion;
            });
        }

        /**
         * Announce message to screen readers
         */
        announceToScreenReader(message, container = null, priority = 'polite') {
            const containers = container ? [container] : document.querySelectorAll('.promen-feature-blocks-container');

            containers.forEach(container => {
                const region = priority === 'assertive' ? container._statusRegion : container._liveRegion;

                if (region) {
                    region.textContent = message;

                    // Clear after announcement
                    setTimeout(() => {
                        region.textContent = '';
                    }, priority === 'assertive' ? 2000 : 1000);
                }
            });
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
            const containers = document.querySelectorAll('.promen-feature-blocks-container');

            containers.forEach((container, index) => {
                // Create skip link if it doesn't exist
                let skipLink = container.querySelector('.feature-blocks-skip-link');
                if (!skipLink) {
                    skipLink = document.createElement('a');
                    skipLink.className = 'feature-blocks-skip-link';
                    skipLink.href = '#feature-blocks-content-' + index;
                    skipLink.textContent = 'Sla over naar inhoud';
                    skipLink.setAttribute('aria-label', 'Sla over naar inhoud');
                    container.insertBefore(skipLink, container.firstChild);
                }

                // Add target element
                const content = container.querySelector('.promen-feature-blocks-wrapper');
                if (content && !content.id) {
                    content.id = 'feature-blocks-content-' + index;
                    content.setAttribute('tabindex', '-1');
                }

                // Add skip link event listener
                skipLink.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.getElementById('feature-blocks-content-' + index);
                    if (target) {
                        target.focus();
                        this.announceStatusUpdate('Overgeslagen naar inhoud', container);
                    }
                });
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
    $(document).ready(function() {
        // Initialize accessibility enhancements
        window.featureBlocksAccessibility = new FeatureBlocksAccessibility();

        // Re-initialize for dynamic content (Elementor preview, etc.)
        $(document).on('elementor/popup/show', function() {
            setTimeout(() => {
                window.featureBlocksAccessibility.initializeDynamicContent();
            }, 100);
        });

        // Handle Elementor preview updates
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_feature_blocks.default', function($scope) {
                setTimeout(() => {
                    window.featureBlocksAccessibility.initializeDynamicContent();
                }, 100);
            });
        }
    });

})(jQuery);