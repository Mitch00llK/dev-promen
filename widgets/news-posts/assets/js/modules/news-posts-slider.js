/**
 * News Posts Widget Slider Initialization
 */

(function ($) {
    'use strict';

    function initNewsSlider() {
        $('.promen-news-slider').each(function () {
            var $slider = $(this);
            var $container = $slider.closest('.promen-news-slider-container');

            // Skip if already initialized
            if ($slider.hasClass('swiper-container-initialized')) return;

            // Get attributes
            var slidesPerView = $slider.data('slides-per-view') || 1;
            var spaceBetween = $slider.data('space-between') || 30;
            var navigation = $slider.data('navigation') === true;
            var pagination = $slider.data('pagination') === true;
            var loop = $slider.data('loop') === true;
            var autoplay = $slider.data('autoplay') === true;
            var effect = $slider.data('effect') || 'slide';
            var breakpoints = $slider.data('breakpoints');

            var swiperOptions = {
                slidesPerView: slidesPerView,
                spaceBetween: spaceBetween,
                loop: loop,
                effect: effect,
                speed: 600,
                autoHeight: true,
                watchOverflow: true,
                navigation: navigation ? {
                    nextEl: $slider.find('.swiper-button-next')[0],
                    prevEl: $slider.find('.swiper-button-prev')[0],
                } : false,
                pagination: pagination ? {
                    el: $slider.find('.swiper-pagination')[0],
                    clickable: true,
                } : false,
                on: {
                    init: function () {
                        $slider.addClass('swiper-container-initialized');
                        $container.addClass('slider-loaded');
                    }
                }
            };

            if (autoplay) {
                swiperOptions.autoplay = {
                    delay: $slider.data('autoplay-delay') || 5000,
                    disableOnInteraction: false,
                };
            }

            if (breakpoints) {
                swiperOptions.breakpoints = breakpoints;
            }

            // Initialize Swiper
            new Swiper($slider[0], swiperOptions);
        });

        // Ensure Grid is visible (Legacy support/Grid View)
        $('.promen-content-posts-widget').removeClass('promen-widget-loading');
    }

    // Initialize on document ready
    $(document).ready(function () {
        initNewsSlider();
    });

    // Initialize on Elementor frontend action
    $(window).on('elementor/frontend/init', function () {
        elementorFrontend.hooks.addAction('frontend/element_ready/promen_news_posts.default', function ($scope) {
            initNewsSlider();
        });
    });

})(jQuery);
