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