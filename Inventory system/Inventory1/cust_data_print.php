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
				<img src="dist/img/avatar5.png">
			</div>
			<table class="table table-bordered table-striped">
				<th>ID</th>
				<th>Name</th>
        <th>Tell</th>
        <th>Address</th>
        <th>Balance</th>
        <th>User ID</th>
        <th>Date</th>
				
				<?php
				$sql = mysqli_query($conn, "SELECT * FROM customers WHERE cust_id=$id");
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
                      </tr>

                      <?php  
                    }
				?>			
			</table>
		</div>
	</div>

</body>
</html>