<?php 
require("library/conn.php");

extract($_POST);
$query = mysqli_query($conn, "INSERT INTO user_sub_menu VALUES('$user_id','$submenu_id')");

header("location: user_privilege.php");

?>