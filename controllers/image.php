<?php
require("../middleware/objects.php");
$objects = new Objects;

$user_id = $_SESSION["user_id"];
$image = $_FILES["profileImage"]["name"];
$tmp_name = $_FILES["profileImage"]["tmp_name"];
$ext = pathinfo($image, PATHINFO_EXTENSION);
$arr = ["jpg", "jpeg", "png", "JPEG", "JPG", "PNG"];

if(in_array($ext, $arr)){
    if(move_uploaded_file($tmp_name, "../images/users/$image")){
        $objects->query = "UPDATE users SET image = '$image' WHERE id = '$user_id'";
        if($objects->execute_query()){
            echo '<script> alert("You have updated your profile image")</script>';
            echo $objects->redirect("templates/settings.php");
        }
    }
}

?>