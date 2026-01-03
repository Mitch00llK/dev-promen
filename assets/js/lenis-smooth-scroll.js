// Lenis Smooth Scroll Implementation
document.addEventListener('DOMContentLoaded', () => {
    // Get settings from WordPress
    const settings = window.lenisSettings || {
        enable_lenis: true,
        scroll_duration: 1.2,
        scroll_easing: 'ease-out-expo',
        mouse_multiplier: 1,
        touch_multiplier: 2
    };

    // Check if Lenis is enabled
    if (!settings.enable_lenis) {
        return;
    }

    // Initialize Lenis for smooth scrolling
    const lenis = new Lenis({
        duration: parseFloat(settings.scroll_duration), // Scroll animation duration (in seconds)
        easing: (t) => {
            switch (settings.scroll_easing) {
                case 'linear':
                    return t;
                case 'ease-out-quad':
                    return t * (2 - t);
                case 'ease-out-cubic':
                    return 1 - Math.pow(1 - t, 3);
                case 'ease-out-expo':
                default:
                    return Math.min(1, 1.001 - Math.pow(2, -10 * t));
            }
        },
        direction: 'vertical', // Vertical scroll
        gestureDirection: 'vertical', // Vertical gestures
        smooth: true, // Enable smooth scrolling
        mouseMultiplier: parseFloat(settings.mouse_multiplier), // Mouse wheel multiplier
        smoothTouch: false, // Disable smooth scrolling on touch devices
        touchMultiplier: parseFloat(settings.touch_multiplier), // Touch multiplier
        infinite: false, // No infinite scrolling
    });

    // Make lenis available globally
    window.lenis = lenis;

    // Dispatch a custom event when Lenis is initialized
    document.dispatchEvent(new CustomEvent('lenis:init', { detail: { lenis } }));

    // Get scroll
    function raf(time) {
        lenis.raf(time);
        requestAnimationFrame(raf);
    }

    // Start the animation frame loop
    requestAnimationFrame(raf);

    // GSAP ScrollTrigger integration (if GSAP is available)
    if (typeof ScrollTrigger !== 'undefined') {
        // Connect Lenis to ScrollTrigger for smooth scrubbing
        lenis.on('scroll', ScrollTrigger.update);

        // Update ScrollTrigger and disable during Lenis smooth scrolling
        ScrollTrigger.scrollerProxy(document.body, {
            scrollTop(value) {
                if (arguments.length) {
                    lenis.scrollTo(value);
                }
                return lenis.scroll;
            },
            getBoundingClientRect() {
                return {
                    top: 0,
                    left: 0,
                    width: window.innerWidth,
                    height: window.innerHeight
                };
            },
            pinType: document.body.style.transform ? "transform" : "fixed"
        });

        // Update ScrollTrigger when window resizes
        ScrollTrigger.addEventListener('refresh', () => lenis.resize());

        // Refresh ScrollTrigger to ensure everything is in sync
        ScrollTrigger.refresh();
    }

    // Add accessibility option to disable smooth scrolling (optional)
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (prefersReducedMotion.matches) {
        lenis.destroy();
    }
});