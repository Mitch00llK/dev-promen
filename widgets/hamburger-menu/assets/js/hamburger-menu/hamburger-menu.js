/**
 * Hamburger Menu Widget JavaScript
 * Uses GSAP for animations
 */

// Register GSAP plugins if available
if (typeof gsap !== 'undefined') {
    // Check if CustomEase is available and register it
    if (typeof CustomEase !== 'undefined') {
        gsap.registerPlugin(CustomEase);
    }
}

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
 * Initialize Hamburger Menu
 * @param {string} menuId - The ID of the hamburger menu element
 */
function initHamburgerMenu(menuId) {

    const menuElement = document.getElementById(menuId);
    if (!menuElement) {
        return;
    }

    // Get elements
    const toggleButton = menuElement.querySelector('.hamburger-menu__toggle');
    const toggleWrapper = menuElement.querySelector('.hamburger-menu__toggle-wrapper');
    const menuPanel = menuElement.querySelector('.hamburger-menu__panel');
    const menuItems = menuElement.querySelectorAll('.menu-item');
    const pageContent = document.querySelector('#page');

    if (!toggleButton || !menuPanel) {
        return;
    }


    // Get animation settings from data attributes
    const animationDuration = parseFloat(menuElement.dataset.animationDuration) || 0.5;
    const staggerDelay = parseFloat(menuElement.dataset.staggerDelay) || 0.1;
    const menuItemsAnimation = menuElement.dataset.menuItemsAnimation || 'fade-up';
    const enablePush = menuElement.dataset.enablePush === 'yes';
    const pushDistancePercent = parseFloat(menuElement.dataset.pushDistance) || 30;

    // Define easing functions for smoother animations
    const easeIn = "power3.in";
    const easeOut = "power3.out";
    const easeInOut = "power3.inOut";

    // Add contact information to the menu panel if not already present
    const contactSection = menuPanel.querySelector('.hamburger-menu__contact-info');
    if (!contactSection && menuPanel.classList.contains('panel-animation-slide-down')) {
        // Only add contact info for full-screen menus
        const contactInfo = document.createElement('div');
        contactInfo.className = 'hamburger-menu__contact-info';

        // Get contact info from the page if available, or use placeholder
        contactInfo.innerHTML = `
            <h4>EMAIL</h4>
            <p>contact@example.com</p>
            <h4>PHONE</h4>
            <p>+1 555-123-4567</p>
            <h4>ADDRESS</h4>
            <p>123 Main Street<br>City, State 12345</p>
        `;

        menuPanel.appendChild(contactInfo);
    }

    // Create a master timeline for coordinated animations
    const masterTimeline = gsap.timeline({ paused: true });

    // PANEL ANIMATION: Different animations based on panel type
    if (menuPanel.classList.contains('panel-animation-slide-down')) {
        // For slide down animation, animate the panel from top
        masterTimeline.fromTo(menuPanel, {
                height: 0,
                opacity: 0,
                y: -50,
                visibility: 'hidden'
            }, {
                height: '100vh',
                opacity: 1,
                y: 0,
                visibility: 'visible',
                duration: animationDuration,
                ease: easeInOut
            },
            0
        );

        // Add push down animation for page content if enabled
        if (enablePush && pageContent) {
            masterTimeline.to(pageContent, {
                y: '30vh', // Push content down by 30% of viewport height
                duration: animationDuration,
                ease: easeInOut
            }, 0);
        }
    } else if (menuPanel.classList.contains('panel-animation-slide-left')) {
        // Slide from left animation
        masterTimeline.fromTo(menuPanel, {
                x: '-100%',
                opacity: 0,
                visibility: 'hidden'
            }, {
                x: '0%',
                opacity: 1,
                visibility: 'visible',
                duration: animationDuration,
                ease: easeInOut
            },
            0
        );

        // Add push right animation for content
        if (enablePush && pageContent) {
            masterTimeline.to(pageContent, {
                x: window.innerWidth * (pushDistancePercent / 100),
                duration: animationDuration,
                ease: easeInOut
            }, 0);
        }
    } else if (menuPanel.classList.contains('panel-animation-slide-right')) {
        // Slide from right animation
        masterTimeline.fromTo(menuPanel, {
                x: '100%',
                opacity: 0,
                visibility: 'hidden'
            }, {
                x: '0%',
                opacity: 1,
                visibility: 'visible',
                duration: animationDuration,
                ease: easeInOut
            },
            0
        );

        // Add push left animation for content
        if (enablePush && pageContent) {
            masterTimeline.to(pageContent, {
                x: -window.innerWidth * (pushDistancePercent / 100),
                duration: animationDuration,
                ease: easeInOut
            }, 0);
        }
    } else {
        // Fade animation
        masterTimeline.fromTo(menuPanel, {
                opacity: 0,
                visibility: 'hidden'
            }, {
                opacity: 1,
                visibility: 'visible',
                duration: animationDuration,
                ease: easeInOut
            },
            0
        );
    }

    // Pre-compute animation properties for menu items
    let entranceAnimation = {};

    // Set animation properties based on selected animation type
    switch (menuItemsAnimation) {
        case 'fade-up':
            entranceAnimation = { y: 30, opacity: 0, visibility: 'hidden' };
            break;
        case 'fade-down':
            entranceAnimation = { y: -30, opacity: 0, visibility: 'hidden' };
            break;
        case 'fade-left':
            entranceAnimation = { x: -30, opacity: 0, visibility: 'hidden' };
            break;
        case 'fade-right':
            entranceAnimation = { x: 30, opacity: 0, visibility: 'hidden' };
            break;
        case 'zoom-in':
            entranceAnimation = { scale: 0.8, opacity: 0, visibility: 'hidden' };
            break;
        case 'zoom-out':
            entranceAnimation = { scale: 1.2, opacity: 0, visibility: 'hidden' };
            break;
        default:
            entranceAnimation = { opacity: 0, visibility: 'hidden' };
            break;
    }

    // Set initial state for menu items
    gsap.set(menuItems, entranceAnimation);

    // Add menu items animation to master timeline
    masterTimeline.to(menuItems, {
        y: 0,
        x: 0,
        scale: 1,
        opacity: 1,
        visibility: 'visible',
        stagger: {
            each: staggerDelay,
            from: "start",
            ease: "power1.out"
        },
        duration: animationDuration,
        ease: "back.out(1.2)"
    }, 0.2); // Start slightly after panel animation begins

    // Add animation for contact info if it exists
    if (contactSection) {
        gsap.set(contactSection, { y: 20, opacity: 0, visibility: 'hidden' });
        masterTimeline.to(contactSection, {
            y: 0,
            opacity: 1,
            visibility: 'visible',
            duration: animationDuration,
            ease: easeOut
        }, 0.4); // Start after menu items begin animating
    }

    // Flag to track menu state
    let isMenuOpen = false;

    // Toggle menu function
    function toggleMenu() {

        if (isMenuOpen) {
            // Close menu
            menuElement.classList.remove('is-active');
            toggleButton.classList.remove('is-active');
            toggleButton.setAttribute('aria-expanded', 'false');

            // Create a reversed timeline for closing
            const closingTimeline = gsap.timeline({
                onComplete: () => {
                    menuPanel.setAttribute('aria-hidden', 'true');
                    document.body.classList.remove('menu-is-active');
                }
            });

            // First animate menu items out with reverse stagger
            closingTimeline.to(menuItems, {
                ...entranceAnimation,
                stagger: {
                    each: staggerDelay / 2, // Faster stagger for closing
                    from: "end",
                    ease: easeIn
                },
                duration: animationDuration * 0.7, // Slightly faster
                ease: easeIn
            });

            // Animate contact info out if it exists
            if (contactSection) {
                closingTimeline.to(contactSection, {
                    y: 20,
                    opacity: 0,
                    visibility: 'hidden',
                    duration: animationDuration * 0.5,
                    ease: easeIn
                }, "<");
            }

            // Then animate the panel out
            if (menuPanel.classList.contains('panel-animation-slide-down')) {
                // For slide down panel, animate up and out
                closingTimeline.to(menuPanel, {
                    height: 0,
                    y: -50,
                    opacity: 0,
                    visibility: 'hidden',
                    duration: animationDuration,
                    ease: easeInOut
                }, "-=0.3");

                // Animate page content back up
                if (enablePush && pageContent) {
                    closingTimeline.to(pageContent, {
                        y: 0,
                        duration: animationDuration,
                        ease: easeInOut
                    }, "-=0.4");
                }
            } else if (menuPanel.classList.contains('panel-animation-slide-left')) {
                // Slide left panel out
                closingTimeline.to(menuPanel, {
                    x: '-100%',
                    opacity: 0,
                    visibility: 'hidden',
                    duration: animationDuration,
                    ease: easeInOut
                }, "-=0.3");

                // Return page content
                if (enablePush && pageContent) {
                    closingTimeline.to(pageContent, {
                        x: 0,
                        duration: animationDuration,
                        ease: easeInOut
                    }, "-=0.4");
                }
            } else if (menuPanel.classList.contains('panel-animation-slide-right')) {
                // Slide right panel out
                closingTimeline.to(menuPanel, {
                    x: '100%',
                    opacity: 0,
                    visibility: 'hidden',
                    duration: animationDuration,
                    ease: easeInOut
                }, "-=0.3");

                // Return page content
                if (enablePush && pageContent) {
                    closingTimeline.to(pageContent, {
                        x: 0,
                        duration: animationDuration,
                        ease: easeInOut
                    }, "-=0.4");
                }
            } else {
                // Fade panel out
                closingTimeline.to(menuPanel, {
                    opacity: 0,
                    visibility: 'hidden',
                    duration: animationDuration,
                    ease: easeInOut
                }, "-=0.3");
            }

            isMenuOpen = false;
        } else {
            // Open menu
            menuElement.classList.add('is-active');
            toggleButton.classList.add('is-active');
            toggleButton.setAttribute('aria-expanded', 'true');
            menuPanel.setAttribute('aria-hidden', 'false');
            document.body.classList.add('menu-is-active');

            // Reset and play the master timeline
            masterTimeline.progress(0);
            masterTimeline.play();

            isMenuOpen = true;
        }
    }

    // Remove any existing listeners to prevent duplicates
    const newToggleWrapper = toggleWrapper.cloneNode(true);
    toggleWrapper.parentNode.replaceChild(newToggleWrapper, toggleWrapper);

    // Get references to new elements after DOM replacement
    const newToggleButton = newToggleWrapper.querySelector('.hamburger-menu__toggle');

    // Make entire toggle wrapper clickable - including the label
    newToggleWrapper.addEventListener('click', toggleMenu);

    // Close menu on ESC key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' && isMenuOpen) {
            toggleMenu();
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', function(event) {
        const isClickInside = menuElement.contains(event.target);

        if (!isClickInside && isMenuOpen) {
            toggleMenu();
        }
    });

    // Initialize submenus if they exist
    const subMenuParents = menuElement.querySelectorAll('.menu-item-has-children');

    subMenuParents.forEach(parent => {
        const link = parent.querySelector('a');
        const subMenu = parent.querySelector('.sub-menu');

        if (link && subMenu) {
            // Set initial state for submenu
            gsap.set(subMenu, {
                height: 0,
                opacity: 0,
                display: 'none',
                overflow: 'hidden' // Prevent content from showing during animation
            });

            // Get existing toggle button
            const toggleIndicator = parent.querySelector('.submenu-toggle');

            if (toggleIndicator) {
                // Toggle submenu with improved animation
                toggleIndicator.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    const isOpen = subMenu.classList.contains('is-active');

                    if (isOpen) {
                        // Create submenu closing timeline
                        const closeSubmenu = gsap.timeline({
                            onComplete: () => {
                                subMenu.style.display = 'none';
                                subMenu.classList.remove('is-active');
                            }
                        });

                        // Animate submenu items first
                        closeSubmenu.to(subMenu.querySelectorAll('li'), {
                            opacity: 0,
                            y: -10,
                            duration: 0.2,
                            stagger: 0.05,
                            ease: easeIn
                        });

                        // Then animate the container
                        closeSubmenu.to(subMenu, {
                            height: 0,
                            opacity: 0,
                            duration: 0.3,
                            ease: easeInOut
                        }, "-=0.1");

                        toggleIndicator.innerHTML = '+';

                    } else {
                        subMenu.classList.add('is-active');
                        subMenu.style.display = 'block';
                        toggleIndicator.innerHTML = '-';

                        // Create submenu opening timeline
                        const openSubmenu = gsap.timeline();

                        // First measure the height for a smooth animation
                        const height = subMenu.scrollHeight;

                        // Animate container first
                        openSubmenu.fromTo(subMenu, { height: 0, opacity: 0 }, { height: height, opacity: 1, duration: 0.3, ease: easeOut });

                        // Set items to initial state
                        gsap.set(subMenu.querySelectorAll('li'), { opacity: 0, y: 10 });

                        // Then animate items
                        openSubmenu.to(subMenu.querySelectorAll('li'), {
                            opacity: 1,
                            y: 0,
                            duration: 0.3,
                            stagger: 0.05,
                            ease: easeOut
                        }, "-=0.1");
                    }
                });
            }
        }
    });

    // Handle window resize to adjust push animation values
    window.addEventListener('resize', function() {
        if (enablePush && pageContent && isMenuOpen) {
            if (menuPanel.classList.contains('panel-animation-slide-down')) {
                // No need to adjust vertical push on resize
            } else if (menuPanel.classList.contains('panel-animation-slide-left')) {
                gsap.set(pageContent, { x: window.innerWidth * (pushDistancePercent / 100) });
            } else if (menuPanel.classList.contains('panel-animation-slide-right')) {
                gsap.set(pageContent, { x: -window.innerWidth * (pushDistancePercent / 100) });
            }
        }
    });

}

// Make function available globally
window.initHamburgerMenu = initHamburgerMenu;