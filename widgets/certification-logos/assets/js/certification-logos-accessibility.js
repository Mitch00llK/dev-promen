/**
 * Certification Logos Widget Accessibility Enhancements
 * WCAG 2.2 compliant keyboard navigation and screen reader support
 */

(function ($) {
    'use strict';

    /**
     * Get localized string helper
     */
    function getString(key, ...args) {
        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.getString) {
            return PromenAccessibility.getString(key, ...args);
        }
        const fallbacks = {
            gridKeyboardInstructions: 'Use arrow keys to navigate between certification logos. Press Enter or Space to visit the certification page.',
            sliderKeyboardInstructions: 'Use arrow keys to navigate between certification logos. Press Enter or Space to visit the certification page.',
            skipLinkText: 'Sla over naar inhoud',
            sliderInstructions: 'This is a carousel of certification logos. Use arrow keys to navigate between logos.',
            openingPage: 'Opening {0} page'
        };
        let str = fallbacks[key] || key;
        args.forEach((arg, index) => {
            str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
        });
        return str;
    }

    /**
     * Certification Logos Accessibility Class
     */
    class CertificationLogosAccessibility {
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
            this.setupSliderAccessibility();
            this.setupReducedMotion();
        }

        /**
         * Setup reduced motion handling
         */
        setupReducedMotion() {
            $('.promen-certification-logos').each(function () {
                const $widget = $(this);
                PromenAccessibility.setupReducedMotion(this, {
                    onMotionReduced: () => {
                        const swiper = $widget.find('.swiper')[0]?.swiper;
                        if (swiper && swiper.autoplay && swiper.autoplay.running) {
                            swiper.autoplay.stop();
                        }
                    }
                });
            });
        }

        /**
         * Bind accessibility events
         */
        bindEvents() {
            $(document).on('keydown', '.promen-certification-logos .certification-logo', this.handleKeyboardNavigation.bind(this));
            $(document).on('focus', '.promen-certification-logos .certification-logo', this.announceLogoFocus.bind(this));
            $(document).on('keydown', '.promen-certification-logos .swiper-slide', this.handleSliderNavigation.bind(this));
            $(document).on('focus', '.promen-certification-logos .swiper-slide', this.announceSlideFocus.bind(this));
        }

        /**
         * Handle keyboard navigation for grid logos
         */
        handleKeyboardNavigation(e) {
            const $currentLogo = $(e.currentTarget);
            const $container = $currentLogo.closest('.logos-grid');
            const $logos = $container.find('.certification-logo');
            const currentIndex = $logos.index($currentLogo);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextLogo($logos, currentIndex);
                    break;
                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousLogo($logos, currentIndex);
                    break;
                case 'Home':
                    e.preventDefault();
                    $logos.first().focus();
                    break;
                case 'End':
                    e.preventDefault();
                    $logos.last().focus();
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.activateLogo($currentLogo);
                    break;
            }
        }

        /**
         * Handle keyboard navigation for slider slides
         */
        handleSliderNavigation(e) {
            const $currentSlide = $(e.currentTarget);
            const $slider = $currentSlide.closest('.swiper');
            const $slides = $slider.find('.swiper-slide');
            const currentIndex = $slides.index($currentSlide);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextSlide($slides, currentIndex);
                    break;
                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousSlide($slides, currentIndex);
                    break;
                case 'Home':
                    e.preventDefault();
                    $slides.first().focus();
                    break;
                case 'End':
                    e.preventDefault();
                    $slides.last().focus();
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.activateSlide($currentSlide);
                    break;
            }
        }

        /**
         * Focus next logo in grid
         */
        focusNextLogo($logos, currentIndex) {
            const nextIndex = currentIndex + 1;
            if (nextIndex < $logos.length) {
                $logos.eq(nextIndex).focus();
            } else {
                // Wrap to first logo
                $logos.first().focus();
            }
        }

        /**
         * Focus previous logo in grid
         */
        focusPreviousLogo($logos, currentIndex) {
            const prevIndex = currentIndex - 1;
            if (prevIndex >= 0) {
                $logos.eq(prevIndex).focus();
            } else {
                // Wrap to last logo
                $logos.last().focus();
            }
        }

        /**
         * Focus next slide in slider
         */
        focusNextSlide($slides, currentIndex) {
            const nextIndex = currentIndex + 1;
            if (nextIndex < $slides.length) {
                $slides.eq(nextIndex).focus();
            } else {
                // Wrap to first slide
                $slides.first().focus();
            }
        }

        /**
         * Focus previous slide in slider
         */
        focusPreviousSlide($slides, currentIndex) {
            const prevIndex = currentIndex - 1;
            if (prevIndex >= 0) {
                $slides.eq(prevIndex).focus();
            } else {
                // Wrap to last slide
                $slides.last().focus();
            }
        }

        /**
         * Announce logo focus to screen readers
         */
        announceLogoFocus(e) {
            const $logo = $(e.currentTarget);
            const $container = $logo.closest('.logos-grid');
            const $logos = $container.find('.certification-logo');
            const currentIndex = $logos.index($logo) + 1;
            const totalLogos = $logos.length;
            const $img = $logo.find('img');
            const altText = $img.attr('alt') || 'Certification logo';

            const announcement = `${altText}, logo ${currentIndex} of ${totalLogos}`;
            this.announceToScreenReader(announcement);
        }

        /**
         * Announce slide focus to screen readers
         */
        announceSlideFocus(e) {
            const $slide = $(e.currentTarget);
            const $slider = $slide.closest('.swiper');
            const $slides = $slider.find('.swiper-slide');
            const currentIndex = $slides.index($slide) + 1;
            const totalSlides = $slides.length;
            const $img = $slide.find('img');
            const altText = $img.attr('alt') || 'Certification logo';

            const announcement = `${altText}, slide ${currentIndex} of ${totalSlides}`;
            this.announceToScreenReader(announcement);
        }

        /**
         * Activate logo (click link if available)
         */
        activateLogo($logo) {
            const $link = $logo.find('a');
            if ($link.length) {
                $link[0].click();
                const $img = $logo.find('img');
                const altText = $img.attr('alt') || 'Certification logo';
                this.announceToScreenReader(getString('openingPage', altText));
            }
        }

        /**
         * Activate slide (click link if available)
         */
        activateSlide($slide) {
            const $link = $slide.find('a');
            if ($link.length) {
                $link[0].click();
                const $img = $slide.find('img');
                const altText = $img.attr('alt') || 'Certification logo';
                this.announceToScreenReader(getString('openingPage', altText));
            }
        }

        /**
         * Enhance keyboard navigation
         */
        enhanceKeyboardNavigation() {
            // Enhance grid logos
            $('.promen-certification-logos .certification-logo').each(function () {
                const $logo = $(this);

                // Ensure proper tabindex
                if (!$logo.attr('tabindex')) {
                    $logo.attr('tabindex', '0');
                }

                // Add keyboard navigation instructions
                $logo.attr('aria-describedby', $logo.attr('id') + '-instructions');

                // Add instructions element if not exists
                if (!$logo.find('.keyboard-instructions').length) {
                    $logo.append(`
                        <div class="keyboard-instructions screen-reader-text" 
                             id="${$logo.attr('id')}-instructions">
                            ${getString('gridKeyboardInstructions')}
                        </div>
                    `);
                }
            });

            // Enhance slider slides
            $('.promen-certification-logos .swiper-slide').each(function () {
                const $slide = $(this);

                // Ensure proper tabindex
                if (!$slide.attr('tabindex')) {
                    $slide.attr('tabindex', '0');
                }

                // Add keyboard navigation instructions
                $slide.attr('aria-describedby', $slide.attr('id') + '-instructions');

                // Add instructions element if not exists
                if (!$slide.find('.keyboard-instructions').length) {
                    $slide.append(`
                        <div class="keyboard-instructions screen-reader-text" 
                             id="${$slide.attr('id')}-instructions">
                            ${getString('sliderKeyboardInstructions')}
                        </div>
                    `);
                }
            });
        }

        /**
         * Add screen reader support
         */
        addScreenReaderSupport() {
            // Live region handled by PromenAccessibility

            // Add skip links if not exist
            if (typeof PromenAccessibility !== 'undefined') {
                $('.promen-certification-logos').each(function () {
                    PromenAccessibility.setupSkipLink(this, getString('skipLinkText'));
                });
            }
        }

        /**
         * Setup slider accessibility
         */
        setupSliderAccessibility() {
            $('.promen-certification-logos .swiper').each(function () {
                const $slider = $(this);
                const $slides = $slider.find('.swiper-slide');

                // Add slider instructions
                if (!$slider.find('.slider-instructions').length) {
                    $slider.prepend(`
                        <div class="slider-instructions screen-reader-text">
                            ${getString('sliderInstructions')}
                        </div>
                    `);
                }

                // Enhance navigation buttons
                $slider.find('.swiper-button-prev, .swiper-button-next').each(function () {
                    const $button = $(this);
                    if (!$button.attr('type')) {
                        $button.attr('type', 'button');
                    }
                });

                // Enhance pagination
                $slider.find('.swiper-pagination').each(function () {
                    const $pagination = $(this);
                    if (!$pagination.attr('role')) {
                        $pagination.attr('role', 'tablist');
                    }
                    if (!$pagination.attr('aria-label')) {
                        $pagination.attr('aria-label', 'Paginering om door verschillende certificeringslogo\'s te navigeren');
                    }
                });
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
    }

    /**
     * Initialize when document is ready
     */
    $(document).ready(function () {
        if ($('.promen-certification-logos').length) {
            new CertificationLogosAccessibility();
        }
    });

    /**
     * Re-initialize on Elementor frontend updates
     */
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_certification_logos.default', function ($scope) {
                new CertificationLogosAccessibility();
            });
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

})(jQuery);