<?php
session_start();
require_once('../actions/require_login.php');
require_once "../classes/Product.php";
require_once "../classes/Sales.php";

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not an admin, show an alert and then redirect
    echo "<script>alert('Access denied: Please use an admin account!');</script>";
    echo "<script>window.location.href = 'cashier_dashboard.php';</script>"; // Redirect to dashboard
    exit; // Stop further execution of the script
}

// Ensure the user is logged in as an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../views/admin_dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<!-- Include the navigation bar -->
<?php include 'navbar.php'; ?>

<!-- Main container with consistent design -->
<div class="container my-5 p-5 bg-white rounded shadow-lg">
    <h1 class="text-center mb-4">Admin Dashboard</h1>

    <!-- First Row for dashboard cards -->
    <div class="row g-4 justify-content-center">
        <!-- Cashier Card -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Cashier</h5>
                    <p class="card-text flex-grow-1">Create Transactions and Print Receipts</p>
                    <a href="cashier_dashboard.php" class="btn btn-primary mt-auto">Cashier</a>
                </div>
            </div>
        </div>

        <!-- Manage Users Card -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text flex-grow-1">Update Users</p>
                    <a href="adminList.php" class="btn btn-primary mt-auto">Manage Users</a>
                </div>
            </div>
        </div>
    </div> <!-- End First Row -->

    <!-- Second Row for dashboard cards -->
    <div class="row g-4 justify-content-center mt-4">
        <!-- Manage Products Card -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">Manage Products</h5>
                    <p class="card-text flex-grow-1">Update Product Prices</p>
                    <a href="manage-inventory.php" class="btn btn-primary mt-auto">Manage Products</a>
                </div>
            </div>
        </div>

        <!-- View Reports Card -->
        <div class="col-md-4">
            <div class="card text-center shadow-sm h-100">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">View Reports</h5>
                    <p class="card-text flex-grow-1">Generate Sales and Payment Reports</p>
                    <a href="sales-report.php" class="btn btn-primary mt-auto">View Reports</a>
                </div>
            </div>
        </div>
    </div> <!-- End Second Row -->
</div> <!-- End Container -->


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
