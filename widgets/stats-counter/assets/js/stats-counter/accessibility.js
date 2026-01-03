/**
 * Stats Counter Accessibility Module
 * Provides enhanced accessibility features for the stats counter widget
 */

class StatsCounterAccessibility {
    constructor(containerElement) {
        this.container = containerElement;
        this.widgetId = (this.container.closest('.elementor-widget-promen_stats_counter') && this.container.closest('.elementor-widget-promen_stats_counter').id) || 'stats-counter';
        this.announcementElement = null;
        this.isInitialized = false;
        this.animatedCounters = new Set();

        this.init();
    }

    init() {
        if (this.isInitialized) return;

        this.mapElements();
        this.setupScreenReaderSupport();
        this.setupReducedMotion();
        this.setupFocusManagement();
        this.setupAnimationAccessibility();

        this.isInitialized = true;
    }

    mapElements() {
        this.announcementElement = document.getElementById('stats-announcements-' + this.widgetId.replace('elementor-widget-promen_stats_counter-', ''));
        this.counterItems = this.container.querySelectorAll('.promen-stats-counter-item');
        this.counterNumbers = this.container.querySelectorAll('.promen-counter-number');
    }

    setupScreenReaderSupport() {
        // Announce when counters start animating
        this.announceToScreenReader('Statistics are loading');

        // Set up live regions for counter updates
        this.counterNumbers.forEach(function(counter, index) {
            const item = counter.closest('.promen-stats-counter-item');
            const title = (item && item.querySelector('.promen-counter-title') && item.querySelector('.promen-counter-title').textContent) || 'Statistic ' + (index + 1);

            // Add aria-label to counter for better context
            counter.setAttribute('aria-label', 'Teller voor ' + title);
        });
    }

    setupReducedMotion() {
        // Check for reduced motion preference
        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReducedMotion) {
            this.container.classList.add('reduce-motion');
            this.disableAnimations();
        }

        // Listen for changes in motion preference
        window.matchMedia('(prefers-reduced-motion: reduce)').addEventListener('change', function(e) {
            if (e.matches) {
                this.container.classList.add('reduce-motion');
                this.disableAnimations();
            } else {
                this.container.classList.remove('reduce-motion');
                // Don't automatically re-enable animations - let user control it
            }
        }.bind(this));
    }

    setupFocusManagement() {
        // Add ARIA attributes for arrow key navigation
        this.container.setAttribute('role', 'listbox');
        this.container.setAttribute('aria-orientation', 'horizontal');
        this.container.setAttribute('aria-label', 'Statistics navigation - use arrow keys to navigate');

        // Make counter items focusable for keyboard navigation
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

            // Add focus/blur event listeners
            item.addEventListener('focus', () => {
                this.announceCounterFocus(item, index);
                this.updateAriaSelected(index);
            });

            item.addEventListener('blur', () => {
                // Optional: handle blur if needed
            });
        });
    }

    setupAnimationAccessibility() {
        // Override the original animation function to include accessibility features
        this.enhanceCounterAnimation();
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
            // Update tabindex for proper focus management
            this.counterItems.forEach((item, i) => {
                item.setAttribute('tabindex', i === index ? '0' : '-1');
            });

            // Focus the target item
            this.counterItems[index].focus();

            // Update ARIA selected state
            this.updateAriaSelected(index);

            // Announce navigation
            this.announceNavigation(index);
        }
    }

    updateAriaSelected(selectedIndex) {
        this.counterItems.forEach((item, index) => {
            item.setAttribute('aria-selected', index === selectedIndex ? 'true' : 'false');
        });
    }

    announceNavigation(index) {
        const item = this.counterItems[index];
        const titleElement = item.querySelector('.promen-counter-title');
        const title = titleElement ? titleElement.textContent : 'Statistic ' + (index + 1);

        this.announceToScreenReader('Navigated to ' + title + ', item ' + (index + 1) + ' of ' + this.counterItems.length);
    }

    announceCounterFocus(item, index) {
        const titleElement = item.querySelector('.promen-counter-title');
        const numberElement = item.querySelector('.promen-counter-number');
        const title = titleElement ? titleElement.textContent : null;
        const number = numberElement ? numberElement.textContent : null;

        if (title && number) {
            this.announceToScreenReader('Focused on ' + title + ': ' + number + '. Press Enter for details.');
        }
    }

    announceCounterDetails(item, index) {
        const titleElement = item.querySelector('.promen-counter-title');
        const numberElement = item.querySelector('.promen-counter-number');
        const title = titleElement ? titleElement.textContent : null;
        const number = numberElement ? numberElement.textContent : null;

        if (title && number) {
            this.announceToScreenReader('Statistic: ' + title + ' shows ' + number + '. This is statistic ' + (index + 1) + ' of ' + this.counterItems.length + '.');
        }
    }

    handleEscapeKey(item) {
        // Announce escape action
        this.announceToScreenReader('Exiting statistics navigation');

        // Remove focus from current item
        item.blur();

        // Find next focusable element outside the statistics
        const focusableElements = document.querySelectorAll(
            'a[href], button, textarea, input[type="text"], input[type="radio"], input[type="checkbox"], select'
        );
        const currentIndex = Array.from(focusableElements).indexOf(item);
        const nextElement = focusableElements[currentIndex + 1];

        if (nextElement) {
            nextElement.focus();
        }
    }

    enhanceCounterAnimation() {
        // Store reference to original animation function
        const originalAnimateCounter = window.animateCounter;

        // Override with accessible version
        window.animateCounter = function(element, duration) {
            const $counters = jQuery(element).find('.promen-counter-number');
            const container = element;

            $counters.each(function(index, counter) {
                const $counter = jQuery(counter);
                const finalValue = parseInt($counter.attr('data-count'), 10);
                const item = $counter.closest('.promen-stats-counter-item');
                const title = item.find('.promen-counter-title').text();

                // Only animate if we have a valid number and motion is not reduced
                if (!isNaN(finalValue) && !this.container.classList.contains('reduce-motion')) {
                    // Announce animation start
                    this.announceToScreenReader('Animating ' + title + ' counter to ' + finalValue);

                    jQuery({ countValue: 0 }).animate({ countValue: finalValue }, {
                        duration: duration || 2000,
                        easing: 'swing',
                        step: function() {
                            const currentValue = Math.floor(this.countValue);
                            $counter.text(currentValue);

                            // Announce significant milestones (25%, 50%, 75%, 100%)
                            const progress = currentValue / finalValue;
                            if (progress >= 0.25 && progress < 0.3 && !this.announced25) {
                                this.announced25 = true;
                                this.announceToScreenReader(title + ' counter at 25%');
                            } else if (progress >= 0.5 && progress < 0.6 && !this.announced50) {
                                this.announced50 = true;
                                this.announceToScreenReader(title + ' counter at 50%');
                            } else if (progress >= 0.75 && progress < 0.8 && !this.announced75) {
                                this.announced75 = true;
                                this.announceToScreenReader(title + ' counter at 75%');
                            }
                        }.bind(this),
                        complete: function() {
                            $counter.text(finalValue);
                            this.announceToScreenReader(title + ' counter completed at ' + finalValue);

                            // Reset announcement flags
                            this.announced25 = false;
                            this.announced50 = false;
                            this.announced75 = false;
                        }.bind(this)
                    });
                } else if (!isNaN(finalValue)) {
                    // For reduced motion, just set the final value
                    $counter.text(finalValue);
                    this.announceToScreenReader(title + ' shows ' + finalValue);
                }
            });
        };
    }

    disableAnimations() {
        // Disable all animations and transitions
        this.container.style.setProperty('--animation-duration', '0ms');
        this.container.style.setProperty('--transition-duration', '0ms');

        // Add CSS class for reduced motion
        this.container.classList.add('reduce-motion');

        // Set final values immediately
        this.counterNumbers.forEach(function(counter) {
            const finalValue = counter.getAttribute('data-count');
            if (finalValue) {
                counter.textContent = finalValue;
            }
        });
    }

    announceToScreenReader(message) {
        if (!this.announcementElement) return;

        // Clear previous announcement
        this.announcementElement.textContent = '';

        // Add new announcement
        setTimeout(function() {
            this.announcementElement.textContent = message;
        }.bind(this), 100);
    }

    // Public method to announce counter completion
    announceCounterComplete(title, finalValue) {
        this.announceToScreenReader(title + ' counter completed at ' + finalValue);
    }

    // Public method to update accessibility when counters are reinitialized
    updateAccessibility() {
        this.mapElements();
        this.setupFocusManagement();
    }

    // Cleanup method
    destroy() {
        this.isInitialized = false;
        // Remove event listeners if needed
    }
}

// Initialize accessibility for all stats counter widgets
document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.promen-stats-counter-container');
    containers.forEach(function(container) {
        new StatsCounterAccessibility(container);
    });
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = StatsCounterAccessibility;
}