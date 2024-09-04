<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/function.php");
require("../library/conn.php");
extract($_POST);

$sql = mysqli_query($conn, "SELECT p.pro_id`Pro ID`,s.store_name`Store`,CONCAT(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,
							COUNT(o.pro_id)`Max Orders`,o.RegDate`Date` FROM orders o JOIN products p ON p.pro_id=o.pro_id 
							JOIN store s ON s.store_id=p.store_id JOIN items i ON i.item_id=p.item_id WHERE o.status=1 AND 
							month(o.RegDate) LIKE CONCAT('%','$month','%') AND year(o.RegDate) LIKE CONCAT('%','$year','%') GROUP BY o.pro_id ORDER BY o.pro_id ASC");

if(mysqli_num_rows($sql) > 0){

?>
	<a href="print_reports.php?id=<?php echo $month; ?> &&action=Maximum Items Ordered Report &&id1=<?php echo $year; ?> &&id2= &&id3= &&id4=" target="_blank" class="btn btn-info col-2" style="margin-left: 83%; margin-bottom: 5px;">Print Report</a>
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