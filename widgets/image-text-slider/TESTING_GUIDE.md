# Image Text Slider - Mobile Performance Testing Guide

## Quick Performance Test

To test if the mobile optimizations are working effectively, follow these steps:

### 1. Check Mobile Detection
Open browser dev tools and add this to console:
```javascript
// Check if mobile optimizations are active
console.log('Mobile detected:', window.innerWidth <= 768);
console.log('Slider instances:', window.imageTextSliderInstances);
```

### 2. Verify CSS Classes
Check if mobile-optimized class is applied:
```javascript
document.querySelectorAll('.image-text-slider-container').forEach(slider => {
    console.log('Slider ID:', slider.id);
    console.log('Has mobile-optimized class:', slider.classList.contains('mobile-optimized'));
});
```

### 3. Performance Monitoring
Monitor the performance optimizations:
```javascript
// Check instance tracking
if (window.imageTextSliderInstances) {
    window.imageTextSliderInstances.forEach((instance, id) => {
        console.log(`Slider ${id}:`, {
            isMobile: instance.isMobile,
            isLowEnd: instance.isLowEnd,
            hasSwiper: !!instance.swiper,
            hasContentSwiper: !!instance.contentSwiper,
            autoplayActive: instance.swiper?.autoplay?.running
        });
    });
}
```

### 4. Test Mobile vs Desktop Behavior

#### On Mobile (≤768px width):
- ✅ GSAP animations should be **disabled**
- ✅ Observers should be **disabled**
- ✅ Touch ratio should be **1.2**
- ✅ Autoplay pauses when **out of viewport**

#### On Desktop (>768px width):
- ✅ GSAP animations should be **enabled**
- ✅ All observers should be **active**
- ✅ Full feature set available

### 5. Network Performance Test

Use Chrome DevTools Performance tab:
1. Open Performance tab
2. Start recording
3. Interact with slider (swipe/click)
4. Stop recording
5. Look for:
   - Reduced main thread activity on mobile
   - Fewer layout recalculations
   - Smooth 60fps transitions

### 6. Multiple Sliders Test

If you have multiple sliders on the page:
```javascript
// Count active sliders
const sliderCount = document.querySelectorAll('.image-text-slider-container').length;
console.log(`Found ${sliderCount} sliders on page`);

// Check if performance monitoring is working
setTimeout(() => {
    console.log('Performance monitoring active:', 
        window.imageTextSliderInstances.size === sliderCount);
}, 3000);
```

## Expected Results

### Mobile Performance Improvements:
- ⚡ **50-70% reduction** in JavaScript execution time
- ⚡ **Faster slide transitions** (300ms vs 500ms)
- ⚡ **Reduced memory usage** from disabled observers
- ⚡ **Better touch responsiveness** with optimized touch settings
- ⚡ **Automatic autoplay management** based on visibility

### Visual Optimizations:
- 🎨 **Simplified animations** on mobile
- 🎨 **Reduced visual effects** for performance
- 🎨 **Better touch targets** (48px minimum)
- 🎨 **Respect for reduced motion preferences**

## Troubleshooting

### If slider is still laggy:
1. Check console for JavaScript errors
2. Verify mobile CSS is loading: `plugins/promen-elementor-widgets/widgets/image-text-slider/assets/mobile-optimizations.css`
3. Ensure WordPress `wp_is_mobile()` is working correctly
4. Test with single slider first, then multiple

### If autoplay isn't pausing out of viewport:
```javascript
// Manually test visibility detection
window.imageTextSliderInstances.forEach((instance) => {
    const rect = instance.element.getBoundingClientRect();
    const isVisible = rect.top < window.innerHeight && rect.bottom > 0;
    console.log('Slider visible:', isVisible);
});
```

## Browser Compatibility

✅ **Optimized for:**
- iOS Safari 12+
- Chrome Mobile 80+
- Samsung Internet 12+
- Firefox Mobile 80+

⚠️ **Fallback behavior for:**
- Older Android browsers
- Internet Explorer (basic functionality)

## Performance Benchmarks

Target metrics on mobile devices:
- **First Contentful Paint:** <2s
- **Largest Contentful Paint:** <3s
- **Cumulative Layout Shift:** <0.1
- **Time to Interactive:** <3s 