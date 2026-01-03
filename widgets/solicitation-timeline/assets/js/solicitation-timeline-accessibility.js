/**
 * Solicitation Timeline Accessibility
 * 
 * Implements WCAG 2.2 compliant reduced motion support, screen reader 
 * announcements, and focus management for the Solicitation Timeline widget.
 * 
 * Uses the centralized PromenAccessibility core library.
 */
(function ($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function () {
        initSolicitationTimelineAccessibility();
    });

    // Initialize when Elementor frontend is initialized (for editor preview)
    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/promen_solicitation_timeline.default',
                initSolicitationTimelineAccessibility
            );
        }
    });

    /**
     * Initialize accessibility features for all timelines
     */
    function initSolicitationTimelineAccessibility() {
        $('.promen-solicitation-timeline').each(function () {
            initSingleTimelineAccessibility($(this));
        });
    }

    /**
     * Initialize accessibility for a single timeline
     */
    function initSingleTimelineAccessibility($timeline) {
        if ($timeline.length === 0 || $timeline.data('accessibility-initialized')) {
            return;
        }

        $timeline.data('accessibility-initialized', true);

        setupARIA($timeline);
        setupReducedMotion($timeline);
        setupKeyboardNavigation($timeline);
        setupFocusIndicators($timeline);
        announceTimelineLoaded($timeline);
    }

    /**
     * Setup ARIA attributes for the timeline
     */
    function setupARIA($timeline) {
        // Set up timeline container
        $timeline.attr({
            'role': 'list',
            'aria-label': 'Solicitation process timeline'
        });

        // Set up each timeline step
        const steps = $timeline.find('.promen-solicitation-timeline__step');
        steps.each(function (index) {
            const $step = $(this);
            const stepNumber = index + 1;
            const totalSteps = steps.length;

            $step.attr({
                'role': 'listitem',
                'aria-label': `Step ${stepNumber} of ${totalSteps}`
            });

            // Make step marker accessible
            const $marker = $step.find('.promen-solicitation-timeline__marker');
            if ($marker.length) {
                $marker.attr({
                    'role': 'presentation',
                    'aria-hidden': 'true'
                });
            }

            // Ensure step content is accessible
            const $content = $step.find('.promen-solicitation-timeline__content');
            if ($content.length) {
                $content.attr('role', 'group');

                // Get title for better description
                const $title = $content.find('.promen-solicitation-timeline__title');
                if ($title.length) {
                    const titleText = $title.text().trim();
                    $step.attr('aria-label', `Step ${stepNumber} of ${totalSteps}: ${titleText}`);
                }
            }
        });
    }

    /**
     * Setup reduced motion support
     */
    function setupReducedMotion($timeline) {
        const prefersReducedMotion = typeof PromenAccessibility !== 'undefined'
            ? PromenAccessibility.isReducedMotion()
            : window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReducedMotion) {
            // Add class to disable CSS animations
            $timeline.addClass('reduced-motion-active');

            // Kill any GSAP animations on this timeline
            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                // Find and kill ScrollTrigger instances for this timeline
                const triggers = ScrollTrigger.getAll();
                triggers.forEach(function (trigger) {
                    if (trigger.trigger && $.contains($timeline[0], trigger.trigger)) {
                        trigger.kill();
                    }
                });
            }

            // Make all steps visible immediately
            $timeline.find('.promen-solicitation-timeline__step').css({
                'opacity': '1',
                'transform': 'none',
                'visibility': 'visible'
            });

            $timeline.find('.promen-solicitation-timeline__marker').css({
                'opacity': '1',
                'transform': 'scale(1)'
            });

            $timeline.find('.promen-solicitation-timeline__content').css({
                'opacity': '1',
                'transform': 'none'
            });

            // Announce that animations are disabled
            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.announce('Timeline animations disabled for reduced motion preference');
            }
        }

        // Register with global animation controller
        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.registerAnimation) {
            PromenAccessibility.registerAnimation('solicitation-timeline', function () {
                // Kill all GSAP animations for this timeline
                if (typeof gsap !== 'undefined') {
                    gsap.killTweensOf($timeline.find('*').toArray());
                }
            });
        }
    }

    /**
     * Setup keyboard navigation between steps
     */
    function setupKeyboardNavigation($timeline) {
        const steps = $timeline.find('.promen-solicitation-timeline__step');

        // Make steps focusable
        steps.attr('tabindex', '0');

        // Handle keyboard navigation
        steps.on('keydown', function (e) {
            const $currentStep = $(this);
            const currentIndex = steps.index($currentStep);
            let targetIndex = -1;

            switch (e.key) {
                case 'ArrowDown':
                case 'ArrowRight':
                    e.preventDefault();
                    targetIndex = Math.min(currentIndex + 1, steps.length - 1);
                    break;
                case 'ArrowUp':
                case 'ArrowLeft':
                    e.preventDefault();
                    targetIndex = Math.max(currentIndex - 1, 0);
                    break;
                case 'Home':
                    e.preventDefault();
                    targetIndex = 0;
                    break;
                case 'End':
                    e.preventDefault();
                    targetIndex = steps.length - 1;
                    break;
            }

            if (targetIndex >= 0 && targetIndex !== currentIndex) {
                const $targetStep = steps.eq(targetIndex);
                $targetStep.trigger('focus');
                announceStep($targetStep, targetIndex, steps.length);
            }
        });
    }

    /**
     * Setup visible focus indicators
     */
    function setupFocusIndicators($timeline) {
        const steps = $timeline.find('.promen-solicitation-timeline__step');

        steps.on('focus', function () {
            $(this).addClass('promen-timeline-step--focused');
        }).on('blur', function () {
            $(this).removeClass('promen-timeline-step--focused');
        });
    }

    /**
     * Announce when timeline is loaded
     */
    function announceTimelineLoaded($timeline) {
        const stepCount = $timeline.find('.promen-solicitation-timeline__step').length;

        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.announce(`Solicitation timeline with ${stepCount} steps`);
        }
    }

    /**
     * Announce current step to screen readers
     */
    function announceStep($step, index, total) {
        const $title = $step.find('.promen-solicitation-timeline__title');
        const titleText = $title.length ? $title.text().trim() : '';

        let message = `Step ${index + 1} of ${total}`;
        if (titleText) {
            message += `: ${titleText}`;
        }

        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.announce(message);
        }
    }

    // Expose for external use
    window.PromenSolicitationTimelineAccessibility = {
        init: initSolicitationTimelineAccessibility
    };

})(jQuery);
