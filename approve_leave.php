<?php
session_start();
require_once 'config/database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $database = new Database();
    $db = $database->getConnection();
    
    $leave_id = $_GET['id'];
    $action = $_GET['action'];
    
    if ($action == 'approve') {
        $status = 'approved';
        $message = 'Leave request approved successfully!';
    } elseif ($action == 'reject') {
        $status = 'rejected';
        $message = 'Leave request rejected successfully!';
    } else {
        $_SESSION['error'] = 'Invalid action!';
        header("Location: admin_dashboard.php");
        exit();
    }
    
    $query = "UPDATE leave_requests SET status = :status WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $leave_id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = $message;
    } else {
        $_SESSION['error'] = 'Failed to update leave request!';
    }
    
    header("Location: admin_dashboard.php");
    exit();
}
?>