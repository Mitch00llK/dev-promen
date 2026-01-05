<?php
/**
 * Accessibility Widget Panel Template
 * 
 * Renders the accessibility widget toggle button and control panel.
 * 
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
?>

<!-- Accessibility Widget Container -->
<div id="a11y-widget" 
     class="a11y-widget" 
     role="region" 
     aria-label="<?php esc_attr_e('Accessibility Options', 'promen-elementor-widgets'); ?>">
    
    <!-- Toggle Button -->
    <button type="button" 
            id="a11y-widget-toggle" 
            class="a11y-widget__toggle" 
            aria-expanded="false" 
            aria-controls="a11y-widget-panel"
            aria-label="<?php esc_attr_e('Open accessibility menu', 'promen-elementor-widgets'); ?>">
        <span class="a11y-widget__toggle-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9H15V22H13V16H11V22H9V9H3V7H21V9Z"/>
            </svg>
        </span>
        <span class="screen-reader-text"><?php esc_html_e('Open accessibility menu', 'promen-elementor-widgets'); ?></span>
    </button>

    <!-- Control Panel -->
    <div id="a11y-widget-panel" 
         class="a11y-widget__panel" 
         role="dialog" 
         aria-modal="true"
         aria-labelledby="a11y-widget-title"
         hidden>
        
        <!-- Panel Header -->
        <div class="a11y-widget__header">
            <h2 id="a11y-widget-title" class="a11y-widget__title">
                <?php esc_html_e('Accessibility Options', 'promen-elementor-widgets'); ?>
            </h2>
            <button type="button" 
                    class="a11y-widget__close" 
                    aria-label="<?php esc_attr_e('Close accessibility menu', 'promen-elementor-widgets'); ?>">
                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true">
                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                </svg>
            </button>
        </div>

        <!-- Panel Content -->
        <div class="a11y-widget__content">
            
            <!-- Profile Presets -->
            <section class="a11y-widget__section a11y-widget__section--profiles">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Accessibility Profiles', 'promen-elementor-widgets'); ?></h3>
                <div class="a11y-widget__profiles">
                    <button type="button" class="a11y-widget__profile" data-profile="vision-impaired">
                        <span class="a11y-widget__profile-icon" aria-hidden="true">👁️</span>
                        <span class="a11y-widget__profile-label"><?php esc_html_e('Vision Impaired', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__profile" data-profile="cognitive">
                        <span class="a11y-widget__profile-icon" aria-hidden="true">🧠</span>
                        <span class="a11y-widget__profile-label"><?php esc_html_e('Cognitive', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__profile" data-profile="seizure-safe">
                        <span class="a11y-widget__profile-icon" aria-hidden="true">⚡</span>
                        <span class="a11y-widget__profile-label"><?php esc_html_e('Seizure Safe', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__profile" data-profile="adhd-friendly">
                        <span class="a11y-widget__profile-icon" aria-hidden="true">🎯</span>
                        <span class="a11y-widget__profile-label"><?php esc_html_e('ADHD Friendly', 'promen-elementor-widgets'); ?></span>
                    </button>
                </div>
            </section>

            <!-- Content Scaling -->
            <section class="a11y-widget__section">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Content Scaling', 'promen-elementor-widgets'); ?></h3>
                <div class="a11y-widget__controls">
                    <div class="a11y-widget__control a11y-widget__control--slider">
                        <label for="a11y-text-size"><?php esc_html_e('Text Size', 'promen-elementor-widgets'); ?></label>
                        <div class="a11y-widget__slider-wrap">
                            <input type="range" id="a11y-text-size" min="100" max="200" step="10" value="100" 
                                   aria-valuemin="100" aria-valuemax="200" aria-valuenow="100">
                            <span class="a11y-widget__slider-value">100%</span>
                        </div>
                    </div>
                    <div class="a11y-widget__control a11y-widget__control--slider">
                        <label for="a11y-zoom"><?php esc_html_e('Page Zoom', 'promen-elementor-widgets'); ?></label>
                        <div class="a11y-widget__slider-wrap">
                            <input type="range" id="a11y-zoom" min="100" max="150" step="10" value="100"
                                   aria-valuemin="100" aria-valuemax="150" aria-valuenow="100">
                            <span class="a11y-widget__slider-value">100%</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Color & Contrast -->
            <section class="a11y-widget__section">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Color & Contrast', 'promen-elementor-widgets'); ?></h3>
                <div class="a11y-widget__controls a11y-widget__controls--grid">
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="high-contrast">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">◐</span>
                        <span><?php esc_html_e('High Contrast', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="dark-contrast">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🌙</span>
                        <span><?php esc_html_e('Dark Contrast', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="light-contrast">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">☀️</span>
                        <span><?php esc_html_e('Light Contrast', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="monochrome">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">◑</span>
                        <span><?php esc_html_e('Monochrome', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="invert-colors">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🔄</span>
                        <span><?php esc_html_e('Invert Colors', 'promen-elementor-widgets'); ?></span>
                    </button>
                </div>
                <div class="a11y-widget__control a11y-widget__control--slider">
                    <label for="a11y-saturation"><?php esc_html_e('Saturation', 'promen-elementor-widgets'); ?></label>
                    <div class="a11y-widget__slider-wrap">
                        <input type="range" id="a11y-saturation" min="0" max="200" step="10" value="100"
                               aria-valuemin="0" aria-valuemax="200" aria-valuenow="100">
                        <span class="a11y-widget__slider-value">100%</span>
                    </div>
                </div>
            </section>

            <!-- Text Adjustments -->
            <section class="a11y-widget__section">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Text Adjustments', 'promen-elementor-widgets'); ?></h3>
                <div class="a11y-widget__controls">
                    <div class="a11y-widget__control a11y-widget__control--slider">
                        <label for="a11y-line-height"><?php esc_html_e('Line Height', 'promen-elementor-widgets'); ?></label>
                        <div class="a11y-widget__slider-wrap">
                            <input type="range" id="a11y-line-height" min="1" max="2.5" step="0.1" value="1.5"
                                   aria-valuemin="1" aria-valuemax="2.5" aria-valuenow="1.5">
                            <span class="a11y-widget__slider-value">1.5</span>
                        </div>
                    </div>
                    <div class="a11y-widget__control a11y-widget__control--slider">
                        <label for="a11y-letter-spacing"><?php esc_html_e('Letter Spacing', 'promen-elementor-widgets'); ?></label>
                        <div class="a11y-widget__slider-wrap">
                            <input type="range" id="a11y-letter-spacing" min="0" max="10" step="1" value="0"
                                   aria-valuemin="0" aria-valuemax="10" aria-valuenow="0">
                            <span class="a11y-widget__slider-value">0px</span>
                        </div>
                    </div>
                    <div class="a11y-widget__control a11y-widget__control--slider">
                        <label for="a11y-word-spacing"><?php esc_html_e('Word Spacing', 'promen-elementor-widgets'); ?></label>
                        <div class="a11y-widget__slider-wrap">
                            <input type="range" id="a11y-word-spacing" min="0" max="20" step="2" value="0"
                                   aria-valuemin="0" aria-valuemax="20" aria-valuenow="0">
                            <span class="a11y-widget__slider-value">0px</span>
                        </div>
                    </div>
                    <button type="button" class="a11y-widget__toggle-btn a11y-widget__toggle-btn--wide" data-setting="dyslexia-font">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">Aa</span>
                        <span><?php esc_html_e('Dyslexia-Friendly Font', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <div class="a11y-widget__control a11y-widget__control--buttons">
                        <span class="a11y-widget__control-label"><?php esc_html_e('Text Alignment', 'promen-elementor-widgets'); ?></span>
                        <div class="a11y-widget__button-group" role="group" aria-label="<?php esc_attr_e('Text alignment', 'promen-elementor-widgets'); ?>">
                            <button type="button" class="a11y-widget__align-btn" data-align="left" aria-pressed="false">
                                <span aria-hidden="true">≡</span>
                                <span class="screen-reader-text"><?php esc_html_e('Left', 'promen-elementor-widgets'); ?></span>
                            </button>
                            <button type="button" class="a11y-widget__align-btn" data-align="center" aria-pressed="false">
                                <span aria-hidden="true">≡</span>
                                <span class="screen-reader-text"><?php esc_html_e('Center', 'promen-elementor-widgets'); ?></span>
                            </button>
                            <button type="button" class="a11y-widget__align-btn" data-align="right" aria-pressed="false">
                                <span aria-hidden="true">≡</span>
                                <span class="screen-reader-text"><?php esc_html_e('Right', 'promen-elementor-widgets'); ?></span>
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Navigation & Interaction -->
            <section class="a11y-widget__section">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Navigation & Interaction', 'promen-elementor-widgets'); ?></h3>
                <div class="a11y-widget__controls a11y-widget__controls--grid">
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="focus-indicators">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🎯</span>
                        <span><?php esc_html_e('Focus Indicators', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="large-cursor">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🖱️</span>
                        <span><?php esc_html_e('Large Cursor', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="reading-guide">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">📏</span>
                        <span><?php esc_html_e('Reading Guide', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="reading-mask">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🔲</span>
                        <span><?php esc_html_e('Reading Mask', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="highlight-links">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🔗</span>
                        <span><?php esc_html_e('Highlight Links', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="highlight-headers">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">H</span>
                        <span><?php esc_html_e('Highlight Headers', 'promen-elementor-widgets'); ?></span>
                    </button>
                </div>
            </section>

            <!-- Content Control -->
            <section class="a11y-widget__section">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Content Control', 'promen-elementor-widgets'); ?></h3>
                <div class="a11y-widget__controls a11y-widget__controls--grid">
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="stop-animations">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">⏹️</span>
                        <span><?php esc_html_e('Stop Animations', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="hide-images">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🖼️</span>
                        <span><?php esc_html_e('Hide Images', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="mute-sounds">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🔇</span>
                        <span><?php esc_html_e('Mute Sounds', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__toggle-btn" data-setting="text-to-speech">
                        <span class="a11y-widget__toggle-icon" aria-hidden="true">🔊</span>
                        <span><?php esc_html_e('Text to Speech', 'promen-elementor-widgets'); ?></span>
                    </button>
                </div>
            </section>

        </div>

        <!-- Panel Footer -->
        <div class="a11y-widget__footer">
            <button type="button" class="a11y-widget__reset" id="a11y-reset-all">
                <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16" aria-hidden="true">
                    <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                </svg>
                <?php esc_html_e('Reset All', 'promen-elementor-widgets'); ?>
            </button>
        </div>

    </div>

    <!-- ARIA Live Region for Announcements -->
    <div id="a11y-announcements" class="screen-reader-text" aria-live="polite" aria-atomic="true"></div>

    <!-- Reading Guide Overlay -->
    <div id="a11y-reading-guide" class="a11y-reading-guide" aria-hidden="true"></div>

    <!-- Reading Mask Overlay -->
    <div id="a11y-reading-mask" class="a11y-reading-mask" aria-hidden="true">
        <div class="a11y-reading-mask__top"></div>
        <div class="a11y-reading-mask__bottom"></div>
    </div>

</div>
