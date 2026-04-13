<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Camera Test - Mobile</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .test-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            text-align: center;
        }
        .test-video {
            width: 100%;
            max-width: 400px;
            height: 300px;
            border: 2px solid #667eea;
            border-radius: 10px;
            background: #f0f0f0;
            object-fit: cover;
        }
        .test-button {
            margin: 10px;
            padding: 15px 30px;
            font-size: 16px;
        }
        .status {
            padding: 15px;
            margin: 15px 0;
            border-radius: 8px;
            font-weight: bold;
        }
        .status-success { background: #d4edda; color: #155724; }
        .status-error { background: #f8d7da; color: #721c24; }
        .status-info { background: #d1ecf1; color: #0c5460; }
    </style>
</head>
<body>
    <div class="test-container">
        <div class="card">
            <h2>📱 Mobile Camera Test</h2>
            <p>Test your mobile camera for attendance system</p>
            
            <div id="status" class="status status-info">
                Ready to test camera...
            </div>
            
            <video id="testVideo" class="test-video" autoplay playsinline muted></video>
            <canvas id="testCanvas" style="display: none;"></canvas>
            
            <div style="margin: 20px 0;">
                <button onclick="testCamera()" class="btn btn-primary test-button">📹 Test Camera</button>
                <button onclick="takeTestPhoto()" class="btn btn-success test-button">📸 Take Photo</button>
                <button onclick="stopCamera()" class="btn btn-danger test-button">⏹️ Stop</button>
            </div>
            
            <div id="photoResult" style="margin: 20px 0;"></div>
            
            <div style="text-align: left; margin: 20px 0; font-size: 14px;">
                <h4>📋 Troubleshooting Steps:</h4>
                <ol>
                    <li><strong>Allow Permission:</strong> Tap "Allow" when browser asks for camera</li>
                    <li><strong>Check HTTPS:</strong> Camera works only on HTTPS or localhost</li>
                    <li><strong>Refresh Page:</strong> If camera doesn't work, refresh the page</li>
                    <li><strong>Try Different Browser:</strong> Chrome/Safari work best</li>
                    <li><strong>Check Settings:</strong> Ensure camera permission is enabled in browser settings</li>
                </ol>
                
                <h4>📱 Mobile Specific:</h4>
                <ul>
                    <li>Use front camera (selfie camera) for attendance</li>
                    <li>Hold phone vertically for better photos</li>
                    <li>Ensure good lighting for clear photos</li>
                    <li>Close other apps that might use camera</li>
                </ul>
            </div>
            
            <div style="margin: 20px 0;">
                <a href="employee_dashboard.php" class="btn btn-primary">← Back to Dashboard</a>
            </div>
        </div>
    </div>

    <script>
        let testStream = null;
        
        function updateStatus(message, type = 'info') {
            const status = document.getElementById('status');
            status.className = `status status-${type}`;
            status.innerHTML = message;
        }
        
        function testCamera() {
            const video = document.getElementById('testVideo');
            
            updateStatus('🔄 Requesting camera access...', 'info');
            
            // Mobile-optimized constraints
            const constraints = {
                video: {
                    width: { ideal: 640, max: 1280 },
                    height: { ideal: 480, max: 720 },
                    facingMode: 'user', // Front camera
                    aspectRatio: { ideal: 4/3 }
                }
            };
            
            navigator.mediaDevices.getUserMedia(constraints)
                .then(function(stream) {
                    testStream = stream;
                    video.srcObject = stream;
                    video.play();
                    updateStatus('✅ Camera working! You can now take photos.', 'success');
                })
                .catch(function(err) {
                    console.error('Camera error:', err);
                    
                    // Try with basic constraints
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(function(stream) {
                            testStream = stream;
                            video.srcObject = stream;
                            video.play();
                            updateStatus('✅ Camera working with basic settings!', 'success');
                        })
                        .catch(function(err2) {
                            console.error('Basic camera error:', err2);
                            updateStatus(`❌ Camera Error: ${err2.message}. Please check permissions and try again.`, 'error');
                        });
                });
        }
        
        function takeTestPhoto() {
            const video = document.getElementById('testVideo');
            const canvas = document.getElementById('testCanvas');
            const photoResult = document.getElementById('photoResult');
            
            if (!testStream) {
                updateStatus('❌ Please start camera first!', 'error');
                return;
            }
            
            // Capture photo
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(video, 0, 0);
            
            // Display captured photo
            const photoData = canvas.toDataURL('image/jpeg');
            photoResult.innerHTML = `
                <h4>📸 Captured Photo:</h4>
                <img src="${photoData}" style="width: 200px; height: 150px; border-radius: 8px; object-fit: cover;">
                <p style="color: green; font-weight: bold;">✅ Photo captured successfully! Your camera is working.</p>
            `;
            
            updateStatus('📸 Photo captured successfully!', 'success');
        }
        
        function stopCamera() {
            const video = document.getElementById('testVideo');
            
            if (testStream) {
                testStream.getTracks().forEach(track => track.stop());
                testStream = null;
                video.srcObject = null;
                updateStatus('⏹️ Camera stopped.', 'info');
            }
        }
        
        // Auto-detect mobile and show relevant info
        document.addEventListener('DOMContentLoaded', function() {
            const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
            
            if (isMobile) {
                updateStatus('📱 Mobile device detected. Tap "Test Camera" to begin.', 'info');
            } else {
                updateStatus('💻 Desktop detected. Click "Test Camera" to begin.', 'info');
            }
        });
    </script>
</body>
</html>