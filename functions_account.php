<?php

function loadUser()
{
    $dblink = db_connect();
    $user = $_SESSION['user_id'];
    $stmt = $dblink->prepare("SELECT * FROM user WHERE User_ID = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $dblink->close();
    return $user;
}

function change_first_name($first_name)
{
    $dblink = db_connect();
    $stmt = $dblink->prepare("UPDATE user SET First_Name = ? WHERE User_ID = ?");
    $stmt->bind_param("si", $first_name, $_SESSION['user_id']);
    $stmt->execute();
    $dblink->close();
}

function change_last_name($last_name)
{
    $dblink = db_connect();
    $stmt = $dblink->prepare("UPDATE user SET Last_Name = ? WHERE User_ID = ?");
    $stmt->bind_param("si", $last_name, $_SESSION['user_id']);
    $stmt->execute();
    $dblink->close();
}

function change_email($email)
{
    $dblink = db_connect();
    $stmt = $dblink->prepare("SELECT * from user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email already exists!";
    } else {
        $stmt = $dblink->prepare("UPDATE user SET Email = ? WHERE User_ID = ?");
        $stmt->bind_param("si", $email, $_SESSION['user_id']);
        $stmt->execute();
    }
    $dblink->close();
}

function change_password($password)
{
    $dblink = db_connect();
    $password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $dblink->prepare("UPDATE user SET Password = ? WHERE User_ID = ?");
    $stmt->bind_param("si", $password, $_SESSION['user_id']);
    $stmt->execute();
    $dblink->close();
}

function change_phone_number($phone_number)
{
    $dblink = db_connect();
    $stmt = $dblink->prepare("UPDATE user SET Phone_Number = ? WHERE User_ID = ?");
    $stmt->bind_param("si", $phone_number, $_SESSION['user_id']);
    $stmt->execute();
    $dblink->close();
}

function change_profile_picture($image_id)
{
    $dblink = db_connect();
    $stmt = $dblink->prepare("UPDATE user SET Image_ID = ? WHERE User_ID = ?");
    $stmt->bind_param("ii", $image_id, $_SESSION['user_id']);
    $stmt->execute();
    $dblink->close();
}

function loadProfilePictures()
{
    $dblink = db_connect();
    $stmt = $dblink->prepare("SELECT * FROM image WHERE Image_ID > 38 AND Image_ID < 73");
    $stmt->execute();
    $result = $stmt->get_result();
    $dblink->close();
    return $result;
}

function addImage($image)
{
    $dblink = db_connect();
    $stmt = $dblink->prepare("INSERT INTO image (Image) VALUES (?)");
    $stmt->bind_param("s", $image);
    $stmt->execute();
    $image_id = $dblink->insert_id;
    $dblink->close();
    return $image_id;
}