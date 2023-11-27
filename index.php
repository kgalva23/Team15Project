<?php
include 'functions.php';

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

is_logged();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $dblink = db_connect();
  $email = $_POST["email"];
  $password = $_POST["password"];

  $stmt = $dblink->prepare("SELECT * FROM user WHERE Email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['Password'])) {
      $_SESSION['user_id'] = $user['User_ID']; // Assuming the user's ID is stored in the 'ID' column
      $_SESSION['role'] = $user['Role'];
      $dblink->close();
      header("Location: /home.php");
      exit();
    } else {
      $dblink->close();
      $_SESSION['error'] = "Invalid username or password";
      header("Location: /index.php");
      exit();
    }
  } else {
    $dblink->close();
    $_SESSION['error'] = "Invalid username or password";
    header("Location: /index.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <title>Team 15</title>
</head>

<body>
  <form id="login-form" class="form-container" action="index.php" method="post" autocomplete="on">
    <h1>Login</h1>
    <label for="email">Email: </label>
    <input type="email" name="email" placeholder="Email" required /><br />

    <label for="password">Password: </label>
    <input type="password" name="password" placeholder="Password" required /><br />
    <input type="submit" value="Login" /><br />
    <a href="registration.php">Don't have an account?</a>
  </form>
  <?php
  if (isset($_SESSION['error'])) {
    echo '<div class="login-error" id="login-error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
  }
  if (isset($_SESSION['success'])) {
    echo '<div class="registration-success" id="registration-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
  }
  ?>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>