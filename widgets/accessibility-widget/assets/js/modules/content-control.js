/**
 * Content Control Module
 * 
 * Handles animations, media, and text-to-speech controls.
 * 
 * @package Promen_Elementor_Widgets
 */

import { storageManager } from '../utilities/storage-manager.js';
import {
    $$,
    addBodyClass,
    removeBodyClass,
    toggleBodyClass,
    announce
} from '../utilities/dom-helper.js';

/**
 * Content Control Controller
 */
class ContentControl {
    constructor() {
        this.speechSynthesis = window.speechSynthesis || null;
        this.currentUtterance = null;
        this.isSpeaking = false;
    }

    /**
     * Apply all saved content control settings
     */
    applyAllSettings() {
        const settings = storageManager.getAll();

        this.setStopAnimations(settings.stopAnimations);
        this.setHideImages(settings.hideImages);
        this.setMuteSounds(settings.muteSounds);

        // Text-to-speech is not auto-applied on load
    }

    /**
     * Toggle stop animations
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setStopAnimations(enabled) {
        storageManager.set('stopAnimations', enabled);
        toggleBodyClass('a11y-stop-animations', enabled);

        if (enabled) {
            // Pause all videos
            $$('video').forEach(video => {
                video.pause();
            });

            // Stop CSS animations by adding class
            // The CSS will handle setting animation-duration to 0
        }

        return enabled;
    }

    /**
     * Toggle hide images
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setHideImages(enabled) {
        storageManager.set('hideImages', enabled);
        toggleBodyClass('a11y-hide-images', enabled);
        return enabled;
    }

    /**
     * Toggle mute sounds
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setMuteSounds(enabled) {
        storageManager.set('muteSounds', enabled);

        // Mute all videos
        $$('video').forEach(video => {
            video.muted = enabled;
        });

        // Mute all audio elements
        $$('audio').forEach(audio => {
            audio.muted = enabled;
        });

        return enabled;
    }

    /**
     * Toggle text-to-speech
     * @param {boolean} enabled Enable state
     * @returns {boolean} New state
     */
    setTextToSpeech(enabled) {
        storageManager.set('textToSpeech', enabled);

        if (!enabled && this.isSpeaking) {
            this.stopSpeaking();
        }

        if (enabled) {
            this.enableTTS();
        } else {
            this.disableTTS();
        }

        return enabled;
    }

    /**
     * Enable text-to-speech mode
     */
    enableTTS() {
        if (!this.speechSynthesis) {
            console.warn('A11y Widget: Speech synthesis not supported');
            return;
        }

        // Add click listener for reading selected text or clicked elements
        document.addEventListener('click', this.handleTTSClick);

        announce('Text to speech enabled. Click on any text to read it aloud.');
    }

    /**
     * Disable text-to-speech mode
     */
    disableTTS() {
        document.removeEventListener('click', this.handleTTSClick);
        this.stopSpeaking();
    }

    /**
     * Handle click for TTS
     * @param {Event} e Click event
     */
    handleTTSClick = (e) => {
        // Don't read clicks on the widget itself
        if (e.target.closest('.a11y-widget')) return;

        // Get selected text or element text
        const selection = window.getSelection();
        let textToRead = '';

        if (selection && selection.toString().trim()) {
            textToRead = selection.toString();
        } else if (e.target.textContent) {
            textToRead = e.target.textContent.trim();
        }

        if (textToRead) {
            this.speak(textToRead);
        }
    };

    /**
     * Speak text using Web Speech API
     * @param {string} text Text to speak
     */
    speak(text) {
        if (!this.speechSynthesis) return;

        // Stop any current speech
        this.stopSpeaking();

        // Create new utterance
        this.currentUtterance = new SpeechSynthesisUtterance(text);
        this.currentUtterance.rate = 0.9;
        this.currentUtterance.pitch = 1;

        this.currentUtterance.onstart = () => {
            this.isSpeaking = true;
        };

        this.currentUtterance.onend = () => {
            this.isSpeaking = false;
        };

        this.currentUtterance.onerror = () => {
            this.isSpeaking = false;
        };

        this.speechSynthesis.speak(this.currentUtterance);
    }

    /**
     * Stop current speech
     */
    stopSpeaking() {
        if (this.speechSynthesis) {
            this.speechSynthesis.cancel();
        }
        this.isSpeaking = false;
    }

    /**
     * Reset all content control features
     */
    reset() {
        this.setStopAnimations(false);
        this.setHideImages(false);
        this.setMuteSounds(false);
        this.setTextToSpeech(false);
    }

    /**
     * Cleanup
     */
    destroy() {
        this.disableTTS();
    }
}

export const contentControl = new ContentControl();
