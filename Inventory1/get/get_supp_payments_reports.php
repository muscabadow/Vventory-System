<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/conn.php");
require("../library/function.php");

extract(@$_POST);

$query = mysqli_query($conn, "CALL payments_report_sp('$cust','$order')");

if (mysqli_num_rows($query) > 0) {
?>

	<div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped mt-3 table-sm">
                <?php table_row($query) ?>
           </table>
        </div>        
    </div>

<?php 
}else {
	echo "<h3 class='text-danger text-center mt-3'>No Data Found</h3>";
}
?>