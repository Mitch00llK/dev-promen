/**
 * Benefits Widget Accessibility Enhancements
 * WCAG 2.2 compliant keyboard navigation and screen reader support
 */

(function($) {
    'use strict';

    /**
     * Benefits Widget Accessibility Class
     */
    class BenefitsAccessibility {
        constructor() {
            this.init();
        }

        /**
         * Initialize accessibility features
         */
        init() {
            this.bindEvents();
            this.enhanceKeyboardNavigation();
            this.addScreenReaderSupport();
        }

        /**
         * Bind accessibility events
         */
        bindEvents() {
            $(document).on('keydown', '.benefits-widget .benefit-item', this.handleKeyboardNavigation.bind(this));
            $(document).on('focus', '.benefits-widget .benefit-item', this.announceBenefitItem.bind(this));
            $(document).on('click', '.benefits-widget .benefit-item', this.handleItemClick.bind(this));
        }

        /**
         * Handle keyboard navigation for benefit items
         */
        handleKeyboardNavigation(e) {
            const $currentItem = $(e.currentTarget);
            const $container = $currentItem.closest('.benefits-container');
            const $items = $container.find('.benefit-item');
            const currentIndex = $items.index($currentItem);

            switch (e.key) {
                case 'ArrowDown':
                case 'ArrowRight':
                    e.preventDefault();
                    this.focusNextItem($items, currentIndex);
                    break;
                case 'ArrowUp':
                case 'ArrowLeft':
                    e.preventDefault();
                    this.focusPreviousItem($items, currentIndex);
                    break;
                case 'Home':
                    e.preventDefault();
                    $items.first().focus();
                    break;
                case 'End':
                    e.preventDefault();
                    $items.last().focus();
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.handleItemClick(e);
                    break;
            }
        }

        /**
         * Focus next item in the list
         */
        focusNextItem($items, currentIndex) {
            const nextIndex = currentIndex + 1;
            if (nextIndex < $items.length) {
                $items.eq(nextIndex).focus();
            } else {
                // Wrap to first item
                $items.first().focus();
            }
        }

        /**
         * Focus previous item in the list
         */
        focusPreviousItem($items, currentIndex) {
            const prevIndex = currentIndex - 1;
            if (prevIndex >= 0) {
                $items.eq(prevIndex).focus();
            } else {
                // Wrap to last item
                $items.last().focus();
            }
        }

        /**
         * Announce benefit item to screen readers
         */
        announceBenefitItem(e) {
            const $item = $(e.currentTarget);
            const $title = $item.find('.benefit-title');
            const $description = $item.find('.benefit-description');
            const $container = $item.closest('.benefits-container');
            const $items = $container.find('.benefit-item');
            const currentIndex = $items.index($item) + 1;
            const totalItems = $items.length;

            let announcement = '';
            if ($title.length) {
                announcement += $title.text().trim();
            }
            if ($description.length) {
                announcement += ', ' + $description.text().trim();
            }
            announcement += `, item ${currentIndex} of ${totalItems}`;

            this.announceToScreenReader(announcement);
        }

        /**
         * Handle item click with accessibility
         */
        handleItemClick(e) {
            const $item = $(e.currentTarget);
            const $title = $item.find('.benefit-title');

            if ($title.length) {
                const title = $title.text().trim();
                this.announceToScreenReader(`Selected: ${title}`);
            }
        }

        /**
         * Enhance keyboard navigation
         */
        enhanceKeyboardNavigation() {
            $('.benefits-widget .benefit-item').each(function() {
                const $item = $(this);

                // Ensure proper tabindex
                if (!$item.attr('tabindex')) {
                    $item.attr('tabindex', '0');
                }

                // Add keyboard navigation instructions
                $item.attr('aria-describedby', $item.attr('id') + '-instructions');

                // Add instructions element if not exists
                if (!$item.find('.keyboard-instructions').length) {
                    $item.append(`
                        <div class="keyboard-instructions screen-reader-text" 
                             id="${$item.attr('id')}-instructions">
                            ${BenefitsAccessibility.getKeyboardInstructions()}
                        </div>
                    `);
                }
            });
        }

        /**
         * Add screen reader support
         */
        addScreenReaderSupport() {
            // Add live region for announcements
            if (!$('#benefits-live-region').length) {
                $('body').append(`
                    <div id="benefits-live-region" 
                         class="screen-reader-text" 
                         aria-live="polite" 
                         aria-atomic="true">
                    </div>
                `);
            }

            // Add skip link if not exists
            if (!$('.benefits-widget .skip-link').length) {
                $('.benefits-widget').prepend(`
                    <a href="#benefits-content" class="skip-link">
                        ${BenefitsAccessibility.getSkipLinkText()}
                    </a>
                `);
            }
        }

        /**
         * Announce text to screen readers
         */
        announceToScreenReader(text) {
            const $liveRegion = $('#benefits-live-region');
            if ($liveRegion.length) {
                $liveRegion.text(text);
                // Clear after announcement
                setTimeout(() => {
                    $liveRegion.text('');
                }, 1000);
            }
        }

        /**
         * Get keyboard navigation instructions
         */
        static getKeyboardInstructions() {
            return 'Use arrow keys to navigate between benefits. Press Enter or Space to select.';
        }

        /**
         * Get skip link text
         */
        static getSkipLinkText() {
            return 'Sla over naar inhoud';
        }
    }

    /**
     * Initialize when document is ready
     */
    $(document).ready(function() {
        if ($('.benefits-widget').length) {
            new BenefitsAccessibility();
        }
    });

    /**
     * Re-initialize on Elementor frontend updates
     */
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_benefits.default', function($scope) {
            new BenefitsAccessibility();
        });
    }

})(jQuery);