

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