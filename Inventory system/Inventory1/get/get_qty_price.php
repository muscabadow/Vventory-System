<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/conn.php");
extract($_POST);
$sql = mysqli_query($conn, "CALL get_qty_pri_sp($item_typee,$item_idd,$storee)");

$ress = mysqli_fetch_assoc($sql);

echo implode(",", $ress);

?>