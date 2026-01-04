/**
 * Image Text Slider Accessibility Utilities
 * Contains all accessibility-related functionality for the slider
 */
(function (window) {
    "use strict";

    // Accessibility state tracking
    const accessibilityState = {
        reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
        highContrast: window.matchMedia('(prefers-contrast: high)').matches,
        currentAnnouncement: null
    };

    // Define the utility object
    const AccessibilityUtils = {
        /**
         * Announce content to screen readers
         */
        announceToScreenReader: function (message, priority = 'polite') {
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.announce(message, priority);
            }
        },

        /**
         * Set up keyboard navigation for slider
         */
        setupKeyboardNavigation: function (sliderEl, swiper) {
            if (!sliderEl || !swiper) return;

            // Make slider container focusable
            sliderEl.setAttribute('tabindex', '0');
            sliderEl.setAttribute('role', 'region');

            // Add keyboard event listener
            sliderEl.addEventListener('keydown', function (e) {
                if (!e.target.closest('.image-text-slider-container')) return;

                switch (e.key) {
                    case 'ArrowLeft':
                    case 'ArrowUp':
                        e.preventDefault();
                        swiper.slidePrev();
                        this.focus();
                        break;

                    case 'ArrowRight':
                    case 'ArrowDown':
                        e.preventDefault();
                        swiper.slideNext();
                        this.focus();
                        break;

                    case 'Home':
                        e.preventDefault();
                        swiper.slideTo(0);
                        this.focus();
                        break;

                    case 'End':
                        e.preventDefault();
                        if (swiper && swiper.slides) {
                            swiper.slideTo(swiper.slides.length - 1);
                        }
                        this.focus();
                        break;

                    case ' ':
                    case 'Enter':
                        e.preventDefault();
                        AccessibilityUtils.toggleAutoplay(sliderEl);
                        break;
                }
            });

            // Add focus indicators
            sliderEl.addEventListener('focus', function () {
                this.classList.add('keyboard-focused');
            });

            sliderEl.addEventListener('blur', function () {
                this.classList.remove('keyboard-focused');
            });
        },

        /**
         * Toggle autoplay with accessibility support
         */
        toggleAutoplay: function (sliderEl) {
            // Check for both possible swiper instance properties
            const swiper = sliderEl.swiper || sliderEl.imageSwiper;
            if (!swiper || !swiper.autoplay) {
                return;
            }

            const playButton = sliderEl.querySelector('.slider-play-pause');
            if (!playButton) {
                return;
            }

            // Check if autoplay is currently running
            const isRunning = swiper.autoplay.running;

            if (isRunning) {
                // Pause the autoplay
                swiper.autoplay.stop();
                playButton.classList.remove('active');
                playButton.setAttribute('aria-pressed', 'false');
                playButton.setAttribute('aria-label', playButton.getAttribute('data-play-label') || 'Start slideshow');
                playButton.setAttribute('title', playButton.getAttribute('data-tooltip-play') || 'Start slideshow');

                const playIcon = playButton.querySelector('.play-icon');
                const pauseIcon = playButton.querySelector('.pause-icon');
                const controlText = playButton.querySelector('.control-text');

                if (playIcon) playIcon.style.display = 'none';
                if (pauseIcon) pauseIcon.style.display = '';
                if (controlText) {
                    controlText.textContent = 'Start slideshow';
                }

                // Update stop button when paused (keep it visible)
                const stopButton = sliderEl.querySelector('.slider-stop');
                if (stopButton) {
                    stopButton.setAttribute('aria-pressed', 'true');
                    stopButton.setAttribute('aria-label', stopButton.getAttribute('data-tooltip-start') || 'Start slideshow');
                    stopButton.setAttribute('title', stopButton.getAttribute('data-tooltip-start') || 'Start slideshow');

                    const stopIcon = stopButton.querySelector('.stop-icon');
                    const startIcon = stopButton.querySelector('.start-icon');
                    const stopControlText = stopButton.querySelector('.control-text');

                    if (stopIcon) stopIcon.style.display = 'none';
                    if (startIcon) startIcon.style.display = '';
                    if (stopControlText) stopControlText.textContent = 'Start slideshow';
                }

                // Add paused visual indicator
                sliderEl.classList.add('autoplay-paused');
                sliderEl.classList.remove('autoplay-stopped');

                AccessibilityUtils.announceToScreenReader('Slideshow paused');
            } else {
                // Start or resume the autoplay
                // Ensure autoplay is configured if it wasn't initially
                if (!swiper.params.autoplay || swiper.params.autoplay === false) {
                    swiper.params.autoplay = {
                        delay: 5000,
                        disableOnInteraction: false
                    };
                }
                swiper.autoplay.start();

                playButton.classList.add('active');
                playButton.setAttribute('aria-pressed', 'true');
                playButton.setAttribute('aria-label', playButton.getAttribute('data-pause-label') || 'Pause slideshow');
                playButton.setAttribute('title', playButton.getAttribute('data-tooltip-pause') || 'Pauzeer slideshow');

                const playIcon = playButton.querySelector('.play-icon');
                const pauseIcon = playButton.querySelector('.pause-icon');
                const controlText = playButton.querySelector('.control-text');

                if (playIcon) playIcon.style.display = '';
                if (pauseIcon) pauseIcon.style.display = 'none';
                if (controlText) {
                    controlText.textContent = 'Pauzeer slideshow';
                }

                // Update stop button when playing
                const stopButton = sliderEl.querySelector('.slider-stop');
                if (stopButton) {
                    stopButton.setAttribute('aria-pressed', 'false');
                    stopButton.setAttribute('aria-label', stopButton.getAttribute('data-tooltip-stop') || 'Stop slideshow');
                    stopButton.setAttribute('title', stopButton.getAttribute('data-tooltip-stop') || 'Stop slideshow');

                    const stopIcon = stopButton.querySelector('.stop-icon');
                    const startIcon = stopButton.querySelector('.start-icon');
                    const stopControlText = stopButton.querySelector('.control-text');

                    if (stopIcon) stopIcon.style.display = '';
                    if (startIcon) startIcon.style.display = 'none';
                    if (stopControlText) stopControlText.textContent = 'Stop slideshow';
                }

                // Remove paused/stopped visual indicators
                sliderEl.classList.remove('autoplay-paused', 'autoplay-stopped');

                AccessibilityUtils.announceToScreenReader('Slideshow started');
            }
        },

        /**
         * Stop slideshow completely with accessibility support
         */
        stopSlideshow: function (sliderEl) {
            // Check for both possible swiper instance properties
            const swiper = sliderEl.swiper || sliderEl.imageSwiper;
            if (!swiper || !swiper.autoplay) return;

            const stopButton = sliderEl.querySelector('.slider-stop');
            if (!stopButton) return;

            // Check current state
            const isStopped = stopButton.getAttribute('aria-pressed') === 'true';

            if (isStopped) {
                // Currently stopped, so start the slideshow
                // Ensure autoplay is configured if it wasn't initially
                if (!swiper.params.autoplay || swiper.params.autoplay === false) {
                    swiper.params.autoplay = {
                        delay: 5000,
                        disableOnInteraction: false
                    };
                }
                swiper.autoplay.start();

                // Update stop button to show "stop" state
                stopButton.setAttribute('aria-pressed', 'false');
                stopButton.setAttribute('aria-label', stopButton.getAttribute('data-tooltip-stop') || 'Stop slideshow');
                stopButton.setAttribute('title', stopButton.getAttribute('data-tooltip-stop') || 'Stop slideshow');

                const stopIcon = stopButton.querySelector('.stop-icon');
                const startIcon = stopButton.querySelector('.start-icon');
                const controlText = stopButton.querySelector('.control-text');

                if (stopIcon) stopIcon.style.display = '';
                if (startIcon) startIcon.style.display = 'none';
                if (controlText) controlText.textContent = 'Stop slideshow';

                // Update play/pause button to show playing state
                const playButton = sliderEl.querySelector('.slider-play-pause');
                if (playButton) {
                    playButton.classList.add('active');
                    playButton.setAttribute('aria-pressed', 'true');
                    playButton.setAttribute('aria-label', playButton.getAttribute('data-pause-label') || 'Pause slideshow');
                    playButton.setAttribute('title', playButton.getAttribute('data-tooltip-pause') || 'Pauzeer slideshow');

                    const playIcon = playButton.querySelector('.play-icon');
                    const pauseIcon = playButton.querySelector('.pause-icon');
                    const playControlText = playButton.querySelector('.control-text');

                    if (playIcon) playIcon.style.display = '';
                    if (pauseIcon) pauseIcon.style.display = 'none';
                    if (playControlText) playControlText.textContent = 'Pauzeer slideshow';
                }

                // Remove stopped visual indicators
                sliderEl.classList.remove('autoplay-stopped', 'autoplay-paused');

                AccessibilityUtils.announceToScreenReader('Slideshow started');
            } else {
                // Currently running, so stop the slideshow
                swiper.autoplay.stop();

                // Update stop button to show "start" state
                stopButton.setAttribute('aria-pressed', 'true');
                stopButton.setAttribute('aria-label', stopButton.getAttribute('data-tooltip-start') || 'Start slideshow');
                stopButton.setAttribute('title', stopButton.getAttribute('data-tooltip-start') || 'Start slideshow');

                const stopIcon = stopButton.querySelector('.stop-icon');
                const startIcon = stopButton.querySelector('.start-icon');
                const controlText = stopButton.querySelector('.control-text');

                if (stopIcon) stopIcon.style.display = 'none';
                if (startIcon) startIcon.style.display = '';
                if (controlText) controlText.textContent = 'Start slideshow';

                // Update play/pause button to show stopped state
                const playButton = sliderEl.querySelector('.slider-play-pause');
                if (playButton) {
                    playButton.classList.remove('active');
                    playButton.setAttribute('aria-pressed', 'false');
                    playButton.setAttribute('aria-label', playButton.getAttribute('data-play-label') || 'Start slideshow');
                    playButton.setAttribute('title', playButton.getAttribute('data-tooltip-play') || 'Start slideshow');

                    const playIcon = playButton.querySelector('.play-icon');
                    const pauseIcon = playButton.querySelector('.pause-icon');
                    const playControlText = playButton.querySelector('.control-text');

                    if (playIcon) playIcon.style.display = 'none';
                    if (pauseIcon) pauseIcon.style.display = '';
                    if (playControlText) playControlText.textContent = 'Start slideshow';
                }

                // Add stopped visual indicator
                sliderEl.classList.add('autoplay-stopped');
                sliderEl.classList.remove('autoplay-paused');

                AccessibilityUtils.announceToScreenReader('Slideshow stopped');
            }
        },

        /**
         * Update slide announcements for screen readers
         */
        updateSlideAnnouncement: function (sliderEl, swiper) {
            if (!swiper || !swiper.slides) {
                return;
            }
            const currentIndex = swiper.realIndex !== undefined ? swiper.realIndex : swiper.activeIndex;
            const totalSlides = swiper.slides.length;
            const liveRegion = sliderEl.querySelector('[aria-live="polite"]');

            // Get current slide content for context
            const currentSlide = swiper.slides[swiper.activeIndex];
            let slideContent = '';

            if (currentSlide) {
                const title = currentSlide.querySelector('.slide-title');
                if (title) {
                    slideContent = title.textContent.trim();
                }
            }

            const announcement = slideContent ?
                `Slide ${currentIndex + 1} of ${totalSlides}: ${slideContent}` :
                `Slide ${currentIndex + 1} of ${totalSlides}`;

            if (liveRegion) {
                liveRegion.textContent = announcement;
            }

            // Update fraction indicator
            AccessibilityUtils.updateFractionIndicator(sliderEl, currentIndex, totalSlides);
        },

        /**
         * Update fraction indicator with current slide info
         */
        updateFractionIndicator: function (sliderEl, currentSlide, totalSlides) {
            const fractionIndicators = sliderEl.querySelectorAll('.slider-fraction-indicator, .slider-fraction-indicator-persistent');

            fractionIndicators.forEach(function (indicator) {
                const currentSlideSpan = indicator.querySelector('.current-slide');
                const totalSlidesSpan = indicator.querySelector('.total-slides');

                if (currentSlideSpan) {
                    currentSlideSpan.textContent = currentSlide + 1;
                }

                if (totalSlidesSpan) {
                    totalSlidesSpan.textContent = totalSlides;
                }
            });
        },

        /**
         * Manage focus during slide transitions
         */
        manageFocusDuringTransition: function (sliderEl) {
            const focusableElements = sliderEl.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );

            // Temporarily disable focus on interactive elements during transition
            focusableElements.forEach(el => {
                if (!el.closest('.slider-controls') && !el.closest('.image-text-slider-controls-persistent')) {
                    el.setAttribute('tabindex', '-1');
                    el.setAttribute('data-temp-disabled', 'true');
                }
            });

            // Re-enable after transition
            setTimeout(() => {
                focusableElements.forEach(el => {
                    if (el.getAttribute('data-temp-disabled') === 'true') {
                        el.removeAttribute('tabindex');
                        el.removeAttribute('data-temp-disabled');
                    }
                });
            }, 500);
        },

        /**
         * Setup accessible button controls
         */
        setupAccessibleControls: function (sliderEl, swiper) {
            // Use the passed swiper or find it from the element
            const swiperInstance = swiper || sliderEl.swiper || sliderEl.imageSwiper;
            // Play/pause button
            const playButton = sliderEl.querySelector('.slider-play-pause');
            if (playButton) {
                // Check if button already has event listeners to avoid resetting state
                if (playButton.hasAttribute('data-accessibility-setup')) {
                    return; // Already set up, don't reset the button state
                }

                // Set up event listeners without cloning to preserve state
                playButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    AccessibilityUtils.toggleAutoplay(sliderEl);
                });

                // Keyboard support for play/pause
                playButton.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        e.stopPropagation();
                        AccessibilityUtils.toggleAutoplay(sliderEl);
                    }
                });

                // Store labels for toggling
                playButton.setAttribute('data-play-label', 'Start slideshow');
                playButton.setAttribute('data-pause-label', 'Pause slideshow');

                // Mark as set up to prevent future resets
                playButton.setAttribute('data-accessibility-setup', 'true');
            } else { }

            // Stop button
            const stopButton = sliderEl.querySelector('.slider-stop');
            if (stopButton) {
                // Check if button already has event listeners to avoid resetting state
                if (stopButton.hasAttribute('data-accessibility-setup')) {
                    return; // Already set up, don't reset the button state
                }

                stopButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    AccessibilityUtils.stopSlideshow(sliderEl);
                });

                // Keyboard support for stop
                stopButton.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        AccessibilityUtils.stopSlideshow(sliderEl);
                    }
                });

                // Mark as set up to prevent future resets
                stopButton.setAttribute('data-accessibility-setup', 'true');
            }

            // Pause on hover/focus for better accessibility
            sliderEl.addEventListener('mouseenter', function () {
                if (swiperInstance && swiperInstance.autoplay && swiperInstance.autoplay.running) {
                    swiperInstance.autoplay.pause();
                    sliderEl.classList.add('hover-paused');
                }
            });

            sliderEl.addEventListener('mouseleave', function () {
                if (swiperInstance && swiperInstance.autoplay && sliderEl.classList.contains('hover-paused')) {
                    swiperInstance.autoplay.start();
                    sliderEl.classList.remove('hover-paused');
                }
            });

            // Pause on focus for keyboard users
            sliderEl.addEventListener('focusin', function () {
                if (swiperInstance && swiperInstance.autoplay && swiperInstance.autoplay.running) {
                    swiperInstance.autoplay.pause();
                    sliderEl.classList.add('focus-paused');
                }
            });

            sliderEl.addEventListener('focusout', function () {
                // Delay to check if focus moved to another element within slider
                setTimeout(() => {
                    if (!sliderEl.contains(document.activeElement)) {
                        if (swiperInstance && swiperInstance.autoplay && sliderEl.classList.contains('focus-paused')) {
                            swiperInstance.autoplay.start();
                            sliderEl.classList.remove('focus-paused');
                        }
                    }
                }, 100);
            });

            // Navigation arrows (now in controls container)
            const prevButton = sliderEl.querySelector('.slider-arrow-prev, .swiper-button-prev');
            const nextButton = sliderEl.querySelector('.slider-arrow-next, .swiper-button-next');

            if (prevButton) {
                prevButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    swiper.slidePrev();
                    sliderEl.focus(); // Return focus to slider
                });

                // Add keyboard support
                prevButton.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        swiper.slidePrev();
                        sliderEl.focus();
                    }
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    swiper.slideNext();
                    sliderEl.focus(); // Return focus to slider
                });

                // Add keyboard support
                nextButton.addEventListener('keydown', function (e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        swiper.slideNext();
                        sliderEl.focus();
                    }
                });
            }

            // Pagination bullets
            const pagination = sliderEl.querySelector('.swiper-pagination');
            if (pagination) {
                // Use MutationObserver to handle dynamically created bullets
                const observer = new MutationObserver(function (mutations) {
                    mutations.forEach(function (mutation) {
                        mutation.addedNodes.forEach(function (node) {
                            if (node.nodeType === Node.ELEMENT_NODE && node.classList.contains('swiper-pagination-bullet')) {
                                AccessibilityUtils.setupPaginationBullet(node, swiper);
                            }
                        });
                    });
                });

                observer.observe(pagination, { childList: true });

                // Setup existing bullets
                pagination.querySelectorAll('.swiper-pagination-bullet').forEach(bullet => {
                    AccessibilityUtils.setupPaginationBullet(bullet, swiper);
                });
            }
        },

        /**
         * Setup individual pagination bullet accessibility
         */
        setupPaginationBullet: function (bullet, swiper) {
            const index = Array.from(bullet.parentNode.children).indexOf(bullet);
            bullet.setAttribute('role', 'tab');
            bullet.setAttribute('aria-label', `Go to slide ${index + 1}`);
            bullet.setAttribute('tabindex', index === 0 ? '0' : '-1');

            bullet.addEventListener('click', function () {
                // Update tabindex for all bullets
                bullet.parentNode.querySelectorAll('.swiper-pagination-bullet').forEach((b, i) => {
                    b.setAttribute('tabindex', i === index ? '0' : '-1');
                });
            });

            bullet.addEventListener('keydown', function (e) {
                const bullets = Array.from(bullet.parentNode.children);
                const currentIndex = bullets.indexOf(bullet);

                switch (e.key) {
                    case 'ArrowLeft':
                    case 'ArrowUp':
                        e.preventDefault();
                        const prevIndex = currentIndex > 0 ? currentIndex - 1 : bullets.length - 1;
                        bullets[prevIndex].focus();
                        bullets[prevIndex].click();
                        break;

                    case 'ArrowRight':
                    case 'ArrowDown':
                        e.preventDefault();
                        const nextIndex = currentIndex < bullets.length - 1 ? currentIndex + 1 : 0;
                        bullets[nextIndex].focus();
                        bullets[nextIndex].click();
                        break;

                    case 'Home':
                        e.preventDefault();
                        bullets[0].focus();
                        bullets[0].click();
                        break;

                    case 'End':
                        e.preventDefault();
                        bullets[bullets.length - 1].focus();
                        bullets[bullets.length - 1].click();
                        break;
                }
            });
        },

        /**
         * Handle reduced motion preferences
         */
        handleReducedMotionPreference: function (options) {
            if (accessibilityState.reducedMotion) {
                // Disable autoplay for reduced motion
                options.autoplay = false;
                options.speed = 0;
                options.effect = 'fade';
                options.enableGsapAnimations = false;
            }

            return options;
        },

        /**
         * Check slide count and conditionally show/hide controls
         */
        checkSlideCountAndToggleControls: function (sliderEl, swiper) {
            if (!sliderEl || !swiper) return;

            const slideCount = swiper.slides ? swiper.slides.length : 0;
            const controlsContainer = sliderEl.querySelector('.image-text-slider-controls-persistent');
            const fractionIndicator = sliderEl.querySelector('.slider-fraction-indicator-persistent');

            // Show controls only if there are 3 or more slides
            if (slideCount >= 3) {
                if (controlsContainer) {
                    controlsContainer.style.display = '';
                    controlsContainer.setAttribute('aria-hidden', 'false');
                }
                if (fractionIndicator) {
                    fractionIndicator.style.display = '';
                    fractionIndicator.setAttribute('aria-hidden', 'false');
                }
            } else {
                // Hide controls if there are 2 or fewer slides
                if (controlsContainer) {
                    controlsContainer.style.display = 'none';
                    controlsContainer.setAttribute('aria-hidden', 'true');
                }
                if (fractionIndicator) {
                    fractionIndicator.style.display = 'none';
                    fractionIndicator.setAttribute('aria-hidden', 'true');
                }
            }
        },

        /**
         * Setup skip link
         */
        setupSkipLink: function (sliderEl) {
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.setupSkipLink(sliderEl, PromenAccessibility.getString('skipSlider'));
            }
        },

        /**
         * Initialize accessibility features for a slider
         */
        initSliderAccessibility: function (sliderEl, swiper, options) {
            if (!sliderEl || !swiper) return;

            // Check slide count and toggle controls visibility
            AccessibilityUtils.checkSlideCountAndToggleControls(sliderEl, swiper);

            // Setup skip link
            AccessibilityUtils.setupSkipLink(sliderEl);

            // Setup keyboard navigation
            AccessibilityUtils.setupKeyboardNavigation(sliderEl, swiper);

            // Setup accessible controls
            AccessibilityUtils.setupAccessibleControls(sliderEl, swiper);

            // Add slide change announcements
            swiper.on('slideChange', function () {
                AccessibilityUtils.updateSlideAnnouncement(sliderEl, this);
                AccessibilityUtils.manageFocusDuringTransition(sliderEl);
            });

            // Initial announcement and fraction indicator
            setTimeout(() => {
                AccessibilityUtils.updateSlideAnnouncement(sliderEl, swiper);
                if (swiper && swiper.slides) {
                    AccessibilityUtils.updateFractionIndicator(sliderEl, 0, swiper.slides.length);
                }
            }, 100);

            // Monitor accessibility preference changes
            const reducedMotionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
            reducedMotionQuery.addEventListener('change', function (e) {
                accessibilityState.reducedMotion = e.matches;
                if (e.matches && swiper.autoplay) {
                    swiper.autoplay.pause();
                    AccessibilityUtils.announceToScreenReader('Autoplay disabled due to motion preference');
                }
            });
        }
    };

    // Expose functionality to valid global namespace
    window.PromenAccessibilityUtils = AccessibilityUtils;

    // Global event listener for play/pause buttons as a fallback
    // Attached to document to handle dynamically added sliders
    if (!window.PromenAccessibilityListenersAttached) {
        document.addEventListener('click', function (e) {
            if (e.target.closest('.slider-play-pause')) {
                const button = e.target.closest('.slider-play-pause');
                const sliderEl = button.closest('.image-text-slider-container');
                if (sliderEl) {
                    e.preventDefault();
                    e.stopPropagation();
                    AccessibilityUtils.toggleAutoplay(sliderEl);
                }
            }

            // Also handle stop button clicks
            if (e.target.closest('.slider-stop')) {
                const button = e.target.closest('.slider-stop');
                const sliderEl = button.closest('.image-text-slider-container');
                if (sliderEl) {
                    e.preventDefault();
                    e.stopPropagation();
                    AccessibilityUtils.stopSlideshow(sliderEl);
                }
            }
        });
        window.PromenAccessibilityListenersAttached = true;
    }

})(window);
