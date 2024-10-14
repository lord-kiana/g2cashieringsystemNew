<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not an admin, show an alert and then redirect
    echo "<script>alert('Access denied: Please use an admin account!');</script>";
    echo "<script>window.location.href = 'cashier_dashboard.php';</script>"; // Redirect to dashboard
    exit; // Stop further execution of the script
}

// Start session and require login
require_once('../actions/require_login.php');

// Include the User class to interact with the database
require_once "../classes/User.php";

// Initialize variables
$message = ''; // Initialize the message variable
$users = [];   // Initialize the users array

// Create a new User instance and fetch all users
$user = new User();
$users = $user->getAllUsers(); // Make sure this method is implemented in your User class

// Check for messages in the URL
if (isset($_GET['message'])) {
    $message = htmlspecialchars(string: $_GET['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin User List</title>
    <link rel="stylesheet" href="../css/adminList.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
/* Body Styles */
        body {
            background-color: #FCFAEE; /* Off-white background */
            color: #343a40; /* Dark text color */
            height: 100vh; /* Full viewport height */
            display: flex; /* Flexbox for centering */
            justify-content: center; /* Horizontally center */
            margin: 0; /* Remove default margin */
            padding-top: 60px; /* Adjust this value to match the height of your navigation bar */
        }

        /* Heading (h1) */
        h1 {
            color: #DA8359; /* Warm Orange for headings */
            font-size: 2.5rem; /* Adjust font size */
            text-align: center; /* Center align the heading */
            margin-bottom: 20px; /* Space below the heading */
        }

        /* Card Styles */
        .card {
            background-color: #ECDFCC; /* Soft Beige background */
            border: 1px solid #A5B68D; /* Muted Green border */
            width: 800px; /* Set a fixed width for the card */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            border-radius: 10px; /* Add a rounded corner */
            padding: 20px; /* Padding inside the card */
        }

        /* User List Container (assuming class is 'user-list-container') */
        .user-list-container {
            background-color: #ECDFCC; /* Soft Beige background */
            border: 1px solid #A5B68D; /* Muted Green border */
            padding: 15px; /* Add padding inside */
            border-radius: 8px; /* Add rounded corners */
            margin-top: 20px; /* Space between other elements and the container */
        }

    </style>
</head>
<body>

<?php include 'navbar.php'; ?> <!-- Include the navbar -->

<div class="container mt-5">

   
    <div class="col-md-12">
                <h1 class="display-3 text-center"> Admin User List</h1>
            </div>
    <!-- Message Display -->
    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message; ?></div>
    <?php endif; ?>



    <!-- User Table in a Scrollable Container -->
    <div class="user-list-container">
        <table class="table table-striped mt-4">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <th scope="row"><?= $user['id']; ?></th>
                        <td><?= $user['first_name']; ?></td>
                        <td><?= $user['last_name']; ?></td>
                        <td><?= $user['username']; ?></td>
                        <td><?= $user['role']; ?></td>
                        <td>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $user['id']; ?>">Edit</button>
                        </td>
                    </tr>
                    
                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal<?= $user['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit User</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="../actions/admin-actions.php" method="post"> <!-- Change this to your action file -->
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $user['id']; ?>">
                                        <div class="mb-3">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= $user['first_name']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= $user['last_name']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?= $user['username']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="role" class="form-label">Role</label>
                                            <select class="form-select" id="role" name="role" required>
                                                <option value="admin" <?= ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                <option value="cashier" <?= ($user['role'] === 'cashier') ? 'selected' : ''; ?>>Cashier</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a href="../actions/delete-product.php?id=<?= $p['product_id']; ?>" class="btn btn-danger primary"
                                        onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>