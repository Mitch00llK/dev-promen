/**
 * Cognitive Support Module
 * 
 * Handles accessibility profile presets.
 * 
 * @package Promen_Elementor_Widgets
 */

import { storageManager } from '../utilities/storage-manager.js';
import { visualAdjustments } from './visual-adjustments.js';
import { navigation } from './navigation.js';
import { contentControl } from './content-control.js';
import { announce } from '../utilities/dom-helper.js';

/**
 * Profile definitions
 * Each profile is a set of settings to apply together
 */
const PROFILES = {
    'vision-impaired': {
        name: 'Vision Impaired',
        settings: {
            textScale: 150,
            lineHeight: 1.8,
            letterSpacing: 2,
            focusIndicators: true,
            highContrast: true
        }
    },
    'cognitive': {
        name: 'Cognitive Disability',
        settings: {
            textScale: 130,
            lineHeight: 2,
            wordSpacing: 8,
            focusIndicators: true,
            highlightLinks: true,
            highlightHeaders: true,
            stopAnimations: true
        }
    },
    'seizure-safe': {
        name: 'Seizure Safe',
        settings: {
            stopAnimations: true,
            saturation: 50
        }
    },
    'adhd-friendly': {
        name: 'ADHD Friendly',
        settings: {
            stopAnimations: true,
            readingMask: true,
            focusIndicators: true,
            saturation: 80
        }
    }
};

/**
 * Cognitive Support Controller
 */
class CognitiveSupport {
    constructor() {
        this.i18n = window.promenA11yWidget?.i18n || {};
    }

    /**
     * Apply a profile preset
     * @param {string} profileId Profile identifier
     * @returns {boolean} Whether profile was applied
     */
    applyProfile(profileId) {
        const profile = PROFILES[profileId];
        if (!profile) {
            console.warn(`A11y Widget: Unknown profile "${profileId}"`);
            return false;
        }

        const currentProfile = storageManager.get('activeProfile');

        // If same profile is active, deactivate it
        if (currentProfile === profileId) {
            this.resetProfile();
            announce(`${profile.name} profile deactivated`);
            return false;
        }

        // Reset everything first
        this.resetAll();

        // Apply profile settings
        const settings = profile.settings;

        // Visual adjustments
        if (settings.textScale) visualAdjustments.setTextScale(settings.textScale);
        if (settings.pageZoom) visualAdjustments.setPageZoom(settings.pageZoom);
        if (settings.highContrast) visualAdjustments.setContrastMode('high-contrast');
        if (settings.darkContrast) visualAdjustments.setContrastMode('dark-contrast');
        if (settings.lightContrast) visualAdjustments.setContrastMode('light-contrast');
        if (settings.monochrome) visualAdjustments.setContrastMode('monochrome');
        if (settings.invertColors) visualAdjustments.setContrastMode('invert');
        if (settings.saturation !== undefined) visualAdjustments.setSaturation(settings.saturation);
        if (settings.lineHeight) visualAdjustments.setLineHeight(settings.lineHeight);
        if (settings.letterSpacing) visualAdjustments.setLetterSpacing(settings.letterSpacing);
        if (settings.wordSpacing) visualAdjustments.setWordSpacing(settings.wordSpacing);
        if (settings.dyslexiaFont) visualAdjustments.setDyslexiaFont(settings.dyslexiaFont);

        // Navigation
        if (settings.focusIndicators) navigation.setFocusIndicators(settings.focusIndicators);
        if (settings.largeCursor) navigation.setLargeCursor(settings.largeCursor);
        if (settings.readingGuide) navigation.setReadingGuide(settings.readingGuide);
        if (settings.readingMask) navigation.setReadingMask(settings.readingMask);
        if (settings.highlightLinks) navigation.setHighlightLinks(settings.highlightLinks);
        if (settings.highlightHeaders) navigation.setHighlightHeaders(settings.highlightHeaders);

        // Content control
        if (settings.stopAnimations) contentControl.setStopAnimations(settings.stopAnimations);
        if (settings.hideImages) contentControl.setHideImages(settings.hideImages);
        if (settings.muteSounds) contentControl.setMuteSounds(settings.muteSounds);

        // Store active profile
        storageManager.set('activeProfile', profileId);

        announce(`${profile.name} profile activated`);

        return true;
    }

    /**
     * Get active profile ID
     * @returns {string|null} Active profile ID
     */
    getActiveProfile() {
        return storageManager.get('activeProfile');
    }

    /**
     * Check if a profile is active
     * @param {string} profileId Profile ID
     * @returns {boolean} Whether profile is active
     */
    isProfileActive(profileId) {
        return storageManager.get('activeProfile') === profileId;
    }

    /**
     * Reset current profile
     */
    resetProfile() {
        storageManager.set('activeProfile', null);
    }

    /**
     * Reset all settings to defaults
     */
    resetAll() {
        visualAdjustments.reset();
        navigation.reset();
        contentControl.reset();
        this.resetProfile();
    }

    /**
     * Get all available profiles
     * @returns {Object} Profiles object
     */
    getProfiles() {
        return PROFILES;
    }
}

export const cognitiveSupport = new CognitiveSupport();
