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

if ($_POST) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];
    
    // Handle profile image
    $profile_image = $employee['profile_image'];
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/profiles/";
        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $profile_image = $employee['employee_id'] . '.' . $file_extension;
        $target_file = $target_dir . $profile_image;
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);
    }
    
    // Update employee
    $query = "UPDATE users SET name = :name, email = :email, phone = :phone, department = :department, 
              position = :position, salary = :salary, status = :status, profile_image = :profile_image 
              WHERE id = :id";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':salary', $salary);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':profile_image', $profile_image);
    $stmt->bindParam(':id', $employee_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Employee updated successfully!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update employee!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
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
        <div class="card" style="max-width: 800px; margin: 50px auto;">
            <h2>Edit Employee - <?php echo htmlspecialchars($employee['name']); ?></h2>
            
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label for="name">Full Name:</label>
                        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($employee['name']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($employee['phone']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="department">Department:</label>
                        <select name="department" id="department" class="form-control" required>
                            <option value="IT" <?php echo $employee['department'] == 'IT' ? 'selected' : ''; ?>>IT</option>
                            <option value="HR" <?php echo $employee['department'] == 'HR' ? 'selected' : ''; ?>>HR</option>
                            <option value="Finance" <?php echo $employee['department'] == 'Finance' ? 'selected' : ''; ?>>Finance</option>
                            <option value="Marketing" <?php echo $employee['department'] == 'Marketing' ? 'selected' : ''; ?>>Marketing</option>
                            <option value="Operations" <?php echo $employee['department'] == 'Operations' ? 'selected' : ''; ?>>Operations</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="position">Position:</label>
                        <input type="text" id="position" name="position" class="form-control" value="<?php echo htmlspecialchars($employee['position']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="salary">Salary:</label>
                        <input type="number" id="salary" name="salary" class="form-control" step="0.01" value="<?php echo $employee['salary']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="status">Status:</label>
                        <select name="status" id="status" class="form-control" required>
                            <option value="active" <?php echo $employee['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo $employee['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Current Profile Image:</label>
                    <?php if ($employee['profile_image']): ?>
                        <img src="uploads/profiles/<?php echo $employee['profile_image']; ?>" alt="Profile" style="width: 100px; height: 100px; border-radius: 10px; object-fit: cover; margin: 10px 0;">
                    <?php else: ?>
                        <p>No image uploaded</p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="profile_image">Update Profile Image:</label>
                    <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-primary">Update Employee</button>
                <a href="admin_dashboard.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>