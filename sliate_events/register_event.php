<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    $_SESSION['error'] = "Please login to register for events.";
    header("Location: login.php");
    exit();
}

// Get event ID from URL
$event_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!$event_id) {
    $_SESSION['error'] = "Invalid event ID.";
    header("Location: event.php");
    exit();
}

try {
    // Get event details
    $stmt = $pdo->prepare("SELECT * FROM events WHERE event_id = ? AND status = 'active'");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$event) {
        $_SESSION['error'] = "Event not found or not available for registration.";
        header("Location: event.php");
        exit();
    }
    
    // Check if user is already registered
    $stmt = $pdo->prepare("SELECT * FROM student_events WHERE student_id = ? AND event_id = ?");
    $stmt->execute([$_SESSION['student_id'], $event_id]);
    $existing_registration = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existing_registration) {
        $_SESSION['error'] = "You are already registered for this event.";
        header("Location: event.php");
        exit();
    }
    
    // Check if event is full
    if ($event['max_participants'] && $event['current_participants'] >= $event['max_participants']) {
        $_SESSION['error'] = "This event is full. Registration is no longer available.";
        header("Location: event.php");
        exit();
    }
    
    // Check if event date has passed
    $event_datetime = $event['event_date'] . ' ' . $event['event_time'];
    if (strtotime($event_datetime) < time()) {
        $_SESSION['error'] = "Registration is closed. This event has already occurred.";
        header("Location: event.php");
        exit();
    }
    
    // Register the user for the event
    $pdo->beginTransaction();
    
    try {
        // Insert registration
        $stmt = $pdo->prepare("INSERT INTO student_events (student_id, event_id) VALUES (?, ?)");
        $stmt->execute([$_SESSION['student_id'], $event_id]);
        
        // Update participant count
        $stmt = $pdo->prepare("UPDATE events SET current_participants = current_participants + 1 WHERE event_id = ?");
        $stmt->execute([$event_id]);
        
        $pdo->commit();
        
        $_SESSION['success'] = "Successfully registered for '" . $event['title'] . "'!";
        header("Location: dashboard.php");
        exit();
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        $_SESSION['error'] = "Registration failed. Please try again.";
        header("Location: event.php");
        exit();
    }
    
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error occurred. Please try again.";
    header("Location: event.php");
    exit();
}
?>

