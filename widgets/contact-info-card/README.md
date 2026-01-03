# Contact Info Card Widget

A customizable contact information card widget with heading, description, employee information, and contact details.

## Features

- Fully responsive design
- Customizable colors, typography, and spacing
- Show/hide individual elements
- Reorder elements to create different layouts
- Character limit for description
- Support for employee image, name, and contact information
- Customizable CTA button with link options

## Structure

The widget follows a highly modular structure for better code organization and maintainability:

```
contact-info-card/
├── contact-info-card-widget.php  # Main widget class
├── README.md                     # Documentation
└── includes/
    ├── controls/                 # Control files
    │   ├── content-controls.php  # Content controls
    │   ├── style-controls.php    # Style controls main file
    │   ├── style/                # Style control components
    │   │   ├── card-style.php    # Card style controls
    │   │   ├── employee-info-block-style.php # Employee info block controls
    │   │   ├── heading-style.php # Heading style controls
    │   │   └── ...               # Other style components
    │   └── visibility-controls.php # Visibility controls
    └── render/                   # Render files
        ├── render-widget.php     # Frontend rendering main file
        ├── content-template.php  # Editor rendering
        └── components/           # Render components
            ├── main-content.php  # Main content section
            ├── employee-info.php # Employee info section
            ├── gravity-form.php  # Gravity form section
            ├── custom-form.php   # Custom form section
            └── ...               # Other render components
```

## Usage

The widget can be used in Elementor by dragging it from the widget panel to the page. It provides the following sections:

1. **Content** - Set the heading, description, and CTA button
2. **Employee Information** - Set the employee image, name, and contact details
3. **Element Visibility** - Show/hide individual elements
4. **Element Order** - Change the order of elements
5. **Style** - Customize the appearance of the widget

## Customization

The widget provides extensive customization options:

- **Card Style** - Background color, padding, border radius, box shadow
- **Employee Info Block Style** - Background color, padding, border radius
- **Heading Style** - Typography, color, margin
- **Description Style** - Typography, color, margin
- **Button Style** - Typography, colors, padding, border radius
- **Employee Info Style** - Background color, padding, border radius
- **Employee Image Style** - Size, border radius
- **Contact Info Style** - Typography, colors

## Development

To extend or modify this widget, you can edit the following files:

- `contact-info-card-widget.php` - Main widget class
- `includes/controls/*.php` - Control files
- `includes/controls/style/*.php` - Style component files
- `includes/render/render-widget.php` - Main render file
- `includes/render/content-template.php` - Editor template
- `includes/render/components/*.php` - Render component files

The modular structure makes it easy to add new features by creating new component files and including them in the main files. 