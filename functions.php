<?php
function db_connect()
{
	$hostname="team15projectdb.mysql.database.azure.com";
	$username="team15admin";
	$password="0keC16&k";
	$db="team15";
	$dblink=new mysqli($hostname,$username,$password,$db);
	if (mysqli_connect_errno())
	{
		die("Error connecting to database: ".mysqli_connect_error());
	}
	return $dblink;
}
function is_logged(){
	if (isset($_SESSION['user_id']))
	{
    	header("Location: /home.php");
    	exit();
	}
}
function not_logged(){
	if (!isset($_SESSION['user_id']))
	{
    	header("Location: /index.php");
    	exit();
	}
}
?>