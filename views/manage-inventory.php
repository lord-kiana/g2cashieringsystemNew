<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    // If the user is not an admin, show an alert and then redirect
    echo "<script>alert('Access denied: Please use an admin account!');</script>";
    echo "<script>window.location.href = 'dashboard.php';</script>"; // Redirect to dashboard
    exit; // Stop further execution of the script
}


// If the user is an admin, continue with inventory management code
require_once('../actions/require_login.php');
require_once "../classes/Product.php";

$product = new Product();
$products = $product->displayProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light background */
            color: #343a40; /* Dark text color */
            height: 100vh; /* Full viewport height */
            display: flex; /* Flexbox for centering */
            align-items: center; /* Vertically center */
            justify-content: center; /* Horizontally center */
            margin: 0; /* Remove default margin */
            padding-top: 60px; /* adjust this value to match the height of your navigation bar */
        }

        .card {
            background-color: #ffffff; /* White background */
            border: 1px solid #dee2e6; /* Light border color */
            width: 800px; /* Set a fixed width for the card */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
        }

        .card-header {
            background-color: #343a40; /* Dark header background */
            color: #ffffff; /* White text color */
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?> <!-- Include the navbar -->

<div class="container mt-5 pt-5" style="overflow-y: auto; max-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card">
                <div class="card-header">
                    <h1 class="display-4 text-center">Inventory</h1>
                </div>
                <div class="card-body">

                    <!-- Add Product Button -->
                    <div class="text-end mb-3">
                        <a href="add-product.php" class="btn btn-success w-100">Add Product</a>
                    </div>

                    <!-- Product Table -->
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">Actions</th> <!-- Edit and Delete options -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $p): ?>
                                    <tr>
                                        <td class="text-center"><?= htmlspecialchars($p['product_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-center"><?= htmlspecialchars($p['product_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="text-center"><?= number_format($p['price'], 2); ?></td>
                                        <td class="text-center"><?= $p['quantity']; ?></td>
                                        <td class="text-center">
                                            <!-- Edit Button -->
                                            <a href="edit-product.php?id=<?= $p['product_id']; ?>" class="btn btn-warning btn-sm">Edit</a>

                                            <!-- Delete Button -->
                                            <a href="../actions/delete-product.php?id=<?= $p['product_id']; ?>" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No products available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>