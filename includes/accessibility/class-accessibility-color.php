<?php
/**
 * Accessibility Color Utilities
 * 
 * Provides WCAG 2.1/2.2 compliant color contrast utilities.
 * 
 * @package Promen_Elementor_Widgets
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Accessibility Color Utilities Class
 */
class Promen_Accessibility_Color {

    /**
     * Validate color contrast ratio
     * 
     * @param string $foreground Foreground color (hex).
     * @param string $background Background color (hex).
     * @return float Contrast ratio.
     */
    public static function get_contrast_ratio($foreground, $background) {
        $fg_rgb = self::hex_to_rgb($foreground);
        $bg_rgb = self::hex_to_rgb($background);
        
        $fg_luminance = self::get_relative_luminance($fg_rgb);
        $bg_luminance = self::get_relative_luminance($bg_rgb);
        
        $lighter = max($fg_luminance, $bg_luminance);
        $darker = min($fg_luminance, $bg_luminance);
        
        return ($lighter + 0.05) / ($darker + 0.05);
    }

    /**
     * Convert hex color to RGB
     * 
     * @param string $hex Hex color code.
     * @return array RGB values.
     */
    public static function hex_to_rgb($hex) {
        $hex = ltrim($hex, '#');
        
        if (strlen($hex) === 3) {
            $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
        }
        
        return [
            'r' => hexdec(substr($hex, 0, 2)),
            'g' => hexdec(substr($hex, 2, 2)),
            'b' => hexdec(substr($hex, 4, 2))
        ];
    }

    /**
     * Get relative luminance
     * 
     * @param array $rgb RGB color values.
     * @return float Relative luminance.
     */
    public static function get_relative_luminance($rgb) {
        $r = $rgb['r'] / 255;
        $g = $rgb['g'] / 255;
        $b = $rgb['b'] / 255;
        
        $r = $r <= 0.03928 ? $r / 12.92 : pow(($r + 0.055) / 1.055, 2.4);
        $g = $g <= 0.03928 ? $g / 12.92 : pow(($g + 0.055) / 1.055, 2.4);
        $b = $b <= 0.03928 ? $b / 12.92 : pow(($b + 0.055) / 1.055, 2.4);
        
        return 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
    }

    /**
     * Check if WCAG color contrast is sufficient
     * 
     * @param string $foreground Foreground color.
     * @param string $background Background color.
     * @param string $level 'AA' or 'AAA'.
     * @param string $size 'normal' or 'large'.
     * @return bool True if contrast is sufficient.
     */
    public static function check_wcag_contrast($foreground, $background, $level = 'AA', $size = 'normal') {
        $ratio = self::get_contrast_ratio($foreground, $background);
        
        // WCAG 2.2 requirements
        $requirements = [
            'AA' => [
                'normal' => 4.5,
                'large' => 3.0
            ],
            'AAA' => [
                'normal' => 7.0,
                'large' => 4.5
            ]
        ];
        
        $required_ratio = $requirements[$level][$size] ?? 4.5;
        
        return $ratio >= $required_ratio;
    }

    /**
     * Suggest accessible color alternatives
     * 
     * @param string $foreground Current foreground color.
     * @param string $background Background color.
     * @param string $level Target WCAG level.
     * @return array Suggested colors.
     */
    public static function suggest_accessible_color($foreground, $background, $level = 'AA') {
        if (self::check_wcag_contrast($foreground, $background, $level)) {
            return [
                'passes' => true,
                'current' => $foreground,
                'suggestion' => null
            ];
        }

        $fg_rgb = self::hex_to_rgb($foreground);
        $bg_luminance = self::get_relative_luminance(self::hex_to_rgb($background));
        
        // Try darkening or lightening the foreground
        $suggestions = [];
        
        // If background is light, make foreground darker
        if ($bg_luminance > 0.5) {
            for ($i = 0; $i <= 100; $i += 5) {
                $darkened = self::adjust_brightness($fg_rgb, -$i);
                $hex = self::rgb_to_hex($darkened);
                if (self::check_wcag_contrast($hex, $background, $level)) {
                    $suggestions[] = $hex;
                    break;
                }
            }
        } else {
            // Background is dark, make foreground lighter
            for ($i = 0; $i <= 100; $i += 5) {
                $lightened = self::adjust_brightness($fg_rgb, $i);
                $hex = self::rgb_to_hex($lightened);
                if (self::check_wcag_contrast($hex, $background, $level)) {
                    $suggestions[] = $hex;
                    break;
                }
            }
        }

        return [
            'passes' => false,
            'current' => $foreground,
            'suggestion' => !empty($suggestions) ? $suggestions[0] : null
        ];
    }

    /**
     * Adjust brightness of RGB color
     * 
     * @param array $rgb RGB values.
     * @param int   $amount Amount to adjust (-100 to 100).
     * @return array Adjusted RGB values.
     */
    private static function adjust_brightness($rgb, $amount) {
        $factor = 1 + ($amount / 100);
        
        return [
            'r' => min(255, max(0, round($rgb['r'] * $factor))),
            'g' => min(255, max(0, round($rgb['g'] * $factor))),
            'b' => min(255, max(0, round($rgb['b'] * $factor)))
        ];
    }

    /**
     * Convert RGB to hex
     * 
     * @param array $rgb RGB values.
     * @return string Hex color.
     */
    public static function rgb_to_hex($rgb) {
        return sprintf('#%02x%02x%02x', $rgb['r'], $rgb['g'], $rgb['b']);
    }
}
