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
     * Initialize all contact info blocks on the page
     */
    function initContactInfoBlocks() {
        // Ensure class is loaded
        if (typeof ContactInfoBlocksAccessibility === 'undefined') {
            console.warn('ContactInfoBlocksAccessibility class not found. Make sure accessibility-handler.js is loaded.');
            return;
        }

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
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
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
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

})();