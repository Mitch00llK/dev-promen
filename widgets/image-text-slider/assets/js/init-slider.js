/**
 * Image Text Slider Initialization
 * Handles DOM events, Elementor hooks, and global listeners
 */
(function (window) {
    "use strict";

    // Dependencies
    const Utils = window.PromenSliderUtils;
    const { debounce, throttle, BrowserCompatibility } = Utils;
    const isMobile = window.innerWidth <= 768; // Or check browser.isMobile if exposed

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize browser compatibility
        const { browser, features } = BrowserCompatibility.init();

        // Check if we're in Elementor editor
        const isElementorEditor = document.body.classList.contains('elementor-editor-active');

        // Initialize sliders for both editor and frontend
        if (!isElementorEditor) {
            // Delayed initialization for better page load performance on frontend
            const initDelay = isMobile ? 300 : 100;
            if (typeof window.initImageTextSliders === 'function') {
                setTimeout(window.initImageTextSliders, initDelay);
            }
        } else {
            // In editor mode, initialize sliders with basic functionality
            if (typeof window.initEditorSliders === 'function') {
                setTimeout(window.initEditorSliders, 200);
            }
        }

        // Handle resize events to ensure proper spacing (debounced for performance)
        if (typeof window.handleSliderResize === 'function') {
            window.addEventListener('resize', debounce(window.handleSliderResize, 250));
        }

        // Handle scroll events to ensure proper positioning (throttled for mobile)
        // Define handleSliderScroll wrapper if it's not global or just rely on existing logic
        // Original script defined handleSliderScroll but we exposed ensureProperSpacingAfterSliders.
        // Let's implement the scroll handler here using the exposed function.

        const handleScroll = () => {
            if (typeof window.ensureProperSpacingAfterSliders === 'function') {
                window.ensureProperSpacingAfterSliders();
            }
        };

        if (isMobile) {
            window.addEventListener('scroll', throttle(handleScroll, 200), { passive: true });
        } else {
            window.addEventListener('scroll', handleScroll, { passive: true });
        }

        // Initial positioning of the spacer
        if (typeof window.positionSliderSpacers === 'function') {
            setTimeout(window.positionSliderSpacers, 500);
            // And again later to be sure
            setTimeout(window.positionSliderSpacers, 1000);
        }

        // Add a more comprehensive resize handler that prevents overlap issues
        // We need to implement addComprehensiveResizeHandler here or expose it.
        // It was not exposed in slider.js. I should implement it here using exposed functions.
        addComprehensiveResizeHandler();

        // Apply static alignment for content slides
        if (typeof window.ensureStaticContentAlignment === 'function') {
            setTimeout(window.ensureStaticContentAlignment, 300);
        }

        // Check if elementorFrontend and hooks are available
        const initElementorHooks = () => {
            if (window.elementorFrontend && window.elementorFrontend.hooks) {
                // Reinitialize sliders when Elementor frontend is initialized
                elementorFrontend.hooks.addAction('frontend/element_ready/image_text_slider.default', function ($scope) {
                    if (!isElementorEditor) {
                        if (typeof window.initImageTextSlider === 'function') {
                            window.initImageTextSlider($scope.find('.image-text-slider-container')[0]);
                        }
                    } else {
                        if (typeof window.initImageTextSliderForEditor === 'function') {
                            window.initImageTextSliderForEditor($scope.find('.image-text-slider-container')[0]);
                        }
                    }

                    // Handle breadcrumb visibility in the editor
                    if (window.elementor && window.elementorFrontend.isEditMode()) {
                        const widget = $scope.data('model-cid');

                        if (widget) {
                            // Listen for changes to the breadcrumb settings
                            elementor.channels.editor.on('change', function (view) {
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
                    elementorFrontend.hooks.addAction('frontend/element_ready/section', function () {
                        setTimeout(function () {
                            if (typeof window.initEditorSliders === 'function') {
                                window.initEditorSliders();
                            }
                        }, 100);
                    });

                    elementorFrontend.hooks.addAction('frontend/element_ready/column', function () {
                        setTimeout(function () {
                            if (typeof window.initEditorSliders === 'function') {
                                window.initEditorSliders();
                            }
                        }, 100);
                    });

                    // Initialize when panel is opened
                    if (window.elementor && window.elementor.hooks) {
                        window.elementor.hooks.addAction('panel/open_editor/widget', function () {
                            setTimeout(function () {
                                if (typeof window.initEditorSliders === 'function') {
                                    window.initEditorSliders();
                                }
                            }, 100);
                        });
                    }
                }
            }
        };

        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            initElementorHooks();
        } else {
            window.addEventListener('elementor/frontend/init', initElementorHooks);
        }

        // Initialize on any preview reload
        document.addEventListener('elementor/popup/show', function () {
            setTimeout(function () {
                if (typeof window.initEditorSliders === 'function') {
                    window.initEditorSliders();
                }
            }, 50);
        });

        // Handle spacing control changes
        if (window.elementor && window.elementor.channels) {
            elementor.channels.editor.on('change', function (view) {
                const changedControlName = view.model.get('name');


            });
        }

        // Force hide inactive content slides on initial load
        if (typeof window.forceHideInactiveContentSlides === 'function') {
            setTimeout(window.forceHideInactiveContentSlides, 100);
            // And again after a longer delay to catch any late rendering
            setTimeout(window.forceHideInactiveContentSlides, 500);
        }

        // And again after full page load
        window.addEventListener('load', () => {
            if (typeof window.forceHideInactiveContentSlides === 'function') {
                window.forceHideInactiveContentSlides();
                setTimeout(window.forceHideInactiveContentSlides, 200);
            }
        });

        // Performance monitoring for mobile
        if (isMobile) {
            // Monitor performance and adjust if needed
            if (typeof window.monitorPerformance === 'function') {
                setTimeout(window.monitorPerformance, 2000);
                setInterval(window.monitorPerformance, 10000); // Check every 10 seconds
            }
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
                if (typeof window.positionSliderSpacers === 'function') {
                    window.positionSliderSpacers();
                }
                // Add clear spacing after sliders
                if (typeof window.ensureProperSpacingAfterSliders === 'function') {
                    window.ensureProperSpacingAfterSliders();
                }
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
                    if (typeof window.positionSliderSpacers === 'function') {
                        window.positionSliderSpacers();
                    }
                    if (typeof window.ensureProperSpacingAfterSliders === 'function') {
                        window.ensureProperSpacingAfterSliders();
                    }

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

})(window);
