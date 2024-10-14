<?php
session_start();
require_once('../actions/require_login.php');
require_once "../classes/Product.php";
require_once "../classes/Sales.php";

$product = new Product();
$sales = new Sales();
$products = $product->displayProducts();
$total = 0;

// Initialize cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding a product to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    
    // Set the quantity to 1 by default when adding a product
    $quantity = 1;

    // Fetch product details (without worrying about stock)
    $product_details = $product->displaySpecificProduct($product_id);

    if ($product_details) {
        // Add to cart with the default quantity of 1
        if (!isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id] = [
                'name' => $product_details['product_name'], 
                'price' => $product_details['price'], 
                'quantity' => $quantity  // Start with quantity 1
            ];
        } else {
            // Update quantity if the product is already in the cart
            $_SESSION['cart'][$product_id]['quantity'] += $quantity;
        }
    } else {
        // Handle error if product details are not found
        $error = true;
    } 
}


// Calculate total price
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Handle payment submission (checkout)
if (isset($_POST['process_payment'])) {
    $payment = $_POST['payment'];
    $change = $payment - $total;

    // Allow payment even if change is less than 1 unit (including 0 change)
    if ($payment >= $total - 0.01) { // Allow for a small margin of error
        
        // Only now update stock and clear the cart after successful checkout
        foreach ($_SESSION['cart'] as $product_id => $cart_item) {
            $product_details = $product->displaySpecificProduct($product_id);
            // Deduct the stock from the database
            $new_quantity = $product_details['quantity'] - $cart_item['quantity'];
            $product->editProduct($product_id, $product_details['product_name'], $product_details['price'], $new_quantity);
        }

        // Store details for the receipt
        $store_name = "AB Meat Shop";
        $store_address = "Iponan, Cagayan de Oro, Philippines 9000";
        $store_phone = "+639 27 161 3674";
        $receipt_number = "R" . time(); // Unique receipt number
        $date = date('Y-m-d H:i:s'); // Current date and time

        // Save store details, receipt number, and date to session for use in the modal
        $_SESSION['store_name'] = $store_name;
        $_SESSION['store_address'] = $store_address;
        $_SESSION['store_phone'] = $store_phone;
        $_SESSION['receipt_number'] = $receipt_number;
        $_SESSION['date'] = $date;

        // Save the cart items, payment, total, and change to session for receipt
        $_SESSION['purchased_items'] = $_SESSION['cart'];
        $_SESSION['payment'] = $payment;
        $_SESSION['change'] = $change;
        $_SESSION['total'] = $total;

        // Insert sales data into the database
        try {
            $sales->insertOrderData($_SESSION['user_id'], $_SESSION['purchased_items'], $payment, $change, $total);
        } catch (Exception $e) {
            echo "Error inserting sales data: " . $e->getMessage();
        }

        // Clear the cart after successful checkout
        $_SESSION['cart'] = [];

        // Set a flag to trigger the modal for the receipt
        $_SESSION['payment_success'] = true;

        // Redirect to the same page to trigger modal on reload
        header("Location: cashier_dashboard.php");
        exit;
    } else {
        echo "<p class='text-danger'>Insufficient payment. Please enter at least Php " . number_format($total, 2) . "</p>";
    }
}

// Handle deleting a product from the cart
if (isset($_GET['delete'])) {
    $product_id = $_GET['delete'];
    unset($_SESSION['cart'][$product_id]); // Remove the item from the cart
    
    // Redirect to the same page to refresh the cart
    header("Location: cashier_dashboard.php");
    exit;
}

// Handle deleting all products from the cart
if (isset($_GET['delete_all'])) {
    $_SESSION['cart'] = []; // Clear the cart

    // Redirect to the same page to refresh the cart
    header("Location: cashier_dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <h1 class="display-3 text-center">Welcome to AB's Meat Shop!</h1>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 60px; /* Adjust this value to match the height of your navigation bar */
        }
        .scrollable-container {
            max-height: 600px; /* Set a max height */
            overflow-y: auto; /* Enable vertical scrolling */
        }
        .cart-container {
            /* Ensure it stays beside the product list */
            border-left: 1px solid #ddd;
            padding-left: 20px;
        }
        .cart-table tbody tr td {
            vertical-align: middle;
        }
    </style>
</head>

<body>

<?php include 'navbar.php'; ?> <!-- Include the navbar -->

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="scrollable-container">
                    <div class="row">
                        <?php foreach ($products as $p): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($p['product_name']); ?></h5>
                                    <p class="card-text">Price: Php <?= number_format($p['price'], 2); ?></p>
                                </div>
                                <div class="card-footer text-end">
                                    <form action="cashier_dashboard.php" method="post">
                                        <input type="hidden" name="product_id" value="<?= intval($p['product_id']); ?>">
                                        <button type="submit" name="add_to_cart" class="btn btn-primary">
                                            <i class="bi bi-cart-plus"></i> Add to Cart
                                        </button>
                                        <?php 
                                        if (isset($_SESSION['cart'][$p['product_id']])): 
                                            $cart_quantity = $_SESSION['cart'][$p['product_id']]['quantity']; 
                                        ?>
                                            <span class="badge bg-secondary ms-2">In Cart: <?= intval($cart_quantity); ?></span>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

                <!-- Cart Column -->
                <div class="col-md-4 cart-container">
                    <h2 class="h4 text-primary">Cart Items</h2>

                    <!-- Display message if cart is empty -->
                    <?php if (empty($_SESSION['cart'])): ?>
                        <p class="text-muted">Please choose items</p>
                    <?php else: ?>
                        <!-- Loop through cart items and display them in a single row per item -->
                        <?php foreach ($_SESSION['cart'] as $product_id => $item): ?>
                            <div class="cart-item-row d-flex justify-content-between align-items-center">
                                <p><strong><?= htmlspecialchars($item['name']); ?></strong></p>
                                <p>Qty: <?= $item['quantity']; ?></p>
                                <p>Price: Php <?= number_format($item['price'], 2); ?></p>
                                <p>
                                    <a href="cashier_dashboard.php?delete=<?= $product_id ?>" class="btn btn-danger btn-sm">Delete</a>
                                </p>
                            </div>
                            <hr> <!-- Line after each item -->
                        <?php endforeach; ?>

                        <div class="cart-total mt-3">
                            <p><strong>Total:</strong> Php <?= number_format($total, 2); ?></p>
                        </div>

                        <a href="cashier_dashboard.php?delete_all" class="btn btn-danger btn-sm mt-2">Delete All</a>

                    <!-- Payment Form -->
                    <form action="cashier_dashboard.php" method="post" class="mt-3" onsubmit="return validatePayment(<?= $total ?>)">
                        <div class="mb-3">
                            <label for="payment" class="form-label">Enter Payment</label>
                            <input type="number" name="payment" id="payment" class="form-control" required>
                        </div>
                        <button type="submit" name="process_payment" class="btn btn-primary w-100">Process Payment</button>
                    </form>

                    <script>
                        function validatePayment(total) {
                            var payment = document.getElementById('payment').value;

                            // Check if the entered payment is less than the total
                            if (payment < total) {
                                alert("Insufficient payment. Please enter at least Php " + parseFloat(total).toFixed(2));
                                return false; // Prevent form submission
                            }

                            // Ask for confirmation if payment is sufficient
                            return confirm("Are you sure you want to proceed with the payment?");
                        }
                    </script>


                    <?php endif; ?>
                </div>

                </div>
            </div>
        </div>
    </div>

<!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">Payment Receipt</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="receipt">
                    <h1 class="text-center"><?= htmlspecialchars($_SESSION['store_name']); ?></h1>

                    <div class="store-details text-center">
                        <p><?= htmlspecialchars($_SESSION['store_address']); ?></p>
                        <p>Phone: <?= htmlspecialchars($_SESSION['store_phone']); ?></p>
                    </div>

                    <div class="timestamp text-center">
                        Receipt #: <?= htmlspecialchars($_SESSION['receipt_number']); ?><br>
                        Date/Time: <?= htmlspecialchars($_SESSION['date']); ?>
                    </div>

                    <div class="line-items">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Items</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($_SESSION['purchased_items'] as $item): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td><?= intval($item['quantity']); ?></td>
                                        <td><?= number_format($item['price'], 2); ?></td>
                                        <td><?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="total text-end">
                        <strong>Total:</strong> Php <?= number_format($_SESSION['total'], 2); ?>
                    </div>
                    <div class="total text-end">
                        <strong>Payment:</strong> Php <?= number_format($_SESSION['payment'], 2); ?>
                    </div>
                    <div class="change text-end">
                        <strong>Change:</strong> Php <?= number_format($_SESSION['change'], 2); ?>
                    </div>

                    <div class="print-button text-center mt-3">
                        <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Include Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<!-- Trigger Modal Automatically After Payment -->
<script>
    <?php if (isset($_SESSION['payment_success']) && $_SESSION['payment_success']): ?>
        var receiptModal = new bootstrap.Modal(document.getElementById('receiptModal'));
        receiptModal.show();
        <?php unset($_SESSION['payment_success']); ?>
    <?php endif; ?>
</script>

</body>
</html>