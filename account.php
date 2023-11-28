<?php
session_start();

include 'functions.php';
include("components/nav_bar.php");
include 'functions_account.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();

$_SESSION["active_page"] = "Account";

$user = loadUser();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    switch ($_POST['action']) {
        case 'change_first_name':
            if ($_POST['first_name'] === $user['First_Name']) {
                $_SESSION['error'] = "First name cannot be the same as the current first name";
            } else {
                change_first_name($_POST['first_name']);
                $_SESSION['success'] = "First name successfully changed!";
            }

            unset($_POST['first_name']);
            break;
        case 'change_last_name':
            if ($_POST['last_name'] === $user['Last_Name']) {
                $_SESSION['error'] = "Last name cannot be the same as the current last name";
            } else {
                change_last_name($_POST['last_name']);
                $_SESSION['success'] = "Last name successfully changed!";
            }

            unset($_POST['last_name']);
            break;
        case 'change_email':
            if ($_POST['email'] === $user['Email']) {
                $_SESSION['error'] = "Email cannot be the same as the current email";
            } else {
                change_email($_POST['email']);
                $_SESSION['success'] = "Email successfully changed!";
            }

            unset($_POST['email']);
            break;
        case 'change_password':
            if (password_verify($_POST['password'], $user['Password'])) {
                $_SESSION['error'] = "Password cannot be the same as the current password";
            } else {
                change_password($_POST['password']);
                $_SESSION['success'] = "Password successfully changed!";
            }

            unset($_POST['password']);
            break;
        case 'change_phone_number':
            if ($_POST['phone_number'] === $user['Phone_Number']) {
                $_SESSION['error'] = "Phone number cannot be the same as the current phone number";
            } else {
                change_phone_number($_POST['phone_number']);
                $_SESSION['success'] = "Phone number successfully changed!";
            }

            unset($_POST['phone_number']);
            break;
    }

    header("Location: account.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Account Settings</title>
</head>

<body class="bg-light">
    <h1>Welcome to your account page!</h1>
    <?php generate_nav_bar(); ?>
    <div class="container">
        <div class="row mt-5">
            <div class="col-lg-6 bg-white m-auto mt-5 mb-5 shadow-lg rounded p-5">

                <h1 class="text-center mb-5">Account Settings</h1>

                <?php
                if (isset($_SESSION['error']) && isset($_SESSION['success'])) {
                    echo '<div class="alert alert-danger alert-dismissable fade show" id="error">' . $_SESSION['error'] . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    unset($_SESSION['error']);
                    unset($_SESSION['success']);
                } elseif (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger alert-dismissable fade show" id="error">' . $_SESSION['error'] . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    unset($_SESSION['error']);
                }

                if (isset($_SESSION['success'])) {
                    echo '<div class="alert alert-success alert-dismissable fade show" id="success">' . $_SESSION['success'] . '
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>';
                    unset($_SESSION['success']);
                }
                ?>

                <form id="first-name-form" action="account.php" method="post">
                    <input type="hidden" name="action" value="change_first_name">
                    <div class="input-group mb-3 shadow-sm">
                        <span class="input-group-text">First name</span>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $user['First_Name'] ?>" />
                        <button class="btn btn-primary" type="submit" id="button-addon2">Change</button>
                    </div>
                </form>

                <form id="last-name-form" action="account.php" method="post">
                    <input type="hidden" name="action" value="change_last_name">
                    <div class="input-group mb-3 shadow-sm">
                        <span class="input-group-text">Last name</span>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $user['Last_Name'] ?>" />
                        <button class="btn btn-primary" type="submit" id="button-addon2">Change</button>
                    </div>
                </form>

                <form id="email-form" action="account.php" method="post">
                    <input type="hidden" name="action" value="change_email">
                    <div class="input-group mb-3 shadow-sm">
                        <span class="input-group-text">Email</span>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['Email'] ?>" />
                        <button class="btn btn-primary" type="submit" id="button-addon2">Change</button>
                    </div>
                </form>

                <form id="password-form" action="account.php" method="post">
                    <input type="hidden" name="action" value="change_password">
                    <div class="input-group mb-3 shadow-sm">
                        <span class="input-group-text">Password</span>
                        <input type="password" class="form-control" id="password" name="password" />
                        <button class="btn btn-primary" type="submit" id="button-addon2">Change</button>
                    </div>
                </form>

                <form id="phone-number-form" action="account.php" method="post">
                    <input type="hidden" name="action" value="change_phone_number">
                    <div class="input-group mb-3 shadow-sm">
                        <span class="input-group-text">Phone number</span>
                        <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?php echo $user['Phone_Number'] ?>" />
                        <button class="btn btn-primary" type="submit" id="button-addon2">Change</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>

</html>