/**
 * Solicitation Timeline Widget JavaScript
 * 
 * Handles the animation of timeline markers based on scroll position using GSAP.
 * Disables animations in the Elementor editor but enables them on the frontend.
 */

(function ($) {
    'use strict';

    // Check if we're in the Elementor editor
    const isElementorEditor = typeof window.elementorFrontend !== 'undefined' && window.elementorFrontend.isEditMode();

    // Initialize the timeline marker animations when the DOM is ready
    $(document).ready(function () {
        // Only run animation if not in Elementor editor
        if (!isElementorEditor) {
            initTimelineMarkerAnimations();
        } else {
            showAllTimelineSteps();
        }
    });

    // Initialize on Elementor frontend init to support Elementor Pro features
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_solicitation_timeline.default', function ($scope) {
                // Initialize keyboard navigation
                if (typeof PromenAccessibility !== 'undefined') {
                    const steps = $scope.find('.solicitation-timeline__step');
                    steps.attr('tabindex', '0');
                    steps.attr('role', 'listitem');
                    $scope.find('.solicitation-timeline').attr('role', 'list');
                }

                // Only run animation if not in Elementor editor
                if (!elementorFrontend.isEditMode()) {
                    // Clear any existing ScrollTrigger instances to prevent duplicates
                    if (typeof ScrollTrigger !== 'undefined') {
                        ScrollTrigger.getAll().forEach(trigger => trigger.kill());
                    }

                    // Initialize the animations with a slight delay to ensure DOM is ready
                    setTimeout(function () {
                        initTimelineMarkerAnimations();
                    }, 100);
                } else {
                    // In editor: show all steps without animation
                    showAllTimelineSteps();
                }
            });
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

    // Re-initialize on window resize (debounced)
    let resizeTimer;
    $(window).on('resize', function () {
        // Only handle resize events for animations if not in editor
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode()) {
            return;
        }

        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            // Kill all existing ScrollTrigger instances
            if (typeof ScrollTrigger !== 'undefined') {
                ScrollTrigger.getAll().forEach(trigger => trigger.kill());
            }

            // Check if we switched between desktop and mobile/tablet
            if (isDesktop()) {
                // Re-initialize animations for desktop
                initTimelineMarkerAnimations();
            } else {
                // Show all steps without animation for mobile/tablet
                showAllTimelineSteps();
            }
        }, 250);
    });

    /**
     * Show all timeline steps without animation (for editor mode)
     */
    function showAllTimelineSteps() {
        const timelineSteps = document.querySelectorAll('.solicitation-timeline__step');

        if (!timelineSteps.length) {
            return;
        }

        // Make all steps visible without animation
        timelineSteps.forEach((step, index) => {
            // Add active class to all steps
            step.classList.add('active');

            // Show step
            step.style.opacity = 1;
            step.style.transform = 'translateY(0)';

            const marker = step.querySelector('.solicitation-timeline__marker');
            if (marker) {
                // Create or get fill element inside the marker
                let fillElement = marker.querySelector('.solicitation-timeline__marker-fill');
                if (!fillElement) {
                    fillElement = document.createElement('div');
                    fillElement.className = 'solicitation-timeline__marker-fill';
                    marker.appendChild(fillElement);
                }

                // Style fill element to be fully filled
                fillElement.style.width = '100%';
                fillElement.style.height = '100%';
                fillElement.style.borderRadius = '50%';
                fillElement.style.backgroundColor = getComputedStyle(marker).backgroundColor;
                fillElement.style.position = 'absolute';
                fillElement.style.top = '50%';
                fillElement.style.left = '50%';
                fillElement.style.transform = 'translate(-50%, -50%)';
                fillElement.style.opacity = '0.8';
            }

            // Show line between steps
            if (index < timelineSteps.length - 1) {
                const line = step.querySelector('.solicitation-timeline__line');
                if (line) {
                    line.classList.add('active');
                    line.style.transform = 'scaleY(1)';
                    line.style.backgroundColor = '#F5A623';
                }
            }
        });
    }

    /**
     * Check if the current device is desktop
     */
    function isDesktop() {
        return window.innerWidth > 1024; // Desktop breakpoint
    }

    /**
     * Initialize the timeline marker animations
     */
    function initTimelineMarkerAnimations() {
        // Check if we're on desktop - only run animations on desktop
        if (!isDesktop()) {
            // On mobile/tablet, show all steps without animation
            showAllTimelineSteps();
            return;
        }

        // Check if GSAP is available
        if (typeof gsap === 'undefined') {
            console.warn('GSAP is not available. Please include the GSAP library.');
            return;
        }

        // Check if ScrollTrigger is available
        if (typeof ScrollTrigger === 'undefined') {
            console.warn('ScrollTrigger is not available. Please include the ScrollTrigger plugin.');
            return;
        }

        // Register ScrollTrigger plugin
        gsap.registerPlugin(ScrollTrigger);

        // Get the timeline container and steps
        const timelineContainer = document.querySelector('.solicitation-timeline');
        const timelineSteps = document.querySelectorAll('.solicitation-timeline__step');

        if (!timelineContainer || !timelineSteps.length) {
            return;
        }

        // Calculate the total scroll duration based on the number of steps
        // Each step gets a full viewport height of scrolling space, plus extra space for the last step
        const scrollDuration = timelineSteps.length * 100 + 100; // Add 100% extra scroll space for the last step

        // Set initial state for all steps and their elements
        timelineSteps.forEach((step, index) => {
            // Initially hide all steps except the first one
            gsap.set(step, {
                opacity: index === 0 ? 1 : 0,
                y: index === 0 ? 0 : 30
            });

            const marker = step.querySelector('.solicitation-timeline__marker');
            if (!marker) return;

            // Create a fill element inside the marker if it doesn't exist
            let fillElement = marker.querySelector('.solicitation-timeline__marker-fill');
            if (!fillElement) {
                fillElement = document.createElement('div');
                fillElement.className = 'solicitation-timeline__marker-fill';
                marker.appendChild(fillElement);
            }

            // Set up the initial state of the fill element
            gsap.set(fillElement, {
                width: index === 0 ? '100%' : '0%',
                height: index === 0 ? '100%' : '0%',
                borderRadius: '50%',
                backgroundColor: getComputedStyle(marker).backgroundColor,
                position: 'absolute',
                top: '50%',
                left: '50%',
                transform: 'translate(-50%, -50%)',
                opacity: 0.8
            });

            // Set initial state for the line if it exists
            if (index < timelineSteps.length - 1) {
                const line = step.querySelector('.solicitation-timeline__line');
                if (line) {
                    gsap.set(line, {
                        scaleY: 0,
                        transformOrigin: 'top center',
                        backgroundColor: '#e6e6e6' // Set initial color
                    });
                }
            }
        });

        // Only create the animated timeline if we're not in the editor
        if (typeof elementorFrontend === 'undefined' || !elementorFrontend.isEditMode()) {
            // Create the main timeline
            const mainTimeline = gsap.timeline({
                scrollTrigger: {
                    trigger: timelineContainer,
                    start: 'top 20%', // Start when the top of the container is 20% from the top of the viewport
                    end: `+=${scrollDuration}%`, // End after scrolling the calculated duration
                    pin: true, // Pin the container during the animation
                    anticipatePin: 1, // Improves performance by pre-pinning
                    scrub: 0.5, // Smooth scrubbing with slight delay
                    markers: false, // Set to true for debugging
                    pinSpacing: true, // Adds space to accommodate the pinned element
                    pinReparent: false // Prevents reparenting issues
                }
            });

            // Add the first step's marker as already active
            if (timelineSteps.length > 0) {
                timelineSteps[0].classList.add('active');
            }

            // Create sequential animations for each step
            timelineSteps.forEach((step, index) => {
                // Skip the first step as it's already visible
                if (index === 0) return;

                const marker = step.querySelector('.solicitation-timeline__marker');
                const fillElement = marker ? marker.querySelector('.solicitation-timeline__marker-fill') : null;

                // Get the previous step and its line
                const prevStep = timelineSteps[index - 1];
                const prevLine = prevStep ? prevStep.querySelector('.solicitation-timeline__line') : null;

                // Create a sequence for this step
                const stepSequence = gsap.timeline();

                // 1. First animate the previous line if it exists
                if (prevLine) {
                    stepSequence.to(prevLine, {
                        scaleY: 1,
                        backgroundColor: '#F5A623',
                        duration: 0.3,
                        onStart: () => {
                            prevLine.classList.add('active');
                        }
                    });
                }

                // 2. Then fade in this step
                stepSequence.to(step, {
                    opacity: 1,
                    y: 0,
                    duration: 0.3,
                    onStart: () => {
                        // Add active class to this step
                        step.classList.add('active');

                        // Remove active class from previous steps except the immediate previous one
                        if (index > 1) {
                            timelineSteps[index - 2].classList.remove('active');
                        }
                    }
                });

                // 3. Then fill the marker
                if (fillElement) {
                    stepSequence.to(fillElement, {
                        width: '100%',
                        height: '100%',
                        duration: 0.3
                    });
                }

                // Calculate position in the timeline
                // Distribute steps evenly across 80% of the timeline, leaving 20% for the last step to be fully visible before unpinning
                const position = (index - 1) / (timelineSteps.length - 1) * 0.8;

                // Add this sequence to the main timeline
                mainTimeline.add(stepSequence, position);
            });

            // Add a final animation to remove the active class from the second-to-last step
            // when the last step is fully visible
            if (timelineSteps.length > 1) {
                const lastIndex = timelineSteps.length - 1;
                const secondLastIndex = lastIndex - 1;

                mainTimeline.call(() => {
                    if (secondLastIndex >= 0) {
                        timelineSteps[secondLastIndex].classList.remove('active');
                    }
                    timelineSteps[lastIndex].classList.add('active');
                }, [], 0.8); // Call at 80% of the timeline

                // Add a significant pause at the end to ensure the last step is fully visible before unpinning
                // This creates a "dwell" period where the last step is displayed prominently
                mainTimeline.to({}, { duration: 0.2 }, 0.8); // 20% of the timeline is just showing the last step
            }

            // Add a special highlight effect for the last step
            const lastStep = timelineSteps[timelineSteps.length - 1];
            if (lastStep) {
                const lastStepTitle = lastStep.querySelector('.solicitation-timeline__step-title');
                const lastStepMarker = lastStep.querySelector('.solicitation-timeline__marker');

                if (lastStepTitle && lastStepMarker) {
                    // Add a subtle pulse animation to the last step when it's active
                    mainTimeline.to(lastStepMarker, {
                        boxShadow: '0 0 20px rgba(245, 166, 35, 0.9)',
                        scale: 1.1,
                        duration: 0.3,
                        repeat: 1,
                        yoyo: true
                    }, 0.85); // Start at 85% of the timeline
                }
            }

            // Refresh ScrollTrigger to ensure proper initialization
            ScrollTrigger.refresh();
        }
    }

})(jQuery);