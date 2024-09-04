<?php 
require("library/conn.php");
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
				<th>Customer</th>
				<th>Pro ID</th>
				<th>Item Name</th>
        <th>Item Type</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
        <th>User</th>
        <th>Status</th>
        <th>Date</th>
				
				<?php
				$sql = mysqli_query($conn, "SELECT o.order_id,c.cust_name,p.pro_id,CONCAT(i.item_name,' ',i.Category),p.item_type,o.qty, o.price,o.total_price,o.user_id,IF(o.status=1,'Ordered','Canceled'),o.RegDate FROM orders o JOIN products p ON p.pro_id=o.pro_id JOIN store s ON s.store_id=p.store_id JOIN items i ON i.item_id=p.item_id JOIN customers c ON c.cust_id=o.cust_id WHERE order_id=$id");
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
                        <td><?php echo $row[10] ?></td>
                      </tr>

                      <?php  
                    }
				?>			
			</table>
		</div>
	</div>

</body>
</html>