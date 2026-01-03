(function (window, document) {
    'use strict';

    let currentUtterance = null;
    let currentButton = null;
    let currentHighlightElement = null;
    let wordSpans = [];
    let currentWordIndex = -1;
    let highlightInterval = null;
    let floatingControl = null;
    let isPaused = false;

    const HIGHLIGHT_CLASS = 'promen-text-content-block__tts-highlight';
    const WORD_SPAN_CLASS = 'promen-text-content-block__tts-word';
    const INLINE_ICON_SELECTOR = '.promen-text-content-block__tts-icon i';
    const FLOATING_ICON_SELECTOR = 'i';

    const setInlineButtonIconState = (button, state) => {
        if (!button) {
            return;
        }

        const icon = button.querySelector(INLINE_ICON_SELECTOR);
        if (!icon) {
            return;
        }

        icon.classList.remove('fa-play', 'fa-stop');
        if (state === 'stop') {
            icon.classList.add('fa-stop');
        } else {
            icon.classList.add('fa-play');
        }
    };

    /**
     * Create floating TTS control bar
     */
    const createFloatingControl = () => {
        if (floatingControl) {
            return floatingControl;
        }

        const control = document.createElement('div');
        control.className = 'promen-text-content-block__tts-floating';
        control.setAttribute('role', 'toolbar');
        control.setAttribute('aria-label', 'Text-to-speech controls');

        // Play/Pause button
        const playPauseBtn = document.createElement('button');
        playPauseBtn.className = 'promen-text-content-block__tts-floating-button';
        playPauseBtn.setAttribute('type', 'button');
        playPauseBtn.setAttribute('aria-label', 'Pause');
        playPauseBtn.setAttribute('data-action', 'pause');

        const pauseIcon = document.createElement('span');
        pauseIcon.className = 'promen-text-content-block__tts-floating-icon pause';
        pauseIcon.setAttribute('aria-hidden', 'true');
        const pauseIconInner = document.createElement('i');
        pauseIconInner.className = 'fa-solid fa-pause';
        pauseIcon.appendChild(pauseIconInner);
        playPauseBtn.appendChild(pauseIcon);

        // Stop button
        const stopBtn = document.createElement('button');
        stopBtn.className = 'promen-text-content-block__tts-floating-button stop';
        stopBtn.setAttribute('type', 'button');
        stopBtn.setAttribute('aria-label', 'Stop');
        stopBtn.setAttribute('data-action', 'stop');

        const stopIcon = document.createElement('span');
        stopIcon.className = 'promen-text-content-block__tts-floating-icon stop';
        stopIcon.setAttribute('aria-hidden', 'true');
        const stopIconInner = document.createElement('i');
        stopIconInner.className = 'fa-solid fa-stop';
        stopIcon.appendChild(stopIconInner);
        stopBtn.appendChild(stopIcon);

        // Event listeners
        playPauseBtn.addEventListener('click', () => {
            if (isPaused) {
                resumeSpeaking();
            } else {
                pauseSpeaking();
            }
        });

        stopBtn.addEventListener('click', () => {
            stopSpeaking();
        });

        control.appendChild(playPauseBtn);
        control.appendChild(stopBtn);
        document.body.appendChild(control);

        floatingControl = control;
        return control;
    };

    /**
     * Show floating control
     */
    const showFloatingControl = () => {
        const control = createFloatingControl();
        control.classList.add('active');
        updateFloatingControlState();
    };

    /**
     * Hide floating control
     */
    const hideFloatingControl = () => {
        if (floatingControl) {
            floatingControl.classList.remove('active');
        }
    };

    /**
     * Update floating control button states
     */
    const updateFloatingControlState = () => {
        if (!floatingControl) {
            return;
        }

        const playPauseBtn = floatingControl.querySelector('[data-action="pause"]');
        const pauseIcon = playPauseBtn ? playPauseBtn.querySelector('.promen-text-content-block__tts-floating-icon') : null;
        const pauseIconInner = pauseIcon ? pauseIcon.querySelector(FLOATING_ICON_SELECTOR) : null;

        if (playPauseBtn && pauseIcon && pauseIconInner) {
            if (isPaused) {
                playPauseBtn.setAttribute('aria-label', 'Resume');
                playPauseBtn.classList.remove('pause');
                pauseIcon.classList.remove('pause');
                pauseIcon.classList.add('play');
                pauseIconInner.classList.remove('fa-pause');
                pauseIconInner.classList.add('fa-play');
            } else {
                playPauseBtn.setAttribute('aria-label', 'Pause');
                playPauseBtn.classList.add('pause');
                pauseIcon.classList.remove('play');
                pauseIcon.classList.add('pause');
                pauseIconInner.classList.remove('fa-play');
                pauseIconInner.classList.add('fa-pause');
            }
        }
    };

    /**
     * Pause speaking
     */
    const pauseSpeaking = () => {
        if ('speechSynthesis' in window && window.speechSynthesis.speaking) {
            window.speechSynthesis.pause();
            isPaused = true;

            // Highlighting interval will check isPaused flag and pause automatically
            updateFloatingControlState();

            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.announce('Text to speech paused');
            }
        }
    };

    /**
     * Resume speaking
     */
    const resumeSpeaking = () => {
        if ('speechSynthesis' in window && window.speechSynthesis.paused) {
            window.speechSynthesis.resume();
            isPaused = false;

            // Resume highlighting - the interval will continue automatically
            // The interval checks isPaused, so it will resume when isPaused becomes false

            updateFloatingControlState();

            if (typeof PromenAccessibility !== 'undefined') {
                PromenAccessibility.announce('Text to speech resumed');
            }
        }
    };

    const stopSpeaking = () => {
        if ('speechSynthesis' in window) {
            window.speechSynthesis.cancel();
            if (typeof PromenAccessibility !== 'undefined' && isPaused === false) {
                // Only announce if we were playing; if strictly cancelling, context matters.
                // But simplest is to announce stop if we were in a non-idle state.
                // Ideally we track if we were actually speaking.
                // For now, simple announce.
                // PromenAccessibility.announce('Text to speech stopped'); 
                // Kept silent to avoid spam on page unload or semantic stop? 
                // Let's add it for explicit user stop actions.
            }
        }

        isPaused = false;

        // Clear highlighting interval
        if (highlightInterval) {
            clearInterval(highlightInterval);
            highlightInterval = null;
        }

        // Remove all word highlights
        wordSpans.forEach(span => {
            span.classList.remove(HIGHLIGHT_CLASS);
        });
        wordSpans = [];
        currentWordIndex = -1;

        if (currentHighlightElement) {
            currentHighlightElement.classList.remove(HIGHLIGHT_CLASS);
            currentHighlightElement = null;
        }

        if (currentButton) {
            currentButton.dataset.ttsState = 'idle';
            const playLabel = currentButton.getAttribute('data-tts-label-play') || currentButton.textContent;
            const labelElement = currentButton.querySelector('.promen-text-content-block__tts-label');

            if (labelElement) {
                labelElement.textContent = playLabel;
            }

            setInlineButtonIconState(currentButton, 'play');
            currentButton = null;
        }

        currentUtterance = null;
        hideFloatingControl();
    };

    /**
     * Preprocess text for better TTS pronunciation
     * Adds pauses, normalizes text, and improves readability
     */
    const preprocessTextForTTS = (text) => {
        if (!text) {
            return '';
        }

        // Normalize whitespace first
        let processed = text.replace(/\s+/g, ' ').trim();

        // Ensure proper spacing around punctuation (but don't duplicate spaces)
        // Add space after punctuation if missing
        processed = processed.replace(/([.!?])([^\s])/g, '$1 $2');

        // Ensure space after commas, semicolons, colons
        processed = processed.replace(/([,;:])([^\s])/g, '$1 $2');

        // Ensure space before opening parentheses
        processed = processed.replace(/([^\s])(\()/g, '$1 $2');

        // Ensure space after closing parentheses
        processed = processed.replace(/(\))([^\s])/g, '$1 $2');

        // Normalize common abbreviations in Dutch (before punctuation handling)
        const abbreviations = {
            '\\bm\\.': 'meter',
            '\\bkm\\.': 'kilometer',
            '\\bdr\\.': 'dokter',
            '\\bmr\\.': 'meneer',
            '\\bmevr\\.': 'mevrouw',
            '\\bdhr\\.': 'de heer',
            '\\bbijv\\.': 'bijvoorbeeld',
            '\\betc\\.': 'et cetera',
            '\\be\\.d\\.': 'enzovoort',
            '\\bo\\.a\\.': 'onder andere',
            '\\bi\\.p\\.v\\.': 'in plaats van',
            '\\bt\\.a\\.v\\.': 'ter attentie van',
            '\\bt\\.m\\.v\\.': 'tot en met',
            '\\bv\\.a\\.': 'vanaf',
            '\\bt\\.o\\.v\\.': 'ten opzichte van',
        };

        Object.keys(abbreviations).forEach((abbr) => {
            const regex = new RegExp(abbr, 'gi');
            processed = processed.replace(regex, abbreviations[abbr]);
        });

        // Normalize number ranges for better pronunciation
        processed = processed.replace(/\b(\d{1,2})\s*-\s*(\d{1,2})\b/g, (match, p1, p2) => {
            return p1 + ' tot ' + p2;
        });

        // Normalize dates (e.g., "01-01-2024" -> "1 januari 2024" would be complex, so leave as is)
        // But ensure proper spacing
        processed = processed.replace(/(\d)\s*-\s*(\d)/g, '$1-$2');

        // Clean up multiple spaces that may have been created
        processed = processed.replace(/\s+/g, ' ').trim();

        return processed;
    };

    /**
     * Extract readable segments (paragraphs) from the collapsible content
     */
    const getReadableSegments = (textWrapper) => {
        if (!textWrapper) {
            return [];
        }

        const paragraphs = Array.from(textWrapper.querySelectorAll('p'));

        const segments = paragraphs
            .map((element) => {
                const rawText = (element.textContent || '').trim();
                const normalized = preprocessTextForTTS(rawText);

                return normalized ? {
                    element,
                    text: normalized,
                } :
                    null;
            })
            .filter(Boolean);

        if (segments.length > 0) {
            return segments;
        }

        // Fallback to entire text wrapper content if no paragraphs are present
        const fallbackText = preprocessTextForTTS(textWrapper.textContent || '');

        return fallbackText ? [{
            element: textWrapper,
            text: fallbackText,
        },] : [];
    };

    /**
     * Wrap text content in word spans for individual word highlighting
     */
    const wrapWordsInSpans = (element) => {
        if (!element) {
            return;
        }

        // Check if already wrapped
        if (element.querySelector('.' + WORD_SPAN_CLASS)) {
            return;
        }

        // Get all text nodes and wrap words
        const walker = document.createTreeWalker(
            element,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );

        const textNodes = [];
        let node;
        while (node = walker.nextNode()) {
            if (node.textContent.trim()) {
                textNodes.push(node);
            }
        }

        textNodes.forEach(textNode => {
            const parent = textNode.parentNode;
            const text = textNode.textContent;

            // Split text into words (including punctuation)
            const words = text.match(/\S+|\s+/g) || [];

            const fragment = document.createDocumentFragment();

            words.forEach(word => {
                if (word.trim()) {
                    // Word with punctuation
                    const span = document.createElement('span');
                    span.className = WORD_SPAN_CLASS;
                    span.textContent = word;
                    fragment.appendChild(span);
                } else {
                    // Whitespace
                    fragment.appendChild(document.createTextNode(word));
                }
            });

            parent.replaceChild(fragment, textNode);
        });
    };

    /**
     * Apply highlight to a specific word by index
     */
    const highlightWord = (index) => {
        // Remove previous highlight
        if (currentWordIndex >= 0 && wordSpans[currentWordIndex]) {
            wordSpans[currentWordIndex].classList.remove(HIGHLIGHT_CLASS);
        }

        // Apply new highlight
        if (index >= 0 && index < wordSpans.length && wordSpans[index]) {
            currentWordIndex = index;
            const span = wordSpans[index];
            span.classList.add(HIGHLIGHT_CLASS);

            // Scroll into view if needed
            span.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'nearest'
            });
        }
    };

    /**
     * Prepare element for word-by-word highlighting
     */
    const prepareElementForWordHighlighting = (element) => {
        if (!element) {
            return;
        }

        // Wrap words in spans
        wrapWordsInSpans(element);

        // Collect all word spans
        wordSpans = Array.from(element.querySelectorAll('.' + WORD_SPAN_CLASS));
        currentWordIndex = -1;
    };

    /**
     * Get optimal voice settings for Dutch
     */
    const getOptimalVoice = () => {
        if (!('speechSynthesis' in window)) {
            return null;
        }

        const voices = window.speechSynthesis.getVoices();

        // Prefer Dutch voices
        const dutchVoices = voices.filter(voice =>
            voice.lang.startsWith('nl') ||
            voice.lang === 'nl-NL' ||
            voice.lang === 'nl-BE'
        );

        if (dutchVoices.length > 0) {
            // Prefer female voices (often sound more natural)
            const femaleVoice = dutchVoices.find(voice =>
                voice.name.toLowerCase().includes('female') ||
                voice.name.toLowerCase().includes('zira') ||
                voice.name.toLowerCase().includes('helen')
            );

            return femaleVoice || dutchVoices[0];
        }

        // Fallback to any available voice
        return voices.length > 0 ? voices[0] : null;
    };

    /**
     * Speak each segment sequentially with word-by-word highlighting
     */
    const speakSegments = (segments, baseSettings, button, index = 0) => {
        if (!currentButton || currentButton !== button) {
            return;
        }

        if (index >= segments.length) {
            stopSpeaking();
            return;
        }

        const { element, text } = segments[index];

        if (!text) {
            speakSegments(segments, baseSettings, button, index + 1);
            return;
        }

        // Prepare element for word-by-word highlighting
        prepareElementForWordHighlighting(element);

        if (wordSpans.length === 0) {
            // No words to highlight, continue to next segment
            speakSegments(segments, baseSettings, button, index + 1);
            return;
        }

        // Calculate estimated duration per word
        // Average speaking rate: ~150 words per minute = ~2.5 words per second
        // With rate 0.95, that's ~2.38 words per second = ~420ms per word
        const wordsPerSecond = 2.5 * baseSettings.rate;
        const msPerWord = 1000 / wordsPerSecond;

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = baseSettings.lang;
        utterance.rate = baseSettings.rate;
        utterance.pitch = baseSettings.pitch;
        utterance.volume = baseSettings.volume;

        if (baseSettings.voice) {
            utterance.voice = baseSettings.voice;
        }

        currentUtterance = utterance;

        // Track highlighting state
        let currentHighlightWordIndex = 0;
        let boundaryWordIndex = 0;

        // Use boundary events for more accurate word tracking
        utterance.onboundary = (event) => {
            if (event.name === 'word') {
                // Calculate word index based on character position
                const charIndex = event.charIndex;
                const wordCount = wordSpans.length;
                const textLength = text.length;

                // Estimate which word is being spoken
                const estimatedIndex = Math.min(
                    Math.floor((charIndex / Math.max(textLength, 1)) * wordCount),
                    wordCount - 1
                );

                boundaryWordIndex = estimatedIndex;
            }
        };

        // Start sequential highlighting with timer
        const startHighlighting = () => {
            // Clear any existing interval
            if (highlightInterval) {
                clearInterval(highlightInterval);
            }

            // Start from first word
            currentHighlightWordIndex = 0;
            highlightWord(0);

            // Update highlight at regular intervals
            highlightInterval = setInterval(() => {
                // Don't update if paused
                if (isPaused) {
                    return;
                }

                // Use boundary index if available, otherwise increment
                if (boundaryWordIndex > currentHighlightWordIndex) {
                    currentHighlightWordIndex = boundaryWordIndex;
                } else {
                    currentHighlightWordIndex++;
                }

                if (currentHighlightWordIndex >= wordSpans.length) {
                    clearInterval(highlightInterval);
                    highlightInterval = null;
                } else {
                    highlightWord(currentHighlightWordIndex);
                    // Update global currentWordIndex for resume functionality
                    currentWordIndex = currentHighlightWordIndex;
                }
            }, msPerWord);
        };

        utterance.onstart = () => {
            startHighlighting();
        };

        utterance.onend = () => {
            // Clear interval
            if (highlightInterval) {
                clearInterval(highlightInterval);
                highlightInterval = null;
            }

            // Remove all highlights from this segment
            wordSpans.forEach(span => {
                span.classList.remove(HIGHLIGHT_CLASS);
            });
            wordSpans = [];
            currentWordIndex = -1;
            boundaryWordIndex = 0;

            // Continue with the next paragraph after a short pause
            setTimeout(() => {
                speakSegments(segments, baseSettings, button, index + 1);
            }, 150);
        };

        utterance.onerror = () => {
            if (highlightInterval) {
                clearInterval(highlightInterval);
                highlightInterval = null;
            }
            stopSpeaking();
        };

        window.speechSynthesis.speak(utterance);
    };

    const handleSpeak = (button) => {
        if (!('speechSynthesis' in window)) {
            button.disabled = true;
            button.setAttribute('aria-disabled', 'true');
            return;
        }

        if (button.dataset.ttsState === 'playing') {
            stopSpeaking();
            return;
        }

        stopSpeaking();

        const collapsible = button.closest('[data-promen-collapsible]');
        const textWrapper = collapsible ? collapsible.querySelector('.promen-text-content-block__collapsible-text') : null;

        // Extract segments to read
        const segments = getReadableSegments(textWrapper);

        if (!segments.length) {
            // Fall back to button text if no segments are available
            const fallbackText = preprocessTextForTTS(button.getAttribute('data-tts-text'));
            if (!fallbackText) {
                return;
            }

            segments.push({
                element: textWrapper || button.closest('.promen-text-content-block__collapsible-panel') || button,
                text: fallbackText,
            });
        }

        // Get optimal voice
        const voice = getOptimalVoice();

        // Prepare shared settings for all segments
        const baseSettings = {
            lang: document.documentElement.lang || 'nl-NL',
            rate: 0.95,
            pitch: 1.0,
            volume: 1,
            voice,
        };

        currentButton = button;

        // Update UI state immediately so users get feedback
        button.dataset.ttsState = 'playing';
        const stopLabel = button.getAttribute('data-tts-label-stop') || 'Stop';
        const labelElement = button.querySelector('.promen-text-content-block__tts-label');

        if (labelElement) {
            labelElement.textContent = stopLabel;
        }

        setInlineButtonIconState(button, 'stop');

        // Show floating control
        showFloatingControl();

        speakSegments(segments, baseSettings, button);
    };

    const toggleCollapsible = (trigger, panel) => {
        if (!trigger || !panel) {
            return;
        }

        const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
        const newState = !isExpanded;

        trigger.setAttribute('aria-expanded', newState ? 'true' : 'false');
        panel.setAttribute('aria-hidden', newState ? 'false' : 'true');

        if (newState) {
            panel.removeAttribute('hidden');
        } else {
            panel.setAttribute('hidden', 'hidden');
            const playingButton = panel.querySelector('.promen-text-content-block__tts[data-tts-state="playing"]');

            if (playingButton) {
                stopSpeaking();
            }
        }
    };

    const initCollapsibles = (scope) => {
        const root = scope || document;
        const collapsibles = root.querySelectorAll('[data-promen-collapsible]');

        if (!collapsibles.length) {
            return;
        }

        collapsibles.forEach((container) => {
            const trigger = container.querySelector('.promen-text-content-block__collapsible-trigger');
            const panel = container.querySelector('.promen-text-content-block__collapsible-panel');

            if (trigger && panel) {
                // Use once option to prevent duplicate listeners, or check if already initialized
                if (!trigger.dataset.initialized) {
                    trigger.dataset.initialized = 'true';
                    trigger.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();
                        toggleCollapsible(trigger, panel);
                    });
                }

                if (trigger.getAttribute('aria-expanded') === 'true') {
                    panel.removeAttribute('hidden');
                    panel.setAttribute('aria-hidden', 'false');
                }
            }

            const ttsButton = container.querySelector('.promen-text-content-block__tts');

            if (ttsButton) {
                ttsButton.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    handleSpeak(ttsButton);
                });
            }
        });
    };

    const onReady = (scope) => {
        initCollapsibles(scope);

        // Add reduced motion support
        if (typeof PromenAccessibility !== 'undefined') {
            const root = scope || document;
            const blocks = root.querySelectorAll('.promen-text-content-block');
            blocks.forEach(block => {
                PromenAccessibility.setupReducedMotion(block);
                PromenAccessibility.setupSkipLink(block, 'Sla over tekstblok');
            });
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', () => onReady(document));
    } else {
        onReady(document);
    }

    const initElementorHooks = () => {
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction('frontend/element_ready/promen_text_content_block.default', ($scope) => {
                if ($scope && $scope.length) {
                    onReady($scope[0]);
                }
            });
        }
    };

    if (window.elementorFrontend && window.elementorFrontend.hooks) {
        initElementorHooks();
    } else {
        window.addEventListener('elementor/frontend/init', initElementorHooks);
    }

    window.addEventListener('beforeunload', stopSpeaking);
})(window, document);