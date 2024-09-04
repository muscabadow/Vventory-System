<?php  

$conn = mysqli_connect("localhost","root","","kaamil_inventory");

if(!$conn){
	die("connection error ".mysqli_connect_error());
}


// $conn->query("SET time_zone = 'Africa/Nairobi'");d
mysqli_query($conn, "SET sql_mode = ''");

?>