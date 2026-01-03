/**
 * Image Text Slider JavaScript
 * Initializes Swiper with the appropriate settings and ensures proper synchronization
 * Now with mobile performance optimizations
 */
(function() {
    "use strict";

    // Performance optimizations
    const isMobile = window.innerWidth <= 768;
    const isLowEndDevice = navigator.hardwareConcurrency <= 2 ||
        navigator.deviceMemory <= 4 ||
        /Android.*4\.|iPhone.*OS [5-9]_/.test(navigator.userAgent);

    // Global instances tracker for performance monitoring
    window.imageTextSliderInstances = window.imageTextSliderInstances || new Map();

    // Accessibility state tracking
    const accessibilityState = {
        reducedMotion: window.matchMedia('(prefers-reduced-motion: reduce)').matches,
        highContrast: window.matchMedia('(prefers-contrast: high)').matches,
        currentAnnouncement: null
    };

    // Performance utilities
    const debounce = (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    const throttle = (func, limit) => {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };

    // Accessibility utilities
    const AccessibilityUtils = {
        /**
         * Announce content to screen readers
         */
        announceToScreenReader: function(message, priority = 'polite') {
            if (!message || accessibilityState.currentAnnouncement === message) return;

            accessibilityState.currentAnnouncement = message;

            const announcement = document.createElement('div');
            announcement.setAttribute('aria-live', priority);
            announcement.setAttribute('aria-atomic', 'true');
            announcement.className = 'sr-only';
            announcement.textContent = message;

            document.body.appendChild(announcement);

            setTimeout(() => {
                document.body.removeChild(announcement);
                if (accessibilityState.currentAnnouncement === message) {
                    accessibilityState.currentAnnouncement = null;
                }
            }, 1000);
        },

        /**
         * Set up keyboard navigation for slider
         */
        setupKeyboardNavigation: function(sliderEl, swiper) {
            if (!sliderEl || !swiper) return;

            // Make slider container focusable
            sliderEl.setAttribute('tabindex', '0');
            sliderEl.setAttribute('role', 'region');

            // Add keyboard event listener
            sliderEl.addEventListener('keydown', function(e) {
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
            sliderEl.addEventListener('focus', function() {
                this.classList.add('keyboard-focused');
            });

            sliderEl.addEventListener('blur', function() {
                this.classList.remove('keyboard-focused');
            });
        },

        /**
         * Toggle autoplay with accessibility support
         */
        toggleAutoplay: function(sliderEl) {
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
        stopSlideshow: function(sliderEl) {
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
        updateSlideAnnouncement: function(sliderEl, swiper) {
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
        updateFractionIndicator: function(sliderEl, currentSlide, totalSlides) {
            const fractionIndicators = sliderEl.querySelectorAll('.slider-fraction-indicator, .slider-fraction-indicator-persistent');

            fractionIndicators.forEach(function(indicator) {
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
        manageFocusDuringTransition: function(sliderEl) {
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
        setupAccessibleControls: function(sliderEl, swiper) {
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
                playButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    AccessibilityUtils.toggleAutoplay(sliderEl);
                });

                // Keyboard support for play/pause
                playButton.addEventListener('keydown', function(e) {
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
            } else {}

            // Stop button
            const stopButton = sliderEl.querySelector('.slider-stop');
            if (stopButton) {
                // Check if button already has event listeners to avoid resetting state
                if (stopButton.hasAttribute('data-accessibility-setup')) {
                    return; // Already set up, don't reset the button state
                }

                stopButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    AccessibilityUtils.stopSlideshow(sliderEl);
                });

                // Keyboard support for stop
                stopButton.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        AccessibilityUtils.stopSlideshow(sliderEl);
                    }
                });

                // Mark as set up to prevent future resets
                stopButton.setAttribute('data-accessibility-setup', 'true');
            }

            // Pause on hover/focus for better accessibility
            sliderEl.addEventListener('mouseenter', function() {
                if (swiperInstance && swiperInstance.autoplay && swiperInstance.autoplay.running) {
                    swiperInstance.autoplay.pause();
                    sliderEl.classList.add('hover-paused');
                }
            });

            sliderEl.addEventListener('mouseleave', function() {
                if (swiperInstance && swiperInstance.autoplay && sliderEl.classList.contains('hover-paused')) {
                    swiperInstance.autoplay.start();
                    sliderEl.classList.remove('hover-paused');
                }
            });

            // Pause on focus for keyboard users
            sliderEl.addEventListener('focusin', function() {
                if (swiperInstance && swiperInstance.autoplay && swiperInstance.autoplay.running) {
                    swiperInstance.autoplay.pause();
                    sliderEl.classList.add('focus-paused');
                }
            });

            sliderEl.addEventListener('focusout', function() {
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
                prevButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    swiper.slidePrev();
                    sliderEl.focus(); // Return focus to slider
                });

                // Add keyboard support
                prevButton.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        swiper.slidePrev();
                        sliderEl.focus();
                    }
                });
            }

            if (nextButton) {
                nextButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    swiper.slideNext();
                    sliderEl.focus(); // Return focus to slider
                });

                // Add keyboard support
                nextButton.addEventListener('keydown', function(e) {
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
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        mutation.addedNodes.forEach(function(node) {
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
        setupPaginationBullet: function(bullet, swiper) {
            const index = Array.from(bullet.parentNode.children).indexOf(bullet);
            bullet.setAttribute('role', 'tab');
            bullet.setAttribute('aria-label', `Go to slide ${index + 1}`);
            bullet.setAttribute('tabindex', index === 0 ? '0' : '-1');

            bullet.addEventListener('click', function() {
                // Update tabindex for all bullets
                bullet.parentNode.querySelectorAll('.swiper-pagination-bullet').forEach((b, i) => {
                    b.setAttribute('tabindex', i === index ? '0' : '-1');
                });
            });

            bullet.addEventListener('keydown', function(e) {
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
        handleReducedMotionPreference: function(options) {
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
        checkSlideCountAndToggleControls: function(sliderEl, swiper) {
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
         * Initialize accessibility features for a slider
         */
        initSliderAccessibility: function(sliderEl, swiper, options) {
            if (!sliderEl || !swiper) return;

            // Check slide count and toggle controls visibility
            AccessibilityUtils.checkSlideCountAndToggleControls(sliderEl, swiper);

            // Setup keyboard navigation
            AccessibilityUtils.setupKeyboardNavigation(sliderEl, swiper);

            // Setup accessible controls
            AccessibilityUtils.setupAccessibleControls(sliderEl, swiper);

            // Add slide change announcements
            swiper.on('slideChange', function() {
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
            reducedMotionQuery.addEventListener('change', function(e) {
                accessibilityState.reducedMotion = e.matches;
                if (e.matches && swiper.autoplay) {
                    swiper.autoplay.pause();
                    AccessibilityUtils.announceToScreenReader('Autoplay disabled due to motion preference');
                }
            });
        }
    };

    // Cross-browser compatibility layer
    const BrowserCompatibility = {
        /**
         * Detect browser and version
         */
        detectBrowser: function() {
            const ua = navigator.userAgent;
            let browser = {
                name: 'unknown',
                version: 0,
                isIE: false,
                isEdge: false,
                isChrome: false,
                isFirefox: false,
                isSafari: false,
                isMobile: /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(ua)
            };

            if (/MSIE|Trident/i.test(ua)) {
                browser.name = 'ie';
                browser.isIE = true;
                browser.version = parseInt((ua.match(/(?:MSIE |rv:)(\d+)/) || [])[1]) || 0;
            } else if (/Edg/i.test(ua)) {
                browser.name = 'edge';
                browser.isEdge = true;
                browser.version = parseInt((ua.match(/Edg\/(\d+)/) || [])[1]) || 0;
            } else if (/Chrome/i.test(ua) && !/Edg/i.test(ua)) {
                browser.name = 'chrome';
                browser.isChrome = true;
                browser.version = parseInt((ua.match(/Chrome\/(\d+)/) || [])[1]) || 0;
            } else if (/Firefox/i.test(ua)) {
                browser.name = 'firefox';
                browser.isFirefox = true;
                browser.version = parseInt((ua.match(/Firefox\/(\d+)/) || [])[1]) || 0;
            } else if (/Safari/i.test(ua) && !/Chrome/i.test(ua)) {
                browser.name = 'safari';
                browser.isSafari = true;
                browser.version = parseInt((ua.match(/Version\/(\d+)/) || [])[1]) || 0;
            }

            return browser;
        },

        /**
         * Apply browser-specific fixes
         */
        applyBrowserFixes: function(sliderEl, options) {
            const browser = this.detectBrowser();
            document.body.classList.add(`browser-${browser.name}`);

            // IE/Edge specific fixes
            if (browser.isIE || (browser.isEdge && browser.version < 79)) {
                this.applyIEEdgeFixes(sliderEl, options);
            }

            // Safari specific fixes
            if (browser.isSafari) {
                this.applySafariFixes(sliderEl, options);
            }

            // Firefox specific fixes
            if (browser.isFirefox) {
                this.applyFirefoxFixes(sliderEl, options);
            }

            // Mobile browser fixes
            if (browser.isMobile) {
                this.applyMobileFixes(sliderEl, options);
            }

            return options;
        },

        /**
         * IE/Edge compatibility fixes
         */
        applyIEEdgeFixes: function(sliderEl, options) {
            // Disable CSS Grid fallback
            sliderEl.classList.add('ie-edge-mode');

            // Force fade effect for better performance
            options.effect = 'fade';
            options.enableGsapAnimations = false;

            // Add polyfills for missing methods
            if (!Element.prototype.closest) {
                Element.prototype.closest = function(selector) {
                    let el = this;
                    while (el && el.nodeType === 1) {
                        if (el.matches(selector)) return el;
                        el = el.parentNode;
                    }
                    return null;
                };
            }

            if (!Element.prototype.matches) {
                Element.prototype.matches = Element.prototype.msMatchesSelector;
            }

            // Fix focus outline issues
            const style = document.createElement('style');
            style.textContent = `
                .image-text-slider-container.keyboard-focused {
                    outline: 2px solid #005fcc !important;
                    outline-offset: 2px !important;
                }
                .image-text-slider-container button:focus {
                    outline: 2px solid #005fcc !important;
                }
            `;
            document.head.appendChild(style);
        },

        /**
         * Safari specific fixes
         */
        applySafariFixes: function(sliderEl, options) {
            sliderEl.classList.add('safari-mode');

            // Safari has issues with transforms during transitions
            if (options.effect === 'slide') {
                options.speed = Math.max(options.speed || 500, 300);
            }

            // Fix Safari's aggressive resource management
            const images = sliderEl.querySelectorAll('img');
            images.forEach(img => {
                img.setAttribute('loading', 'eager');
                // Prevent Safari from unloading images
                img.style.willChange = 'auto';
            });

            // Safari accessibility improvements
            const style = document.createElement('style');
            style.textContent = `
                @media screen and (-webkit-min-device-pixel-ratio: 2) {
                    .image-text-slider-container.keyboard-focused {
                        outline: 3px solid #005fcc !important;
                        outline-offset: 2px !important;
                    }
                }
                .image-text-slider-container button {
                    -webkit-appearance: none;
                    border-radius: 4px;
                }
            `;
            document.head.appendChild(style);
        },

        /**
         * Firefox specific fixes
         */
        applyFirefoxFixes: function(sliderEl, options) {
            sliderEl.classList.add('firefox-mode');

            // Firefox has better support for CSS transforms
            if (options.effect === 'fade') {
                options.fadeEffect = {
                    crossFade: true
                };
            }

            // Firefox focus improvements
            const style = document.createElement('style');
            style.textContent = `
                .image-text-slider-container.keyboard-focused {
                    outline: 2px solid -moz-mac-focusring !important;
                    outline-offset: 2px !important;
                }
                .image-text-slider-container button::-moz-focus-inner {
                    border: 0;
                }
                .image-text-slider-container button:focus {
                    outline: 2px solid -moz-mac-focusring !important;
                    outline-offset: 1px !important;
                }
            `;
            document.head.appendChild(style);
        },

        /**
         * Mobile browser fixes
         */
        applyMobileFixes: function(sliderEl, options) {
            sliderEl.classList.add('mobile-browser');

            // Optimize touch handling
            options.touchRatio = 1.2;
            options.touchAngle = 35;
            options.longSwipesRatio = 0.3;
            options.threshold = 5;

            // Improve mobile performance
            options.watchSlidesProgress = false;
            options.observer = false;
            options.observeParents = false;

            // Mobile-specific accessibility
            const style = document.createElement('style');
            style.textContent = `
                .image-text-slider-container.mobile-browser button {
                    min-height: 44px;
                    min-width: 44px;
                    padding: 12px;
                }
                .image-text-slider-container.mobile-browser .swiper-pagination-bullet {
                    width: 44px;
                    height: 44px;
                    margin: 0 8px;
                }
                @media (hover: none) and (pointer: coarse) {
                    .image-text-slider-container.keyboard-focused {
                        outline: 3px solid #005fcc !important;
                        outline-offset: 3px !important;
                    }
                }
            `;
            document.head.appendChild(style);
        },

        /**
         * Add ARIA polyfills for older browsers
         */
        addAriaPolyfills: function() {
            // Check if ARIA is supported
            if (!('ariaLabel' in document.createElement('div'))) {
                // Add basic ARIA support for older browsers
                const script = document.createElement('script');
                script.textContent = `
                    (function() {
                        var proto = Element.prototype;
                        if (!proto.setAttribute.ariaSafe) {
                            var original = proto.setAttribute;
                            proto.setAttribute = function(name, value) {
                                if (name && name.indexOf('aria-') === 0) {
                                    this[name.replace(/-([a-z])/g, function(m, l) { 
                                        return l.toUpperCase(); 
                                    })] = value;
                                }
                                return original.call(this, name, value);
                            };
                            proto.setAttribute.ariaSafe = true;
                        }
                    })();
                `;
                document.head.appendChild(script);
            }
        },

        /**
         * Feature detection and progressive enhancement
         */
        detectFeatures: function() {
            const features = {
                intersectionObserver: 'IntersectionObserver' in window,
                resizeObserver: 'ResizeObserver' in window,
                customProperties: CSS.supports('color', 'var(--test)'),
                grid: CSS.supports('display', 'grid'),
                flexbox: CSS.supports('display', 'flex'),
                transform3d: (function() {
                    const el = document.createElement('div');
                    el.style.transform = 'translate3d(1px,1px,1px)';
                    return el.style.transform !== '';
                })(),
                touchEvents: 'ontouchstart' in window,
                pointerEvents: 'onpointerdown' in window
            };

            // Add feature classes to document
            Object.keys(features).forEach(feature => {
                document.documentElement.classList.add(
                    features[feature] ? `has-${feature}` : `no-${feature}`
                );
            });

            return features;
        },

        /**
         * Initialize browser compatibility
         */
        init: function() {
            const browser = this.detectBrowser();
            const features = this.detectFeatures();

            // Add browser class to document
            document.documentElement.classList.add(`browser-${browser.name}`);

            // Add ARIA polyfills if needed
            this.addAriaPolyfills();

            // Store browser info globally for access by other functions
            window.browserInfo = browser;
            window.browserFeatures = features;

            return { browser, features };
        }
    };

    // Global event listener for play/pause buttons as a fallback
    document.addEventListener('click', function(e) {
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

    document.addEventListener('DOMContentLoaded', function() {
        // Initialize browser compatibility
        const { browser, features } = BrowserCompatibility.init();

        // Check if we're in Elementor editor
        const isElementorEditor = document.body.classList.contains('elementor-editor-active');

        // Initialize sliders for both editor and frontend
        if (!isElementorEditor) {
            // Delayed initialization for better page load performance on frontend
            const initDelay = isMobile ? 300 : 100;
            setTimeout(initImageTextSliders, initDelay);
        } else {
            // In editor mode, initialize sliders with basic functionality
            setTimeout(initEditorSliders, 200);
        }

        // Handle resize events to ensure proper spacing (debounced for performance)
        window.addEventListener('resize', debounce(handleSliderResize, 250));

        // Handle scroll events to ensure proper positioning (throttled for mobile)
        if (isMobile) {
            const throttle = (func, limit) => {
                let inThrottle;
                return function() {
                    if (!inThrottle) {
                        func.apply(this, arguments);
                        inThrottle = true;
                        setTimeout(() => inThrottle = false, limit);
                    }
                }
            };
            window.addEventListener('scroll', throttle(handleSliderScroll, 200), { passive: true });
        } else {
            window.addEventListener('scroll', handleSliderScroll, { passive: true });
        }

        // Initial positioning of the spacer
        setTimeout(positionSliderSpacers, 100);

        // Add a more comprehensive resize handler that prevents overlap issues
        addComprehensiveResizeHandler();

        // Apply static alignment for content slides
        setTimeout(ensureStaticContentAlignment, 300);

        // Check if elementorFrontend and hooks are available
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            // Reinitialize sliders when Elementor frontend is initialized
            elementorFrontend.hooks.addAction('frontend/element_ready/image_text_slider.default', function($scope) {
                if (!isElementorEditor) {
                    initImageTextSlider($scope.find('.image-text-slider-container')[0]);
                } else {
                    initImageTextSliderForEditor($scope.find('.image-text-slider-container')[0]);
                }

                // Handle breadcrumb visibility in the editor
                if (window.elementor && window.elementorFrontend.isEditMode()) {
                    const widget = $scope.data('model-cid');

                    if (widget) {
                        // Listen for changes to the breadcrumb settings
                        elementor.channels.editor.on('change', function(view) {
                            const changedWidget = view.model.cid;

                            // Only proceed if this is our widget
                            if (changedWidget !== widget) {
                                return;
                            }

                            // Get the changed control name
                            const changedControlName = view.model.get('name');

                            // If the breadcrumb visibility or position control changed
                            if (changedControlName === 'show_breadcrumb' || changedControlName === 'breadcrumb_position') {
                                // Re-render the widget
                                window.elementor.reloadPreview();
                            }
                        });
                    }
                }
            });

            // Additional handling for editor mode
            if (window.elementorFrontend.isEditMode()) {
                // Initialize on section/column changes in Elementor editor
                elementorFrontend.hooks.addAction('frontend/element_ready/section', function() {
                    setTimeout(function() {
                        initEditorSliders();
                    }, 100);
                });

                elementorFrontend.hooks.addAction('frontend/element_ready/column', function() {
                    setTimeout(function() {
                        initEditorSliders();
                    }, 100);
                });

                // Initialize when panel is opened
                if (window.elementor && window.elementor.hooks) {
                    window.elementor.hooks.addAction('panel/open_editor/widget', function() {
                        setTimeout(function() {
                            initEditorSliders();
                        }, 100);
                    });
                }

                // Initialize on any preview reload
                document.addEventListener('elementor/popup/show', function() {
                    setTimeout(function() {
                        initEditorSliders();
                    }, 50);
                });

                // Handle spacing control changes
                if (window.elementor && window.elementor.channels) {
                    elementor.channels.editor.on('change', function(view) {
                        const changedControlName = view.model.get('name');

                        // Update visual spacing indicator when margin control changes
                        if (changedControlName === 'slider_container_margin_bottom') {
                            setTimeout(function() {
                                updateEditorSpacingIndicators();
                            }, 100);
                        }
                    });
                }
            }

            // Add resize handler when elements are ready
            elementorFrontend.hooks.addAction('frontend/element_ready/global', function() {
                setTimeout(positionSliderSpacers, 100);
            });
        } else {
            // If elementorFrontend hooks are not available, initialize sliders directly
            // This ensures that sliders will work even if Elementor hooks are not loaded
            setTimeout(function() {
                initImageTextSliders();
                positionSliderSpacers();
            }, 300);
        }

        // Force hide inactive content slides on initial load
        setTimeout(forceHideInactiveContentSlides, 100);
        // And again after a longer delay to catch any late rendering
        setTimeout(forceHideInactiveContentSlides, 500);
        // And again after full page load
        window.addEventListener('load', () => {
            forceHideInactiveContentSlides();
            setTimeout(forceHideInactiveContentSlides, 200);
        });

        // Performance monitoring for mobile
        if (isMobile) {
            // Monitor performance and adjust if needed
            setTimeout(monitorPerformance, 2000);
            setInterval(monitorPerformance, 10000); // Check every 10 seconds
        }
    });

    /**
     * Adds a comprehensive resize handler to prevent container overflow issues
     */
    function addComprehensiveResizeHandler() {
        // Track the last window width to detect actual size changes
        let lastWidth = window.innerWidth;

        // Create a resize observer to watch for container changes
        if ('ResizeObserver' in window) {
            const resizeObserver = new ResizeObserver((entries) => {
                // When any observed element changes size, reposition spacers
                positionSliderSpacers();
                // Add clear spacing after sliders
                ensureProperSpacingAfterSliders();
            });

            // Observe all slider containers
            document.querySelectorAll('.image-text-slider-container').forEach(slider => {
                resizeObserver.observe(slider);

                // Also observe the next element to ensure proper spacing
                if (slider.nextElementSibling) {
                    resizeObserver.observe(slider.nextElementSibling);
                }
            });
        }

        // Enhanced resize handler with debounce
        window.addEventListener('resize', () => {
            // Only process if width actually changed (height changes don't cause overlap issues as much)
            if (window.innerWidth !== lastWidth) {
                lastWidth = window.innerWidth;

                // Clear any existing timeout
                clearTimeout(window.sliderComprehensiveResizeTimer);

                // Set timeout for debounce
                window.sliderComprehensiveResizeTimer = setTimeout(() => {
                    positionSliderSpacers();
                    ensureProperSpacingAfterSliders();

                    // Force a small shift in layout to trigger proper recalculation
                    document.querySelectorAll('.image-text-slider-container').forEach(slider => {
                        // Temporarily add 1px to force layout recalculation
                        const currentHeight = slider.style.height;
                        slider.style.height = (parseInt(getComputedStyle(slider).height) + 1) + 'px';

                        // Reset back after a small delay
                        setTimeout(() => {
                            slider.style.height = currentHeight;
                        }, 50);
                    });
                }, 250);
            }
        });
    }

    /**
     * Ensure proper spacing after sliders to prevent container overflow
     */
    function ensureProperSpacingAfterSliders() {
        document.querySelectorAll('.image-text-slider-container').forEach(slider => {
            // Create or get the spacer element
            let spacer = slider.nextElementSibling;
            if (!spacer || !spacer.classList.contains('slider-bottom-spacer')) {
                // Create spacer if it doesn't exist
                spacer = document.createElement('div');
                spacer.classList.add('slider-bottom-spacer');
                // Insert after slider
                if (slider.nextElementSibling) {
                    slider.parentNode.insertBefore(spacer, slider.nextElementSibling);
                } else {
                    slider.parentNode.appendChild(spacer);
                }
            }

            // Get the slider height including any extended overlays
            const sliderRect = slider.getBoundingClientRect();
            const sliderHeight = sliderRect.height;

            // Find any overlay elements that might extend beyond
            const extendedOverlays = slider.querySelectorAll('.absolute-overlay-image.extend-beyond');
            let maxExtension = 0;

            extendedOverlays.forEach(overlay => {
                if (overlay.classList.contains('position-bottom-left') ||
                    overlay.classList.contains('position-bottom-center') ||
                    overlay.classList.contains('position-bottom-right')) {
                    const overlayRect = overlay.getBoundingClientRect();
                    const extension = (overlayRect.bottom - sliderRect.bottom);
                    maxExtension = Math.max(maxExtension, extension);
                }
            });

            // Apply appropriate height to the spacer
            spacer.style.height = (maxExtension + 1) + 'px';
        });
    }

    /**
     * Handle scroll events for sliders
     */
    function handleSliderScroll() {
        // Debounce the scroll handler
        clearTimeout(window.sliderScrollTimer);
        window.sliderScrollTimer = setTimeout(() => {
            ensureProperSpacingAfterSliders();
        }, 200);
    }

    /**
     * Position the bottom spacers for all sliders
     */
    function positionSliderSpacers() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function(slider) {
            const spacer = slider.nextElementSibling;

            // Create spacer if it doesn't exist
            if (!spacer || !spacer.classList.contains('slider-bottom-spacer')) {
                const newSpacer = document.createElement('div');
                newSpacer.classList.add('slider-bottom-spacer');

                if (slider.nextElementSibling) {
                    slider.parentNode.insertBefore(newSpacer, slider.nextElementSibling);
                } else {
                    slider.parentNode.appendChild(newSpacer);
                }

                updateSpacerPosition(slider, newSpacer);
            } else if (spacer) {
                updateSpacerPosition(slider, spacer);
            }

            // Force the next element to have proper z-index
            if (spacer && spacer.nextElementSibling) {
                spacer.nextElementSibling.style.position = 'relative';
                spacer.nextElementSibling.style.zIndex = '0';
            }
        });
    }

    /**
     * Update the spacer position for a specific slider
     * @param {HTMLElement} slider - The slider container
     * @param {HTMLElement} spacer - The spacer element
     */
    function updateSpacerPosition(slider, spacer) {
        if (!slider || !spacer) return;

        // Get the slider height
        const sliderHeight = slider.offsetHeight;

        // Check if the slider has extended overlays
        const hasExtendedOverlays = slider.classList.contains('has-extended-overlays');

        // Set spacer position
        spacer.style.position = 'relative';
        spacer.style.zIndex = '1';
        spacer.style.marginTop = hasExtendedOverlays ? '0' : '-1px';

        // Add a small delay for overlays to settle
        setTimeout(() => {
            // Find any absolute overlay images that extend beyond
            const extendingOverlays = slider.querySelectorAll('.absolute-overlay-image.extend-beyond');
            let maxExtension = 0;

            // Calculate maximum extension
            extendingOverlays.forEach(overlay => {
                if (overlay.classList.contains('position-bottom-left') ||
                    overlay.classList.contains('position-bottom-center') ||
                    overlay.classList.contains('position-bottom-right')) {
                    const overlayRect = overlay.getBoundingClientRect();
                    const sliderRect = slider.getBoundingClientRect();
                    const extension = (overlayRect.bottom - sliderRect.bottom);
                    if (extension > maxExtension) {
                        maxExtension = extension;
                    }
                }
            });

            // Apply max extension as padding if needed
            if (maxExtension > 0) {
                slider.style.paddingBottom = maxExtension + 'px';
            }
        }, 200);
    }

    /**
     * Handle resize events for all sliders
     */
    function handleSliderResize() {
        // Debounce the resize handler
        clearTimeout(window.sliderResizeTimer);
        window.sliderResizeTimer = setTimeout(() => {
            positionSliderSpacers();
            ensureProperSpacingAfterSliders();

            // Reapply static content alignment
            ensureStaticContentAlignment();

            // Force container below to redraw
            document.querySelectorAll('.image-text-slider-container').forEach(slider => {
                if (slider.nextElementSibling && slider.nextElementSibling.nextElementSibling) {
                    const elem = slider.nextElementSibling.nextElementSibling;
                    const display = elem.style.display;
                    elem.style.display = 'none';
                    void elem.offsetHeight; // Force reflow
                    elem.style.display = display;
                }
            });
        }, 150);
    }

    /**
     * Initialize sliders specifically for editor mode
     */
    function initEditorSliders() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function(slider) {
            initImageTextSliderForEditor(slider);
        });

        // Ensure proper spacer positioning in editor
        positionSliderSpacers();

        // Update spacing indicators
        setTimeout(function() {
            updateEditorSpacingIndicators();
        }, 200);
    }

    /**
     * Initialize a single slider for editor mode with basic functionality
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function initImageTextSliderForEditor(sliderEl) {
        if (!sliderEl || typeof Swiper === 'undefined') {
            setupEditorSlider(sliderEl);
            return;
        }

        // Check if already initialized to prevent conflicts
        if (sliderEl.classList.contains('editor-initialized')) {
            return;
        }

        // If slider already initialized, destroy it first
        if (sliderEl.swiper) {
            sliderEl.swiper.destroy(true, true);
            sliderEl.swiper = null;
        }

        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.destroy(true, true);
            sliderEl.contentSwiper = null;
        }

        // Mark as initialized
        sliderEl.classList.add('editor-initialized');

        // Get slider options from data attribute
        let options = {};
        try {
            options = JSON.parse(sliderEl.getAttribute('data-options')) || {};
        } catch (e) {
            // Error parsing slider options
        }

        // Editor-specific settings (simpler configuration)
        const editorOptions = {
            ...options,
            autoplay: false, // Disable autoplay in editor
            enableGsapAnimations: false, // Disable animations in editor
            speed: 300 // Faster transitions for better UX in editor
        };

        // Get slide count for proper initialization
        const slideCount = sliderEl.querySelectorAll('.swiper .swiper-slide').length;
        const useLoop = slideCount > 1;

        // Store reference for content swiper to be used in callbacks
        let contentSwiper = null;

        // Initialize main image slider with basic settings
        try {
            const swiper = new Swiper(sliderEl.querySelector('.swiper'), {
                slidesPerView: 1,
                effect: 'slide', // Use slide effect for better editor performance
                speed: editorOptions.speed,
                loop: useLoop,
                loopedSlides: useLoop ? slideCount : null, // Ensure proper loop handling
                autoplay: false,
                preventInteractionOnTransition: true,
                pagination: sliderEl.querySelector('.swiper-pagination') ? {
                    el: sliderEl.querySelector('.swiper-pagination'),
                    clickable: true,
                    type: 'bullets'
                } : false,
                navigation: {
                    nextEl: sliderEl.querySelector('.swiper-button-next'),
                    prevEl: sliderEl.querySelector('.swiper-button-prev'),
                },
                allowTouchMove: true,
                grabCursor: true,
                on: {
                    init: function() {},
                    slideChange: function() {
                        // Sync content slider if available - use proper index handling
                        if (contentSwiper && typeof contentSwiper.slideTo === 'function') {
                            const targetIndex = useLoop ? this.realIndex : this.activeIndex;

                            if (useLoop) {
                                contentSwiper.slideToLoop(targetIndex, 0, false);
                            } else {
                                contentSwiper.slideTo(targetIndex, 0, false);
                            }

                        }
                    }
                }
            });

            // Initialize content slider with matching settings
            contentSwiper = new Swiper(sliderEl.querySelector('.swiper-content-slider'), {
                slidesPerView: 1,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 0, // Instant transitions for content
                allowTouchMove: false,
                loop: useLoop,
                loopedSlides: useLoop ? slideCount : null, // Match main swiper settings
                preventInteractionOnTransition: true,
                on: {
                    init: function() {

                        // Set initial slide to match main swiper
                        const initialIndex = useLoop ? swiper.realIndex : swiper.activeIndex;
                        if (useLoop) {
                            this.slideToLoop(initialIndex, 0, false);
                        } else {
                            this.slideTo(initialIndex, 0, false);
                        }
                    }
                }
            });

            // Store swiper instances
            sliderEl.swiper = swiper;
            sliderEl.contentSwiper = contentSwiper;

            // Check slide count and toggle controls visibility for editor
            AccessibilityUtils.checkSlideCountAndToggleControls(sliderEl, swiper);

            // Ensure initial synchronization after both sliders are ready
            setTimeout(function() {
                if (swiper && contentSwiper) {
                    const initialIndex = useLoop ? swiper.realIndex : swiper.activeIndex;

                    if (useLoop) {
                        contentSwiper.slideToLoop(initialIndex, 0, false);
                    } else {
                        contentSwiper.slideTo(initialIndex, 0, false);
                    }
                }
            }, 50);

            // Add navigation event handlers with better error handling
            const prevBtns = sliderEl.querySelectorAll('.swiper-button-prev');
            const nextBtns = sliderEl.querySelectorAll('.swiper-button-next');

            prevBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (swiper && typeof swiper.slidePrev === 'function') {
                        swiper.slidePrev();
                    }
                });
            });

            nextBtns.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (swiper && typeof swiper.slideNext === 'function') {
                        swiper.slideNext();
                    }
                });
            });

        } catch (error) {

            // Clean up on error
            sliderEl.classList.remove('editor-initialized');

            if (sliderEl.swiper) {
                sliderEl.swiper.destroy(true, true);
                sliderEl.swiper = null;
            }

            if (sliderEl.contentSwiper) {
                sliderEl.contentSwiper.destroy(true, true);
                sliderEl.contentSwiper = null;
            }

            // Fallback to static display
            setupEditorSlider(sliderEl);
        }
    }

    /**
     * Update visual spacing indicators in the editor
     */
    function updateEditorSpacingIndicators() {
        if (!window.elementorFrontend.isEditMode()) return;

        const sliderWidgets = document.querySelectorAll('.elementor-widget-image_text_slider');

        sliderWidgets.forEach(function(widget) {
            const spacingIndicator = widget.querySelector('.editor-spacing-indicator');
            if (!spacingIndicator) return;

            // Get the computed margin-bottom from the widget
            const computedStyle = window.getComputedStyle(widget);
            const marginBottom = computedStyle.marginBottom;

            if (marginBottom && marginBottom !== '0px') {
                // Update the indicator to show the current margin value
                const marginValue = parseInt(marginBottom, 10);
                const span = spacingIndicator.querySelector('span');
                if (span) {
                    span.textContent = `Bottom Spacing Area (${marginValue}px)`;
                }

            }
        });
    }

    /**
     * Reset editor slider initialization (useful for debugging)
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function resetEditorSlider(sliderEl) {
        if (!sliderEl) return;


        // Remove initialization flag
        sliderEl.classList.remove('editor-initialized');

        // Destroy existing instances
        if (sliderEl.swiper) {
            sliderEl.swiper.destroy(true, true);
            sliderEl.swiper = null;
        }

        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.destroy(true, true);
            sliderEl.contentSwiper = null;
        }

        // Re-initialize
        setTimeout(function() {
            initImageTextSliderForEditor(sliderEl);
        }, 100);
    }

    /**
     * Sets up editor view for all sliders
     */
    function setupEditorView() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function(slider) {
            setupEditorSlider(slider);
        });

        // Ensure proper spacer positioning in editor
        positionSliderSpacers();
    }

    /**
     * Sets up editor view for a single slider
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function setupEditorSlider(sliderEl) {
        if (!sliderEl) return;

        // Show first slide and its content in editor
        const slides = sliderEl.querySelectorAll('.swiper-slide');
        const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');

        // Make sure first slides are visible and have higher z-index
        if (slides.length > 0) {
            slides[0].style.zIndex = '2';
            slides[0].style.opacity = '1';
            slides[0].style.visibility = 'visible';

            // Add active class to first slide for proper styling
            slides[0].classList.add('swiper-slide-active');
        }

        if (contentSlides.length > 0) {
            contentSlides[0].style.zIndex = '2';
            contentSlides[0].style.opacity = '1';
            contentSlides[0].style.visibility = 'visible';

            // Add active class to first content slide for proper styling
            contentSlides[0].classList.add('swiper-slide-active');
        }

        // Check slide count and toggle controls visibility for static editor view
        const slideCount = slides.length;
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
    }

    /**
     * Initialize all image text sliders on the page
     */
    function initImageTextSliders() {
        const sliders = document.querySelectorAll('.image-text-slider-container');
        sliders.forEach(function(slider) {
            initImageTextSlider(slider);
        });
    }

    /**
     * Initialize a single slider with Swiper
     * @param {HTMLElement} sliderEl - The slider container element
     */
    function initImageTextSlider(sliderEl) {
        if (!sliderEl || typeof Swiper === 'undefined') {
            return;
        }

        // If slider already initialized, destroy it first
        if (sliderEl.swiper) {
            sliderEl.swiper.destroy(true, true);
        }

        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.destroy(true, true);
        }

        // Get slider options from data attribute with mobile optimizations
        let options = {};
        try {
            options = JSON.parse(sliderEl.getAttribute('data-options')) || {};

            // Apply accessibility preferences
            options = AccessibilityUtils.handleReducedMotionPreference(options);

            // Apply browser compatibility fixes
            options = BrowserCompatibility.applyBrowserFixes(sliderEl, options);

            // Mobile performance adjustments
            if (isMobile || isLowEndDevice) {
                options.speed = Math.max(options.speed || 500, 300); // Faster transitions
                options.enableGsapAnimations = false; // Disable GSAP on mobile
                options.effect = 'slide'; // Force slide effect (more performant)
            }
        } catch (e) {
            // Error parsing slider options
        }

        // Add mobile optimization class
        if (isMobile) {
            sliderEl.classList.add('mobile-optimized');
        }

        // Get transition speed
        const transitionSpeed = options.speed || 500;

        // Set transition speed as CSS variable for reliable synchronization
        sliderEl.style.setProperty('--swiper-transition-duration', transitionSpeed + 'ms');

        // Get slide count for proper initialization
        const slideCount = sliderEl.querySelectorAll('.swiper .swiper-slide').length;
        const useLoop = slideCount > 1 && (options.infinite !== undefined ? options.infinite : true);

        // Add transitioning class to handle content visibility during transitions
        sliderEl.classList.add('initializing');

        // Configure Swiper options - critical fix: ensure loopedSlides is set properly
        const swiperOptions = {
            slidesPerView: 1,
            spaceBetween: 0,
            effect: options.effect || 'fade',
            speed: transitionSpeed,
            loop: useLoop,
            // Explicitly set loopedSlides to the number of slides if loop is enabled
            loopedSlides: useLoop ? slideCount : null,
            autoHeight: false,
            watchSlidesProgress: !isMobile, // Disable on mobile for performance
            grabCursor: true,
            observer: !isMobile, // Disable heavy observers on mobile
            observeParents: !isMobile,
            observeSlideChildren: !isMobile, // Disable on mobile for performance
            simulateTouch: true,
            preventInteractionOnTransition: true, // Prevent interaction during transition to avoid glitches
            preventClicksPropagation: false,
            // Ensure slides maintain proper order
            slideToClickedSlide: false, // This can cause order issues, disable it

            // Mobile-specific optimizations
            touchRatio: isMobile ? 1.2 : 1,
            touchAngle: isMobile ? 35 : 45,
            longSwipesRatio: isMobile ? 0.3 : 0.5,
            threshold: isMobile ? 5 : 0,

            // Navigation
            navigation: {
                nextEl: sliderEl.querySelector('.swiper-button-next'),
                prevEl: sliderEl.querySelector('.swiper-button-prev'),
            },

            // Pagination
            pagination: {
                el: sliderEl.querySelector('.swiper-pagination'),
                clickable: true,
                type: options.paginationType || 'bullets'
            },

            // Events for managing visibility and transitions
            on: {
                init: function() {
                    // Add a short delay before showing content for initial load
                    setTimeout(() => {
                        sliderEl.classList.remove('initializing');
                        updateSlideVisibility(this);
                    }, 50);

                    // Store initial slide order for debugging
                    logSlideOrder(this, 'Main Swiper Init');
                },
                beforeTransitionStart: function() {
                    // Add transitioning class to handle content visibility during transitions
                    sliderEl.classList.add('transitioning');

                    // Force hide all inactive slides
                    forceHideInactiveContentSlides();

                    // Immediately hide content to prevent flashing
                    const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
                    contentSlides.forEach(slide => {
                        if (!slide.classList.contains('swiper-slide-active')) {
                            slide.style.opacity = "0";
                            slide.style.visibility = "hidden";
                        }
                    });
                },
                slideChange: function() {
                    updateSlideVisibility(this);
                    logSlideOrder(this, 'Main Swiper Change');

                    // Manually sync the content slider with the image slider
                    if (sliderEl.contentSwiper) {
                        // Get target slide before animation 
                        const targetIndex = useLoop ? this.realIndex : this.activeIndex;

                        // Reset all content slides immediately
                        if (options.enableGsapAnimations && window.gsap) {
                            const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
                            contentSlides.forEach(slide => resetSlideContent(slide));
                        }

                        // Set exact same index to ensure synchronization with 0 speed
                        if (useLoop) {
                            // For loop mode, use realIndex
                            sliderEl.contentSwiper.slideToLoop(targetIndex, 0, false);
                        } else {
                            // For non-loop mode, use activeIndex
                            sliderEl.contentSwiper.slideTo(targetIndex, 0, false);
                        }
                    }
                },
                transitionStart: function() {
                    // If using GSAP, prepare content slides
                    if (options.enableGsapAnimations && window.gsap) {
                        const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide:not(.swiper-slide-active)');
                        contentSlides.forEach(slide => resetSlideContent(slide));
                    }
                },
                transitionEnd: function() {
                    // Remove transitioning class when finished
                    setTimeout(() => {
                        sliderEl.classList.remove('transitioning');

                        // Force correct visibility again after transition
                        forceHideInactiveContentSlides();
                    }, 50);
                }
            }
        };

        // Add autoplay if enabled
        if (options.autoplay) {
            swiperOptions.autoplay = {
                delay: options.autoplaySpeed || 5000,
                disableOnInteraction: options.pauseOnHover ? true : false
            };
        }

        // Make sure there are slides before initializing
        if (sliderEl.querySelectorAll('.swiper .swiper-slide').length === 0) {
            return;
        }

        try {
            // Initialize Main Image Swiper
            const swiper = new Swiper(sliderEl.querySelector('.swiper'), swiperOptions);

            // Store instance for performance monitoring
            const sliderId = sliderEl.id || 'slider-' + Date.now();
            sliderEl.id = sliderId;
            window.imageTextSliderInstances.set(sliderId, {
                swiper: swiper,
                element: sliderEl,
                options: options,
                isMobile: isMobile,
                isLowEnd: isLowEndDevice
            });

            // Initialize content slider with matching settings to ensure perfect synchronization
            const contentSwiperOptions = {
                slidesPerView: 1,
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                speed: 0, // Set to 0 for instant transitions - critical fix
                allowTouchMove: false,
                observer: true,
                observeParents: true,
                observeSlideChildren: true,
                loop: useLoop,
                loopedSlides: useLoop ? slideCount : null, // Match loopedSlides with main swiper
                preventInteractionOnTransition: true,
                on: {
                    init: function() {
                        updateContentSlideVisibility(this);

                        // Set initial slide based on main swiper
                        if (useLoop) {
                            this.slideToLoop(swiper.realIndex, 0, false);
                        } else {
                            this.slideTo(swiper.activeIndex, 0, false);
                        }

                        // Log for debugging
                        logSlideOrder(this, 'Content Swiper Init');

                        // Initialize GSAP animations for first slide
                        if (options.enableGsapAnimations && window.gsap) {
                            const initialSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
                            if (initialSlide) {
                                // Show slide without animation first to prevent flashing
                                showSlideContentWithoutAnimation(initialSlide);

                                // Then animate with a slight delay
                                setTimeout(() => {
                                    resetSlideContent(initialSlide);
                                    animateSlideContent(initialSlide, options.animationDuration || 0.7);
                                }, 50);
                            }
                        }

                        // Ensure visibility is set properly for all content slides
                        const slides = this.slides;
                        if (slides && slides.length > 0) {
                            slides.forEach((slide, index) => {
                                if (index === this.activeIndex) {
                                    slide.style.opacity = '1';
                                    slide.style.visibility = 'visible';
                                } else {
                                    slide.style.opacity = '0';
                                    slide.style.visibility = 'hidden';
                                }
                            });
                        }
                    },
                    slideChange: function() {
                        updateContentSlideVisibility(this);
                        logSlideOrder(this, 'Content Swiper Change');

                        // Explicitly set visibility based on active state
                        const slides = this.slides;
                        if (slides && slides.length > 0) {
                            slides.forEach((slide, index) => {
                                if (index === this.activeIndex) {
                                    slide.style.opacity = '1';
                                    slide.style.visibility = 'visible';
                                } else {
                                    slide.style.opacity = '0';
                                    slide.style.visibility = 'hidden';
                                }
                            });
                        }
                    },
                    transitionStart: function() {
                        // Hide all non-active slides immediately
                        const slides = this.slides;
                        if (slides && slides.length > 0) {
                            slides.forEach((slide, index) => {
                                if (index !== this.activeIndex) {
                                    slide.style.opacity = '0';
                                    slide.style.visibility = 'hidden';
                                }
                            });
                        }
                    },
                    transitionEnd: function() {
                        // Ensure only active slide is visible after transition
                        setTimeout(ensureStaticContentAlignment, 50);
                    }
                }
            };

            const contentSwiper = new Swiper(sliderEl.querySelector('.swiper-content-slider'), contentSwiperOptions);

            // Store swiper instances in the element
            sliderEl.swiper = swiper;
            sliderEl.contentSwiper = contentSwiper;

            // Update instance tracking with content swiper
            const instance = window.imageTextSliderInstances.get(sliderId);
            if (instance) {
                instance.contentSwiper = contentSwiper;
            }

            // Set initial sync after initialization
            if (useLoop) {
                contentSwiper.slideToLoop(swiper.realIndex, 0, false);
            } else {
                contentSwiper.slideTo(swiper.activeIndex, 0, false);
            }

            // Add event listener for navigation clicks to ensure sync
            sliderEl.querySelectorAll('.swiper-button-next, .swiper-button-prev').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const isNext = btn.classList.contains('swiper-button-next');

                    // Add transitioning class
                    sliderEl.classList.add('transitioning');

                    // Handle navigation
                    if (isNext) {
                        swiper.slideNext();
                    } else {
                        swiper.slidePrev();
                    }
                });
            });

            // Listen for autoplay
            if (options.autoplay) {
                swiper.on('autoplay', function() {
                    // Add transitioning class
                    sliderEl.classList.add('transitioning');

                    // Keep content slider in sync with image slider during autoplay
                    if (useLoop) {
                        contentSwiper.slideToLoop(swiper.realIndex, 0, false);
                    } else {
                        contentSwiper.slideTo(swiper.activeIndex, 0, false);
                    }
                });
            }

            // Add CSS helper to handle transitions better
            const styleEl = document.createElement('style');
            styleEl.innerHTML = `
                .image-text-slider-container.transitioning .swiper-content-slider .swiper-slide:not(.swiper-slide-active),
                .image-text-slider-container.initializing .swiper-content-slider .swiper-slide:not(.swiper-slide-active) {
                    opacity: 0 !important;
                    visibility: hidden !important;
                    transition: none !important;
                }
            `;
            document.head.appendChild(styleEl);

            // Add GSAP animation if enabled
            if (options.enableGsapAnimations && window.gsap) {
                setupGsapAnimations(sliderEl, swiper, options);
            }

            // Update spacer after initialization
            const spacer = sliderEl.nextElementSibling;
            if (spacer && spacer.classList.contains('slider-bottom-spacer')) {
                setTimeout(() => updateSpacerPosition(sliderEl, spacer), 300);
            }

            // Add event listener to handle slide changes and update spacer if needed
            swiper.on('slideChange', function() {
                const spacer = sliderEl.nextElementSibling;
                if (spacer && spacer.classList.contains('slider-bottom-spacer')) {
                    setTimeout(() => updateSpacerPosition(sliderEl, spacer), 300);
                }
            });

            // After initialization, ensure static content alignment is preserved
            setTimeout(ensureStaticContentAlignment, 500);

            // Add event listener to ensure alignment on slide changes
            swiper.on('slideChangeTransitionEnd', function() {
                setTimeout(ensureStaticContentAlignment, 50);
            });

            // Initialize accessibility features
            AccessibilityUtils.initSliderAccessibility(sliderEl, swiper, options);

            // Accessibility controls are already set up during initSliderAccessibility

            // Remove initializing class after everything is set up
            setTimeout(() => {
                sliderEl.classList.remove('initializing');
                ensureStaticContentAlignment();
            }, 300);

        } catch (error) {
            // Clean up in case of error
            sliderEl.classList.remove('initializing');
            sliderEl.classList.remove('transitioning');
        }
    }

    /**
     * Log the current order of slides for debugging purposes
     * @param {Swiper} swiper - The Swiper instance
     * @param {string} context - Context message for the log
     */
    function logSlideOrder(swiper, context) {
        if (!swiper || !swiper.slides || swiper.slides.length === 0) return;

        const isMainSwiper = swiper.el.classList.contains('swiper') && !swiper.el.classList.contains('swiper-content-slider');

        if (isMainSwiper) {
            const slideInfo = {
                context: context,
                activeIndex: swiper.activeIndex,
                realIndex: swiper.realIndex,
                slides: []
            };

            swiper.slides.forEach((slide, index) => {
                // Get slide ID from class (elementor-repeater-item-xxx)
                const classes = slide.className.split(' ');
                const idClass = classes.find(cls => cls.startsWith('elementor-repeater-item-'));
                const id = idClass ? idClass.replace('elementor-repeater-item-', '') : 'unknown';

                slideInfo.slides.push({
                    index: index,
                    id: id,
                    isActive: slide.classList.contains('swiper-slide-active'),
                    isVisible: window.getComputedStyle(slide).visibility !== 'hidden'
                });
            });

            // Only log if debugging is enabled
            if (window.debugImageTextSlider) {}
        }
    }

    /**
     * Update slide visibility based on active, next, prev status
     * @param {Swiper} swiper - The Swiper instance
     */
    function updateSlideVisibility(swiper) {
        if (!swiper || !swiper.slides) return;

        swiper.slides.forEach(function(slide, index) {
            // Set all slides to hidden first
            slide.style.opacity = "0";
            slide.style.visibility = "hidden";

            // Make active, next and prev slides visible
            if (index === swiper.activeIndex ||
                (swiper.loop && (
                    // Handle loop edge cases properly
                    index === swiper.realIndex ||
                    index === swiper.activeIndex - 1 ||
                    index === swiper.activeIndex + 1 ||
                    // Handle wrap-around cases in loop mode
                    (swiper.activeIndex === 0 && index === swiper.slides.length - 1) ||
                    (swiper.activeIndex === swiper.slides.length - 1 && index === 0)
                )) ||
                (!swiper.loop && (
                    index === swiper.activeIndex - 1 ||
                    index === swiper.activeIndex + 1
                ))) {
                slide.style.opacity = "1";
                slide.style.visibility = "visible";
            }
        });
    }

    /**
     * Update content slide visibility based on active status
     * @param {Swiper} contentSwiper - The content Swiper instance
     */
    function updateContentSlideVisibility(contentSwiper) {
        if (!contentSwiper || !contentSwiper.slides) return;

        contentSwiper.slides.forEach(function(slide, index) {
            // Set all slides to hidden first - use direct style application for stronger effect
            slide.style.opacity = "0";
            slide.style.visibility = "hidden";
            slide.style.zIndex = "0";

            // We only want the active slide to be visible - use direct style application
            if (index === contentSwiper.activeIndex) {
                slide.style.opacity = "1";
                slide.style.visibility = "visible";
                slide.style.zIndex = "2";
            }
        });
    }

    // Expose initialization function for external use (especially in editor)
    window.initImageTextSliders = initImageTextSliders;
    window.initImageTextSlider = initImageTextSlider;
    window.initEditorSliders = initEditorSliders;
    window.initImageTextSliderForEditor = initImageTextSliderForEditor;
    window.setupEditorView = setupEditorView;
    window.positionSliderSpacers = positionSliderSpacers;
    window.resetEditorSlider = resetEditorSlider;
    window.updateEditorSpacingIndicators = updateEditorSpacingIndicators;

    // Add debugging toggle
    window.debugImageTextSlider = false;

    /**
     * Setup GSAP animations for the slider
     * @param {HTMLElement} sliderEl - The slider container element
     * @param {Swiper} swiper - The Swiper instance
     * @param {Object} options - The slider options
     */
    function setupGsapAnimations(sliderEl, swiper, options) {
        if (!window.gsap) return;

        const duration = options.animationDuration || 0.7;
        const useLoop = swiper.params.loop;

        // Keep track of animated slides to prevent re-animation
        const animatedSlides = new Set();

        // Animate initial slide
        const initialSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
        if (initialSlide) {
            animateSlideContent(initialSlide, duration);

            // Add slide ID to animated set
            const slideId = initialSlide.className.split(' ')
                .find(cls => cls.startsWith('elementor-repeater-item-content-'));
            if (slideId) animatedSlides.add(slideId);
        }

        // Add event listeners for slide changes
        swiper.on('slideChangeTransitionStart', function() {
            // Get the target slide index depending on loop mode
            const targetIndex = useLoop ? this.realIndex : this.activeIndex;

            // Reset all content slides first
            const contentSlides = sliderEl.querySelectorAll('.swiper-content-slider .swiper-slide');
            contentSlides.forEach(slide => resetSlideContent(slide));

            // Immediately make the target slide visible for smoother transition
            if (sliderEl.contentSwiper && sliderEl.contentSwiper.slides) {
                const targetSlide = Array.from(sliderEl.contentSwiper.slides).find((slide, index) => {
                    if (useLoop) {
                        // For loop mode, match by realIndex
                        return (index % (sliderEl.contentSwiper.slides.length / 3)) === targetIndex;
                    } else {
                        // For non-loop mode, match by direct index
                        return index === targetIndex;
                    }
                });

                if (targetSlide) {
                    showSlideContentWithoutAnimation(targetSlide);
                }
            }
        });

        swiper.on('slideChangeTransitionEnd', function() {
            // Get active content slide
            const activeSlide = sliderEl.querySelector('.swiper-content-slider .swiper-slide-active');
            if (!activeSlide) return;

            // Extract slide ID
            const slideId = activeSlide.className.split(' ')
                .find(cls => cls.startsWith('elementor-repeater-item-content-'));

            // Animate if not seen before, otherwise just show
            if (slideId && !animatedSlides.has(slideId)) {
                animateSlideContent(activeSlide, duration);
                animatedSlides.add(slideId);
            } else {
                showSlideContentWithoutAnimation(activeSlide);
            }
        });

        // Handle sync between content slider and animations
        if (sliderEl.contentSwiper) {
            sliderEl.contentSwiper.on('slideChangeTransitionEnd', function() {
                // Get active slide from content swiper
                const activeSlide = this.slides[this.activeIndex];
                if (!activeSlide) return;

                // Extract slide ID
                const slideId = activeSlide.className.split(' ')
                    .find(cls => cls.startsWith('elementor-repeater-item-content-'));

                // Animate if not seen before
                if (slideId && !animatedSlides.has(slideId)) {
                    animateSlideContent(activeSlide, duration);
                    animatedSlides.add(slideId);
                }
            });
        }
    }

    /**
     * Animate the content of a slide with GSAP
     * @param {HTMLElement} slide - The slide element
     * @param {number} duration - Animation duration in seconds
     */
    function animateSlideContent(slide, duration) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        // Note: Navigation arrows are now in the main controls, not per slide

        // Kill any existing animations first
        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow]);

        const timeline = gsap.timeline({
            defaults: {
                duration: duration,
                ease: "power2.out",
                clearProps: "all" // Clear properties after animation to avoid conflicts
            }
        });

        // Animate different elements with sequence
        if (breadcrumbAbove) {
            timeline.fromTo(breadcrumbAbove, { opacity: 0, y: -15 }, { opacity: 1, y: 0, duration: duration * 0.6 });
        }

        if (title) {
            timeline.fromTo(title, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                breadcrumbAbove ? "-=0.2" : 0
            );
        }

        if (description) {
            timeline.fromTo(description, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.2"
            );
        }

        if (buttons) {
            timeline.fromTo(buttons, { opacity: 0, y: 20 }, { opacity: 1, y: 0 },
                "-=0.2"
            );
        }

        if (breadcrumbBelow) {
            timeline.fromTo(breadcrumbBelow, { opacity: 0, y: 15 }, { opacity: 1, y: 0, duration: duration * 0.6 },
                "-=0.2"
            );
        }
    }

    /**
     * Reset the content of a slide for GSAP animation
     * @param {HTMLElement} slide - The slide element
     */
    function resetSlideContent(slide) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        // Note: Navigation arrows are now in the main controls, not per slide

        // Kill any ongoing animations
        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow]);

        // Reset all elements to their starting positions
        if (breadcrumbAbove) gsap.set(breadcrumbAbove, { opacity: 0, y: -15 });
        if (title) gsap.set(title, { opacity: 0, y: 20 });
        if (description) gsap.set(description, { opacity: 0, y: 20 });
        if (buttons) gsap.set(buttons, { opacity: 0, y: 20 });
        if (breadcrumbBelow) gsap.set(breadcrumbBelow, { opacity: 0, y: 15 });
    }

    /**
     * Show slide content immediately without animation
     * @param {HTMLElement} slide - The slide element
     */
    function showSlideContentWithoutAnimation(slide) {
        if (!window.gsap) return;

        const title = slide.querySelector('.slide-title');
        const description = slide.querySelector('.slide-description');
        const buttons = slide.querySelector('.slide-buttons');
        const breadcrumbAbove = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:first-child');
        const breadcrumbBelow = slide.querySelector('.slide-content-container > .image-text-slider-breadcrumb:last-child');
        // Note: Navigation arrows are now in the main controls, not per slide

        // Kill any ongoing animations
        gsap.killTweensOf([title, description, buttons, breadcrumbAbove, breadcrumbBelow]);

        // Show all elements immediately at their final positions
        if (breadcrumbAbove) gsap.set(breadcrumbAbove, { opacity: 1, y: 0, clearProps: "all" });
        if (title) gsap.set(title, { opacity: 1, y: 0, clearProps: "all" });
        if (description) gsap.set(description, { opacity: 1, y: 0, clearProps: "all" });
        if (buttons) gsap.set(buttons, { opacity: 1, y: 0, clearProps: "all" });
        if (breadcrumbBelow) gsap.set(breadcrumbBelow, { opacity: 1, y: 0, clearProps: "all" });
    }

    /**
     * Ensures content slides have the correct static alignment in the frontend view
     */
    function ensureStaticContentAlignment() {
        // Only apply to non-editor views
        if (document.body.classList.contains('elementor-editor-active')) {
            return;
        }

        // Get all slider containers
        document.querySelectorAll('.image-text-slider-container').forEach(slider => {
            // Check if this is a single-slide setup
            const slideCount = slider.querySelectorAll('.swiper .swiper-slide').length;
            if (slideCount <= 1) {
                slider.classList.add('single-slide');
            } else {
                slider.classList.remove('single-slide');
            }

            // Get all content slides in this slider
            const contentSlides = slider.querySelectorAll('.swiper-content-slider .swiper-slide[class*="elementor-repeater-item-content"]');

            contentSlides.forEach(slide => {
                // Make sure the content slide respects the CSS styles we've defined
                slide.style.position = 'absolute';

                // If it's a multi-slide slider, ensure only active slide is visible
                if (slideCount > 1) {
                    if (slide.classList.contains('swiper-slide-active')) {
                        slide.style.opacity = '1';
                        slide.style.visibility = 'visible';

                        // Make sure content positioning is maintained
                        const slideContent = slide.querySelector('.slide-content-container');
                        if (slideContent) {
                            slideContent.style.visibility = 'visible';
                            slideContent.style.opacity = '1';
                        }
                    } else {
                        slide.style.opacity = '0';
                        slide.style.visibility = 'hidden';
                    }
                } else {
                    // For single slides, always make them visible
                    slide.style.opacity = '1';
                    slide.style.visibility = 'visible';
                }
            });
        });
    }

    // Add this new function to forcefully hide all non-active content slides
    function forceHideInactiveContentSlides() {
        document.querySelectorAll('.image-text-slider-container').forEach(slider => {
            const contentSlides = slider.querySelectorAll('.swiper-content-slider .swiper-slide');

            // First identify the active slide
            let activeSlide = null;
            contentSlides.forEach(slide => {
                if (slide.classList.contains('swiper-slide-active')) {
                    activeSlide = slide;
                }
            });

            // If we found an active slide, hide all others
            if (activeSlide) {
                contentSlides.forEach(slide => {
                    if (slide !== activeSlide) {
                        // Apply strong hiding
                        slide.style.opacity = "0";
                        slide.style.visibility = "hidden";
                        slide.style.pointerEvents = "none";
                        slide.style.position = "absolute";
                        slide.style.zIndex = "0";
                    } else {
                        // Ensure active slide is fully visible
                        slide.style.opacity = "1";
                        slide.style.visibility = "visible";
                        slide.style.pointerEvents = "auto";
                        slide.style.position = "absolute";
                        slide.style.zIndex = "2";
                    }
                });
            }
        });
    }

    /**
     * Monitor performance and adjust settings for mobile
     */
    function monitorPerformance() {
        if (!window.imageTextSliderInstances || !isMobile) return;

        window.imageTextSliderInstances.forEach((instance, id) => {
            const { swiper, element, options } = instance;

            // Check if autoplay is causing performance issues
            if (swiper && swiper.autoplay && swiper.autoplay.running) {
                const rect = element.getBoundingClientRect();
                const isVisible = rect.top < window.innerHeight && rect.bottom > 0;

                // Pause autoplay when slider is out of viewport
                if (!isVisible && !swiper.autoplay.paused) {
                    swiper.autoplay.pause();
                } else if (isVisible && swiper.autoplay.paused) {
                    swiper.autoplay.start();
                }
            }

            // Disable observers on very low-end devices after a while
            if (isLowEndDevice && swiper) {
                swiper.observer = false;
                swiper.observeParents = false;
                swiper.observeSlideChildren = false;
            }
        });
    }
})();