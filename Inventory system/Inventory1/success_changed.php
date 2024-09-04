<?php
require("library/conn.php");
if (isset($_POST['btnreg'])) {
  $pass = $_POST['pass'];
  $cpass = $_POST['cpass'];

  if ($pass == $cpass) {
    $sql = mysqli_query($conn, "UPDATE `users` SET `password`='$pass' WHERE `user_id`='$user_id';");
    echo "<script> window.location='success_changed.php'; </script>";
  }else{
    echo "<div class='btn btn-block btn-danger mt-3' style='border-radius: 30px;'>Si iskumid ah uma gelin Password-ka Fadlan iska hubi</div>";
  }
}

?>













<!-- <div class="popup">
  <img src="images\404-tick.png">
  <h2>Mahadsanid!</h2>
  <p>Waad ku guuleysatay inaad badasho<br> 
    Password-kaaga!</p>
  <button type="button" id="btn">Ok</button>        
</div>


<style type="text/css">
  .popup{
    width: 400px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0px 5px 25px rgba(0, 0, 0, .8);
    position: absolute;
    top: 27%;
    left: 34.6%;
    text-align: center;
    padding: 10px 5px 10px 5px;
  }
  img{
    width: 70px;
    margin-top: -50px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  }
  button{
    width: 80%;
    margin-top: 20px;
    margin-bottom: 20px;
    background: #6fd649;
    outline: none;
    border: 0;
    border-radius: 6px;
    padding: 8px 0;
    font-size: 15px;
    cursor: pointer;
    box-shadow: 0 5px 5px rgba(0, 0, 0, 0.2);
  }
  h2{
    font-size: 38px;
  }
  p{
    font-size: 22px;
  }
</style>



<script type="text/javascript">
  document.getElementById("btn").addEventListener("click",function(){
    // alert(1);
    window.location='index.php';
  })
</script> -->