<?php
require_once('../actions/require_login.php');
require_once "../classes/Product.php";

$product = new Product();
$products = $product->displayProducts();

// Initialize cart if it's not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding a product to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    
    // Set the quantity to 1 by default when adding a product
    $quantity = 1;

    // Fetch product details
    $product_details = $product->displaySpecificProduct($product_id);
    
    // Check if the requested quantity exceeds available stock
    $current_cart_quantity = isset($_SESSION['cart'][$product_id]) ? $_SESSION['cart'][$product_id]['quantity'] : 0;
    $total_requested_quantity = $current_cart_quantity + $quantity;

    if ($product_details && $total_requested_quantity <= $product_details['quantity']) {
        // Add to cart with the default quantity of 1
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'name' => $product_details['product_name'], 
                'price' => $product_details['price'], 
                'quantity' => $quantity
            ];
        } else {
            // Update quantity if the product is already in the cart
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        }
    } else {
        // Display an error message if requested quantity exceeds stock
        echo "<p class='text-danger'>Not enough stock available for this product.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashiering Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the brand name */
        .navbar-brand {
            font-size: 2rem; /* Makes the brand name larger */
            color: #f8f9fa !important; /* Light color (using Bootstrap's light color) */
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">AB Meat Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Menu Icon for Logout -->
                    <li class="nav-item">
                     <!-- Menu Icon for Logout -->
<li class="nav-item">
    <button class="btn btn-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLogout" aria-controls="offcanvasLogout">
        <i class="bi bi-list"></i> 
    </button>
</li>

                    </li>
                </ul>
            </div>
        </div>
    </nav>

<!-- Offcanvas Logout Menu -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasLogout" aria-labelledby="offcanvasLogoutLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasLogoutLabel">Options</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <p>Are you sure you want to logout?</p>
        <div class="d-grid gap-2">
        <a href="manage-inventory.php" class="btn btn-success">
                <i class="bi bi-gear-fill"></i> Manage Inventory
            </a>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
            <a href="../actions/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>


    <!-- Add margin-top to avoid content overlap with fixed navbar -->
    <div class="container mt-5 pt-5">
        <h1 class="display-4 text-center">Cashiering Dashboard</h1>

    <!-- Main Dashboard Content -->
    <div class="container" id="main-container">
        <h1 class="display-4 text-center">Cashiering Dashboard</h1>

        <!-- Select Products and Add to Cart -->
        <h2>Select Products</h2>
        <div class="row">
            <?php foreach ($products as $p): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $p['product_name']; ?></h5>
                        <p class="card-text">Price: $<?= $p['price']; ?></p>
                        <p class="card-text">Stock: <?= $p['quantity']; ?></p>
                    </div>
                    <div class="card-footer text-end">
                        <form action="dashboard.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $p['id']; ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </button>

                            <!-- Cart Quantity Indicator -->
                            <?php if (isset($_SESSION['cart'][$p['id']])): 
                                $cart_quantity = $_SESSION['cart'][$p['id']]['quantity']; ?>
                                <span class="badge bg-secondary ms-2">In Cart: <?= $cart_quantity; ?></span>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- View Cart / Checkout Button -->
        <div class="text-end mt-3">
            <a href="cart.php" class="btn btn-success">
                <i class="bi bi-cart-check"></i> View Cart / Checkout
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
