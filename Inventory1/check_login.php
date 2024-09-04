<?php
session_start();
require("library/conn.php");
if (isset($_POST['btnreg'])) {
  extract($_POST);

  // $sql = mysqli_query($conn, "SELECT `user_id`, ifnull(e.emp_name,'Cabdicasiis Shiikh Nuur')`emp_name`, `username`, `password`, `gender`, `image`, u.status, u.type, u.RegDate FROM users u LEFT JOIN employee e ON e.emp_id=u.emp_id WHERE u.status=1 AND username='$user' AND password='$pass'");

  $sql = mysqli_query($conn, "CALL check_login_sp('$user','$pass')");
        
  if ($sql) {
    $ress = mysqli_fetch_array($sql);

    if(!@$ress['error']){

      foreach ($ress as $colum => $val) {
        $_SESSION[$colum] = $val;
      }
      echo "<script> window.location='home.php'; </script>";


    }else{
      // header('location: index.php');
      // echo "<script> window.location='index.php'; </script>";
      // echo "<script> window.location.href = 'index.php'; </script>";
      echo "<script> window.location='index.php?error=$ress[0]'; </script>";
      // "<script> alert('Username or Password is incorrect. Try again'); window.location='index.php'; </script>";
    }

  }else{
    echo $conn->error;
  }
}

?>

