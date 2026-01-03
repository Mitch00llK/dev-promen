/**
 * Promen Image Text Block Widget Accessibility JavaScript
 * Implements WCAG 2.2 compliant keyboard navigation and ARIA management
 */
(function($) {
    'use strict';

    // Initialize on document ready
    $(document).ready(function() {
        initImageTextBlockAccessibility();
    });

    // Initialize when Elementor frontend is initialized (for editor preview)
    $(window).on('elementor/frontend/init', function() {
        if (typeof elementorFrontend !== 'undefined') {
            elementorFrontend.hooks.addAction('frontend/element_ready/promen_image_text_block.default', initImageTextBlockAccessibility);
        }
    });

    /**
     * Initialize accessibility features for all image text blocks
     */
    function initImageTextBlockAccessibility() {
        $('.promen-image-text-block').each(function() {
            initSingleBlockAccessibility($(this));
        });
    }

    /**
     * Initialize accessibility features for a single image text block
     */
    function initSingleBlockAccessibility($block) {
        if ($block.length === 0) {
            return;
        }

        // Initialize tabs accessibility if in tabs mode
        if ($block.hasClass('promen-image-text-block--tabs') || $block.hasClass('promen-tabs-mode')) {
            initTabsAccessibility($block);
        }

        // Initialize button accessibility
        initButtonAccessibility($block);

        // Initialize image accessibility
        initImageAccessibility($block);

        // Initialize skip links
        initSkipLinks($block);
    }

    /**
     * Initialize tabs accessibility with keyboard navigation
     */
    function initTabsAccessibility($block) {
        var $tabs = $block.find('[role="tab"]');
        var $tabpanels = $block.find('[role="tabpanel"]');
        var $tablist = $block.find('[role="tablist"]');

        if ($tabs.length === 0) {
            return;
        }

        // Handle keyboard navigation
        $tabs.on('keydown', function(e) {
            var $currentTab = $(this);
            var currentIndex = $tabs.index($currentTab);
            var $nextTab, $prevTab;

            switch (e.key) {
                case 'ArrowRight':
                case 'ArrowDown':
                    e.preventDefault();
                    $nextTab = $tabs.eq((currentIndex + 1) % $tabs.length);
                    switchToTab($nextTab, $block);
                    break;

                case 'ArrowLeft':
                case 'ArrowUp':
                    e.preventDefault();
                    $prevTab = $tabs.eq(currentIndex === 0 ? $tabs.length - 1 : currentIndex - 1);
                    switchToTab($prevTab, $block);
                    break;

                case 'Home':
                    e.preventDefault();
                    switchToTab($tabs.first(), $block);
                    break;

                case 'End':
                    e.preventDefault();
                    switchToTab($tabs.last(), $block);
                    break;

                case 'Enter':
                case ' ':
                    e.preventDefault();
                    switchToTab($currentTab, $block);
                    break;

                case 'Escape':
                    // Return focus to the tablist
                    $tablist.focus();
                    break;
            }
        });

        // Handle click events (for mouse users)
        $tabs.on('click', function(e) {
            e.preventDefault();
            switchToTab($(this), $block);
        });

        // Handle focus events
        $tabs.on('focus', function() {
            $(this).addClass('focused');
        }).on('blur', function() {
            $(this).removeClass('focused');
        });

        // Initialize ARIA live region for announcements
        if ($block.find('.promen-aria-live').length === 0) {
            $block.append('<div class="promen-aria-live" aria-live="polite" aria-atomic="true" style="position: absolute; left: -10000px; width: 1px; height: 1px; overflow: hidden;"></div>');
        }
    }

    /**
     * Switch to a specific tab with proper ARIA management
     */
    function switchToTab($tab, $block) {
        var tabId = $tab.attr('id');
        var panelId = $tab.attr('aria-controls');
        var tabTitle = $tab.find('.promen-image-text-block__tab-title').text();

        // Update tab states
        $block.find('[role="tab"]').each(function() {
            var $this = $(this);
            var isActive = $this.attr('id') === tabId;

            $this.attr('aria-selected', isActive);
            $this.attr('aria-expanded', isActive ? 'true' : 'false');
            $this.attr('tabindex', isActive ? '0' : '-1');
            $this.toggleClass('active', isActive);
        });

        // Update panel states - handle both individual tabpanels and the main tabpanel container
        $block.find('[role="tabpanel"]').each(function() {
            var $this = $(this);
            var isActive = $this.attr('id') === panelId;

            // For individual tab content panels
            if ($this.hasClass('promen-tab-content')) {
                $this.attr('aria-hidden', !isActive);
                $this.attr('tabindex', isActive ? '0' : '-1');
                $this.toggleClass('active', isActive);
                $this.toggleClass('promen-tab-hidden', !isActive);

                if (isActive) {
                    $this.css({
                        'display': 'block',
                        'opacity': '1',
                        'visibility': 'visible',
                        'position': 'relative'
                    });
                } else {
                    $this.css({
                        'display': 'none',
                        'opacity': '0',
                        'visibility': 'hidden'
                    });
                }
            }
        });

        // Update image states
        $block.find('.promen-tab-image').each(function() {
            var $this = $(this);
            var isActive = $this.data('tab') === tabId;

            $this.toggleClass('active', isActive);
            $this.toggleClass('promen-tab-hidden', !isActive);
            $this.attr('aria-hidden', !isActive);

            if (isActive) {
                $this.css({
                    'display': 'block',
                    'opacity': '1',
                    'visibility': 'visible'
                });
            } else {
                $this.css({
                    'display': 'none',
                    'opacity': '0',
                    'visibility': 'hidden'
                });
            }
        });

        // Focus the tab
        $tab.focus();

        // Announce the change to screen readers
        var $liveRegion = $block.find('.promen-aria-live');
        if ($liveRegion.length > 0) {
            $liveRegion.text('Switched to ' + tabTitle + ' tab');
        }

        // Trigger custom event for other scripts
        $block.trigger('tabChanged', [tabId, panelId, tabTitle]);
    }

    /**
     * Initialize button accessibility
     */
    function initButtonAccessibility($block) {
        var $buttons = $block.find('.promen-image-text-block__button');

        $buttons.each(function() {
            var $button = $(this);

            // Ensure proper focus indicators
            $button.on('focus', function() {
                $(this).addClass('focused');
            }).on('blur', function() {
                $(this).removeClass('focused');
            });

            // Handle keyboard activation
            $button.on('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.click();
                }
            });
        });
    }

    /**
     * Initialize image accessibility
     */
    function initImageAccessibility($block) {
        var $images = $block.find('img');

        $images.each(function() {
            var $img = $(this);

            // Ensure all images have alt attributes
            if (!$img.attr('alt')) {
                $img.attr('alt', 'Content image');
            }

            // Add loading and decoding attributes for performance
            if (!$img.attr('loading')) {
                $img.attr('loading', 'lazy');
            }
            if (!$img.attr('decoding')) {
                $img.attr('decoding', 'async');
            }
        });
    }

    /**
     * Initialize skip links for keyboard navigation
     */
    function initSkipLinks($block) {
        var $skipLink = $block.find('.promen-skip-link');

        if ($skipLink.length === 0) {
            // Add skip link if it doesn't exist
            $block.prepend('<a href="#' + $block.attr('id') + '" class="promen-skip-link" style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden; visibility: hidden;">Sla over naar inhoud</a>');
            $skipLink = $block.find('.promen-skip-link');
        }

        $skipLink.on('focus', function() {
            $(this).css({
                'position': 'static',
                'left': 'auto',
                'top': 'auto',
                'width': 'auto',
                'height': 'auto',
                'overflow': 'visible'
            });
        }).on('blur', function() {
            $(this).css({
                'position': 'absolute',
                'left': '-10000px',
                'top': 'auto',
                'width': '1px',
                'height': '1px',
                'overflow': 'hidden'
            });
        });
    }

    /**
     * Handle reduced motion preferences
     */
    function handleReducedMotion() {
        if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
            $('.promen-image-text-block').addClass('reduced-motion');
        }
    }

    // Initialize reduced motion handling
    if (window.matchMedia) {
        window.matchMedia('(prefers-reduced-motion: reduce)').addListener(handleReducedMotion);
        handleReducedMotion();
    }

    /**
     * Handle high contrast mode
     */
    function handleHighContrast() {
        if (window.matchMedia('(prefers-contrast: high)').matches) {
            $('.promen-image-text-block').addClass('high-contrast');
        }
    }

    // Initialize high contrast handling
    if (window.matchMedia) {
        window.matchMedia('(prefers-contrast: high)').addListener(handleHighContrast);
        handleHighContrast();
    }

    /**
     * Announce dynamic content changes
     */
    function announceContentChange($block, message) {
        var $liveRegion = $block.find('.promen-aria-live');
        if ($liveRegion.length > 0) {
            $liveRegion.text(message);
        }
    }

    // Expose functions for external use
    window.PromenImageTextBlockAccessibility = {
        switchToTab: switchToTab,
        announceContentChange: announceContentChange,
        initSingleBlockAccessibility: initSingleBlockAccessibility
    };

})(jQuery);