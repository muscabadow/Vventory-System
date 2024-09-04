<?php
require("library/conn.php");

if (isset($_POST['btnreg'])) {
  extract($_POST);

  $sql = mysqli_query($conn, "SELECT u.username,e.email,e.tell,u.sec_question FROM userss u LEFT JOIN employee e ON e.emp_id=u.emp_id WHERE (u.username = '$uep' OR e.email = '$uep' OR e.tell LIKE CONCAT('+252','$uep'));");

  if ($sql) {
    if (mysqli_num_rows($sql) > 0) {
      $ress = mysqli_fetch_array($sql);
      echo "<script> window.location='forgot_password_sec_que.php?sec_question=$ress[3]'; </script>";
    }else{
      echo "<script> window.location='forgot_password.php?errorr=Incorrect Username or Email Address or Phone'; </script>";
    }
  }else{
    echo $conn->error;
  }
}
?>