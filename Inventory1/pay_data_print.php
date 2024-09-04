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
          <th>Purchase No</th>
          <th>Supplier</th>
          <th>Amount</th>
          <th>Paid</th>
          <th>Balance</th>
          <th>Sender</th>
          <th>Receifer</th>
          <th>User</th>
          <th>Ref#</th>
          <th>Status</th>
          <th>Date</th>
				
				<?php
				$sql = mysqli_query($conn, "SELECT p.payment_id,p.purchase_id,concat(s.name,' ',s.location),p.total_price,p.paid,p.balance,p.Sender,p.receifer,p.user_id,p.ref_no,IF(p.status=0,'Canceled','Payed'),p.RegDate FROM payments p JOIN supplier s ON s.supplier_id=p.supplier_id WHERE p.payment_id=$id");
				while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo "$$row[3]" ?></td>
                        <td><?php echo "$$row[4]" ?></td>
                        <td><?php echo "$$row[5]" ?></td>
                        <td><?php echo $row[6] ?></td>
                        <td><?php echo $row[7] ?></td>
                        <td><?php echo $row[8] ?></td>
                        <td><?php echo $row[9] ?></td>
                        <td><?php echo $row[10] ?></td>
                        <td><?php echo $row[11] ?></td>
                      </tr>

                      <?php  
                    }
				?>			
			</table>
		</div>
	</div>

</body>
</html>