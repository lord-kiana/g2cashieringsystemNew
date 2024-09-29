<?php
require_once "../classes/User.php";
session_start(); // Start the session to use session variables

$user = new User();

// Check if the registration form is submitted
if (isset($_POST['register'])) {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);  // Hash the password

    // Attempt to register the user
    if ($user->register($first_name, $last_name, $username, $password)) {
        // Successful registration, redirect to login page
        header("Location: ../index.php");
        exit;
    } else {
        // Show error if registration fails
        echo "Registration failed: " . $user->getError();
    }
}

// Check if the login form is submitted
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

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
        // Show error if login fails
        echo "Login failed: " . $user->getError();
    }
}


?>
