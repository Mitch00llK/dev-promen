/**
 * Control Handler
 * 
 * Manages control interactions (buttons, sliders, etc.)
 * 
 * @package Promen_Elementor_Widgets
 */

import { $, $$, announce } from '../utilities/dom-helper.js';
import { storageManager } from '../utilities/storage-manager.js';
import { visualAdjustments } from '../modules/visual-adjustments.js';
import { navigation } from '../modules/navigation.js';
import { contentControl } from '../modules/content-control.js';
import { cognitiveSupport } from '../modules/cognitive-support.js';

/**
 * Control Handler Class
 */
class ControlHandler {
    constructor() {
        this.i18n = window.promenA11yWidget?.i18n || {};
    }

    /**
     * Initialize control handlers
     */
    init() {
        this.bindSliders();
        this.bindToggleButtons();
        this.bindProfileButtons();
        this.bindAlignmentButtons();
        this.bindResetButton();

        // Sync UI with current settings
        this.syncUI();
    }

    /**
     * Bind slider controls
     */
    bindSliders() {
        // Text size slider
        const textSizeSlider = $('#a11y-text-size');
        if (textSizeSlider) {
            textSizeSlider.addEventListener('input', (e) => {
                const value = parseInt(e.target.value);
                visualAdjustments.setTextScale(value);
                this.updateSliderValue(e.target, `${value}%`);
            });
        }

        // Page zoom slider
        const zoomSlider = $('#a11y-zoom');
        if (zoomSlider) {
            zoomSlider.addEventListener('input', (e) => {
                const value = parseInt(e.target.value);
                visualAdjustments.setPageZoom(value);
                this.updateSliderValue(e.target, `${value}%`);
            });
        }

        // Saturation slider
        const saturationSlider = $('#a11y-saturation');
        if (saturationSlider) {
            saturationSlider.addEventListener('input', (e) => {
                const value = parseInt(e.target.value);
                visualAdjustments.setSaturation(value);
                this.updateSliderValue(e.target, `${value}%`);
            });
        }

        // Line height slider
        const lineHeightSlider = $('#a11y-line-height');
        if (lineHeightSlider) {
            lineHeightSlider.addEventListener('input', (e) => {
                const value = parseFloat(e.target.value);
                visualAdjustments.setLineHeight(value);
                this.updateSliderValue(e.target, value.toFixed(1));
            });
        }

        // Letter spacing slider
        const letterSpacingSlider = $('#a11y-letter-spacing');
        if (letterSpacingSlider) {
            letterSpacingSlider.addEventListener('input', (e) => {
                const value = parseInt(e.target.value);
                visualAdjustments.setLetterSpacing(value);
                this.updateSliderValue(e.target, `${value}px`);
            });
        }

        // Word spacing slider
        const wordSpacingSlider = $('#a11y-word-spacing');
        if (wordSpacingSlider) {
            wordSpacingSlider.addEventListener('input', (e) => {
                const value = parseInt(e.target.value);
                visualAdjustments.setWordSpacing(value);
                this.updateSliderValue(e.target, `${value}px`);
            });
        }
    }

    /**
     * Update slider value display
     * @param {Element} slider Slider element
     * @param {string} value Display value
     */
    updateSliderValue(slider, value) {
        const valueEl = slider.parentElement?.querySelector('.a11y-widget__slider-value');
        if (valueEl) {
            valueEl.textContent = value;
        }
        slider.setAttribute('aria-valuenow', slider.value);
    }

    /**
     * Bind toggle button controls
     */
    bindToggleButtons() {
        const toggleButtons = $$('.a11y-widget__toggle-btn[data-setting]');

        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const setting = button.dataset.setting;
                this.handleToggleSetting(setting, button);
            });
        });
    }

    /**
     * Handle toggle setting
     * @param {string} setting Setting name
     * @param {Element} button Button element
     */
    handleToggleSetting(setting, button) {
        let newState;

        switch (setting) {
            // Contrast modes (mutually exclusive)
            case 'high-contrast':
            case 'dark-contrast':
            case 'light-contrast':
            case 'monochrome':
            case 'invert-colors':
                const mode = setting === 'invert-colors' ? 'invert' : setting;
                newState = visualAdjustments.toggleContrastMode(mode);
                // Update all contrast buttons
                this.syncContrastButtons();
                break;

            // Dyslexia font
            case 'dyslexia-font':
                newState = !storageManager.get('dyslexiaFont');
                visualAdjustments.setDyslexiaFont(newState);
                break;

            // Navigation features
            case 'focus-indicators':
                newState = !storageManager.get('focusIndicators');
                navigation.setFocusIndicators(newState);
                break;

            case 'large-cursor':
                newState = !storageManager.get('largeCursor');
                navigation.setLargeCursor(newState);
                break;

            case 'reading-guide':
                newState = !storageManager.get('readingGuide');
                navigation.setReadingGuide(newState);
                break;

            case 'reading-mask':
                newState = !storageManager.get('readingMask');
                navigation.setReadingMask(newState);
                break;

            case 'highlight-links':
                newState = !storageManager.get('highlightLinks');
                navigation.setHighlightLinks(newState);
                break;

            case 'highlight-headers':
                newState = !storageManager.get('highlightHeaders');
                navigation.setHighlightHeaders(newState);
                break;

            // Content control
            case 'stop-animations':
                newState = !storageManager.get('stopAnimations');
                contentControl.setStopAnimations(newState);
                break;

            case 'hide-images':
                newState = !storageManager.get('hideImages');
                contentControl.setHideImages(newState);
                break;

            case 'mute-sounds':
                newState = !storageManager.get('muteSounds');
                contentControl.setMuteSounds(newState);
                break;

            case 'text-to-speech':
                newState = !storageManager.get('textToSpeech');
                contentControl.setTextToSpeech(newState);
                break;

            default:
                console.warn(`A11y Widget: Unknown setting "${setting}"`);
                return;
        }

        // Update button state
        this.updateButtonState(button, newState);

        // Clear profile if manually changing settings
        cognitiveSupport.resetProfile();
        this.syncProfileButtons();
    }

    /**
     * Bind profile preset buttons
     */
    bindProfileButtons() {
        const profileButtons = $$('.a11y-widget__profile[data-profile]');

        profileButtons.forEach(button => {
            button.addEventListener('click', () => {
                const profileId = button.dataset.profile;
                cognitiveSupport.applyProfile(profileId);
                this.syncUI();
            });
        });
    }

    /**
     * Bind alignment buttons
     */
    bindAlignmentButtons() {
        const alignButtons = $$('.a11y-widget__align-btn[data-align]');

        alignButtons.forEach(button => {
            button.addEventListener('click', () => {
                const align = button.dataset.align;
                const currentAlign = storageManager.get('textAlign');

                // Toggle off if clicking same alignment
                const newAlign = currentAlign === align ? null : align;
                visualAdjustments.setTextAlign(newAlign);

                // Update button states
                alignButtons.forEach(btn => {
                    this.updateButtonState(btn, btn.dataset.align === newAlign);
                });

                // Clear profile
                cognitiveSupport.resetProfile();
                this.syncProfileButtons();
            });
        });
    }

    /**
     * Bind reset button
     */
    bindResetButton() {
        const resetBtn = $('#a11y-reset-all');

        resetBtn?.addEventListener('click', () => {
            cognitiveSupport.resetAll();
            storageManager.reset();
            this.syncUI();
            announce(this.i18n.settingsReset || 'All accessibility settings have been reset');
        });
    }

    /**
     * Update button pressed state
     * @param {Element} button Button element
     * @param {boolean} isActive Active state
     */
    updateButtonState(button, isActive) {
        button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        button.classList.toggle('is-active', isActive);
    }

    /**
     * Sync all contrast mode buttons
     */
    syncContrastButtons() {
        const settings = storageManager.getAll();

        const buttons = {
            'high-contrast': settings.highContrast,
            'dark-contrast': settings.darkContrast,
            'light-contrast': settings.lightContrast,
            'monochrome': settings.monochrome,
            'invert-colors': settings.invertColors
        };

        Object.entries(buttons).forEach(([setting, isActive]) => {
            const button = $(`.a11y-widget__toggle-btn[data-setting="${setting}"]`);
            if (button) {
                this.updateButtonState(button, isActive);
            }
        });
    }

    /**
     * Sync profile buttons
     */
    syncProfileButtons() {
        const activeProfile = cognitiveSupport.getActiveProfile();

        $$('.a11y-widget__profile[data-profile]').forEach(button => {
            const isActive = button.dataset.profile === activeProfile;
            this.updateButtonState(button, isActive);
        });
    }

    /**
     * Sync entire UI with current settings
     */
    syncUI() {
        const settings = storageManager.getAll();

        // Sync sliders
        this.syncSlider('#a11y-text-size', settings.textScale, `${settings.textScale}%`);
        this.syncSlider('#a11y-zoom', settings.pageZoom, `${settings.pageZoom}%`);
        this.syncSlider('#a11y-saturation', settings.saturation, `${settings.saturation}%`);
        this.syncSlider('#a11y-line-height', settings.lineHeight, settings.lineHeight.toFixed(1));
        this.syncSlider('#a11y-letter-spacing', settings.letterSpacing, `${settings.letterSpacing}px`);
        this.syncSlider('#a11y-word-spacing', settings.wordSpacing, `${settings.wordSpacing}px`);

        // Sync contrast buttons
        this.syncContrastButtons();

        // Sync toggle buttons
        const toggleSettings = {
            'dyslexia-font': settings.dyslexiaFont,
            'focus-indicators': settings.focusIndicators,
            'large-cursor': settings.largeCursor,
            'reading-guide': settings.readingGuide,
            'reading-mask': settings.readingMask,
            'highlight-links': settings.highlightLinks,
            'highlight-headers': settings.highlightHeaders,
            'stop-animations': settings.stopAnimations,
            'hide-images': settings.hideImages,
            'mute-sounds': settings.muteSounds,
            'text-to-speech': settings.textToSpeech
        };

        Object.entries(toggleSettings).forEach(([setting, isActive]) => {
            const button = $(`.a11y-widget__toggle-btn[data-setting="${setting}"]`);
            if (button) {
                this.updateButtonState(button, isActive);
            }
        });

        // Sync alignment buttons
        $$('.a11y-widget__align-btn[data-align]').forEach(button => {
            this.updateButtonState(button, button.dataset.align === settings.textAlign);
        });

        // Sync profile buttons
        this.syncProfileButtons();
    }

    /**
     * Sync slider value
     * @param {string} selector Slider selector
     * @param {number} value Slider value
     * @param {string} display Display value
     */
    syncSlider(selector, value, display) {
        const slider = $(selector);
        if (slider) {
            slider.value = value;
            slider.setAttribute('aria-valuenow', value);
            this.updateSliderValue(slider, display);
        }
    }
}

export const controlHandler = new ControlHandler();
