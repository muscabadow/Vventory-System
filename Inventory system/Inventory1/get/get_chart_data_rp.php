<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/function.php");
require("../library/conn.php");
extract($_POST);

$sql = "CALL chart_reports_sp('$action','$cust','$text')";
$query = $conn->query($sql);

if(@$query->num_rows > 0){
?>
		<!-- <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group input-group-lg">
                                    <input type="search" name="order" class="form-control form-control-lg custid" autocomplete="off" placeholder="Search Customer ID,Name and Tell Here...">
                                  <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default mybtn">
                                       <i class="fa fa-search"></i>
                                    </button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div> -->

        <div class="card" style="background-color: #143655; color: white; box-shadow: 0px 5px 20px rgba(0, 0, 0, .8);">
			<div class="card-body">
				<table class="table table-bordered table-striped mt-3">
					<?php table_row($query); ?>
				</table>
			</div>
		</div>
<?php 
}else{
	echo "<h1 class='text-danger text-center mt-3'>No Data Found</h1>";
}
?>










<!-- 



<div class="card">
			<div class="card-body">
				<table class="table table-bordered table-striped mt-3">
					<thead>
						<tr>
							<th>SNO</th>
							<th>Order No</th>
							<th>Name</th>
							<th>Tell</th>
							<th>Item</th>
							<th>Item Type</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Total</th>
						</tr>
					</thead>

					<tbody>
						<php
						while($row = mysqli_fetch_array($query)){
						?>
						<tr>
							<td><php echo $row[0] ?></td>
							<td><php echo $row[1] ?></td>
							<td><php echo $row[2] ?></td>
							<td><php echo $row[3] ?></td>
							<td><php echo $row[4] ?></td>
							<td><php echo $row[5] ?></td>
							<td><php echo $row[6] ?></td>
							<td><php echo $row[7] ?></td>
							<td><php echo $row[8] ?></td>
						</tr>
						<php
						}
						?>
					</tbody>				
				</table>
			</div>
		</div> -->