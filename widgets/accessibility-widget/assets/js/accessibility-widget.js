/**
 * Accessibility Widget - Browser Bundle
 * 
 * Single-file bundle for browser compatibility (no ES modules).
 * This is a compiled version of all widget JS modules.
 * 
 * @package Promen_Elementor_Widgets
 */

(function () {
    'use strict';

    // ============================================
    // STORAGE MANAGER
    // ============================================

    const STORAGE_KEY = 'promen_a11y_settings';
    const STORAGE_VERSION = '1.0';

    const DEFAULT_SETTINGS = {
        version: STORAGE_VERSION,
        textScale: 100,
        pageZoom: 100,
        highContrast: false,
        darkContrast: false,
        lightContrast: false,
        monochrome: false,
        invertColors: false,
        saturation: 100,
        lineHeight: 1.5,
        letterSpacing: 0,
        wordSpacing: 0,
        dyslexiaFont: false,
        textAlign: null,
        focusIndicators: false,
        largeCursor: false,
        readingGuide: false,
        readingMask: false,
        highlightLinks: false,
        highlightHeaders: false,
        stopAnimations: false,
        hideImages: false,
        muteSounds: false,
        textToSpeech: false,
        activeProfile: null
    };

    const storageManager = {
        settings: null,

        load() {
            try {
                const stored = localStorage.getItem(STORAGE_KEY);
                if (!stored) return { ...DEFAULT_SETTINGS };
                const parsed = JSON.parse(stored);
                if (parsed.version !== STORAGE_VERSION) {
                    return { ...DEFAULT_SETTINGS, ...parsed, version: STORAGE_VERSION };
                }
                return { ...DEFAULT_SETTINGS, ...parsed };
            } catch (e) {
                return { ...DEFAULT_SETTINGS };
            }
        },

        save(settings) {
            try {
                this.settings = { ...settings, version: STORAGE_VERSION };
                localStorage.setItem(STORAGE_KEY, JSON.stringify(this.settings));
            } catch (e) { /* ignore */ }
        },

        get(key) {
            if (!this.settings) this.settings = this.load();
            return this.settings[key] ?? DEFAULT_SETTINGS[key];
        },

        set(key, value) {
            if (!this.settings) this.settings = this.load();
            this.settings[key] = value;
            this.save(this.settings);
        },

        getAll() {
            if (!this.settings) this.settings = this.load();
            return { ...this.settings };
        },

        reset() {
            this.settings = { ...DEFAULT_SETTINGS };
            this.save(this.settings);
        },

        hasModifications() {
            if (!this.settings) this.settings = this.load();
            for (const key in DEFAULT_SETTINGS) {
                if (key === 'version') continue;
                if (this.settings[key] !== DEFAULT_SETTINGS[key]) return true;
            }
            return false;
        }
    };

    // ============================================
    // DOM HELPERS
    // ============================================

    function $(selector, context) {
        return (context || document).querySelector(selector);
    }

    function $$(selector, context) {
        return (context || document).querySelectorAll(selector);
    }

    function addBodyClass(...classes) {
        document.body.classList.add(...classes);
    }

    function removeBodyClass(...classes) {
        document.body.classList.remove(...classes);
    }

    function toggleBodyClass(className, force) {
        return document.body.classList.toggle(className, force);
    }

    function setCSSVariable(property, value) {
        const name = property.startsWith('--') ? property : `--${property}`;
        document.documentElement.style.setProperty(name, value);
    }

    function announce(message) {
        const announcer = $('#a11y-announcements');
        if (!announcer) return;
        announcer.textContent = '';
        requestAnimationFrame(() => {
            announcer.textContent = message;
        });
    }

    function trapFocus(container) {
        const focusableSelectors = 'button:not([disabled]), a[href], input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])';
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
        firstFocusable?.focus();

        return () => container.removeEventListener('keydown', handleKeydown);
    }

    function debounce(fn, wait) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => fn.apply(this, args), wait);
        };
    }

    // ============================================
    // VISUAL ADJUSTMENTS
    // ============================================

    const CONTRAST_MODES = ['a11y-high-contrast', 'a11y-dark-contrast', 'a11y-light-contrast', 'a11y-monochrome', 'a11y-invert'];

    const visualAdjustments = {
        applyAllSettings() {
            const s = storageManager.getAll();
            this.setTextScale(s.textScale);
            this.setPageZoom(s.pageZoom);
            this.clearContrastModes();
            if (s.highContrast) this.setContrastMode('high-contrast');
            else if (s.darkContrast) this.setContrastMode('dark-contrast');
            else if (s.lightContrast) this.setContrastMode('light-contrast');
            else if (s.monochrome) this.setContrastMode('monochrome');
            else if (s.invertColors) this.setContrastMode('invert');
            this.setSaturation(s.saturation);
            this.setLineHeight(s.lineHeight);
            this.setLetterSpacing(s.letterSpacing);
            this.setWordSpacing(s.wordSpacing);
            this.setDyslexiaFont(s.dyslexiaFont);
            this.setTextAlign(s.textAlign);
        },

        setTextScale(scale) {
            scale = Math.max(100, Math.min(200, scale));
            storageManager.set('textScale', scale);
            if (scale !== 100) {
                setCSSVariable('--a11y-font-scale', `${scale}%`);
                addBodyClass('a11y-text-scaled');
            } else {
                removeBodyClass('a11y-text-scaled');
            }
        },

        setPageZoom(zoom) {
            zoom = Math.max(100, Math.min(150, zoom));
            storageManager.set('pageZoom', zoom);
            if (zoom !== 100) {
                setCSSVariable('--a11y-page-zoom', zoom / 100);
                addBodyClass('a11y-page-zoomed');
            } else {
                removeBodyClass('a11y-page-zoomed');
            }
        },

        clearContrastModes() {
            CONTRAST_MODES.forEach(mode => removeBodyClass(mode));
            storageManager.set('highContrast', false);
            storageManager.set('darkContrast', false);
            storageManager.set('lightContrast', false);
            storageManager.set('monochrome', false);
            storageManager.set('invertColors', false);
        },

        setContrastMode(mode) {
            const className = `a11y-${mode}`;
            const isActive = document.body.classList.contains(className);
            this.clearContrastModes();
            if (!isActive) {
                addBodyClass(className);
                const keyMap = {
                    'high-contrast': 'highContrast',
                    'dark-contrast': 'darkContrast',
                    'light-contrast': 'lightContrast',
                    'monochrome': 'monochrome',
                    'invert': 'invertColors'
                };
                if (keyMap[mode]) storageManager.set(keyMap[mode], true);
                return true;
            }
            return false;
        },

        toggleContrastMode(mode) { return this.setContrastMode(mode); },

        setSaturation(sat) {
            sat = Math.max(0, Math.min(200, sat));
            storageManager.set('saturation', sat);
            if (sat !== 100) {
                setCSSVariable('--a11y-saturation', `${sat}%`);
                addBodyClass('a11y-saturation-adjusted');
            } else {
                removeBodyClass('a11y-saturation-adjusted');
            }
        },

        setLineHeight(h) {
            h = Math.max(1, Math.min(2.5, h));
            storageManager.set('lineHeight', h);
            if (h !== 1.5) {
                setCSSVariable('--a11y-line-height-adjust', h);
                addBodyClass('a11y-line-height-adjusted');
            } else {
                removeBodyClass('a11y-line-height-adjusted');
            }
        },

        setLetterSpacing(s) {
            s = Math.max(0, Math.min(10, s));
            storageManager.set('letterSpacing', s);
            if (s !== 0) {
                setCSSVariable('--a11y-letter-spacing-adjust', `${s}px`);
                addBodyClass('a11y-letter-spacing-adjusted');
            } else {
                removeBodyClass('a11y-letter-spacing-adjusted');
            }
        },

        setWordSpacing(s) {
            s = Math.max(0, Math.min(20, s));
            storageManager.set('wordSpacing', s);
            if (s !== 0) {
                setCSSVariable('--a11y-word-spacing-adjust', `${s}px`);
                addBodyClass('a11y-word-spacing-adjusted');
            } else {
                removeBodyClass('a11y-word-spacing-adjusted');
            }
        },

        setDyslexiaFont(enabled) {
            storageManager.set('dyslexiaFont', enabled);
            toggleBodyClass('a11y-dyslexia-font', enabled);
            return enabled;
        },

        setTextAlign(align) {
            removeBodyClass('a11y-text-align-left', 'a11y-text-align-center', 'a11y-text-align-right');
            storageManager.set('textAlign', align);
            if (align && ['left', 'center', 'right'].includes(align)) {
                addBodyClass(`a11y-text-align-${align}`);
            }
        },

        reset() {
            this.setTextScale(100);
            this.setPageZoom(100);
            this.clearContrastModes();
            this.setSaturation(100);
            this.setLineHeight(1.5);
            this.setLetterSpacing(0);
            this.setWordSpacing(0);
            this.setDyslexiaFont(false);
            this.setTextAlign(null);
        }
    };

    // ============================================
    // NAVIGATION
    // ============================================

    const navigation = {
        readingGuideEl: null,
        readingMaskEl: null,
        mouseMoveHandler: null,

        init() {
            this.readingGuideEl = $('#a11y-reading-guide');
            this.readingMaskEl = $('#a11y-reading-mask');
            this.mouseMoveHandler = debounce((e) => this.updateReadingAids(e.clientY), 10);
        },

        applyAllSettings() {
            const s = storageManager.getAll();
            this.setFocusIndicators(s.focusIndicators);
            this.setLargeCursor(s.largeCursor);
            this.setHighlightLinks(s.highlightLinks);
            this.setHighlightHeaders(s.highlightHeaders);
            this.setReadingGuide(s.readingGuide);
            this.setReadingMask(s.readingMask);
        },

        setFocusIndicators(enabled) {
            storageManager.set('focusIndicators', enabled);
            toggleBodyClass('a11y-focus-indicators', enabled);
            return enabled;
        },

        setLargeCursor(enabled) {
            storageManager.set('largeCursor', enabled);
            toggleBodyClass('a11y-large-cursor', enabled);
            return enabled;
        },

        setHighlightLinks(enabled) {
            storageManager.set('highlightLinks', enabled);
            toggleBodyClass('a11y-highlight-links', enabled);
            return enabled;
        },

        setHighlightHeaders(enabled) {
            storageManager.set('highlightHeaders', enabled);
            toggleBodyClass('a11y-highlight-headers', enabled);
            return enabled;
        },

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
        },

        setReadingMask(enabled) {
            storageManager.set('readingMask', enabled);
            if (enabled) {
                this.readingMaskEl?.classList.add('is-active');
                document.addEventListener('mousemove', this.mouseMoveHandler);
            } else {
                this.readingMaskEl?.classList.remove('is-active');
                if (!storageManager.get('readingGuide')) {
                    document.removeEventListener('mousemove', this.mouseMoveHandler);
                }
            }
            return enabled;
        },

        updateReadingAids(y) {
            const vh = window.innerHeight;
            const maskHeight = 120;

            if (this.readingGuideEl && storageManager.get('readingGuide')) {
                this.readingGuideEl.style.top = `${y - 6}px`;
            }

            if (this.readingMaskEl && storageManager.get('readingMask')) {
                const topEl = this.readingMaskEl.querySelector('.a11y-reading-mask__top');
                const bottomEl = this.readingMaskEl.querySelector('.a11y-reading-mask__bottom');
                if (topEl) topEl.style.height = `${Math.max(0, y - maskHeight / 2)}px`;
                if (bottomEl) bottomEl.style.height = `${Math.max(0, vh - y - maskHeight / 2)}px`;
            }
        },

        reset() {
            this.setFocusIndicators(false);
            this.setLargeCursor(false);
            this.setHighlightLinks(false);
            this.setHighlightHeaders(false);
            this.setReadingGuide(false);
            this.setReadingMask(false);
        },

        destroy() {
            document.removeEventListener('mousemove', this.mouseMoveHandler);
        }
    };

    // ============================================
    // CONTENT CONTROL
    // ============================================

    const contentControl = {
        speechSynthesis: window.speechSynthesis || null,
        isSpeaking: false,

        applyAllSettings() {
            const s = storageManager.getAll();
            this.setStopAnimations(s.stopAnimations);
            this.setHideImages(s.hideImages);
            this.setMuteSounds(s.muteSounds);
        },

        setStopAnimations(enabled) {
            storageManager.set('stopAnimations', enabled);
            toggleBodyClass('a11y-stop-animations', enabled);
            if (enabled) {
                $$('video').forEach(v => v.pause());
            }
            return enabled;
        },

        setHideImages(enabled) {
            storageManager.set('hideImages', enabled);
            toggleBodyClass('a11y-hide-images', enabled);
            return enabled;
        },

        setMuteSounds(enabled) {
            storageManager.set('muteSounds', enabled);
            $$('video').forEach(v => v.muted = enabled);
            $$('audio').forEach(a => a.muted = enabled);
            return enabled;
        },

        setTextToSpeech(enabled) {
            storageManager.set('textToSpeech', enabled);
            if (!enabled && this.isSpeaking) this.stopSpeaking();
            if (enabled) {
                document.addEventListener('click', this.handleTTSClick);
                announce('Text to speech enabled. Click on any text to read it aloud.');
            } else {
                document.removeEventListener('click', this.handleTTSClick);
            }
            return enabled;
        },

        handleTTSClick: function (e) {
            if (e.target.closest('.a11y-widget')) return;
            const selection = window.getSelection();
            let text = '';
            if (selection && selection.toString().trim()) {
                text = selection.toString();
            } else if (e.target.textContent) {
                text = e.target.textContent.trim();
            }
            if (text) contentControl.speak(text);
        },

        speak(text) {
            if (!this.speechSynthesis) return;
            this.stopSpeaking();
            const utterance = new SpeechSynthesisUtterance(text);
            utterance.rate = 0.9;
            utterance.onstart = () => this.isSpeaking = true;
            utterance.onend = () => this.isSpeaking = false;
            utterance.onerror = () => this.isSpeaking = false;
            this.speechSynthesis.speak(utterance);
        },

        stopSpeaking() {
            if (this.speechSynthesis) this.speechSynthesis.cancel();
            this.isSpeaking = false;
        },

        reset() {
            this.setStopAnimations(false);
            this.setHideImages(false);
            this.setMuteSounds(false);
            this.setTextToSpeech(false);
        },

        destroy() {
            this.setTextToSpeech(false);
        }
    };

    // ============================================
    // COGNITIVE SUPPORT (PROFILES)
    // ============================================

    const PROFILES = {
        'vision-impaired': {
            name: 'Vision Impaired',
            settings: { textScale: 150, lineHeight: 1.8, letterSpacing: 2, focusIndicators: true, highContrast: true }
        },
        'cognitive': {
            name: 'Cognitive Disability',
            settings: { textScale: 130, lineHeight: 2, wordSpacing: 8, focusIndicators: true, highlightLinks: true, highlightHeaders: true, stopAnimations: true }
        },
        'seizure-safe': {
            name: 'Seizure Safe',
            settings: { stopAnimations: true, saturation: 50 }
        },
        'adhd-friendly': {
            name: 'ADHD Friendly',
            settings: { stopAnimations: true, readingMask: true, focusIndicators: true, saturation: 80 }
        }
    };

    const cognitiveSupport = {
        applyProfile(profileId) {
            const profile = PROFILES[profileId];
            if (!profile) return false;

            const current = storageManager.get('activeProfile');
            if (current === profileId) {
                this.resetAll();
                announce(`${profile.name} profile deactivated`);
                return false;
            }

            this.resetAll();
            const s = profile.settings;

            if (s.textScale) visualAdjustments.setTextScale(s.textScale);
            if (s.highContrast) visualAdjustments.setContrastMode('high-contrast');
            if (s.saturation !== undefined) visualAdjustments.setSaturation(s.saturation);
            if (s.lineHeight) visualAdjustments.setLineHeight(s.lineHeight);
            if (s.letterSpacing) visualAdjustments.setLetterSpacing(s.letterSpacing);
            if (s.wordSpacing) visualAdjustments.setWordSpacing(s.wordSpacing);
            if (s.focusIndicators) navigation.setFocusIndicators(true);
            if (s.readingMask) navigation.setReadingMask(true);
            if (s.highlightLinks) navigation.setHighlightLinks(true);
            if (s.highlightHeaders) navigation.setHighlightHeaders(true);
            if (s.stopAnimations) contentControl.setStopAnimations(true);

            storageManager.set('activeProfile', profileId);
            announce(`${profile.name} profile activated`);
            return true;
        },

        getActiveProfile() { return storageManager.get('activeProfile'); },
        isProfileActive(id) { return storageManager.get('activeProfile') === id; },
        resetProfile() { storageManager.set('activeProfile', null); },

        resetAll() {
            visualAdjustments.reset();
            navigation.reset();
            contentControl.reset();
            this.resetProfile();
        }
    };

    // ============================================
    // PANEL HANDLER
    // ============================================

    const panelHandler = {
        widget: null,
        toggle: null,
        panel: null,
        closeBtn: null,
        isOpen: false,
        focusTrapCleanup: null,
        previousFocus: null,

        init() {
            this.widget = $('#a11y-widget');
            this.toggle = $('#a11y-widget-toggle');
            this.panel = $('#a11y-widget-panel');
            this.closeBtn = this.panel?.querySelector('.a11y-widget__close');

            if (!this.widget || !this.toggle || !this.panel) return;

            this.toggle.addEventListener('click', () => this.togglePanel());
            this.closeBtn?.addEventListener('click', () => this.closePanel());

            document.addEventListener('click', (e) => {
                if (this.isOpen && !this.widget.contains(e.target)) this.closePanel();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && this.isOpen) {
                    e.preventDefault();
                    this.closePanel();
                }
            });
        },

        togglePanel() {
            if (this.isOpen) this.closePanel();
            else this.openPanel();
        },

        openPanel() {
            if (this.isOpen) return;
            this.previousFocus = document.activeElement;
            this.panel.hidden = false;
            this.panel.setAttribute('data-animating', 'in');
            this.toggle.setAttribute('aria-expanded', 'true');
            this.widget.classList.add('a11y-widget--open');
            this.focusTrapCleanup = trapFocus(this.panel);
            this.isOpen = true;
            setTimeout(() => this.panel.removeAttribute('data-animating'), 250);
            announce('Accessibility menu opened');
        },

        closePanel() {
            if (!this.isOpen) return;
            this.panel.setAttribute('data-animating', 'out');
            this.toggle.setAttribute('aria-expanded', 'false');
            this.widget.classList.remove('a11y-widget--open');
            if (this.focusTrapCleanup) { this.focusTrapCleanup(); this.focusTrapCleanup = null; }
            setTimeout(() => { this.panel.hidden = true; this.panel.removeAttribute('data-animating'); }, 150);
            this.previousFocus?.focus();
            this.isOpen = false;
            announce('Accessibility menu closed');
        }
    };

    // ============================================
    // CONTROL HANDLER
    // ============================================

    const controlHandler = {
        init() {
            this.bindSliders();
            this.bindToggleButtons();
            this.bindProfileButtons();
            this.bindAlignmentButtons();
            this.bindResetButton();
            this.syncUI();
        },

        bindSliders() {
            const self = this;

            const textSize = $('#a11y-text-size');
            if (textSize) textSize.addEventListener('input', (e) => {
                visualAdjustments.setTextScale(parseInt(e.target.value));
                self.updateSliderValue(e.target, `${e.target.value}%`);
            });

            const zoom = $('#a11y-zoom');
            if (zoom) zoom.addEventListener('input', (e) => {
                visualAdjustments.setPageZoom(parseInt(e.target.value));
                self.updateSliderValue(e.target, `${e.target.value}%`);
            });

            const sat = $('#a11y-saturation');
            if (sat) sat.addEventListener('input', (e) => {
                visualAdjustments.setSaturation(parseInt(e.target.value));
                self.updateSliderValue(e.target, `${e.target.value}%`);
            });

            const lh = $('#a11y-line-height');
            if (lh) lh.addEventListener('input', (e) => {
                visualAdjustments.setLineHeight(parseFloat(e.target.value));
                self.updateSliderValue(e.target, parseFloat(e.target.value).toFixed(1));
            });

            const ls = $('#a11y-letter-spacing');
            if (ls) ls.addEventListener('input', (e) => {
                visualAdjustments.setLetterSpacing(parseInt(e.target.value));
                self.updateSliderValue(e.target, `${e.target.value}px`);
            });

            const ws = $('#a11y-word-spacing');
            if (ws) ws.addEventListener('input', (e) => {
                visualAdjustments.setWordSpacing(parseInt(e.target.value));
                self.updateSliderValue(e.target, `${e.target.value}px`);
            });
        },

        updateSliderValue(slider, value) {
            const el = slider.parentElement?.querySelector('.a11y-widget__slider-value');
            if (el) el.textContent = value;
            slider.setAttribute('aria-valuenow', slider.value);
        },

        bindToggleButtons() {
            const self = this;
            // Updated selector to match new Switch HTML
            $$('.a11y-widget__switch[data-setting]').forEach(btn => {
                btn.addEventListener('click', () => self.handleToggle(btn.dataset.setting, btn));
            });
            // Also bind contrast buttons (they are separate now)
            $$('.a11y-widget__contrast-btn[data-setting]').forEach(btn => {
                btn.addEventListener('click', () => self.handleToggle(btn.dataset.setting, btn));
            });
        },

        handleToggle(setting, btn) {
            let newState;

            switch (setting) {
                case 'high-contrast':
                case 'dark-contrast':
                case 'light-contrast':
                case 'monochrome':
                case 'invert-colors':
                    const mode = setting === 'invert-colors' ? 'invert' : setting;
                    newState = visualAdjustments.toggleContrastMode(mode);
                    this.syncContrastButtons();
                    break;
                case 'dyslexia-font':
                    newState = !storageManager.get('dyslexiaFont');
                    visualAdjustments.setDyslexiaFont(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'focus-indicators':
                    newState = !storageManager.get('focusIndicators');
                    navigation.setFocusIndicators(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'large-cursor':
                    newState = !storageManager.get('largeCursor');
                    navigation.setLargeCursor(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'reading-guide':
                    newState = !storageManager.get('readingGuide');
                    navigation.setReadingGuide(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'reading-mask':
                    newState = !storageManager.get('readingMask');
                    navigation.setReadingMask(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'highlight-links':
                    newState = !storageManager.get('highlightLinks');
                    navigation.setHighlightLinks(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'highlight-headers':
                    newState = !storageManager.get('highlightHeaders');
                    navigation.setHighlightHeaders(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'stop-animations':
                    newState = !storageManager.get('stopAnimations');
                    contentControl.setStopAnimations(newState);
                    this.updateButtonState(button, newState); // Fixed variable name 'button' to 'btn'
                    break;
                case 'hide-images':
                    newState = !storageManager.get('hideImages');
                    contentControl.setHideImages(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'mute-sounds':
                    newState = !storageManager.get('muteSounds');
                    contentControl.setMuteSounds(newState);
                    this.updateButtonState(btn, newState);
                    break;
                case 'text-to-speech':
                    newState = !storageManager.get('textToSpeech');
                    contentControl.setTextToSpeech(newState);
                    this.updateButtonState(btn, newState);
                    break;
                default:
                    return;
            }

            // Sync others if not contrast (handled above)
            if (!['high-contrast', 'dark-contrast', 'light-contrast', 'monochrome', 'invert-colors'].includes(setting)) {
                // Check if it's a switch or button
                // updateButtonState handles the logic
            }

            cognitiveSupport.resetProfile();
            this.syncProfileButtons();
        },

        updateButtonState(button, isActive) {
            if (!button) return;
            const role = button.getAttribute('role');
            if (role === 'switch') {
                button.setAttribute('aria-checked', isActive ? 'true' : 'false');
            } else {
                button.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            }
            button.classList.toggle('is-active', isActive);
        },

        syncContrastButtons() {
            const s = storageManager.getAll();
            const states = {
                'high-contrast': s.highContrast,
                'dark-contrast': s.darkContrast,
                'light-contrast': s.lightContrast,
                'invert-colors': s.invertColors
            };
            for (const [key, active] of Object.entries(states)) {
                const btn = $(`.a11y-widget__contrast-btn[data-setting="${key}"]`);
                if (btn) this.updateButtonState(btn, active);
            }
        },

        bindProfileButtons() {
            const self = this;
            $$('.a11y-widget__profile[data-profile]').forEach(btn => {
                btn.addEventListener('click', () => {
                    cognitiveSupport.applyProfile(btn.dataset.profile);
                    self.syncUI();
                });
            });
        },

        bindAlignmentButtons() {
            const self = this;
            const btns = $$('.a11y-widget__align-btn[data-align]');
            btns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const current = storageManager.get('textAlign');
                    const newAlign = current === btn.dataset.align ? null : btn.dataset.align;
                    visualAdjustments.setTextAlign(newAlign);
                    btns.forEach(b => self.updateButtonState(b, b.dataset.align === newAlign));
                    cognitiveSupport.resetProfile();
                    self.syncProfileButtons();
                });
            });
        },

        bindResetButton() {
            const self = this;
            const resetBtn = $('#a11y-reset-all');
            resetBtn?.addEventListener('click', () => {
                cognitiveSupport.resetAll();
                storageManager.reset();
                self.syncUI();
                announce('All accessibility settings have been reset');
            });
        },

        updateButtonState(btn, isActive) {
            btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            btn.classList.toggle('is-active', isActive);
        },

        syncContrastButtons() {
            const s = storageManager.getAll();
            const map = {
                'high-contrast': s.highContrast,
                'dark-contrast': s.darkContrast,
                'light-contrast': s.lightContrast,
                'monochrome': s.monochrome,
                'invert-colors': s.invertColors
            };
            Object.entries(map).forEach(([setting, active]) => {
                const btn = $(`.a11y-widget__toggle-btn[data-setting="${setting}"]`);
                if (btn) this.updateButtonState(btn, active);
            });
        },

        syncProfileButtons() {
            const active = cognitiveSupport.getActiveProfile();
            $$('.a11y-widget__profile[data-profile]').forEach(btn => {
                this.updateButtonState(btn, btn.dataset.profile === active);
            });
        },

        syncUI() {
            const settings = storageManager.getAll();

            // Sync sliders
            this.syncSlider('#a11y-text-size', settings.textScale, `${settings.textScale}%`);
            this.syncSlider('#a11y-zoom', settings.pageZoom, `${settings.pageZoom}%`);
            this.syncSlider('#a11y-line-height', settings.lineHeight, settings.lineHeight.toFixed(1));
            this.syncSlider('#a11y-letter-spacing', settings.letterSpacing, `${settings.letterSpacing}px`);

            // Sync contrast buttons
            this.syncContrastButtons();

            // Sync switches
            const toggleSettings = {
                'dyslexia-font': settings.dyslexiaFont,
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

            Object.keys(toggleSettings).forEach(setting => {
                const btn = $(`.a11y-widget__switch[data-setting="${setting}"]`);
                if (btn) this.updateButtonState(btn, toggleSettings[setting]);
            });

            // Sync profile buttons
            this.syncProfileButtons();
        },

        syncSlider(selector, value, display) {
            const slider = $(selector);
            if (slider) {
                slider.value = value;
                slider.setAttribute('aria-valuenow', value);
                this.updateSliderValue(slider, display);
            }
        }
    };

    // ============================================
    // MAIN INIT
    // ============================================

    function initWidget() {
        try {
            navigation.init();
            panelHandler.init();
            controlHandler.init();

            if (storageManager.hasModifications()) {
                visualAdjustments.applyAllSettings();
                navigation.applyAllSettings();
                contentControl.applyAllSettings();
            }

            console.log('A11y Widget: Initialized');
        } catch (e) {
            console.error('A11y Widget: Init failed', e);
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initWidget);
    } else {
        initWidget();
    }

    // Expose for debugging
    window.promenA11y = {
        storage: storageManager,
        visual: visualAdjustments,
        navigation: navigation,
        content: contentControl,
        profiles: cognitiveSupport,
        panel: panelHandler,
        controls: controlHandler
    };

})();
