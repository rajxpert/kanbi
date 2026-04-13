// Camera functionality for attendance with mobile support
let video = null;
let canvas = null;
let stream = null;

function startCamera() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    
    // Mobile-friendly camera constraints
    const constraints = {
        video: {
            width: { ideal: 640, max: 1280 },
            height: { ideal: 480, max: 720 },
            facingMode: 'user', // Front camera for mobile
            aspectRatio: 4/3
        }
    };
    
    navigator.mediaDevices.getUserMedia(constraints)
        .then(function(mediaStream) {
            stream = mediaStream;
            video.srcObject = mediaStream;
            video.play();
        })
        .catch(function(err) {
            console.log("Camera error: " + err);
            // Try with basic constraints for older devices
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(mediaStream) {
                    stream = mediaStream;
                    video.srcObject = mediaStream;
                    video.play();
                })
                .catch(function(err2) {
                    alert("Camera access required for attendance. Please allow camera permission.");
                });
        });
}

function capturePhoto() {
    if (!video || !canvas) return null;
    
    const context = canvas.getContext('2d');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0);
    
    return canvas.toDataURL('image/jpeg');
}

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
    }
}

// Attendance functions
function checkIn() {
    const photo = capturePhoto();
    if (!photo) {
        alert("Please allow camera access");
        return;
    }
    
    // Get location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const location = position.coords.latitude + ',' + position.coords.longitude;
            
            fetch('attendance_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'check_in',
                    photo: photo,
                    location: location
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Check-in successful!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }, function() {
            // Location denied, proceed without location
            sendAttendance('check_in', photo, null);
        });
    } else {
        // Location not supported
        sendAttendance('check_in', photo, null);
    }
}

function checkOut() {
    const photo = capturePhoto();
    if (!photo) {
        alert("Please allow camera access");
        return;
    }
    
    // Get location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const location = position.coords.latitude + ',' + position.coords.longitude;
            
            fetch('attendance_action.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'check_out',
                    photo: photo,
                    location: location
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Check-out successful!');
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            });
        }, function() {
            // Location denied, proceed without location
            sendAttendance('check_out', photo, null);
        });
    } else {
        // Location not supported
        sendAttendance('check_out', photo, null);
    }
}

function sendAttendance(action, photo, location) {
    fetch('attendance_action.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            action: action,
            photo: photo,
            location: location
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(action === 'check_in' ? 'Check-in successful!' : 'Check-out successful!');
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
}

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    const inputs = form.querySelectorAll('input[required]');
    
    for (let input of inputs) {
        if (!input.value.trim()) {
            alert('Please fill all required fields');
            input.focus();
            return false;
        }
    }
    return true;
}

// Initialize camera when page loads with mobile detection
document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('video')) {
        // Check if mobile device
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        
        if (isMobile) {
            // Add mobile-specific instructions
            const instructions = document.getElementById('cameraInstructions');
            if (instructions) {
                instructions.innerHTML = '📱 <strong>Mobile Device Detected:</strong> Tap "Allow" when browser asks for camera permission. Make sure you\'re using HTTPS or localhost.';
            }
        }
        
        // Start camera with delay for mobile
        setTimeout(startCamera, isMobile ? 1000 : 500);
    }
});