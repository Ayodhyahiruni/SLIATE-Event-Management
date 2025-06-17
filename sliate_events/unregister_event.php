<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    $_SESSION['error'] = "Please login to access this feature.";
    header("Location: login.php");
    exit();
}

// Get event ID from URL
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$event_id) {
    $_SESSION['error'] = "Invalid event ID.";
    header("Location: dashboard.php");
    exit();
}

try {
    // Check if user is registered for this event
    $stmt = $pdo->prepare("SELECT * FROM student_events WHERE student_id = ? AND event_id = ?");
    $stmt->execute([$_SESSION['student_id'], $event_id]);
    $registration = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$registration) {
        $_SESSION['error'] = "You are not registered for this event.";
        header("Location: dashboard.php");
        exit();
    }
    
    // Get event details
    $stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$event) {
        $_SESSION['error'] = "Event not found.";
        header("Location: dashboard.php");
        exit();
    }
    
    // Check if event has already occurred
    $event_datetime = $event['event_date'] . ' ' . $event['event_time'];
    if (strtotime($event_datetime) < time()) {
        $_SESSION['error'] = "Cannot unregister from past events.";
        header("Location: dashboard.php");
        exit();
    }
    
    // Unregister the user from the event
    $pdo->beginTransaction();
    
    try {
        // Delete registration
        $stmt = $pdo->prepare("DELETE FROM student_events WHERE student_id = ? AND event_id = ?");
        $stmt->execute([$_SESSION['student_id'], $event_id]);
        
        // Update participant count
        $stmt = $pdo->prepare("UPDATE events SET current_participants = current_participants - 1 WHERE event_id = ? AND current_participants > 0");
        $stmt->execute([$event_id]);
        
        $pdo->commit();
        
        $_SESSION['success'] = "Successfully unregistered from '" . $event['title'] . "'.";
        header("Location: dashboard.php");
        exit();
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Unregistration failed. Please try again.";
        header("Location: dashboard.php");
        exit();
    }
    
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error occurred. Please try again.";
    header("Location: dashboard.php");
    exit();
}
?>

