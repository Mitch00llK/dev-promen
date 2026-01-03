/**
 * Promen Elementor Widgets - Accessible Error Handling
 * Provides WCAG 2.1/2.2 compliant error management
 */

(function($) {
    'use strict';

    // Error handling object
    const PromenErrorHandler = {
        
        // Initialize error handling
        init: function() {
            this.bindEvents();
            this.setupLiveRegions();
            this.handleExistingErrors();
        },

        // Bind event handlers
        bindEvents: function() {
            // Handle error dismissal
            $(document).on('click', '.error-dismiss, .success-dismiss', this.dismissMessage);
            
            // Handle form submissions
            $(document).on('submit', '.promen-widget form', this.handleFormSubmission);
            
            // Handle AJAX errors
            $(document).ajaxError(this.handleAjaxError);
            
            // Handle keyboard events for error dismissal
            $(document).on('keydown', '.promen-widget-error, .promen-widget-success', this.handleKeyboardDismissal);
            
            // Focus management for dynamically added errors
            $(document).on('DOMNodeInserted', '.promen-widget-error[role="alert"]', this.focusNewError);
        },

        // Setup ARIA live regions
        setupLiveRegions: function() {
            if (!$('#promen-error-live-region').length) {
                $('body').append('<div id="promen-error-live-region" aria-live="assertive" aria-atomic="true" class="screen-reader-text"></div>');
            }
            
            if (!$('#promen-success-live-region').length) {
                $('body').append('<div id="promen-success-live-region" aria-live="polite" aria-atomic="true" class="screen-reader-text"></div>');
            }
        },

        // Handle existing errors on page load
        handleExistingErrors: function() {
            $('.promen-widget-error[role="alert"]').each(function() {
                const $error = $(this);
                // Announce existing errors to screen readers
                setTimeout(function() {
                    $('#promen-error-live-region').text($error.find('.error-message').text());
                }, 100);
            });
        },

        // Display accessible error message
        displayError: function(message, options) {
            options = $.extend({
                type: 'error',
                container: 'body',
                widgetId: '',
                dismissible: true,
                focus: true,
                announce: true
            }, options);

            const errorId = 'promen-error-' + this.generateUniqueId();
            const classes = ['promen-widget-error', 'promen-form-' + options.type];
            
            if (options.widgetId) {
                classes.push('widget-' + options.widgetId + '-error');
            }

            const errorHtml = `
                <div id="${errorId}" class="${classes.join(' ')}" role="alert" aria-live="assertive" tabindex="-1">
                    <span class="error-icon" aria-hidden="true">⚠</span>
                    <span class="error-message">${this.escapeHtml(message)}</span>
                    ${options.dismissible ? `
                        <button type="button" class="error-dismiss" aria-label="${promenErrors.aria_labels.close_error}">
                            <span aria-hidden="true">×</span>
                        </button>
                    ` : ''}
                </div>
            `;

            // Remove existing errors in the same container
            $(options.container).find('.promen-widget-error').remove();
            
            // Add new error
            $(options.container).prepend(errorHtml);
            
            const $errorElement = $('#' + errorId);

            // Focus on error if requested
            if (options.focus) {
                this.focusError($errorElement);
            }

            // Announce to screen readers
            if (options.announce) {
                this.announceError(message);
            }

            // Auto-dismiss after 10 seconds for non-critical errors
            if (options.dismissible && options.type !== 'validation') {
                setTimeout(function() {
                    $errorElement.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 10000);
            }

            return $errorElement;
        },

        // Display accessible success message
        displaySuccess: function(message, options) {
            options = $.extend({
                container: 'body',
                widgetId: '',
                dismissible: true,
                focus: false,
                announce: true
            }, options);

            const successId = 'promen-success-' + this.generateUniqueId();
            const classes = ['promen-widget-success', 'promen-form-success'];
            
            if (options.widgetId) {
                classes.push('widget-' + options.widgetId + '-success');
            }

            const successHtml = `
                <div id="${successId}" class="${classes.join(' ')}" role="status" aria-live="polite" tabindex="-1">
                    <span class="success-icon" aria-hidden="true">✓</span>
                    <span class="success-message">${this.escapeHtml(message)}</span>
                    ${options.dismissible ? `
                        <button type="button" class="success-dismiss" aria-label="${promenErrors.aria_labels.close_error}">
                            <span aria-hidden="true">×</span>
                        </button>
                    ` : ''}
                </div>
            `;

            // Remove existing success messages in the same container
            $(options.container).find('.promen-widget-success').remove();
            
            // Add new success message
            $(options.container).prepend(successHtml);
            
            const $successElement = $('#' + successId);

            // Focus if requested
            if (options.focus) {
                $successElement.focus();
            }

            // Announce to screen readers
            if (options.announce) {
                this.announceSuccess(message);
            }

            // Auto-dismiss after 5 seconds
            if (options.dismissible) {
                setTimeout(function() {
                    $successElement.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 5000);
            }

            return $successElement;
        },

        // Focus on error element
        focusError: function($errorElement) {
            // Scroll into view if not visible
            if (!this.isElementInViewport($errorElement[0])) {
                $errorElement[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }

            // Focus after scroll
            setTimeout(function() {
                $errorElement.focus();
            }, 300);
        },

        // Focus new error (for dynamically added errors)
        focusNewError: function(event) {
            const $error = $(event.target);
            if ($error.hasClass('promen-widget-error') && $error.attr('role') === 'alert') {
                PromenErrorHandler.focusError($error);
            }
        },

        // Announce error to screen readers
        announceError: function(message) {
            const $liveRegion = $('#promen-error-live-region');
            $liveRegion.text(''); // Clear first
            
            setTimeout(function() {
                $liveRegion.text(message);
            }, 50);

            // Clear after announcement
            setTimeout(function() {
                $liveRegion.text('');
            }, 3000);
        },

        // Announce success to screen readers
        announceSuccess: function(message) {
            const $liveRegion = $('#promen-success-live-region');
            $liveRegion.text(''); // Clear first
            
            setTimeout(function() {
                $liveRegion.text(message);
            }, 50);

            // Clear after announcement
            setTimeout(function() {
                $liveRegion.text('');
            }, 3000);
        },

        // Dismiss message
        dismissMessage: function(event) {
            event.preventDefault();
            const $message = $(this).closest('.promen-widget-error, .promen-widget-success');
            
            $message.fadeOut(200, function() {
                $(this).remove();
            });
        },

        // Handle keyboard dismissal
        handleKeyboardDismissal: function(event) {
            // Dismiss with Escape key
            if (event.key === 'Escape' || event.keyCode === 27) {
                const $dismissButton = $(this).find('.error-dismiss, .success-dismiss');
                if ($dismissButton.length) {
                    $dismissButton.trigger('click');
                }
            }
        },

        // Handle form submission
        handleFormSubmission: function(event) {
            const $form = $(this);
            const widgetId = $form.closest('.promen-widget').attr('id') || '';

            // Clear existing errors
            $form.find('.promen-widget-error').remove();

            // Show loading state
            PromenErrorHandler.showLoadingState($form, widgetId);
        },

        // Show loading state
        showLoadingState: function($form, widgetId) {
            const loadingMessage = promenErrors.loading_message;
            
            // Add loading indicator
            if (!$form.find('.promen-loading-indicator').length) {
                $form.prepend(`
                    <div class="promen-loading-indicator" role="status" aria-live="polite">
                        <span class="loading-message">${loadingMessage}</span>
                        <span class="loading-spinner" aria-hidden="true"></span>
                    </div>
                `);
            }

            // Disable form elements
            $form.find('input, textarea, select, button').prop('disabled', true);
            
            // Announce loading to screen readers
            $('#promen-success-live-region').text(loadingMessage);
        },

        // Hide loading state
        hideLoadingState: function($form) {
            $form.find('.promen-loading-indicator').remove();
            $form.find('input, textarea, select, button').prop('disabled', false);
            $('#promen-success-live-region').text('');
        },

        // Handle AJAX errors
        handleAjaxError: function(event, jqXHR, ajaxSettings, thrownError) {
            // Only handle our plugin's AJAX requests
            if (ajaxSettings.url && ajaxSettings.url.includes('admin-ajax.php')) {
                const data = ajaxSettings.data || '';
                if (data.includes('promen') || data.includes('elementor')) {
                    let errorMessage = promenErrors.network_error;
                    
                    // Customize error message based on status
                    switch (jqXHR.status) {
                        case 0:
                            errorMessage = promenErrors.network_error;
                            break;
                        case 404:
                            errorMessage = 'The requested resource was not found.';
                            break;
                        case 500:
                            errorMessage = 'A server error occurred. Please try again.';
                            break;
                        case 403:
                            errorMessage = 'You do not have permission to perform this action.';
                            break;
                    }

                    PromenErrorHandler.displayError(errorMessage, {
                        type: 'network'
                    });
                }
            }
        },

        // Validate form fields
        validateForm: function($form) {
            let isValid = true;
            const errors = [];

            // Remove existing field errors
            $form.find('.promen-field-error').removeClass('promen-field-error');
            $form.find('.field-error-message').remove();

            // Check required fields
            $form.find('[required]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (!value) {
                    PromenErrorHandler.markFieldError($field, 'This field is required.');
                    errors.push($field.attr('name') || 'Unknown field');
                    isValid = false;
                }
            });

            // Check email fields
            $form.find('input[type="email"]').each(function() {
                const $field = $(this);
                const value = $field.val().trim();
                
                if (value && !PromenErrorHandler.isValidEmail(value)) {
                    PromenErrorHandler.markFieldError($field, 'Please enter a valid email address.');
                    errors.push($field.attr('name') || 'Email field');
                    isValid = false;
                }
            });

            // If there are errors, display summary and focus first error
            if (!isValid) {
                const errorSummary = `Form validation errors: ${errors.join(', ')}. Please correct the highlighted fields.`;
                PromenErrorHandler.displayError(errorSummary, {
                    type: 'validation',
                    focus: false
                });

                // Focus first error field
                const $firstError = $form.find('.promen-field-error').first();
                if ($firstError.length) {
                    $firstError.focus();
                }
            }

            return isValid;
        },

        // Mark field with error
        markFieldError: function($field, errorMessage) {
            $field.addClass('promen-field-error');
            $field.attr('aria-invalid', 'true');
            
            const errorId = 'field-error-' + this.generateUniqueId();
            $field.attr('aria-describedby', errorId);
            
            const $errorMessage = $(`<div id="${errorId}" class="field-error-message" role="alert">${errorMessage}</div>`);
            $field.after($errorMessage);
        },

        // Email validation
        isValidEmail: function(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        },

        // Check if element is in viewport
        isElementInViewport: function(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top >= 0 &&
                rect.left >= 0 &&
                rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                rect.right <= (window.innerWidth || document.documentElement.clientWidth)
            );
        },

        // Escape HTML
        escapeHtml: function(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        },

        // Generate unique ID
        generateUniqueId: function() {
            return Date.now().toString(36) + Math.random().toString(36).substr(2);
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function() {
        PromenErrorHandler.init();
    });

    // Make PromenErrorHandler globally available
    window.PromenErrorHandler = PromenErrorHandler;

})(jQuery);