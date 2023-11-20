<?php
include("functions.php");
include("components/nav_bar.php");
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

not_logged();

$_SESSION["active_page"] = "Admin";

?>

<html>
    <header>
        <title>Admin Page</title>
        <link rel="stylesheet" type="text/css" href="/components/nav_bar.css">
    </header>

    <body>
        <h1>Welcome to the admin page!</h1>
        <p>Which admin task would you like to perform?</p>

        <?php generate_nav_bar(); ?>

        <h2>Current Active Accounts:</h2>

        <table class="form-control" name="docType">
          <?php
            $dblink = db_connect();

            $sql="SELECT * FROM user";
            $result= $dblink->query($sql) or die ("Something went wrong with: $sql<br>".$dblink_>error);
            $counter = 1;

            //While loop to go through each account in the database
            while ($data=$result->fetch_array(MYSQLI_ASSOC)){
                $buttonName = "button".(string)$counter;
                $c_firstName = $data['First_Name'];
                $c_lastName = $data['Last_Name'];
                $c_email = $data['Email'];
                echo '<p> Name: '.$c_firstName. ' '.$c_lastName.'<br />Email: '.$c_email.'</p>';
                echo "<form method='post'> 
                        <input type='submit' name=$buttonName value='Remove Account!'/>";
                
                //check to see which button is clicked
                if(isset($_POST[$buttonName])) { 
                    $dblink->query("DELETE FROM user WHERE First_Name='$c_firstName'");
                } 
                $counter++;
            }
            ?>
        </table>

    </body>
</html>