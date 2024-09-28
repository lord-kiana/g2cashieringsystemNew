<?php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the login page after logging out
header("Location: ../index.php"); // Adjust the path to your login page
exit;
?>
