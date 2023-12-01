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
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="/components/footer.css" rel="stylesheet">
    <link href="/style.css" rel="stylesheet">
    <title>Shopping Cart</title>
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

        <h1>Checkout Page</h1>
        <?php if (empty($itemDetails)) : ?>
            <p>Your cart is empty.</p>
        <?php else : ?>
            <div class="cart-items">
                <?php foreach ($itemDetails as $item) : ?>
                    <?php if ($item['Quantity'] > 0) : ?>
                        <div class="row">
                            <div class="col-md-8 col-lg-6 mx-auto">
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
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <div class="cart-total">
                    <h3>Total Payment Due: $<?php echo number_format($totalPrice, 2); ?></h3>
                    <button class="checkout" id="confirmOrderButton" onclick="window.location.href='orders.php';">Confirm Order</button>
                    <button class="checkout" id="returntoCartButton" onclick="window.location.href='cart.php';">Return to Cart</button>
                </div>

            </div>
        <?php endif; ?>

    </div>

    <?php generate_footer(); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>