<?php
require_once "Database.php";

class Product extends Database {
    public function displayProducts() {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Method to add a new product (without quantity)
    public function addProduct($product_name, $price) {
        // SQL to insert a new product (without quantity)
        $sql = "INSERT INTO products (product_name, price) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sd", $product_name, $price);  // s = string, d = double

        // Execute the query
        if ($stmt->execute()) {
            return true;  // Product added successfully
        } else {
            return false;  // Failed to add product
        }
    }

    // Method to edit a product (without quantity)
    public function editProduct($product_id, $product_name, $price) {
        $sql = "UPDATE products SET product_name = ?, price = ? WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $product_name, $price, $product_id); // Bind the parameters
            
        if ($stmt->execute()) {
            return true; // Return true if update succeeds
        } else {
            return false; // Return false if update fails
        }
    }
    
    // Method to handle product purchases (without checking for stock/quantity)
    public function buyProduct($product_id) {
        // Logic for buying a product without quantity constraints
        // You can add any other necessary logic here based on your business rules
        return true;  // Purchase successful (or implement other logic if needed)
    }
    
    // Method to display specific product details
    public function displaySpecificProduct($product_id) {
        // Prepare SQL query
        $sql = "SELECT * FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql);
    
        // Check if the SQL statement was prepared correctly
        if (!$stmt) {
            die("Error preparing SQL statement: " . $this->conn->error);
        }
    
        // Bind the product ID
        $stmt->bind_param("i", $product_id);
    
        // Check if the query executed successfully
        if (!$stmt->execute()) {
            die("Error executing SQL statement: " . $stmt->error);
        }
    
        // Get the result
        $result = $stmt->get_result();
    
        // Check if any rows were returned
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();  // Return the product details
        } else {
            echo "No product found with ID: $product_id.<br>"; // Debugging output
            return null;  // No product found
        }
    }

    // Method to delete a product by its ID
    public function deleteProduct($product_id) {
        // Prepare the SQL query to delete the product
        $sql = "DELETE FROM products WHERE product_id = ?";
        $stmt = $this->conn->prepare($sql); // Use $this->conn here safely

        if ($stmt) {
            $stmt->bind_param("i", $product_id); // Bind the product ID
            if ($stmt->execute()) {
                return true;
            } else {
                return false; // Return false if deletion failed
            }
        } else {
            return false; // Return false if preparation failed
        }
    }
}
?>
