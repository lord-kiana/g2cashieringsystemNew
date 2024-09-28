<?php
session_start();
require_once '../classes/sales.php';

$sales = new Sales();

$daily_sales_report = $sales->getDailySalesReport();
$monthly_sales_report = $sales->getMonthlySalesReport();
$yearly_sales_report = $sales->getYearlySalesReport();
$product_sales_report = $sales->getProductSalesReport();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <h1>Sales Report</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <!-- Button Group: Back to Dashboard -->
                <div class="mb-3 text-start">
                    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h2>Daily Sales Report</h2>
                <table>
                    <tr>
                        <th>Product ID</th>
                        <th>Sale Date</th>
                        <th>Sale Amount</th>
                    </tr>
                    <?php foreach ($daily_sales_report as $report): ?>
                        <tr>
                            <td><?= $report['product_id']; ?></td>
                            <td><?= $report['sale_date']; ?></td>
                            <td><?= number_format($report['sale_amount'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-6">
                <h2>Monthly Sales Report</h2>
                <table>
                    <tr>
                        <th>Month</th>
                        <th>Total Sales</th>
                    </tr>
                    <?php foreach ($monthly_sales_report as $report): ?>
                        <tr>
                            <td><?= $report['month']; ?></td>
                            <td><?= $report['total_sales']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <div class="col-md-6">
                <h2>Yearly Sales Report</h2>
                <table>
                    <tr>
                        <th>Year</th>
                        <th>Total Sales</th>
                    </tr>
                    <?php foreach ($yearly_sales_report as $report): ?>
                        <tr>
                            <td><?= $report['year']; ?></td>
                            <td><?= $report['total_sales']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h2>Product Sales Report</h2>
                <table>
                    <tr>
                        <th>Product Name</th>
                        <th>Total Sales</th>
                    </tr>
                    <?php foreach ($product_sales_report as $report): ?>
                        <tr>
                            <td><?= $report['product_name']; ?></td>
                            <td><?= $report['total_sales']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>

</body>
</html>