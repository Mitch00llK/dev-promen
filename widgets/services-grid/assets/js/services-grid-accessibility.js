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
                                $link.attr('aria-label', `Klik hier om meer informatie te lezen over ${serviceTitle}`);
                            }
                        }

                        // Enhance icon aria-label
                        if ($icon.length) {
                            const currentIconLabel = $icon.attr('aria-label');
                            if (!currentIconLabel || currentIconLabel === serviceTitle) {
                                $icon.attr('aria-label', `Visueel icoon dat ${serviceTitle} representeert`);
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
                    const announcement = `Er zijn ${count} service${count !== 1 ? 's' : ''} beschikbaar die u kunt bekijken`;
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
                if (!$container.prev('.skip-link').length) {
                    // This could be standardized via PHP render, but for now maintaining JS injection if render doesn't handle it
                    $container.before(`<a href="#${containerId}" class="skip-link screen-reader-text">Sla over naar inhoud</a>`);
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
                        PromenAccessibility.announce(`De service ${serviceTitle} wordt nu getoond in de schuifregelaar`);
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

    // Export for external use
    window.ServicesGridAccessibility = ServicesGridAccessibility;

})(jQuery);