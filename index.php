<?php
session_start();

include 'functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dblink=db_connect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $dblink->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            // Password is correct
            header("Location: /home.php");
            exit();
        } else {
            // Password is incorrect
            $_SESSION['error'] = "Invalid username or password";
            header("Location: /index.php");
            exit();
        }
    } else {
        // Email does not exist
        $_SESSION['error'] = "Invalid username or password";
        header("Location: /index.php");
        exit();
    }
}

$dblink->close();
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="./index.css" />
    <title>Team 15</title>
  </head>
  <body>
    <form
      id="login-form"
      class="form-container"
      action="index.php"
      method="post"
      autocomplete="on"
    >
      <h1>Login</h1>
      <label for="email">Email: </label>
      <input type="email" name="email" placeholder="Email" required /><br />

      <label for="password">Password: </label>
      <input
        type="password"
        name="password"
        placeholder="Password"
        required
      /><br />
      <input type="submit" value="Login" /><br />
      <a href="registration.php">Don't have an account?</a>
    </form>
    <?php
      if (isset($_SESSION['error'])) {
        echo '<div id="login-error">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']);
      }
    ?>
  </body>
</html>