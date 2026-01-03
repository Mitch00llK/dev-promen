# News Posts Widget

A widget that displays posts from the "post" post type with featured images, titles, excerpts, and links.

## Features

- **Multiple Content Selection Methods:**
  - Automatic (Latest Posts) - Shows the most recent posts
  - By Taxonomy - Filter posts by specific taxonomy terms
  - Manual Selection - Choose specific posts manually

- **Dynamic Taxonomy Selection:**
  - Automatically loads taxonomies based on selected post type
  - Dynamic term loading based on selected taxonomy
  - Support for multiple post types: Posts, Succesvolle Verhalen, Vacatures

- **Responsive Grid Display:**
  - Displays a grid of posts with customizable number of columns for different devices
  - Adjustable columns for desktop, tablet, and mobile

- **Advanced Styling Options:**
  - Split title styling option
  - Header and footer buttons with customizable text, icons, and URLs
  - Customizable read more buttons for each post
  - Customizable colors, typography, and spacing

- **Mobile Slider:**
  - Optional mobile slider with Swiper.js
  - Multiple slider templates (default, cards, fade)
  - Configurable slider settings (navigation, pagination, autoplay, etc.)

- **Content Filtering:**
  - Frontend category filters for vacatures post type
  - Customizable filter button styling and layout

## Content Selection Methods

### Automatic Selection
- Displays the latest posts from the selected post type
- Configurable number of posts to display
- Sorting options: Date, Title, Menu Order, Random, Comment Count
- Order options: Ascending, Descending

### Taxonomy-Based Selection
- Select a specific taxonomy associated with the chosen post type
- Option to filter by specific terms within the taxonomy
- Leave terms empty to show all posts from the taxonomy
- Same sorting and ordering options as automatic selection

### Manual Selection
- Search and select specific posts individually
- Maintains the order of selection
- Perfect for curated content displays
- Posts are displayed in the order they were selected

## Post Type Support

The widget supports three post types out of the box:
- **News Posts (post)** - Standard WordPress posts
- **Succesvolle Verhalen** - Custom post type for success stories
- **Vacatures** - Custom post type for job listings

Each post type automatically displays its associated taxonomies for filtering.

## Structure

The widget is organized into the following files:

- `news-posts-widget.php`: Main widget class that registers the widget with Elementor
- `includes/controls/content-controls.php`: Content tab controls for the widget including new selection methods
- `includes/controls/style-controls.php`: Style tab controls for the widget
- `includes/controls/visibility-controls.php`: Responsive controls for the widget
- `includes/render/render-widget.php`: Main render logic for different content selection methods
- `includes/render/content-template.php`: Template for rendering individual post cards
- `includes/ajax-handlers.php`: AJAX handlers for dynamic content loading
- `assets/js/news-posts-admin.js`: Admin JavaScript for dynamic control updates

## Usage

The widget will be available in the Elementor editor under the "General" category with the name "Content Posts & Vacatures Grid".

### Setting up Automatic Selection
1. Choose your post type
2. Set content selection to "Automatic"
3. Configure number of posts and sorting options

### Setting up Taxonomy-Based Selection
1. Choose your post type
2. Set content selection to "By Taxonomy"
3. Select the desired taxonomy from the dropdown
4. Optionally select specific terms to filter by
5. Configure number of posts and sorting options

### Setting up Manual Selection
1. Choose your post type
2. Set content selection to "Manual Selection"
3. Search and select specific posts from the dropdown
4. Posts will display in the order selected

## Performance Considerations

- Manual post selection is limited to 50 posts for performance
- AJAX requests are used to dynamically load taxonomies and terms
- Proper caching is implemented for taxonomy and term queries
- Security nonces are used for all AJAX requests 