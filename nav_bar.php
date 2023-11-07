<?php
function generate_nav_bar() {
    $pages = array(
        "Home" => "home.php",
        "Logout" => "logout.php",
    );
    
    echo "<nav>";
    echo "<ul>";
    foreach ($pages as $page => $url) {
        if ($page == $_SESSION["active_page"]) {
            echo "<li><a href=\"$url\" class=\"active\">$page</a></li>";
        } else {
            echo "<li><a href=\"$url\">$page</a></li>";
        }
    }
    if ($_SESSION["role"] == "Admin") {
        echo "<li><a href=\"admin.php\">Admin</a></li>";
    }
    echo "</ul>";
    echo "</nav>";
}

?>