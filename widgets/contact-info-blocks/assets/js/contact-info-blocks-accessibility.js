/**
 * Contact Info Blocks Widget Accessibility Enhancements
 * WCAG 2.2 Level AA compliant
 * Semantic HTML, ARIA, and keyboard navigation without jQuery dependency
 * 
 * @package Promen
 * @version 2.0.0
 */

(function () {
    'use strict';

    /**
     * Contact Info Blocks Accessibility Class
     * Pure vanilla JS implementation for better performance
     */
    class ContactInfoBlocksAccessibility {
        /**
         * Constructor
         * @param {HTMLElement} container - The contact info blocks container
         */
        constructor(container) {
            this.container = container;
            this.blocks = Array.from(container.querySelectorAll('.contact-info-block'));
            this.liveRegion = null;
            this.focusedIndex = -1;

            // Bind methods to maintain context
            this.handleKeydown = this.handleKeydown.bind(this);
            this.handleFocus = this.handleFocus.bind(this);
            this.handleLinkClick = this.handleLinkClick.bind(this);

            this.init();
        }

        /**
         * Initialize accessibility features
         */
        init() {
            if (this.blocks.length === 0) return;

            this.createLiveRegion();
            this.enhanceLinks();
            this.bindEvents();
            this.setupReducedMotion();

            // Add skip link
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.setupSkipLink(this.container, getString('skipToContent', 'Sla over naar inhoud'));
            }
        }

        /**
         * Create ARIA live region for screen reader announcements
         */
        createLiveRegion() {
            const existingRegion = document.getElementById('contact-info-blocks-live-region');

            if (!existingRegion) {
                this.liveRegion = document.createElement('div');
                this.liveRegion.id = 'contact-info-blocks-live-region';
                this.liveRegion.className = 'screen-reader-text';
                this.liveRegion.setAttribute('role', 'status');
                this.liveRegion.setAttribute('aria-live', 'polite');
                this.liveRegion.setAttribute('aria-atomic', 'true');
                document.body.appendChild(this.liveRegion);
            } else {
                this.liveRegion = existingRegion;
            }
        }

        /**
         * Enhance links with proper ARIA labels and interaction feedback
         */
        enhanceLinks() {
            this.blocks.forEach((block, index) => {
                const links = block.querySelectorAll('a.contact-info-link');

                links.forEach((link) => {
                    // Add focus visible indicator
                    link.classList.add('focus-visible-enhanced');

                    // Ensure links have proper role
                    if (!link.getAttribute('role')) {
                        link.setAttribute('role', 'link');
                    }

                    // Add tabindex for proper tab order
                    if (!link.getAttribute('tabindex')) {
                        link.setAttribute('tabindex', '0');
                    }

                    // Enhance ARIA for better context
                    const blockType = block.dataset.blockType || 'contact';
                    const existingLabel = link.getAttribute('aria-label');

                    if (existingLabel) {
                        // Add position information for screen readers
                        const enhancedLabel = `${existingLabel} (${index + 1} van ${this.blocks.length})`;
                        link.setAttribute('data-original-label', existingLabel);
                        link.setAttribute('aria-label', enhancedLabel);
                    }

                    // Add ARIA describedby for additional context
                    const blockArticle = block.querySelector('.contact-info-block__inner');
                    if (blockArticle) {
                        const articleId = blockArticle.getAttribute('aria-labelledby');
                        if (articleId) {
                            link.setAttribute('aria-describedby', articleId);
                        }
                    }
                });
            });
        }

        /**
         * Bind event listeners
         */
        bindEvents() {
            // Keyboard navigation on list items
            this.blocks.forEach((block) => {
                const links = block.querySelectorAll('a.contact-info-link');

                // Add keyboard navigation to links
                links.forEach((link) => {
                    link.addEventListener('click', this.handleLinkClick, { passive: true });
                    link.addEventListener('focus', this.handleFocus, { passive: true });

                    // Handle Enter and Space key activation
                    link.addEventListener('keydown', (e) => {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            this.handleLinkClick(e);
                            // Trigger native click for navigation
                            link.click();
                        }
                    });

                    // Add blur handler to remove focus indicator
                    link.addEventListener('blur', () => {
                        const block = link.closest('.contact-info-block');
                        if (block) {
                            block.classList.remove('is-focused');
                        }
                    }, { passive: true });
                });
            });

            // Add container-level keyboard shortcuts
            this.container.addEventListener('keydown', this.handleKeydown);

            // Add escape key handler for accessibility
            this.container.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    // Clear all focus states
                    this.blocks.forEach(b => b.classList.remove('is-focused'));
                    this.announce(getString('navigationCancelled'));
                }
            });
        }

        /**
         * Handle keyboard navigation
         * @param {KeyboardEvent} event 
         */
        handleKeydown(event) {
            const target = event.target;

            // Only handle if we're on a link within a block
            if (!target.classList.contains('contact-info-link')) {
                return;
            }

            const currentBlock = target.closest('.contact-info-block');
            const currentIndex = this.blocks.indexOf(currentBlock);

            switch (event.key) {
                case 'ArrowDown':
                case 'ArrowRight':
                    event.preventDefault();
                    this.focusNextBlock(currentIndex);
                    break;

                case 'ArrowUp':
                case 'ArrowLeft':
                    event.preventDefault();
                    this.focusPreviousBlock(currentIndex);
                    break;

                case 'Home':
                    event.preventDefault();
                    this.focusBlock(0);
                    break;

                case 'End':
                    event.preventDefault();
                    this.focusBlock(this.blocks.length - 1);
                    break;
            }
        }

        /**
         * Focus the next block
         * @param {number} currentIndex 
         */
        focusNextBlock(currentIndex) {
            const nextIndex = (currentIndex + 1) % this.blocks.length;
            this.focusBlock(nextIndex);
        }

        /**
         * Focus the previous block
         * @param {number} currentIndex 
         */
        focusPreviousBlock(currentIndex) {
            const prevIndex = currentIndex - 1 < 0
                ? this.blocks.length - 1
                : currentIndex - 1;
            this.focusBlock(prevIndex);
        }

        /**
         * Focus a specific block by index
         * @param {number} index 
         */
        focusBlock(index) {
            if (index < 0 || index >= this.blocks.length) return;

            const block = this.blocks[index];
            const link = block.querySelector('a.contact-info-link');

            if (link) {
                link.focus();
                this.focusedIndex = index;

                // Announce navigation to screen readers
                const blockType = block.dataset.blockType || 'contact';
                const title = block.querySelector('.contact-info-title')?.textContent.trim() || '';
                this.announce(
                    `${title}, ${this.getBlockTypeLabel(blockType)}, ${index + 1} van ${this.blocks.length}`
                );
            }
        }

        /**
         * Handle focus events
         * @param {FocusEvent} event 
         */
        handleFocus(event) {
            const link = event.target;
            const block = link.closest('.contact-info-block');

            if (!block) return;

            // Add visual focus indicator to block
            this.blocks.forEach(b => b.classList.remove('is-focused'));
            block.classList.add('is-focused');
        }

        /**
         * Handle link clicks with announcements
         * @param {MouseEvent|KeyboardEvent} event 
         */
        handleLinkClick(event) {
            const link = event.currentTarget;
            const href = link.getAttribute('href');

            // Check if it was activated via keyboard (for better feedback)
            const isKeyboardActivation = event instanceof KeyboardEvent;

            if (href) {
                if (href.startsWith('tel:')) {
                    const phoneNumber = link.querySelector('[aria-hidden="true"]')?.textContent.trim()
                        || link.textContent.trim();
                    const callingMsg = getString('callingNumber', phoneNumber);
                    this.announce(callingMsg);

                    // Additional feedback for keyboard users
                    if (isKeyboardActivation) {
                        link.classList.add('activated');
                        setTimeout(() => link.classList.remove('activated'), 200);
                    }
                } else if (href.startsWith('mailto:')) {
                    const email = link.querySelector('[aria-hidden="true"]')?.textContent.trim()
                        || link.textContent.trim();
                    const emailMsg = getString('composingEmail', email);
                    this.announce(emailMsg);

                    // Additional feedback for keyboard users
                    if (isKeyboardActivation) {
                        link.classList.add('activated');
                        setTimeout(() => link.classList.remove('activated'), 200);
                    }
                }
            }
        }

        /**
         * Get localized block type label
         * @param {string} blockType 
         * @returns {string}
         */
        getBlockTypeLabel(blockType) {
            const labels = {
                'address': getString('address'),
                'phone': getString('phone'),
                'email': getString('email')
            };
            return labels[blockType] || getString('contactInfo');
        }

        /**
         * Announce text to screen readers
         * @param {string} message 
         */
        announce(message) {
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.announce(message);
            }
        }

        /**
         * Setup reduced motion preferences
         */
        setupReducedMotion() {
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

            const applyReducedMotion = (matches) => {
                if (matches) {
                    this.container.classList.add('reduce-motion');

                    // Disable GSAP animations if they exist
                    const animatedBlocks = this.container.querySelectorAll('[data-animation]');
                    animatedBlocks.forEach(block => {
                        block.style.opacity = '1';
                        block.style.transform = 'none';
                        block.style.transition = 'none';
                    });

                    // Remove any animation classes
                    this.blocks.forEach(block => {
                        block.style.animation = 'none';
                    });

                    // Announce to screen readers
                    this.announce(getString('animationsDisabled'));
                } else {
                    this.container.classList.remove('reduce-motion');
                }
            };

            // Apply initial state
            applyReducedMotion(prefersReducedMotion.matches);

            // Listen for changes
            prefersReducedMotion.addEventListener('change', (e) => {
                applyReducedMotion(e.matches);
            });
        }

        /**
         * Destroy instance and clean up
         */
        destroy() {
            this.container.removeEventListener('keydown', this.handleKeydown);

            this.blocks.forEach((block) => {
                const links = block.querySelectorAll('a.contact-info-link');
                links.forEach((link) => {
                    link.removeEventListener('click', this.handleLinkClick);
                    link.removeEventListener('focus', this.handleFocus);
                });
            });

            this.blocks = [];
            this.liveRegion = null;
        }
    }

    /**
     * Initialize all contact info blocks on the page
     */
    function initContactInfoBlocks() {
        const containers = document.querySelectorAll('.contact-info-blocks');

        containers.forEach((container) => {
            // Check if already initialized
            if (container.dataset.accessibilityInit === 'true') return;

            // Mark as initialized
            container.dataset.accessibilityInit = 'true';

            // Create instance
            const instance = new ContactInfoBlocksAccessibility(container);

            // Store instance on element for later access
            container._accessibilityInstance = instance;
        });
    }

    /**
     * Initialize on DOM ready
     */
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initContactInfoBlocks);
    } else {
        initContactInfoBlocks();
    }

    /**
     * Re-initialize on Elementor frontend updates
     */
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction(
            'frontend/element_ready/contact_info_blocks.default',
            function ($scope) {
                const container = $scope[0].querySelector('.contact-info-blocks');
                if (container) {
                    // Clean up old instance
                    if (container._accessibilityInstance) {
                        container._accessibilityInstance.destroy();
                    }

                    // Reinitialize
                    container.dataset.accessibilityInit = 'false';
                    initContactInfoBlocks();
                }
            }
        );
    }

    // Expose to global scope for manual initialization if needed
    window.PromenContactInfoBlocksAccessibility = ContactInfoBlocksAccessibility;

})();