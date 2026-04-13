<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

require_once 'config/database.php';

if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $join_date = $_POST['join_date'];
    $password = $_POST['password'];
    
    // Check if email exists
    $check_query = "SELECT id FROM users WHERE email = :email";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(':email', $email);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email already exists!";
    } else {
        // Generate employee ID
        $emp_query = "SELECT COUNT(*) as count FROM users WHERE role = 'employee'";
        $emp_stmt = $db->prepare($emp_query);
        $emp_stmt->execute();
        $emp_count = $emp_stmt->fetch(PDO::FETCH_ASSOC)['count'];
        $employee_id = 'EMP' . str_pad($emp_count + 1, 4, '0', STR_PAD_LEFT);
        
        // Handle profile image
        $profile_image = null;
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $target_dir = "uploads/profiles/";
            $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
            $profile_image = $employee_id . '.' . $file_extension;
            $target_file = $target_dir . $profile_image;
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);
        }
        
        // Insert employee
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (employee_id, name, email, password, phone, department, position, salary, join_date, profile_image) 
                  VALUES (:employee_id, :name, :email, :password, :phone, :department, :position, :salary, :join_date, :profile_image)";
        
        $stmt = $db->prepare($query);
        $stmt->bindParam(':employee_id', $employee_id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':department', $department);
        $stmt->bindParam(':position', $position);
        $stmt->bindParam(':salary', $salary);
        $stmt->bindParam(':join_date', $join_date);
        $stmt->bindParam(':profile_image', $profile_image);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Employee added successfully! Employee ID: " . $employee_id;
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Failed to add employee!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
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
            <h2>Add New Employee</h2>
            
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
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone:</label>
                        <input type="tel" id="phone" name="phone" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="department">Department:</label>
                        <select name="department" id="department" class="form-control" required>
                            <option value="">Select Department</option>
                            <option value="IT">IT</option>
                            <option value="HR">HR</option>
                            <option value="Finance">Finance</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Operations">Operations</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="position">Position:</label>
                        <input type="text" id="position" name="position" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="salary">Salary:</label>
                        <input type="number" id="salary" name="salary" class="form-control" step="0.01" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="join_date">Join Date:</label>
                        <input type="date" id="join_date" name="join_date" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="profile_image">Profile Image:</label>
                    <input type="file" id="profile_image" name="profile_image" class="form-control" accept="image/*">
                </div>
                
                <button type="submit" class="btn btn-primary">Add Employee</button>
                <a href="admin_dashboard.php" class="btn btn-danger">Cancel</a>
            </form>
        </div>
    </div>
</body>
</html>