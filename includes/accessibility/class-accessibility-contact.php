<?php
/**
 * Accessibility Contact Utilities
 * 
 * Provides accessible contact link helpers (phone, email, address).
 * 
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Accessibility Contact Utilities Class
 */
class Promen_Accessibility_Contact {

    /**
     * Generate contact info blocks accessibility attributes
     * 
     * @param string $block_type Type of contact block ('address', 'phone', 'email').
     * @param array  $data Block data.
     * @param int    $index Block index.
     * @param string $widget_id Widget ID.
     * @return array Contact block accessibility data.
     */
    public static function get_contact_block_attrs($block_type, $data = [], $index = 0, $widget_id = '') {
        $block_id = Promen_Accessibility_Aria::generate_id($block_type . '-block-' . ($index + 1), $widget_id);
        $heading_id = Promen_Accessibility_Aria::generate_id($block_type . '-heading-' . ($index + 1), $widget_id);
        $content_id = Promen_Accessibility_Aria::generate_id($block_type . '-content-' . ($index + 1), $widget_id);
        
        $schema_type = '';
        switch ($block_type) {
            case 'address':
                $schema_type = 'https://schema.org/PostalAddress';
                break;
            case 'phone':
            case 'email':
                $schema_type = 'https://schema.org/ContactPoint';
                break;
        }
        
        $block_labels = [
            'address' => __('Adresinformatie', 'promen-elementor-widgets'),
            'phone' => __('Telefoonnummer', 'promen-elementor-widgets'),
            'email' => __('E-mailadres', 'promen-elementor-widgets')
        ];
        
        $block_label = $block_labels[$block_type] ?? __('Contactinformatie', 'promen-elementor-widgets');
        
        $link_labels = [
            'phone' => __('Bel %s', 'promen-elementor-widgets'),
            'email' => __('Stuur e-mail naar %s', 'promen-elementor-widgets')
        ];
        
        return [
            'block_id' => $block_id,
            'heading_id' => $heading_id,
            'content_id' => $content_id,
            'block_attrs' => 'id="' . esc_attr($block_id) . '" role="listitem" data-block-type="' . esc_attr($block_type) . '"',
            'article_attrs' => 'aria-labelledby="' . esc_attr($heading_id) . '" itemscope itemtype="' . esc_attr($schema_type) . '"',
            'heading_attrs' => 'id="' . esc_attr($heading_id) . '" class="contact-info-title"',
            'content_attrs' => 'id="' . esc_attr($content_id) . '" class="contact-info-content"',
            'block_label' => $block_label,
            'link_label_format' => $link_labels[$block_type] ?? '',
            'schema_type' => $schema_type
        ];
    }

    /**
     * Generate phone link with proper accessibility
     * 
     * @param string $phone_number Phone number to display.
     * @param bool   $clickable Whether to make it clickable.
     * @param array  $extra_attrs Extra attributes.
     * @return string Phone link HTML.
     */
    public static function get_accessible_phone_link($phone_number, $clickable = true, $extra_attrs = []) {
        if (!$clickable) {
            return '<span class="contact-info-text" itemprop="telephone">' . esc_html($phone_number) . '</span>';
        }
        
        $clean_number = preg_replace('/[^0-9+]/', '', $phone_number);
        
        $aria_label = sprintf(__('Bel %s', 'promen-elementor-widgets'), $phone_number);
        if (isset($extra_attrs['aria-label'])) {
            $aria_label = $extra_attrs['aria-label'];
            unset($extra_attrs['aria-label']);
        }
        
        $attrs = 'href="tel:' . esc_attr($clean_number) . '" ';
        $attrs .= 'class="contact-info-link contact-info-link--phone" ';
        $attrs .= 'itemprop="telephone" ';
        $attrs .= 'aria-label="' . esc_attr($aria_label) . '" ';
        $attrs .= 'rel="nofollow"';
        
        foreach ($extra_attrs as $key => $value) {
            $attrs .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
        }
        
        return '<a ' . $attrs . '><span aria-hidden="true">' . esc_html($phone_number) . '</span><span class="screen-reader-text">' . esc_html(sprintf(__('Telefoon: %s (klik om te bellen)', 'promen-elementor-widgets'), $phone_number)) . '</span></a>';
    }

    /**
     * Generate email link with proper accessibility
     * 
     * @param string $email_address Email address to display.
     * @param bool   $clickable Whether to make it clickable.
     * @param array  $extra_attrs Extra attributes.
     * @return string Email link HTML.
     */
    public static function get_accessible_email_link($email_address, $clickable = true, $extra_attrs = []) {
        if (!$clickable) {
            return '<span class="contact-info-text" itemprop="email">' . esc_html($email_address) . '</span>';
        }
        
        $aria_label = sprintf(__('Stuur e-mail naar %s', 'promen-elementor-widgets'), $email_address);
        if (isset($extra_attrs['aria-label'])) {
            $aria_label = $extra_attrs['aria-label'];
            unset($extra_attrs['aria-label']);
        }
        
        $attrs = 'href="mailto:' . esc_attr($email_address) . '" ';
        $attrs .= 'class="contact-info-link contact-info-link--email" ';
        $attrs .= 'itemprop="email" ';
        $attrs .= 'aria-label="' . esc_attr($aria_label) . '" ';
        $attrs .= 'rel="nofollow"';
        
        foreach ($extra_attrs as $key => $value) {
            $attrs .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
        }
        
        return '<a ' . $attrs . '><span aria-hidden="true">' . esc_html($email_address) . '</span><span class="screen-reader-text">' . esc_html(sprintf(__('E-mail: %s (klik om te verzenden)', 'promen-elementor-widgets'), $email_address)) . '</span></a>';
    }

    /**
     * Sanitize and validate phone number
     * 
     * @param string $phone Phone number.
     * @return string Sanitized phone number.
     */
    public static function sanitize_phone_number($phone) {
        $phone = preg_replace('/[^0-9+]/', '', $phone);
        
        if (strpos($phone, '+') !== false) {
            $phone = '+' . str_replace('+', '', $phone);
        }
        
        return $phone;
    }

    /**
     * Validate email address with accessibility feedback
     * 
     * @param string $email Email address.
     * @return bool True if valid.
     */
    public static function validate_email_address($email) {
        return is_email($email);
    }
}
