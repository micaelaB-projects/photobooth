<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retro Photobooth 📸 - 70s-90s Vibes</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/theme-crown-of-hearts.css">
</head>
<body>
    <div class="container">
        <div class="photobooth">
            <h1>✨ RETRO PHOTOBOOTH ✨</h1>
            <p style="text-align: center; color: #ff1493; font-weight: 900; margin-bottom: 15px; letter-spacing: 1px;">~ 70s • 80s • 90s VIBES ~</p>
            
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step-indicator-item active" id="stepIndicator1">
                    <div class="step-indicator-circle">1</div>
                    <div class="step-indicator-label">Layout</div>
                </div>
                <div class="step-indicator-connector"></div>
                <div class="step-indicator-item" id="stepIndicator2">
                    <div class="step-indicator-circle">2</div>
                    <div class="step-indicator-label">Filters</div>
                </div>
                <div class="step-indicator-connector"></div>
                <div class="step-indicator-item" id="stepIndicator3">
                    <div class="step-indicator-circle">3</div>
                    <div class="step-indicator-label">Capture</div>
                </div>
                <div class="step-indicator-connector"></div>
                <div class="step-indicator-item" id="stepIndicator4">
                    <div class="step-indicator-circle">4</div>
                    <div class="step-indicator-label">Preview</div>
                </div>
            </div>
            
            <!-- STEP 1: Choose Layout -->
            <div id="stepLayout" class="photobooth-step active">
                <h2>🎬 Choose Your Layout</h2>
                <p class="step-subtitle">Select how many photos you want to capture</p>
                
                <div class="layout-selector">
                    <div class="layout-option" data-layout="2" onclick="selectLayout(2)">
                        <div class="layout-preview layout-2">
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                        </div>
                        <p class="layout-option-count">2 Photos</p>
                        <p class="layout-option-subtitle">Quick Snap</p>
                    </div>
                    
                    <div class="layout-option" data-layout="3" onclick="selectLayout(3)">
                        <div class="layout-preview layout-3">
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                        </div>
                        <p class="layout-option-count">3 Photos</p>
                        <p class="layout-option-subtitle">Trio</p>
                    </div>
                    
                    <div class="layout-option selected" data-layout="4" onclick="selectLayout(4)">
                        <div class="layout-preview layout-4">
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                        </div>
                        <p class="layout-option-count">4 Photos</p>
                        <p class="layout-option-subtitle">Classic Strip</p>
                    </div>
                    
                    <div class="layout-option" data-layout="6" onclick="selectLayout(6)">
                        <div class="layout-preview layout-6">
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                            <div class="layout-preview-box">📷</div>
                        </div>
                        <p class="layout-option-count">6 Photos</p>
                        <p class="layout-option-subtitle">Full Strip</p>
                    </div>
                </div>
                
                <div class="step-buttons">
                    <button id="nextToFiltersBtn" class="btn btn-primary btn-lg" onclick="goToFilters()">Next → Choose Filters</button>
                </div>
            </div>
            
            <!-- STEP 2: Choose Filters -->
            <div id="stepFilters" class="photobooth-step">
                <h2>🎨 Choose Your Filters</h2>
                <p class="step-subtitle">Select a filter for your photos</p>
                
                <div class="filter-buttons">
                    <button class="filter-btn active" data-filter="retro" onclick="selectFilter('retro')">
                        <span class="filter-icon">✨</span> Retro Classic
                    </button>
                    <button class="filter-btn" data-filter="sepia" onclick="selectFilter('sepia')">
                        <span class="filter-icon">🟤</span> Sepia
                    </button>
                    <button class="filter-btn" data-filter="bw" onclick="selectFilter('bw')">
                        <span class="filter-icon">⚫</span> B&W
                    </button>
                    <button class="filter-btn" data-filter="vaporwave" onclick="selectFilter('vaporwave')">
                        <span class="filter-icon">💜</span> Vaporwave
                    </button>
                    <button class="filter-btn" data-filter="neon" onclick="selectFilter('neon')">
                        <span class="filter-icon">🌈</span> Neon
                    </button>
                    <button class="filter-btn" data-filter="cool" onclick="selectFilter('cool')">
                        <span class="filter-icon">❄️</span> Cool
                    </button>
                    <button class="filter-btn" data-filter="crowns" onclick="selectFilter('crowns')">
                        <span class="filter-icon">👑</span> Crown of Hearts
                    </button>
                    
                    <!-- Mirror & Transform Filters -->
                    <button class="filter-btn" data-filter="mirror-normal" onclick="selectFilter('mirror-normal')">
                        <span class="filter-icon">📸</span> Normal
                    </button>
                    <button class="filter-btn" data-filter="mirror-left" onclick="selectFilter('mirror-left')">
                        <span class="filter-icon">↔️</span> Left Mirror
                    </button>
                    <button class="filter-btn" data-filter="mirror-right" onclick="selectFilter('mirror-right')">
                        <span class="filter-icon">↔️</span> Right Mirror
                    </button>
                    <button class="filter-btn" data-filter="mirror-top" onclick="selectFilter('mirror-top')">
                        <span class="filter-icon">↕️</span> Top Mirror
                    </button>
                    <button class="filter-btn" data-filter="mirror-bottom" onclick="selectFilter('mirror-bottom')">
                        <span class="filter-icon">↕️</span> Bottom Mirror
                    </button>
                    <button class="filter-btn" data-filter="mirror-quad" onclick="selectFilter('mirror-quad')">
                        <span class="filter-icon">📊</span> Quad Mirror
                    </button>
                    <button class="filter-btn" data-filter="mirror-upsidedown" onclick="selectFilter('mirror-upsidedown')">
                        <span class="filter-icon">🔄</span> Upside-Down
                    </button>
                    <button class="filter-btn" data-filter="mirror-switch" onclick="selectFilter('mirror-switch')">
                        <span class="filter-icon">🔀</span> Switch
                    </button>
                    <button class="filter-btn" data-filter="mirror-kaleidoscope" onclick="selectFilter('mirror-kaleidoscope')">
                        <span class="filter-icon">🎨</span> Kaleidoscope
                    </button>
                </div>
                
                <div class="step-buttons">
                    <button class="btn btn-secondary" onclick="goToLayout()">← Back</button>
                    <button class="btn btn-primary btn-lg" onclick="goToCapture()">Next → Start Capture</button>
                </div>
            </div>
            
            <!-- STEP 3: Camera & Capture -->
            <div id="stepCapture" class="photobooth-step">
                <h2>📷 Capture Your Photos</h2>
                <p class="step-subtitle" id="captureSubtitle">Get ready to capture photo 1 of 4</p>
                
                <div class="filter-display" onclick="toggleCaptureFilterSelector()">
                    <span class="filter-display-label">Filter:</span>
                    <span class="filter-display-name" id="captureFilterName">RETRO CLASSIC</span>
                    <span class="filter-display-toggle">▼</span>
                </div>
                
                <!-- Filter Selector Modal -->
                <div id="captureFilterSelector" class="capture-filter-selector hidden">
                    <div class="capture-filter-options">
                        <button class="capture-filter-option active" data-filter="retro" onclick="changeCaptureFilter('retro')">⭐ RETRO CLASSIC</button>
                        <button class="capture-filter-option" data-filter="sepia" onclick="changeCaptureFilter('sepia')">📷 SEPIA</button>
                        <button class="capture-filter-option" data-filter="bw" onclick="changeCaptureFilter('bw')">⚫ B&W</button>
                        <button class="capture-filter-option" data-filter="vaporwave" onclick="changeCaptureFilter('vaporwave')">🌀 VAPORWAVE</button>
                        <button class="capture-filter-option" data-filter="neon" onclick="changeCaptureFilter('neon')">💫 NEON</button>
                        <button class="capture-filter-option" data-filter="cool" onclick="changeCaptureFilter('cool')">❄️ COOL</button>
                        <button class="capture-filter-option" data-filter="crowns" onclick="changeCaptureFilter('crowns')">👑 CROWN OF HEARTS</button>
                        
                        <div style="border-top: 1px solid #666; margin: 10px 0; padding-top: 10px;">
                            <button class="capture-filter-option" data-filter="mirror-normal" onclick="changeCaptureFilter('mirror-normal')">📸 NORMAL</button>
                            <button class="capture-filter-option" data-filter="mirror-left" onclick="changeCaptureFilter('mirror-left')">↔️ LEFT MIRROR</button>
                            <button class="capture-filter-option" data-filter="mirror-right" onclick="changeCaptureFilter('mirror-right')">↔️ RIGHT MIRROR</button>
                            <button class="capture-filter-option" data-filter="mirror-top" onclick="changeCaptureFilter('mirror-top')">↕️ TOP MIRROR</button>
                            <button class="capture-filter-option" data-filter="mirror-bottom" onclick="changeCaptureFilter('mirror-bottom')">↕️ BOTTOM MIRROR</button>
                            <button class="capture-filter-option" data-filter="mirror-quad" onclick="changeCaptureFilter('mirror-quad')">📊 QUAD MIRROR</button>
                            <button class="capture-filter-option" data-filter="mirror-upsidedown" onclick="changeCaptureFilter('mirror-upsidedown')">🔄 UPSIDE-DOWN</button>
                            <button class="capture-filter-option" data-filter="mirror-switch" onclick="changeCaptureFilter('mirror-switch')">🔀 SWITCH</button>
                            <button class="capture-filter-option" data-filter="mirror-kaleidoscope" onclick="changeCaptureFilter('mirror-kaleidoscope')">🎨 KALEIDOSCOPE</button>
                        </div>
                    </div>
                </div>
                
                <div class="camera-section">
                    <video id="video" class="video-stream" autoplay playsinline></video>
                    <canvas id="canvas" class="hidden"></canvas>
                </div>
                
                <div class="capture-progress-container">
                    <div class="capture-progress-label">
                        <span id="photoCounter">Photo 1 of 4</span>
                    </div>
                    <div class="capture-progress">
                        <div id="progressFill" style="width: 0%"></div>
                    </div>
                </div>
                
                <div class="capture-buttons">
                    <button id="startCameraBtn" class="btn btn-primary btn-lg" onclick="startCamera()">Start Camera</button>
                    <button id="capturePhotoBtnMain" class="btn btn-capture btn-lg" disabled onclick="capturePhoto()">
                        📷 CAPTURE
                    </button>
                </div>
                
                <div class="capture-buttons" style="margin-top: 10px;">
                    <button id="retakeCaptureBtn" class="btn btn-secondary" disabled onclick="retakePhotos()">🔄 Retake All</button>
                    <button id="nextToPreviewBtn" class="btn btn-secondary" disabled onclick="goToPreview()">Next → Preview</button>
                </div>
                
                <div class="info-section">
                    <p id="captureStatus" class="status-message">Click 'Start Camera' to begin</p>
                </div>
            </div>
            
            <!-- STEP 4: Preview & Customize -->
            <div id="stepPreview" class="photobooth-step">
                <h2>🎬 Your Photo Strip</h2>
                <p class="step-subtitle">Preview and customize your strip</p>
                
                <div class="strip-layout-selector">
                    <label class="strip-layout-label">✨ Strip Style:</label>
                    <div class="strip-layout-buttons">
                        <button class="strip-layout-btn active" data-layout="vertical" onclick="selectStripLayout('vertical')">📟 Vertical Strip</button>
                        <button class="strip-layout-btn" data-layout="horizontal" onclick="selectStripLayout('horizontal')">⬅️➡️ Horizontal</button>
                        <button class="strip-layout-btn" data-layout="grid2x2" onclick="selectStripLayout('grid2x2')">⬜ 2x2 Grid</button>
                        <button class="strip-layout-btn" data-layout="polaroid" onclick="selectStripLayout('polaroid')">🎨 Polaroid Wall</button>
                        <button class="strip-layout-btn" data-layout="compact" onclick="selectStripLayout('compact')">📱 Compact</button>
                    </div>
                </div>
                
                <div id="previewStrip" class="preview-full-strip preview-vertical">
                    <!-- Dynamic photos will be added here -->
                </div>
                
                <!-- Polaroid Customization (shown only for polaroid layout) -->
                <div id="polaroidCustomize" class="customize-section" style="display: none;">
                    <label class="customize-label">📸 Polaroid Style:</label>
                    
                    <div class="polaroid-options">
                        <div class="polaroid-option-group">
                            <label>Frame Color:</label>
                            <div class="polaroid-color-buttons">
                                <button class="polaroid-color-btn active" style="background-color: white;" onclick="setPolaroidFrameColor('white')" title="White"></button>
                                <button class="polaroid-color-btn" style="background-color: #f5e6d3;" onclick="setPolaroidFrameColor('#f5e6d3')" title="Retro Cream"></button>
                                <button class="polaroid-color-btn" style="background-color: #fffacd;" onclick="setPolaroidFrameColor('#fffacd')" title="Pale Yellow"></button>
                                <button class="polaroid-color-btn" style="background-color: #ffe4e1;" onclick="setPolaroidFrameColor('#ffe4e1')" title="Pastel Pink"></button>
                                <button class="polaroid-color-btn" style="background-color: #fff0f5;" onclick="setPolaroidFrameColor('#fff0f5')" title="Lavender Blush"></button>
                            </div>
                        </div>
                        
                        <div class="polaroid-option-group">
                            <label>Caption:</label>
                            <input type="text" id="polaroidCaption" maxlength="30" placeholder="Add text to photos..." class="polaroid-caption-input" onchange="updatePolaroidCaption()" oninput="updatePolaroidCaption()">
                        </div>
                        
                        <div class="polaroid-option-group">
                            <label>Style:</label>
                            <div class="polaroid-style-buttons">
                                <button class="polaroid-style-btn active" onclick="setPolaroidStyle('classic')">🎨 Classic</button>
                                <button class="polaroid-style-btn" onclick="setPolaroidStyle('straight')">📏 Straight</button>
                                <button class="polaroid-style-btn" onclick="setPolaroidStyle('scattered')">🌀 Scattered</button>
                                <button class="polaroid-style-btn" onclick="setPolaroidStyle('magazine')">📑 Magazine</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="customize-section">
                    <label class="customize-label">🎨 Frame Color:</label>
                    <div class="color-buttons">
                        <button class="color-btn active" style="background-color: #1a1a1a;" onclick="setFrameColor('#1a1a1a')" title="Black"></button>
                        <button class="color-btn" style="background-color: white;" onclick="setFrameColor('white')" title="White"></button>
                        <button class="color-btn" style="background-color: #ffd700;" onclick="setFrameColor('#ffd700')" title="Gold"></button>
                        <button class="color-btn" style="background-color: #ff1493;" onclick="setFrameColor('#ff1493')" title="Pink"></button>
                        <button class="color-btn" style="background-color: #00ffff;" onclick="setFrameColor('#00ffff')" title="Cyan"></button>
                    </div>
                </div>
                
                <div class="preview-actions">
                    <button class="btn btn-secondary" onclick="goToCapture()">← Retake</button>
                    <button class="btn btn-secondary" id="downloadStripBtn" onclick="downloadStrip()">💾 Download Strip</button>
                    <button class="btn btn-secondary" id="printStripBtn" onclick="printStrip()">🖨️ Print Strip</button>
                    <button class="btn btn-primary btn-lg" onclick="startOver()">🔄 Start Over</button>
                </div>
            </div>
            
            <!-- Gallery Section -->
            <div class="gallery-section">
                <h2>📸 GALLERY 📸</h2>
                <div id="gallery" class="gallery-grid">
                    <p class="empty-message">No memories captured yet...</p>
                </div>
            </div>
            
            <div class="info-section">
                <p id="status" class="status-message">Welcome to Retro Photobooth!</p>
            </div>
        </div>
    </div>
    
    <script src="js/script.js"></script>
    <script>
        // Initialize filter display on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeDOM();
            const filterNameMap = {
                'retro': 'RETRO CLASSIC',
                'sepia': 'SEPIA',
                'bw': 'B&W',
                'vaporwave': 'VAPORWAVE',
                'neon': 'NEON',
                'cool': 'COOL',
                'crowns': 'CROWN OF HEARTS'
            };
            const displayName = filterNameMap['retro'] || 'RETRO CLASSIC';
            const filterDisplay = document.getElementById('captureFilterName');
            if (filterDisplay) {
                filterDisplay.textContent = displayName;
            }
            
            // Close filter selector when clicking outside
            document.addEventListener('click', function(e) {
                const filterDisplay = document.querySelector('.filter-display');
                const filterSelector = document.getElementById('captureFilterSelector');
                if (filterDisplay && filterSelector && !filterDisplay.contains(e.target) && !filterSelector.contains(e.target)) {
                    filterSelector.classList.add('hidden');
                    document.querySelector('.filter-display-toggle').style.transform = 'rotate(0deg)';
                }
            });
        });
    </script>
</body>
</html>
