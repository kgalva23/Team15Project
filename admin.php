<?php
include("functions.php");
include("components/nav_bar.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();

$_SESSION["active_page"] = "Admin";
$section = $_GET['section'] ?? 'default';
$dblink = db_connect();
if ($_SERVER["REQUEST_METHOD"] == "POST" && $section == 'addInventory') {
    $name = $dblink->real_escape_string($_POST['name']);
    $description = $dblink->real_escape_string($_POST['description']);
    $company = $dblink->real_escape_string($_POST['company']);
    $price = $dblink->real_escape_string($_POST['price']);
    $stock = $dblink->real_escape_string($_POST['stock']);

    $target_dir = "./images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {

        $imageInsertSql = "INSERT INTO image (Image) VALUES ('" . $target_file . "')";
        if ($dblink->query($imageInsertSql) === TRUE) {
            $last_image_id = $dblink->insert_id;
            $itemInsertSql = "INSERT INTO item (Name, Description, Company, Price, Stock, Image_ID) VALUES ('$name', '$description', '$company', '$price', '$stock', '$last_image_id')";
            if ($dblink->query($itemInsertSql) === TRUE) {
                echo "New item added successfully";
            } else {
                echo "Error: " . $itemInsertSql . "<br>" . $dblink->error;
            }
        } else {
            echo "Error: " . $imageInsertSql . "<br>" . $dblink->error;
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


if ($section == 'modifyInventory') {
    $sql = "SELECT item.*, image.Image AS ImagePath FROM item LEFT JOIN image ON item.Image_ID = image.Image_ID";
    $result = $dblink->query($sql);

    $items = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
    } else {
        echo "Error fetching items: " . $dblink->error;
    }
}

?>

<html>
<header>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Admin Page</title>
</header>

<body>
    <h1>Welcome to the admin page!</h1>
    

    <?php generate_nav_bar(); ?>
    <p>Which admin task would you like to perform?</p>


    <a href="admin.php?section=modifyUsers" class="btn btn-primary">Modify User Accounts</a>
        <a href="admin.php?section=addInventory" class="btn btn-success">Add New Item to Inventory</a>

        <?php if ($section == 'modifyUsers'): ?>
            <div id="userSection">
            <h2>Current Active Accounts:</h2>

<table class="form-control" name="docType">
    <?php
    

    $sql = "SELECT * FROM user";
    $result = $dblink->query($sql) or die("Something went wrong with: $sql<br>" . $dblink_->error);
    $counter = 1;

    //While loop to go through each account in the database
    while ($data = $result->fetch_array(MYSQLI_ASSOC)) {
        $buttonName = "button" . (string)$counter;
        $c_firstName = $data['First_Name'];
        $c_lastName = $data['Last_Name'];
        $c_email = $data['Email'];
        echo '<p> Name: ' . $c_firstName . ' ' . $c_lastName . '<br />Email: ' . $c_email . '</p>';
        echo "<form method='post'> 
                    <input type='submit' name=$buttonName value='Remove Account!'/>";

        //check to see which button is clicked
        if (isset($_POST[$buttonName])) {
            $dblink->query("DELETE FROM user WHERE First_Name='$c_firstName'");
        }
        $counter++;
    }
    ?>
</table>
            </div>
    <?php elseif ($section == 'addInventory'): ?>
    <div id="addInventorySection">
        <h2>Add New Inventory Item</h2>
        <form action="admin.php?section=addInventory" method="post" enctype="multipart/form-data">
            Name: <input type="text" name="name" required><br>
            Description: <input type="text" name="description" required><br>
            Company: <input type="text" name="company" required><br>
            Price: <input type="number" step="0.01" name="price" required><br>
            Stock: <input type="number" name="stock" required><br>
            Image: <input type="file" name="image" required><br>
            <input type="submit" value="Add Item" class="btn btn-primary">
        </form>
    </div>
<?php endif; ?>
<script src="/js/modify_items.js"></script>
</body>

</html>

