/**
 * Image Text Slider Utilities
 * Contains performance helpers and browser compatibility checks
 */
(function (window) {
    "use strict";

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
        return function () {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    };

    // Cross-browser compatibility layer
    const BrowserCompatibility = {
        /**
         * Detect browser and version
         */
        detectBrowser: function () {
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
        applyBrowserFixes: function (sliderEl, options) {
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
        applyIEEdgeFixes: function (sliderEl, options) {
            // Disable CSS Grid fallback
            sliderEl.classList.add('ie-edge-mode');

            // Force fade effect for better performance
            options.effect = 'fade';
            options.enableGsapAnimations = false;

            // Add polyfills for missing methods
            if (!Element.prototype.closest) {
                Element.prototype.closest = function (selector) {
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
                    outline-offset: 2px !important;
                }
            `;
            document.head.appendChild(style);
        },

        /**
         * Safari specific fixes
         */
        applySafariFixes: function (sliderEl, options) {
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
        applyFirefoxFixes: function (sliderEl, options) {
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
        applyMobileFixes: function (sliderEl, options) {
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
        addAriaPolyfills: function () {
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
        detectFeatures: function () {
            const features = {
                intersectionObserver: 'IntersectionObserver' in window,
                resizeObserver: 'ResizeObserver' in window,
                customProperties: CSS.supports('color', 'var(--test)'),
                grid: CSS.supports('display', 'grid'),
                flexbox: CSS.supports('display', 'flex'),
                transform3d: (function () {
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
        init: function () {
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

    // Expose functionality to global namespace
    window.PromenSliderUtils = {
        debounce: debounce,
        throttle: throttle,
        BrowserCompatibility: BrowserCompatibility
    };

})(window);
