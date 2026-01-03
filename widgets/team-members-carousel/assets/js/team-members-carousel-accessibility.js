/**
 * Team Members Carousel Accessibility
 * 
 * Implements WCAG 2.2 compliant keyboard navigation, ARIA management,
 * and screen reader support for the Team Members Carousel widget.
 * 
 * Uses the centralized PromenAccessibility core library.
 */
(function ($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function () {
        initTeamMembersCarouselAccessibility();
    });

    // Initialize when Elementor frontend is initialized (for editor preview)
    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/promen_team_members_carousel.default',
                initTeamMembersCarouselAccessibility
            );
        }
    });

    /**
     * Initialize accessibility features for all carousels
     */
    function initTeamMembersCarouselAccessibility() {
        $('.promen-team-members-carousel').each(function () {
            initSingleCarouselAccessibility($(this));
        });
    }

    /**
     * Initialize accessibility for a single carousel
     */
    function initSingleCarouselAccessibility($carousel) {
        if ($carousel.length === 0 || $carousel.data('accessibility-initialized')) {
            return;
        }

        $carousel.data('accessibility-initialized', true);

        // Get Swiper instance
        const swiperEl = $carousel.find('.swiper')[0];
        if (!swiperEl || !swiperEl.swiper) {
            // Retry after a short delay if Swiper isn't initialized yet
            setTimeout(function () {
                if (swiperEl && swiperEl.swiper) {
                    setupAccessibility($carousel, swiperEl.swiper);
                }
            }, 500);
            return;
        }

        setupAccessibility($carousel, swiperEl.swiper);
    }

    /**
     * Setup all accessibility features
     */
    function setupAccessibility($carousel, swiper) {
        setupARIA($carousel, swiper);
        setupKeyboardNavigation($carousel, swiper);
        setupReducedMotion($carousel, swiper);
        setupSlideAnnouncements($carousel, swiper);
        setupNavigationButtons($carousel, swiper);
    }

    /**
     * Setup ARIA attributes for the carousel
     */
    function setupARIA($carousel, swiper) {
        const container = $carousel.find('.swiper')[0];
        const slides = $carousel.find('.swiper-slide');

        // Set up carousel container
        container.setAttribute('role', 'region');
        container.setAttribute('aria-label', 'Team Members Carousel');
        container.setAttribute('aria-roledescription', 'carousel');

        // Set up slides
        slides.each(function (index) {
            const slide = $(this);
            slide.attr('role', 'group');
            slide.attr('aria-roledescription', 'slide');
            slide.attr('aria-label', `Slide ${index + 1} of ${slides.length}`);

            // Ensure slide content is focusable
            const memberCard = slide.find('.promen-team-member-card');
            if (memberCard.length && !memberCard.attr('tabindex')) {
                memberCard.attr('tabindex', '0');
            }
        });

        // Update ARIA on slide change
        swiper.on('slideChange', function () {
            updateSlideARIA($carousel, swiper);
        });

        // Initial update
        updateSlideARIA($carousel, swiper);
    }

    /**
     * Update ARIA attributes when slide changes
     */
    function updateSlideARIA($carousel, swiper) {
        const slides = $carousel.find('.swiper-slide');

        slides.each(function (index) {
            const slide = $(this);
            const isActive = index === swiper.activeIndex;
            const isVisible = index >= swiper.activeIndex &&
                index < swiper.activeIndex + (swiper.params.slidesPerView || 1);

            slide.attr('aria-hidden', !isVisible);
            slide.find('a, button, [tabindex]').attr('tabindex', isVisible ? '0' : '-1');
        });
    }

    /**
     * Setup keyboard navigation
     */
    function setupKeyboardNavigation($carousel, swiper) {
        const container = $carousel.find('.swiper')[0];

        // Make container focusable
        if (!container.hasAttribute('tabindex')) {
            container.setAttribute('tabindex', '0');
        }

        // Handle keyboard events
        $(container).on('keydown', function (e) {
            switch (e.key) {
                case 'ArrowLeft':
                    e.preventDefault();
                    swiper.slidePrev();
                    announceSlideChange($carousel, swiper);
                    break;
                case 'ArrowRight':
                    e.preventDefault();
                    swiper.slideNext();
                    announceSlideChange($carousel, swiper);
                    break;
                case 'Home':
                    e.preventDefault();
                    swiper.slideTo(0);
                    announceSlideChange($carousel, swiper);
                    break;
                case 'End':
                    e.preventDefault();
                    swiper.slideTo(swiper.slides.length - 1);
                    announceSlideChange($carousel, swiper);
                    break;
            }
        });
    }

    /**
     * Setup reduced motion support
     */
    function setupReducedMotion($carousel, swiper) {
        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.isReducedMotion()) {
            // Disable transitions
            swiper.params.speed = 0;

            // Disable autoplay if enabled
            if (swiper.autoplay && swiper.autoplay.running) {
                swiper.autoplay.stop();
            }

            // Add visual indicator
            $carousel.addClass('reduced-motion-active');
        }

        // Register with global animation controller
        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.registerAnimation) {
            PromenAccessibility.registerAnimation('team-members-carousel', function () {
                if (swiper.autoplay && swiper.autoplay.running) {
                    swiper.autoplay.stop();
                }
            });
        }
    }

    /**
     * Setup slide change announcements
     */
    function setupSlideAnnouncements($carousel, swiper) {
        swiper.on('slideChangeTransitionEnd', function () {
            announceSlideChange($carousel, swiper);
        });
    }

    /**
     * Announce slide change to screen readers
     */
    function announceSlideChange($carousel, swiper) {
        const currentSlide = swiper.activeIndex + 1;
        const totalSlides = swiper.slides.length;

        // Get member name from current slide
        const activeSlide = $(swiper.slides[swiper.activeIndex]);
        const memberName = activeSlide.find('.promen-team-member-card__name').text().trim();
        const memberRole = activeSlide.find('.promen-team-member-card__role').text().trim();

        let message = `Slide ${currentSlide} of ${totalSlides}`;
        if (memberName) {
            message += `: ${memberName}`;
            if (memberRole) {
                message += `, ${memberRole}`;
            }
        }

        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.announce(message);
        }
    }

    /**
     * Setup accessible navigation buttons
     */
    function setupNavigationButtons($carousel, swiper) {
        const prevBtn = $carousel.find('.swiper-button-prev');
        const nextBtn = $carousel.find('.swiper-button-next');

        // Ensure buttons have proper ARIA
        prevBtn.attr({
            'role': 'button',
            'aria-label': 'Previous team member',
            'tabindex': '0'
        });

        nextBtn.attr({
            'role': 'button',
            'aria-label': 'Next team member',
            'tabindex': '0'
        });

        // Handle keyboard activation
        prevBtn.add(nextBtn).on('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        // Update button states
        swiper.on('slideChange', function () {
            updateNavigationState($carousel, swiper);
        });

        // Initial state
        updateNavigationState($carousel, swiper);
    }

    /**
     * Update navigation button disabled states
     */
    function updateNavigationState($carousel, swiper) {
        const prevBtn = $carousel.find('.swiper-button-prev');
        const nextBtn = $carousel.find('.swiper-button-next');

        if (!swiper.params.loop) {
            prevBtn.attr('aria-disabled', swiper.isBeginning ? 'true' : 'false');
            nextBtn.attr('aria-disabled', swiper.isEnd ? 'true' : 'false');
        }
    }

    // Expose for external use
    window.PromenTeamMembersCarouselAccessibility = {
        init: initTeamMembersCarouselAccessibility
    };

})(jQuery);
