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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Login</title>
</head>

<body class="bg-light">
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-4 bg-white m-auto">

        <form id="login-form" action="index.php" method="post" autocomplete="on">
          <h1 class="text-center pt-3 mb-3">Login</h1>

          <div class="form-floating mb-3">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
            <label for="email">Email: </label>
          </div>

          <div class="form-floating mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
            <label for="password">Password: </label>
          </div>

          <div class="d-flex justify-content-center">
            <input type="submit" value="Login" class="btn btn-primary btn-lg" />
          </div>

          <p class="text-center">Don't have an account? <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="registration.php">Register</a></p>
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
        </form>

      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>