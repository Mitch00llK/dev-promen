/**
 * Panel Handler
 * 
 * Manages panel open/close states and interactions.
 * 
 * @package Promen_Elementor_Widgets
 */

import { $, trapFocus, announce } from '../utilities/dom-helper.js';

/**
 * Panel Handler Class
 */
class PanelHandler {
    constructor() {
        this.widget = null;
        this.toggle = null;
        this.panel = null;
        this.closeBtn = null;
        this.isOpen = false;
        this.focusTrapCleanup = null;
        this.previousFocus = null;
    }

    /**
     * Initialize panel handler
     */
    init() {
        this.widget = $('#a11y-widget');
        this.toggle = $('#a11y-widget-toggle');
        this.panel = $('#a11y-widget-panel');
        this.closeBtn = this.panel?.querySelector('.a11y-widget__close');

        if (!this.widget || !this.toggle || !this.panel) {
            console.warn('A11y Widget: Required elements not found');
            return;
        }

        this.bindEvents();
    }

    /**
     * Bind event listeners
     */
    bindEvents() {
        // Toggle button click
        this.toggle.addEventListener('click', () => this.togglePanel());

        // Close button click
        this.closeBtn?.addEventListener('click', () => this.closePanel());

        // Click outside to close
        document.addEventListener('click', (e) => {
            if (this.isOpen && !this.widget.contains(e.target)) {
                this.closePanel();
            }
        });

        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                e.preventDefault();
                this.closePanel();
            }
        });
    }

    /**
     * Toggle panel open/close
     */
    togglePanel() {
        if (this.isOpen) {
            this.closePanel();
        } else {
            this.openPanel();
        }
    }

    /**
     * Open panel
     */
    openPanel() {
        if (this.isOpen) return;

        // Store current focus
        this.previousFocus = document.activeElement;

        // Show panel
        this.panel.hidden = false;
        this.panel.setAttribute('data-animating', 'in');

        // Update toggle state
        this.toggle.setAttribute('aria-expanded', 'true');
        this.widget.classList.add('a11y-widget--open');

        // Setup focus trap
        this.focusTrapCleanup = trapFocus(this.panel);

        this.isOpen = true;

        // Clear animation attribute after animation
        setTimeout(() => {
            this.panel.removeAttribute('data-animating');
        }, 250);

        announce('Accessibility menu opened');
    }

    /**
     * Close panel
     */
    closePanel() {
        if (!this.isOpen) return;

        // Animate out
        this.panel.setAttribute('data-animating', 'out');

        // Update toggle state
        this.toggle.setAttribute('aria-expanded', 'false');
        this.widget.classList.remove('a11y-widget--open');

        // Remove focus trap
        if (this.focusTrapCleanup) {
            this.focusTrapCleanup();
            this.focusTrapCleanup = null;
        }

        // Hide after animation
        setTimeout(() => {
            this.panel.hidden = true;
            this.panel.removeAttribute('data-animating');
        }, 150);

        // Restore focus
        this.previousFocus?.focus();

        this.isOpen = false;

        announce('Accessibility menu closed');
    }

    /**
     * Check if panel is open
     * @returns {boolean} Open state
     */
    isPanelOpen() {
        return this.isOpen;
    }
}

export const panelHandler = new PanelHandler();
