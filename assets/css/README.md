# Promen Elementor Widgets CSS Organization

This directory contains all CSS files for the Promen Elementor Widgets plugin.

## Directory Structure

- `style.css` - Main stylesheet that imports all other CSS files
- `common.css` - Common styles shared across multiple widgets
- `admin.css` - Styles for the WordPress admin area
- `widgets/` - Directory containing individual widget CSS files
  - Each widget has its own CSS file named after the widget

## Usage Guidelines

1. **Widget-specific styles** should be placed in the `widgets/` directory with a filename matching the widget name.
2. **Common styles** that are shared across multiple widgets should be placed in `common.css`.
3. **Admin-specific styles** should be placed in `admin.css`.
4. The main `style.css` file should only contain imports and minimal global styles.

## Naming Conventions

- Use kebab-case for CSS class names (e.g., `.promen-feature-block`)
- Prefix all classes with `promen-` to avoid conflicts with other plugins
- Use BEM methodology for class naming when appropriate:
  - Block: `.promen-feature-block`
  - Element: `.promen-feature-block__title`
  - Modifier: `.promen-feature-block--highlighted`

## Best Practices

- Use CSS variables for colors, spacing, and other repeated values
- Keep selectors as simple as possible to improve performance
- Comment your code, especially for complex selectors or animations
- Use media queries for responsive designs
- Optimize for accessibility and performance 