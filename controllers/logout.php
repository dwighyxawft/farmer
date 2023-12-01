<?php
require("../middleware/objects.php");
$objects = new Objects;
session_destroy();
echo $objects->redirect("templates/login.php");

?>