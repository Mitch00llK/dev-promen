/**
 * Business Catering Widget Accessibility Enhancements
 * WCAG 2.2 compliant keyboard navigation and screen reader support
 * 
 * Uses global PromenAccessibility core library.
 */

(function ($) {
    'use strict';

    /**
     * Business Catering Accessibility Class
     */
    class BusinessCateringAccessibility {
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
        }

        /**
         * Bind accessibility events
         */
        bindEvents() {
            $(document).on('keydown', '.promen-business-catering-widget .swiper-slide', this.handleKeyboardNavigation.bind(this));
            $(document).on('focus', '.promen-business-catering-widget .swiper-slide', this.announceSlideFocus.bind(this));
            $(document).on('keydown', '.promen-business-catering-widget .promen-catering-image-wrapper', this.handleGridNavigation.bind(this));
            $(document).on('focus', '.promen-business-catering-widget .promen-catering-image-wrapper', this.announceImageFocus.bind(this));
        }

        /**
         * Handle keyboard navigation for slider slides
         */
        handleKeyboardNavigation(e) {
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
                    this.announceSlideDetails($currentSlide);
                    break;
            }
        }

        /**
         * Handle keyboard navigation for grid images
         */
        handleGridNavigation(e) {
            const $currentImage = $(e.currentTarget);
            const $container = $currentImage.closest('.promen-catering-grid');
            const $images = $container.find('.promen-catering-image-wrapper');
            const currentIndex = $images.index($currentImage);

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    this.focusNextImage($images, currentIndex);
                    break;
                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    this.focusPreviousImage($images, currentIndex);
                    break;
                case 'Home':
                    e.preventDefault();
                    $images.first().focus();
                    break;
                case 'End':
                    e.preventDefault();
                    $images.last().focus();
                    break;
                case 'Enter':
                case ' ':
                    e.preventDefault();
                    this.announceImageDetails($currentImage);
                    break;
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
         * Focus next image in grid
         */
        focusNextImage($images, currentIndex) {
            const nextIndex = currentIndex + 1;
            if (nextIndex < $images.length) {
                $images.eq(nextIndex).focus();
            } else {
                // Wrap to first image
                $images.first().focus();
            }
        }

        /**
         * Focus previous image in grid
         */
        focusPreviousImage($images, currentIndex) {
            const prevIndex = currentIndex - 1;
            if (prevIndex >= 0) {
                $images.eq(prevIndex).focus();
            } else {
                // Wrap to last image
                $images.last().focus();
            }
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
            const altText = $img.attr('alt') || 'Catering image';

            const announcement = `${altText}, slide ${currentIndex} of ${totalSlides}`;
            // Use global announcer
            // Only announce if significantly different or if user navigated explicitly?
            // Usually focus announcement is handled by screen reader natively reading element content.
            // But if we want to add context like "slide X of Y", we can use aria-label update OR live region.
            // Updating aria-describedby is better than live region spam for focus.
            // However, previous implementation used live region. We will replace with simple console log or better yet, rely on ARIA.
            // Actually, let's usage the global announcer if it was deemed necessary before.
            // PromenAccessibility.announce(announcement); 
            // Better: update aria-label for the focused item dynamically or assume static aria-label is enough.
            // The previous code used explicit live region announcement.
            PromenAccessibility.announce(announcement);
        }

        /**
         * Announce image focus to screen readers
         */
        announceImageFocus(e) {
            const $image = $(e.currentTarget);
            const $container = $image.closest('.promen-catering-grid');
            const $images = $container.find('.promen-catering-image-wrapper');
            const currentIndex = $images.index($image) + 1;
            const totalImages = $images.length;
            const $img = $image.find('img');
            const altText = $img.attr('alt') || 'Catering image';

            const announcement = `${altText}, image ${currentIndex} of ${totalImages}`;
            PromenAccessibility.announce(announcement);
        }

        /**
         * Announce slide details
         */
        announceSlideDetails($slide) {
            const $img = $slide.find('img');
            const $title = $slide.find('.promen-catering-overlay-title');
            const $description = $slide.find('.promen-catering-overlay-description');

            let announcement = '';
            if ($title.length) {
                announcement += $title.text().trim();
            }
            if ($description.length) {
                announcement += ', ' + $description.text().trim();
            }
            if (announcement) {
                PromenAccessibility.announce(`Selected: ${announcement}`);
            }
        }

        /**
         * Announce image details
         */
        announceImageDetails($image) {
            const $img = $image.find('img');
            const $title = $image.find('.promen-catering-overlay-title');
            const $description = $image.find('.promen-catering-overlay-description');

            let announcement = '';
            if ($title.length) {
                announcement += $title.text().trim();
            }
            if ($description.length) {
                announcement += ', ' + $description.text().trim();
            }
            if (announcement) {
                PromenAccessibility.announce(`Selected: ${announcement}`);
            }
        }

        /**
         * Enhance keyboard navigation
         */
        enhanceKeyboardNavigation() {
            // Enhance slider slides
            $('.promen-business-catering-widget .swiper-slide').each(function () {
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
                            ${BusinessCateringAccessibility.getSliderKeyboardInstructions()}
                        </div>
                    `);
                }
            });

            // Enhance grid images
            $('.promen-business-catering-widget .promen-catering-image-wrapper').each(function () {
                const $image = $(this);

                // Ensure proper tabindex
                if (!$image.attr('tabindex')) {
                    $image.attr('tabindex', '0');
                }

                // Add keyboard navigation instructions
                $image.attr('aria-describedby', $image.attr('id') + '-instructions');

                // Add instructions element if not exists
                if (!$image.find('.keyboard-instructions').length) {
                    $image.append(`
                        <div class="keyboard-instructions screen-reader-text" 
                             id="${$image.attr('id')}-instructions">
                            ${BusinessCateringAccessibility.getGridKeyboardInstructions()}
                        </div>
                    `);
                }
            });
        }

        /**
         * Add screen reader support
         */
        addScreenReaderSupport() {
            // Add skip links if not exist
            $('.promen-business-catering-widget').each(function () {
                if (!$(this).find('.skip-link').length) {
                    $(this).prepend(`
                        <a href="#business-catering-content" class="skip-link">
                            ${BusinessCateringAccessibility.getSkipLinkText()}
                        </a>
                    `);
                }
            });
        }

        /**
         * Setup slider accessibility
         */
        setupSliderAccessibility() {
            $('.promen-business-catering-widget .swiper').each(function () {
                const $slider = $(this);
                const $slides = $slider.find('.swiper-slide');

                // Add slider instructions
                if (!$slider.find('.slider-instructions').length) {
                    $slider.prepend(`
                        <div class="slider-instructions screen-reader-text">
                            ${BusinessCateringAccessibility.getSliderInstructions()}
                        </div>
                    `);
                }

                // Enhance navigation buttons (Make them keyboard accessible)
                $slider.find('.swiper-button-prev, .swiper-button-next').each(function () {
                    const $button = $(this);
                    if (!$button.attr('type')) {
                        $button.attr('type', 'button');
                    }
                    PromenAccessibility.addKeyboardClick(this);
                });

                // Enhance pagination
                $slider.find('.swiper-pagination').each(function () {
                    const $pagination = $(this);
                    if (!$pagination.attr('role')) {
                        $pagination.attr('role', 'tablist');
                    }
                    if (!$pagination.attr('aria-label')) {
                        $pagination.attr('aria-label', 'Paginering om door verschillende catering afbeeldingen te navigeren');
                    }
                    // Enhance bullets
                    $pagination.find('.swiper-pagination-bullet').each(function () {
                        PromenAccessibility.addKeyboardClick(this);
                        $(this).attr('role', 'tab');
                    });
                });
            });
        }

        /**
         * Get slider keyboard navigation instructions
         */
        static getSliderKeyboardInstructions() {
            return 'Use arrow keys to navigate between slides. Press Enter or Space to get details.';
        }

        /**
         * Get grid keyboard navigation instructions
         */
        static getGridKeyboardInstructions() {
            return 'Use arrow keys to navigate between images. Press Enter or Space to get details.';
        }

        /**
         * Get skip link text
         */
        static getSkipLinkText() {
            return 'Sla over naar inhoud';
        }

        /**
         * Get slider instructions
         */
        static getSliderInstructions() {
            return 'This is a carousel of catering images. Use arrow keys to navigate between slides.';
        }
    }

    /**
     * Initialize when document is ready
     */
    $(document).ready(function () {
        if ($('.promen-business-catering-widget').length) {
            new BusinessCateringAccessibility();
        }
    });

    /**
     * Re-initialize on Elementor frontend updates
     */
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_business_catering.default', function ($scope) {
            new BusinessCateringAccessibility();
        });
    }

})(jQuery);