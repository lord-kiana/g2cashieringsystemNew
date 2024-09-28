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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">

    <div class="mb-3 text-start">
            <a href="manage-inventory.php" class="btn btn-secondary">Back</a>
        </div>
        
        <h1>Edit Product</h1>
        <form action="../actions/product-actions.php?id=<?= $product_id ?>" method="post">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" value="<?= htmlspecialchars($product_details['product_name'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="<?= htmlspecialchars($product_details['price'], ENT_QUOTES, 'UTF-8') ?>" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="<?= htmlspecialchars($product_details['quantity'], ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <button type="submit" name="edit_product" class="btn btn-primary">Update Product</button>
        </form>
    </div>
</body>
</html>
