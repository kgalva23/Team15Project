<?php
include("functions.php");
include("nav_bar.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();

$_SESSION["active_page"] = "Home";

?>

<html>
    <header>
        <title>Home Page</title>
        <link rel="stylesheet" type="text/css" href="/components/nav_bar.css">
    </header>
    <body>
        <h1>Welcome to the home page!</h1>
        <p>You are logged in!</p>
        <?php generate_nav_bar(); ?>
    </body>
</html>