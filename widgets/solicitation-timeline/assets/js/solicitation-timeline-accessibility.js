/**
 * Solicitation Timeline Accessibility
 * 
 * Implements WCAG 2.2 compliant reduced motion support, screen reader 
 * announcements, and focus management for the Solicitation Timeline widget.
 * 
 * Uses the centralized PromenAccessibility core library with i18n support.
 */
(function ($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function () {
        initSolicitationTimelineAccessibility();
    });

    // Initialize when Elementor frontend is initialized (for editor preview)
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/promen_solicitation_timeline.default',
                initSolicitationTimelineAccessibility
            );
        }
    };

    if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

    /**
     * Get localized string helper
     */
    function getString(key, ...args) {
        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.getString) {
            return PromenAccessibility.getString(key, ...args);
        }
        // Fallback
        const fallbacks = {
            solicitationTimelineLabel: 'Sollicitatieproces tijdlijn',
            timelineWithSteps: 'Tijdlijn met {0} stappen',
            stepOf: 'Stap {0} van {1}',
            skipTimeline: 'Sla tijdlijn over',
            timelineAnimationsDisabled: 'Tijdlijn animaties uitgeschakeld vanwege voorkeur voor verminderde beweging'
        };
        let str = fallbacks[key] || key;
        args.forEach((arg, index) => {
            str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
        });
        return str;
    }

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
        setupSkipLink($timeline);
        announceTimelineLoaded($timeline);
    }

    /**
     * Setup skip link
     */
    function setupSkipLink($timeline) {
        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.setupSkipLink($timeline[0], getString('skipTimeline'));
        }
    }

    /**
     * Setup ARIA attributes for the timeline
     */
    function setupARIA($timeline) {
        $timeline.attr({
            'role': 'list',
            'aria-label': getString('solicitationTimelineLabel')
        });

        const steps = $timeline.find('.promen-solicitation-timeline__step');
        steps.each(function (index) {
            const $step = $(this);
            const stepNumber = index + 1;
            const totalSteps = steps.length;

            $step.attr({
                'role': 'listitem',
                'aria-label': getString('stepOf', stepNumber, totalSteps)
            });

            const $marker = $step.find('.promen-solicitation-timeline__marker');
            if ($marker.length) {
                $marker.attr({
                    'role': 'presentation',
                    'aria-hidden': 'true'
                });
            }

            const $content = $step.find('.promen-solicitation-timeline__content');
            if ($content.length) {
                $content.attr('role', 'group');

                const $title = $content.find('.promen-solicitation-timeline__title');
                if ($title.length) {
                    const titleText = $title.text().trim();
                    $step.attr('aria-label', getString('stepOf', stepNumber, totalSteps) + ': ' + titleText);
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
            $timeline.addClass('reduced-motion-active');

            if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
                const triggers = ScrollTrigger.getAll();
                triggers.forEach(function (trigger) {
                    if (trigger.trigger && $.contains($timeline[0], trigger.trigger)) {
                        trigger.kill();
                    }
                });
            }

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

            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.announce(getString('timelineAnimationsDisabled'));
            }
        }

        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.registerAnimation) {
            PromenAccessibility.registerAnimation('solicitation-timeline', function () {
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

        steps.attr('tabindex', '0');

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
            PromenAccessibility.announce(getString('timelineWithSteps', stepCount));
        }
    }

    /**
     * Announce current step to screen readers
     */
    function announceStep($step, index, total) {
        const $title = $step.find('.promen-solicitation-timeline__title');
        const titleText = $title.length ? $title.text().trim() : '';

        let message = getString('stepOf', index + 1, total);
        if (titleText) {
            message += `: ${titleText}`;
        }

        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.announce(message);
        }
    }

    window.PromenSolicitationTimelineAccessibility = {
        init: initSolicitationTimelineAccessibility
    };

})(jQuery);
