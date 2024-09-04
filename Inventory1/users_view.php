<?php
require("library/conn.php");

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: index.php");
  return false;
}

//THEMES
$rq10 = mysqli_query($conn, "SELECT * FROM `theme` LIMIT 1");
$resq10 = mysqli_fetch_array($rq10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require("library/head.php")?>
</head>
<body class="<?php echo $resq10[0] ?> hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
    <?php require("library/nav.php")?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php require("library/sidebar.php")?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Users View</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php require("modals/insert_modals.php") ?>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users View</h3>
              <div class="row m-12">
                <div class="col-md-10"></div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn btn-block btn-info far fa-edit" data-toggle="modal" data-target="#users_reg_modal">
                    Add New User
                    </button>
                  </div>
              </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-sm">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Gender</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Sec Question</th>
                    <th>Sec Answer</th>
                    <th>Date</th>

                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>

                    <?php
                    if(isset($_POST['user_updates'])){
                      $id  = mysqli_real_escape_string($conn, $_POST['user_ids']);
                      $us  = mysqli_real_escape_string($conn, $_POST['users']);
                      $pa  = mysqli_real_escape_string($conn, $_POST['passs']);
                      $ge  = mysqli_real_escape_string($conn, $_POST['genders']);
                      $st  = mysqli_real_escape_string($conn, $_POST['statuss']);
                      $sq  = mysqli_real_escape_string($conn, $_POST['sec_que']);
                      $sa  = mysqli_real_escape_string($conn, $_POST['sec_ans']);
                      $ty = mysqli_real_escape_string($conn, @$_POST['user_types']);

                      $path = "images/";
                      $img_name = @$path . @$_FILES['img']['name'];

                      $edit = mysqli_query($conn, "CALL update_users_sp('$id','$us','$pa','$ge','$img_name','$st','$ty','$sq','$sa')");

                      if ($edit){
                        move_uploaded_file(@$_FILES['img']['tmp_name'], @$img_name);
                        // echo "<script>alert('Updated Successfully')</script>";

                        $re = mysqli_fetch_array($edit);
                        $ree = explode("|", $re[0]);
                        if ($ree[0] = 'danger') {
                          echo "<script>alert('$ree[1]'); window.location='users_view.php';</script>";
                        }else{
                          echo "<script>alert('$ree[1]'); window.location='users_view.php';</script>";
                        }
                      }
                    }
                    ?>

                    <?php
                      if(isset($_GET['id'])){
                        $del = $_GET['id'];
                        $query = mysqli_query($conn, "DELETE FROM users WHERE user_id=$del");
                      }
                      ?>

                    <?php 

                    if ($_SESSION['type'] == 'Developer') {  
                      $sql = mysqli_query($conn, "SELECT user_id, e.emp_name, username, password,gender, IF(image='images/','images/Cu-logo.jpg',image), IF(u.status = 1,'Active','In Active'),u.type,u.sec_question,u.sec_answer,u.RegDate FROM users u LEFT JOIN employee e ON e.emp_id=u.emp_id");

                      while($row = mysqli_fetch_array($sql)){
                        ?>
                        <tr>
                          <td><?php echo $row[0] ?></td>
                          <td><?php echo $row[1] ?></td>
                          <td><?php echo $row[2] ?></td>
                          <td><?php echo $row[3] ?></td>
                          <td><?php echo $row[4] ?></td>
                          <td><img src="<?php echo $row[5] ?>" style="width: 50px;"></td>
                          <!-- <td><img src=""></td> -->
                          <td><?php echo $row[6] ?></td>
                          <td><?php echo $row[7] ?></td>
                          <td><?php echo $row[8] ?></td>
                          <td><?php echo $row[9] ?></td>
                          <td><?php echo $row[10] ?></td>

                          <td>
                            <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> -->
                            <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="users" alt="<?php echo $row[0] ?>"></button>
                          </td>
                          <td>
                            <a href="users_view.php?id=<?php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                          </td>
                          <td>
                            <a href="users_data_print.php?id=<?php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                          </td>
                        </tr>
                    <?php  
                      }// END DEVELOPER WHILE

                    }else{
                      $sql = mysqli_query($conn, "SELECT user_id, e.emp_name, username, password,gender, IF(image='images/','images/Kaamil_logo.jpg',image), IF(u.status = 1,'Active','In Active'),u.type,u.sec_question,u.sec_answer,u.RegDate FROM users u LEFT JOIN employee e ON e.emp_id=u.emp_id WHERE u.type != 'Developer' ");

                      while($row = mysqli_fetch_array($sql)){
                        ?>
                        <tr>
                          <td><?php echo $row[0] ?></td>
                          <td><?php echo $row[1] ?></td>
                          <td><?php echo $row[2] ?></td>
                          <td><?php echo $row[3] ?></td>
                          <td><?php echo $row[4] ?></td>
                          <td><img src="<?php echo $row[5] ?>" style="width: 50px;"></td>
                          <!-- <td><img src=""></td> -->
                          <td><?php echo $row[6] ?></td>
                          <td><?php echo $row[7] ?></td>
                          <td><?php echo $row[8] ?></td>
                          <td><?php echo $row[9] ?></td>
                          <td><?php echo $row[10] ?></td>

                          <td>
                            <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> -->
                            <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="users" alt="<?php echo $row[0] ?>"></button>
                          </td>
                          <td>
                            <a href="users_view.php?id=<?php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                          </td>
                          <td>
                            <a href="users_data_print.php?id=<?php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                          </td>
                        </tr>
                    <?php  
                      }// END ADMINS WHILE
                    }
                    ?>

                    <?php
                      if(isset($_POST["btnreg"])){
                        $en = mysqli_real_escape_string($conn, @$_POST['enames']);
                        $ei = mysqli_real_escape_string($conn, @$_POST['empids']);
                        $us = mysqli_real_escape_string($conn, $_POST['users']);
                        $pa = mysqli_real_escape_string($conn, $_POST['passs']);
                        $ge = mysqli_real_escape_string($conn, @$_POST['gens']);
                        $ty = mysqli_real_escape_string($conn, @$_POST['user_types']);
                        $sq = mysqli_real_escape_string($conn, @$_POST['sec_que']);
                        $sa = mysqli_real_escape_string($conn, @$_POST['sec_ans']);
                        $da = mysqli_real_escape_string($conn, $_POST['dates']);

                        $path = "images/";
                        $img_name = @$path . @$_FILES['img']['name'];

                        $insert = mysqli_query($conn, "CALL users_sp('$ei','$us','$pa','$ge','$img_name','$ty','$sq','$sa','$da')");
                        $ress = mysqli_fetch_array($insert);
                        // echo "<script>alert('Inserted Successfully898')</script>";

                        if($ress){
                          $msg = explode("|", $ress[0]);
                          move_uploaded_file(@$_FILES['img']['tmp_name'], @$img_name);
                          if($msg[0] = 'danger'){
                            echo "<script> alert('$msg[1]'); window.location='users_view.php'; </script>";
                          }else{
                            echo "<script> alert('$msg[1]'); window.location='users_view.php'; </script>";
                          }
                        }else{
                          echo $conn->error;
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row -->
        <!-- Main row -->
        
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <?php require("modals/all_modal.php") ?>
  <!-- /.content-wrapper -->
  <?php include("library/footer.php")?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
  <?php require("library/script.php"); ?>

  <script>
    $("body").delegate('.get_edit','click',function(){
      var id = $(this).attr('alt');
      var name = $(this).attr('action');
      // alert(id);
      var data = '_id='+id+'&_action='+name;
      // alert(data);

      $.post("get_tbls_info.php",data,function(res){
        var sql = res.split(",");

        $('#user_ids').val(sql[0]);
        $('#empids').val(sql[1]);
        $('#users').val(sql[2]);
        $('#passs').val(sql[3]);
        $('#genders').val(sql[4]);
        $('#statuss').val(sql[5]);
        $('#user_types').val(sql[6]);
        $('#sec_que').val(sql[7]);
        $('#sec_ans').val(sql[8]);
        $('#user_dates').val(sql[9]);

        $('#users_modal').modal('show');
      });
    });
  </script>

</body>
</html>






<style type="text/css">
  #e{
      cursor: pointer;
    }
</style>

<script type="text/javascript">
  // var eyee = document.getElementById("e").getAttribute('class');
  function show(){
    var mypass = document.getElementById("password");
    var mycla = document.getElementById("e").getAttribute('class');
    // alert(mycla);
    if (mypass.type == "password") {
      mypass.type = "text";
      eyee = "fas fa-eye-slash";
      document.getElementById("e").setAttribute('class',eyee);
    }else{
      mypass.type = "password";
      eyee = "fas fa-eye";
      document.getElementById("e").setAttribute('class',eyee);
    }
  }
</script>








<!--  -->




  <!-- <script>
    $(document).ready(function(){
      $("body"). on('click', '.get_edit', function(){
        var id = "us_id="+$(this).attr("alt");

        $.ajax({
         url:"get_users.php",
         method:"POST",
         data:id,            
         success:function(data){
              
          var res = data.split(",");
          $('#user_id').val(res[0]);
          $('#empid').val(res[1]);
          $('#user').val(res[2]);
          $('#pass').val(res[3]);
          $('#gender').val(res[4]);
          $('#image').val(res[5]);
          $('#status').val(res[6]);
          $('#date').val(res[7]);
              

          $('#users_modal').modal('show');
            }
          });
        });
       });         
      
    </script> -->