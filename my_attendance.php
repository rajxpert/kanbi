<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

// Get current month and year
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Get attendance for the month
$att_query = "SELECT * FROM attendance WHERE employee_id = :employee_id 
              AND MONTH(date) = :month AND YEAR(date) = :year 
              ORDER BY date DESC";
$att_stmt = $db->prepare($att_query);
$att_stmt->bindParam(':employee_id', $_SESSION['employee_id']);
$att_stmt->bindParam(':month', $month);
$att_stmt->bindParam(':year', $year);
$att_stmt->execute();
$attendance_records = $att_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance Calendar</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .calendar-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .calendar-table { width: 100%; border-collapse: collapse; }
        .calendar-table th, .calendar-table td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        .present { background-color: #d4edda; }
        .absent { background-color: #f8d7da; }
        .today { background-color: #fff3cd; font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">Employee Portal</div>
            <div class="nav-links">
                <a href="employee_dashboard.php">Dashboard</a>
                <a href="my_attendance.php">My Attendance</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <div class="calendar-nav">
                <a href="?month=<?php echo $month == 1 ? 12 : $month-1; ?>&year=<?php echo $month == 1 ? $year-1 : $year; ?>" class="btn btn-primary">Previous</a>
                <h3><?php echo date('F Y', mktime(0,0,0,$month,1,$year)); ?></h3>
                <a href="?month=<?php echo $month == 12 ? 1 : $month+1; ?>&year=<?php echo $month == 12 ? $year+1 : $year; ?>" class="btn btn-primary">Next</a>
            </div>

            <table class="calendar-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>In-Out</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($attendance_records as $record): ?>
                    <tr class="<?php echo $record['date'] == date('Y-m-d') ? 'today' : 'present'; ?>">
                        <td><?php echo date('d M Y', strtotime($record['date'])); ?></td>
                        <td><?php echo $record['check_in_time'] ? date('h:i A', strtotime($record['check_in_time'])) : '-'; ?></td>
                        <td><?php echo $record['check_out_time'] ? date('h:i A', strtotime($record['check_out_time'])) : 'Not yet'; ?></td>
                        <td><?php echo $record['check_out_time'] ? 'Completed' : 'Active'; ?></td>
                        <td>
                            <?php if ($record['check_in_location']): ?>
                                <a href="#" target="_blank" class="btn" style="padding: 3px 8px; font-size: 11px; background: #28a745; color: white;">In</a>
                            <?php endif; ?>
                            <?php if ($record['check_out_location']): ?>
                                <a href="#" target="_blank" class="btn" style="padding: 3px 8px; font-size: 11px; background: #dc3545; color: white;">Out</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>