/**
 * Visual Adjustments Module
 * 
 * Handles color, contrast, text size, and text style controls.
 * 
 * @package Promen_Elementor_Widgets
 */

import { storageManager } from '../utilities/storage-manager.js';
import {
    addBodyClass,
    removeBodyClass,
    toggleBodyClass,
    setCSSVariable,
    announce
} from '../utilities/dom-helper.js';

// Contrast mode classes (mutually exclusive)
const CONTRAST_MODES = [
    'a11y-high-contrast',
    'a11y-dark-contrast',
    'a11y-light-contrast',
    'a11y-monochrome',
    'a11y-invert'
];

/**
 * Visual Adjustments Controller
 */
class VisualAdjustments {
    constructor() {
        this.i18n = window.promenA11yWidget?.i18n || {};
    }

    /**
     * Apply all saved visual settings
     */
    applyAllSettings() {
        const settings = storageManager.getAll();

        // Apply text scaling
        this.setTextScale(settings.textScale);

        // Apply page zoom
        this.setPageZoom(settings.pageZoom);

        // Apply contrast mode
        this.clearContrastModes();
        if (settings.highContrast) this.setContrastMode('high-contrast');
        else if (settings.darkContrast) this.setContrastMode('dark-contrast');
        else if (settings.lightContrast) this.setContrastMode('light-contrast');
        else if (settings.monochrome) this.setContrastMode('monochrome');
        else if (settings.invertColors) this.setContrastMode('invert');

        // Apply saturation
        this.setSaturation(settings.saturation);

        // Apply text adjustments
        this.setLineHeight(settings.lineHeight);
        this.setLetterSpacing(settings.letterSpacing);
        this.setWordSpacing(settings.wordSpacing);
        this.setDyslexiaFont(settings.dyslexiaFont);
        this.setTextAlign(settings.textAlign);
    }

    /**
     * Set text scale
     * @param {number} scale Scale percentage (100-200)
     */
    setTextScale(scale) {
        scale = Math.max(100, Math.min(200, scale));
        storageManager.set('textScale', scale);

        if (scale !== 100) {
            setCSSVariable('--a11y-font-scale', `${scale}%`);
            addBodyClass('a11y-text-scaled');
        } else {
            removeBodyClass('a11y-text-scaled');
        }
    }

    /**
     * Set page zoom
     * @param {number} zoom Zoom percentage (100-150)
     */
    setPageZoom(zoom) {
        zoom = Math.max(100, Math.min(150, zoom));
        storageManager.set('pageZoom', zoom);

        if (zoom !== 100) {
            setCSSVariable('--a11y-page-zoom', zoom / 100);
            addBodyClass('a11y-page-zoomed');
        } else {
            removeBodyClass('a11y-page-zoomed');
        }
    }

    /**
     * Clear all contrast modes
     */
    clearContrastModes() {
        CONTRAST_MODES.forEach(mode => removeBodyClass(mode));

        storageManager.set('highContrast', false);
        storageManager.set('darkContrast', false);
        storageManager.set('lightContrast', false);
        storageManager.set('monochrome', false);
        storageManager.set('invertColors', false);
    }

    /**
     * Set contrast mode (mutually exclusive)
     * @param {string} mode Contrast mode name
     * @returns {boolean} New state
     */
    setContrastMode(mode) {
        const className = `a11y-${mode}`;
        const isCurrentlyActive = document.body.classList.contains(className);

        // Clear all contrast modes first
        this.clearContrastModes();

        // If not currently active, enable this mode
        if (!isCurrentlyActive) {
            addBodyClass(className);

            // Map mode to storage key
            const keyMap = {
                'high-contrast': 'highContrast',
                'dark-contrast': 'darkContrast',
                'light-contrast': 'lightContrast',
                'monochrome': 'monochrome',
                'invert': 'invertColors'
            };

            if (keyMap[mode]) {
                storageManager.set(keyMap[mode], true);
            }

            return true;
        }

        return false;
    }

    /**
     * Toggle contrast mode
     * @param {string} mode Mode name
     * @returns {boolean} New state
     */
    toggleContrastMode(mode) {
        return this.setContrastMode(mode);
    }

    /**
     * Set saturation level
     * @param {number} saturation Saturation percentage (0-200)
     */
    setSaturation(saturation) {
        saturation = Math.max(0, Math.min(200, saturation));
        storageManager.set('saturation', saturation);

        if (saturation !== 100) {
            setCSSVariable('--a11y-saturation', `${saturation}%`);
            addBodyClass('a11y-saturation-adjusted');
        } else {
            removeBodyClass('a11y-saturation-adjusted');
        }
    }

    /**
     * Set line height
     * @param {number} height Line height multiplier (1-2.5)
     */
    setLineHeight(height) {
        height = Math.max(1, Math.min(2.5, height));
        storageManager.set('lineHeight', height);

        if (height !== 1.5) {
            setCSSVariable('--a11y-line-height-adjust', height);
            addBodyClass('a11y-line-height-adjusted');
        } else {
            removeBodyClass('a11y-line-height-adjusted');
        }
    }

    /**
     * Set letter spacing
     * @param {number} spacing Spacing in pixels (0-10)
     */
    setLetterSpacing(spacing) {
        spacing = Math.max(0, Math.min(10, spacing));
        storageManager.set('letterSpacing', spacing);

        if (spacing !== 0) {
            setCSSVariable('--a11y-letter-spacing-adjust', `${spacing}px`);
            addBodyClass('a11y-letter-spacing-adjusted');
        } else {
            removeBodyClass('a11y-letter-spacing-adjusted');
        }
    }

    /**
     * Set word spacing
     * @param {number} spacing Spacing in pixels (0-20)
     */
    setWordSpacing(spacing) {
        spacing = Math.max(0, Math.min(20, spacing));
        storageManager.set('wordSpacing', spacing);

        if (spacing !== 0) {
            setCSSVariable('--a11y-word-spacing-adjust', `${spacing}px`);
            addBodyClass('a11y-word-spacing-adjusted');
        } else {
            removeBodyClass('a11y-word-spacing-adjusted');
        }
    }

    /**
     * Toggle dyslexia-friendly font
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setDyslexiaFont(enabled) {
        storageManager.set('dyslexiaFont', enabled);
        toggleBodyClass('a11y-dyslexia-font', enabled);
        return enabled;
    }

    /**
     * Set text alignment
     * @param {string|null} align Alignment ('left', 'center', 'right', null)
     */
    setTextAlign(align) {
        // Remove all alignment classes
        removeBodyClass('a11y-text-align-left', 'a11y-text-align-center', 'a11y-text-align-right');

        storageManager.set('textAlign', align);

        if (align && ['left', 'center', 'right'].includes(align)) {
            addBodyClass(`a11y-text-align-${align}`);
        }
    }

    /**
     * Reset all visual adjustments
     */
    reset() {
        // Reset text scaling
        this.setTextScale(100);
        this.setPageZoom(100);

        // Clear contrast modes
        this.clearContrastModes();

        // Reset saturation
        this.setSaturation(100);

        // Reset text adjustments
        this.setLineHeight(1.5);
        this.setLetterSpacing(0);
        this.setWordSpacing(0);
        this.setDyslexiaFont(false);
        this.setTextAlign(null);
    }
}

export const visualAdjustments = new VisualAdjustments();
