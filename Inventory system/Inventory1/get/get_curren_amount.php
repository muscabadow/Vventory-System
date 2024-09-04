<?php 

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/conn.php");

if (isset($_POST['id'])) {
	$sql = mysqli_query($conn, "CALL get_current_sp('$_POST[action]','$_POST[id]')");

	$ress = mysqli_fetch_assoc($sql);

	$arrayName = array('Nothing to show');

	if (!$ress) {
		echo implode(',', $arrayName);
	}else{
		echo implode(',', $ress);
	}
}

?>