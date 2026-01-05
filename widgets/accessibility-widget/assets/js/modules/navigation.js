/**
 * Navigation Module
 * 
 * Handles focus indicators, cursor, reading aids, and highlight features.
 * 
 * @package Promen_Elementor_Widgets
 */

import { storageManager } from '../utilities/storage-manager.js';
import {
    $,
    addBodyClass,
    removeBodyClass,
    toggleBodyClass,
    debounce
} from '../utilities/dom-helper.js';

/**
 * Navigation Controller
 */
class Navigation {
    constructor() {
        this.readingGuideEl = null;
        this.readingMaskEl = null;
        this.mouseMoveHandler = null;
    }

    /**
     * Initialize navigation features
     */
    init() {
        this.readingGuideEl = $('#a11y-reading-guide');
        this.readingMaskEl = $('#a11y-reading-mask');

        // Create debounced mouse handler
        this.mouseMoveHandler = debounce((e) => {
            this.updateReadingAids(e.clientY);
        }, 10);
    }

    /**
     * Apply all saved navigation settings
     */
    applyAllSettings() {
        const settings = storageManager.getAll();

        this.setFocusIndicators(settings.focusIndicators);
        this.setLargeCursor(settings.largeCursor);
        this.setHighlightLinks(settings.highlightLinks);
        this.setHighlightHeaders(settings.highlightHeaders);
        this.setReadingGuide(settings.readingGuide);
        this.setReadingMask(settings.readingMask);
    }

    /**
     * Toggle focus indicators
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setFocusIndicators(enabled) {
        storageManager.set('focusIndicators', enabled);
        toggleBodyClass('a11y-focus-indicators', enabled);
        return enabled;
    }

    /**
     * Toggle large cursor
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setLargeCursor(enabled) {
        storageManager.set('largeCursor', enabled);
        toggleBodyClass('a11y-large-cursor', enabled);
        return enabled;
    }

    /**
     * Toggle highlight links
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setHighlightLinks(enabled) {
        storageManager.set('highlightLinks', enabled);
        toggleBodyClass('a11y-highlight-links', enabled);
        return enabled;
    }

    /**
     * Toggle highlight headers
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setHighlightHeaders(enabled) {
        storageManager.set('highlightHeaders', enabled);
        toggleBodyClass('a11y-highlight-headers', enabled);
        return enabled;
    }

    /**
     * Toggle reading guide
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setReadingGuide(enabled) {
        storageManager.set('readingGuide', enabled);

        if (enabled) {
            this.readingGuideEl?.classList.add('is-active');
            document.addEventListener('mousemove', this.mouseMoveHandler);
        } else {
            this.readingGuideEl?.classList.remove('is-active');
            document.removeEventListener('mousemove', this.mouseMoveHandler);
        }

        return enabled;
    }

    /**
     * Toggle reading mask
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setReadingMask(enabled) {
        storageManager.set('readingMask', enabled);

        if (enabled) {
            this.readingMaskEl?.classList.add('is-active');
            document.addEventListener('mousemove', this.mouseMoveHandler);
        } else {
            this.readingMaskEl?.classList.remove('is-active');

            // Only remove listener if reading guide is also off
            if (!storageManager.get('readingGuide')) {
                document.removeEventListener('mousemove', this.mouseMoveHandler);
            }
        }

        return enabled;
    }

    /**
     * Update reading aids position based on mouse Y
     * @param {number} y Mouse Y position
     */
    updateReadingAids(y) {
        const viewportHeight = window.innerHeight;
        const maskHeight = 120; // Height of visible reading area

        // Update reading guide
        if (this.readingGuideEl && storageManager.get('readingGuide')) {
            this.readingGuideEl.style.top = `${y - 6}px`;
        }

        // Update reading mask
        if (this.readingMaskEl && storageManager.get('readingMask')) {
            const topHeight = Math.max(0, y - maskHeight / 2);
            const bottomHeight = Math.max(0, viewportHeight - y - maskHeight / 2);

            const topEl = this.readingMaskEl.querySelector('.a11y-reading-mask__top');
            const bottomEl = this.readingMaskEl.querySelector('.a11y-reading-mask__bottom');

            if (topEl) topEl.style.height = `${topHeight}px`;
            if (bottomEl) bottomEl.style.height = `${bottomHeight}px`;
        }
    }

    /**
     * Reset all navigation features
     */
    reset() {
        this.setFocusIndicators(false);
        this.setLargeCursor(false);
        this.setHighlightLinks(false);
        this.setHighlightHeaders(false);
        this.setReadingGuide(false);
        this.setReadingMask(false);
    }

    /**
     * Cleanup event listeners
     */
    destroy() {
        document.removeEventListener('mousemove', this.mouseMoveHandler);
    }
}

export const navigation = new Navigation();
