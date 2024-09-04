<?php
require("library/conn.php");

if(isset($_POST['_id'])){

// extract($_POST);

	// $id = $_POST['_id'];
	// $action = $_POST['_action'];

	$query = mysqli_query($conn, "CALL get_tables_info_sp('$_POST[_action]','$_POST[_id]')");
	$ress = mysqli_fetch_assoc($query);

	// if($ress){
	
		echo implode(",", $ress);



	// }else{
	// 	echo $conn->error;
	// }

	
}

?>
