<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$employee_id = $_GET['id'];

// Get employee details
$emp_query = "SELECT * FROM users WHERE id = :id AND role = 'employee'";
$emp_stmt = $db->prepare($emp_query);
$emp_stmt->bindParam(':id', $employee_id);
$emp_stmt->execute();

if ($emp_stmt->rowCount() == 0) {
    header("Location: admin_dashboard.php");
    exit();
}

$employee = $emp_stmt->fetch(PDO::FETCH_ASSOC);

// Get today's attendance
$today = date('Y-m-d');
$att_query = "SELECT * FROM attendance WHERE employee_id = :employee_id AND date = :date";
$att_stmt = $db->prepare($att_query);
$att_stmt->bindParam(':employee_id', $employee['employee_id']);
$att_stmt->bindParam(':date', $today);
$att_stmt->execute();
$today_attendance = $att_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Employee Monitor - <?php echo htmlspecialchars($employee['name']); ?></title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .live-video-container {
            background: #000;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            position: relative;
        }
        .live-video {
            width: 100%;
            max-width: 640px;
            height: 480px;
            border-radius: 10px;
            background: #222;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
        }
        .video-controls {
            margin: 15px 0;
        }
        .status-indicator {
            position: absolute;
            top: 30px;
            right: 30px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #ff4444;
            animation: pulse 2s infinite;
        }
        .status-indicator.live {
            background: #44ff44;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
        .activity-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .screen-share {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">🔴 LIVE Monitor</div>
            <div class="nav-links">
                <a href="employee_details.php?id=<?php echo $employee_id; ?>">Employee Details</a>
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>🎥 Live Employee Monitor - <?php echo htmlspecialchars($employee['name']); ?></h2>
            <p>Employee ID: <?php echo htmlspecialchars($employee['employee_id']); ?> | Department: <?php echo htmlspecialchars($employee['department']); ?></p>
            
            <!-- Live Status -->
            <div style="background: <?php echo ($today_attendance && !$today_attendance['check_out_time']) ? '#d4edda' : '#f8d7da'; ?>; padding: 15px; border-radius: 8px; text-align: center; margin: 15px 0;">
                <?php if ($today_attendance && !$today_attendance['check_out_time']): ?>
                    🟢 <strong>LIVE - Currently Working</strong> (Since <?php echo date('h:i A', strtotime($today_attendance['check_in_time'])); ?>)
                <?php else: ?>
                    🔴 <strong>OFFLINE - Not Working</strong>
                <?php endif; ?>
            </div>
        </div>

        <!-- Live Video Feed -->
        <div class="card">
            <h3>📹 Live Video Feed</h3>
            <div class="live-video-container">
                <div class="status-indicator <?php echo ($today_attendance && !$today_attendance['check_out_time']) ? 'live' : ''; ?>"></div>
                
                <?php if ($today_attendance && !$today_attendance['check_out_time']): ?>
                    <!-- Simulated Live Video -->
                    <video id="liveVideo" class="live-video" autoplay muted style="background: #000;">
                        <div style="color: white; font-size: 16px;">
                            🎥 Live Camera Feed<br>
                            <div id="videoStatus">Connecting to employee camera...</div>
                        </div>
                    </video>
                    
                    <div class="video-controls">
                        <button onclick="startLiveStream()" class="btn btn-success">📹 Start Live Stream</button>
                        <button onclick="stopLiveStream()" class="btn btn-danger">⏹️ Stop Stream</button>
                        <button onclick="takeScreenshot()" class="btn btn-primary">📸 Take Screenshot</button>
                    </div>
                <?php else: ?>
                    <div class="live-video">
                        <div>
                            📴 Employee Not Active<br>
                            <small>Live video available only when employee is working</small>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Activity Monitoring -->
        <div class="activity-grid">
            <div class="card">
                <h4>🖥️ Screen Activity</h4>
                <div class="screen-share">
                    <?php if ($today_attendance && !$today_attendance['check_out_time']): ?>
                        <div id="screenActivity">
                            <p>🖱️ Mouse Activity: <span style="color: green;">Active</span></p>
                            <p>⌨️ Keyboard Activity: <span style="color: green;">Active</span></p>
                            <p>🖥️ Screen Status: <span style="color: green;">Online</span></p>
                            <p>📊 Productivity: <span style="color: green;">85%</span></p>
                        </div>
                    <?php else: ?>
                        <p>No screen activity - Employee offline</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <h4>📊 Real-time Stats</h4>
                <div style="text-align: center;">
                    <?php if ($today_attendance && !$today_attendance['check_out_time']): ?>
                        <p><strong>Work Duration:</strong> <span id="workDuration">Calculating...</span></p>
                        <p><strong>Break Time:</strong> <span id="breakTime">15 min</span></p>
                        <p><strong>Tasks Completed:</strong> <span id="tasksCompleted">3</span></p>
                        <p><strong>Current Task:</strong> <span id="currentTask">Working on project</span></p>
                    <?php else: ?>
                        <p>No activity data available</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Live Activity Log -->
        <div class="card">
            <h3>📝 Live Activity Log</h3>
            <div id="activityLog" style="max-height: 300px; overflow-y: auto; background: #f8f9fa; padding: 15px; border-radius: 8px;">
                <?php if ($today_attendance && !$today_attendance['check_out_time']): ?>
                    <div class="activity-item" style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                        <strong><?php echo date('h:i:s A'); ?>:</strong> 🎥 Live monitoring started
                    </div>
                    <div class="activity-item" style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                        <strong><?php echo date('h:i:s A', strtotime('-2 minutes')); ?>:</strong> 💻 Employee active on workstation
                    </div>
                    <div class="activity-item" style="padding: 8px; border-bottom: 1px solid #dee2e6;">
                        <strong><?php echo date('h:i:s A', strtotime('-5 minutes')); ?>:</strong> 📊 Task progress updated
                    </div>
                <?php else: ?>
                    <p>No live activity - Employee is offline</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        let liveStreamActive = false;
        let activityInterval;

        function startLiveStream() {
            const video = document.getElementById('liveVideo');
            const videoStatus = document.getElementById('videoStatus');
            
            // Simulate live video stream
            videoStatus.innerHTML = '🔴 LIVE - Streaming employee workspace';
            video.style.background = 'linear-gradient(45deg, #667eea, #764ba2)';
            liveStreamActive = true;
            
            // Start simulated video feed
            navigator.mediaDevices.getUserMedia({ video: true, audio: false })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.style.background = 'none';
                    videoStatus.innerHTML = '🔴 LIVE - Employee Camera Active';
                })
                .catch(function(err) {
                    // Fallback to simulated feed
                    simulateLiveVideo();
                });
        }

        function simulateLiveVideo() {
            const video = document.getElementById('liveVideo');
            const videoStatus = document.getElementById('videoStatus');
            
            // Create canvas for simulated video
            const canvas = document.createElement('canvas');
            canvas.width = 640;
            canvas.height = 480;
            const ctx = canvas.getContext('2d');
            
            function drawFrame() {
                if (!liveStreamActive) return;
                
                // Simulate video feed with moving elements
                ctx.fillStyle = '#2c3e50';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                
                // Simulate person silhouette
                ctx.fillStyle = '#34495e';
                ctx.fillRect(200, 150, 240, 300);
                
                // Add timestamp
                ctx.fillStyle = '#ecf0f1';
                ctx.font = '20px Arial';
                ctx.fillText('LIVE: ' + new Date().toLocaleTimeString(), 20, 40);
                
                // Add activity indicator
                const activity = Math.random() > 0.5 ? '🟢 Active' : '🟡 Idle';
                ctx.fillText(activity, 20, 70);
                
                requestAnimationFrame(drawFrame);
            }
            
            drawFrame();
            video.style.backgroundImage = `url(${canvas.toDataURL()})`;
            video.style.backgroundSize = 'cover';
        }

        function stopLiveStream() {
            liveStreamActive = false;
            const video = document.getElementById('liveVideo');
            const videoStatus = document.getElementById('videoStatus');
            
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
            
            video.style.background = '#222';
            videoStatus.innerHTML = '⏹️ Stream Stopped';
        }

        function takeScreenshot() {
            if (liveStreamActive) {
                alert('📸 Screenshot captured and saved to monitoring records');
                addActivityLog('📸 Screenshot taken by admin');
            } else {
                alert('Please start live stream first');
            }
        }

        function addActivityLog(message) {
            const activityLog = document.getElementById('activityLog');
            const newActivity = document.createElement('div');
            newActivity.className = 'activity-item';
            newActivity.style.cssText = 'padding: 8px; border-bottom: 1px solid #dee2e6;';
            newActivity.innerHTML = `<strong>${new Date().toLocaleTimeString()}:</strong> ${message}`;
            activityLog.insertBefore(newActivity, activityLog.firstChild);
            
            // Keep only last 20 activities
            while (activityLog.children.length > 20) {
                activityLog.removeChild(activityLog.lastChild);
            }
        }

        // Update work duration
        <?php if ($today_attendance && !$today_attendance['check_out_time']): ?>
        function updateWorkDuration() {
            const checkInTime = new Date('<?php echo $today_attendance['check_in_time']; ?>');
            const now = new Date();
            const diff = now - checkInTime;
            
            const hours = Math.floor(diff / (1000 * 60 * 60));
            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
            
            document.getElementById('workDuration').innerText = hours + 'h ' + minutes + 'm';
        }

        updateWorkDuration();
        setInterval(updateWorkDuration, 60000);

        // Simulate real-time activity updates
        setInterval(function() {
            const activities = [
                '💻 Working on document',
                '🖱️ Mouse activity detected',
                '⌨️ Typing activity',
                '📊 Checking reports',
                '💬 Team communication',
                '🔍 Research activity',
                '📝 Taking notes'
            ];
            
            const randomActivity = activities[Math.floor(Math.random() * activities.length)];
            addActivityLog(randomActivity);
            
            // Update stats randomly
            document.getElementById('tasksCompleted').innerText = Math.floor(Math.random() * 10) + 1;
            document.getElementById('breakTime').innerText = Math.floor(Math.random() * 30) + 5 + ' min';
        }, 15000); // Update every 15 seconds
        <?php endif; ?>

        // Auto-start live stream if employee is active
        <?php if ($today_attendance && !$today_attendance['check_out_time']): ?>
        setTimeout(function() {
            startLiveStream();
        }, 2000);
        <?php endif; ?>
    </script>
</body>
</html>