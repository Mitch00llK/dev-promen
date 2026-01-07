/**
 * Certification Logos Widget JS
 * 
 * Handles Swiper initialization for the mobile slider
 */

(function ($) {
    'use strict';

    const CertificationLogos = {
        /**
         * Initialize the widget
         */
        init: function () {
            const self = this;

            // Handle Elementor editor changes
            $(window).on('elementor/frontend/init', function () {
                elementorFrontend.hooks.addAction('frontend/element_ready/promen_certification_logos.default', function ($scope) {
                    self.initWidget($scope);
                });
            });

            // Regular initialization
            $('.promen-certification-logos').each(function () {
                self.initWidget($(this));
            });
        },

        /**
         * Initialize a specific widget instance
         */
        initWidget: function ($scope) {
            const $slider = $scope.find('.mobile-slider');
            const $grid = $scope.find('.logos-grid');
            const uniqueId = $scope.attr('id');
            let logoSwiper = null;

            if (!$slider.length) return;

            const logoCount = $slider.find('.swiper-slide').length;

            const initSwiper = function () {
                if (window.innerWidth < 1024) {
                    if (!logoSwiper) {
                        $slider.show();
                        $grid.hide();

                        logoSwiper = new Swiper($slider[0], {
                            slidesPerView: 3,
                            spaceBetween: 30,
                            watchOverflow: true,
                            loop: logoCount > 1,
                            autoplay: {
                                delay: 3000,
                                disableOnInteraction: false,
                            },
                            pagination: {
                                el: $slider.find('.swiper-pagination')[0],
                                clickable: true,
                            },
                            navigation: {
                                nextEl: $slider.find('.swiper-button-next')[0],
                                prevEl: $slider.find('.swiper-button-prev')[0],
                            },
                            breakpoints: {
                                320: {
                                    slidesPerView: 1,
                                    spaceBetween: 20
                                },
                                480: {
                                    slidesPerView: 2,
                                    spaceBetween: 20
                                },
                                768: {
                                    slidesPerView: 3,
                                    spaceBetween: 30
                                }
                            }
                        });
                    }
                } else {
                    if (logoSwiper) {
                        logoSwiper.destroy(true, true);
                        logoSwiper = null;
                        $slider.hide();
                        $grid.show();
                    }
                }
            };

            // Initialize on load
            initSwiper();

            // Handle window resize
            let resizeTimer;
            $(window).on('resize', function () {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function () {
                    initSwiper();
                }, 250);
            });
        }
    };

    $(document).ready(function () {
        CertificationLogos.init();
    });

})(jQuery);
