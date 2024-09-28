<?php
if (session_status() === PHP_SESSION_NONE) {  //aron ma wala ang doble nga session start
    session_start();
}


// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../views/index.php");
    exit;
}
?>
