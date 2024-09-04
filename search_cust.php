<?php
require("library/conn.php");

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: index.php");
  return false;
}

extract($_POST);
$sql = mysqli_query($conn, "SELECT c.cust_id,c.cust_name FROM customers c  
					WHERE c.cust_name LIKE CONCAT('%','$text','%') OR c.tell LIKE CONCAT('%','$text','%')");

if($sql->num_rows > 0){

	while($ress = mysqli_fetch_array($sql)){
?>
		
		<li class="get_li" action="current_amount" value="<?php echo $ress[0] ?>"><?php echo $ress[1] ?></li>

<?php 
	}

}else{
	echo "<li>Nothing to show</li>";
}

?>


<!-- TO ORDER -->


<style type="text/css">
	.get_li:hover{
		cursor: pointer;
	}
</style>