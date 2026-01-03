/**
 * Document Info List Widget Animations
 */
class DocumentInfoListAnimations {
    constructor(widgetId, animationType, staggerDelay) {
        this.widgetId = widgetId;
        this.animationType = animationType;
        this.staggerDelay = staggerDelay ? staggerDelay / 1000 : 0;

        // If widgetId is provided, find container by animation ID
        if (widgetId) {
            this.container = document.querySelector(`[data-animation-id="${this.widgetId}"]`);
        }

        // Initialize only if container exists and GSAP is loaded
        if (this.container && typeof gsap !== 'undefined') {
            this.init();
        }
    }

    init() {
        this.yearSections = this.container.querySelectorAll('.document-info-year-section');

        // Create master timeline
        this.masterTimeline = gsap.timeline({
            defaults: {
                ease: "power3.out",
                duration: 0.7
            }
        });

        this.setInitialState();
        this.buildTimeline();
        this.setupHoverEffects();

        // Skip animation in Elementor editor, otherwise play it
        if (!document.body.classList.contains('elementor-editor-active')) {
            this.playAnimation();
        } else {
            // Make sure elements are visible in the editor
            this.showElementsInEditor();
        }
    }

    setInitialState() {
        // Skip animation setup in Elementor editor
        if (document.body.classList.contains('elementor-editor-active')) {
            return;
        }

        // Set initial state for all elements to prevent FOUC (Flash of Unstyled Content)
        this.yearSections.forEach(section => {
            const yearTitle = section.querySelector('.document-info-year-title');
            const documentItems = section.querySelectorAll('.document-info-item');

            // Set title initial state
            gsap.set(yearTitle, {
                opacity: 0,
                y: this.animationType === 'slide-up' ? 30 : 0,
                x: this.animationType === 'slide-in' ? -40 : 0,
                scale: this.animationType === 'scale-in' ? 0.85 : 1,
                transformOrigin: 'left center'
            });

            // Set document items initial state
            gsap.set(documentItems, {
                opacity: 0,
                y: this.animationType === 'slide-up' ? 30 : 0,
                x: this.animationType === 'slide-in' ? -40 : 0,
                scale: this.animationType === 'scale-in' ? 0.9 : 1,
                transformOrigin: 'left center'
            });
        });
    }

    showElementsInEditor() {
        // Force all elements to be visible in the editor
        this.yearSections.forEach(section => {
            const yearTitle = section.querySelector('.document-info-year-title');
            const documentItems = section.querySelectorAll('.document-info-item');

            if (yearTitle) gsap.set(yearTitle, { opacity: 1, y: 0, x: 0, scale: 1 });
            if (documentItems.length) gsap.set(documentItems, { opacity: 1, y: 0, x: 0, scale: 1 });
        });
    }

    buildTimeline() {
        // Skip animation in Elementor editor
        if (document.body.classList.contains('elementor-editor-active')) {
            return;
        }

        // Build animation timeline with proper sequence
        this.yearSections.forEach((section, sectionIndex) => {
            const yearTitle = section.querySelector('.document-info-year-title');
            const documentItems = section.querySelectorAll('.document-info-item');

            // Create section timeline
            const sectionTimeline = gsap.timeline({
                defaults: {
                    ease: "power3.out",
                    force3D: true, // hardware acceleration
                    clearProps: "transform" // clean up after animation
                }
            });

            // Add year title animation with performance optimization
            sectionTimeline.to(yearTitle, {
                opacity: 1,
                y: 0,
                x: 0,
                scale: 1,
                duration: 0.7,
                onStart: () => gsap.set(yearTitle, { willChange: "transform, opacity" }),
                onComplete: () => gsap.set(yearTitle, { willChange: "auto" })
            });

            // Add staggered document items animation with improved timing and performance
            sectionTimeline.to(documentItems, {
                opacity: 1,
                y: 0,
                x: 0,
                scale: 1,
                stagger: {
                    amount: Math.min(documentItems.length * 0.15, 0.8), // cap at reasonable maximum
                    ease: "power1.inOut",
                    from: "start"
                },
                duration: 0.6,
                onStart: () => gsap.set(documentItems, { willChange: "transform, opacity" }),
                onComplete: () => gsap.set(documentItems, { willChange: "auto" })
            }, "-=0.4"); // slight overlap with title animation

            // Add section timeline to master with proper spacing between sections
            this.masterTimeline.add(sectionTimeline, sectionIndex * 0.15);
        });
    }

    setupHoverEffects() {
        // Get all document items for hover effects
        const documentItems = this.container.querySelectorAll('.document-info-item');

        // Setup hover animations for each item
        documentItems.forEach(item => {
            const downloadLink = item.querySelector('.document-info-download-link');

            // Setup download functionality for download links
            if (downloadLink) {
                setupDownloadHandler(downloadLink);
                return;
            }

            const title = item.querySelector('.document-info-document-title');
            const icon = item.querySelector('.document-info-icon');

            if (!title || !icon) return;

            // Create hover timeline (paused by default)
            const hoverTimeline = gsap.timeline({ paused: true });

            // Add subtle hover animations
            hoverTimeline
                .to(icon, {
                    scale: 1,
                    duration: 0.3,
                    ease: "power2.out"
                }, 0)
                .to(title, {
                    color: "", // Will use the CSS-defined hover color
                    duration: 0.3,
                    ease: "power2.out",
                    // Don't add underline animation here - let CSS handle it for better performance
                }, 0);

            // Setup mouse enter/leave events for icon and title animations
            item.addEventListener('mouseenter', () => hoverTimeline.play());
            item.addEventListener('mouseleave', () => hoverTimeline.reverse());
        });
    }



    playAnimation() {
        // Add a slight delay to ensure the page has loaded
        setTimeout(() => {
            this.masterTimeline.play();
        }, 100);
    }
}

// Initialize download handlers for all document info lists (even without animation)
function initializeDocumentInfoLists() {
    const containers = document.querySelectorAll('.document-info-list-container');

    containers.forEach(container => {
        const downloadLinks = container.querySelectorAll('.document-info-download-link');

        downloadLinks.forEach(downloadLink => {
            // Setup download handler directly
            setupDownloadHandler(downloadLink);
        });
    });
}

// Standalone download handler function
function setupDownloadHandler(downloadLink) {
    downloadLink.addEventListener('click', (e) => {
        e.preventDefault();

        const fileUrl = downloadLink.getAttribute('data-file-url');
        const fileName = downloadLink.getAttribute('data-file-name');
        const fileId = downloadLink.getAttribute('data-file-id');

        if (!fileUrl) {
            return;
        }

        downloadFile(fileUrl, fileName, fileId);
    });
}

function downloadFile(fileUrl, fileName, fileId) {
    // Direct download method
    const tempLink = document.createElement('a');
    tempLink.href = fileUrl;
    tempLink.download = fileName || 'download';
    tempLink.style.display = 'none';
    tempLink.target = '_blank';
    tempLink.rel = 'noopener noreferrer';

    document.body.appendChild(tempLink);
    tempLink.click();
    document.body.removeChild(tempLink);

    // Track download analytics
    trackDownload(fileName, fileUrl);
}





function ajaxDownload(fileId, fileName) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = window.promenAjaxUrl;
    form.style.display = 'none';

    const fields = {
        'action': 'promen_download_file',
        'file_id': fileId,
        'nonce': window.promenDownloadNonce
    };

    for (const [key, value] of Object.entries(fields)) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    }

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    // Track download analytics
    trackDownload(fileName, '');
}

function trackDownload(fileName, fileUrl) {
    // Track download analytics if available
    if (typeof gtag !== 'undefined') {
        gtag('event', 'file_download', {
            'file_name': fileName,
            'file_url': fileUrl
        });
    }

    // Track with other analytics if available
    if (typeof _gaq !== 'undefined') {
        _gaq.push(['_trackEvent', 'Download', 'File', fileName]);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize download handlers for all instances
    initializeDocumentInfoLists();
}, { passive: true });