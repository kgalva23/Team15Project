<?php
include("functions.php");
include("components/nav_bar.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();

$_SESSION["active_page"] = "Home";

$dblink = db_connect();

$sql = "SELECT item.*, image.Image AS ImagePath FROM item LEFT JOIN image ON item.Image_ID = image.Image_ID";
$result = $dblink->query($sql);
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

$dblink->close();

?>

<html>
<header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Home Page</title>
    <style>
        .container {
            max-width: 80%;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333; /* Set your desired background color */
            color: white; 
            padding: 20px 0;
            font-size: 12px;
            text-align: middle;
            margin-top: auto; /* Push the footer to the bottom */
            
        }

        footer h3 {
            font-size: 18px; /* Footer heading 3 font size */
        }

        footer ul li {
            font-size: 14px; /* List item font size */
        }
        
        .card-flex {
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-right: 100px;
            margin-left: 100px;

        }
        .card-flex img {
            width: 150px;
            height: auto;
            margin-right: 15px;
        }
        .card-body {
            flex-grow: 1;
            align-items: center;
        }
    </style>
    <script>
        var items = <?php echo json_encode($items); ?>;
    </script>

    <script src="/js/search.js"></script>
    <script src="/js/filter.js"></script>
</header>

<body class="bg-light">
    <div class="container mt-4">
        <h1>Welcome to FreshPicks!</h1>
        <?php generate_nav_bar(); ?>
        <div class="container"><h2>Popular Items</h2></div>
    </div>
    <div class="row" id="itemContainer">
                <?php foreach ($items as $item): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card card-flex">
                            <img src="<?php echo $_SESSION['s3url'] . htmlspecialchars($item['ImagePath']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($item['Name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($item['Description']); ?></p>
                                <p class="card-text">Company: <?php echo htmlspecialchars($item['Company']); ?></p>
                                <p class="card-text">Price: $<?php echo htmlspecialchars(number_format($item['Price'], 2)); ?></p>
                                <p class="card-text">Available: <?php echo htmlspecialchars($item['Stock']); ?></p>
                                <button class="btn btn-success add-to-cart" data-item-id="<?php echo $item['Item_ID']; ?>">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>     
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

<!-- Footer Section -->
<footer class="bg-dark text-light">
    <div class="container py-0.1">
        <div class="row">
            <div class="col-md-4">
                <h3>Contact Us</h3>
                <p>123 Grocery Street, Apple City, USA</p>
                <p>Email: info@freshpicks.com</p>
                <!--    <p>Phone: 123-456-7890</p>  -->
            </div>
            <div class="col-md-4">
                <h3>Share With Others</h3>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="https://www.facebook.com/login" target="_blank">Facebook</a></li>
                    <li class="list-inline-item"><a href="https://twitter.com/login" target="_blank">Twitter/X</a></li>
                    <li class="list-inline-item"><a href="https://www.instagram.com/accounts/login/" target="_blank">Instagram</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>
