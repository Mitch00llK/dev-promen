/**
 * Storage Manager
 * 
 * Handles persistence of accessibility settings using localStorage.
 * 
 * @package Promen_Elementor_Widgets
 */

const STORAGE_KEY = 'promen_a11y_settings';
const STORAGE_VERSION = '1.0';

/**
 * Default settings structure
 */
const DEFAULT_SETTINGS = {
    version: STORAGE_VERSION,

    // Content Scaling
    textScale: 100,
    pageZoom: 100,

    // Color & Contrast
    highContrast: false,
    darkContrast: false,
    lightContrast: false,
    monochrome: false,
    invertColors: false,
    saturation: 100,

    // Text Adjustments
    lineHeight: 1.5,
    letterSpacing: 0,
    wordSpacing: 0,
    dyslexiaFont: false,
    textAlign: null,

    // Navigation & Interaction
    focusIndicators: false,
    largeCursor: false,
    readingGuide: false,
    readingMask: false,
    highlightLinks: false,
    highlightHeaders: false,

    // Content Control
    stopAnimations: false,
    hideImages: false,
    muteSounds: false,
    textToSpeech: false,

    // Profile
    activeProfile: null
};

/**
 * Storage Manager class
 */
class StorageManager {
    constructor() {
        this.settings = this.load();
    }

    /**
     * Load settings from localStorage
     * @returns {Object} Settings object
     */
    load() {
        try {
            const stored = localStorage.getItem(STORAGE_KEY);

            if (!stored) {
                return { ...DEFAULT_SETTINGS };
            }

            const parsed = JSON.parse(stored);

            // Check version and migrate if needed
            if (parsed.version !== STORAGE_VERSION) {
                return this.migrate(parsed);
            }

            // Merge with defaults to ensure all keys exist
            return { ...DEFAULT_SETTINGS, ...parsed };

        } catch (error) {
            console.warn('A11y Widget: Failed to load settings', error);
            return { ...DEFAULT_SETTINGS };
        }
    }

    /**
     * Save settings to localStorage
     * @param {Object} settings Settings to save
     */
    save(settings = this.settings) {
        try {
            this.settings = { ...settings, version: STORAGE_VERSION };
            localStorage.setItem(STORAGE_KEY, JSON.stringify(this.settings));
        } catch (error) {
            console.warn('A11y Widget: Failed to save settings', error);
        }
    }

    /**
     * Get a single setting value
     * @param {string} key Setting key
     * @returns {*} Setting value
     */
    get(key) {
        return this.settings[key] ?? DEFAULT_SETTINGS[key];
    }

    /**
     * Set a single setting value
     * @param {string} key Setting key
     * @param {*} value Setting value
     */
    set(key, value) {
        this.settings[key] = value;
        this.save();
    }

    /**
     * Get all settings
     * @returns {Object} All settings
     */
    getAll() {
        return { ...this.settings };
    }

    /**
     * Reset all settings to defaults
     */
    reset() {
        this.settings = { ...DEFAULT_SETTINGS };
        this.save();
    }

    /**
     * Check if any setting is modified from default
     * @returns {boolean} True if any setting is modified
     */
    hasModifications() {
        for (const key in DEFAULT_SETTINGS) {
            if (key === 'version') continue;
            if (this.settings[key] !== DEFAULT_SETTINGS[key]) {
                return true;
            }
        }
        return false;
    }

    /**
     * Migrate settings from older versions
     * @param {Object} oldSettings Old settings object
     * @returns {Object} Migrated settings
     */
    migrate(oldSettings) {
        // For now, just use defaults with any matching keys from old settings
        const migrated = { ...DEFAULT_SETTINGS };

        for (const key in oldSettings) {
            if (key in DEFAULT_SETTINGS && key !== 'version') {
                migrated[key] = oldSettings[key];
            }
        }

        // Save migrated settings
        this.save(migrated);

        return migrated;
    }
}

// Export singleton instance
export const storageManager = new StorageManager();
export { DEFAULT_SETTINGS };
