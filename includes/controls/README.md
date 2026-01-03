# Promen Elementor Widgets - Common Controls

This directory contains common controls that can be reused across all Promen Elementor widgets.

## Split Title Controls

The `split-title-controls.php` file provides standardized controls and rendering functions for implementing split titles across all widgets.

### Usage

#### 1. Adding Split Title Controls to a Widget

In your widget's controls file, use the `promen_add_split_title_controls()` function:

```php
// Add the split title controls to your widget
promen_add_split_title_controls(
    $widget,                // The widget instance
    'section_header',       // The section name
    ['show_header' => 'yes'], // Optional condition for when to show these controls
    'Your Default Title'    // Default title text
);
```

Parameters:
- `$widget`: The widget instance
- `$section_name`: The section name to add controls to (default: 'section_header')
- `$condition`: Optional condition for when to show these controls (default: [])
- `$default_title`: Default title text (default: '')
- `$title_control_name`: Optional custom name for the title control (default: 'title')

#### 2. Adding Style Controls for Split Title Parts

In your widget's style controls file, use the `promen_add_split_title_style_controls()` function:

```php
// Add style controls for the split title parts
promen_add_split_title_style_controls(
    $widget,                // The widget instance
    'section_title_style',  // The section name
    ['show_header' => 'yes'], // Optional condition for when to show these controls
    'your-prefix'           // Optional prefix for CSS classes
);
```

Parameters:
- `$widget`: The widget instance
- `$section_name`: The section name to add controls to (default: 'section_title_style')
- `$condition`: Optional condition for when to show these controls (default: [])
- `$class_prefix`: Optional prefix for CSS classes (default: 'promen')
- `$title_control_name`: Optional custom name for the title control (default: 'title')

#### 3. Rendering the Split Title

In your widget's render file, use the `promen_render_split_title()` function:

```php
// Render the split title
echo promen_render_split_title($widget, $settings, 'title', 'your-prefix');
```

Parameters:
- `$widget`: The widget instance
- `$settings`: The widget settings
- `$title_control_name`: Optional custom name for the title control (default: 'title')
- `$class_prefix`: Optional prefix for CSS classes (default: 'promen')

### Controls Added

#### Content Controls
The `promen_add_split_title_controls()` function adds the following controls:

1. `title` - Regular title field (shown when split_title is off)
2. `split_title` - Switcher to enable/disable split title
3. `title_part_1` - First part of the split title
4. `title_part_2` - Second part of the split title
5. `title_html_tag` - HTML tag selector for the title (h1-h6, div, span, p)

#### Style Controls
The `promen_add_split_title_style_controls()` function adds the following controls:

1. Typography and color controls for the regular title
2. Typography and color controls for the first part of the split title
3. Typography and color controls for the second part of the split title
4. Spacing control for the title
5. Alignment control for the title

### HTML Output

The rendered HTML will look like:

```html
<!-- When split_title is enabled -->
<h2 class="prefix-title prefix-split-title">
    <span class="prefix-title-part-1">First part</span>
    <span class="prefix-title-part-2">Second part</span>
</h2>

<!-- When split_title is disabled -->
<h2 class="prefix-title">Regular Title</h2>
```

### CSS Classes

The following CSS classes are added:

- `{prefix}-title` - Applied to all titles
- `{prefix}-split-title` - Applied only to split titles
- `{prefix}-title-part-1` - Applied to the first part of a split title
- `{prefix}-title-part-2` - Applied to the second part of a split title 