<?php
require("library/conn.php");

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: index.php");
  return false;
}

$id = $_GET['id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>KAAMIL INVENTORY SYSTEM</title>
	<?php require("library/head.php") ?>
</head>
<body class="dark-mode">
	<div class="container">
		<div class="row">
			<div class="header">
				<img src="images/Kaamil_logo.jpg">
			</div>
			<table class="table table-bordered table-striped">
					<th>ID</th>
          <th>Order No</th>
          <th>Name</th>
          <th>Amount</th>
          <th>Paid</th>
          <th>Remained</th>
          <th>Discount</th>
          <th>New Balance</th>
          <th>Sender</th>
          <th>Receifer</th>
          <th>Ref#</th>
          <th>User</th>
          <th>Status</th>
          <th>Date</th>
				
				<?php
				$sql = mysqli_query($conn, "SELECT `rec_id`, r.order_id, c.cust_name, `current_amount`, `paid`, `remained`, `discount`, `new_balance`, `account_id`, `send_number`, `ref_no`, r.user_id, IF(r.status=0,'Canceled','Recepted'), r.RegDate FROM receipt r JOIN customers c ON c.cust_id=r.cust_id WHERE r.rec_id= $id");
				while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo "$$row[3]" ?></td>
                        <td><?php echo "$$row[4]" ?></td>
                        <td><?php echo "$$row[5]" ?></td>
                        <td><?php echo "$$row[6]" ?></td>
                        <td><?php echo "$$row[7]" ?></td>
                        <td><?php echo $row[8] ?></td>
                        <td><?php echo $row[9] ?></td>
                        <td><?php echo $row[10] ?></td>
                        <td><?php echo $row[11] ?></td>
                        <td><?php echo $row[12] ?></td>
                        <td><?php echo $row[13] ?></td>
                      </tr>

                      <?php  
                    }
				?>			
			</table>
		</div>
	</div>

</body>
</html>