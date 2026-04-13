<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

// Get statistics
$stats_query = "SELECT 
    (SELECT COUNT(*) FROM users WHERE role = 'employee' AND status = 'active') as total_employees,
    (SELECT COUNT(*) FROM attendance WHERE date = CURDATE()) as today_attendance,
    (SELECT COUNT(*) FROM leave_requests WHERE status = 'pending') as pending_leaves,
    (SELECT COUNT(*) FROM attendance WHERE date = CURDATE() AND check_out_time IS NULL) as active_employees";
$stats_stmt = $db->prepare($stats_query);
$stats_stmt->execute();
$stats = $stats_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo admin-logo">
                <img src="assets/kenbilogo.png" alt="logo" class="logo-photo">
            </div>
            <div class="nav-links">
                <a href="#employees">Employees</a>
                <a href="#attendance">Attendance</a>
                <a href="employee_attendance_calendar.php">Attendance Calendar</a>
                <a href="#leaves">Leave Requests</a>
                <a href="#salary">Salary Management</a>
                <a href="logout.php" onclick="sendLogoutLocation()">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Welcome, Admin!</h2>
            <p>Manage your organization efficiently</p>
        </div>

        <!-- Statistics -->
        <div class="dashboard-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_employees']; ?></div>
                <div class="stat-label">Total Employees</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['today_attendance']; ?></div>
                <div class="stat-label">Today's Attendance</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['pending_leaves']; ?></div>
                <div class="stat-label">Pending Leaves</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['active_employees']; ?></div>
                <div class="stat-label">Currently Active</div>
            </div>
        </div>

        <!-- Employee Management -->
        <div class="card" id="employees">
            <h3>Employee Management</h3>
            
            <?php
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            
            <div style="margin-bottom: 20px;">
                <a href="add_employee.php" class="btn btn-primary">Add New Employee</a>
            </div>
            
            <?php
            $emp_query = "SELECT * FROM users WHERE role = 'employee' ORDER BY created_at DESC";
            $emp_stmt = $db->prepare($emp_query);
            $emp_stmt->execute();
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>S/R</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count=1; while ($employee = $emp_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($count); ?> :-</td>
                        <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                        <td><?php echo htmlspecialchars($employee['name']); ?></td>
                        <td><?php echo htmlspecialchars($employee['department']); ?></td>
                        <td><?php echo htmlspecialchars($employee['position']); ?></td>
                        <td>
                            <span style="color: <?php echo $employee['status'] == 'active' ? 'green' : 'red'; ?>">
                                <?php echo ucfirst($employee['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Edit</a>
                            <a href="employee_details.php?id=<?php echo $employee['id']; ?>" class="btn btn-success" style="padding: 5px 10px; font-size: 12px;">View</a>
                            <a href="live_monitor.php?id=<?php echo $employee['id']; ?>" class="btn" style="padding: 5px 10px; font-size: 12px; background: #17a2b8; color: white;">Live Monitor</a>
                        </td>
                    </tr>
                    <?php $count++; endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Today's Attendance -->
        <div class="card" id="attendance">
            <h3>Today's Attendance</h3>
            
            <?php
            $att_query = "SELECT a.*, u.name, u.department 
                          FROM attendance a 
                          JOIN users u ON a.employee_id = u.employee_id 
                          WHERE a.date = CURDATE() 
                          ORDER BY a.check_in_time DESC";
            $att_stmt = $db->prepare($att_query);
            $att_stmt->execute();
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Check In Photo</th>
                        <th>Location</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($attendance = $att_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($attendance['name']); ?></td>
                        <td><?php echo htmlspecialchars($attendance['department']); ?></td>
                        <td><?php echo $attendance['check_in_time'] ? date('h:i A', strtotime($attendance['check_in_time'])) : '-'; ?></td>
                        <td><?php echo $attendance['check_out_time'] ? date('h:i A', strtotime($attendance['check_out_time'])) : 'Not yet'; ?></td>
                        <td>
                            <?php if ($attendance['check_in_photo']): ?>
                                <img src="uploads/attendance/<?php echo $attendance['check_in_photo']; ?>" 
                                     alt="Check-in photo" class="attendance-photo">
                            <?php else: ?>
                                No photo
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($attendance['check_in_location']): ?>
                                <a href="https://maps.google.com/maps?q=<?php echo $attendance['check_in_location']; ?>" 
                                   target="_blank" class="btn" style="padding: 3px 8px; font-size: 11px; background: #28a745; color: white;">View Location</a>
                            <?php else: ?>
                                No location
                            <?php endif; ?>
                            <?php if ($attendance['check_out_location']): ?>
                                <br><a href="https://maps.google.com/maps?q=<?php echo $attendance['check_out_location']; ?>" 
                                      target="_blank" class="btn" style="padding: 3px 8px; font-size: 11px; background: #dc3545; color: white; margin-top: 2px;">Out Location</a>
                            <?php else: ?>
                                No location
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="color: <?php echo $attendance['check_out_time'] ? 'green' : 'orange'; ?>">
                                <?php echo $attendance['check_out_time'] ? 'Completed' : 'Active'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pending Leave Requests -->
        <div class="card" id="leaves">
            <h3>Pending Leave Requests</h3>
            
            <?php
            $leave_query = "SELECT lr.*, u.name, u.department 
                           FROM leave_requests lr 
                           JOIN users u ON lr.employee_id = u.employee_id 
                           WHERE lr.status = 'pending' 
                           ORDER BY lr.created_at DESC";
            $leave_stmt = $db->prepare($leave_query);
            $leave_stmt->execute();
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Department</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($leave = $leave_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($leave['name']); ?></td>
                        <td><?php echo htmlspecialchars($leave['department']); ?></td>
                        <td><?php echo ucfirst($leave['leave_type']); ?></td>
                        <td><?php echo date('d M Y', strtotime($leave['start_date'])); ?></td>
                        <td><?php echo date('d M Y', strtotime($leave['end_date'])); ?></td>
                        <td><?php echo htmlspecialchars(substr($leave['reason'], 0, 50)) . '...'; ?></td>
                        <td>
                            <a href="approve_leave.php?id=<?php echo $leave['id']; ?>&action=approve" 
                               class="btn btn-success" style="padding: 5px 10px; font-size: 12px;">Approve</a>
                            <a href="approve_leave.php?id=<?php echo $leave['id']; ?>&action=reject" 
                               class="btn btn-danger" style="padding: 5px 10px; font-size: 12px;">Reject</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Salary Management -->
        <div class="card" id="salary">
            <h3>Salary Management</h3>
            <div style="margin-bottom: 20px;">
                <a href="salary_management.php" class="btn btn-primary">Manage Employee Salaries</a>
                <a href="generate_salary.php" class="btn btn-success">View Generated Salary Slips</a>
            </div>
            <p>Set individual employee salaries and generate monthly salary slips.</p>
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
        function sendLogoutLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const location = position.coords.latitude + ',' + position.coords.longitude;
                    
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = 'logout.php';
                    
                    const locationInput = document.createElement('input');
                    locationInput.type = 'hidden';
                    locationInput.name = 'location';
                    locationInput.value = location;
                    
                    form.appendChild(locationInput);
                    document.body.appendChild(form);
                    form.submit();
                });
            } else {
                window.location.href = 'logout.php';
            }
        }
    </script>
</body>
</html>