/**
 * Document Info List Widget Accessibility Enhancements
 * WCAG 2.2 compliant keyboard navigation and screen reader support
 */

(function ($) {
    'use strict';

    /**
     * Document Info List Accessibility Class
     */
    class DocumentInfoListAccessibility {
        constructor() {
            this.init();
        }

        /**
         * Initialize accessibility features
         */
        init() {
            this.bindEvents();
            this.enhanceKeyboardNavigation();
            this.enhanceKeyboardNavigation();
            this.addScreenReaderSupport();

            // Add reduced motion support
            $('.document-info-list-container').each(function () {
                PromenAccessibility.setupReducedMotion(this);
            });
        }

        /**
         * Bind accessibility events
         */
        bindEvents() {
            $(document).on('keydown', '.document-info-list-container .document-info-item', this.handleKeyboardNavigation.bind(this));
            $(document).on('focus', '.document-info-list-container .document-info-item', this.announceItemFocus.bind(this));
            $(document).on('keydown', '.document-info-list-container .document-info-download-link', this.handleDownloadKeydown.bind(this));
            $(document).on('click', '.document-info-list-container .document-info-download-link', this.handleDownloadClick.bind(this));
        }

        /**
         * Handle keyboard navigation for document items
         */
        handleKeyboardNavigation(e) {
            const $currentItem = $(e.currentTarget);
            const $container = $currentItem.closest('.document-info-year-section');
            const $items = $container.find('.document-info-item');
            const currentIndex = $items.index($currentItem);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextItem($items, currentIndex);
                    break;
                case 'ArrowLeft':
                case 'ArrowUp':
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
                    this.activateItem($currentItem);
                    break;
            }
        }

        /**
         * Handle download button keydown
         */
        handleDownloadKeydown(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.handleDownloadClick(e);
            }
        }

        /**
         * Handle download button click
         */
        handleDownloadClick(e) {
            const $button = $(e.currentTarget);
            const fileName = $button.data('file-name') || 'document';
            const fileUrl = $button.data('file-url');

            if (fileUrl) {
                this.announceToScreenReader(`Downloading ${fileName}`);

                // Trigger download
                setTimeout(() => {
                    window.open(fileUrl, '_blank');
                }, 100);
            }
        }

        /**
         * Focus next item
         */
        focusNextItem($items, currentIndex) {
            const nextIndex = currentIndex + 1;
            if (nextIndex < $items.length) {
                $items.eq(nextIndex).focus();
            } else {
                // Try to move to next year section
                const $currentSection = $items.closest('.document-info-year-section');
                const $nextSection = $currentSection.next('.document-info-year-section');
                if ($nextSection.length) {
                    const $nextItems = $nextSection.find('.document-info-item');
                    if ($nextItems.length) {
                        $nextItems.first().focus();
                    }
                } else {
                    // Wrap to first item
                    $items.first().focus();
                }
            }
        }

        /**
         * Focus previous item
         */
        focusPreviousItem($items, currentIndex) {
            const prevIndex = currentIndex - 1;
            if (prevIndex >= 0) {
                $items.eq(prevIndex).focus();
            } else {
                // Try to move to previous year section
                const $currentSection = $items.closest('.document-info-year-section');
                const $prevSection = $currentSection.prev('.document-info-year-section');
                if ($prevSection.length) {
                    const $prevItems = $prevSection.find('.document-info-item');
                    if ($prevItems.length) {
                        $prevItems.last().focus();
                    }
                } else {
                    // Wrap to last item
                    $items.last().focus();
                }
            }
        }

        /**
         * Announce item focus to screen readers
         */
        announceItemFocus(e) {
            const $item = $(e.currentTarget);
            const $container = $item.closest('.document-info-year-section');
            const $items = $container.find('.document-info-item');
            const currentIndex = $items.index($item) + 1;
            const totalItems = $items.length;
            const $title = $item.find('.document-info-document-title');
            const $yearSection = $container.find('.document-info-year-title');
            const year = $yearSection.text().trim();

            let announcement = '';
            if ($title.length) {
                announcement += $title.text().trim();
            }
            if (year) {
                announcement += `, from ${year}`;
            }
            announcement += `, document ${currentIndex} of ${totalItems}`;

            this.announceToScreenReader(announcement);
        }

        /**
         * Activate item (click download button if available)
         */
        activateItem($item) {
            const $downloadButton = $item.find('.document-info-download-link');
            if ($downloadButton.length) {
                $downloadButton[0].click();
            } else {
                this.announceItemDetails($item);
            }
        }

        /**
         * Announce item details
         */
        announceItemDetails($item) {
            const $title = $item.find('.document-info-document-title');
            const $yearSection = $item.closest('.document-info-year-section').find('.document-info-year-title');
            const year = $yearSection.text().trim();

            let announcement = '';
            if ($title.length) {
                announcement += $title.text().trim();
            }
            if (year) {
                announcement += `, from ${year}`;
            }
            announcement += ', document information selected';

            this.announceToScreenReader(announcement);
        }

        /**
         * Enhance keyboard navigation
         */
        enhanceKeyboardNavigation() {
            $('.document-info-list-container .document-info-item').each(function () {
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
                            ${DocumentInfoListAccessibility.getKeyboardInstructions()}
                        </div>
                    `);
                }
            });

            // Enhance download buttons
            $('.document-info-list-container .document-info-download-link').each(function () {
                const $button = $(this);

                // Ensure proper button attributes
                if (!$button.attr('type')) {
                    $button.attr('type', 'button');
                }

                // Add download instructions
                if (!$button.attr('aria-describedby')) {
                    const buttonId = $button.attr('id') || 'download-' + Math.random().toString(36).substr(2, 9);
                    $button.attr('id', buttonId);
                    $button.attr('aria-describedby', buttonId + '-instructions');

                    // Add instructions element if not exists
                    if (!$button.find('.download-instructions').length) {
                        $button.append(`
                            <div class="download-instructions screen-reader-text" 
                                 id="${buttonId}-instructions">
                                ${DocumentInfoListAccessibility.getDownloadInstructions()}
                            </div>
                        `);
                    }
                }
            });
        }

        /**
         * Add screen reader support
         */
        addScreenReaderSupport() {
            // Add live region for announcements
            if (!$('#document-info-list-live-region').length) {
                $('body').append(`
                    <div id="document-info-list-live-region" 
                         class="screen-reader-text" 
                         aria-live="polite" 
                         aria-atomic="true">
                    </div>
                `);
            }

            // Add skip links
            $('.document-info-list-container').each(function () {
                PromenAccessibility.setupSkipLink(this, DocumentInfoListAccessibility.getSkipLinkText());
            });

            // Add section navigation
            $('.document-info-year-section').each(function () {
                const $section = $(this);
                const $yearTitle = $section.find('.document-info-year-title');
                const year = $yearTitle.text().trim();

                if (year && !$section.attr('aria-label')) {
                    $section.attr('aria-label', `Documenten uit het jaar ${year} die u kunt downloaden`);
                }
            });
        }

        /**
         * Announce text to screen readers
         */
        announceToScreenReader(text) {
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.announce(text);
            }
        }

        /**
         * Get keyboard navigation instructions
         */
        static getKeyboardInstructions() {
            return 'Use arrow keys to navigate between documents. Press Enter or Space to download or get details.';
        }

        /**
         * Get download button instructions
         */
        static getDownloadInstructions() {
            return 'Press Enter or Space to download this document.';
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
    $(document).ready(function () {
        if ($('.document-info-list-container').length) {
            new DocumentInfoListAccessibility();
        }
    });

    /**
     * Re-initialize on Elementor frontend updates
     */
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_document_info_list.default', function ($scope) {
            new DocumentInfoListAccessibility();
        });
    }

})(jQuery);