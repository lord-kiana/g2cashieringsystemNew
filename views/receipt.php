<?php
session_start();
require_once '../classes/Sales.php';

// Create an instance of the sales class
$sales = new Sales();

// Ensure the session contains the required payment information
if (!isset($_SESSION['payment']) || !isset($_SESSION['change']) || !isset($_SESSION['total']) || !isset($_SESSION['purchased_items'])) {
    echo "No payment information available.";
    exit;
}

// Store details for the receipt
$store_name = "AB Meat Shop";
$store_address = "Iponan, Cagayan de Oro, Philippines 9000";
$store_phone = "+639 27 161 3674";
$receipt_number = "R" . time(); // Unique receipt number
$date = date('Y-m-d H:i:s'); // Current date and time

// Get the payment, total, change, and purchased items from the session
$purchased_items = $_SESSION['purchased_items'];
$payment = $_SESSION['payment'];
$change = $_SESSION['change'];
$total = $_SESSION['total'];

// Ensure the $purchased_items array is populated
if (empty($purchased_items)) {
    echo "No purchased items available.";
    exit;
}

try {
    // Insert the sales data into the database
    $sales->insertOrderData($_SESSION['user_id'], $purchased_items, $payment, $change, $total);
} catch (Exception $e) {
    echo "Error inserting sales data: " . $e->getMessage();
}

// Clear payment information from the session after generating the receipt
unset($_SESSION['purchased_items'], $_SESSION['payment'], $_SESSION['change'], $_SESSION['total']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px; }
        .receipt { max-width: 400px; margin: auto; padding: 20px; background-color: white; border: 1px solid #ddd; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .receipt h1 { text-align: center; font-size: 24px; margin-bottom: 20px; }
        .store-details, .timestamp { text-align: center; margin-bottom: 20px; }
        .line-items table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .line-items table th, .line-items table td { padding: 8px; border-bottom: 1px solid #ddd; text-align: left; }
        .total, .change { text-align: right; font-weight: bold; margin-bottom: 20px; }
        .print-button { text-align: center; }
        .print-button button { padding: 10px 20px; font-size: 16px; }
    </style>
</head>
<body>

    <div class="mb-3 text-start">
        <a href="cashier_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    <div class="receipt">
        <h1><?= htmlspecialchars($store_name); ?></h1>

        <div class="store-details">
            <p><?= htmlspecialchars($store_address); ?></p>
            <p>Phone: <?= htmlspecialchars($store_phone); ?></p>
        </div>

        <div class="timestamp">
            Receipt #: <?= htmlspecialchars($receipt_number); ?><br>
            Date/Time: <?= htmlspecialchars($date); ?>
        </div>

        <div class="line-items">
            <table>
                <thead>
                    <tr>
                        <th>Items</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($purchased_items as $item): ?>
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

        <div class="total">
            Total: <?= number_format($total, 2); ?>
        </div>
        <div class="total">
            Payment: <?= number_format($payment, 2); ?>
        </div>
        <div class="change">
            Change: <?= number_format($change, 2); ?>
        </div>

        <div class="print-button">
            <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
