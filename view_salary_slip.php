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
    header("Location: generate_salary.php");
    exit();
}

$salary_id = $_GET['id'];

// Get salary slip details
$salary_query = "SELECT ss.*, u.name, u.department, u.position, u.employee_id 
                 FROM salary_slips ss 
                 JOIN users u ON ss.employee_id = u.employee_id 
                 WHERE ss.id = :id";
$salary_stmt = $db->prepare($salary_query);
$salary_stmt->bindParam(':id', $salary_id);
$salary_stmt->execute();

if ($salary_stmt->rowCount() == 0) {
    header("Location: generate_salary.php");
    exit();
}

$salary_info = $salary_stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Salary Slip</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .salary-slip { max-width: 800px; margin: 20px auto; background: white; padding: 30px; }
        .company-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .employee-details { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin: 20px 0; }
        .salary-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .salary-table th, .salary-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .salary-table th { background-color: #f2f2f2; }
        .total-row { font-weight: bold; background-color: #f9f9f9; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <nav class="navbar">
            <div class="navbar-content">
                <div class="logo">Admin Portal</div>
                <div class="nav-links">
                    <a href="generate_salary.php">Back to Salary Management</a>
                    <button onclick="window.print()" class="btn btn-primary">Print</button>
                </div>
            </div>
        </nav>
    </div>

    <div class="salary-slip">
        <div class="company-header">
            <h1>KENBI GROUP PVT. LTD</h1>
            <p>Rajapuri Bus Stand, New Delhi, Delhi 110059.</p>
            <h2>Salary Slip for <?php echo date('F Y', strtotime($salary_info['month'] . '-01')); ?></h2>
        </div>
        
        <div class="employee-details">
            <div>
                <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($salary_info['employee_id']); ?></p>
                <p><strong>Employee Name:</strong> <?php echo htmlspecialchars($salary_info['name']); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($salary_info['department']); ?></p>
            </div>
            <div>
                <p><strong>Position:</strong> <?php echo htmlspecialchars($salary_info['position']); ?></p>
                <p><strong>Pay Period:</strong> <?php echo date('F Y', strtotime($salary_info['month'] . '-01')); ?></p>
                <p><strong>Generated On:</strong> <?php echo date('d M Y', strtotime($salary_info['generated_at'])); ?></p>
            </div>
        </div>
        
        <table class="salary-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount (₹)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Basic Salary</td>
                    <td><?php echo number_format($salary_info['basic_salary'], 2); ?></td>
                </tr>
                <tr>
                    <td>Allowances (HRA, DA, etc.)</td>
                    <td><?php echo number_format($salary_info['allowances'], 2); ?></td>
                </tr>
                <tr>
                    <td><strong>Gross Salary</strong></td>
                    <td><strong><?php echo number_format($salary_info['basic_salary'] + $salary_info['allowances'], 2); ?></strong></td>
                </tr>
                <tr>
                    <td>Deductions (Tax, PF, ESI, etc.)</td>
                    <td><?php echo number_format($salary_info['deductions'], 2); ?></td>
                </tr>
                <tr class="total-row">
                    <td><strong>Net Salary</strong></td>
                    <td><strong>₹<?php echo number_format($salary_info['net_salary'], 2); ?></strong></td>
                </tr>
            </tbody>
        </table>
        
        <div style="margin-top: 50px;">
            <p><strong>Note:</strong> This is a computer-generated salary slip and does not require a signature.</p>
            <p><strong>Net Amount in Words:</strong> <?php 
                // Simple number to words conversion for Indian currency
                $amount = $salary_info['net_salary'];
                echo "Rupees " . ucwords(number_format($amount, 2)) . " Only";
            ?></p>
        </div>
    </div>
</body>
</html>