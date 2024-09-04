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
				<th>Purchase ID</th>
				<th>Store</th>
				<th>Item Name</th>
        <th>Item Type</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Total Price</th>
        <th>User</th>
        <th>Status</th>
        <th>Date</th>
				
				<?php
				$sql = mysqli_query($conn, "SELECT `pro_id`, p.purchase_id, s.store_name, CONCAT(i.item_name,' ',i.Category), p.item_type, p.qty, p.price, p.total_price, p.user_id, IF(p.status=1,'EXISTS',IF(p.status=0 AND p.purchase_id=pu.purchase_id ,'Canceled','END')), p.RegDate FROM products p JOIN store s ON s.store_id=p.store_id JOIN items i ON i.item_id=p.item_id LEFT JOIN purchase pu ON pu.purchase_id=p.purchase_id WHERE pro_id=$id");
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