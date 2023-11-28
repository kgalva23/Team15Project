<?php
session_start();

include 'functions.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

is_logged();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $dblink = db_connect();

  // Check if email already exists in table
  $email = $_POST["email"];
  $stmt = $dblink->prepare("SELECT * FROM user WHERE Email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Email already exists, display error message
    $_SESSION['error'] = "Email already exists!";
    header("Location: /registration.php");
    exit();
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
      $_SESSION['success'] = "You're account was made successfully! Please login to continue.";
      header("Location: /index.php");
      exit();
    } else {
      $dblink->close();
      $_SESSION['error'] = "An error occurred while registering your account. Please try again.";
      header("Location: /registration.php");
      exit();
    }
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <title>Registration</title>
</head>

<body class="bg-light">
  <div class="container">
    <div class="row mt-5">
      <div class="col-lg-4 bg-white m-auto mt-5 shadow-lg rounded p-3">
        <form id="registration-form" action="registration.php" method="post">
          <h1 class="text-center pt-3 mb-3">Register</h1>

          <div class="form-floating mb-3 shadow-sm">
            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First name" required />
            <label for="first_name">First name: </label>
          </div>

          <div class="form-floating mb-3 shadow-sm">
            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last name" required />
            <label for="last_name">Last name: </label>
          </div>

          <div class="form-floating mb-3 shadow-sm">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
            <label for="email">Email: </label>
          </div>

          <div class="form-floating mb-3 shadow-sm">
            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
            <label for="password">Password: </label>
          </div>

          <div class="form-floating mb-3 shadow-sm">
            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Phone number" required />
            <label for="phone_number">Phone number: </label>
          </div>

          <div class="d-flex justify-content-center mb-3">
            <input type="submit" value="Register" class="btn btn-primary btn-lg" />
          </div>
          <p class="text-center">Already have an account? <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="index.php">Login</a></p>

          <?php
          if (isset($_SESSION['error'])) {
            echo '<div class="registration-error" id="registration-error">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
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