/**
 * Hamburger Menu Widget JavaScript
 * Uses GSAP for animations
 */

// Initialize all hamburger menus on page
document.addEventListener('DOMContentLoaded', function() {
    // Find all hamburger menu instances
    const hamburgerMenus = document.querySelectorAll('.hamburger-menu');

    // Initialize each menu
    hamburgerMenus.forEach(menu => {
        const menuId = menu.getAttribute('id');
        if (menuId) {
            initHamburgerMenu(menuId);
        }
    });
});

/**
 * Debounce function to limit event handler calls
 * @param {Function} func - The function to debounce
 * @param {number} wait - The debounce time in milliseconds
 * @param {boolean} immediate - If true, trigger the function on the leading edge instead of trailing
 * @return {Function} - Debounced function
 */
function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        const context = this,
            args = arguments;
        const later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}

/**
 * Initialize Hamburger Menu
 * @param {string} menuId - The ID of the hamburger menu element
 */
function initHamburgerMenu(menuId) {
    // Get the menu element
    const menuElement = document.getElementById(menuId);
    if (!menuElement) {
        console.error('Hamburger menu element not found:', menuId);
        return;
    }

    // Get elements
    const toggleButton = menuElement.querySelector('.hamburger-menu__toggle');
    const menuPanel = menuElement.querySelector('.hamburger-menu__panel');
    const closeButton = menuElement.querySelector('.hamburger-menu__close');
    const menuItems = menuElement.querySelectorAll('.menu-item');
    const pageContent = document.querySelector('#page');

    if (!toggleButton || !menuPanel) {
        console.error('Required elements missing in hamburger menu:', menuId);
        return;
    }

    // Get animation settings from data attributes
    const animationDuration = parseFloat(menuElement.dataset.animationDuration) || 0.5;
    const animationEasing = menuElement.dataset.animationEasing || 'power3.out';
    const staggerDelay = parseFloat(menuElement.dataset.staggerDelay) || 0.08;
    const menuItemsAnimation = menuElement.dataset.menuItemsAnimation || 'fade-up';
    const iconType = menuElement.dataset.iconType || 'classic';
    const submenuAnimation = menuElement.dataset.submenuAnimation || 'slide';
    const submenuDuration = parseFloat(menuElement.dataset.submenuDuration) || 0.3;
    const panelAnimation = menuElement.dataset.panelAnimation || 'slide-right';
    const enablePush = menuElement.dataset.enablePush === 'yes';
    const pushDistance = parseFloat(menuElement.dataset.pushDistance) || 30;
    const pushUnit = menuElement.dataset.pushUnit || '%';

    // Flag to track if we're in the Elementor editor
    const isElementorEditor = window.elementorFrontend && window.elementorFrontend.isEditMode();

    // State tracking
    let recentlyToggledSubmenu = false;
    let submenuToggleTimeout = null;
    let menuIsActive = false;
    let touchStartX = 0;
    let touchStartY = 0;

    // Detect if we're on a touch device
    const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;

    // Add touch device class if needed
    if (isTouchDevice) {
        menuElement.classList.add('is-touch-device');
    }

    // Reset any GSAP-added inline styles from the page
    resetGSAPStyles();

    // Initialize submenu toggling
    initializeSubmenus();

    // Set up event listeners with debounce for better performance
    toggleButton.addEventListener('click', debounce(toggleMenu, 100));
    closeButton.addEventListener('click', debounce(closeMenu, 100));

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        if (menuElement.classList.contains('is-active') &&
            !menuElement.contains(event.target)) {
            closeMenu();
        }
    });

    // Add swipe gesture support for touch devices
    if (isTouchDevice) {
        menuPanel.addEventListener('touchstart', handleTouchStart, { passive: true });
        menuPanel.addEventListener('touchmove', handleTouchMove, { passive: false });
        menuPanel.addEventListener('touchend', handleTouchEnd, { passive: true });
    }

    // Close menu on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && menuElement.classList.contains('is-active')) {
            closeMenu();
        }
    });

    /**
     * Handle touch start event
     * @param {TouchEvent} e - Touch event
     */
    function handleTouchStart(e) {
        const touch = e.touches[0];
        touchStartX = touch.clientX;
        touchStartY = touch.clientY;
    }

    /**
     * Handle touch move event
     * @param {TouchEvent} e - Touch event
     */
    function handleTouchMove(e) {
        // Don't prevent default for all touch moves to allow scrolling inside menu
        // Only prevent if we detect a horizontal swipe to close the menu
        if (!touchStartX) {
            return;
        }

        const touch = e.touches[0];
        const diffX = touchStartX - touch.clientX;
        const diffY = touchStartY - touch.clientY;

        // If horizontal swipe is more significant than vertical (likely a close gesture)
        if (Math.abs(diffX) > Math.abs(diffY) * 2) {
            // Prevent default only for likely close gestures
            if ((diffX < -50 && menuPanel.classList.contains('panel-animation-slide-left')) ||
                (diffX > 50 && menuPanel.classList.contains('panel-animation-slide-right'))) {
                e.preventDefault();
            }
        }
    }

    /**
     * Handle touch end event
     * @param {TouchEvent} e - Touch event
     */
    function handleTouchEnd(e) {
        if (!touchStartX) {
            return;
        }

        const touch = e.changedTouches[0];
        const diffX = touchStartX - touch.clientX;
        const diffY = touchStartY - touch.clientY;

        // If it's a significant horizontal swipe (greater than 100px)
        if (Math.abs(diffX) > 100 && Math.abs(diffX) > Math.abs(diffY)) {
            // Close menu if swipe direction matches panel position
            if ((diffX < 0 && menuPanel.classList.contains('panel-animation-slide-left')) ||
                (diffX > 0 && menuPanel.classList.contains('panel-animation-slide-right'))) {
                closeMenu();
            }
        }

        // Reset touch coordinates
        touchStartX = 0;
        touchStartY = 0;
    }

    /**
     * Reset GSAP styles that might be left on elements
     */
    function resetGSAPStyles() {
        // Reset all sub-menus to ensure they have no leftover GSAP styles
        const allSubmenus = menuElement.querySelectorAll('.sub-menu');
        allSubmenus.forEach(submenu => {
            submenu.removeAttribute('style');
            // Don't set display:none here - let CSS handle visibility
        });

        // Also reset any menu items
        menuElement.querySelectorAll('.menu-item').forEach(item => {
            if (item.style.transform) {
                item.style.transform = '';
            }
            if (item.style.opacity) {
                item.style.opacity = '';
            }
        });
    }

    /**
     * Icon animation configurations
     */
    const iconAnimations = {
        classic: {
            open: (bars) => {
                gsap.to(bars[0], { rotation: 45, y: 8, duration: 0.3 });
                gsap.to(bars[1], { opacity: 0, duration: 0.3 });
                gsap.to(bars[2], { rotation: -45, y: -8, duration: 0.3 });
            },
            close: (bars) => {
                gsap.to(bars[0], { rotation: 0, y: 0, duration: 0.3 });
                gsap.to(bars[1], { opacity: 1, duration: 0.3 });
                gsap.to(bars[2], { rotation: 0, y: 0, duration: 0.3 });
            }
        },
        spin: {
            open: (bars) => {
                gsap.to(bars[0], { rotation: 135, y: 8, duration: 0.3 });
                gsap.to(bars[1], { opacity: 0, rotation: 135, duration: 0.3 });
                gsap.to(bars[2], { rotation: 45, y: -8, duration: 0.3 });
                gsap.to(toggleButton, { rotation: 180, duration: 0.5 });
            },
            close: (bars) => {
                gsap.to(bars[0], { rotation: 0, y: 0, duration: 0.3 });
                gsap.to(bars[1], { opacity: 1, rotation: 0, duration: 0.3 });
                gsap.to(bars[2], { rotation: 0, y: 0, duration: 0.3 });
                gsap.to(toggleButton, { rotation: 0, duration: 0.5 });
            }
        },
        elastic: {
            open: (bars) => {
                gsap.to(bars[0], { rotation: 45, y: 8, duration: 0.3, ease: "elastic.out(1, 0.3)" });
                gsap.to(bars[1], { scaleX: 0, duration: 0.3, ease: "elastic.out(1, 0.3)" });
                gsap.to(bars[2], { rotation: -45, y: -8, duration: 0.3, ease: "elastic.out(1, 0.3)" });
            },
            close: (bars) => {
                gsap.to(bars[0], { rotation: 0, y: 0, duration: 0.3, ease: "elastic.out(1, 0.3)" });
                gsap.to(bars[1], { scaleX: 1, duration: 0.3, ease: "elastic.out(1, 0.3)" });
                gsap.to(bars[2], { rotation: 0, y: 0, duration: 0.3, ease: "elastic.out(1, 0.3)" });
            }
        },
        arrow: {
            open: (bars) => {
                gsap.to(bars[0], { rotation: 45, width: "50%", x: -2, y: 6, duration: 0.3 });
                gsap.to(bars[1], { width: "75%", duration: 0.3 });
                gsap.to(bars[2], { rotation: -45, width: "50%", x: -2, y: -6, duration: 0.3 });
            },
            close: (bars) => {
                gsap.to(bars[0], { rotation: 0, width: "100%", x: 0, y: 0, duration: 0.3 });
                gsap.to(bars[1], { width: "100%", duration: 0.3 });
                gsap.to(bars[2], { rotation: 0, width: "100%", x: 0, y: 0, duration: 0.3 });
            }
        },
        minus: {
            open: (bars) => {
                gsap.to(bars[0], { rotation: 180, y: 8, duration: 0.3 });
                gsap.to(bars[1], { opacity: 0, duration: 0.3 });
                gsap.to(bars[2], { rotation: 180, y: -8, duration: 0.3 });
            },
            close: (bars) => {
                gsap.to(bars[0], { rotation: 0, y: 0, duration: 0.3 });
                gsap.to(bars[1], { opacity: 1, duration: 0.3 });
                gsap.to(bars[2], { rotation: 0, y: 0, duration: 0.3 });
            }
        }
    };

    /**
     * Enhanced submenu handling with better event management
     */
    function initializeSubmenus() {
        // Get all parent menu items with submenus
        const parentMenuItems = menuElement.querySelectorAll('.menu-item-has-children');

        // Remove existing document click handler first to prevent multiple handlers
        document.removeEventListener('click', documentClickHandler);

        // Create a set to keep track of which elements are part of submenus
        const submenuElements = new Set();

        parentMenuItems.forEach(item => {
            // Get the submenu and add class to parent
            const submenu = item.querySelector('.sub-menu');
            const parentLink = item.querySelector('a');
            item.classList.add('has-submenu');

            // Add this item and all its children to our tracking set
            submenuElements.add(item);
            Array.from(item.querySelectorAll('*')).forEach(el => submenuElements.add(el));

            // Clear any inline styles and let CSS handle transitions
            if (submenu) {
                // Remove ALL inline styles - we'll use CSS transitions for opening/closing
                submenu.removeAttribute('style');

                // Get submenu items for GSAP animations
                const submenuItems = submenu.querySelectorAll('.menu-item');

                // Get or create toggle button
                let toggleBtn = item.querySelector('.submenu-toggle');

                if (toggleBtn) {
                    // Capture in closure to reference in our event handlers
                    const thisItem = item;
                    const thisSubmenu = submenu;
                    const thisToggleBtn = toggleBtn;
                    const thisSubmenuItems = submenuItems;

                    // Debounced toggle handler for better performance
                    const toggleHandler = debounce(function(e) {
                        e.preventDefault();
                        e.stopPropagation();

                        // Set flag to prevent immediate closing
                        recentlyToggledSubmenu = true;

                        // Clear any existing timeout
                        if (submenuToggleTimeout) {
                            clearTimeout(submenuToggleTimeout);
                        }

                        // Reset the flag after a delay (longer than animation)
                        submenuToggleTimeout = setTimeout(() => {
                            recentlyToggledSubmenu = false;
                        }, submenuDuration * 1000 + 300); // Add 300ms buffer

                        // Toggle based on current state
                        const isOpen = thisItem.classList.contains('submenu-open');

                        if (isOpen) {
                            // Close submenu
                            thisItem.classList.remove('submenu-open');
                            thisItem.classList.remove('submenu-active');
                            thisToggleBtn.classList.remove('is-active');

                            // Update ARIA states
                            const parentLink = thisItem.querySelector('a');
                            if (parentLink) {
                                parentLink.setAttribute('aria-expanded', 'false');
                            }

                            // Animate submenu items out with GSAP
                            gsap.to(thisSubmenuItems, {
                                opacity: 0,
                                y: 10,
                                duration: 0.2,
                                stagger: 0.03,
                                ease: "power2.in",
                                onComplete: () => {
                                    // Set explicit height to 0 after animation finishes
                                    if (thisSubmenu) {
                                        thisSubmenu.style.height = '0px';
                                    }
                                }
                            });
                        } else {
                            // First, close any other open submenus at the same level
                            const siblings = Array.from(thisItem.parentNode.children).filter(
                                sibling => sibling !== thisItem && sibling.classList.contains('submenu-open')
                            );

                            siblings.forEach(sibling => {
                                sibling.classList.remove('submenu-open', 'submenu-active');
                                const siblingBtn = sibling.querySelector('.submenu-toggle');
                                if (siblingBtn) siblingBtn.classList.remove('is-active');

                                // Update ARIA states
                                const siblingLink = sibling.querySelector('a');
                                if (siblingLink) {
                                    siblingLink.setAttribute('aria-expanded', 'false');
                                }

                                // Animate sibling submenu items out
                                const siblingSubmenu = sibling.querySelector('.sub-menu');
                                const siblingItems = sibling.querySelectorAll('.sub-menu .menu-item');

                                gsap.to(siblingItems, {
                                    opacity: 0,
                                    y: 10,
                                    duration: 0.2,
                                    stagger: 0.03,
                                    ease: "power2.in",
                                    onComplete: () => {
                                        // Set explicit height to 0 after animation finishes
                                        if (siblingSubmenu) {
                                            siblingSubmenu.style.height = '0px';
                                        }
                                    }
                                });
                            });

                            // Open submenu - add classes to let CSS handle the transition
                            thisItem.classList.add('submenu-open');
                            thisItem.classList.add('submenu-active');
                            thisToggleBtn.classList.add('is-active');

                            // Force height to auto to make submenu visible
                            if (thisSubmenu) {
                                // First set visibility to visible but height still 0
                                thisSubmenu.style.visibility = 'visible';
                                thisSubmenu.style.opacity = '1';

                                // Get natural height
                                thisSubmenu.style.height = 'auto';
                                const naturalHeight = thisSubmenu.offsetHeight;

                                // Reset to 0 then animate to natural height
                                thisSubmenu.style.height = '0px';

                                // Force a repaint
                                void thisSubmenu.offsetHeight;

                                // Now set the final height
                                thisSubmenu.style.height = naturalHeight + 'px';

                                // After transition completes, set to auto to handle content changes
                                setTimeout(() => {
                                    thisSubmenu.style.height = 'auto';
                                }, 300);
                            }

                            // Update ARIA states
                            const parentLink = thisItem.querySelector('a');
                            if (parentLink) {
                                parentLink.setAttribute('aria-expanded', 'true');
                            }

                            // Reset submenu items for entrance animation
                            gsap.set(thisSubmenuItems, {
                                opacity: 0,
                                y: 10
                            });

                            // Animate submenu items in with GSAP (after short delay)
                            setTimeout(() => {
                                gsap.to(thisSubmenuItems, {
                                    opacity: 1,
                                    y: 0,
                                    duration: 0.3,
                                    stagger: 0.05,
                                    ease: "power2.out"
                                });
                            }, 100); // Short delay to let CSS transition start
                        }
                    }, 50); // 50ms debounce time

                    // Add event listener with debounced handler
                    toggleBtn.addEventListener('click', toggleHandler);

                    // Add capturing phase event listeners to ensure we capture all events
                    // before they bubble up to document
                    toggleBtn.addEventListener('mousedown', stopEvent, true);
                    toggleBtn.addEventListener('touchstart', stopEvent, true);
                    toggleBtn.addEventListener('click', stopEvent, true);

                    // Also apply to submenu and all its children
                    submenu.addEventListener('mousedown', stopEvent, true);
                    submenu.addEventListener('touchstart', stopEvent, true);
                    submenu.addEventListener('click', stopEvent, true);

                    // Apply to all submenu children
                    Array.from(submenu.querySelectorAll('*')).forEach(el => {
                        el.addEventListener('mousedown', stopEvent, true);
                        el.addEventListener('touchstart', stopEvent, true);
                        el.addEventListener('click', stopEvent, true);
                    });
                }

                // Handle parent link clicks
                if (parentLink) {
                    parentLink.addEventListener('click', function(e) {
                        // Only prevent default in Elementor editor or if link is "#"
                        if (isElementorEditor || parentLink.getAttribute('href') === '#') {
                            e.preventDefault();
                        }

                        // Always stop propagation
                        e.stopPropagation();
                    });
                }
            }
        });

        // Helper function to stop event propagation completely
        function stopEvent(e) {
            e.stopPropagation();
            e.stopImmediatePropagation();
        }

        // Add global click handler to document
        document.addEventListener('click', documentClickHandler);
    }

    /**
     * Document click handler to close submenus when clicking outside
     * Now with improved state tracking
     */
    function documentClickHandler(event) {
        // If we just toggled a submenu, don't process
        if (recentlyToggledSubmenu) {
            return;
        }

        // First check - was the click inside an active submenu or toggle?
        const clickedOnSubmenu = !!event.target.closest('.submenu-open');
        const clickedOnToggle = !!event.target.closest('.submenu-toggle');
        const clickedOnMenuItem = !!event.target.closest('.menu-item-has-children');

        if (!clickedOnSubmenu && !clickedOnToggle && !clickedOnMenuItem) {
            // This will handle clicks outside of open submenus
            closeAllSubmenus();
        }
    }

    /**
     * Close all open submenus with improved logic
     */
    function closeAllSubmenus() {
        const openItems = menuElement.querySelectorAll('.submenu-open');

        if (openItems.length === 0) {
            return; // Nothing to close
        }

        openItems.forEach(item => {
            // Get submenu and toggle button
            const submenu = item.querySelector('.sub-menu');
            const toggleBtn = item.querySelector('.submenu-toggle');
            const submenuItems = submenu ? submenu.querySelectorAll('.menu-item') : [];

            // Remove classes
            item.classList.remove('submenu-open');
            item.classList.remove('submenu-active');

            // Update ARIA states
            const parentLink = item.querySelector('a');
            if (parentLink) {
                parentLink.setAttribute('aria-expanded', 'false');
            }

            if (toggleBtn) {
                toggleBtn.classList.remove('is-active');
            }

            // Set explicit height to close the submenu
            if (submenu) {
                // First animate to 0 height
                submenu.style.height = '0px';
                submenu.style.overflow = 'hidden';

                // After transition, reset other properties
                setTimeout(() => {
                    submenu.style.visibility = 'hidden';
                    submenu.style.opacity = '0';
                }, 300);
            }

            // Animate submenu items out
            if (submenu && submenuItems.length > 0) {
                gsap.to(submenuItems, {
                    opacity: 0,
                    y: 10,
                    duration: 0.2,
                    stagger: 0.03,
                    ease: "power2.in"
                });
            }
        });
    }

    /**
     * Toggle menu function
     */
    function toggleMenu() {
        const isOpen = menuElement.classList.contains('is-active');
        if (isOpen) {
            closeMenu();
        } else {
            openMenu();
        }
    }

    /**
     * Open menu function
     */
    function openMenu() {
        const bars = toggleButton.querySelectorAll('.hamburger-bar');

        // Update states
        menuElement.classList.add('is-active');
        toggleButton.classList.add('is-active');
        toggleButton.setAttribute('aria-expanded', 'true');
        menuPanel.setAttribute('aria-hidden', 'false');

        // Run icon animation
        if (iconAnimations[iconType]) {
            iconAnimations[iconType].open(bars);
        }

        // Reset menu items position before animating
        gsap.set(menuItems, {
            opacity: 0,
            y: menuItemsAnimation.includes('up') ? 30 : menuItemsAnimation.includes('down') ? -30 : menuItemsAnimation.includes('left') ? 30 : menuItemsAnimation.includes('right') ? -30 : 0,
            scale: menuItemsAnimation.includes('zoom') ? 0.95 : 1
        });

        // Create entrance animation timeline
        const tl = gsap.timeline({
            defaults: {
                ease: animationEasing,
                duration: animationDuration
            }
        });

        // Panel animation
        tl.to(menuPanel, {
            x: 0,
            y: 0,
            opacity: 1,
            duration: animationDuration * 0.6
        });

        // Menu items animation with stagger
        tl.to(menuItems, {
            opacity: 1,
            y: 0,
            scale: 1,
            stagger: staggerDelay,
            duration: animationDuration * 0.6,
            ease: animationEasing
        }, "-=0.2"); // Slight overlap with panel animation

        // Handle push animation if enabled
        if (enablePush && pageContent && pageContentPush !== 0) {
            tl.to(pageContent, {
                x: pageContentPush + (pushUnit === '%' ? '%' : 'px'),
                duration: animationDuration * 0.6
            }, 0);
        }

        // Close all submenus when opening the main menu
        closeAllSubmenus();
    }

    /**
     * Close menu function
     */
    function closeMenu() {
        const bars = toggleButton.querySelectorAll('.hamburger-bar');

        // Update states
        menuElement.classList.remove('is-active');
        toggleButton.classList.remove('is-active');
        toggleButton.setAttribute('aria-expanded', 'false');
        menuPanel.setAttribute('aria-hidden', 'true');

        // Run icon animation
        if (iconAnimations[iconType]) {
            iconAnimations[iconType].close(bars);
        }

        // Create exit animation timeline
        const tl = gsap.timeline({
            defaults: {
                ease: animationEasing,
                duration: animationDuration
            }
        });

        // Fade out menu items with stagger in reverse
        tl.to(menuItems, {
            opacity: 0,
            y: menuItemsAnimation.includes('up') ? -30 : menuItemsAnimation.includes('down') ? 30 : menuItemsAnimation.includes('left') ? -30 : menuItemsAnimation.includes('right') ? 30 : 0,
            scale: menuItemsAnimation.includes('zoom') ? 0.95 : 1,
            stagger: staggerDelay / 2,
            duration: animationDuration * 0.4
        });

        // Panel animation
        tl.to(menuPanel, {
            x: panelAnimation === 'slide-left' ? '-100%' : panelAnimation === 'slide-right' ? '100%' : 0,
            y: panelAnimation === 'slide-down' ? '100%' : 0,
            opacity: panelAnimation === 'fade' ? 0 : 1,
            duration: animationDuration * 0.4
        }, "-=0.2");

        // Handle push animation if enabled
        if (enablePush && pageContent && pageContentPush !== 0) {
            tl.to(pageContent, {
                x: 0,
                duration: animationDuration * 0.4
            }, "-=0.4");
        }

        // Close all submenus when closing the main menu
        closeAllSubmenus();
    }

    // Set initial accessibility attributes
    toggleButton.setAttribute('aria-expanded', 'false');
    menuPanel.setAttribute('aria-hidden', 'true');

    // Add accessibility keyboard navigation for menu items
    menuItems.forEach(item => {
        const link = item.querySelector('a');
        if (link) {
            link.addEventListener('keydown', (e) => {
                // Handle Enter or Space to activate links
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    link.click();
                }
            });
        }
    });
}

// Make function available globally
window.initHamburgerMenu = initHamburgerMenu;