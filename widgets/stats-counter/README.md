# Stats Counter Widget - Accessibility Implementation

## Overview
The Stats Counter Widget has been fully updated to meet WCAG 2.2 accessibility standards, providing an inclusive experience for all users including those using assistive technologies.

## Accessibility Features Implemented

### 1. Semantic HTML Structure
- **Proper HTML5 elements**: Uses `<section>`, `<header>`, `<main>` for better document structure
- **Heading hierarchy**: Counter titles use `<h3>` for proper heading structure
- **List semantics**: Statistics are marked as `role="list"` and `role="listitem"`
- **Image semantics**: Counter circles use `role="img"` with descriptive labels

### 2. ARIA Implementation
- **ARIA labels**: All interactive elements have descriptive labels
- **ARIA live regions**: Screen reader announcements for counter changes
- **ARIA describedby**: Counter items are properly described
- **ARIA labelledby**: Counter items are properly labelled
- **ARIA live**: Counter numbers announce changes during animation

### 3. Keyboard Navigation
- **Arrow keys**: Left/Right arrows navigate between statistics
- **Home/End keys**: Jump to first/last statistic
- **Enter/Space**: Get detailed information about current statistic
- **Tab navigation**: Logical tab order through all interactive elements
- **Focus management**: Proper focus indicators and management

### 4. Screen Reader Support
- **Live announcements**: Counter animations are announced to screen readers
- **Descriptive labels**: All elements have meaningful labels
- **Context information**: Users know their position in the statistics
- **Progress announcements**: Milestone announcements during animations

### 5. Visual Accessibility
- **High contrast support**: Enhanced visibility in high contrast mode
- **Focus indicators**: Clear, high-contrast focus outlines (3:1 ratio minimum)
- **Color independence**: Information is not conveyed by color alone
- **Minimum touch targets**: 44px minimum for touch interactions
- **Text shadows**: Enhanced readability for counter numbers

### 6. Motion and Animation
- **Reduced motion support**: Respects `prefers-reduced-motion` setting
- **Pause on focus**: Animations pause when user focuses on statistics
- **Animation controls**: Users can disable animations if needed
- **Immediate values**: For reduced motion, shows final values immediately

## Files Modified/Created

### New Files
- `assets/js/accessibility.js` - Accessibility JavaScript module
- `assets/css/accessibility.css` - Accessibility-specific styles
- `README.md` - This documentation file

### Modified Files
- `stats-counter-widget.php` - Added accessibility dependencies
- `includes/controls/counter-controls.php` - Added accessibility controls
- `includes/render/counter-render.php` - Updated HTML structure and ARIA
- `assets/js/stats-counter.js` - Integrated accessibility module
- `assets/css/widgets/stats-counter.css` - Enhanced existing styles
- `includes/class-assets-manager.php` - Registered new accessibility assets

## Accessibility Controls

The widget now includes an "Accessibility" tab in the Elementor editor with the following controls:

1. **Statistics Label** - Custom label for screen readers
2. **Announce Counter Changes** - Toggle screen reader announcements
3. **Enable Keyboard Navigation** - Toggle keyboard support
4. **Pause Animation on Focus** - Pause animations when focused
5. **Respect Reduced Motion** - Honor user motion preferences

## WCAG 2.2 Compliance

### Level A Compliance ✅
- [x] Images have text alternatives
- [x] Content is accessible via keyboard
- [x] Page has proper headings and labels
- [x] Color is not the only visual means of conveying information

### Level AA Compliance ✅
- [x] Text has sufficient contrast (4.5:1 minimum)
- [x] Text can resize to 200% without assistive technology
- [x] Focus is visible and logical
- [x] Input errors are identified and described

### Level AAA Considerations ✅
- [x] Very high contrast ratios (7:1) for focus indicators
- [x] No flashing content
- [x] Consistent navigation and identification

## Testing Checklist

### Automated Testing
- [x] HTML validation
- [x] ARIA attribute validation
- [x] Color contrast testing
- [x] Keyboard navigation testing

### Manual Testing
- [x] Screen reader testing (NVDA, JAWS, VoiceOver)
- [x] Keyboard-only navigation
- [x] High contrast mode testing
- [x] Reduced motion testing
- [x] Mobile accessibility testing

## Browser Support
- Chrome 90+
- Firefox 88+
- Safari 14+
- Edge 90+
- Mobile browsers (iOS Safari, Chrome Mobile)

## Usage Notes

1. **Screen Readers**: The widget announces counter animations and provides context
2. **Keyboard Users**: Full keyboard navigation with arrow keys and shortcuts
3. **Touch Users**: Minimum 44px touch targets for all interactive elements
4. **Motion Sensitivity**: Automatically respects user motion preferences
5. **High Contrast**: Enhanced visibility in high contrast mode

## Animation Accessibility Features

### Screen Reader Announcements
- Animation start: "Animating [title] counter to [value]"
- Progress milestones: "[title] counter at 25%", "50%", "75%"
- Animation completion: "[title] counter completed at [value]"

### Keyboard Navigation
- **Arrow Keys**: Navigate between statistics
- **Enter/Space**: Get detailed information about current statistic
- **Home/End**: Jump to first/last statistic
- **Tab**: Navigate through all interactive elements

### Reduced Motion Support
- Automatically detects `prefers-reduced-motion` setting
- Disables all animations and transitions
- Shows final values immediately
- Maintains full functionality without motion

## Future Enhancements

Potential future improvements could include:
- Voice control integration
- Custom announcement text
- Advanced keyboard shortcuts
- Integration with assistive technology APIs
- Haptic feedback for mobile devices

## Support

For accessibility-related issues or questions, please refer to the WCAG 2.2 guidelines or contact the development team.
