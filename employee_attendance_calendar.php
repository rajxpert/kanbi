<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

$employee_id = isset($_GET['emp_id']) ? $_GET['emp_id'] : '';
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Get employee info
if ($employee_id) {
    $emp_query = "SELECT * FROM users WHERE employee_id = :employee_id";
    $emp_stmt = $db->prepare($emp_query);
    $emp_stmt->bindParam(':employee_id', $employee_id);
    $emp_stmt->execute();
    $employee = $emp_stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get attendance for the month
    $att_query = "SELECT * FROM attendance WHERE employee_id = :employee_id 
                  AND MONTH(date) = :month AND YEAR(date) = :year 
                  ORDER BY date DESC";
    $att_stmt = $db->prepare($att_query);
    $att_stmt->bindParam(':employee_id', $employee_id);
    $att_stmt->bindParam(':month', $month);
    $att_stmt->bindParam(':year', $year);
    $att_stmt->execute();
    $attendance_records = $att_stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get all employees for dropdown
$all_emp_query = "SELECT employee_id, name FROM users WHERE role = 'employee' ORDER BY name";
$all_emp_stmt = $db->prepare($all_emp_query);
$all_emp_stmt->execute();
$all_employees = $all_emp_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance Calendar</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .calendar-nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .calendar-table { width: 100%; border-collapse: collapse; }
        .calendar-table th, .calendar-table td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        .present { background-color: #d4edda; }
        .absent { background-color: #f8d7da; }
        .today { background-color: #fff3cd; font-weight: bold; }
        .employee-select { margin-bottom: 20px; }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">Admin Portal</div>
            <div class="nav-links">
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="employee_attendance_calendar.php">Attendance Calendar</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h3>Employee Attendance Calendar</h3>
            
            <div class="employee-select">
                <form method="GET">
                    <select name="emp_id" onchange="this.form.submit()" class="form-control" style="width: 300px; display: inline-block;">
                        <option value="">Select Employee</option>
                        <?php foreach ($all_employees as $emp): ?>
                            <option value="<?php echo $emp['employee_id']; ?>" <?php echo $employee_id == $emp['employee_id'] ? 'selected' : ''; ?>>
                                <?php echo $emp['name'] . ' (' . $emp['employee_id'] . ')'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="month" value="<?php echo $month; ?>">
                    <input type="hidden" name="year" value="<?php echo $year; ?>">
                </form>
            </div>

            <?php if ($employee_id && $employee): ?>
                <div class="calendar-nav">
                    <a href="?emp_id=<?php echo $employee_id; ?>&month=<?php echo $month == 1 ? 12 : $month-1; ?>&year=<?php echo $month == 1 ? $year-1 : $year; ?>" class="btn btn-primary">Previous</a>
                    <h4><?php echo $employee['name']; ?> - <?php echo date('F Y', mktime(0,0,0,$month,1,$year)); ?></h4>
                    <a href="?emp_id=<?php echo $employee_id; ?>&month=<?php echo $month == 12 ? 1 : $month+1; ?>&year=<?php echo $month == 12 ? $year+1 : $year; ?>" class="btn btn-primary">Next</a>
                </div>

                <table class="calendar-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Location</th>
                            <th>Photos</th>
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
                                    <a href="https://maps.google.com/maps?q=<?php echo $record['check_in_location']; ?>" target="_blank" class="btn" style="padding: 3px 8px; font-size: 11px; background: #28a745; color: white;">In</a>
                                <?php endif; ?>
                                <?php if ($record['check_out_location']): ?>
                                    <a href="https://maps.google.com/maps?q=<?php echo $record['check_out_location']; ?>" target="_blank" class="btn" style="padding: 3px 8px; font-size: 11px; background: #dc3545; color: white;">Out</a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($record['check_in_photo']): ?>
                                    <img src="uploads/attendance/<?php echo $record['check_in_photo']; ?>" style="width: 30px; height: 30px; border-radius: 50%;" title="Check-in photo">
                                <?php endif; ?>
                                <?php if ($record['check_out_photo']): ?>
                                    <img src="uploads/attendance/<?php echo $record['check_out_photo']; ?>" style="width: 30px; height: 30px; border-radius: 50%;" title="Check-out photo">
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Please select an employee to view their attendance calendar.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>