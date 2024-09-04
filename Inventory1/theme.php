<?php 

require("library/conn.php");
// extract($_POST);

if (isset($_POST['theme_type'])) {
	
	if ($_POST['theme_type'] == "checked") {
		$run_query = mysqli_query($conn, "INSERT INTO `theme`(`theme_type`) VALUES ('dark-mode')"); 
	}elseif ($_POST['theme_type'] == "un-checked") {
		$run_query1 = mysqli_query($conn, "DELETE FROM `theme`"); 
	}
}


?>