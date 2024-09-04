<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/function.php");
require("../library/conn.php");
extract($_POST);

$sql = mysqli_query($conn, "CALL supplier_all_report_sp('$supplier_id')");

if(mysqli_num_rows($sql) > 0){

?>
	<a href="print_reports.php?id=<?php echo $supplier_id; ?> &&action=Supplier History Report &&id1= &&id2= &&id3= &&id4=" target="_blank" class="btn btn-info col-2" style="margin-left: 83%; margin-bottom: 5px;">Print Report</a>
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered table-striped mt-3">
				<?php table_row($sql); ?>
			</table>
		</div>		
	</div>
<?php 
}else{
	echo "<h1 class='text-danger text-center mt-3'>No Data Found</h1>";
}
?>


<!-- print/print_cust_all_rep -->