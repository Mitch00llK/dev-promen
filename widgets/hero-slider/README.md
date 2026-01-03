# Hero Slider Widget

## Overview

The Hero Slider Widget is a custom Elementor widget that allows you to create beautiful, responsive hero sections with slider functionality. It supports both slider and static modes, content overlap, and various styling options.

## Features

- **Dual Mode**: Choose between slider mode (multiple slides) or static mode (single slide)
- **Content Overlap**: Option to make the content overlap with elements below the slider
- **Ken Burns Effect**: Add dynamic zoom effects to background images
- **Responsive Design**: Fully responsive with customizable settings for different screen sizes
- **Navigation Options**: Customizable arrows and pagination
- **Elementor Container Compatible**: Works seamlessly with both traditional Elementor sections and the new container system

## Recent Fixes

The following issues have been fixed in the latest update:

1. **Display Type Control**: Fixed issues with the display_type control not persisting its value
2. **Content Overlap Feature**: Improved the content_overlap control and related functionality
3. **Slider Controls**: Enhanced slider controls to ensure they properly persist their values
4. **Navigation Controls**: Updated navigation controls for better compatibility
5. **Repeater Controls**: Fixed issues with repeater controls for slides, especially for the Ken Burns effect
6. **Elementor Container Compatibility**: Improved compatibility with Elementor containers
7. **JavaScript Initialization**: Enhanced the initialization process and error handling in the JavaScript file
8. **CSS Improvements**: Updated CSS for better compatibility with Elementor containers

## Usage

1. Add the Hero Slider widget to your Elementor page
2. Choose between slider mode or static mode
3. Add slides with background images, titles, content, and buttons
4. Customize the appearance using the style controls
5. Adjust the navigation options as needed
6. Configure responsive settings for different screen sizes

## Testing

A test file (`test-hero-slider.php`) has been created to verify that the widget works correctly. You can access this file directly in your browser to test the following:

- Slider mode functionality
- Static mode functionality
- Content overlap feature

## Troubleshooting

If you encounter any issues with the widget, check the following:

1. Make sure the Swiper library is properly enqueued
2. Check the browser console for any JavaScript errors
3. Verify that the widget is compatible with your Elementor version
4. If using content overlap, ensure that parent elements have proper overflow settings

## Developer Notes

- The widget uses the Swiper library for slider functionality
- Control values are made available to the frontend using the `frontend_available` and `render_type` parameters
- The widget includes extensive error handling and fallback mechanisms
- CSS includes specific fixes for Elementor container compatibility 