<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/conn.php");
require("../library/function.php");
extract($_POST);

$query = mysqli_query($conn, "CALL cust_receipt_report_sp('$cust','$order')");

if (mysqli_num_rows($query) > 0) {
?>
    <!-- <a href="print/print_cust_receipt_rep.php?id=<php echo $cust; ?> &&id1=<php echo $order; ?>" target="_blank" class="btn btn-info col-2" style="margin-left: 83%; margin-bottom: 5px;">Print Report</a> -->
    <a href="invoice_print.php?order=<?php echo $order; ?>" rel="noopener" style="margin-left: 94%; margin-bottom: 5px;" target="_blank" class="btn btn-info pr"><i class="fas fa-print"></i> Print</a>
	<div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped mt-3 table-sm">
                <?php table_row($query); ?>    
            </table>
        </div>        
    </div>
<?php 
}else {
	echo "<h3 class='text-danger text-center mt-3'>No Data Found</h3>";
}
?>




<!-- 

<thead>
                    <tr>
                        <th>SNO</th>
                        <th>Order No</th>
                        <th>Name</th>
                        <th>Item</th>
                        <th>Item Type</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Remained</th>
                        <th>Discount</th>
                        <th>Balance</th>
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
                        <td><php echo "$$row[6]" ?></td>
                        <td><php echo "$$row[7]" ?></td>
                        <td><php echo "$$row[8]" ?></td>
                        <td><php echo "$$row[9]" ?></td>
                        <td><php echo "$$row[10]" ?></td>
                        <td><php echo "$$row[11]" ?></td>
                    </tr>
                    <php  
                        }
                    ?>
                </tbody>  -->