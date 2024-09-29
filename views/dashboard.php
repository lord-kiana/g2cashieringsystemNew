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
        $error = true;
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* adjust this value to match the height of your navigation bar */
        }
    </style>
</head>

<body>

    <?php include 'navbar.php'; ?> <!-- Include the navbar -->

    <?php if (isset($error)): ?>
        <div class="alert alert-warning" role="alert">
            Not enough stock available for this product.
        </div>
    <?php endif; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1 class="display-3 text-center">Dashboard</h1>
            </div>

        <h2 id="products">Select Products</h2>
        <div class="row">
            
                <div class="text-end mt-3">
                    <a href="cart.php" class="btn btn-success">
                        <i class="bi bi-cart-check"></i> View Cart
                    </a>
                </div>

            <?php foreach ($products as $p): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= $p['product_name']; ?></h5>
                        <p class="card-text">Price: Php <?= $p['price']; ?></p>
                        <p class="card-text">Stock: <?= $p['quantity']; ?></p>
                    </div>
                    <div class="card-footer text-end">
                        <form action="dashboard.php" method="post">
                            <input type="hidden" name="product_id" value="<?= $p['product_id']; ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i> Add to Cart
                            </button>
                            <?php 
                            if (isset($_SESSION['cart'][$p['product_id']])): 
                                $cart_quantity = $_SESSION['cart'][$p['product_id']]['quantity']; 
                            ?>
                                <span class="badge bg-secondary ms-2">In Cart: <?= $cart_quantity; ?></span>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>