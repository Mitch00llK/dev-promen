/**
 * Widget Admin JavaScript
 * 
 * Handles widget toggle, usage modal, and cache refresh functionality.
 */
(function ($) {
    'use strict';

    const PromenWidgetAdmin = {

        /**
         * Initialize
         */
        init: function () {
            this.bindEvents();
        },

        /**
         * Bind event handlers
         */
        bindEvents: function () {
            // Toggle widget state
            $(document).on('change', '.promen-toggle__input', this.handleToggle.bind(this));

            // View usage button
            $(document).on('click', '.promen-view-usage', this.handleViewUsage.bind(this));

            // Close modal
            $(document).on('click', '.promen-modal__close, .promen-modal__overlay', this.closeModal.bind(this));

            // Escape key closes modal
            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    this.closeModal();
                }
            }.bind(this));

            // Refresh cache button
            $('#promen-refresh-cache').on('click', this.handleRefreshCache.bind(this));
        },

        /**
         * Handle widget toggle
         */
        handleToggle: function (e) {
            const $checkbox = $(e.target);
            const $card = $checkbox.closest('.promen-widget-card');
            const widgetName = $checkbox.data('widget');
            const enabled = $checkbox.is(':checked');

            // Show loading state
            $card.addClass('is-loading');

            // Send AJAX request
            $.ajax({
                url: promenWidgetAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'promen_toggle_widget',
                    nonce: promenWidgetAdmin.nonce,
                    widget: widgetName,
                    enabled: enabled
                },
                success: function (response) {
                    if (response.success) {
                        // Update card state
                        $card.toggleClass('is-disabled', !enabled);
                        $card.find('.promen-toggle__label').text(
                            enabled ? 'Enabled' : 'Disabled'
                        );
                    } else {
                        // Revert checkbox
                        $checkbox.prop('checked', !enabled);
                        alert(response.data.message || promenWidgetAdmin.strings.error);
                    }
                },
                error: function () {
                    // Revert checkbox
                    $checkbox.prop('checked', !enabled);
                    alert(promenWidgetAdmin.strings.error);
                },
                complete: function () {
                    $card.removeClass('is-loading');
                }
            });
        },

        /**
         * Handle view usage button click
         */
        handleViewUsage: function (e) {
            e.preventDefault();

            const $button = $(e.target);
            const widgetName = $button.data('widget');
            const $card = $button.closest('.promen-widget-card');
            const widgetTitle = $card.find('.promen-widget-card__title').text();

            // Show modal with loading state
            this.showModal(widgetTitle, '<p class="promen-loading">' + promenWidgetAdmin.strings.loading + '</p>');

            // Fetch usage data
            $.ajax({
                url: promenWidgetAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'promen_get_widget_usage',
                    nonce: promenWidgetAdmin.nonce,
                    widget: widgetName
                },
                success: function (response) {
                    if (response.success) {
                        $('#promen-usage-modal .promen-modal__body').html(response.data.html);
                    } else {
                        $('#promen-usage-modal .promen-modal__body').html(
                            '<p class="promen-error">' + (response.data.message || promenWidgetAdmin.strings.error) + '</p>'
                        );
                    }
                },
                error: function () {
                    $('#promen-usage-modal .promen-modal__body').html(
                        '<p class="promen-error">' + promenWidgetAdmin.strings.error + '</p>'
                    );
                }
            });
        },

        /**
         * Show modal
         */
        showModal: function (title, content) {
            const $modal = $('#promen-usage-modal');
            $modal.find('.promen-modal__title').text(title + ' - Usage');
            $modal.find('.promen-modal__body').html(content);
            $modal.fadeIn(200);
            $('body').addClass('modal-open');
        },

        /**
         * Close modal
         */
        closeModal: function () {
            $('#promen-usage-modal').fadeOut(200);
            $('body').removeClass('modal-open');
        },

        /**
         * Handle refresh cache button
         */
        handleRefreshCache: function (e) {
            e.preventDefault();

            const $button = $(e.target).closest('button');
            const originalText = $button.html();

            // Show loading state
            $button.prop('disabled', true).html(
                '<span class="dashicons dashicons-update spinning"></span> ' + promenWidgetAdmin.strings.refreshing
            );

            // Send AJAX request
            $.ajax({
                url: promenWidgetAdmin.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'promen_refresh_usage_cache',
                    nonce: promenWidgetAdmin.nonce
                },
                success: function (response) {
                    if (response.success) {
                        // Update all usage counts
                        const counts = response.data.counts;
                        $('.promen-widget-card').each(function () {
                            const widgetName = $(this).data('widget');
                            const count = counts[widgetName] || 0;
                            $(this).find('.usage-count').text(count);
                        });
                    } else {
                        alert(response.data.message || promenWidgetAdmin.strings.error);
                    }
                },
                error: function () {
                    alert(promenWidgetAdmin.strings.error);
                },
                complete: function () {
                    $button.prop('disabled', false).html(originalText);
                }
            });
        }
    };

    // Initialize when DOM is ready
    $(document).ready(function () {
        PromenWidgetAdmin.init();
    });

    // Add spinning animation for refresh icon
    $('<style>')
        .prop('type', 'text/css')
        .html('.dashicons.spinning { animation: promen-spin 1s linear infinite; } @keyframes promen-spin { 100% { transform: rotate(360deg); } }')
        .appendTo('head');

})(jQuery);
