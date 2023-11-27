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

    echo '<nav class="navbar navbar-expand-lg bg-body tertiary">';
    echo '<div class="container-fluid">';
    echo "<a class='navbar-brand' href='home.php'>Home</a>";
    echo '<div class="collapse navbar-collapse" id="navbarSupportedContent">';
    echo '<ul class="navbar-nav me-auto mb-2 mb-lg-0">';
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
    if ($_SESSION["role"] == "Admin") {
        if ($page == $_SESSION["active_page"]) {
            echo "<li class='nav-item'>
                    <a class='nav-link active' href=admin.php>Admin</a>
                  </li>";
        } else {
            echo "<li class='nav-item'>
                    <a class='nav-link' href=admin.php>Admin</a>
                  </li>";
        }
    }
    echo "</ul>";
    echo "</div>";
    echo "</div>";
    echo "</nav>";
}
