<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/function.php");
require("../library/conn.php");
extract($_POST);

$sql = mysqli_query($conn, "CALL store_out_report_sp('$store','$item','$month','$year')");

if(mysqli_num_rows($sql) > 0){
?>
	<a href="print_reports.php?id=<?php echo $store; ?> &&action=Store Out Report &&id1=<?php echo $item; ?> &&id2=<?php echo $month; ?> &&id3=<?php echo $year; ?> &&id4=" target="_blank" class="btn btn-info col-2" style="margin-left: 83%; margin-bottom: 5px;">Print Report</a>
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered table-striped mt-3">
				<?php table_row($sql) ?>
			</table>
		</div>		
	</div>




<?php 
}else{
	echo "<h1 class='text-danger text-center mt-3'>No Data Found</h1>";
}
?>