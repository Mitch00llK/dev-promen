/**
 * Checklist Comparison Widget Accessibility Enhancements
 * WCAG 2.2 compliant keyboard navigation and screen reader support
 */

(function($) {
    'use strict';

    /**
     * Checklist Comparison Accessibility Class
     */
    class ChecklistComparisonAccessibility {
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
            this.setupComparisonNavigation();
        }

        /**
         * Bind accessibility events
         */
        bindEvents() {
            $(document).on('keydown', '.promen-checklist-comparison__item', this.handleKeyboardNavigation.bind(this));
            $(document).on('focus', '.promen-checklist-comparison__item', this.announceChecklistItem.bind(this));
            $(document).on('keydown', '.promen-checklist-comparison', this.handleContainerNavigation.bind(this));
        }

        /**
         * Handle keyboard navigation for checklist items
         */
        handleKeyboardNavigation(e) {
            const $currentItem = $(e.currentTarget);
            const $column = $currentItem.closest('.promen-checklist-comparison__column');
            const $items = $column.find('.promen-checklist-comparison__item');
            const currentIndex = $items.index($currentItem);

            switch (e.key) {
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextItem($items, currentIndex);
                    break;
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousItem($items, currentIndex);
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    this.focusCorrespondingItem($currentItem, 'right');
                    break;
                case 'ArrowLeft':
                    e.preventDefault();
                    this.focusCorrespondingItem($currentItem, 'left');
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
                    this.announceItemDetails($currentItem);
                    break;
            }
        }

        /**
         * Handle container-level navigation
         */
        handleContainerNavigation(e) {
            const $container = $(e.currentTarget);

            switch (e.key) {
                case 'Tab':
                    // Ensure proper tab order between columns
                    this.manageTabOrder($container, e);
                    break;
            }
        }

        /**
         * Focus next item in the same column
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
         * Focus previous item in the same column
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
         * Focus corresponding item in the other column
         */
        focusCorrespondingItem($currentItem, direction) {
            const currentIndex = $currentItem.closest('.promen-checklist-comparison__items').find('.promen-checklist-comparison__item').index($currentItem);
            const $targetColumn = $currentItem.closest('.promen-checklist-comparison__container')
                .find(`.promen-checklist-comparison__column--${direction}`);
            const $targetItems = $targetColumn.find('.promen-checklist-comparison__item');

            if ($targetItems.length > currentIndex) {
                $targetItems.eq(currentIndex).focus();
            } else if ($targetItems.length > 0) {
                // Focus last item if index is out of bounds
                $targetItems.last().focus();
            }
        }

        /**
         * Manage tab order between columns
         */
        manageTabOrder($container, e) {
            const $leftColumn = $container.find('.promen-checklist-comparison__column--left');
            const $rightColumn = $container.find('.promen-checklist-comparison__column--right');

            // If tabbing from left column, focus right column
            if (e.shiftKey && document.activeElement.closest('.promen-checklist-comparison__column--right')) {
                const $firstLeftItem = $leftColumn.find('.promen-checklist-comparison__item').first();
                if ($firstLeftItem.length) {
                    e.preventDefault();
                    $firstLeftItem.focus();
                }
            }
        }

        /**
         * Announce checklist item to screen readers
         */
        announceChecklistItem(e) {
            const $item = $(e.currentTarget);
            const $text = $item.find('.promen-checklist-comparison__item-text');
            const $column = $item.closest('.promen-checklist-comparison__column');
            const $items = $column.find('.promen-checklist-comparison__item');
            const currentIndex = $items.index($item) + 1;
            const totalItems = $items.length;
            const columnSide = $column.hasClass('promen-checklist-comparison__column--left') ? 'left' : 'right';

            let announcement = '';
            if ($text.length) {
                announcement += $text.text().trim();
            }
            announcement += `, ${columnSide} column, item ${currentIndex} of ${totalItems}`;

            this.announceToScreenReader(announcement);
        }

        /**
         * Announce item details
         */
        announceItemDetails($item) {
            const $text = $item.find('.promen-checklist-comparison__item-text');
            if ($text.length) {
                const text = $text.text().trim();
                this.announceToScreenReader(`Selected: ${text}`);
            }
        }

        /**
         * Enhance keyboard navigation
         */
        enhanceKeyboardNavigation() {
            $('.promen-checklist-comparison__item').each(function() {
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
                            ${ChecklistComparisonAccessibility.getKeyboardInstructions()}
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
            if (!$('#checklist-live-region').length) {
                $('body').append(`
                    <div id="checklist-live-region" 
                         class="screen-reader-text" 
                         aria-live="polite" 
                         aria-atomic="true">
                    </div>
                `);
            }

            // Add skip links if not exist
            if (!$('.promen-checklist-comparison .skip-link').length) {
                $('.promen-checklist-comparison').prepend(`
                    <a href="#checklist-left" class="skip-link">
                        ${ChecklistComparisonAccessibility.getSkipLinkText('left')}
                    </a>
                    <a href="#checklist-right" class="skip-link">
                        ${ChecklistComparisonAccessibility.getSkipLinkText('right')}
                    </a>
                `);
            }
        }

        /**
         * Setup comparison navigation
         */
        setupComparisonNavigation() {
            $('.promen-checklist-comparison__container').each(function() {
                const $container = $(this);
                const $leftColumn = $container.find('.promen-checklist-comparison__column--left');
                const $rightColumn = $container.find('.promen-checklist-comparison__column--right');

                // Add comparison instructions
                if (!$container.find('.comparison-instructions').length) {
                    $container.prepend(`
                        <div class="comparison-instructions screen-reader-text">
                            ${ChecklistComparisonAccessibility.getComparisonInstructions()}
                        </div>
                    `);
                }

                // Ensure both columns have same number of items for proper comparison
                this.balanceColumns($leftColumn, $rightColumn);
            });
        }

        /**
         * Balance columns for proper comparison
         */
        balanceColumns($leftColumn, $rightColumn) {
            const leftItems = $leftColumn.find('.promen-checklist-comparison__item').length;
            const rightItems = $rightColumn.find('.promen-checklist-comparison__item').length;

            if (leftItems !== rightItems) {
                const maxItems = Math.max(leftItems, rightItems);

                // Add empty items to balance columns
                for (let i = leftItems; i < maxItems; i++) {
                    $leftColumn.find('.promen-checklist-comparison__items').append(`
                        <li class="promen-checklist-comparison__item" 
                            role="listitem" 
                            aria-hidden="true" 
                            tabindex="-1">
                            <span class="promen-checklist-comparison__item-icon" aria-hidden="true"></span>
                            <span class="promen-checklist-comparison__item-text"></span>
                        </li>
                    `);
                }

                for (let i = rightItems; i < maxItems; i++) {
                    $rightColumn.find('.promen-checklist-comparison__items').append(`
                        <li class="promen-checklist-comparison__item" 
                            role="listitem" 
                            aria-hidden="true" 
                            tabindex="-1">
                            <span class="promen-checklist-comparison__item-icon" aria-hidden="true"></span>
                            <span class="promen-checklist-comparison__item-text"></span>
                        </li>
                    `);
                }
            }
        }

        /**
         * Announce text to screen readers
         */
        announceToScreenReader(text) {
            const $liveRegion = $('#checklist-live-region');
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
            return 'Use arrow keys to navigate. Left/Right arrows move between columns. Up/Down arrows move within column.';
        }

        /**
         * Get skip link text
         */
        static getSkipLinkText(column) {
            return 'Sla over naar inhoud';
        }

        /**
         * Get comparison instructions
         */
        static getComparisonInstructions() {
            return 'This is a two-column comparison. Use arrow keys to navigate between items and columns.';
        }
    }

    /**
     * Initialize when document is ready
     */
    $(document).ready(function() {
        if ($('.promen-checklist-comparison').length) {
            new ChecklistComparisonAccessibility();
        }
    });

    /**
     * Re-initialize on Elementor frontend updates
     */
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_checklist_comparison.default', function($scope) {
            new ChecklistComparisonAccessibility();
        });
    }

})(jQuery);