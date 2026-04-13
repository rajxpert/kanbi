<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: index.php");
    exit();
}

if ($_POST) {
    $database = new Database();
    $db = $database->getConnection();
    
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $reason = $_POST['reason'];
    
    // Validate dates
    if (strtotime($start_date) > strtotime($end_date)) {
        $_SESSION['error'] = "End date cannot be before start date!";
        header("Location: employee_dashboard.php");
        exit();
    }
    
    // Check for overlapping leave requests
    $overlap_query = "SELECT id FROM leave_requests 
                      WHERE employee_id = :employee_id 
                      AND status != 'rejected'
                      AND ((start_date <= :start_date AND end_date >= :start_date) 
                           OR (start_date <= :end_date AND end_date >= :end_date)
                           OR (start_date >= :start_date AND end_date <= :end_date))";
    
    $overlap_stmt = $db->prepare($overlap_query);
    $overlap_stmt->bindParam(':employee_id', $_SESSION['employee_id']);
    $overlap_stmt->bindParam(':start_date', $start_date);
    $overlap_stmt->bindParam(':end_date', $end_date);
    $overlap_stmt->execute();
    
    if ($overlap_stmt->rowCount() > 0) {
        $_SESSION['error'] = "You already have a leave request for these dates!";
        header("Location: employee_dashboard.php");
        exit();
    }
    
    // Insert leave request
    $query = "INSERT INTO leave_requests (employee_id, leave_type, start_date, end_date, reason) 
              VALUES (:employee_id, :leave_type, :start_date, :end_date, :reason)";
    
    $stmt = $db->prepare($query);
    $stmt->bindParam(':employee_id', $_SESSION['employee_id']);
    $stmt->bindParam(':leave_type', $leave_type);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
    $stmt->bindParam(':reason', $reason);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Leave request submitted successfully!";
    } else {
        $_SESSION['error'] = "Failed to submit leave request!";
    }
    
    header("Location: employee_dashboard.php");
    exit();
}
?>