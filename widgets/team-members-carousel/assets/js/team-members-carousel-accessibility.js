/**
 * Team Members Carousel Accessibility
 * 
 * Implements WCAG 2.2 compliant keyboard navigation, ARIA management,
 * and screen reader support for the Team Members Carousel widget.
 * 
 * Uses the centralized PromenAccessibility core library with i18n support.
 */
(function ($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function () {
        initTeamMembersCarouselAccessibility();
    });

    // Initialize when Elementor frontend is initialized (for editor preview)
    const initElementorHooks = () => {
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.hooks) {
            elementorFrontend.hooks.addAction(
                'frontend/element_ready/promen_team_members_carousel.default',
                initTeamMembersCarouselAccessibility
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
            teamMembersCarouselLabel: 'Teamleden carrousel',
            slideOf: 'Dia {0} van {1}',
            previousTeamMember: 'Vorig teamlid',
            nextTeamMember: 'Volgend teamlid',
            slideLabel: 'dia',
            skipTeamCarousel: 'Sla over naar inhoud',
            reducedMotionEnabled: 'Animaties uitgeschakeld vanwege voorkeur voor verminderde beweging'
        };
        let str = fallbacks[key] || key;
        args.forEach((arg, index) => {
            str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
        });
        return str;
    }

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
        setupReducedMotion($carousel, swiper);
        setupSlideAnnouncements($carousel, swiper);
        setupNavigationButtons($carousel, swiper);
        setupSkipLink($carousel);
    }

    function setupSkipLink($carousel) {
        if (typeof PromenAccessibility !== 'undefined') {
            PromenAccessibility.setupSkipLink($carousel[0], getString('skipTeamCarousel'));
        }
    }

    /**
     * Setup ARIA attributes for the carousel
     */
    function setupARIA($carousel, swiper) {
        const container = $carousel.find('.swiper')[0];
        const slides = $carousel.find('.swiper-slide');

        container.setAttribute('role', 'region');
        container.setAttribute('aria-label', getString('teamMembersCarouselLabel'));
        container.setAttribute('aria-roledescription', 'carousel');

        slides.each(function (index) {
            const slide = $(this);
            slide.attr('role', 'group');
            slide.attr('aria-roledescription', getString('slideLabel'));
            slide.attr('aria-label', getString('slideOf', index + 1, slides.length));

            const memberCard = slide.find('.promen-team-member-card');
            if (memberCard.length && !memberCard.attr('tabindex')) {
                memberCard.attr('tabindex', '0');
            }
        });

        swiper.on('slideChange', function () {
            updateSlideARIA($carousel, swiper);
        });

        updateSlideARIA($carousel, swiper);
    }

    function updateSlideARIA($carousel, swiper) {
        const slides = $carousel.find('.swiper-slide');

        slides.each(function (index) {
            const slide = $(this);
            const isVisible = index >= swiper.activeIndex &&
                index < swiper.activeIndex + (swiper.params.slidesPerView || 1);

            slide.attr('aria-hidden', !isVisible);
            slide.find('a, button, [tabindex]').attr('tabindex', isVisible ? '0' : '-1');
        });
    }

    function setupKeyboardNavigation($carousel, swiper) {
        const container = $carousel.find('.swiper')[0];

        if (!container.hasAttribute('tabindex')) {
            container.setAttribute('tabindex', '0');
        }

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

    function setupReducedMotion($carousel, swiper) {
        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.isReducedMotion()) {
            swiper.params.speed = 0;

            if (swiper.autoplay && swiper.autoplay.running) {
                swiper.autoplay.stop();
            }

            $carousel.addClass('reduced-motion-active');
        }

        if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.registerAnimation) {
            PromenAccessibility.registerAnimation('team-members-carousel', function () {
                if (swiper.autoplay && swiper.autoplay.running) {
                    swiper.autoplay.stop();
                }
            });
        }
    }

    function setupSlideAnnouncements($carousel, swiper) {
        swiper.on('slideChangeTransitionEnd', function () {
            announceSlideChange($carousel, swiper);
        });
    }

    function announceSlideChange($carousel, swiper) {
        const currentSlide = swiper.activeIndex + 1;
        const totalSlides = swiper.slides.length;

        const activeSlide = $(swiper.slides[swiper.activeIndex]);
        const memberName = activeSlide.find('.promen-team-member-card__name').text().trim();
        const memberRole = activeSlide.find('.promen-team-member-card__role').text().trim();

        let message = getString('slideOf', currentSlide, totalSlides);
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

    function setupNavigationButtons($carousel, swiper) {
        const prevBtn = $carousel.find('.swiper-button-prev');
        const nextBtn = $carousel.find('.swiper-button-next');

        prevBtn.attr({
            'role': 'button',
            'aria-label': getString('previousTeamMember'),
            'tabindex': '0'
        });

        nextBtn.attr({
            'role': 'button',
            'aria-label': getString('nextTeamMember'),
            'tabindex': '0'
        });

        prevBtn.add(nextBtn).on('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                $(this).trigger('click');
            }
        });

        swiper.on('slideChange', function () {
            updateNavigationState($carousel, swiper);
        });

        updateNavigationState($carousel, swiper);
    }

    function updateNavigationState($carousel, swiper) {
        const prevBtn = $carousel.find('.swiper-button-prev');
        const nextBtn = $carousel.find('.swiper-button-next');

        if (!swiper.params.loop) {
            prevBtn.attr('aria-disabled', swiper.isBeginning ? 'true' : 'false');
            nextBtn.attr('aria-disabled', swiper.isEnd ? 'true' : 'false');
        }
    }

    window.PromenTeamMembersCarouselAccessibility = {
        init: initTeamMembersCarouselAccessibility
    };

})(jQuery);
