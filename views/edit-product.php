<?php
require_once('../actions/require_login.php');
require_once "../classes/Product.php";

$product = new Product();

// Fetch the specific product by ID
$product_id = $_GET['id'];  // Changed from $_GET['product_id'] to $_GET['id']
$product_details = $product->displaySpecificProduct($product_id);

if (!$product_details) {
    die("Product not found");
}

// Check for success message
$success_message = isset($_GET['success']) ? htmlspecialchars($_GET['success'], ENT_QUOTES, 'UTF-8') : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
            <h1 class="display-4">Edit Product</h1>
        </div>
        <div class="card-body">

        <form action="../actions/product-actions.php?id=<?= $product_id ?>" method="post">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" value="<?= htmlspecialchars($product_details['product_name'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="<?= htmlspecialchars($product_details['price'], ENT_QUOTES, 'UTF-8') ?>" step="0.01" required>
            
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="<?= htmlspecialchars($product_details['quantity'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="d-flex justify-content-between">
                    <button type="submit" name="edit_product" class="btn btn-success">Update Product</button>
                    <a href="manage-inventory.php" class="btn btn-danger">
                        <i class="bi bi-back-arrow"></i> Back
                    </a>
            </div>    
        </form>
    </div>
</div>

<!-- Success Modal -->
<?php if ($success_message): ?>
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel" style="color: green;">Success</h5> <!-- Inline style to change text color to green -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: green;"> <!-- Inline style for the message -->
                    <?= $success_message ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeBtn">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.getElementById('closeBtn').addEventListener('click', function () {
            window.location.href = '../views/manage-inventory.php'; 
        });
    </script>
<?php endif; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Show the modal if the success message exists
        <?php if ($success_message): ?>
            var myModal = new bootstrap.Modal(document.getElementById('successModal'));
            myModal.show();
        <?php endif; ?>
    </script>

</body>
</html>
