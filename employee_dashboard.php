<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: index.php");
    exit();
}

// Set timezone to India
date_default_timezone_set('Asia/Kolkata');

require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

// Get today's attendance
$today = date('Y-m-d');
$att_query = "SELECT * FROM attendance WHERE employee_id = :employee_id AND date = :date";
$att_stmt = $db->prepare($att_query);
$att_stmt->bindParam(':employee_id', $_SESSION['employee_id']);
$att_stmt->bindParam(':date', $today);
$att_stmt->execute();
$today_attendance = $att_stmt->fetch(PDO::FETCH_ASSOC);

// Get user info
$user_query = "SELECT * FROM users WHERE employee_id = :employee_id";
$user_stmt = $db->prepare($user_query);
$user_stmt->bindParam(':employee_id', $_SESSION['employee_id']);
$user_stmt->execute();
$user_info = $user_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <style>
        .ig-border img {
            border-radius: 50%;
            width: 100%;
            height: 100%;
            display: block;
            background: #fff;
        }

        .ig-border {
            width: 110px;
            height: 110px;
            display: inline-block;
            padding: 6px;
            border-radius: 50%;
            background: linear-gradient(45deg, #feda75, #fa7e1e, #d62976, #962fbf, #4f5bd5);
        }
    
        .user-card {
            display: flex;
            justify-content: space-between;
        }
    </style>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">Employee Portal</div>
            <div class="nav-links">
                <a href="#attendance">Attendance</a>
                <a href="my_attendance.php">My Attendance</a>
                <a href="#leave">Leave Request</a>
                <a href="#salary">Salary Slip</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card user-card">
            <div class="user-info">
                <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
                <p>Employee ID: <?php echo htmlspecialchars($_SESSION['employee_id']); ?></p>
                <p>Department: <?php echo htmlspecialchars($user_info['department']); ?></p>
                <p>Position: <?php echo htmlspecialchars($user_info['position']); ?></p>
            </div>
            <div class="ig-border">
                <?php if ($user_info['profile_image']): ?>
                    <img src="uploads/profiles/<?php echo $user_info['profile_image']; ?>" alt="Profile">
                <?php else: ?>
                    <div style="width: 98px; height: 98px; background: #f0f0f0; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                        No Photo
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Attendance Section -->
        <div class="card" id="attendance">
            <h3>Today's Attendance - <?php echo date('d M Y'); ?></h3>
            
            <div class="camera-container">
                <video id="video" autoplay></video>
                <canvas id="canvas" style="display: none;"></canvas>
            </div>
            
            <div style="text-align: center; margin: 20px 0;">
                <?php if (!$today_attendance): ?>
                    <button onclick="checkIn()" class="btn btn-success">Check In</button>
                <?php elseif (!$today_attendance['check_out_time']): ?>
                    <p>Check-in Time: <?php echo date('h:i A', strtotime($today_attendance['check_in_time'])); ?></p>
                    <button onclick="checkOut()" class="btn btn-danger">Check Out</button>
                <?php else: ?>
                    <p>Check-in: <?php echo date('h:i A', strtotime($today_attendance['check_in_time'])); ?></p>
                    <p>Check-out: <?php echo date('h:i A', strtotime($today_attendance['check_out_time'])); ?></p>
                    <p style="color: green;">Attendance completed for today!</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Leave Request Section -->
        <div class="card" id="leave">
            <h3>Leave Request</h3>
            <form action="leave_request.php" method="POST">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="leave_type">Leave Type:</label>
                        <select name="leave_type" id="leave_type" class="form-control" required>
                            <option value="sick">Sick Leave</option>
                            <option value="casual">Casual Leave</option>
                            <option value="annual">Annual Leave</option>
                            <option value="emergency">Emergency Leave</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="start_date">Start Date:</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="end_date">End Date:</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="reason">Reason:</label>
                    <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit Leave Request</button>
            </form>
        </div>

        <!-- Recent Leave Requests -->
        <div class="card">
            <h3>Recent Leave Requests</h3>
            <?php
            $leave_query = "SELECT * FROM leave_requests WHERE employee_id = :employee_id ORDER BY created_at DESC LIMIT 5";
            $leave_stmt = $db->prepare($leave_query);
            $leave_stmt->bindParam(':employee_id', $_SESSION['employee_id']);
            $leave_stmt->execute();
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Applied On</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($leave = $leave_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo ucfirst($leave['leave_type']); ?></td>
                        <td><?php echo date('d M Y', strtotime($leave['start_date'])); ?></td>
                        <td><?php echo date('d M Y', strtotime($leave['end_date'])); ?></td>
                        <td>
                            <span style="color: <?php echo $leave['status'] == 'approved' ? 'green' : ($leave['status'] == 'rejected' ? 'red' : 'orange'); ?>">
                                <?php echo ucfirst($leave['status']); ?>
                            </span>
                        </td>
                        <td><?php echo date('d M Y', strtotime($leave['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Salary Slip Section -->
        <div class="card" id="salary">
            <h3>Salary Slips</h3>
            
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            
            <p>Download your monthly salary slips:</p>
            <a href="download_salary.php" class="btn btn-primary">View/Download Current Month Salary Slip</a>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>