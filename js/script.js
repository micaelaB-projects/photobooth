// Retro Photobooth - Multi-Step Workflow

// State variables
let stream = null;
let selectedLayout = 4;
let selectedFilter = 'retro';
let capturedPhotos = [];
let frameColor = '#1a1a1a';
let stripLayout = 'vertical';
let polaroidFrameColor = 'white';
let polaroidCaption = '';
let polaroidStyle = 'classic';

// DOM elements
let video, canvas, ctx;
let currentStep = 'layout';

// Initialize DOM elements after page loads
function initializeDOM() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    ctx = canvas && canvas.getContext('2d');
}

// Show/hide steps
function showStep(stepName) {
    document.querySelectorAll('.photobooth-step').forEach(step => {
        step.classList.remove('active');
    });
    document.getElementById('step' + stepName.charAt(0).toUpperCase() + stepName.slice(1)).classList.add('active');
    currentStep = stepName;
    window.scrollTo(0, 0);
    
    // Update step indicator
    updateStepIndicator(stepName);
}

// Update step indicator
function updateStepIndicator(stepName) {
    document.querySelectorAll('.step-indicator-item').forEach(item => {
        item.classList.remove('active', 'completed');
    });
    
    const stepMap = {
        'layout': 'stepIndicator1',
        'filters': 'stepIndicator2',
        'capture': 'stepIndicator3',
        'preview': 'stepIndicator4'
    };
    
    const currentStepIndex = Object.keys(stepMap).indexOf(stepName) + 1;
    
    // Mark completed steps
    for (let i = 1; i < currentStepIndex; i++) {
        const key = Object.keys(stepMap)[i - 1];
        document.getElementById(stepMap[key]).classList.add('completed');
    }
    
    // Mark current step
    document.getElementById(stepMap[stepName]).classList.add('active');
}

// STEP 1: Layout Selection
function selectLayout(count) {
    selectedLayout = count;
    document.querySelectorAll('.layout-option').forEach(opt => {
        opt.classList.remove('selected');
    });
    document.querySelector(`[data-layout="${count}"]`).classList.add('selected');
    updateStatus(`Layout selected: ${count} photos`);
}

function goToFilters() {
    showStep('filters');
}

// STEP 2: Filter Selection
function selectFilter(filterName) {
    selectedFilter = filterName;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-filter="${filterName}"]`).classList.add('active');
}

function goToLayout() {
    showStep('layout');
}

function goToCapture() {
    capturedPhotos = [];
    showStep('capture');
    updateCaptureUI();
    
    // Apply current filter to video preview
    applyVideoPreviewFilter(selectedFilter);
    
    // Close filter selector
    const filterSelector = document.getElementById('captureFilterSelector');
    if (filterSelector) {
        filterSelector.classList.add('hidden');
        const toggle = document.querySelector('.filter-display-toggle');
        if (toggle) toggle.style.transform = 'rotate(0deg)';
    }
}

// STEP 3: Capture Photos
function startCamera() {
    const btn = document.getElementById('startCameraBtn');
    btn.disabled = true;
    btn.textContent = 'Camera Starting...';
    
    navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: 'user',
            width: { ideal: 1280 },
            height: { ideal: 720 }
        },
        audio: false
    }).then(mediaStream => {
        stream = mediaStream;
        video.srcObject = stream;
        
        video.onloadedmetadata = () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Apply current filter to video preview
            setTimeout(() => applyVideoPreviewFilter(selectedFilter), 100);
            
            btn.style.display = 'none';
            document.getElementById('capturePhotoBtnMain').disabled = false;
            document.getElementById('retakeCaptureBtn').disabled = false;
            updateCaptureStatus('Camera ready! Click CAPTURE to start');
        };
    }).catch(error => {
        updateCaptureStatus('Error: ' + error.message);
        btn.disabled = false;
        btn.textContent = 'Start Camera';
    });
}

function capturePhoto() {
    if (!video || video.readyState !== video.HAVE_ENOUGH_DATA) {
        updateCaptureStatus('Camera not ready');
        return;
    }
    
    // Draw video to canvas
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
    
    // Apply filter
    applyFilter(ctx, canvas.width, canvas.height, selectedFilter);
    
    // Convert to blob
    canvas.toBlob((blob) => {
        capturedPhotos.push(blob);
        updateCaptureUI();
        
        if (capturedPhotos.length < selectedLayout) {
            updateCaptureStatus(`✨ Photo ${capturedPhotos.length} captured! Click CAPTURE again`);
        } else {
            updateCaptureStatus(`🎉 All ${selectedLayout} photos captured! Click Next to preview`);
            document.getElementById('capturePhotoBtnMain').disabled = true;
            document.getElementById('nextToPreviewBtn').disabled = false;
        }
    }, 'image/jpeg', 0.95);
}

function updateCaptureUI() {
    const count = capturedPhotos.length;
    document.getElementById('photoCounter').textContent = `Photo ${count + 1} of ${selectedLayout}`;
    document.getElementById('captureSubtitle').textContent = `Get ready to capture photo ${count + 1} of ${selectedLayout}`;
    document.getElementById('progressFill').style.width = (count / selectedLayout * 100) + '%';
    
    // Update filter display
    const filterNameMap = {
        'retro': 'RETRO CLASSIC',
        'sepia': 'SEPIA',
        'bw': 'B&W',
        'vaporwave': 'VAPORWAVE',
        'neon': 'NEON',
        'cool': 'COOL',
        'crowns': 'CROWN OF HEARTS',
        'mirror-normal': 'NORMAL',
        'mirror-left': 'LEFT MIRROR',
        'mirror-right': 'RIGHT MIRROR',
        'mirror-top': 'TOP MIRROR',
        'mirror-bottom': 'BOTTOM MIRROR',
        'mirror-quad': 'QUAD MIRROR',
        'mirror-upsidedown': 'UPSIDE-DOWN',
        'mirror-switch': 'SWITCH',
        'mirror-kaleidoscope': 'KALEIDOSCOPE'
    };
    const displayName = filterNameMap[selectedFilter] || selectedFilter.toUpperCase();
    document.getElementById('captureFilterName').textContent = displayName;
}

function retakePhotos() {
    capturedPhotos = [];
    updateCaptureUI();
    document.getElementById('capturePhotoBtnMain').disabled = false;
    document.getElementById('nextToPreviewBtn').disabled = true;
    updateCaptureStatus('Ready to capture again');
}

function goToPreview() {
    if (capturedPhotos.length < selectedLayout) {
        updateCaptureStatus('Not all photos captured yet');
        return;
    }
    
    // Reset video filter
    const video = document.getElementById('video');
    if (video) {
        video.style.filter = '';
    }
    
    // Stop camera stream
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    
    showStep('preview');
    displayPreviewStrip();
}

// Filter selector for capture phase
function toggleCaptureFilterSelector() {
    const selector = document.getElementById('captureFilterSelector');
    selector.classList.toggle('hidden');
    const toggle = document.querySelector('.filter-display-toggle');
    if (selector.classList.contains('hidden')) {
        toggle.style.transform = 'rotate(0deg)';
    } else {
        toggle.style.transform = 'rotate(180deg)';
    }
}

function changeCaptureFilter(filterName) {
    selectedFilter = filterName;
    
    // Update filter display name
    const filterNameMap = {
        'retro': 'RETRO CLASSIC',
        'sepia': 'SEPIA',
        'bw': 'B&W',
        'vaporwave': 'VAPORWAVE',
        'neon': 'NEON',
        'cool': 'COOL',
        'crowns': 'CROWN OF HEARTS',
        'mirror-normal': 'NORMAL',
        'mirror-left': 'LEFT MIRROR',
        'mirror-right': 'RIGHT MIRROR',
        'mirror-top': 'TOP MIRROR',
        'mirror-bottom': 'BOTTOM MIRROR',
        'mirror-quad': 'QUAD MIRROR',
        'mirror-upsidedown': 'UPSIDE-DOWN',
        'mirror-switch': 'SWITCH',
        'mirror-kaleidoscope': 'KALEIDOSCOPE'
    };
    const displayName = filterNameMap[filterName] || filterName.toUpperCase();
    document.getElementById('captureFilterName').textContent = displayName;
    
    // Update active button in selector
    document.querySelectorAll('.capture-filter-option').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-filter') === filterName) {
            btn.classList.add('active');
        }
    });
    
    // Close selector
    document.getElementById('captureFilterSelector').classList.add('hidden');
    document.querySelector('.filter-display-toggle').style.transform = 'rotate(0deg)';
    
    updateCaptureStatus(`Filter changed to ${displayName}`);
    
    // Apply CSS filter to video stream
    applyVideoPreviewFilter(filterName);
}

// Apply CSS filter to video element for real-time preview
function applyVideoPreviewFilter(filterName) {
    const video = document.getElementById('video');
    if (!video) return;
    
    let filterStyle = '';
    let transformStyle = '';
    
    switch(filterName) {
        case 'retro':
            filterStyle = 'saturate(1.3) hue-rotate(-5deg) brightness(1.05) contrast(1.1)';
            break;
        case 'sepia':
            filterStyle = 'sepia(0.8) saturate(0.8)';
            break;
        case 'bw':
            filterStyle = 'grayscale(1) contrast(1.2)';
            break;
        case 'vaporwave':
            filterStyle = 'saturate(1.8) hue-rotate(180deg) brightness(0.95) contrast(1.3)';
            break;
        case 'neon':
            filterStyle = 'saturate(2) contrast(1.5) brightness(1.1) hue-rotate(5deg)';
            break;
        case 'cool':
            filterStyle = 'saturate(0.7) hue-rotate(20deg) brightness(1.0) contrast(1.1)';
            break;
        case 'crowns':
            filterStyle = 'saturate(1.5) hue-rotate(-30deg) brightness(1.1) contrast(1.2) drop-shadow(0 0 30px rgba(255, 20, 147, 0.4))';
            break;
        // Mirror & Transform Filters
        case 'mirror-normal':
            transformStyle = 'scaleX(1) scaleY(1)';
            break;
        case 'mirror-left':
            transformStyle = 'scaleX(-1) scaleY(1)';
            break;
        case 'mirror-right':
            transformStyle = 'scaleX(-1) scaleY(1)';
            break;
        case 'mirror-top':
            transformStyle = 'scaleX(1) scaleY(-1)';
            break;
        case 'mirror-bottom':
            transformStyle = 'scaleX(1) scaleY(-1)';
            break;
        case 'mirror-quad':
            // Quad mirror uses clip-path with rotation
            video.style.clipPath = 'polygon(0% 0%, 25% 0%, 25% 25%, 50% 25%, 50% 0%, 75% 0%, 75% 25%, 100% 25%, 100% 50%, 75% 50%, 75% 75%, 100% 75%, 100% 100%, 75% 100%, 75% 75%, 50% 75%, 50% 100%, 25% 100%, 25% 75%, 0% 75%, 0% 100%, 0% 75%, 0% 50%, 25% 50%, 25% 25%, 0% 25%)';
            video.style.transform = 'scale(1)';
            return;
        case 'mirror-upsidedown':
            transformStyle = 'scaleY(-1)';
            break;
        case 'mirror-switch':
            transformStyle = 'rotate(180deg)';
            break;
        case 'mirror-kaleidoscope':
            // Kaleidoscope effect with multiple rotations
            video.style.clipPath = 'polygon(50% 0%, 100% 0%, 100% 50%, 50% 50%)';
            video.style.transform = 'rotate(0deg)';
            return;
        default:
            filterStyle = '';
    }
    
    video.style.filter = filterStyle;
    if (transformStyle) {
        video.style.transform = transformStyle;
    } else {
        video.style.transform = '';
    }
    video.style.clipPath = 'none';
}
function selectStripLayout(layoutType) {
    stripLayout = layoutType;
    document.querySelectorAll('.strip-layout-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-layout="${layoutType}"]`).classList.add('active');
    
    const previewStrip = document.getElementById('previewStrip');
    previewStrip.className = `preview-full-strip preview-${layoutType}`;    
    // Show/hide polaroid customization
    const polaroidCustomize = document.getElementById('polaroidCustomize');
    if (layoutType === 'polaroid') {
        polaroidCustomize.style.display = 'block';
    } else {
        polaroidCustomize.style.display = 'none';
    }
    displayPreviewStrip();
    updateStatus(`Strip layout changed to ${layoutType === 'vertical' ? 'Vertical' : layoutType === 'horizontal' ? 'Horizontal' : layoutType === 'grid2x2' ? '2x2 Grid' : layoutType === 'polaroid' ? 'Polaroid Wall' : 'Compact'}`);
}

function setPolaroidFrameColor(color) {
    polaroidFrameColor = color;
    document.querySelectorAll('.polaroid-color-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    if (event && event.target) {
        event.target.classList.add('active');
    }
    displayPreviewStrip();
}

function updatePolaroidCaption() {
    polaroidCaption = document.getElementById('polaroidCaption').value;
    displayPreviewStrip();
}

function setPolaroidStyle(style) {
    polaroidStyle = style;
    document.querySelectorAll('.polaroid-style-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    if (event && event.target) {
        event.target.classList.add('active');
    }
    displayPreviewStrip();
}

function displayPreviewStrip() {
    const previewStrip = document.getElementById('previewStrip');
    previewStrip.innerHTML = '';
    
    // Apply layout class
    previewStrip.className = `preview-full-strip preview-${stripLayout}`;
    previewStrip.style.borderColor = frameColor;
    
    if (stripLayout === 'polaroid') {
        // Polaroid wall with customization
        capturedPhotos.forEach((blob, index) => {
            const url = URL.createObjectURL(blob);
            
            // Create polaroid frame
            const polaroidFrame = document.createElement('div');
            polaroidFrame.className = 'polaroid-frame';
            polaroidFrame.style.backgroundColor = polaroidFrameColor;
            
            // Calculate rotation based on style
            let rotation = 0;
            if (polaroidStyle === 'classic') {
                rotation = (Math.random() - 0.5) * 6;
            } else if (polaroidStyle === 'scattered') {
                rotation = (Math.random() - 0.5) * 12;
            } else if (polaroidStyle === 'magazine') {
                rotation = 0;
            }
            
            polaroidFrame.style.transform = `rotate(${rotation}deg)`;
            
            // Photo container
            const photoDiv = document.createElement('div');
            photoDiv.className = 'preview-photo polaroid-photo';
            photoDiv.style.backgroundColor = polaroidFrameColor;
            
            const img = document.createElement('img');
            img.src = url;
            photoDiv.appendChild(img);
            
            // Caption
            const caption = document.createElement('div');
            caption.className = 'polaroid-caption';
            caption.textContent = polaroidCaption || '✨';
            
            polaroidFrame.appendChild(photoDiv);
            polaroidFrame.appendChild(caption);
            previewStrip.appendChild(polaroidFrame);
        });
    } else if (stripLayout === 'grid2x2') {
        // 2x2 Grid - show only first 4 photos
        const photosToShow = capturedPhotos.slice(0, 4);
        photosToShow.forEach((blob) => {
            const url = URL.createObjectURL(blob);
            const photoDiv = document.createElement('div');
            photoDiv.className = 'preview-photo';
            photoDiv.style.backgroundColor = frameColor;
            
            const img = document.createElement('img');
            img.src = url;
            photoDiv.appendChild(img);
            previewStrip.appendChild(photoDiv);
        });
    } else if (stripLayout === 'horizontal') {
        // Horizontal - show all photos in a row
        capturedPhotos.forEach((blob) => {
            const url = URL.createObjectURL(blob);
            const photoDiv = document.createElement('div');
            photoDiv.className = 'preview-photo';
            photoDiv.style.backgroundColor = frameColor;
            
            const img = document.createElement('img');
            img.src = url;
            photoDiv.appendChild(img);
            previewStrip.appendChild(photoDiv);
        });
    } else if (stripLayout === 'compact') {
        // Compact grid layout
        capturedPhotos.forEach((blob) => {
            const url = URL.createObjectURL(blob);
            const photoDiv = document.createElement('div');
            photoDiv.className = 'preview-photo';
            photoDiv.style.backgroundColor = frameColor;
            
            const img = document.createElement('img');
            img.src = url;
            photoDiv.appendChild(img);
            previewStrip.appendChild(photoDiv);
        });
    } else {
        // Vertical - default, show all photos stacked
        capturedPhotos.forEach((blob) => {
            const url = URL.createObjectURL(blob);
            const photoDiv = document.createElement('div');
            photoDiv.className = 'preview-photo';
            photoDiv.style.backgroundColor = frameColor;
            
            const img = document.createElement('img');
            img.src = url;
            photoDiv.appendChild(img);
            previewStrip.appendChild(photoDiv);
        });
    }
}

function setFrameColor(color) {
    frameColor = color;
    document.querySelectorAll('.color-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    if (event && event.target) {
        event.target.classList.add('active');
    }
    displayPreviewStrip();
}

async function downloadStrip() {
    if (capturedPhotos.length === 0) {
        updateStatus('No photos to download');
        return;
    }
    
    try {
        updateStatus('Creating professional strip...');
        
        const stripCanvas = document.createElement('canvas');
        const stripCtx = stripCanvas.getContext('2d');
        const photoSize = 450;
        const padding = 35;
        const frameWidth = 12;
        const gapSize = 10;
        const headerFooterHeight = 70;
        const borderInnerWidth = 6;
        
        let width, height;
        let photosToRender = capturedPhotos;
        let cols = 1;
        let rows = capturedPhotos.length;
        
        // Calculate dimensions based on layout
        switch(stripLayout) {
            case 'horizontal':
                cols = capturedPhotos.length;
                rows = 1;
                width = (photoSize * cols) + (gapSize * (cols - 1)) + (padding * 2) + (frameWidth * 2);
                height = photoSize + (padding * 2) + (frameWidth * 2) + headerFooterHeight;
                break;
            case 'grid2x2':
                cols = 2;
                rows = 2;
                photosToRender = capturedPhotos.slice(0, 4);
                width = (photoSize * cols) + (gapSize * (cols - 1)) + (padding * 2) + (frameWidth * 2);
                height = (photoSize * rows) + (gapSize * (rows - 1)) + (padding * 2) + (frameWidth * 2) + headerFooterHeight;
                break;
            case 'compact':
                cols = Math.min(3, Math.ceil(Math.sqrt(capturedPhotos.length)));
                rows = Math.ceil(capturedPhotos.length / cols);
                width = (photoSize * cols) + (gapSize * (cols - 1)) + (padding * 2) + (frameWidth * 2);
                height = (photoSize * rows) + (gapSize * (rows - 1)) + (padding * 2) + (frameWidth * 2) + headerFooterHeight;
                break;
            case 'polaroid':
                cols = Math.min(3, capturedPhotos.length);
                rows = Math.ceil(capturedPhotos.length / 3);
                width = (photoSize + 90) * cols + (padding * 2);
                height = (photoSize + 130) * rows + (padding * 2) + headerFooterHeight;
                break;
            default: // vertical
                cols = 1;
                rows = capturedPhotos.length;
                width = photoSize + (padding * 2) + (frameWidth * 2);
                height = (photoSize * rows) + (gapSize * (rows - 1)) + (padding * 2) + (frameWidth * 2) + headerFooterHeight;
        }
        
        stripCanvas.width = width;
        stripCanvas.height = height;
        
        // Background gradient - darker to lighter
        const bgGradient = stripCtx.createLinearGradient(0, 0, 0, height);
        bgGradient.addColorStop(0, '#0a0a0a');
        bgGradient.addColorStop(1, '#1a1a1a');
        stripCtx.fillStyle = bgGradient;
        stripCtx.fillRect(0, 0, width, height);
        
        // Outer decorative frame (bright green - Game Boy style)
        stripCtx.fillStyle = '#8bac0f';
        stripCtx.fillRect(0, 0, width, frameWidth);
        stripCtx.fillRect(0, height - frameWidth, width, frameWidth);
        stripCtx.fillRect(0, 0, frameWidth, height);
        stripCtx.fillRect(width - frameWidth, 0, frameWidth, height);
        
        // Inner border (lighter green accent)
        stripCtx.strokeStyle = '#9bbc0f';
        stripCtx.lineWidth = borderInnerWidth;
        stripCtx.strokeRect(frameWidth + 2, frameWidth + 2, width - (frameWidth * 2) - 4, height - (frameWidth * 2) - 4);
        
        // Header with branding
        const headerY = frameWidth + padding;
        stripCtx.fillStyle = 'rgba(155, 188, 15, 0.3)';
        stripCtx.fillRect(frameWidth + padding, frameWidth + padding, width - (frameWidth * 2) - (padding * 2), 50);
        
        // Branding text
        stripCtx.fillStyle = '#ffd700';
        stripCtx.font = 'bold 24px Arial';
        stripCtx.textAlign = 'center';
        stripCtx.fillText('✨ RETRO PHOTOBOOTH ✨', width / 2, headerY + 35);
        
        // Content area start
        let contentY = frameWidth + padding + headerFooterHeight;
        let contentX = frameWidth + padding;
        
        // Draw photos based on layout
        const imagePromises = [];
        for (let i = 0; i < photosToRender.length; i++) {
            imagePromises.push(new Promise((resolve) => {
                const url = URL.createObjectURL(photosToRender[i]);
                const img = new Image();
                img.onload = () => {
                    let x, y;
                    
                    if (stripLayout === 'polaroid') {
                        const polCols = 3;
                        const photoWithFrame = photoSize + 90;
                        const photoWithFrameH = photoSize + 130;
                        x = padding + (i % polCols) * photoWithFrame + 45;
                        y = contentY + Math.floor(i / polCols) * photoWithFrameH + 65;
                        
                        // Draw polaroid frame with style
                        stripCtx.fillStyle = polaroidFrameColor || '#ffffff';
                        stripCtx.fillRect(x - 45, y - 65, photoSize + 90, photoSize + 130);
                        
                        // Polaroid shadow
                        stripCtx.fillStyle = 'rgba(0, 0, 0, 0.35)';
                        stripCtx.fillRect(x - 40, y + photoSize - 40, photoSize + 80, 10);
                        
                        // Draw photo
                        stripCtx.drawImage(img, x, y, photoSize, photoSize);
                        
                        // Polaroid caption area
                        stripCtx.fillStyle = '#999';
                        stripCtx.font = '12px Arial';
                        stripCtx.textAlign = 'center';
                        stripCtx.fillText(polaroidCaption || '✨', x + photoSize / 2, y + photoSize + 45);
                    } else {
                        // Grid-based layouts
                        const row = Math.floor(i / cols);
                        const col = i % cols;
                        
                        x = contentX + (col * (photoSize + gapSize));
                        y = contentY + (row * (photoSize + gapSize));
                        
                        // Draw photo with frame border
                        // Outer photo frame with shadow effect
                        stripCtx.fillStyle = 'rgba(0, 0, 0, 0.4)';
                        stripCtx.fillRect(x - 2, y - 2, photoSize + 4, photoSize + 4);
                        
                        // Photo border (bright green)
                        stripCtx.fillStyle = '#8bac0f';
                        stripCtx.fillRect(x - 4, y - 4, photoSize + 8, photoSize + 8);
                        
                        // Draw actual photo
                        stripCtx.drawImage(img, x, y, photoSize, photoSize);
                    }
                    
                    resolve();
                };
                img.src = url;
            }));
        }
        
        await Promise.all(imagePromises);
        
        // Footer with date
        const footerY = height - frameWidth - padding - 8;
        stripCtx.fillStyle = 'rgba(155, 188, 15, 0.3)';
        stripCtx.fillRect(frameWidth + padding, height - frameWidth - padding - 30 - 8, width - (frameWidth * 2) - (padding * 2), 40);
        
        stripCtx.fillStyle = '#9bbc0f';
        stripCtx.font = '13px Arial';
        stripCtx.textAlign = 'center';
        const now = new Date();
        const dateStr = now.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        stripCtx.fillText(`${dateStr} • ${cols}${rows > 1 ? 'x' + rows : ''} Layout • Memories Captured`, width / 2, footerY);
        
        // Download with higher quality
        stripCanvas.toBlob((blob) => {
            const url = URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = url;
            link.download = `photobooth-${stripLayout}-${new Date().getTime()}.jpg`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
            
            // Save to gallery
            saveStripToGallery(blob);
            updateStatus('✨ Professional strip downloaded! Saving to gallery...');
        }, 'image/jpeg', 0.98);
        
    } catch (error) {
        console.error('Error:', error);
        updateStatus('Error creating strip');
    }
}

async function saveStripToGallery(blob) {
    try {
        const formData = new FormData();
        formData.append('photo', blob, `photobooth-strip-${new Date().getTime()}.jpg`);
        
        const response = await fetch('api.php?action=save', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        if (data.success) {
            loadGallery();
            updateStatus('Strip saved to gallery!');
        }
    } catch (error) {
        console.error('Error saving strip:', error);
    }
}

function printStrip() {
    try {
        updateStatus('Preparing print...');
        
        const printWindow = window.open('', '_blank');
        let htmlContent = `
            <!DOCTYPE html>
            <html>
            <head>
                <title>Photo Strip Print</title>
                <style>
                    * { margin: 0; padding: 0; }
                    body { 
                        font-family: Arial, sans-serif; 
                        display: flex; 
                        justify-content: center; 
                        align-items: center; 
                        min-height: 100vh; 
                        background: #f0f0f0; 
                    }
                    .print-container { 
                        background: white; 
                        padding: 30px; 
                        border: 5px solid #000; 
                    }
                    .strip { 
                        width: 400px; 
                        border: 3px solid #ffd700; 
                        background: ` + frameColor + `; 
                    }
                    .photo { 
                        width: 100%; 
                        height: 400px; 
                        object-fit: cover; 
                        display: block; 
                        border-bottom: 2px solid #ff1493; 
                    }
                    .photo:last-child { border-bottom: none; }
                    .branding {
                        text-align: center;
                        font-size: 20px;
                        font-weight: bold;
                        margin-top: 20px;
                        color: #ffd700;
                    }
                    @media print { body { background: white; } }
                </style>
            </head>
            <body>
                <div class="print-container">
                    <div class="strip">
        `;
        
        capturedPhotos.forEach((blob) => {
            const url = URL.createObjectURL(blob);
            htmlContent += `<img src="${url}" class="photo" alt="photo">`;
        });
        
        htmlContent += `
                    </div>
                    <div class="branding">✨ RETRO PHOTOBOOTH ✨</div>
                </div>
            </body>
            </html>
        `;
        
        printWindow.document.write(htmlContent);
        printWindow.document.close();
        
        setTimeout(() => {
            printWindow.print();
        }, 1500);
        
        updateStatus('Print dialog opened');
        
    } catch (error) {
        console.error('Error:', error);
        updateStatus('Error preparing print');
    }
}

function startOver() {
    // Stop camera
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
    
    capturedPhotos = [];
    selectedLayout = 4;
    selectedFilter = 'retro';
    frameColor = '#1a1a1a';
    
    showStep('layout');
    updateStatus('Start a new session!');
}

// Gallery functions
async function loadGallery() {
    try {
        const response = await fetch('api.php?action=list');
        const data = await response.json();
        const gallery = document.getElementById('gallery');
        
        if (data.success && data.photos && data.photos.length > 0) {
            gallery.innerHTML = '';
            
            data.photos.forEach(photo => {
                const item = document.createElement('div');
                item.className = 'gallery-item';
                
                const img = document.createElement('img');
                img.src = `uploads/${photo.filename}`;
                img.alt = photo.original_name || 'Gallery photo';
                
                const actions = document.createElement('div');
                actions.className = 'gallery-item-actions';
                
                const downloadBtn = document.createElement('button');
                downloadBtn.className = 'gallery-item-btn download';
                downloadBtn.textContent = '⬇️ Download';
                downloadBtn.onclick = (e) => {
                    e.stopPropagation();
                    downloadGalleryPhoto(photo.filename);
                };
                
                const deleteBtn = document.createElement('button');
                deleteBtn.className = 'gallery-item-btn delete';
                deleteBtn.textContent = '🗑️ Delete';
                deleteBtn.onclick = (e) => {
                    e.stopPropagation();
                    deletePhoto(photo.filename);
                };
                
                actions.appendChild(downloadBtn);
                actions.appendChild(deleteBtn);
                item.appendChild(img);
                item.appendChild(actions);
                gallery.appendChild(item);
            });
        } else {
            gallery.innerHTML = '<p class="empty-message">No memories captured yet...</p>';
        }
    } catch (error) {
        console.error('Error loading gallery:', error);
    }
}

function downloadGalleryPhoto(filename) {
    const link = document.createElement('a');
    link.href = `uploads/${filename}`;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

async function deletePhoto(filename) {
    if (!confirm('Are you sure you want to delete this photo?')) {
        return;
    }
    
    try {
        await fetch(`api.php?action=delete&filename=${filename}`);
        loadGallery();
        updateStatus('Photo deleted');
    } catch (error) {
        console.error('Error deleting photo:', error);
    }
}

function updateStatus(message) {
    const statusEl = document.getElementById('status');
    if (statusEl) {
        statusEl.textContent = message;
        statusEl.className = 'status-message success';
    }
}

function updateCaptureStatus(message) {
    const el = document.getElementById('captureStatus');
    if (el) el.textContent = message;
}

/**
 * FILTER FUNCTIONS
 */

function applyFilter(ctx, width, height, filterType) {
    switch(filterType) {
        case 'retro':
            applyRetroFilter(ctx, width, height);
            break;
        case 'sepia':
            applySepiaFilter(ctx, width, height);
            break;
        case 'bw':
            applyBlackWhiteFilter(ctx, width, height);
            break;
        case 'vaporwave':
            applyVaporwaveFilter(ctx, width, height);
            break;
        case 'neon':
            applyNeonFilter(ctx, width, height);
            break;
        case 'cool':
            applyCoolFilter(ctx, width, height);
            break;
        case 'crowns':
            applyCrownsFilter(ctx, width, height);
            break;
        case 'mirror-normal':
            // No transformation needed
            applyRetroFilter(ctx, width, height);
            break;
        case 'mirror-left':
            applyHorizontalFlip(ctx, width, height);
            applyRetroFilter(ctx, width, height);
            break;
        case 'mirror-right':
            applyHorizontalFlip(ctx, width, height);
            applyRetroFilter(ctx, width, height);
            break;
        case 'mirror-top':
            applyVerticalFlip(ctx, width, height);
            applyRetroFilter(ctx, width, height);
            break;
        case 'mirror-bottom':
            applyVerticalFlip(ctx, width, height);
            applyRetroFilter(ctx, width, height);
            break;
        case 'mirror-quad':
            applyQuadMirror(ctx, width, height);
            applyRetroFilter(ctx, width, height);
            break;
        case 'mirror-upsidedown':
            applyVerticalFlip(ctx, width, height);
            applyRetroFilter(ctx, width, height);
            break;
        case 'mirror-switch':
            applyRotate180(ctx, width, height);
            applyRetroFilter(ctx, width, height);
            break;
        case 'mirror-kaleidoscope':
            applyKaleidoscope(ctx, width, height);
            applyRetroFilter(ctx, width, height);
            break;
        default:
            applyRetroFilter(ctx, width, height);
    }
}

// Mirror transform functions
function applyHorizontalFlip(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    ctx.clearRect(0, 0, width, height);
    ctx.save();
    ctx.scale(-1, 1);
    ctx.translate(-width, 0);
    ctx.putImageData(imageData, 0, 0);
    ctx.restore();
}

function applyVerticalFlip(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    ctx.clearRect(0, 0, width, height);
    ctx.save();
    ctx.scale(1, -1);
    ctx.translate(0, -height);
    ctx.putImageData(imageData, 0, 0);
    ctx.restore();
}

function applyRotate180(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    ctx.clearRect(0, 0, width, height);
    ctx.save();
    ctx.translate(width / 2, height / 2);
    ctx.rotate(Math.PI);
    ctx.translate(-width / 2, -height / 2);
    ctx.putImageData(imageData, 0, 0);
    ctx.restore();
}

function applyQuadMirror(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    // Create 4 mirrored quadrants of the original image
    ctx.clearRect(0, 0, width, height);
    
    // Quadrant 1: Normal
    ctx.putImageData(imageData, 0, 0);
    
    // Quadrant 2: H-flip
    ctx.save();
    ctx.scale(-1, 1);
    ctx.translate(-width / 2, 0);
    ctx.putImageData(imageData, width / 2, 0);
    ctx.restore();
}

function applyKaleidoscope(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width / 2, height / 2);
    const data = imageData.data;
    
    // Mirror to create kaleidoscope effect
    ctx.clearRect(0, 0, width, height);
    ctx.putImageData(imageData, 0, 0);
    
    ctx.save();
    // Top-right (horizontal flip)
    ctx.scale(-1, 1);
    ctx.putImageData(imageData, -width, 0);
    
    // Bottom-left (vertical flip)  
    ctx.scale(1, -1);
    ctx.putImageData(imageData, 0, -height);
    
    // Bottom-right (both flips)
    ctx.scale(-1, 1);
    ctx.putImageData(imageData, -width, -height);
    ctx.restore();
}

function applyRetroFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        
        const lum = 0.299 * r + 0.587 * g + 0.114 * b;
        const saturation = 1.3;
        
        data[i] = Math.min(255, r + (r - lum) * saturation);
        data[i + 1] = Math.min(255, g + (g - lum) * saturation);
        data[i + 2] = Math.min(255, b + (b - lum) * saturation);
        
        data[i] = Math.min(255, data[i] * 1.1);
        data[i + 1] = Math.min(255, data[i + 1] * 1.05);
        data[i + 2] = Math.max(0, data[i + 2] * 0.85);
    }
    
    ctx.putImageData(imageData, 0, 0);
    addFilmGrain(ctx, width, height);
    addLightLeak(ctx, width, height);
    addVignette(ctx, width, height);
}

function applySepiaFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        
        data[i] = Math.min(255, r * 0.393 + g * 0.769 + b * 0.189);
        data[i + 1] = Math.min(255, r * 0.349 + g * 0.686 + b * 0.168);
        data[i + 2] = Math.min(255, r * 0.272 + g * 0.534 + b * 0.131);
    }
    
    ctx.putImageData(imageData, 0, 0);
    addFilmGrain(ctx, width, height);
    addVignette(ctx, width, height);
}

function applyBlackWhiteFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        const gray = 0.299 * r + 0.587 * g + 0.114 * b;
        
        data[i] = gray;
        data[i + 1] = gray;
        data[i + 2] = gray;
    }
    
    ctx.putImageData(imageData, 0, 0);
    addFilmGrain(ctx, width, height);
    addVignette(ctx, width, height);
}

function applyVaporwaveFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        const lum = 0.299 * r + 0.587 * g + 0.114 * b;
        
        data[i] = lum * 0.7 + r * 0.3;
        data[i + 1] = lum * 0.5 + g * 0.5;
        data[i + 2] = lum * 0.3 + b * 0.7;
        
        const shift = Math.sin(i / 100) * 20;
        data[i] = Math.min(255, data[i] + shift * 1.5);
        data[i + 2] = Math.min(255, data[i + 2] + shift);
    }
    
    ctx.putImageData(imageData, 0, 0);
    addFilmGrain(ctx, width, height);
}

function applyNeonFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        const lum = 0.299 * r + 0.587 * g + 0.114 * b;
        const saturation = 2.5;
        
        data[i] = Math.min(255, r + (r - lum) * saturation);
        data[i + 1] = Math.min(255, g + (g - lum) * saturation);
        data[i + 2] = Math.min(255, b + (b - lum) * saturation);
    }
    
    ctx.putImageData(imageData, 0, 0);
    addVignette(ctx, width, height);
}

function applyCoolFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        
        data[i] = Math.max(0, r * 0.85);
        data[i + 1] = Math.min(255, g * 1.05);
        data[i + 2] = Math.min(255, b * 1.25);
    }
    
    ctx.putImageData(imageData, 0, 0);
    addFilmGrain(ctx, width, height);
    addVignette(ctx, width, height);
}

function applyCrownsFilter(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    
    // Crown of Hearts: Enhanced pinks/magentas with heart-like color scheme
    for (let i = 0; i < data.length; i += 4) {
        const r = data[i];
        const g = data[i + 1];
        const b = data[i + 2];
        
        // Boost reds and purples
        data[i] = Math.min(255, r * 1.25);
        data[i + 1] = Math.min(255, g * 0.8);
        data[i + 2] = Math.min(255, b * 1.15);
        
        // Increase saturation
        const max = Math.max(data[i], data[i + 1], data[i + 2]);
        const min = Math.min(data[i], data[i + 1], data[i + 2]);
        if (max > 0) {
            const l = (max + min) / 2;
            const s = (max - min) / (max + min <= 127.5 ? max + min : 510 - max - min);
            data[i] = Math.min(255, Math.max(0, data[i] + (data[i] - l) * 0.3));
            data[i + 1] = Math.min(255, Math.max(0, data[i + 1] + (data[i + 1] - l) * 0.3));
            data[i + 2] = Math.min(255, Math.max(0, data[i + 2] + (data[i + 2] - l) * 0.3));
        }
    }
    
    ctx.putImageData(imageData, 0, 0);
    addFilmGrain(ctx, width, height);
    addVignette(ctx, width, height);
}

function addFilmGrain(ctx, width, height) {
    const imageData = ctx.getImageData(0, 0, width, height);
    const data = imageData.data;
    const grainIntensity = 25;
    
    for (let i = 0; i < data.length; i += 4) {
        const noise = (Math.random() - 0.5) * grainIntensity;
        data[i] = Math.max(0, Math.min(255, data[i] + noise));
        data[i + 1] = Math.max(0, Math.min(255, data[i + 1] + noise));
        data[i + 2] = Math.max(0, Math.min(255, data[i + 2] + noise));
    }
    
    ctx.putImageData(imageData, 0, 0);
}

function addLightLeak(ctx, width, height) {
    const leakTypes = [
        { color: 'rgba(255, 100, 50, 0.15)', x: 0, y: 0 },
        { color: 'rgba(255, 200, 0, 0.12)', x: width, y: 0 },
        { color: 'rgba(255, 50, 150, 0.1)', x: 0, y: height },
        { color: 'rgba(0, 255, 150, 0.1)', x: width, y: height },
    ];
    
    const leak = leakTypes[Math.floor(Math.random() * leakTypes.length)];
    const leakGradient = ctx.createRadialGradient(leak.x, leak.y, 0, leak.x, leak.y, Math.max(width, height) * 0.8);
    leakGradient.addColorStop(0, leak.color);
    leakGradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
    
    ctx.fillStyle = leakGradient;
    ctx.fillRect(0, 0, width, height);
}

function addVignette(ctx, width, height) {
    const vignetteGradient = ctx.createRadialGradient(width / 2, height / 2, 0, width / 2, height / 2, Math.sqrt(width * width + height * height) / 2);
    vignetteGradient.addColorStop(0, 'rgba(0, 0, 0, 0)');
    vignetteGradient.addColorStop(0.7, 'rgba(0, 0, 0, 0.1)');
    vignetteGradient.addColorStop(1, 'rgba(0, 0, 0, 0.4)');
    
    ctx.fillStyle = vignetteGradient;
    ctx.fillRect(0, 0, width, height);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    initializeDOM();
    loadGallery();
    updateStatus('Welcome to Retro Photobooth! Select your layout to begin');
});
