<?php 
require("library/conn.php");

extract($_POST);
$query = mysqli_query($conn, "DELETE FROM user_sub_menu WHERE user_id=$user_id AND sub_menu_id=$submenu_id");

header("location: user_privilege.php");

?>