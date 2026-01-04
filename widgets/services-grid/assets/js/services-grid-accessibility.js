/**
 * Services Grid Accessibility Enhancement
 * 
 * This script enhances the accessibility of the services grid widget by:
 * - Automatically generating aria-labels based on service titles
 * - Adding keyboard navigation support
 * - Implementing focus management
 * - Adding screen reader announcements
 * 
 * Uses global PromenAccessibility core library.
 */

(function ($) {
    'use strict';

    /**
     * Get translated string from promenA11yStrings
     * @param {string} key - String key
     * @param {...any} args - Replacement arguments
     * @returns {string}
     */
    function getString(key, ...args) {
        const strings = window.promenA11yStrings || {};
        let str = strings[key] || key;
        args.forEach((arg, index) => {
            str = str.replace(`{${index}}`, arg);
        });
        return str;
    }


    class ServicesGridAccessibility {
        constructor() {
            this.init();
        }

        init() {
            this.enhanceServiceCards();
            this.addKeyboardNavigation();
            this.addFocusManagement();
            this.addFocusManagement();
            this.addScreenReaderSupport();

            // Add reduced motion support
            $('.services-grid, .services-slider').each((index, container) => {
                PromenAccessibility.setupReducedMotion(container);
            });
        }

        /**
         * Enhance service cards with accessibility features
         */
        enhanceServiceCards() {
            $('.services-grid, .services-slider').each((index, container) => {
                const $container = $(container);
                const $serviceCards = $container.find('.service-card');

                $serviceCards.each((cardIndex, card) => {
                    const $card = $(card);
                    const $link = $card.find('a');
                    const $title = $card.find('.service-title');
                    const $icon = $card.find('.service-icon');
                    const $description = $card.find('.service-description');

                    // Get service title for aria-label generation
                    const serviceTitle = $title.text().trim();

                    if (serviceTitle) {
                        // Enhance link aria-label
                        if ($link.length) {
                            const currentLabel = $link.attr('aria-label');
                            if (!currentLabel || currentLabel === serviceTitle) {
                                $link.attr('aria-label', getString('readMoreAbout', serviceTitle));
                            }
                        }

                        // Enhance icon aria-label
                        if ($icon.length) {
                            const currentIconLabel = $icon.attr('aria-label');
                            if (!currentIconLabel || currentIconLabel === serviceTitle) {
                                $icon.attr('aria-label', getString('iconFor', serviceTitle));
                            }
                        }

                        // Add description to card if available
                        if ($description.length) {
                            const descriptionText = $description.text().trim();
                            if (descriptionText) {
                                $card.attr('aria-describedby', $description.attr('id') || `service-description-${cardIndex + 1}`);
                            }
                        }
                    }
                });
            });
        }

        /**
         * Add keyboard navigation support
         */
        addKeyboardNavigation() {
            const self = this;
            $('.service-card').on('keydown', (e) => {
                const $card = $(e.currentTarget);
                const $container = $card.closest('.services-grid, .services-slider');
                const $cards = $container.find('.service-card');
                const currentIndex = $cards.index($card);

                switch (e.key) {
                    case 'ArrowRight':
                    case 'ArrowDown':
                        e.preventDefault();
                        const nextIndex = (currentIndex + 1) % $cards.length;
                        self.focusCard($cards.eq(nextIndex));
                        break;

                    case 'ArrowLeft':
                    case 'ArrowUp':
                        e.preventDefault();
                        const prevIndex = currentIndex === 0 ? $cards.length - 1 : currentIndex - 1;
                        self.focusCard($cards.eq(prevIndex));
                        break;

                    case 'Enter':
                    case ' ':
                        e.preventDefault();
                        const $link = $card.find('a');
                        if ($link.length) {
                            $link[0].click();
                        }
                        break;

                    case 'Home':
                        e.preventDefault();
                        self.focusCard($cards.first());
                        break;

                    case 'End':
                        e.preventDefault();
                        self.focusCard($cards.last());
                        break;
                }
            });
        }

        focusCard($card) {
            $card.focus();
            // Optional: Announce focused card title? 
            // Native behavior handles reading focused content usually.
        }

        /**
         * Add focus management
         */
        addFocusManagement() {
            // Add focus indicators
            $('.service-card').on('focus', function () {
                $(this).addClass('focused');
            }).on('blur', function () {
                $(this).removeClass('focused');
            });

            // Add focus trap for sliders using Core
            $('.services-slider').each((index, slider) => {
                PromenAccessibility.initFocusTrap(slider);
            });
        }

        /**
         * Add screen reader support
         */
        addScreenReaderSupport() {
            // Announce service count
            $('.services-grid, .services-slider').each((index, container) => {
                const $container = $(container);
                const $cards = $container.find('.service-card');
                const count = $cards.length;

                if (count > 0) {
                    const announcement = getString('servicesAvailable', count);
                    $container.attr('aria-label', announcement);
                }
            });

            // Add skip links
            $('.services-grid, .services-slider').each((index, container) => {
                const $container = $(container);
                const containerId = $container.attr('id') || `services-container-${index}`;

                if (!$container.attr('id')) {
                    $container.attr('id', containerId);
                }

                // Add skip link if not already present
                if (typeof PromenAccessibility !== 'undefined') {
                    PromenAccessibility.setupSkipLink($container[0], getString('skipToContent'));
                }
            });
        }

        /**
         * Update accessibility when slider changes
         */
        updateSliderAccessibility(sliderInstance) {
            if (sliderInstance && sliderInstance.slides) {
                const activeIndex = sliderInstance.activeIndex;
                const $activeSlide = $(sliderInstance.slides[activeIndex]);
                const $serviceCard = $activeSlide.find('.service-card');

                if ($serviceCard.length) {
                    // Announce slide change via Global Announcer
                    const serviceTitle = $serviceCard.find('.service-title').text().trim();
                    if (serviceTitle) {
                        PromenAccessibility.announce(getString('serviceNowShowing', serviceTitle));
                    }

                    // Update aria-current for pagination
                    $('.swiper-pagination .swiper-pagination-bullet').removeAttr('aria-current');
                    $('.swiper-pagination .swiper-pagination-bullet').eq(activeIndex).attr('aria-current', 'true');
                }
            }
        }
    }

    // Initialize when document is ready
    $(document).ready(() => {
        new ServicesGridAccessibility();

        // Re-initialize when new content is loaded
        $(document).on('elementor/popup/show', () => {
            setTimeout(() => {
                new ServicesGridAccessibility();
            }, 100);
        });
    });

    // Re-initialize on Elementor frontend updates
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_services_grid.default', function ($scope) {
                new ServicesGridAccessibility();
            });
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

    // Export for external use
    window.ServicesGridAccessibility = ServicesGridAccessibility;

})(jQuery);