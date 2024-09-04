<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/conn.php");
extract($_POST);

$sql = mysqli_query($conn, "CALL store_report_sp('$store','$item')");

if(mysqli_num_rows($sql) > 0){

?>
	<a href="print_reports.php?action=Store Report &&id=<?php echo $store; ?> &&id1=<?php echo $item; ?> &&id2= &&id3= &&id4=" target="_blank" class="btn btn-info col-2" style="margin-left: 83%; margin-bottom: 5px;">Print Report</a>
	<div class="card">
		<div class="card-body">
			<table class="table table-bordered table-striped mt-3">
				<thead>
					<tr>
						<th>SNO</th>
						<th>Pro ID</th>
						<th>Store</th>
						<th>Item</th>
						<th>Item Type</th>
						<th>In Quantity</th>
						<th>Out Quantity</th>
						<th>Balance</th>
						<th>Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					while ($ress = mysqli_fetch_array($sql)) { 
					?>
						<tr>
							<td><?php echo $ress[0];?></td>
							<td><?php echo $ress[1];?></td>
							<td><?php echo $ress[2];?></td>
							<td><?php echo $ress[3];?></td>
							<td><?php echo $ress[4];?></td>
							<td><?php echo $ress[5];?></td>
							<td><?php echo $ress[6];?></td>
							<td><?php echo $ress[7];?></td>
							<td><?php echo $ress[8];?></td>
						</tr>
					<?php 	
					}
					?>
				</tbody>
			</table>
		</div>		
	</div>




<?php 
}else{
	echo "<h1 class='text-danger text-center mt-3'>No Data Found</h1>";
}
?>