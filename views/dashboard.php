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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        /* Sidebar styling for left-side placement */
        .sidebar {
            position: fixed;
            top: 0;
            left: -250px;
            height: 100%;
            width: 250px;
            background-color: #333;
            color: #fff;
            padding-top: 20px;
            transition: left 0.3s ease;
        }

        /* When sidebar is shown */
        .sidebar.show {
            left: 0;
        }

        .navbar-dark .navbar-toggler {
            position: relative;
            z-index: 1050; /* Ensure the button stays above the collapse */
        }

        .navbar-nav {
            flex-direction: column;
            padding-left: 0;
            padding-top: 20px;
        }

        .nav-link {
            color: #fff;
            padding: 10px;
        }

        .nav-link:hover {
            background-color: #444;
        }

        /* Positioning Logout button at the bottom */
        .mt-auto {
            margin-top: auto;
        }

        /* Ensuring the main container stays in place */
        .container {
            margin-top: 50px;
            margin-left: 500px;
            transition: margin-left 0.3s ease;
        }

    </style>
</head>

<body>
    <!-- Navbar at the top that toggles the sidebar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Sidebar that opens on the left -->
    <div class="sidebar" id="sidebar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="manage-inventory.php">
                    <i class="bi bi-gear-fill"></i> Manage Inventory
                </a>
            </li>
        </ul>
        <ul class="navbar-nav mt-auto">
            <li class="nav-item">
                <a class="nav-link" href="../actions/logout.php">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </div>

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

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            var mainContainer = document.getElementById('main-container');

            // Toggle the sidebar visibility
            sidebar.classList.toggle('show');
            mainContainer.classList.toggle('shifted');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
