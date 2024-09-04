<?php

if(isset($_POST['img_sub'])){
	$path = "images/";
	$img_name = $path . $_FILES['img']['name'];
	$tmp_img = $_FILES['img']['tmp_name'];

	move_uploaded_file($tmp_img,$img_name);
}


?>


<form method="POST" enctype="multipart/form-data">
	<input type="file" name="img"><br><br>
	<input type="submit" name="img_sub">
</form>