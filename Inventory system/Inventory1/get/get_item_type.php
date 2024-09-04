<?php 
session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

require("../library/conn.php");
extract($_POST);
$sqll = mysqli_query($conn, "SELECT p.pro_id,p.item_type FROM products p JOIN items i ON i.item_id=p.item_id JOIN store s ON s.store_id=p.store_id WHERE s.store_id=$_store_id AND  p.item_id=$_item_id AND p.status=1");



if($sqll->num_rows > 0){

	?>

	<option selected disabled>Select Item Type</option>

	<?php  

	while ($ress = mysqli_fetch_array($sqll)) {
?>

	<option value="<?php echo $ress[0] ?>"><?php echo $ress[1] ?></option>

<?php 

	}	
}else{
	echo "<option selected disabled>There is nothing in this store</option>";
}


?>