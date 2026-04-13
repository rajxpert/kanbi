<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

if ($_POST) {
    if (isset($_POST['update_salary'])) {
        $employee_id = $_POST['employee_id'];
        $basic_salary = $_POST['basic_salary'];
        $allowances = $_POST['allowances'];
        $deductions = $_POST['deductions'];
        
        $query = "UPDATE users SET salary = :salary WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':salary', $basic_salary);
        $stmt->bindParam(':id', $employee_id);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Salary updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update salary!";
        }
    }
    
    if (isset($_POST['generate_slips'])) {
        $selected_month = $_POST['month'];
        $generated_count = 0;
        
        foreach ($_POST['employees'] as $emp_id) {
            $emp_query = "SELECT * FROM users WHERE id = :id";
            $emp_stmt = $db->prepare($emp_query);
            $emp_stmt->bindParam(':id', $emp_id);
            $emp_stmt->execute();
            $employee = $emp_stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if already exists
            $check_query = "SELECT id FROM salary_slips WHERE employee_id = :employee_id AND month = :month";
            $check_stmt = $db->prepare($check_query);
            $check_stmt->bindParam(':employee_id', $employee['employee_id']);
            $check_stmt->bindParam(':month', $selected_month);
            $check_stmt->execute();
            
            if ($check_stmt->rowCount() == 0) {
                $basic_salary = $employee['salary'] ? $employee['salary'] : 25000;
                $allowances = $basic_salary * 0.2;
                $deductions = $basic_salary * 0.1;
                $net_salary = $basic_salary + $allowances - $deductions;
                
                $insert_query = "INSERT INTO salary_slips (employee_id, month, basic_salary, allowances, deductions, net_salary) 
                                 VALUES (:employee_id, :month, :basic_salary, :allowances, :deductions, :net_salary)";
                $insert_stmt = $db->prepare($insert_query);
                $insert_stmt->bindParam(':employee_id', $employee['employee_id']);
                $insert_stmt->bindParam(':month', $selected_month);
                $insert_stmt->bindParam(':basic_salary', $basic_salary);
                $insert_stmt->bindParam(':allowances', $allowances);
                $insert_stmt->bindParam(':deductions', $deductions);
                $insert_stmt->bindParam(':net_salary', $net_salary);
                
                if ($insert_stmt->execute()) {
                    $generated_count++;
                }
            }
        }
        
        $_SESSION['success'] = "Generated $generated_count salary slips for " . date('F Y', strtotime($selected_month . '-01'));
    }
}

// Get all employees
$emp_query = "SELECT * FROM users WHERE role = 'employee' AND status = 'active' ORDER BY name";
$emp_stmt = $db->prepare($emp_query);
$emp_stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Management</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="logo">Admin Portal</div>
            <div class="nav-links">
                <a href="admin_dashboard.php">Dashboard</a>
                <a href="generate_salary.php">View Generated Slips</a>
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Salary Management System</h2>
            
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
        </div>

        <!-- Employee Salary Management -->
        <div class="card">
            <h3>Manage Employee Salaries</h3>
            
            <form method="POST" id="salaryForm">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Current Salary</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($employee = $emp_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="employees[]" value="<?php echo $employee['id']; ?>">
                            </td>
                            <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                            <td><?php echo htmlspecialchars($employee['name']); ?></td>
                            <td><?php echo htmlspecialchars($employee['department']); ?></td>
                            <td>₹<?php echo number_format($employee['salary'] ? $employee['salary'] : 0, 2); ?></td>
                            <td>
                                <button type="button" onclick="editSalary(<?php echo $employee['id']; ?>, '<?php echo $employee['name']; ?>', <?php echo $employee['salary'] ? $employee['salary'] : 0; ?>)" class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">Edit Salary</button>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                
                <div style="margin-top: 20px;">
                    <div class="form-group" style="display: inline-block; margin-right: 20px;">
                        <label for="month">Select Month:</label>
                        <input type="month" id="month" name="month" class="form-control" value="<?php echo date('Y-m'); ?>" required>
                    </div>
                    <button type="submit" name="generate_slips" class="btn btn-success">Generate Salary Slips for Selected</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Salary Edit Modal -->
    <div id="salaryModal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
        <div style="position: relative; margin: 10% auto; width: 400px; background: white; padding: 30px; border-radius: 10px;">
            <h3 id="modalTitle">Edit Salary</h3>
            <form method="POST">
                <input type="hidden" id="modal_employee_id" name="employee_id">
                
                <div class="form-group">
                    <label for="modal_basic_salary">Basic Salary:</label>
                    <input type="number" id="modal_basic_salary" name="basic_salary" class="form-control" step="0.01" required>
                </div>
                
                <div class="form-group">
                    <label for="modal_allowances">Allowances (%):</label>
                    <input type="number" id="modal_allowances" name="allowances" class="form-control" value="20" step="0.01">
                </div>
                
                <div class="form-group">
                    <label for="modal_deductions">Deductions (%):</label>
                    <input type="number" id="modal_deductions" name="deductions" class="form-control" value="10" step="0.01">
                </div>
                
                <button type="submit" name="update_salary" class="btn btn-primary">Update Salary</button>
                <button type="button" onclick="closeSalaryModal()" class="btn btn-danger">Cancel</button>
            </form>
        </div>
    </div>

    <script>
        function editSalary(empId, empName, currentSalary) {
            document.getElementById('modalTitle').innerText = 'Edit Salary - ' + empName;
            document.getElementById('modal_employee_id').value = empId;
            document.getElementById('modal_basic_salary').value = currentSalary;
            document.getElementById('salaryModal').style.display = 'block';
        }
        
        function closeSalaryModal() {
            document.getElementById('salaryModal').style.display = 'none';
        }
    </script>
</body>
</html>