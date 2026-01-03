# Image Text Slider Assets

This directory contains all the assets for the Image Text Slider widget, organized according to Elementor widget development best practices.

## Directory Structure

```
assets/
├── css/
│   ├── style.css                    # Main stylesheet
│   ├── modules/
│   │   ├── accessibility-minimal.css # Accessibility-specific styles
│   │   └── mobile-optimizations.css  # Mobile performance optimizations
│   └── index.php                    # Security file
├── js/
│   ├── script.js                    # Main JavaScript file
│   ├── modules/
│   │   └── init-slider.js           # Slider initialization module
│   └── index.php                    # Security file
├── index.php                        # Security file
└── README.md                        # This file
```

## File Descriptions

### CSS Files
- **`css/style.css`** - Main stylesheet containing all core widget styles
- **`css/modules/accessibility-minimal.css`** - WCAG 2.2 AA accessibility enhancements
- **`css/modules/mobile-optimizations.css`** - Mobile performance optimizations and responsive styles

### JavaScript Files
- **`js/script.js`** - Main JavaScript file with core functionality, accessibility features, and browser compatibility
- **`js/modules/init-slider.js`** - Slider initialization module with GSAP animations and performance optimizations

## Security
All directories contain `index.php` files to prevent direct access to the directory contents.

## Development Guidelines
- Follow the Elementor widget development rules
- Maintain accessibility standards (WCAG 2.2 AA)
- Optimize for mobile performance
- Use semantic naming conventions
- Keep modules focused on specific functionality
