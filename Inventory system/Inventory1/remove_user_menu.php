<?php 
require("library/conn.php");

extract($_POST);
$query = mysqli_query($conn, "DELETE FROM user_menu WHERE user_id=$user_id AND menu_id=$menu_id");

// header("location: user_privilege.php");

?>