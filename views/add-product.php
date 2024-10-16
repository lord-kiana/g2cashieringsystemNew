<?php require_once('../actions/require_login.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa; /* Light background */
            color: #343a40; /* Dark text color */
            height: 100vh; /* Full viewport height */
            display: flex; /* Flexbox for centering */
            align-items: center; /* Vertically center */
            justify-content: center; /* Horizontally center */
            margin: 0; /* Remove default margin */
        }

        .card {
            background-color: #ffffff; /* White background */
            border: 1px solid #dee2e6; /* Light border color */
            width: 400px; /* Set a fixed width for the card */
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

    <div class="card">
        <div class="card-header">
            <h1 class="display-4">Add New Product</h1>
        </div>
        <div class="card-body">
    <form action="../actions/product-actions.php" method="POST">
        <div class="mb-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" name="product_name" id="product_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" name="add_product" class="btn btn-success">Add Product</button>
            <a href="manage-inventory.php" class="btn btn-danger">
                <i class="bi bi-back-arrow"></i> Back
            </a>
        </div>
    </form>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>