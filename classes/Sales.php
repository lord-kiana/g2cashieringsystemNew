<?php
require_once "Database.php";

class Sales extends Database {
    public function insertSalesData($purchased_items, $payment, $change, $total) {
        try {
            // Get the next available id
            $sql = "SELECT MAX(id) + 1 AS next_id FROM sales";
            $result = $this->conn->query($sql);
            $row = $result->fetch_assoc();
            $next_id = $row['next_id'];
    
            // Insert the sales data into the database
            $sql = "INSERT INTO sales (id, product_id, user_id, sale_date, sale_amount)
                    VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);
            $sale_date = date('Y-m-d'); // Assign the result of date function to a variable
            $stmt->bind_param("iiiss", $next_id, $purchased_items['id'], $_SESSION['user_id'], $sale_date, $payment);
            $stmt->execute();
        } catch (Exception $e) {
            // Handle the database error
            echo "Error inserting sales data: " . $e->getMessage();
        }
    }

    public function getDailySalesReport() {
        try {
            // Get the daily sales report
            $sql = "SELECT id, product_id, user_id, sale_date, sale_amount
                    FROM sales
                    ORDER BY sale_date DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $daily_sales_report = $result->fetch_all(MYSQLI_ASSOC);
            return $daily_sales_report;
        } catch (Exception $e) {
            // Handle the database error
            echo "Error getting daily sales report: " . $e->getMessage();
        }
    }

    public function getMonthlySalesReport() {
        try {
            // Get the monthly sales report
            $sql = "SELECT MONTH(sale_date) AS month, SUM(sale_amount) AS total_sales
                    FROM sales
                    GROUP BY MONTH(sale_date)
                    ORDER BY MONTH(sale_date) DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $monthly_sales_report = $result->fetch_all(MYSQLI_ASSOC);
            return $monthly_sales_report;
        } catch (Exception $e) {
            // Handle the database error
            echo "Error getting monthly sales report: " . $e->getMessage();
        }
    }

    public function getYearlySalesReport() {
        try {
            // Get the yearly sales report
            $sql = "SELECT YEAR(sale_date) AS year, SUM(sale_amount) AS total_sales
                    FROM sales
                    GROUP BY YEAR(sale_date)
                    ORDER BY YEAR(sale_date) DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $yearly_sales_report = $result->fetch_all(MYSQLI_ASSOC);
            return $yearly_sales_report;
        } catch (Exception $e) {
            // Handle the database error
            echo "Error getting yearly sales report: " . $e->getMessage();
        }
    }

    public function getProductSalesReport() {
        try {
            // Get the product sales report
            $sql = "SELECT p.product_name, SUM(s.sale_amount) AS total_sales
                    FROM sales s
                    JOIN products p ON s.product_id = p.id
                    GROUP BY p.product_name
                    ORDER BY p.product_name ASC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $product_sales_report = $result->fetch_all(MYSQLI_ASSOC);
            return $product_sales_report;
        } catch (Exception $e) {
            // Handle the database error
            echo "Error getting product sales report: " . $e->getMessage();
        }
    }
}