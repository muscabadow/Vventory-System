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
          <th>Store Name</th>
          <th>User</th>
          <th>Date</th>

				
				<?php
				$sql = mysqli_query($conn, "SELECT * FROM store WHERE store_id=$id");
				while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                      </tr>

                      <?php  
                    }
				?>			
			</table>
		</div>
	</div>

</body>
</html>






