<?php
include 'functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dblink=db_connect();

// Check if email already exists in table
$email = $_POST["email"];
$sql = "SELECT * FROM user WHERE Email = '$email'";
$result = $dblink->query($sql);

if ($result->num_rows > 0) {
    // Email already exists, display error message
    echo "Email already exists in database.";
} else {
    // Email does not exist, insert new user into table
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $phone_number = $_POST["phone_number"];
    $sql = "INSERT INTO user (First_Name, Last_Name, Email, Password, Phone_Number) VALUES ('$first_name', '$last_name', '$email', '$password', '$phone_number')";

    if ($dblink->query($sql) === TRUE) {
        echo "New user created successfully.";
        header("Location: /home.html");
    } else {
        $_SESSION['error'] = "Email already exists!";
        echo "Error: " . $sql . "<br>" . $dblink->error;
    }
}

$dblink->close();
exit();
?>