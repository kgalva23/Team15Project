<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'functions.php';
$dblink=db_connect();
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "myDB";

// Check if email already exists in table
$email = $_POST["email"];
$sql = "SELECT * FROM user WHERE Email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Email already exists, display error message
    echo "Email already exists in database.";
} else {
    // Email does not exist, insert new user into table
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $password = $_POST["password"];
    $sql = "INSERT INTO user (First_Name, Last_Name, Email, Password, Phone_Number) VALUES ('$first_name', '$last_name', '$email', '$password', '$phone_number')";

    if ($conn->query($sql) === TRUE) {
        echo "New user created successfully.";
        header("Location: /home.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
exit();
?>