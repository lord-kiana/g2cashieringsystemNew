<?php
require_once "../classes/Product.php";
$product = new Product();

// Handle product edit
if (isset($_POST['edit_product'])) {
    $id = $_GET['id']; 
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    // Update the product in the database
    if ($product->editProduct($id, $product_name, $price)) {
        // Redirect to the edit page with a success parameter
        header("Location: ../views/edit-product.php?id=$id&success=Product updated successfully.");
        exit;
    } else {
        die("Failed to update the product.");
    }
}

// Handle product purchase logic (no need to check quantity anymore)
if (isset($_POST['buy_product'])) {
    $id = $_GET['id'];
    
    // Fetch product details
    $product_details = $product->displaySpecificProduct($id);

    if ($product_details === null) {
        die("Product not found. Please try again.");
    }

    // Redirect after successful purchase
    if ($product->buyProduct($id)) {
        header("Location: ../views/cashier_dashboard.php");  // Redirect to dashboard on success
        exit;
    } else {
        die("Failed to purchase product.");
    }
}

// Handle adding a new product (no quantity required)
if (isset($_POST['add_product'])) {
    // Get the form data
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];

    // Call the method to add the product
    if ($product->addProduct($product_name, $price)) {
        // Redirect to the dashboard on success
        header("Location: ../views/manage-inventory.php");
        exit;
    } else {
        die("Failed to add product.");
    }
}
?>
