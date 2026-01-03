<?php
/**
 * Custom Form Component for Contact Info Card Widget
 * 
 * Renders the custom form section.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Renders the custom form section.
 * 
 * @param array $settings Widget settings
 */
function render_custom_form($settings) {
    ?>
    <section class="contact-info-card__custom-form" role="region" aria-labelledby="custom-form-heading">
        <h2 id="custom-form-heading" class="sr-only"><?php echo esc_html__('Contact Form', 'promen-elementor-widgets'); ?></h2>
        <form action="<?php echo esc_url($settings['form_action']); ?>" method="post" enctype="multipart/form-data" role="form" aria-label="<?php echo esc_attr__('Contact form', 'promen-elementor-widgets'); ?>">
            <fieldset>
                <legend class="sr-only"><?php echo esc_html__('Personal Information', 'promen-elementor-widgets'); ?></legend>
                
                <?php if ('yes' === $settings['show_name_field']) : ?>
                    <div class="form-field">
                        <label for="name"><?php echo esc_html($settings['name_field_label']); ?> <span class="required" aria-label="<?php echo esc_attr__('Required field', 'promen-elementor-widgets'); ?>">*</span></label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               required 
                               aria-required="true"
                               aria-describedby="name-error"
                               autocomplete="name">
                        <div id="name-error" class="error-message" role="alert" aria-live="polite" style="display: none;"></div>
                    </div>
                <?php endif; ?>
                
                <?php if ('yes' === $settings['show_phone_field']) : ?>
                    <div class="form-field">
                        <label for="phone"><?php echo esc_html($settings['phone_field_label']); ?> <span class="required" aria-label="<?php echo esc_attr__('Required field', 'promen-elementor-widgets'); ?>">*</span></label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               required 
                               aria-required="true"
                               aria-describedby="phone-error"
                               autocomplete="tel">
                        <div id="phone-error" class="error-message" role="alert" aria-live="polite" style="display: none;"></div>
                    </div>
                <?php endif; ?>
                
                <?php if ('yes' === $settings['show_email_field']) : ?>
                    <div class="form-field">
                        <label for="email"><?php echo esc_html($settings['email_field_label']); ?> <span class="required" aria-label="<?php echo esc_attr__('Required field', 'promen-elementor-widgets'); ?>">*</span></label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required 
                               aria-required="true"
                               aria-describedby="email-error"
                               autocomplete="email">
                        <div id="email-error" class="error-message" role="alert" aria-live="polite" style="display: none;"></div>
                    </div>
                <?php endif; ?>
            </fieldset>
            
            <fieldset>
                <legend class="sr-only"><?php echo esc_html__('File Uploads', 'promen-elementor-widgets'); ?></legend>
                
                <?php if ('yes' === $settings['show_cv_field']) : ?>
                    <div class="form-field">
                        <label for="cv-file"><?php echo esc_html($settings['cv_field_label']); ?> <span class="required" aria-label="<?php echo esc_attr__('Required field', 'promen-elementor-widgets'); ?>">*</span></label>
                        <div class="file-upload-wrapper">
                            <div class="file-upload-info" role="status" aria-live="polite">
                                <span class="file-name" id="cv-file-status"><?php echo esc_html($settings['cv_no_file_text']); ?></span>
                            </div>
                            <label for="cv-file" class="file-upload-button" tabindex="0" role="button" aria-describedby="cv-file-status">
                                <?php echo esc_html($settings['cv_upload_text']); ?>
                            </label>
                            <input type="file" 
                                   id="cv-file" 
                                   name="cv" 
                                   class="file-input" 
                                   accept=".pdf,.doc,.docx" 
                                   required 
                                   aria-required="true"
                                   aria-describedby="cv-file-status cv-file-error"
                                   style="display: none;">
                            <div id="cv-file-error" class="error-message" role="alert" aria-live="polite" style="display: none;"></div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ('yes' === $settings['show_motivation_field']) : ?>
                    <div class="form-field">
                        <label for="motivation-file"><?php echo esc_html($settings['motivation_field_label']); ?> <span class="required" aria-label="<?php echo esc_attr__('Required field', 'promen-elementor-widgets'); ?>">*</span></label>
                        <div class="file-upload-wrapper">
                            <div class="file-upload-info" role="status" aria-live="polite">
                                <span class="file-name" id="motivation-file-status"><?php echo esc_html($settings['motivation_no_file_text']); ?></span>
                            </div>
                            <label for="motivation-file" class="file-upload-button" tabindex="0" role="button" aria-describedby="motivation-file-status">
                                <?php echo esc_html($settings['motivation_upload_text']); ?>
                            </label>
                            <input type="file" 
                                   id="motivation-file" 
                                   name="motivation" 
                                   class="file-input" 
                                   accept=".pdf,.doc,.docx" 
                                   required 
                                   aria-required="true"
                                   aria-describedby="motivation-file-status motivation-file-error"
                                   style="display: none;">
                            <div id="motivation-file-error" class="error-message" role="alert" aria-live="polite" style="display: none;"></div>
                        </div>
                    </div>
                <?php endif; ?>
            </fieldset>
            
            <?php if ('yes' === $settings['show_submit_button']) : ?>
                <div class="form-field">
                    <button type="submit" 
                            class="submit-button" 
                            aria-describedby="form-submit-help">
                        <?php echo esc_html($settings['submit_button_text']); ?>
                    </button>
                    <div id="form-submit-help" class="sr-only">
                        <?php echo esc_html__('Submit the form to send your information', 'promen-elementor-widgets'); ?>
                    </div>
                </div>
            <?php endif; ?>
        </form>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle file input display for CV
                const cvFileInput = document.getElementById('cv-file');
                if (cvFileInput) {
                    const cvFileName = document.getElementById('cv-file-status');
                    const cvFileButton = cvFileInput.closest('.form-field').querySelector('.file-upload-button');
                    
                    // File input change handler
                    cvFileInput.addEventListener('change', function() {
                        if (this.files.length > 0) {
                            const file = this.files[0];
                            cvFileName.textContent = file.name;
                            cvFileName.setAttribute('aria-label', '<?php echo esc_js(__('Selected file:', 'promen-elementor-widgets')); ?> ' + file.name);
                            
                            // Validate file type
                            const allowedTypes = ['.pdf', '.doc', '.docx'];
                            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                            if (!allowedTypes.includes(fileExtension)) {
                                showError('cv-file-error', '<?php echo esc_js(__('Please select a PDF, DOC, or DOCX file.', 'promen-elementor-widgets')); ?>');
                            } else {
                                hideError('cv-file-error');
                            }
                        } else {
                            cvFileName.textContent = '<?php echo esc_js($settings['cv_no_file_text']); ?>';
                            cvFileName.removeAttribute('aria-label');
                        }
                    });
                    
                    // Keyboard support for file button
                    cvFileButton.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            cvFileInput.click();
                        }
                    });
                }
                
                // Handle file input display for Motivation
                const motivationFileInput = document.getElementById('motivation-file');
                if (motivationFileInput) {
                    const motivationFileName = document.getElementById('motivation-file-status');
                    const motivationFileButton = motivationFileInput.closest('.form-field').querySelector('.file-upload-button');
                    
                    // File input change handler
                    motivationFileInput.addEventListener('change', function() {
                        if (this.files.length > 0) {
                            const file = this.files[0];
                            motivationFileName.textContent = file.name;
                            motivationFileName.setAttribute('aria-label', '<?php echo esc_js(__('Selected file:', 'promen-elementor-widgets')); ?> ' + file.name);
                            
                            // Validate file type
                            const allowedTypes = ['.pdf', '.doc', '.docx'];
                            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                            if (!allowedTypes.includes(fileExtension)) {
                                showError('motivation-file-error', '<?php echo esc_js(__('Please select a PDF, DOC, or DOCX file.', 'promen-elementor-widgets')); ?>');
                            } else {
                                hideError('motivation-file-error');
                            }
                        } else {
                            motivationFileName.textContent = '<?php echo esc_js($settings['motivation_no_file_text']); ?>';
                            motivationFileName.removeAttribute('aria-label');
                        }
                    });
                    
                    // Keyboard support for file button
                    motivationFileButton.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            motivationFileInput.click();
                        }
                    });
                }
                
                // Form validation
                const form = document.querySelector('.contact-info-card__custom-form form');
                if (form) {
                    form.addEventListener('submit', function(e) {
                        let hasErrors = false;
                        
                        // Validate required fields
                        const requiredFields = form.querySelectorAll('input[required]');
                        requiredFields.forEach(function(field) {
                            if (!field.value.trim()) {
                                showError(field.id + '-error', '<?php echo esc_js(__('This field is required.', 'promen-elementor-widgets')); ?>');
                                hasErrors = true;
                            } else {
                                hideError(field.id + '-error');
                            }
                        });
                        
                        if (hasErrors) {
                            e.preventDefault();
                            // Focus first error field
                            const firstError = form.querySelector('.error-message[style*="block"]');
                            if (firstError) {
                                const fieldId = firstError.id.replace('-error', '');
                                const field = document.getElementById(fieldId);
                                if (field) {
                                    field.focus();
                                }
                            }
                        }
                    });
                }
                
                // Helper functions
                function showError(errorId, message) {
                    const errorElement = document.getElementById(errorId);
                    if (errorElement) {
                        errorElement.textContent = message;
                        errorElement.style.display = 'block';
                        errorElement.setAttribute('aria-live', 'assertive');
                    }
                }
                
                function hideError(errorId) {
                    const errorElement = document.getElementById(errorId);
                    if (errorElement) {
                        errorElement.style.display = 'none';
                        errorElement.textContent = '';
                    }
                }
            });
        </script>
    </div>
    <?php
} 