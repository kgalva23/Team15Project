<?php
include("functions.php");
include("components/header.php");
include("components/footer.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();
$_SESSION["active_page"] = "Cart";

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

<body>
    <?php generate_header(); ?>

    <div class="container">

        <h1>Shopping Cart</h1>
        <?php if (empty($itemDetails)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <div class="cart-items">
                <?php foreach ($itemDetails as $item): ?>
                    <div class="row">
                        <div class="col-md-8 col-lg-6 mx-auto">
                            <div class="cart-item">
                                <h3>
                                    <?php echo htmlspecialchars($item['Name']); ?>
                                </h3>
                                <p>Quantity:
                                    <?php echo htmlspecialchars($item['Quantity']); ?>
                                </p>
                                <p class="item-price">
                                    <?php echo htmlspecialchars(number_format($item['Price'], 2)); ?>
                                </p>
                                <p>Total: $
                                    <?php echo htmlspecialchars(number_format($item['Total'], 2)); ?>
                                </p>
                                <button class="remove-from-cart" data-item-id="<?php echo $item['Item_ID']; ?>">Remove from
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div class="cart-total">
                    <h3 id="totalPrice">Total Price: $0.00</h3>
                    <button class="checkout" id="checkoutButton"
                        onclick="window.location.href='checkout.php';">Checkout</button>
                </div>

            </div>
        <?php endif; ?>

    </div>

    <?php generate_footer(); ?>
</body>

</html>