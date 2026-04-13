<?php
session_start();
require_once 'config/database.php';

if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $join_date = $_POST['join_date'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: register.php");
        exit();
    }
    
    // Check if email already exists
    $check_query = "SELECT id FROM users WHERE email = :email";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(':email', $email);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        $_SESSION['error'] = "Email already exists!";
        header("Location: register.php");
        exit();
    }
    
    // Generate employee ID
    $emp_query = "SELECT COUNT(*) as count FROM users WHERE role = 'employee'";
    $emp_stmt = $db->prepare($emp_query);
    $emp_stmt->execute();
    $emp_count = $emp_stmt->fetch(PDO::FETCH_ASSOC)['count'];
    $employee_id = 'EMP' . str_pad($emp_count + 1, 4, '0', STR_PAD_LEFT);
    
    // Handle profile image upload
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = "uploads/profiles/";
        $file_extension = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $profile_image = $employee_id . '.' . $file_extension;
        $target_file = $target_dir . $profile_image;
        
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            // File uploaded successfully
        } else {
            $profile_image = null;
        }
    }
    
    // Insert user
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $query = "INSERT INTO users (employee_id, name, email, password, phone, department, position, join_date, profile_image) 
              VALUES (:employee_id, :name, :email, :password, :phone, :department, :position, :join_date, :profile_image)";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':department', $department);
    $stmt->bindParam(':position', $position);
    $stmt->bindParam(':join_date', $join_date);
    $stmt->bindParam(':profile_image', $profile_image);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Registration successful! Your Employee ID is: " . $employee_id;
        header("Location: index.php");
    } else {
        $_SESSION['error'] = "Registration failed! Please try again.";
        header("Location: register.php");
    }
    exit();
}
?>