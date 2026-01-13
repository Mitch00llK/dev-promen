<?php
/**
 * Plugin Name: Promen Elementor Widgets
 * Description: Custom Elementor widgets for Promen website
 * Version: 2.0
 * Author: Mitchell Kamp
 * Text Domain: promen-elementor-widgets
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin path constants
define('PROMEN_ELEMENTOR_WIDGETS_PATH', plugin_dir_path(__FILE__));
define('PROMEN_ELEMENTOR_WIDGETS_URL', plugins_url('/', __FILE__));
define('PROMEN_ELEMENTOR_WIDGETS_VERSION', '1.0.0');

// Include core files
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/class-error-handling.php');
require_once(PROMEN_ELEMENTOR_WIDGETS_PATH . 'includes/class-promen-elementor-widgets.php');

// Include required files



// Initialize the plugin
Promen_Elementor_Widgets::instance();

// Register AJAX handlers for document downloads (for both logged in and logged out users)
add_action('wp_ajax_promen_download_file', 'promen_handle_file_download');
add_action('wp_ajax_nopriv_promen_download_file', 'promen_handle_file_download');

/**
 * Handle file download via AJAX (accessible to all users)
 */
function promen_handle_file_download() {
    // Verify nonce for security
    if (!wp_verify_nonce($_POST['nonce'], 'promen_download_file')) {
        wp_die('Security check failed');
    }

    $file_id = intval($_POST['file_id']);
    
    if (!$file_id) {
        wp_die('Invalid file ID');
    }

    // Get attachment post to check if it exists and is public
    $attachment = get_post($file_id);
    if (!$attachment || $attachment->post_type !== 'attachment') {
        wp_die('Invalid attachment');
    }

    // Check if attachment is publicly accessible (inherit status = public)
    if ($attachment->post_status !== 'inherit') {
        wp_die('File not publicly accessible');
    }

    $file_path = get_attached_file($file_id);
    
    if (!$file_path || !file_exists($file_path)) {
        wp_die('File not found');
    }

    $file_name = basename($file_path);
    $file_size = filesize($file_path);
    $mime_type = get_post_mime_type($file_id);

    // Set headers for download
    header('Content-Type: ' . $mime_type);
    header('Content-Disposition: attachment; filename="' . $file_name . '"');
    header('Content-Length: ' . $file_size);
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Expires: 0');

    // Clear output buffer
    ob_clean();
    flush();

    // Read and output file
    readfile($file_path);
    exit;
} 