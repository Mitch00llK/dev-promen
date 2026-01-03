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

        this.init();
    }

    init() {
        if (this.isInitialized) return;

        this.mapElements();
        this.setupScreenReaderSupport();
        this.setupFocusManagement();
        this.setupAnimationAccessibility();

        this.isInitialized = true;
    }

    mapElements() {
        this.counterItems = this.container.querySelectorAll('.promen-stats-counter-item');
        this.counterNumbers = this.container.querySelectorAll('.promen-counter-number');
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
        // Add ARIA attributes for listbox pattern
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
document.addEventListener('DOMContentLoaded', function () {
    const containers = document.querySelectorAll('.promen-stats-counter-container');
    containers.forEach(function (container) {
        new StatsCounterAccessibility(container);
    });
});

// Export for usage
if (typeof module !== 'undefined' && module.exports) {
    module.exports = StatsCounterAccessibility;
}