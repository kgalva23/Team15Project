<?php
include("functions.php");
include("components/header.php");
include("components/footer.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();
$_SESSION["active_page"] = "Items";

$dblink = db_connect();

$sql = "SELECT item.*, image.Image AS ImagePath FROM item LEFT JOIN image ON item.Image_ID = image.Image_ID";
$result = $dblink->query($sql);
$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
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
    <title>Items Page</title>
    <style>
        .card-flex {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        .card-flex img {
            width: 150px;
            height: auto;
            margin-right: 15px;
        }

        .card-body {
            flex-grow: 1;
        }
    </style>
    <script>
        var items = <?php echo json_encode($items); ?>;
    </script>
    <script src="/js/search.js"></script>
    <script src="/js/filter.js"></script>
    <script src="/js/shopping_cart.js"></script>

</head>

<body class="bg-light min-vh-100">
    <?php generate_header(); ?>
    <div class="container min-vw-75  min-vh-100 bg-white shadow-lg pt-3">

        <div class="container">
            <div class="row mb-3 ">
                <div class="col-md-6">
                    <input type="text" id="searchItems" class="form-control" placeholder="Search items...">
                </div>
                <div class="col-md-6">
                    <select id="sortSelect" class="form-select">
                        <option value="default">Sort By...</option>
                        <option value="price_low_high">Price Low to High</option>
                        <option value="price_high_low">Price High to Low</option>
                    </select>
                </div>
            </div>

            <div class="row" id="itemContainer">
                <?php foreach ($items as $item) : ?>
                    <div class="col-md-6 mb-4">
                        <div class="card card-flex">
                            <img src="<?php echo $_SESSION['s3url'] . htmlspecialchars($item['ImagePath']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($item['Name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($item['Description']); ?></p>
                                <p class="card-text">Company: <?php echo htmlspecialchars($item['Company']); ?></p>
                                <p class="card-text">Price: $<?php echo htmlspecialchars(number_format($item['Price'], 2)); ?></p>
                                <p class="card-text">Available: <?php echo htmlspecialchars($item['Stock']); ?></p>
                                <button class="btn <?php echo $item['Item_ID']; ?> openModalBtn" data-item-id="<?php echo $item['Item_ID']; ?>">Add to Cart</button> <!-- Button to trigger the modal -->
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Item added to cart!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Content to display in the modal -->
                    <?php
                    // Message to click "Close" button
                    echo "Click the 'Close' button to continue!";
                    ?>
                </div>
                <div class="modal-footer">
                    <button id="modalclose" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php generate_footer(); ?>

    <script>
        //JavaScript to trigger modal on button click, this shows that item has been added to cart
        document.querySelectorAll('.openModalBtn').forEach(button => {
            button.addEventListener('click', function() {
                $('#myModal').modal('show'); // Show the modal when the button is clicked
            });
        });
    </script>

    <script>
        // JavaScript to trigger modal closing on button click
        document.getElementById('modalclose').addEventListener('click', function() {
            $('#myModal').modal('hide'); // Hide the modal when the button is clicked
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>