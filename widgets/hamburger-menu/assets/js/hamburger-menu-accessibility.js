/**
 * Hamburger Menu Accessibility Enhancement
 * WCAG 2.1/2.2 compliant navigation functionality
 */

(function ($) {
    'use strict';

    const HamburgerMenuAccessibility = {

        init: function () {
            this.bindEvents();
            this.enhanceExistingMenus();
        },

        bindEvents: function () {
            // Initialize menus when they become visible
            $(document).on('elementor/popup/show', this.initMenus.bind(this));
            $(window).on('load', this.initMenus.bind(this));

            // Handle keyboard navigation
            $(document).on('keydown', '.hamburger-menu', this.handleKeyboard.bind(this));

            // Handle menu toggle
            $(document).on('click', '.hamburger-menu__toggle', this.toggleMenu.bind(this));

            // Handle close button
            $(document).on('click', '.hamburger-menu__close', this.closeMenu.bind(this));

            // Handle submenu toggles
            $(document).on('click', '.submenu-toggle', this.toggleSubmenu.bind(this));

            // Handle outside clicks
            $(document).on('click', this.handleOutsideClick.bind(this));

            // Handle focus events
            $(document).on('focus', '.hamburger-menu__panel a, .hamburger-menu__panel button', this.handleMenuFocus.bind(this));

            // Handle escape key globally
            $(document).on('keydown', this.handleGlobalKeyboard.bind(this));
        },

        initMenus: function () {
            $('.hamburger-menu').each(function () {
                const $menu = $(this);
                if (!$menu.data('accessibility-enhanced')) {
                    HamburgerMenuAccessibility.enhanceMenu($menu);
                    if (typeof PromenAccessibility !== 'undefined') {
                        PromenAccessibility.setupReducedMotion($menu[0]);
                        PromenAccessibility.setupSkipLink($menu[0], 'Sla over naar inhoud');
                    }
                }
            });
        },

        enhanceExistingMenus: function () {
            // Wait for menus to be initialized, then enhance them
            setTimeout(this.initMenus.bind(this), 500);

            // Also try after a longer delay for dynamic content
            setTimeout(this.initMenus.bind(this), 2000);
        },

        enhanceMenu: function ($menu) {
            $menu.data('accessibility-enhanced', true);

            const menuId = $menu.attr('id');
            const $toggle = $menu.find('.hamburger-menu__toggle');
            const $panel = $menu.find('.hamburger-menu__panel');
            const $closeBtn = $menu.find('.hamburger-menu__close');

            // Set up proper IDs and relationships
            if (menuId && !$toggle.attr('id')) {
                $toggle.attr('id', menuId + '-toggle');
            }

            // Add submenu toggles to parent items
            this.addSubmenuToggles($menu);

            // Set up focus trap
            this.setupFocusTrap($menu);

            // Set up keyboard navigation
            this.setupKeyboardNavigation($menu);

            // Initialize closed state
            this.setMenuState($menu, false);
        },

        addSubmenuToggles: function ($menu) {
            const $parentItems = $menu.find('.has-submenu, .menu-item-has-children');

            $parentItems.each(function () {
                const $item = $(this);
                const $link = $item.find('> a').first();
                const $submenu = $item.find('> .sub-menu').first();

                if ($submenu.length && !$item.find('.submenu-toggle').length) {
                    const toggleId = 'submenu-toggle-' + Math.random().toString(36).substr(2, 9);
                    const submenuId = 'submenu-' + Math.random().toString(36).substr(2, 9);

                    // Create submenu toggle button
                    const $toggle = $(`
                        <button type="button" 
                                class="submenu-toggle" 
                                id="${toggleId}"
                                aria-expanded="false" 
                                aria-controls="${submenuId}"
                                aria-label="${HamburgerMenuAccessibility.getToggleLabel($link.text(), false)}">
                            <span class="toggle-icon" aria-hidden="true">▼</span>
                            <span class="screen-reader-text">Expand ${$link.text()} submenu</span>
                        </button>
                    `);

                    // Add IDs and ARIA attributes to submenu
                    $submenu.attr('id', submenuId)
                        .attr('aria-labelledby', toggleId)
                        .attr('aria-hidden', 'true')
                        .addClass('submenu-collapsed');

                    // Insert toggle button after the link
                    $link.after($toggle);

                    // Set parent item attributes
                    $item.attr('aria-haspopup', 'true');
                }
            });
        },

        setupFocusTrap: function ($menu) {
            const $panel = $menu.find('.hamburger-menu__panel');

            $panel.on('keydown', function (e) {
                if (e.key === 'Tab') {
                    const $focusable = $panel.find('a, button, input, select, textarea, [tabindex]:not([tabindex="-1"])').filter(':visible');

                    if ($focusable.length === 0) return;

                    const $first = $focusable.first();
                    const $last = $focusable.last();

                    if (e.shiftKey && document.activeElement === $first[0]) {
                        e.preventDefault();
                        $last.focus();
                    } else if (!e.shiftKey && document.activeElement === $last[0]) {
                        e.preventDefault();
                        $first.focus();
                    }
                }
            });
        },

        setupKeyboardNavigation: function ($menu) {
            const $menuItems = $menu.find('.hamburger-menu__items a');

            $menuItems.on('keydown', function (e) {
                const $current = $(this);
                const $items = $menu.find('.hamburger-menu__items a:visible');
                const currentIndex = $items.index($current);

                let $target = null;

                switch (e.key) {
                    case 'ArrowUp':
                        e.preventDefault();
                        $target = currentIndex > 0 ? $items.eq(currentIndex - 1) : $items.last();
                        break;

                    case 'ArrowDown':
                        e.preventDefault();
                        $target = currentIndex < $items.length - 1 ? $items.eq(currentIndex + 1) : $items.first();
                        break;

                    case 'Home':
                        e.preventDefault();
                        $target = $items.first();
                        break;

                    case 'End':
                        e.preventDefault();
                        $target = $items.last();
                        break;

                    case 'ArrowRight':
                        // Open submenu if available
                        const $toggle = $current.siblings('.submenu-toggle');
                        if ($toggle.length && $toggle.attr('aria-expanded') === 'false') {
                            e.preventDefault();
                            $toggle.click();

                            // Focus first submenu item
                            setTimeout(() => {
                                const $submenu = $current.parent().find('.sub-menu a:visible').first();
                                if ($submenu.length) {
                                    $submenu.focus();
                                }
                            }, 100);
                        }
                        break;

                    case 'ArrowLeft':
                        // Close submenu or go to parent
                        const $parentItem = $current.closest('.sub-menu').parent();
                        if ($parentItem.length) {
                            e.preventDefault();
                            const $parentToggle = $parentItem.find('> .submenu-toggle');
                            if ($parentToggle.length && $parentToggle.attr('aria-expanded') === 'true') {
                                $parentToggle.click();
                                $parentItem.find('> a').focus();
                            }
                        }
                        break;
                }

                if ($target) {
                    $target.focus();
                }
            });
        },

        toggleMenu: function (e) {
            e.preventDefault();
            const $toggle = $(this);
            const $menu = $toggle.closest('.hamburger-menu');
            const $panel = $menu.find('.hamburger-menu__panel');
            const isOpen = $toggle.attr('aria-expanded') === 'true';

            HamburgerMenuAccessibility.setMenuState($menu, !isOpen);

            if (!isOpen) {
                // Menu opening - focus close button or first menu item
                setTimeout(() => {
                    const $closeBtn = $panel.find('.hamburger-menu__close');
                    const $firstItem = $panel.find('a:visible').first();

                    if ($closeBtn.length) {
                        $closeBtn.focus();
                    } else if ($firstItem.length) {
                        $firstItem.focus();
                    }
                }, 100);

                // Prevent body scroll
                $('body').addClass('hamburger-menu-open');

                // Announce to screen readers
                HamburgerMenuAccessibility.announceToUser('Navigation menu opened');

            } else {
                // Menu closing - restore focus to toggle
                $toggle.focus();
                $('body').removeClass('hamburger-menu-open');

                HamburgerMenuAccessibility.announceToUser('Navigation menu closed');
            }
        },

        closeMenu: function (e) {
            e.preventDefault();
            const $closeBtn = $(this);
            const $menu = $closeBtn.closest('.hamburger-menu');
            const $toggle = $menu.find('.hamburger-menu__toggle');

            HamburgerMenuAccessibility.setMenuState($menu, false);

            // Restore focus to toggle button
            $toggle.focus();
            $('body').removeClass('hamburger-menu-open');

            HamburgerMenuAccessibility.announceToUser('Navigation menu closed');
        },

        toggleSubmenu: function (e) {
            e.preventDefault();
            const $toggle = $(this);
            const $submenu = $('#' + $toggle.attr('aria-controls'));
            const isOpen = $toggle.attr('aria-expanded') === 'true';
            const $parentLink = $toggle.siblings('a').first();
            const linkText = $parentLink.text();

            // Toggle states
            $toggle.attr('aria-expanded', !isOpen);
            $submenu.attr('aria-hidden', isOpen);

            if (isOpen) {
                $submenu.addClass('submenu-collapsed').removeClass('submenu-expanded');
                $toggle.find('.toggle-icon').text('▼');
                $toggle.attr('aria-label', HamburgerMenuAccessibility.getToggleLabel(linkText, false));
                $toggle.find('.screen-reader-text').text(`Expand ${linkText} submenu`);
            } else {
                $submenu.removeClass('submenu-collapsed').addClass('submenu-expanded');
                $toggle.find('.toggle-icon').text('▲');
                $toggle.attr('aria-label', HamburgerMenuAccessibility.getToggleLabel(linkText, true));
                $toggle.find('.screen-reader-text').text(`Collapse ${linkText} submenu`);
            }

            // Announce change
            const announcement = isOpen ? `${linkText} submenu collapsed` : `${linkText} submenu expanded`;
            HamburgerMenuAccessibility.announceToUser(announcement);
        },

        setMenuState: function ($menu, isOpen) {
            const $toggle = $menu.find('.hamburger-menu__toggle');
            const $panel = $menu.find('.hamburger-menu__panel');

            $toggle.attr('aria-expanded', isOpen);
            $panel.attr('aria-hidden', !isOpen);

            if (isOpen) {
                $menu.addClass('menu-open');
                $toggle.attr('aria-label', 'Close navigation menu');
                $toggle.find('.screen-reader-text').text('Close Menu');
                $panel.attr('tabindex', '-1');
            } else {
                $menu.removeClass('menu-open');
                $toggle.attr('aria-label', 'Open navigation menu');
                $toggle.find('.screen-reader-text').text('Open Menu');

                // Close all submenus
                $panel.find('.submenu-toggle[aria-expanded="true"]').each(function () {
                    $(this).click();
                });
            }
        },

        handleKeyboard: function (e) {
            const $menu = $(e.currentTarget);
            const $panel = $menu.find('.hamburger-menu__panel');
            const isOpen = $panel.attr('aria-hidden') === 'false';

            // Handle escape key
            if (e.key === 'Escape' && isOpen) {
                e.preventDefault();
                e.stopPropagation();
                this.closeMenu.call($menu.find('.hamburger-menu__close')[0]);
                return;
            }

            // Handle enter/space on toggle
            if ((e.key === 'Enter' || e.key === ' ') && $(e.target).hasClass('hamburger-menu__toggle')) {
                e.preventDefault();
                this.toggleMenu.call(e.target, e);
                return;
            }
        },

        handleGlobalKeyboard: function (e) {
            // Handle escape key to close any open menus
            if (e.key === 'Escape') {
                $('.hamburger-menu.menu-open').each(function () {
                    const $menu = $(this);
                    const $closeBtn = $menu.find('.hamburger-menu__close');
                    if ($closeBtn.length) {
                        HamburgerMenuAccessibility.closeMenu.call($closeBtn[0], e);
                    }
                });
            }
        },

        handleOutsideClick: function (e) {
            const $target = $(e.target);

            // If click is outside of any open menu, close it
            if (!$target.closest('.hamburger-menu').length) {
                $('.hamburger-menu.menu-open').each(function () {
                    const $menu = $(this);
                    HamburgerMenuAccessibility.setMenuState($menu, false);
                    $('body').removeClass('hamburger-menu-open');
                });
            }
        },

        handleMenuFocus: function (e) {
            const $focusedElement = $(e.target);
            const $menu = $focusedElement.closest('.hamburger-menu');
            const $panel = $menu.find('.hamburger-menu__panel');

            // Ensure panel is accessible when items receive focus
            if ($panel.attr('aria-hidden') === 'true') {
                HamburgerMenuAccessibility.setMenuState($menu, true);
            }
        },

        getToggleLabel: function (itemText, isExpanded) {
            const action = isExpanded ? 'Collapse' : 'Expand';
            return `${action} ${itemText} submenu`;
        },

        announceToUser: function (message) {
            let $liveRegion = $('#promen-success-live-region');

            if (!$liveRegion.length) {
                $liveRegion = $('<div id="promen-success-live-region" aria-live="polite" aria-atomic="true" class="screen-reader-text"></div>');
                $('body').append($liveRegion);
            }

            $liveRegion.text('');
            setTimeout(() => {
                $liveRegion.text(message);
            }, 100);

            setTimeout(() => {
                $liveRegion.text('');
            }, 3000);
        }
    };

    // Initialize when document is ready
    $(document).ready(function () {
        HamburgerMenuAccessibility.init();
    });

    // Make available globally
    window.HamburgerMenuAccessibility = HamburgerMenuAccessibility;

})(jQuery);