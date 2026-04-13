<?php
session_start();
require_once 'config/database.php';

if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();
    
    $employee_id = $_POST['employee_id'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
    $query = "SELECT * FROM users WHERE employee_id = :employee_id AND role = :role AND status = 'active' ";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':role', $role);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['employee_id'] = $user['employee_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            // Log login activity with location
            $login_query = "INSERT INTO activity_logs (employee_id, activity_type, location, ip_address, user_agent) VALUES (:employee_id, 'login', :location, :ip_address, :user_agent)";
            $login_stmt = $db->prepare($login_query);
            $login_stmt->bindParam(':employee_id', $employee_id);
            $location = isset($_POST['location']) ? $_POST['location'] : 'Unknown';
            $login_stmt->bindParam(':location', $location);
            $login_stmt->bindParam(':ip_address', $_SERVER['REMOTE_ADDR']);
            $login_stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);
            $login_stmt->execute();
            
            if ($role == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: employee_dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Invalid password!";
        }
    } else {
        $_SESSION['error'] = "Invalid employee ID or role!";
    }
    
    header("Location: index.php");
    exit();
}
?>