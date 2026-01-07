/**
 * Contact Info Card Widget - Accessibility Entry Point
 */

(function ($) {
    'use strict';

    // Instantiate Handler
    // The class PromenContactInfoCardHandler should be loaded before this file
    if (typeof PromenContactInfoCardHandler !== 'undefined') {
        new PromenContactInfoCardHandler();
    } else {
        console.warn('PromenContactInfoCardHandler not found. Accessibility features may not work.');
    }

})(jQuery);