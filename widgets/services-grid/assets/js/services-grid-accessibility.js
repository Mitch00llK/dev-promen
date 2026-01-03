/**
 * Services Grid Accessibility Enhancement
 * 
 * This script enhances the accessibility of the services grid widget by:
 * - Automatically generating aria-labels based on service titles
 * - Adding keyboard navigation support
 * - Implementing focus management
 * - Adding screen reader announcements
 */

(function($) {
    'use strict';

    class ServicesGridAccessibility {
        constructor() {
            this.init();
        }

        init() {
            this.enhanceServiceCards();
            this.addKeyboardNavigation();
            this.addFocusManagement();
            this.addScreenReaderSupport();
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
                        $cards.eq(nextIndex).focus();
                        break;

                    case 'ArrowLeft':
                    case 'ArrowUp':
                        e.preventDefault();
                        const prevIndex = currentIndex === 0 ? $cards.length - 1 : currentIndex - 1;
                        $cards.eq(prevIndex).focus();
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
                        $cards.first().focus();
                        break;

                    case 'End':
                        e.preventDefault();
                        $cards.last().focus();
                        break;
                }
            });
        }

        /**
         * Add focus management
         */
        addFocusManagement() {
            // Add focus indicators
            $('.service-card').on('focus', function() {
                $(this).addClass('focused');
            }).on('blur', function() {
                $(this).removeClass('focused');
            });

            // Add focus trap for sliders
            $('.services-slider').each((index, slider) => {
                const $slider = $(slider);
                const $cards = $slider.find('.service-card');

                if ($cards.length > 0) {
                    $slider.on('keydown', (e) => {
                        if (e.key === 'Tab') {
                            const $focusedCard = $slider.find('.service-card:focus');
                            if ($focusedCard.length === 0) {
                                e.preventDefault();
                                $cards.first().focus();
                            }
                        }
                    });
                }
            });
        }

        /**
         * Add screen reader support
         */
        addScreenReaderSupport() {
            // Add live region for dynamic content
            if (!$('#services-grid-live-region').length) {
                $('body').append('<div id="services-grid-live-region" class="screen-reader-text" aria-live="polite" aria-atomic="true"></div>');
            }

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
                    // Announce slide change
                    const serviceTitle = $serviceCard.find('.service-title').text().trim();
                    if (serviceTitle) {
                        $('#services-grid-live-region').text(`De service ${serviceTitle} wordt nu getoond in de schuifregelaar`);
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