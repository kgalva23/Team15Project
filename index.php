<?php
include 'functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dblink=db_connect();

$email = $_POST["email"];
$password = $_POST["password"];
$sql = "SELECT * FROM user WHERE Email = '$email' AND Password = '$password'";
$result = $dblink->query($sql);

if ($result->num_rows > 0) {
    // Email and password exist together
    echo "Successfully logged in.";
    header("Location: /home.html");
} else {
    // Email or password do not match
    echo "Email or password do not match.";
}

$dblink->close();
exit();
?>