<?php
require_once "../classes/User.php";
session_start(); // Start the session to use session variables

$user = new User();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Attempt to log in the user
    if ($user->login($username, $password)) {
        // Set session variables after successful login
        $_SESSION['user_id'] = $user->getUserId(); // Store user ID in session
        $_SESSION['username'] = $username;         // Store username in session

        // Fetch user details, including the role
        $user_details = $user->getUserDetails($username); // Fetch role from DB
        if ($user_details) {
            $_SESSION['role'] = $user_details['role'];    // Store the role in session
        } else {
            echo "Failed to retrieve user details.";
        }

        // Redirect to dashboard after successful login
        header("Location: ../views/dashboard.php");
        exit;
    } else {
        echo "Login failed: " . $user->getError();
    }
}

if (isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash the password before storing it

    // Attempt to register the user
    if ($user->register($first_name, $last_name, $username, $password)) {
        // Redirect to login page if registration is successful
        header("Location: ../index.php");
        exit;
    } else {
        // If registration fails, show the error
        echo "Registration failed: " . $user->getError();
    }
} else {
    echo "Registration form not submitted.<br>";
}
?>
