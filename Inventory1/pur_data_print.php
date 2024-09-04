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
				<th>Supplier</th>
				<th>Item Name</th>
        <th>Item Type</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
        <th>User</th>
        <th>Status</th>
        <th>Date</th>
				
				<?php
				$sql = mysqli_query($conn, "SELECT p.purchase_id,concat(su.name,' ',su.location),concat(i.item_name,' ',i.Category),p.item_type,p.qty,p.price,p.total_price,p.user_id,IF(p.status=0,'Canceled','Purchased'),p.RegDate FROM purchase p JOIN supplier su ON su.supplier_id=p.supplier_id JOIN items i ON i.item_id=p.item_id WHERE purchase_id=$id");
				while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo $row[4] ?></td>
                        <td><?php echo $row[5] ?></td>
                        <td><?php echo $row[6] ?></td>
                        <td><?php echo $row[7] ?></td>
                        <td><?php echo $row[8] ?></td>
                        <td><?php echo $row[9] ?></td>
                      </tr>

                      <?php  
                    }
				?>			
			</table>
		</div>
	</div>

</body>
</html>