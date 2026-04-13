<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

$current_month = date('Y-m');

// if ($_POST) {
//     $selected_month = $_POST['month'];
    
//     // Get all active employees
//     $emp_query = "SELECT * FROM users WHERE role = 'employee' AND status = 'active'";
//     $emp_stmt = $db->prepare($emp_query);
//     $emp_stmt->execute();
    
//     $generated_count = 0;
    
//     while ($employee = $emp_stmt->fetch(PDO::FETCH_ASSOC)) {
//         // Check if salary slip already exists for this month
//         $check_query = "SELECT id FROM salary_slips WHERE employee_id = :employee_id AND month = :month";
//         $check_stmt = $db->prepare($check_query);
//         $check_stmt->bindParam(':employee_id', $employee['employee_id']);
//         $check_stmt->bindParam(':month', $selected_month);
//         $check_stmt->execute();
        
//         if ($check_stmt->rowCount() == 0) {
//             // Generate salary slip
//             $basic_salary = $employee['salary'] ? $employee['salary'] : 25000;
//             $allowances = $basic_salary * 0.2; // 20% allowances
//             $deductions = $basic_salary * 0.1; // 10% deductions
//             $net_salary = $basic_salary + $allowances - $deductions;
            
//             $insert_query = "INSERT INTO salary_slips (employee_id, month, basic_salary, allowances, deductions, net_salary) 
//                              VALUES (:employee_id, :month, :basic_salary, :allowances, :deductions, :net_salary)";
//             $insert_stmt = $db->prepare($insert_query);
//             $insert_stmt->bindParam(':employee_id', $employee['employee_id']);
//             $insert_stmt->bindParam(':month', $selected_month);
//             $insert_stmt->bindParam(':basic_salary', $basic_salary);
//             $insert_stmt->bindParam(':allowances', $allowances);
//             $insert_stmt->bindParam(':deductions', $deductions);
//             $insert_stmt->bindParam(':net_salary', $net_salary);
            
//             if ($insert_stmt->execute()) {
//                 $generated_count++;
//             }
//         }
//     }
    
//     $_SESSION['success'] = "Generated $generated_count salary slips for " . date('F Y', strtotime($selected_month . '-01'));
// }

// Get existing salary slips for current month
$salary_query = "SELECT ss.*, u.name, u.department 
                 FROM salary_slips ss 
                 JOIN users u ON ss.employee_id = u.employee_id 
                 WHERE ss.month = :month 
                 ORDER BY u.name";
$salary_stmt = $db->prepare($salary_query);
$salary_stmt->bindParam(':month', $current_month);
$salary_stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Salary Slips</title>
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
            <h2>Generate Monthly Salary Slips</h2>
            
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
            
            <form method="POST" style="margin-bottom: 30px;">
                <div style="display: flex; gap: 20px; align-items: end;">
                    <div class="form-group">
                        <label for="month">Select Month:</label>
                        <input type="month" id="month" name="month" class="form-control" value="<?php echo $current_month; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Generate Salary Slips</button>
                </div>
            </form>
        </div>

        <div class="card">
            <h3>Current Month Salary Slips (<?php echo date('F Y', strtotime($current_month . '-01')); ?>)</h3>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Basic Salary</th>
                        <th>Allowances</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Generated On</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($salary = $salary_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($salary['employee_id']); ?></td>
                        <td><?php echo htmlspecialchars($salary['name']); ?></td>
                        <td><?php echo htmlspecialchars($salary['department']); ?></td>
                        <td>₹<?php echo number_format($salary['basic_salary'], 2); ?></td>
                        <td>₹<?php echo number_format($salary['allowances'], 2); ?></td>
                        <td>₹<?php echo number_format($salary['deductions'], 2); ?></td>
                        <td><strong>₹<?php echo number_format($salary['net_salary'], 2); ?></strong></td>
                        <td><?php echo date('d M Y', strtotime($salary['generated_at'])); ?></td>
                        <td>
                            <a href="view_salary_slip.php?id=<?php echo $salary['id']; ?>" class="btn btn-success" style="padding: 5px 10px; font-size: 12px;">View</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>