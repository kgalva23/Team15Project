<?php
session_start();
include_once 'functions.php';
include("components/header.php");
include("components/footer.php");

not_logged();

$orders = getOrders();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="/components/footer.css" rel="stylesheet">
    <link href="/style.css" rel="stylesheet">
</head>

<body class="bg-light min-vh-100">

    <?php generate_header(); ?>

    <div class="container min-vw-75  min-vh-100 bg-white shadow-lg pt-3">
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
                <?php foreach ($orders as $order) : ?>
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

    <?php generate_footer(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>