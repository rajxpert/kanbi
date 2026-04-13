<?php
session_start();
require_once 'config/database.php';

// Set timezone to India
date_default_timezone_set('Asia/Kolkata');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit();
}

$database = new Database();
$db = $database->getConnection();

$input = json_decode(file_get_contents('php://input'), true);
$action = $input['action'];
$photo = $input['photo'];
$location = isset($input['location']) ? $input['location'] : null;

$today = date('Y-m-d');
$current_time = date('Y-m-d H:i:s');

if ($action == 'check_in') {
    // Check if already checked in today
    $check_query = "SELECT id FROM attendance WHERE employee_id = :employee_id AND date = :date";
    $check_stmt = $db->prepare($check_query);
    $check_stmt->bindParam(':employee_id', $_SESSION['employee_id']);
    $check_stmt->bindParam(':date', $today);
    $check_stmt->execute();
    
    if ($check_stmt->rowCount() > 0) {
        echo json_encode(['success' => false, 'message' => 'Already checked in today']);
        exit();
    }
    
    // Save photo
    $photo_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
    $photo_name = $_SESSION['employee_id'] . '_checkin_' . date('Ymd_His') . '.jpg';
    $photo_path = 'uploads/attendance/' . $photo_name;
    file_put_contents($photo_path, $photo_data);
    
    // Insert check-in record with location
    $query = "INSERT INTO attendance (employee_id, check_in_time, check_in_photo, check_in_location, date) 
              VALUES (:employee_id, :check_in_time, :photo, :location, :date)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':employee_id', $_SESSION['employee_id']);
    $stmt->bindParam(':check_in_time', $current_time);
    $stmt->bindParam(':photo', $photo_name);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':date', $today);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Check-in successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Check-in failed']);
    }
    
} elseif ($action == 'check_out') {
    // Get today's attendance record
    $att_query = "SELECT * FROM attendance WHERE employee_id = :employee_id AND date = :date";
    $att_stmt = $db->prepare($att_query);
    $att_stmt->bindParam(':employee_id', $_SESSION['employee_id']);
    $att_stmt->bindParam(':date', $today);
    $att_stmt->execute();
    
    if ($att_stmt->rowCount() == 0) {
        echo json_encode(['success' => false, 'message' => 'No check-in record found for today']);
        exit();
    }
    
    $attendance = $att_stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($attendance['check_out_time']) {
        echo json_encode(['success' => false, 'message' => 'Already checked out today']);
        exit();
    }
    
    // Save photo
    $photo_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $photo));
    $photo_name = $_SESSION['employee_id'] . '_checkout_' . date('Ymd_His') . '.jpg';
    $photo_path = 'uploads/attendance/' . $photo_name;
    file_put_contents($photo_path, $photo_data);
    
    // Update check-out record with location
    $query = "UPDATE attendance SET check_out_time = :check_out_time, check_out_photo = :photo, check_out_location = :location 
              WHERE employee_id = :employee_id AND date = :date";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':check_out_time', $current_time);
    $stmt->bindParam(':photo', $photo_name);
    $stmt->bindParam(':location', $location);
    $stmt->bindParam(':employee_id', $_SESSION['employee_id']);
    $stmt->bindParam(':date', $today);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Check-out successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Check-out failed']);
    }
}
?>