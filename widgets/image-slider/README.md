# Image Slider Widget

A widget that displays images in a grid or slider layout. When more than 3 images are added, it automatically converts to a SwiperJS slider.

## Features

- Display images in a responsive grid layout
- Automatic conversion to slider when more than 3 images are added
- Customizable slider settings (navigation, pagination, autoplay, etc.)
- Gradient overlays on the left and right sides of the slider
- Image overlay options with title and description
- Auto-pull title and description from image metadata
- Fully responsive design
- Accessibility-friendly implementation

## Usage

1. Add the widget to your Elementor page
2. Set the section title
3. Add images using the repeater control
4. Choose whether to use image metadata for titles and descriptions
5. Configure slider settings if needed
6. Style the widget using the style controls

## Controls

### Content Controls
- Section Title
- Split Title Option
- Images (Repeater)
  - Image
  - Use Image Title (pulls title from media library)
  - Custom Title (if not using image title)
  - Use Image Description (pulls caption/description from media library)
  - Custom Description (if not using image description)
  - Show Overlay
- Layout Settings (Columns, Image Size, etc.)

### Slider Controls
- Slider Template
- Navigation Arrows
- Pagination Dots
- Loop
- Autoplay
- Transition Effect
- Gradient Overlay

### Style Controls
- Title Style
- Images Style
- Overlay Style
- Slider Navigation Style

### Visibility Controls
- Show/Hide Title
- Show/Hide Image Titles
- Show/Hide Image Descriptions
- Show Overlay on Hover
- Responsive Visibility

## Technical Details

- Uses SwiperJS for slider functionality
- Optimized for performance
- SEO-friendly structure
- Accessibility compliant
- Auto-retrieves image metadata from WordPress media library 