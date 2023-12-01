<?php
require("../middleware/objects.php");
$objects = new Objects;

$image = $_FILES['image']["name"];
$tmp_name = $_FILES['image']["tmp_name"];
$name = $_POST["name"];
$quantity = $_POST["quantity"];
$amount = $_POST["amount"];
$farmer_id = $_SESSION["user_id"];

if(move_uploaded_file($tmp_name, "../images/products/$image")){
    $objects->query = "INSERT INTO products (image, name, quantity, amount, farmer_id) VALUES ('$image', '$name', '$quantity', '$amount', '$farmer_id')";
    if($objects->execute_query()){
        echo "<script>alert('Your product has been uploaded successfully')</script>";
        echo $objects->redirect("templates/products.php");
    }
}


?>