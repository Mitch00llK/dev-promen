/**
 * Hero Slider Accessibility Enhancements
 * WCAG 2.1/2.2 compliant slider functionality
 * 
 * Uses global PromenAccessibility core library.
 */

(function ($) {
    'use strict';

    const HeroSliderAccessibility = {

        init: function () {
            this.bindEvents();
            this.enhanceExistingSliders();
        },

        bindEvents: function () {
            // Initialize sliders when they become visible
            $(document).on('elementor/popup/show', this.initSliders.bind(this));
            $(window).on('load', this.initSliders.bind(this));

            // Handle keyboard navigation
            $(document).on('keydown', '.hero-slider-container', this.handleKeyboard.bind(this));

            // Handle play/pause button
            $(document).on('click', '.hero-slider-play-pause', this.togglePlayPause.bind(this));

            // Handle focus events
            $(document).on('focus', '.hero-slide', this.handleSlideFocus.bind(this));
        },

        initSliders: function () {
            $('.hero-slider-container').each(function () {
                const $container = $(this);
                if (!$container.data('accessibility-enhanced')) {
                    HeroSliderAccessibility.enhanceSlider($container);
                }
            });
        },

        enhanceExistingSliders: function () {
            // Wait for sliders to be initialized, then enhance them
            setTimeout(this.initSliders.bind(this), 1000);
            setTimeout(this.initSliders.bind(this), 3000);
        },

        enhanceSlider: function ($container) {
            const sliderId = $container.attr('id');
            if (!sliderId) return;

            $container.data('accessibility-enhanced', true);

            // Get slider instance
            let swiperInstance = null;
            const $swiper = $container.find('.swiper')[0];
            if ($swiper && $swiper.swiper) {
                swiperInstance = $swiper.swiper;
            }

            // If we have a swiper instance, enhance it
            if (swiperInstance) {
                this.enhanceSwiperAccessibility(swiperInstance, $container);
            } else {
                // Wait for swiper to initialize
                setTimeout(() => {
                    const $swiperRetry = $container.find('.swiper')[0];
                    if ($swiperRetry && $swiperRetry.swiper) {
                        this.enhanceSwiperAccessibility($swiperRetry.swiper, $container);
                    }
                }, 500);
            }

            // Setup autoplay controls (initial state)
            this.setupAutoplayControls($container);
        },

        enhanceSwiperAccessibility: function (swiper, $container) {
            // Disable swiper's built-in keyboard control to use our own
            if (swiper.keyboard) {
                swiper.keyboard.disable();
            }

            // Add slide change announcements
            swiper.on('slideChange', () => {
                this.announceSlideChange(swiper, $container);
            });

            // Pause autoplay on interaction
            swiper.on('touchStart', () => {
                if (swiper.autoplay && swiper.autoplay.running) {
                    swiper.autoplay.stop();
                }
            });

            // Make pagination bullets keyboard accessible
            this.makePaginationAccessible($container, swiper);
        },

        setupAutoplayControls: function ($container) {
            const $playPause = $container.find('.hero-slider-play-pause');
            if (!$playPause.length) return;

            // Check global reduced motion via CSS var or media query via generic check
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            const isAutoplay = $container.data('options') && $container.data('options').autoplay;
            // Stop autoplay if reduced motion is preferred
            if (prefersReducedMotion && isAutoplay) {
                const $swiper = $container.find('.swiper')[0];
                if ($swiper && $swiper.swiper && $swiper.swiper.autoplay) {
                    $swiper.swiper.autoplay.stop();
                }
                this.updatePlayPauseButton($playPause, false);
            } else {
                this.updatePlayPauseButton($playPause, isAutoplay);
            }
        },

        togglePlayPause: function () {
            const $button = $(this);
            const $container = $button.closest('.hero-slider-container');
            const $swiper = $container.find('.swiper')[0];
            const swiper = $swiper ? $swiper.swiper : null;

            if (!swiper || !swiper.autoplay) return;

            if (swiper.autoplay.running) {
                swiper.autoplay.stop();
                HeroSliderAccessibility.updatePlayPauseButton($button, false);
                PromenAccessibility.announce('Slideshow paused');
            } else {
                swiper.autoplay.start();
                HeroSliderAccessibility.updatePlayPauseButton($button, true);
                PromenAccessibility.announce('Slideshow playing');
            }
        },

        updatePlayPauseButton: function ($button, isPlaying) {
            const $playIcon = $button.find('.play-icon');
            const $pauseIcon = $button.find('.pause-icon');
            const $controlText = $button.find('.control-text');

            if (isPlaying) {
                $playIcon.show();
                $pauseIcon.hide();
                $button.attr('aria-pressed', 'true');
                $controlText.text('Pause slideshow');
                $button.attr('aria-label', 'Pause slideshow');
            } else {
                $playIcon.hide();
                $pauseIcon.show();
                $button.attr('aria-pressed', 'false');
                $controlText.text('Play slideshow');
                $button.attr('aria-label', 'Play slideshow');
            }
        },

        makePaginationAccessible: function ($container, swiper) {
            const $pagination = $container.find('.swiper-pagination');
            if (!$pagination.length) return;

            setTimeout(() => {
                $pagination.find('.swiper-pagination-bullet').each(function (index) {
                    const $bullet = $(this);
                    $bullet.attr('role', 'button') // Changed to button for better semantic fit here
                        .attr('aria-label', `Go to slide ${index + 1}`)
                        .attr('tabindex', $bullet.hasClass('swiper-pagination-bullet-active') ? '0' : '-1');
                });

                // Handle keyboard navigation in pagination
                $pagination.on('keydown', '.swiper-pagination-bullet', function (e) {
                    const $bullets = $pagination.find('.swiper-pagination-bullet');
                    const currentIndex = $bullets.index(this);
                    let targetIndex;

                    switch (e.key) {
                        case 'ArrowLeft':
                        case 'ArrowUp':
                            e.preventDefault();
                            targetIndex = currentIndex > 0 ? currentIndex - 1 : $bullets.length - 1;
                            $bullets.eq(targetIndex).focus().click();
                            break;

                        case 'ArrowRight':
                        case 'ArrowDown':
                            e.preventDefault();
                            targetIndex = currentIndex < $bullets.length - 1 ? currentIndex + 1 : 0;
                            $bullets.eq(targetIndex).focus().click();
                            break;

                        case 'Home':
                            e.preventDefault();
                            $bullets.first().focus().click();
                            break;

                        case 'End':
                            e.preventDefault();
                            $bullets.last().focus().click();
                            break;

                        case 'Enter':
                        case ' ':
                            e.preventDefault();
                            $(this).click();
                            break;
                    }
                });

                // Update bullet states on slide change
                swiper.on('slideChange', () => {
                    $pagination.find('.swiper-pagination-bullet').each(function (index) {
                        const $bullet = $(this);
                        const isActive = $bullet.hasClass('swiper-pagination-bullet-active');
                        $bullet.attr('tabindex', isActive ? '0' : '-1')
                            .attr('aria-selected', isActive ? 'true' : 'false');
                    });
                });
            }, 100);
        },

        announceSlideChange: function (swiper, $container, trigger = 'auto') {
            const activeIndex = swiper.activeIndex;
            const totalSlides = swiper.slides.length;
            const $activeSlide = $(swiper.slides[activeIndex]);

            let announcement = '';
            const $title = $activeSlide.find('.hero-slide-title');
            const title = $title.text().trim();

            announcement = `Slide ${activeIndex + 1} of ${totalSlides}${title ? ': ' + title : ''}`;

            if (trigger === 'navigation') {
                announcement = `Navigated to ${announcement}`;
            }

            PromenAccessibility.announce(announcement);
        },

        handleKeyboard: function (e) {
            const $container = $(e.currentTarget);

            // Only handle if container has focus or is focused within
            if (!$container.is(':focus') && !$container.find(':focus').length) {
                return;
            }

            const $swiper = $container.find('.swiper')[0];
            const swiper = $swiper ? $swiper.swiper : null;

            if (!swiper) return;

            switch (e.key) {
                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    swiper.slidePrev();
                    this.announceSlideChange(swiper, $container, 'navigation');
                    break;

                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    swiper.slideNext();
                    this.announceSlideChange(swiper, $container, 'navigation');
                    break;

                case 'Home':
                    e.preventDefault();
                    swiper.slideTo(0);
                    this.announceSlideChange(swiper, $container, 'navigation');
                    break;

                case 'End':
                    e.preventDefault();
                    swiper.slideTo(swiper.slides.length - 1);
                    this.announceSlideChange(swiper, $container, 'navigation');
                    break;

                case ' ': // Spacebar
                case 'Enter':
                    if ($(e.target).hasClass('hero-slider-play-pause')) {
                        break;
                    }
                    e.preventDefault();
                    this.togglePlayPause.call($container.find('.hero-slider-play-pause')[0]);
                    break;
            }
        },

        handleSlideFocus: function (e) {
            const $slide = $(e.currentTarget);
            const $container = $slide.closest('.hero-slider-container');

            // Pause autoplay when slide receives focus
            const $swiper = $container.find('.swiper')[0];
            const swiper = $swiper ? $swiper.swiper : null;

            if (swiper && swiper.autoplay && swiper.autoplay.running) {
                swiper.autoplay.stop();
                const $playPause = $container.find('.hero-slider-play-pause');
                this.updatePlayPauseButton($playPause, false);
                PromenAccessibility.announce('Slideshow paused on focus');
            }
        }
    };

    // Initialize when document is ready
    $(document).ready(function () {
        HeroSliderAccessibility.init();
    });

    // Make available globally
    window.HeroSliderAccessibility = HeroSliderAccessibility;

})(jQuery);