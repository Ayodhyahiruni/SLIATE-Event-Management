<?php
session_start();

// Destroy all session data
session_destroy();

// Redirect to login page with success message
session_start();
$_SESSION['success'] = "You have been successfully logged out.";
header("Location: login.php");
exit();
?>

