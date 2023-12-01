<?php
function db_connect()
{
	$hostname = "team15projectdb.mysql.database.azure.com";
	$username = "team15admin";
	$password = "0keC16&k";
	$db = "team15";
	$dblink = new mysqli($hostname, $username, $password, $db);
	if (mysqli_connect_errno()) {
		die("Error connecting to database: " . mysqli_connect_error());
	}
	return $dblink;
}
function is_logged()
{
	if (isset($_SESSION['user_id'])) {
		header("Location: /home.php");
		exit();
	}
}
function not_logged()
{
	if (!isset($_SESSION['user_id'])) {
		header("Location: /index.php");
		exit();
	}
}
function loadProfilePicture($image_id)
{
	$dblink = db_connect();
	$stmt = $dblink->prepare("SELECT * FROM image WHERE Image_ID = ?");
	$stmt->bind_param("i", $image_id);
	$stmt->execute();
	$result = $stmt->get_result();
	$profile_picture = $result->fetch_assoc();
	$dblink->close();
	return $profile_picture['Image'];
}

function addImage($image)
{
	$dblink = db_connect();
	$stmt = $dblink->prepare("INSERT INTO image (Image) VALUES (?)");
	$stmt->bind_param("s", $image);
	$stmt->execute();
	$image_id = $dblink->insert_id;
	$dblink->close();
	return $image_id;
}

function getOrders()
{
    $dblink = db_connect();
    
    $query = "
        SELECT o.Order_ID, o.User_ID, o.Order_Date, o.Shipping_Date, o.Address_ID, 
               o.Order_Status, o.Total, o.Payment_ID, o.Discount_code_ID,
               p.Payment_ID, p.User_ID as Payment_User_ID, p.Name as Payment_Name,
               p.Type, p.Number, p.Expiration_Date, p.Security_Code,
               COUNT(oi.Order_Item_ID) as Item_Count
        FROM `order` o
        JOIN payment p ON o.Payment_ID = p.Payment_ID
        LEFT JOIN order_item oi ON o.Order_ID = oi.Order_ID
        GROUP BY o.Order_ID
    ";
    
    $result = $dblink->query($query);
    
    if (!$result) {
        die("Error fetching orders: " . $dblink->error);
    }
    
    $orders = [];
    
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    
    $dblink->close();
    
    return $orders;
}