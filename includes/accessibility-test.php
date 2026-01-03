<?php
/**
 * Accessibility Test and Validation Script
 * Tests all implemented WCAG 2.1/2.2 features
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Test Accessibility Utilities Class
 */
function test_promen_accessibility_utils() {
    if (!class_exists('Promen_Accessibility_Utils')) {
        return ['status' => 'error', 'message' => 'Accessibility Utils class not found'];
    }
    
    $tests = [];
    
    // Test 1: Unique ID generation
    $id1 = Promen_Accessibility_Utils::generate_id('test', 'widget-123');
    $id2 = Promen_Accessibility_Utils::generate_id('test', 'widget-123');
    
    $tests['unique_ids'] = [
        'status' => $id1 !== $id2 ? 'pass' : 'fail',
        'message' => $id1 !== $id2 ? 'IDs are unique' : 'IDs are not unique',
        'values' => [$id1, $id2]
    ];
    
    // Test 2: ARIA label attributes
    $aria_attrs = Promen_Accessibility_Utils::get_aria_label_attrs(
        'Test label',
        'labelledby-id',
        'describedby-id'
    );
    
    $expected_attrs = [
        'aria-label="Test label"',
        'aria-labelledby="labelledby-id"',
        'aria-describedby="describedby-id"'
    ];
    
    $all_present = true;
    foreach ($expected_attrs as $attr) {
        if (strpos($aria_attrs, $attr) === false) {
            $all_present = false;
            break;
        }
    }
    
    $tests['aria_attributes'] = [
        'status' => $all_present ? 'pass' : 'fail',
        'message' => $all_present ? 'All ARIA attributes generated correctly' : 'Missing ARIA attributes',
        'output' => $aria_attrs
    ];
    
    // Test 3: Button attributes
    $button_attrs = Promen_Accessibility_Utils::get_button_attrs([
        'label' => 'Test button',
        'expanded' => false,
        'controls' => 'menu-id',
        'haspopup' => true
    ]);
    
    $required_button_attrs = [
        'aria-label="Test button"',
        'aria-expanded="false"',
        'aria-controls="menu-id"',
        'aria-haspopup="true"'
    ];
    
    $button_attrs_valid = true;
    foreach ($required_button_attrs as $attr) {
        if (strpos($button_attrs, $attr) === false) {
            $button_attrs_valid = false;
            break;
        }
    }
    
    $tests['button_attributes'] = [
        'status' => $button_attrs_valid ? 'pass' : 'fail',
        'message' => $button_attrs_valid ? 'Button attributes generated correctly' : 'Button attributes missing',
        'output' => $button_attrs
    ];
    
    // Test 4: Color contrast calculation
    $contrast_ratio = Promen_Accessibility_Utils::get_contrast_ratio('#000000', '#FFFFFF');
    $tests['contrast_ratio'] = [
        'status' => $contrast_ratio > 7 ? 'pass' : 'fail', // Should be 21:1 for black/white
        'message' => "Contrast ratio: {$contrast_ratio}:1 " . ($contrast_ratio >= 4.5 ? '(WCAG AA compliant)' : '(WCAG non-compliant)'),
        'value' => $contrast_ratio
    ];
    
    // Test 5: Screen reader text
    $sr_text = Promen_Accessibility_Utils::get_screen_reader_text('Hidden text for screen readers');
    $tests['screen_reader_text'] = [
        'status' => strpos($sr_text, 'screen-reader-text') !== false ? 'pass' : 'fail',
        'message' => strpos($sr_text, 'screen-reader-text') !== false ? 'Screen reader text generated with proper class' : 'Screen reader text class missing',
        'output' => $sr_text
    ];
    
    // Test 6: Slider attributes
    $slider_attrs = Promen_Accessibility_Utils::get_slider_attrs([
        'widget_id' => 'test-slider',
        'slides_count' => 5,
        'autoplay' => true,
        'loop' => true
    ]);
    
    $required_slider_keys = ['container_id', 'live_region_id', 'container_attrs', 'prev_button_attrs', 'next_button_attrs'];
    $slider_attrs_complete = true;
    
    foreach ($required_slider_keys as $key) {
        if (!isset($slider_attrs[$key])) {
            $slider_attrs_complete = false;
            break;
        }
    }
    
    $tests['slider_attributes'] = [
        'status' => $slider_attrs_complete ? 'pass' : 'fail',
        'message' => $slider_attrs_complete ? 'Slider attributes complete' : 'Missing slider attributes',
        'keys' => array_keys($slider_attrs)
    ];
    
    return [
        'status' => 'completed',
        'tests' => $tests,
        'summary' => [
            'total' => count($tests),
            'passed' => count(array_filter($tests, function($test) { return $test['status'] === 'pass'; })),
            'failed' => count(array_filter($tests, function($test) { return $test['status'] === 'fail'; }))
        ]
    ];
}

/**
 * Test Error Handling Accessibility
 */
function test_promen_error_handling() {
    if (!class_exists('Promen_Error_Handling')) {
        return ['status' => 'error', 'message' => 'Error Handling class not found'];
    }
    
    $tests = [];
    
    // Test 1: Error message display
    $error_html = Promen_Error_Handling::display_error('Test error message', 'validation', 'test-widget');
    
    $required_error_elements = [
        'role="alert"',
        'aria-live="assertive"',
        'Test error message',
        'error-dismiss',
        'aria-label='
    ];
    
    $error_valid = true;
    foreach ($required_error_elements as $element) {
        if (strpos($error_html, $element) === false) {
            $error_valid = false;
            break;
        }
    }
    
    $tests['error_display'] = [
        'status' => $error_valid ? 'pass' : 'fail',
        'message' => $error_valid ? 'Error message contains all required accessibility attributes' : 'Missing error accessibility attributes',
        'output' => $error_html
    ];
    
    // Test 2: Success message display
    $success_html = Promen_Error_Handling::display_success('Test success message', 'test-widget');
    
    $required_success_elements = [
        'role="status"',
        'aria-live="polite"',
        'Test success message',
        'success-dismiss'
    ];
    
    $success_valid = true;
    foreach ($required_success_elements as $element) {
        if (strpos($success_html, $element) === false) {
            $success_valid = false;
            break;
        }
    }
    
    $tests['success_display'] = [
        'status' => $success_valid ? 'pass' : 'fail',
        'message' => $success_valid ? 'Success message contains all required accessibility attributes' : 'Missing success accessibility attributes',
        'output' => $success_html
    ];
    
    return [
        'status' => 'completed',
        'tests' => $tests,
        'summary' => [
            'total' => count($tests),
            'passed' => count(array_filter($tests, function($test) { return $test['status'] === 'pass'; })),
            'failed' => count(array_filter($tests, function($test) { return $test['status'] === 'fail'; }))
        ]
    ];
}

/**
 * Test CSS Accessibility Features
 */
function test_promen_css_accessibility() {
    $css_file = PROMEN_ELEMENTOR_WIDGETS_PATH . 'assets/css/accessibility.css';
    
    if (!file_exists($css_file)) {
        return ['status' => 'error', 'message' => 'Accessibility CSS file not found'];
    }
    
    $css_content = file_get_contents($css_file);
    $tests = [];
    
    // Test 1: Screen reader text styles
    $tests['screen_reader_text'] = [
        'status' => strpos($css_content, '.screen-reader-text') !== false ? 'pass' : 'fail',
        'message' => strpos($css_content, '.screen-reader-text') !== false ? 'Screen reader text styles present' : 'Screen reader text styles missing'
    ];
    
    // Test 2: Focus indicators
    $tests['focus_indicators'] = [
        'status' => strpos($css_content, '*:focus') !== false ? 'pass' : 'fail',
        'message' => strpos($css_content, '*:focus') !== false ? 'Focus indicators present' : 'Focus indicators missing'
    ];
    
    // Test 3: Touch target sizes
    $tests['touch_targets'] = [
        'status' => strpos($css_content, 'min-height: 44px') !== false ? 'pass' : 'fail',
        'message' => strpos($css_content, 'min-height: 44px') !== false ? 'Touch target sizes implemented' : 'Touch target sizes missing'
    ];
    
    // Test 4: Reduced motion support
    $tests['reduced_motion'] = [
        'status' => strpos($css_content, 'prefers-reduced-motion') !== false ? 'pass' : 'fail',
        'message' => strpos($css_content, 'prefers-reduced-motion') !== false ? 'Reduced motion support present' : 'Reduced motion support missing'
    ];
    
    // Test 5: High contrast support
    $tests['high_contrast'] = [
        'status' => strpos($css_content, 'prefers-contrast: high') !== false ? 'pass' : 'fail',
        'message' => strpos($css_content, 'prefers-contrast: high') !== false ? 'High contrast support present' : 'High contrast support missing'
    ];
    
    // Test 6: ARIA live regions
    $tests['aria_live_regions'] = [
        'status' => strpos($css_content, '.aria-live-region') !== false ? 'pass' : 'fail',
        'message' => strpos($css_content, '.aria-live-region') !== false ? 'ARIA live region styles present' : 'ARIA live region styles missing'
    ];
    
    return [
        'status' => 'completed',
        'tests' => $tests,
        'summary' => [
            'total' => count($tests),
            'passed' => count(array_filter($tests, function($test) { return $test['status'] === 'pass'; })),
            'failed' => count(array_filter($tests, function($test) { return $test['status'] === 'fail'; }))
        ]
    ];
}

/**
 * Run all accessibility tests
 */
function run_promen_accessibility_tests() {
    $results = [
        'timestamp' => current_time('mysql'),
        'tests' => [
            'utilities' => test_promen_accessibility_utils(),
            'error_handling' => test_promen_error_handling(),
            'css_features' => test_promen_css_accessibility()
        ]
    ];
    
    // Calculate overall summary
    $total_tests = 0;
    $total_passed = 0;
    $total_failed = 0;
    
    foreach ($results['tests'] as $category) {
        if (isset($category['summary'])) {
            $total_tests += $category['summary']['total'];
            $total_passed += $category['summary']['passed'];
            $total_failed += $category['summary']['failed'];
        }
    }
    
    $results['overall_summary'] = [
        'total' => $total_tests,
        'passed' => $total_passed,
        'failed' => $total_failed,
        'success_rate' => $total_tests > 0 ? round(($total_passed / $total_tests) * 100, 2) : 0
    ];
    
    return $results;
}

// Only run tests if called directly (for debugging)
if (defined('WP_CLI') && WP_CLI) {
    $test_results = run_promen_accessibility_tests();
    WP_CLI::success('Accessibility tests completed');
    WP_CLI::line('Overall success rate: ' . $test_results['overall_summary']['success_rate'] . '%');
    WP_CLI::line('Total tests: ' . $test_results['overall_summary']['total']);
    WP_CLI::line('Passed: ' . $test_results['overall_summary']['passed']);
    WP_CLI::line('Failed: ' . $test_results['overall_summary']['failed']);
}