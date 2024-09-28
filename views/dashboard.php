<?php
require_once('../actions/require_login.php');
require_once "../classes/Product.php";

$product = new Product();
$products = $product->displayProducts();

// Initialize cart if it's not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the user is an admin (replace with your actual admin check)
$is_admin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'; // Example condition

// Handle adding a product to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];

    // Fetch product details
    $product_details = $product->displaySpecificProduct($product_id);

    // Check if the product exists and has available stock
    if ($product_details) {
        // Check if the product is already in the cart
        if (isset($_SESSION['cart'][$product_id])) {
            // Increment the quantity in the cart
            if ($_SESSION['cart'][$product_id]['quantity'] < $product_details['quantity']) {
                $_SESSION['cart'][$product_id]['quantity']++;
            } else {
                echo "<p class='text-danger'>Not enough stock available for this product.</p>";
            }
        } else {
            // Add the product to the cart with quantity 1
            $_SESSION['cart'][$product_id] = [
                'name' => $product_details['product_name'],
                'price' => $product_details['price'],
                'quantity' => 1
            ];
        }
    }
    
    // Redirect to avoid resubmission on page refresh
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashiering Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <script>
        function checkAdmin() {
            // Check if the user is an admin )
            const isAdmin = <?= json_encode($is_admin); ?>; // Pass PHP variable to JavaScript
            if (!isAdmin) {
                alert('Unauthorized Access, Please use an admin account.');
                return false; // Prevent navigation
            }
            return true; // Allow navigation
        }
    </script>
</head>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">AB Meat Shop</a>
        <div class="ms-auto">
            <a href="../actions/logout.php" class="btn btn-danger">Logout</a>
        </div>
        </div>
    </nav>

<body>
    <div class="container mt-5">
        <h1 class="display-4 text-center">Cashiering Dashboard</h1>

        <!-- Manage Inventory Button -->
        <div class="text-end mb-3">
            <a href="manage-inventory.php" class="btn btn-success" onclick="return checkAdmin()">
                <i class="bi bi-gear-fill"></i> Manage Inventory
            </a>
        </div>

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
                            <?php 
                            if (isset($_SESSION['cart'][$p['id']])): 
                                $cart_quantity = $_SESSION['cart'][$p['id']]['quantity']; 
                            ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
