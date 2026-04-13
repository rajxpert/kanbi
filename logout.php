<?php
session_start();

if (isset($_SESSION['employee_id'])) {
    require_once 'config/database.php';
    $database = new Database();
    $db = $database->getConnection();
    
    // Log logout activity with location
    $logout_query = "INSERT INTO activity_logs (employee_id, activity_type, location, ip_address, user_agent) VALUES (:employee_id, 'logout', :location, :ip_address, :user_agent)";
    $logout_stmt = $db->prepare($logout_query);
    $logout_stmt->bindParam(':employee_id', $_SESSION['employee_id']);
    $location = isset($_POST['location']) ? $_POST['location'] : 'Unknown';
    $logout_stmt->bindParam(':location', $location);
    $logout_stmt->bindParam(':ip_address', $_SERVER['REMOTE_ADDR']);
    $logout_stmt->bindParam(':user_agent', $_SERVER['HTTP_USER_AGENT']);
    $logout_stmt->execute();
}

session_destroy();
header("Location: index.php");
exit();
?>