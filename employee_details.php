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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details - <?php echo htmlspecialchars($employee['name']); ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">Admin Portal</div>
            <div class="nav-links">
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Employee Details</h2>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin: 20px 0;">
                <div>
                    <?php if ($employee['profile_image']): ?>
                        <img src="uploads/profiles/<?php echo $employee['profile_image']; ?>" 
                             alt="Profile" style="width: 200px; height: 200px; border-radius: 10px; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 200px; height: 200px; background: #f0f0f0; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            No Photo
                        </div>
                    <?php endif; ?>
                </div>
                
                <div>
                    <table class="table">
                        <tr>
                            <th>Employee ID:</th>
                            <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td><?php echo htmlspecialchars($employee['name']); ?></td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td><?php echo htmlspecialchars($employee['email']); ?></td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td><?php echo htmlspecialchars($employee['phone']); ?></td>
                        </tr>
                        <tr>
                            <th>Department:</th>
                            <td><?php echo htmlspecialchars($employee['department']); ?></td>
                        </tr>
                        <tr>
                            <th>Position:</th>
                            <td><?php echo htmlspecialchars($employee['position']); ?></td>
                        </tr>
                        <tr>
                            <th>Join Date:</th>
                            <td><?php echo date('d M Y', strtotime($employee['join_date'])); ?></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span style="color: <?php echo $employee['status'] == 'active' ? 'green' : 'red'; ?>">
                                    <?php echo ucfirst($employee['status']); ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Attendance -->
        <div class="card">
            <h3>Recent Attendance (Last 10 days)</h3>
            
            <?php
            $att_query = "SELECT * FROM attendance WHERE employee_id = :employee_id ORDER BY date DESC LIMIT 10";
            $att_stmt = $db->prepare($att_query);
            $att_stmt->bindParam(':employee_id', $employee['employee_id']);
            $att_stmt->execute();
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Check In Photo</th>
                        <th>Check Out Photo</th>
                        <th>Location</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($attendance = $att_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo date('d M Y', strtotime($attendance['date'])); ?></td>
                        <td><?php echo $attendance['check_in_time'] ? date('h:i A', strtotime($attendance['check_in_time'])) : '-'; ?></td>
                        <td><?php echo $attendance['check_out_time'] ? date('h:i A', strtotime($attendance['check_out_time'])) : 'Not yet'; ?></td>
                        <td>
                            <?php if ($attendance['check_in_photo']): ?>
                                <img src="uploads/attendance/<?php echo $attendance['check_in_photo']; ?>" 
                                     alt="Check-in photo" class="attendance-photo" 
                                     onclick="showLargeImage('uploads/attendance/<?php echo $attendance['check_in_photo']; ?>')" 
                                     style="cursor: pointer;">
                            <?php else: ?>
                                No photo
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($attendance['check_out_photo']): ?>
                                <img src="uploads/attendance/<?php echo $attendance['check_out_photo']; ?>" 
                                     alt="Check-out photo" class="attendance-photo" 
                                     onclick="showLargeImage('uploads/attendance/<?php echo $attendance['check_out_photo']; ?>')" 
                                     style="cursor: pointer;">
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
                                <?php echo $attendance['check_out_time'] ? 'Completed' : 'Incomplete'; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Leave History -->
        <div class="card">
            <h3>Leave History</h3>
            
            <?php
            $leave_query = "SELECT * FROM leave_requests WHERE employee_id = :employee_id ORDER BY created_at DESC LIMIT 10";
            $leave_stmt = $db->prepare($leave_query);
            $leave_stmt->bindParam(':employee_id', $employee['employee_id']);
            $leave_stmt->execute();
            ?>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
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
                        <td id="empreason"><?php echo htmlspecialchars(substr($leave['reason'], 0, 50)) . '...'; ?></td>
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
    </div>

    <!-- Image Modal -->
    <div id="imageModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8);">
        <div style="position: relative; margin: 5% auto; width: 80%; max-width: 600px;">
            <span onclick="closeImageModal()" style="position: absolute; top: 10px; right: 25px; color: white; font-size: 35px; font-weight: bold; cursor: pointer;">&times;</span>
            <img id="modalImage" style="width: 100%; height: auto; border-radius: 10px;">
        </div>
    </div>

    <script src="js/script.js"></script>
    <script>
        function showLargeImage(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').style.display = 'block';
        }
        
        function closeImageModal() {
            document.getElementById('imageModal').style.display = 'none';
        }
        
        // Close modal when clicking outside the image
        window.onclick = function(event) {
            var modal = document.getElementById('imageModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const empreason = document.getElementById('empreason');
            empreason.addEventListener('click', function() {
                this.style.color = 'blue';
                empreason.innerHTML = '<?php echo htmlspecialchars($leave['reason']); ?>';
            });
        });

    </script>
</body>
</html>