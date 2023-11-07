<?php
include("functions.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();

echo "<pre>" . print_r($_SESSION, true) . "</pre>";

?>

<html>
    <header>
        <title>Home Page</title>
    </header>
    <body>
        <h1>Welcome to the home page!</h1>
        <p>You are logged in!</p>
    <a href="logout.php">Logout</a>
    </body>
</html>