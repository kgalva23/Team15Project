<?php
function generate_nav_bar()
{
    $pages = array(
        "Items" => "items.php",
        "Shopping Cart" => "cart.php",
        "Checkout" => "checkout.php",
        "Orders" => "orders.php",
        "Account" => "account.php",
        "Logout" => "logout.php",
    );

    echo '<nav class="navbar navbar-expand-lg navbar-fixed-top bg-body tertiary bg-white shadow-lg border rounded" style="height: 60px;">
<div class="container-fluid d-flex justify-content-between">
    <a class="navbar-brand" href="home.php">Home</a>
    <div class="d-flex">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">';
    if ($_SESSION["role"] == "Admin") {
        if ("Admin" == $_SESSION["active_page"]) {
            echo "<li class='nav-item'>
                    <a class='nav-link active' href=admin.php>Admin</a>
                  </li>";
        } else {
            echo "<li class='nav-item'>
                    <a class='nav-link' href=admin.php>Admin</a>
                  </li>";
        }
    }
    foreach ($pages as $page => $url) {
        if ($page == $_SESSION["active_page"]) {
            echo "<li class='nav-item'>
                    <a class='nav-link active' href=\"$url\">$page</a>
                  </li>";
        } else {
            echo "<li class='nav-item'>
                    <a class='nav-link' href=\"$url\">$page</a>
                  </li>";
        }
    }
    echo "<li class='nav-item'> 
            <a class='navbar-brand' href='account.php'>
                <img src='" . $_SESSION['s3url'] . $_SESSION['profile_picture'] . "' alt='err' height='50' width='50' class='rounded-circle'>
            </a>
          </li>";
    echo "</ul>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</nav>";
}
