jQuery(document).ready(function($) {
    // Handle enable/disable toggle
    function toggleLenisSettings() {
        const isEnabled = $('input[name="lenis_scroll_options[enable_lenis]"]').is(':checked');
        const settingsRows = $('input[name^="lenis_scroll_options[scroll_"], select[name^="lenis_scroll_options[scroll_"], input[name^="lenis_scroll_options[mouse_"], input[name^="lenis_scroll_options[touch_"]').closest('tr');
        const testButton = $('#test-lenis-settings');

        if (isEnabled) {
            settingsRows.show().css('opacity', '1');
            testButton.prop('disabled', false).text('Test Scroll Settings');
        } else {
            settingsRows.hide();
            testButton.prop('disabled', true).text('Test Disabled (Enable Lenis First)');
        }
    }

    // Initialize on page load
    toggleLenisSettings();

    // Handle checkbox change
    $('input[name="lenis_scroll_options[enable_lenis]"]').on('change', toggleLenisSettings);

    $('#test-lenis-settings').on('click', function() {
        $.ajax({
            url: lenisSettings.ajaxurl,
            type: 'POST',
            data: {
                action: 'test_lenis_speed',
                nonce: lenisSettings.nonce
            },
            success: function(response) {
                if (response.success) {
                    const settings = response.data;

                    // Check if Lenis is enabled
                    if (!settings.enable_lenis) {
                        alert('Lenis smooth scroll is currently disabled. Please enable it in the settings to test.');
                        return;
                    }

                    // Create a test element
                    const testContainer = $('<div>', {
                        id: 'lenis-test-container',
                        css: {
                            position: 'fixed',
                            top: 0,
                            left: 0,
                            width: '100%',
                            height: '100%',
                            background: 'rgba(0,0,0,0.8)',
                            zIndex: 999999,
                            overflow: 'auto',
                            padding: '20px'
                        }
                    });

                    const content = $('<div>', {
                        css: {
                            background: '#fff',
                            padding: '20px',
                            maxWidth: '800px',
                            margin: '20px auto',
                            borderRadius: '5px'
                        }
                    });

                    // Add close button
                    const closeBtn = $('<button>', {
                        text: 'Close Test',
                        class: 'button button-primary',
                        css: {
                            position: 'fixed',
                            top: '20px',
                            right: '20px'
                        }
                    }).on('click', function() {
                        testContainer.remove();
                    });

                    // Add test content
                    for (let i = 0; i < 10; i++) {
                        content.append(`
                            <div style="margin-bottom: 40px;">
                                <h3>Test Section ${i + 1}</h3>
                                <p>This is a test section to demonstrate the scroll settings.</p>
                                <p>Current settings:</p>
                                <ul>
                                    <li>Enabled: ${settings.enable_lenis ? 'Yes' : 'No'}</li>
                                    <li>Duration: ${settings.scroll_duration}s</li>
                                    <li>Easing: ${settings.scroll_easing}</li>
                                    <li>Mouse Multiplier: ${settings.mouse_multiplier}</li>
                                    <li>Touch Multiplier: ${settings.touch_multiplier}</li>
                                </ul>
                            </div>
                        `);
                    }

                    testContainer.append(closeBtn, content);
                    $('body').append(testContainer);

                    // Initialize Lenis with current settings
                    const lenis = new Lenis({
                        duration: parseFloat(settings.scroll_duration),
                        easing: (t) => {
                            switch (settings.scroll_easing) {
                                case 'linear':
                                    return t;
                                case 'ease-out-quad':
                                    return t * (2 - t);
                                case 'ease-out-cubic':
                                    return 1 - Math.pow(1 - t, 3);
                                case 'ease-out-expo':
                                default:
                                    return Math.min(1, 1.001 - Math.pow(2, -10 * t));
                            }
                        },
                        mouseMultiplier: parseFloat(settings.mouse_multiplier),
                        touchMultiplier: parseFloat(settings.touch_multiplier)
                    });

                    function raf(time) {
                        lenis.raf(time);
                        requestAnimationFrame(raf);
                    }

                    requestAnimationFrame(raf);

                    // Clean up when closing
                    closeBtn.on('click', function() {
                        lenis.destroy();
                    });
                }
            }
        });
    });
});