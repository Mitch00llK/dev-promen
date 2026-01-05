/**
 * DOM Helper
 * 
 * Utility functions for DOM manipulation.
 * 
 * @package Promen_Elementor_Widgets
 */

/**
 * Query selector shorthand
 * @param {string} selector CSS selector
 * @param {Element} context Context element (default: document)
 * @returns {Element|null} First matching element
 */
export function $(selector, context = document) {
    return context.querySelector(selector);
}

/**
 * Query selector all shorthand
 * @param {string} selector CSS selector  
 * @param {Element} context Context element (default: document)
 * @returns {NodeList} All matching elements
 */
export function $$(selector, context = document) {
    return context.querySelectorAll(selector);
}

/**
 * Add class(es) to body element
 * @param {...string} classes Class names to add
 */
export function addBodyClass(...classes) {
    document.body.classList.add(...classes);
}

/**
 * Remove class(es) from body element
 * @param {...string} classes Class names to remove
 */
export function removeBodyClass(...classes) {
    document.body.classList.remove(...classes);
}

/**
 * Toggle class on body element
 * @param {string} className Class name to toggle
 * @param {boolean} force Force add (true) or remove (false)
 * @returns {boolean} Whether class is now present
 */
export function toggleBodyClass(className, force) {
    return document.body.classList.toggle(className, force);
}

/**
 * Check if body has class
 * @param {string} className Class name to check
 * @returns {boolean} Whether class is present
 */
export function hasBodyClass(className) {
    return document.body.classList.contains(className);
}

/**
 * Set CSS custom property on document root
 * @param {string} property Property name (with or without --)
 * @param {string} value Property value
 */
export function setCSSVariable(property, value) {
    const name = property.startsWith('--') ? property : `--${property}`;
    document.documentElement.style.setProperty(name, value);
}

/**
 * Get CSS custom property value
 * @param {string} property Property name (with or without --)
 * @returns {string} Property value
 */
export function getCSSVariable(property) {
    const name = property.startsWith('--') ? property : `--${property}`;
    return getComputedStyle(document.documentElement).getPropertyValue(name).trim();
}

/**
 * Announce message to screen readers
 * @param {string} message Message to announce
 * @param {string} politeness 'polite' or 'assertive'
 */
export function announce(message, politeness = 'polite') {
    const announcer = $('#a11y-announcements');
    if (!announcer) return;

    // Clear and re-add to trigger announcement
    announcer.textContent = '';
    announcer.setAttribute('aria-live', politeness);

    // Small delay to ensure screen readers pick up the change
    requestAnimationFrame(() => {
        announcer.textContent = message;
    });
}

/**
 * Trap focus within an element
 * @param {Element} container Container element
 * @returns {Function} Cleanup function to remove trap
 */
export function trapFocus(container) {
    const focusableSelectors = [
        'button:not([disabled])',
        'a[href]',
        'input:not([disabled])',
        'select:not([disabled])',
        'textarea:not([disabled])',
        '[tabindex]:not([tabindex="-1"])'
    ].join(', ');

    const focusableElements = $$(focusableSelectors, container);
    const firstFocusable = focusableElements[0];
    const lastFocusable = focusableElements[focusableElements.length - 1];

    function handleKeydown(e) {
        if (e.key !== 'Tab') return;

        if (e.shiftKey) {
            if (document.activeElement === firstFocusable) {
                e.preventDefault();
                lastFocusable?.focus();
            }
        } else {
            if (document.activeElement === lastFocusable) {
                e.preventDefault();
                firstFocusable?.focus();
            }
        }
    }

    container.addEventListener('keydown', handleKeydown);

    // Focus first element
    firstFocusable?.focus();

    // Return cleanup function
    return () => {
        container.removeEventListener('keydown', handleKeydown);
    };
}

/**
 * Debounce function
 * @param {Function} fn Function to debounce
 * @param {number} wait Wait time in ms
 * @returns {Function} Debounced function
 */
export function debounce(fn, wait = 100) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => fn.apply(this, args), wait);
    };
}

/**
 * Check if element is visible
 * @param {Element} element Element to check
 * @returns {boolean} Whether element is visible
 */
export function isVisible(element) {
    if (!element) return false;

    const style = getComputedStyle(element);
    return style.display !== 'none' &&
        style.visibility !== 'hidden' &&
        style.opacity !== '0';
}
