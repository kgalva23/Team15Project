<?php
session_start();

include 'functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dblink=db_connect();

    // Check if email already exists in table
    $email = $_POST["email"];
    $stmt = $dblink->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email already exists, display error message
        echo "Email already exists in database.";
    } else {
        // Email does not exist, insert new user into table
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $phone_number = $_POST["phone_number"];

        $stmt = $dblink->prepare("INSERT INTO user (First_Name, Last_Name, Email, Password, Phone_Number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $email, $password, $phone_number);

        if ($stmt->execute()) {
            $dblink->close();
            header("Location: /home.php");
            exit();
        } else {
            $dblink->close();
            $_SESSION['error'] = "Email already exists!";
            header("Location: /registration.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Registration Page</title>
    <link rel="stylesheet" href="./index.css" />
  </head>
  <body>
    <h1>Registration Form</h1>
    <form class="form-container" action="registration.php" method="post">
      <label for="first_name">First Name:</label>
      <input
        type="text"
        id="first_name"
        name="first_name"
        required
      /><br /><br />

      <label for="last-name">Last Name:</label>
      <input type="text" id="last_name" name="last_name" required /><br /><br />

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required /><br /><br />

      <label for="password">Password:</label>
      <input
        type="password"
        id="password"
        name="password"
        required
      /><br /><br />

      <label for="phone_number">Phone Number:</label>
      <input
        type="tel"
        id="phone_number"
        name="phone_number"
        required
      /><br /><br />

      <input type="submit" value="Submit" />
    </form>
    <div id="login-error"><?php echo $_SESSION['error']; ?></div>
  </body>
</html>
