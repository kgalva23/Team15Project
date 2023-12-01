<?php
include("functions.php");
include("components/header.php");
include("components/footer.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();
$_SESSION["active_page"] = "Checkout";

$dblink = db_connect();

$cartItems = json_decode($_COOKIE['shopping_cart'] ?? '{}', true);
$itemDetails = [];
$totalPrice = 0;

if (!empty($cartItems)) {
    $placeholders = implode(',', array_fill(0, count($cartItems), '?'));
    $sql = "SELECT * FROM item WHERE Item_ID IN ($placeholders)";
    $stmt = $dblink->prepare($sql);
    $stmt->bind_param(str_repeat('i', count($cartItems)), ...array_keys($cartItems));
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $row['Quantity'] = $cartItems[$row['Item_ID']];
        $row['Total'] = $row['Price'] * $row['Quantity'];
        $totalPrice += $row['Total'];
        $itemDetails[] = $row;
    }
}

$dblink->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {/*
    $dblink = db_connect();

    $expiration_date = $_POST['expiration_date'] . '-01'; // Append the first day of the month
    $expiration_date = date('Y-m-t', strtotime($expiration_date));
    $type = "Visa";

    $sql = "INSERT INTO payment (User_ID, Name, Type, Number, Expiration_Date, Security_Code) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $dblink->prepare($sql);
    $stmt->bind_param('isssss', $_SESSION['user_id'], $_POST['Name'], $type, $_POST['Number'], $expiration_date, $_POST['cvv']);
    $stmt->execute();
    $payment_id = $dblink->insert_id;


    $order_date = date('Y-m-d H:i:s');
    $shipping_date = date('Y-m-d H:i:s', strtotime('+1 day'));
    $address_id = 5;
    $order_status = "Packaging";
    $sql = "INSERT INTO `order` (User_ID, Order_Date, Shipping_Date, Address_ID, Order_Status, Total, Payment_ID) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $dblink->prepare($sql);
    $stmt->bind_param('issisdi', $_SESSION['user_id'], $order_date, $shipping_date, $address_id, $order_status,  $totalPrice, $payment_id);
    $stmt->execute();
    $order_id = $dblink->insert_id;

    $sql = "INSERT INTO order_item (Order_ID, Item_ID) VALUES (?, ?)";
    $stmt = $dblink->prepare($sql);
    foreach ($itemDetails as $item) {
        $stmt->bind_param('ii', $order_id, $item['Item_ID']);
        $stmt->execute();
    }

    $sql = "UPDATE item SET Stock = Stock - ? WHERE Item_ID = ?";
    $stmt = $dblink->prepare($sql);
    foreach ($itemDetails as $item) {
        $stmt->bind_param('ii', $item['Quantity'], $item['Item_ID']);
        $stmt->execute();
    }



    $dblink->close();

    setcookie('shopping_cart', '', time() - 3600);
    */
    header('Location: orders.php');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="/components/footer.css" rel="stylesheet">
    <link href="/style.css" rel="stylesheet">
    <title>Checkout</title>
    <script src="/js/shopping_cart.js"></script>
    <style>
        .cart-items {
            list-style-type: none;
            padding: 0;
        }

        .cart-item {
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 10px;
        }

        .cart-item h3 {
            margin-top: 0;
        }
    </style>
</head>

<body class="bg-light min-vh-100">
    <?php generate_header(); ?>

    <div class="container  min-vw-75  min-vh-100 bg-white shadow-lg pt-3">

        <div class="container mb-3 border-bottom">
            <h2>Checkout</h2>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <?php if (empty($itemDetails)) : ?>
                    <p>Your cart is empty.</p>
                <?php else : ?>
                    <div class="cart-items">
                        <?php foreach ($itemDetails as $item) : ?>
                            <?php if ($item['Quantity'] > 0) : ?>
                                <div class="cart-item">
                                    <h3>
                                        <?php echo htmlspecialchars($item['Name']); ?>
                                    </h3>
                                    <p>Quantity:
                                        <?php echo htmlspecialchars($item['Quantity']); ?>
                                    </p>
                                    <p class="item-price"> Price: $
                                        <?php echo htmlspecialchars(number_format($item['Price'], 2)); ?>
                                    </p>
                                    <p>Total: $
                                        <?php echo htmlspecialchars(number_format($item['Total'], 2)); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="cart-total">
                            <h3>Total Payment Due: $<?php echo number_format($totalPrice, 2); ?></h3>
                            <button class="checkout" id="backButton" onclick="window.location.href='cart.php';">Back to Cart</button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-6">
                <form class="needs-validation" novalidate id="registration-form" action="checkout.php" method="post">
                    <h1 class="text-center pt-3 mb-3">Payment</h1>



                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="Name" name="Name" placeholder="Name" required />
                        <label for="Name">Name: </label>

                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="Type" required>
                            <option selected>Card Type</option>
                            <option value="Mastercard">Mastercard</option>
                            <option value="visa">Visa</option>
                            <option value="American Express">American Express</option>
                            <option value="Discover">Discover</option>

                        </select>
                        <label for="type">Type: </label>

                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="Number" name="Number" placeholder="Number" required />
                        <label for="Number">Number: </label>

                    </div>

                    <div class="form-floating mb-3">
                        <input type="month" class="form-control" id="expiration_date" name="expiration_date" placeholder="Expiration date" required />
                        <label for="expiration_date">Expiration Date: </label>

                    </div>

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="cvv" name="cvv" placeholder="CVV" required />
                        <label for="cvv">CVV: </label>
                    </div>

                    <div class="d-flex justify-content-center mb-3">
                        <input type="submit" value="Confirm Order" class="btn btn-primary btn-lg" />
                    </div>

                </form>
            </div>
        </div>

    </div>

    <?php generate_footer(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>