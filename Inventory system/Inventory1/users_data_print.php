<?php
require("library/conn.php");

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: index.php");
  return false;
}

$id = $_GET['id'];

$get_img = mysqli_query($conn, "SELECT IF(image='images/','images/Cu-logo.jpg',image) FROM users WHERE user_id=$id");
$ress = mysqli_fetch_array($get_img);
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
				<img src="<?php echo $ress[0] ?>" style="width: 350px; ">
			</div>
			<table class="table table-bordered table-striped">
				<th>ID</th>
				<th>Employee Name</th>
				<th>Username</th>
				<th>Gender</th>
				<th>Status</th>
				<th>User Type</th>
				<th>Register Date</th>

				<?php
				$print = mysqli_query($conn, "SELECT user_id, ifnull(e.emp_name,'Cabdicasiis Shiikh Nuur')`Name`, username, gender, IF(u.status = 1,'Active','In Active') AS status, u.type, u.RegDate FROM users u LEFT JOIN employee e ON e.emp_id=u.emp_id WHERE u.user_id=$id");
				while($rows = mysqli_fetch_array($print)){
        ?>
          <tr>
            <td><?php echo $rows[0] ?></td>
            <td><?php echo $rows[1] ?></td>
            <td><?php echo $rows[2] ?></td>
            <td><?php echo $rows[3] ?></td>
            <td><?php echo $rows[4] ?></td>
            <td><?php echo $rows[5] ?></td>
            <td><?php echo $rows[6] ?></td>
          </tr>
        <?php  
        }
				?>			
			</table>
		</div>
	</div>



</body>
</html>
