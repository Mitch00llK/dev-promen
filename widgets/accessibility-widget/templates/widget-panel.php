<?php
/**
 * Accessibility Widget Panel Template (SaaS Revamp)
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
     aria-label="<?php esc_attr_e('Toegankelijkheidsopties', 'promen-elementor-widgets'); ?>">
    
    <!-- Toggle Button -->
    <button type="button" 
            id="a11y-widget-toggle" 
            class="a11y-widget__toggle" 
            aria-expanded="false" 
            aria-controls="a11y-widget-panel"
            aria-label="<?php esc_attr_e('Open toegankelijkheidsmenu', 'promen-elementor-widgets'); ?>">
        <span class="a11y-widget__toggle-icon" aria-hidden="true">
            <svg viewBox="0 0 24 24" fill="currentColor" width="28" height="28">
                <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9H15V22H13V16H11V22H9V9H3V7H21V9Z"/>
            </svg>
        </span>
        <span class="screen-reader-text"><?php esc_html_e('Open toegankelijkheidsmenu', 'promen-elementor-widgets'); ?></span>
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
            <div class="a11y-widget__header-main">
                <h2 id="a11y-widget-title" class="a11y-widget__title">
                    <?php esc_html_e('Toegankelijkheid', 'promen-elementor-widgets'); ?>
                </h2>
                <div class="a11y-widget__header-actions">
                    <button type="button" class="a11y-widget__reset" id="a11y-reset-all" aria-label="<?php esc_attr_e('Instellingen resetten', 'promen-elementor-widgets'); ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </button>
                    <button type="button" class="a11y-widget__close" aria-label="<?php esc_attr_e('Sluit menu', 'promen-elementor-widgets'); ?>">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Panel Content -->
        <div class="a11y-widget__content">
            
            <!-- Quick Profiles -->
            <section class="a11y-widget__section a11y-widget__section--profiles">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Profielen', 'promen-elementor-widgets'); ?></h3>
                <div class="a11y-widget__profiles">
                    <button type="button" class="a11y-widget__profile" data-profile="vision-impaired">
                        <span class="a11y-widget__profile-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                        <span class="a11y-widget__profile-label"><?php esc_html_e('Visueel', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__profile" data-profile="cognitive">
                        <span class="a11y-widget__profile-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3M3.34 16.66l.707-.707M6 12a6 6 0 1112 0 6 6 0 01-12 0z" />
                            </svg>
                        </span>
                        <span class="a11y-widget__profile-label"><?php esc_html_e('Cognitief', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__profile" data-profile="seizure-safe">
                        <span class="a11y-widget__profile-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </span>
                        <span class="a11y-widget__profile-label"><?php esc_html_e('Epilepsie', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__profile" data-profile="adhd-friendly">
                        <span class="a11y-widget__profile-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="24" height="24">
                                <circle cx="12" cy="12" r="10" />
                                <circle cx="12" cy="12" r="6" />
                                <circle cx="12" cy="12" r="2" />
                            </svg>
                        </span>
                        <span class="a11y-widget__profile-label"><?php esc_html_e('ADHD', 'promen-elementor-widgets'); ?></span>
                    </button>
                </div>
            </section>

            <!-- Display Settings -->
            <section class="a11y-widget__section">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Weergave', 'promen-elementor-widgets'); ?></h3>
                
                <!-- Scaling Sliders -->
                <div class="a11y-widget__control-group">
                    <div class="a11y-widget__slider-row">
                        <div class="a11y-widget__slider-label">
                            <span aria-hidden="true" class="a11y-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7" />
                                </svg>
                            </span>
                            <label for="a11y-text-size"><?php esc_html_e('Tekstgrootte', 'promen-elementor-widgets'); ?></label>
                        </div>
                        <div class="a11y-widget__slider-input">
                             <input type="range" id="a11y-text-size" min="100" max="200" step="10" value="100" 
                                   aria-valuemin="100" aria-valuemax="200" aria-valuenow="100">
                            <span class="a11y-widget__slider-value">100%</span>
                        </div>
                    </div>
                    
                    <div class="a11y-widget__slider-row">
                        <div class="a11y-widget__slider-label">
                            <span aria-hidden="true" class="a11y-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            <label for="a11y-zoom"><?php esc_html_e('Zoom', 'promen-elementor-widgets'); ?></label>
                        </div>
                        <div class="a11y-widget__slider-input">
                            <input type="range" id="a11y-zoom" min="100" max="150" step="10" value="100"
                                   aria-valuemin="100" aria-valuemax="150" aria-valuenow="100">
                            <span class="a11y-widget__slider-value">100%</span>
                        </div>
                    </div>
                </div>

                <!-- Contrast Grid -->
                <div class="a11y-widget__contrast-grid">
                     <button type="button" class="a11y-widget__contrast-btn" data-setting="high-contrast" aria-label="<?php esc_attr_e('Hoog contrast', 'promen-elementor-widgets'); ?>">
                        <span class="a11y-swatch a11y-swatch--high"></span>
                        <span class="a11y-label"><?php esc_html_e('Hoog', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__contrast-btn" data-setting="dark-contrast" aria-label="<?php esc_attr_e('Donker contrast', 'promen-elementor-widgets'); ?>">
                        <span class="a11y-swatch a11y-swatch--dark"></span>
                        <span class="a11y-label"><?php esc_html_e('Donker', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__contrast-btn" data-setting="light-contrast" aria-label="<?php esc_attr_e('Licht contrast', 'promen-elementor-widgets'); ?>">
                        <span class="a11y-swatch a11y-swatch--light"></span>
                        <span class="a11y-label"><?php esc_html_e('Licht', 'promen-elementor-widgets'); ?></span>
                    </button>
                    <button type="button" class="a11y-widget__contrast-btn" data-setting="invert-colors" aria-label="<?php esc_attr_e('Kleuren omkeren', 'promen-elementor-widgets'); ?>">
                        <span class="a11y-swatch a11y-swatch--invert"></span>
                        <span class="a11y-label"><?php esc_html_e('Omkeren', 'promen-elementor-widgets'); ?></span>
                    </button>
                </div>
            </section>

            <!-- Content Adjustments -->
            <section class="a11y-widget__section">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Inhoud', 'promen-elementor-widgets'); ?></h3>
                
                <div class="a11y-widget__switch-list">
                    <!-- Dyslexia Font -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Leesbaar lettertype', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="dyslexia-font">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>

                    <!-- Highlight Links -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Links markeren', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="highlight-links">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>

                    <!-- Highlight Headers -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Koppen markeren', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="highlight-headers">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>
                </div>
            </section>

            <!-- Interaction -->
            <section class="a11y-widget__section">
                <h3 class="a11y-widget__section-title"><?php esc_html_e('Interactie', 'promen-elementor-widgets'); ?></h3>
                
                <div class="a11y-widget__switch-list">
                    <!-- Large Cursor -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Grote cursor', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="large-cursor">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>

                    <!-- Reading Guide -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Leeshulp', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="reading-guide">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>

                    <!-- Reading Mask -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Leesmasker', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="reading-mask">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>
                    
                    <!-- Text to Speech -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Pagina voorlezen', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="text-to-speech">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>
                </div>
            </section>
            
            <!-- More Settings (Collapsed) -->
            <details class="a11y-widget__details">
                <summary class="a11y-widget__details-summary">
                    <?php esc_html_e('Meer opties', 'promen-elementor-widgets'); ?>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" width="16" height="16" stroke-width="2"><path d="M6 9l6 6 6-6"/></svg>
                </summary>
                
                <div class="a11y-widget__switch-list">
                     <!-- Stop Animations -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Animaties stoppen', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="stop-animations">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>

                    <!-- Hide Images -->
                    <div class="a11y-widget__switch-row">
                        <div class="a11y-widget__switch-info">
                            <span class="a11y-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>
                            <span class="a11y-label"><?php esc_html_e('Afbeeldingen verbergen', 'promen-elementor-widgets'); ?></span>
                        </div>
                        <button type="button" class="a11y-widget__switch" role="switch" aria-checked="false" data-setting="hide-images">
                            <span class="a11y-widget__switch-knob"></span>
                        </button>
                    </div>
                    
                    <div class="a11y-widget__control a11y-widget__control--slider">
                        <label for="a11y-line-height"><?php esc_html_e('Regelhoogte', 'promen-elementor-widgets'); ?></label>
                        <div class="a11y-widget__slider-wrap">
                            <input type="range" id="a11y-line-height" min="1" max="2.5" step="0.1" value="1.5"
                                   aria-valuemin="1" aria-valuemax="2.5" aria-valuenow="1.5">
                            <span class="a11y-widget__slider-value">1.5</span>
                        </div>
                    </div>
                    
                    <div class="a11y-widget__control a11y-widget__control--slider">
                        <label for="a11y-letter-spacing"><?php esc_html_e('Letterafstand', 'promen-elementor-widgets'); ?></label>
                        <div class="a11y-widget__slider-wrap">
                            <input type="range" id="a11y-letter-spacing" min="0" max="10" step="1" value="0"
                                   aria-valuemin="0" aria-valuemax="10" aria-valuenow="0">
                            <span class="a11y-widget__slider-value">0</span>
                        </div>
                    </div>
                </div>
            </details>

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
