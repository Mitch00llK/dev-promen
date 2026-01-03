<?php
/**
 * Content Template for Contact Info Card Widget
 * 
 * Handles the rendering of the contact info card widget in the editor.
 * Uses the same components as the frontend renderer but with Elementor templating syntax.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Renders the Elementor editor content template.
 */
function render_contact_info_card_content_template() {
    ?>
    <#
    // Main container classes
    var containerClasses = ['contact-info-card'];
    
    // Add position class based on content type
    if (settings.right_side_content_type === 'none') {
        containerClasses.push('no-right-content');
    } else if (settings.right_side_content_type === 'employee_info') {
        containerClasses.push('employee-position-' + settings.employee_info_position);
    } else if (settings.right_side_content_type === 'gravity_form') {
        containerClasses.push('form-position-' + settings.form_position);
    } else if (settings.right_side_content_type === 'custom_form') {
        containerClasses.push('form-position-' + settings.custom_form_position);
    } else if (settings.right_side_content_type === 'combined_layout') {
        containerClasses.push('combined-layout');
        
        // Add ratio class
        if (settings.combined_layout_ratio) {
            var ratio = settings.combined_layout_ratio.replace('_', '-');
            containerClasses.push('ratio-' + ratio);
        }
    }
    #>
    
    <!-- Skip Links for Accessibility -->
    <nav class="skip-links" aria-label="<?php echo esc_attr__('Navigatie om direct naar de hoofdinhoud te gaan', 'promen-elementor-widgets'); ?>">
        <a href="#contact-info-main" class="skip-link"><?php echo esc_html__('Sla over naar inhoud', 'promen-elementor-widgets'); ?></a>
        <# if (settings.right_side_content_type !== 'none' && (settings.right_side_content_type === 'employee_info' || settings.right_side_content_type === 'combined_layout')) { #>
            <a href="#employee-contact-info" class="skip-link"><?php echo esc_html__('Sla over naar inhoud', 'promen-elementor-widgets'); ?></a>
        <# } #>
        <# if (settings.right_side_content_type !== 'none' && (settings.right_side_content_type === 'gravity_form' || settings.right_side_content_type === 'custom_form' || settings.right_side_content_type === 'combined_layout')) { #>
            <a href="#contact-form" class="skip-link"><?php echo esc_html__('Sla over naar inhoud', 'promen-elementor-widgets'); ?></a>
        <# } #>
    </nav>
    
    <div class="{{{ containerClasses.join(' ') }}}" style="display: grid; grid-template-columns: <# if (settings.right_side_content_type === 'none') { #>1fr<# } else { #>minmax(0, 1fr) auto<# } #>; grid-gap: 20px; width: 100%;">
        <# if (settings.right_side_content_type !== 'combined_layout') { #>
            <!-- Main Content Section -->
            <div id="contact-info-main" class="contact-info-card__main-content" style="grid-column: 1; min-width: 0;">
                <# if (settings.show_heading === 'yes') { #>
                    <div class="contact-info-card__heading-wrapper">
                        <# 
                        var headingTag = settings.title_html_tag || 'h3';
                        
                        if (settings.split_title === 'yes') {
                            #>
                            <{{{ headingTag }}} class="promen-split-title">
                                <span class="promen-title-part-1">{{{ settings.title_part_1 || '' }}}</span>
                                <span class="promen-title-part-2">{{{ settings.title_part_2 || '' }}}</span>
                            </{{{ headingTag }}}>
                        <# } else if (settings.heading) { #>
                            <{{{ headingTag }}} class="promen-title">
                                {{{ settings.heading }}}
                            </{{{ headingTag }}}>
                        <# } #>
                    </div>
                <# } #>
                
                <# if (settings.show_description === 'yes') { #>
                    <# if (settings.content_type === 'description' && settings.description) { #>
                        <div class="contact-info-card__description">{{{ settings.description }}}</div>
                    <# } else if (settings.content_type === 'icon_list' && settings.icon_list_items && settings.icon_list_items.length) { #>
                        <style>
                            .contact-info-card__icon-list {
                                list-style: none;
                                padding: 0;
                                margin: 0 0 1.5rem 0;
                                width: 100%;
                            }
                            .contact-info-card__icon-list-item {
                                display: flex;
                                align-items: flex-start;
                                margin-bottom: 0.75rem;
                            }
                            .contact-info-card__icon-list-item:last-child {
                                margin-bottom: 0;
                            }
                            .contact-info-card__icon-list-icon {
                                display: inline-flex;
                                align-items: center;
                                justify-content: center;
                                margin-right: 0.75rem;
                                flex-shrink: 0;
                                width: 1.25rem;
                            }
                            .contact-info-card__icon-list-text {
                                flex: 1;
                                line-height: 1.5;
                            }
                            @media (max-width: 767px) {
                                .contact-info-card__icon-list-icon {
                                    margin-right: 0.5rem;
                                    width: 1rem;
                                }
                                .contact-info-card__icon-list-text {
                                    font-size: 0.875rem;
                                }
                            }
                        </style>
                        <ul class="contact-info-card__icon-list">
                            <# _.each(settings.icon_list_items, function(item, index) { #>
                                <li class="contact-info-card__icon-list-item">
                                    <# if (item.item_icon && item.item_icon.value) { #>
                                        <span class="contact-info-card__icon-list-icon">
                                            <i class="{{ item.item_icon.value }}" aria-hidden="true"></i>
                                        </span>
                                    <# } #>
                                    <span class="contact-info-card__icon-list-text">{{{ item.item_text }}}</span>
                                </li>
                            <# }); #>
                        </ul>
                    <# } #>
                <# } #>
                
                <# if (settings.show_cta_button === 'yes' && settings.cta_button_text) { #>
                    <# 
                    var buttonUrl = settings.cta_button_link && settings.cta_button_link.url ? settings.cta_button_link.url : '#';
                    var buttonTarget = settings.cta_button_link && settings.cta_button_link.is_external ? ' target="_blank"' : '';
                    var buttonNofollow = settings.cta_button_link && settings.cta_button_link.nofollow ? ' rel="nofollow"' : '';
                    #>
                    <a href="{{{ buttonUrl }}}" class="contact-info-card__button"{{{ buttonTarget }}}{{{ buttonNofollow }}}>
                        {{{ settings.cta_button_text }}}
                        <# if (settings.cta_button_icon && settings.cta_button_icon.value) { #>
                            <i class="{{ settings.cta_button_icon.value }}" aria-hidden="true"></i>
                        <# } #>
                    </a>
                <# } #>
            </div>
        <# } else { #>
            <!-- Combined Layout Section -->
            <div class="contact-info-card__content-wrapper" style="display: grid; grid-template-columns: 1fr auto auto; grid-gap: 20px; width: 100%;">
                <!-- Main Content Section -->
                <div class="contact-info-card__main-content" style="grid-column: 1; min-width: 0;">
                    <# if (settings.show_heading === 'yes') { #>
                        <div class="contact-info-card__heading-wrapper">
                            <# 
                            var headingTag = settings.title_html_tag || 'h3';
                            
                            if (settings.split_title === 'yes') {
                                #>
                                <{{{ headingTag }}} class="promen-split-title">
                                    <span class="promen-title-part-1">{{{ settings.title_part_1 || '' }}}</span>
                                    <span class="promen-title-part-2">{{{ settings.title_part_2 || '' }}}</span>
                                </{{{ headingTag }}}>
                            <# } else if (settings.heading) { #>
                                <{{{ headingTag }}} class="promen-title">
                                    {{{ settings.heading }}}
                                </{{{ headingTag }}}>
                            <# } #>
                        </div>
                    <# } #>
                    
                    <# if (settings.show_description === 'yes') { #>
                        <# if (settings.content_type === 'description' && settings.description) { #>
                            <div class="contact-info-card__description">{{{ settings.description }}}</div>
                        <# } else if (settings.content_type === 'icon_list' && settings.icon_list_items && settings.icon_list_items.length) { #>
                            <style>
                                .contact-info-card__icon-list {
                                    list-style: none;
                                    padding: 0;
                                    margin: 0 0 1.5rem 0;
                                    width: 100%;
                                }
                                .contact-info-card__icon-list-item {
                                    display: flex;
                                    align-items: flex-start;
                                    margin-bottom: 0.75rem;
                                }
                                .contact-info-card__icon-list-item:last-child {
                                    margin-bottom: 0;
                                }
                                .contact-info-card__icon-list-icon {
                                    display: inline-flex;
                                    align-items: center;
                                    justify-content: center;
                                    margin-right: 0.75rem;
                                    flex-shrink: 0;
                                    width: 1.25rem;
                                }
                                .contact-info-card__icon-list-text {
                                    flex: 1;
                                    line-height: 1.5;
                                }
                                @media (max-width: 767px) {
                                    .contact-info-card__icon-list-icon {
                                        margin-right: 0.5rem;
                                        width: 1rem;
                                    }
                                    .contact-info-card__icon-list-text {
                                        font-size: 0.875rem;
                                    }
                                }
                            </style>
                            <ul class="contact-info-card__icon-list">
                                <# _.each(settings.icon_list_items, function(item, index) { #>
                                    <li class="contact-info-card__icon-list-item">
                                        <# if (item.item_icon && item.item_icon.value) { #>
                                            <span class="contact-info-card__icon-list-icon">
                                                <i class="{{ item.item_icon.value }}" aria-hidden="true"></i>
                                            </span>
                                        <# } #>
                                        <span class="contact-info-card__icon-list-text">{{{ item.item_text }}}</span>
                                    </li>
                                <# }); #>
                            </ul>
                        <# } #>
                    <# } #>
                    
                    <# if (settings.show_cta_button === 'yes' && settings.cta_button_text) { #>
                        <# 
                        var buttonUrl = settings.cta_button_link && settings.cta_button_link.url ? settings.cta_button_link.url : '#';
                        var buttonTarget = settings.cta_button_link && settings.cta_button_link.is_external ? ' target="_blank"' : '';
                        var buttonNofollow = settings.cta_button_link && settings.cta_button_link.nofollow ? ' rel="nofollow"' : '';
                        #>
                        <a href="{{{ buttonUrl }}}" class="contact-info-card__button"{{{ buttonTarget }}}{{{ buttonNofollow }}}>
                            {{{ settings.cta_button_text }}}
                            <# if (settings.cta_button_icon && settings.cta_button_icon.value) { #>
                                <i class="{{ settings.cta_button_icon.value }}" aria-hidden="true"></i>
                            <# } #>
                        </a>
                    <# } #>
                </div>
                
                <!-- Employee Info Section for Combined Layout -->
                <div class="contact-info-card__employee-info-block" style="grid-column: 2; width: auto;">
                    <div class="contact-info-card__employee-info">
                        <# if (settings.show_employee_image === 'yes' && settings.employee_image && settings.employee_image.url) { #>
                            <div class="contact-info-card__employee-image">
                                <img src="{{{ settings.employee_image.url }}}" alt="{{{ settings.employee_name }}}">
                            </div>
                        <# } #>
                        
                        <# if (settings.show_contact_heading === 'yes' && settings.contact_heading) { #>
                            <# var contactHeadingTag = settings.contact_heading_tag || 'h3'; #>
                            <{{{ contactHeadingTag }}} class="contact-info-card__contact-heading">{{{ settings.contact_heading }}}</{{{ contactHeadingTag }}}>
                        <# } #>
                        
                        <# if (settings.show_employee_name === 'yes' && settings.employee_name) { #>
                            <div class="contact-info-card__employee-name">{{{ settings.employee_name }}}</div>
                        <# } #>
                        
                        <div class="contact-info-card__contact-items">
                            <# if (settings.contact_items && settings.contact_items.length) { #>
                                <# _.each(settings.contact_items, function(item, index) { #>
                                    <# if (item && item.contact_value && item.contact_type) { #>
                                        <div class="contact-info-card__contact-item contact-info-card__{{{ item.contact_type }}}">
                                            <span class="contact-info-card__contact-icon" aria-hidden="true">
                                                <# if (item.contact_type === 'email') { #>
                                                    <i class="fas fa-envelope"></i>
                                                <# } else { #>
                                                    <i class="fas fa-phone-alt"></i>
                                                <# } #>
                                            </span>
                                            <# if (item.contact_type === 'email') { #>
                                                <a href="mailto:{{{ item.contact_value }}}">{{{ item.contact_value }}}</a>
                                            <# } else { #>
                                                <a href="tel:{{{ item.contact_value.replace(/[^0-9+]/g, '') }}}">{{{ item.contact_value }}}</a>
                                            <# } #>
                                        </div>
                                    <# } #>
                                <# }); #>
                            <# } #>
                        </div>
                    </div>
                </div>
                
                <!-- Gravity Form Section for Combined Layout -->
                <# if (settings.show_gravity_form === 'yes' && settings.gravity_form_shortcode) { #>
                    <div class="contact-info-card__gravity-form" style="grid-column: 3; width: auto;">
                        <# /* Note: Shortcodes don't render in Elementor editor preview, so we show a placeholder */ #>
                        <div class="contact-info-card__gravity-form-placeholder">
                            <i class="fas fa-wpforms"></i>
                            <p><?php echo esc_html__('Gravity Form will appear here on the frontend', 'promen-elementor-widgets'); ?></p>
                            <small><?php echo esc_html__('Shortcode:', 'promen-elementor-widgets'); ?> {{{ settings.gravity_form_shortcode }}}</small>
                        </div>
                    </div>
                <# } #>
            </div>
        <# } #>
        
        <!-- Employee Info Section for Standard Layout -->
        <# if (settings.right_side_content_type === 'employee_info') { #>
            <div class="contact-info-card__employee-info-block" style="grid-column: 2; width: auto;">
                <div class="contact-info-card__employee-info">
                    <# if (settings.show_employee_image === 'yes' && settings.employee_image && settings.employee_image.url) { #>
                        <div class="contact-info-card__employee-image">
                            <img src="{{{ settings.employee_image.url }}}" alt="{{{ settings.employee_name }}}">
                        </div>
                    <# } #>
                    
                    <# if (settings.show_contact_heading === 'yes' && settings.contact_heading) { #>
                        <# var contactHeadingTag = settings.contact_heading_tag || 'h3'; #>
                        <{{{ contactHeadingTag }}} class="contact-info-card__contact-heading">{{{ settings.contact_heading }}}</{{{ contactHeadingTag }}}>
                    <# } #>
                    
                    <# if (settings.show_employee_name === 'yes' && settings.employee_name) { #>
                        <div class="contact-info-card__employee-name">{{{ settings.employee_name }}}</div>
                    <# } #>
                    
                    <div class="contact-info-card__contact-items">
                        <# if (settings.contact_items && settings.contact_items.length) { #>
                            <# _.each(settings.contact_items, function(item, index) { #>
                                <# if (item && item.contact_value && item.contact_type) { #>
                                    <div class="contact-info-card__contact-item contact-info-card__{{{ item.contact_type }}}">
                                        <span class="contact-info-card__contact-icon" aria-hidden="true">
                                            <# if (item.contact_type === 'email') { #>
                                                <i class="fas fa-envelope"></i>
                                            <# } else { #>
                                                <i class="fas fa-phone-alt"></i>
                                            <# } #>
                                        </span>
                                        <# if (item.contact_type === 'email') { #>
                                            <a href="mailto:{{{ item.contact_value }}}">{{{ item.contact_value }}}</a>
                                        <# } else { #>
                                            <a href="tel:{{{ item.contact_value.replace(/[^0-9+]/g, '') }}}">{{{ item.contact_value }}}</a>
                                        <# } #>
                                    </div>
                                <# } #>
                            <# }); #>
                        <# } #>
                    </div>
                </div>
            </div>
        <# } #>
        
        <!-- Gravity Form Section for Standard Layout -->
        <# if (settings.right_side_content_type === 'gravity_form' && settings.show_gravity_form === 'yes' && settings.gravity_form_shortcode) { #>
            <div class="contact-info-card__gravity-form" style="grid-column: 2; width: auto;">
                <# /* Note: Shortcodes don't render in Elementor editor preview, so we show a placeholder */ #>
                <div class="contact-info-card__gravity-form-placeholder">
                    <i class="fas fa-wpforms"></i>
                    <p><?php echo esc_html__('Gravity Form will appear here on the frontend', 'promen-elementor-widgets'); ?></p>
                    <small><?php echo esc_html__('Shortcode:', 'promen-elementor-widgets'); ?> {{{ settings.gravity_form_shortcode }}}</small>
                </div>
            </div>
        <# } #>
        
        <!-- Custom Form Section -->
        <# if (settings.right_side_content_type === 'custom_form' && settings.show_custom_form === 'yes') { #>
            <div class="contact-info-card__custom-form" style="grid-column: 2; width: auto;">
                <form>
                    <# if (settings.show_name_field === 'yes') { #>
                        <div class="form-field">
                            <label for="name">{{{ settings.name_field_label }}}*</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                    <# } #>
                    
                    <# if (settings.show_phone_field === 'yes') { #>
                        <div class="form-field">
                            <label for="phone">{{{ settings.phone_field_label }}}*</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    <# } #>
                    
                    <# if (settings.show_email_field === 'yes') { #>
                        <div class="form-field">
                            <label for="email">{{{ settings.email_field_label }}}*</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                    <# } #>
                    
                    <# if (settings.show_cv_field === 'yes') { #>
                        <div class="form-field">
                            <label for="cv">{{{ settings.cv_field_label }}}*</label>
                            <div class="file-upload-wrapper">
                                <div class="file-upload-info">
                                    <span class="file-name">{{{ settings.cv_no_file_text }}}</span>
                                </div>
                                <label class="file-upload-button">{{{ settings.cv_upload_text }}}</label>
                            </div>
                        </div>
                    <# } #>
                    
                    <# if (settings.show_motivation_field === 'yes') { #>
                        <div class="form-field">
                            <label for="motivation">{{{ settings.motivation_field_label }}}*</label>
                            <div class="file-upload-wrapper">
                                <div class="file-upload-info">
                                    <span class="file-name">{{{ settings.motivation_no_file_text }}}</span>
                                </div>
                                <label class="file-upload-button">{{{ settings.motivation_upload_text }}}</label>
                            </div>
                        </div>
                    <# } #>
                    
                    <# if (settings.show_submit_button === 'yes') { #>
                        <div class="form-field">
                            <button type="button" class="submit-button">{{{ settings.submit_button_text }}}</button>
                        </div>
                    <# } #>
                </form>
            </div>
        <# } #>
    </div>
    <?php
} 