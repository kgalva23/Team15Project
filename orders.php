<?php
session_start();
include_once 'functions.php';

not_logged();

$orders = getOrders();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

    <div class="container mt-4">
        <h1 class="mb-4">Orders</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Order Date</th>
                    <th>Shipping Date</th>
                    <th>Address ID</th>
                    <th>Order Status</th>
                    <th>Total</th>
                    <th>Payment ID</th>
                    <th>Discount Code ID</th>
                    <th>Payment User ID</th>
                    <th>Payment Name</th>
                    <th>Type</th>
                    <th>Number</th>
                    <th>Expiration Date</th>
                    <th>Security Code</th>
                    <th>Item Count</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?php echo $order['Order_ID']; ?></td>
                        <td><?php echo $order['User_ID']; ?></td>
                        <td><?php echo $order['Order_Date']; ?></td>
                        <td><?php echo $order['Shipping_Date']; ?></td>
                        <td><?php echo $order['Address_ID']; ?></td>
                        <td><?php echo $order['Order_Status']; ?></td>
                        <td><?php echo $order['Total']; ?></td>
                        <td><?php echo $order['Payment_ID']; ?></td>
                        <td><?php echo $order['Discount_code_ID']; ?></td>
                        <td><?php echo $order['Payment_User_ID']; ?></td>
                        <td><?php echo $order['Payment_Name']; ?></td>
                        <td><?php echo $order['Type']; ?></td>
                        <td><?php echo $order['Number']; ?></td>
                        <td><?php echo $order['Expiration_Date']; ?></td>
                        <td><?php echo $order['Security_Code']; ?></td>
                        <td><?php echo $order['Item_Count']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>