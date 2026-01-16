/**
 * Stats Counter Accessibility Module
 * Provides enhanced accessibility features for the stats counter widget
 * 
 * Uses global PromenAccessibility core library.
 */

/**
 * Get localized string helper
 */
function getString(key, ...args) {
    if (typeof PromenAccessibility !== 'undefined' && PromenAccessibility.getString) {
        return PromenAccessibility.getString(key, ...args);
    }
    const fallbacks = {
        statisticsLoading: 'Statistics are loading',
        counterFor: 'Counter for {0}',
        statisticLabel: 'Statistic {0}'
    };
    let str = fallbacks[key] || key;
    args.forEach((arg, index) => {
        str = str.replace(new RegExp(`\\{${index}\\}`, 'g'), arg);
    });
    return str;
}

class StatsCounterAccessibility {
    constructor(containerElement) {
        this.container = containerElement;
        this.widgetId = (this.container.closest('.elementor-widget-promen_stats_counter') && this.container.closest('.elementor-widget-promen_stats_counter').id) || 'stats-counter';
        this.isInitialized = false;
        this.mutationObserver = null;
        this.validationInterval = null;

        // CRITICAL: Remove any existing listbox role immediately to prevent ARIA errors
        this.sanitizeContainerRole();

        this.init();
    }

    init() {
        if (this.isInitialized) return;

        // Map elements and check if we have items
        if (!this.mapElements()) {
            // No items found, remove role if it exists to avoid invalid ARIA
            this.sanitizeContainerRole();
            return;
        }

        this.setupScreenReaderSupport();
        this.setupFocusManagement();
        this.setupAnimationAccessibility();
        // Skip link is handled in PHP (counter-render.php) to ensure Dutch translation
        // No need to set up skip link in JavaScript
        this.setupDOMWatcher();

        this.isInitialized = true;
    }

    /**
     * Remove listbox role and related attributes if container is invalid
     * This prevents ARIA validation errors
     */
    sanitizeContainerRole() {
        // Always check if we have valid DIRECT CHILD option elements before keeping listbox role
        // ARIA spec: role="option" must be a direct child of role="listbox"
        const optionElements = this.container.querySelectorAll('.promen-stats-counter-item[role="option"]');
        const directChildOptions = Array.from(optionElements).filter(el => 
            el.parentElement === this.container
        );
        
        if (directChildOptions.length === 0) {
            this.container.removeAttribute('role');
            this.container.removeAttribute('aria-orientation');
            this.container.removeAttribute('aria-label');
        }
    }

    /**
     * Watch for DOM changes and validate ARIA roles remain correct
     */
    setupDOMWatcher() {
        // Use MutationObserver to watch for item removal/addition
        if (typeof MutationObserver !== 'undefined') {
            this.mutationObserver = new MutationObserver((mutations) => {
                let shouldRevalidate = false;
                
                mutations.forEach((mutation) => {
                    // Check if items were added or removed
                    if (mutation.type === 'childList') {
                        if (mutation.addedNodes.length > 0 || mutation.removedNodes.length > 0) {
                            shouldRevalidate = true;
                        }
                    }
                    // Check if role attributes were changed
                    if (mutation.type === 'attributes' && mutation.attributeName === 'role') {
                        shouldRevalidate = true;
                    }
                });
                
                if (shouldRevalidate) {
                    // Debounce validation to avoid excessive checks
                    clearTimeout(this.validationTimeout);
                    this.validationTimeout = setTimeout(() => {
                        this.validateAndFixARIA();
                    }, 100);
                }
            });
            
            // Observe the container for changes
            this.mutationObserver.observe(this.container, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['role']
            });
        }
        
        // Also set up periodic validation as a safety net
        this.validationInterval = setInterval(() => {
            this.validateAndFixARIA();
        }, 2000); // Check every 2 seconds
    }

    /**
     * Validate ARIA roles and fix if invalid
     */
    validateAndFixARIA() {
        // Check if container still exists
        if (!this.container || !document.body.contains(this.container)) {
            this.cleanup();
            return;
        }
        
        const hasListboxRole = this.container.getAttribute('role') === 'listbox';
        
        if (!hasListboxRole) {
            return; // No listbox role, nothing to validate
        }
        
        // Check if we have valid option children that are DIRECT children
        const optionElements = this.container.querySelectorAll('.promen-stats-counter-item[role="option"]');
        const directChildOptions = Array.from(optionElements).filter(el => 
            el.parentElement === this.container
        );
        
        // If container has listbox role but no direct child option elements, remove it
        if (directChildOptions.length === 0) {
            console.warn('Stats Counter: Removing invalid listbox role - no direct child option elements found');
            this.sanitizeContainerRole();
            return;
        }
        
        // If some options are not direct children, remove role from those that aren't
        if (directChildOptions.length !== optionElements.length) {
            optionElements.forEach((item) => {
                if (item.parentElement !== this.container) {
                    item.removeAttribute('role');
                    item.removeAttribute('aria-posinset');
                    item.removeAttribute('aria-setsize');
                    item.removeAttribute('aria-selected');
                }
            });
        }
        
        // Ensure all direct child items have role="option"
        const allDirectChildItems = Array.from(this.container.children).filter(el => 
            el.classList.contains('promen-stats-counter-item')
        );
        
        allDirectChildItems.forEach((item) => {
            if (!item.hasAttribute('role') || item.getAttribute('role') !== 'option') {
                item.setAttribute('role', 'option');
            }
        });
    }

    /**
     * Cleanup observers and intervals
     */
    cleanup() {
        if (this.mutationObserver) {
            this.mutationObserver.disconnect();
            this.mutationObserver = null;
        }
        if (this.validationInterval) {
            clearInterval(this.validationInterval);
            this.validationInterval = null;
        }
        if (this.validationTimeout) {
            clearTimeout(this.validationTimeout);
            this.validationTimeout = null;
        }
    }

    mapElements() {
        // First, find all items (they should have role="option" from PHP)
        this.counterItems = this.container.querySelectorAll('.promen-stats-counter-item');
        this.counterNumbers = this.container.querySelectorAll('.promen-counter-number');
        
        // Ensure all items have role="option" (in case PHP didn't set it)
        this.counterItems.forEach(item => {
            if (!item.hasAttribute('role')) {
                item.setAttribute('role', 'option');
            }
        });
        
        // Re-query to get items with role="option"
        this.counterItems = this.container.querySelectorAll('.promen-stats-counter-item[role="option"]');
        
        // If no items found, don't proceed with initialization
        if (this.counterItems.length === 0) {
            return false;
        }
        return true;
    }

    setupScreenReaderSupport() {
        // Announce when counters start animating (if not reduced motion)
        if (!this.prefersReducedMotion()) {
            PromenAccessibility.announce(getString('statisticsLoading'));
        }

        // Set up labels
        this.counterNumbers.forEach(function (counter, index) {
            const item = counter.closest('.promen-stats-counter-item');
            const title = (item && item.querySelector('.promen-counter-title') && item.querySelector('.promen-counter-title').textContent) || getString('statisticLabel', index + 1);

            // Add aria-label to counter for better context
            counter.setAttribute('aria-label', getString('counterFor', title));
        });
    }

    setupFocusManagement() {
        // CRITICAL: Always sanitize first to remove any invalid roles
        this.sanitizeContainerRole();
        
        // Only add ARIA attributes for listbox pattern if there are items
        // Double-check: count actual option elements, not just items
        const optionElements = this.container.querySelectorAll('.promen-stats-counter-item[role="option"]');
        
        // CRITICAL: Only set listbox role if we have at least one confirmed option child
        // This prevents ARIA validation errors for missing required children
        if (this.counterItems.length === 0 || optionElements.length === 0) {
            // Remove role if no items to avoid invalid ARIA
            this.sanitizeContainerRole();
            return;
        }

        // Verify we have the same count - if not, something is wrong
        if (this.counterItems.length !== optionElements.length) {
            console.warn('Stats Counter: Mismatch between counter items and option elements');
            this.sanitizeContainerRole();
            return;
        }

        // Final validation: Ensure all items actually exist in the DOM
        const validOptions = Array.from(optionElements).filter(el => 
            document.body.contains(el) && 
            el.closest('.promen-stats-counter-container') === this.container
        );
        
        if (validOptions.length === 0) {
            console.warn('Stats Counter: No valid option elements found in container');
            this.sanitizeContainerRole();
            return;
        }

        // CRITICAL: Verify that option elements are DIRECT children of the container
        // ARIA spec requires: role="option" must be a direct child of role="listbox"
        const directChildOptions = Array.from(validOptions).filter(el => {
            return el.parentElement === this.container;
        });
        
        if (directChildOptions.length === 0) {
            console.warn('Stats Counter: No option elements are direct children of container - ARIA violation');
            this.sanitizeContainerRole();
            return;
        }
        
        // If some options are not direct children, remove role from those that aren't
        // and only keep the ones that are properly nested
        if (directChildOptions.length !== validOptions.length) {
            console.warn('Stats Counter: Some option elements are not direct children - fixing structure');
            validOptions.forEach(option => {
                if (option.parentElement !== this.container) {
                    option.removeAttribute('role');
                    option.removeAttribute('aria-posinset');
                    option.removeAttribute('aria-setsize');
                    option.removeAttribute('aria-selected');
                }
            });
            
            // Re-check after fixing
            const remainingDirectOptions = this.container.querySelectorAll('.promen-stats-counter-item[role="option"]');
            if (remainingDirectOptions.length === 0) {
                this.sanitizeContainerRole();
                return;
            }
        }

        // Add ARIA attributes for listbox pattern only when we have confirmed option children
        // This ensures ARIA validation passes (listbox requires option children)
        // WCAG 2.1: listbox role requires at least one option child that is a direct child
        this.container.setAttribute('role', 'listbox');
        this.container.setAttribute('aria-orientation', 'horizontal');
        this.container.setAttribute('aria-label', 'Statistics navigation - use arrow keys to navigate');

        // Make counter items focusable
        this.counterItems.forEach((item, index) => {
            if (!item.hasAttribute('tabindex')) {
                item.setAttribute('tabindex', index === 0 ? '0' : '-1');
            }

            // Add ARIA attributes for each item
            item.setAttribute('role', 'option');
            item.setAttribute('aria-posinset', index + 1);
            item.setAttribute('aria-setsize', this.counterItems.length);
            item.setAttribute('aria-selected', index === 0 ? 'true' : 'false');

            // Add keyboard event listeners
            item.addEventListener('keydown', (e) => {
                this.handleKeyboardNavigation(e, item, index);
            });

            // Add focus event listener
            item.addEventListener('focus', () => {
                this.updateAriaSelected(index);
                // Optional: Announce focus through global announcer? 
                // Mostly native focus is enough, but custom announcements add context.
                this.announceCounterFocus(item, index);
            });
        });
    }

    setupAnimationAccessibility() {
        // Override the original animation function to include accessibility features
        // Only if it exists globally
        if (window.animateCounter) {
            this.enhanceCounterAnimation();
        }
    }

    // Skip link is handled in PHP (counter-render.php) to ensure Dutch translation
    // Removed JavaScript skip link setup to avoid duplicates

    handleKeyboardNavigation(e, item, index) {
        const key = e.key;

        switch (key) {
            case 'Enter':
            case ' ':
                e.preventDefault();
                this.announceCounterDetails(item, index);
                break;
            case 'ArrowRight':
                e.preventDefault();
                this.focusNextCounter(index);
                break;
            case 'ArrowLeft':
                e.preventDefault();
                this.focusPreviousCounter(index);
                break;
            case 'Home':
                e.preventDefault();
                this.focusFirstCounter();
                break;
            case 'End':
                e.preventDefault();
                this.focusLastCounter();
                break;
            case 'Escape':
                e.preventDefault();
                this.handleEscapeKey(item);
                break;
        }
    }

    focusNextCounter(currentIndex) {
        const nextIndex = (currentIndex + 1) % this.counterItems.length;
        this.focusCounterByIndex(nextIndex);
    }

    focusPreviousCounter(currentIndex) {
        const prevIndex = currentIndex === 0 ? this.counterItems.length - 1 : currentIndex - 1;
        this.focusCounterByIndex(prevIndex);
    }

    focusFirstCounter() {
        this.focusCounterByIndex(0);
    }

    focusLastCounter() {
        this.focusCounterByIndex(this.counterItems.length - 1);
    }

    focusCounterByIndex(index) {
        if (this.counterItems[index]) {
            // Update tabindex
            this.counterItems.forEach((item, i) => {
                item.setAttribute('tabindex', i === index ? '0' : '-1');
            });

            this.counterItems[index].focus();
            this.updateAriaSelected(index);
        }
    }

    updateAriaSelected(selectedIndex) {
        this.counterItems.forEach((item, index) => {
            item.setAttribute('aria-selected', index === selectedIndex ? 'true' : 'false');
        });
    }

    announceCounterFocus(item, index) {
        const titleElement = item.querySelector('.promen-counter-title');
        const numberElement = item.querySelector('.promen-counter-number');
        const title = titleElement ? titleElement.textContent : null;
        const number = numberElement ? numberElement.textContent : null;

        if (title && number) {
            PromenAccessibility.announce('Focused on ' + title + ': ' + number + '. Press Enter for details.');
        }
    }

    announceCounterDetails(item, index) {
        const titleElement = item.querySelector('.promen-counter-title');
        const numberElement = item.querySelector('.promen-counter-number');
        const title = titleElement ? titleElement.textContent : null;
        const number = numberElement ? numberElement.textContent : null;

        if (title && number) {
            PromenAccessibility.announce('Statistic: ' + title + ' shows ' + number + '. This is statistic ' + (index + 1) + ' of ' + this.counterItems.length + '.');
        }
    }

    handleEscapeKey(item) {
        PromenAccessibility.announce('Exiting statistics navigation');
        item.blur();
        // Allow default tab behavior to take over or manually find next?
        // Let's rely on user moving tab manually after blur, or better, keep focus on container?
        // Actually, blurring without moving focus is disorienting.
        this.container.focus();
    }

    enhanceCounterAnimation() {
        const originalAnimateCounter = window.animateCounter;
        const self = this;

        // Note: This replaces the global function. Be careful if multiple widgets init.
        // It's better to ensure this runs only once or checks if already enhanced.
        // But since we are cleaning up, we'll assume this module is the authority.

        window.animateCounter = function (element, duration) {
            const $counters = jQuery(element).find('.promen-counter-number');

            $counters.each(function (index, counter) {
                const $counter = jQuery(counter);
                const finalValue = parseInt($counter.attr('data-count'), 10);
                const item = $counter.closest('.promen-stats-counter-item');
                const title = item.find('.promen-counter-title').text();

                if (!isNaN(finalValue) && !self.prefersReducedMotion()) {
                    // Start announcement
                    PromenAccessibility.announce('Animating ' + title + ' counter to ' + finalValue);

                    jQuery({ countValue: 0 }).animate({ countValue: finalValue }, {
                        duration: duration || 2000,
                        easing: 'swing',
                        step: function () {
                            const currentValue = Math.floor(this.countValue);
                            $counter.text(currentValue);
                        },
                        complete: function () {
                            $counter.text(finalValue);
                            PromenAccessibility.announce(title + ' counter completed at ' + finalValue);
                        }
                    });
                } else if (!isNaN(finalValue)) {
                    // Reduced motion
                    $counter.text(finalValue);
                }
            });
        };
    }

    prefersReducedMotion() {
        return PromenAccessibility.isReducedMotion();
    }
}

// Initialize accessibility for all stats counter widgets
function initializeStatsCounterAccessibility() {
    const containers = document.querySelectorAll('.promen-stats-counter-container');
    containers.forEach(function (container) {
        // CRITICAL: First, remove any existing listbox role to prevent ARIA errors
        // We'll only add it back if validation passes
        const currentRole = container.getAttribute('role');
        if (currentRole === 'listbox') {
            container.removeAttribute('role');
            container.removeAttribute('aria-orientation');
            container.removeAttribute('aria-label');
        }
        
        // Wait a tick to ensure DOM is fully rendered
        setTimeout(function() {
            // Check if container still exists
            if (!document.body.contains(container)) {
                return;
            }
            
            const items = container.querySelectorAll('.promen-stats-counter-item');
            const optionItems = container.querySelectorAll('.promen-stats-counter-item[role="option"]');
            
            // If container has no items at all, or no items with role="option", don't initialize
            if (items.length === 0 || optionItems.length === 0) {
                // Ensure listbox role is removed
                container.removeAttribute('role');
                container.removeAttribute('aria-orientation');
                container.removeAttribute('aria-label');
                return; // Don't initialize
            }
            
            // Ensure all items have role="option" before proceeding
            items.forEach(function(item) {
                if (!item.hasAttribute('role') || item.getAttribute('role') !== 'option') {
                    item.setAttribute('role', 'option');
                }
            });
            
            // Re-check after ensuring roles are set
            const confirmedOptionItems = container.querySelectorAll('.promen-stats-counter-item[role="option"]');
            if (confirmedOptionItems.length === 0) {
                container.removeAttribute('role');
                container.removeAttribute('aria-orientation');
                container.removeAttribute('aria-label');
                return;
            }
            
            // CRITICAL: Verify that option elements are DIRECT children of the container
            // ARIA spec requires: role="option" must be a direct child of role="listbox"
            const directChildOptions = Array.from(confirmedOptionItems).filter(el => 
                el.parentElement === container
            );
            
            if (directChildOptions.length === 0) {
                console.warn('Stats Counter: No option elements are direct children of container');
                container.removeAttribute('role');
                container.removeAttribute('aria-orientation');
                container.removeAttribute('aria-label');
                return;
            }
            
            // Only initialize if we have confirmed direct child option elements
            // Check if already initialized to prevent duplicates
            if (!container.hasAttribute('data-accessibility-initialized')) {
                container.setAttribute('data-accessibility-initialized', 'true');
                new StatsCounterAccessibility(container);
            }
        }, 0);
    });
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // First pass: Remove any invalid listbox roles immediately
    // Check for containers with listbox role that don't have direct child option elements
    const containers = document.querySelectorAll('.promen-stats-counter-container[role="listbox"]');
    containers.forEach(function(container) {
        const optionItems = container.querySelectorAll('.promen-stats-counter-item[role="option"]');
        // ARIA spec: option must be direct child of listbox
        const directChildOptions = Array.from(optionItems).filter(el => 
            el.parentElement === container
        );
        
        if (directChildOptions.length === 0) {
            container.removeAttribute('role');
            container.removeAttribute('aria-orientation');
            container.removeAttribute('aria-label');
        }
    });
    
    // Then initialize properly
    initializeStatsCounterAccessibility();
});

// Also initialize after a short delay to catch dynamically loaded content
setTimeout(initializeStatsCounterAccessibility, 100);

// Watch for dynamically added widgets (Elementor, AJAX, etc.)
if (typeof MutationObserver !== 'undefined') {
    const globalObserver = new MutationObserver(function(mutations) {
        let shouldReinit = false;
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length > 0) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        if (node.classList && node.classList.contains('promen-stats-counter-container')) {
                            shouldReinit = true;
                        } else if (node.querySelectorAll) {
                            const containers = node.querySelectorAll('.promen-stats-counter-container');
                            if (containers.length > 0) {
                                shouldReinit = true;
                            }
                        }
                    }
                });
            }
        });
        
        if (shouldReinit) {
            // Debounce to avoid excessive calls
            clearTimeout(window.statsCounterReinitTimeout);
            window.statsCounterReinitTimeout = setTimeout(initializeStatsCounterAccessibility, 150);
        }
    });
    
    // Observe document body for new widgets
    if (document.body) {
        globalObserver.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
}

// Export for usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = StatsCounterAccessibility;
}