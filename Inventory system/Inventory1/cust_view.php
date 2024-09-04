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
            <h1 class="m-0">Customer View</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
 -->            </ol>
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
                <h3 class="card-title">Customer View</h3>

              <div class="row m-12">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                  <button type="button" class="btn btn btn-block btn-info far fa-edit" data-toggle="modal" data-target="#cust_reg_modal">
                    Add New Customer
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
                    <th>Tell</th>
                    <th>Address</th>
                    <th>Balance</th>
                    <th>User ID</th>
                    <th>Date</th>

                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(isset($_POST['cus_update'])){
                      $cid = mysqli_real_escape_string($conn, $_POST['cus_id']);
                      $cn = mysqli_real_escape_string($conn, $_POST['cname']);
                      $te = mysqli_real_escape_string($conn, $_POST['ctell']);
                      $ad = mysqli_real_escape_string($conn, $_POST['cadd']);
                      $ba = mysqli_real_escape_string($conn, $_POST['bal']);

                      $edit = mysqli_query($conn, "UPDATE `customers` SET `cust_name`='$cn',`tell`='$te',`address`='$ad',`balance`='$ba' WHERE `cust_id`='$cid'");
                      echo "<script>alert('Updated Successfully')</script>";
                    }
                    ?>

                    <?php
                      if(isset($_GET['id'])){
                        $del = $_GET['id'];
                        $query = mysqli_query($conn, "DELETE FROM customers WHERE cust_id=$del");
                      }
                      ?>

                    <?php 
                    
                    $sql = mysqli_query($conn, "SELECT * FROM customers");

                    while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo '$'.$row[4] ?></td>
                        <td><?php echo $row[5] ?></td>
                        <td><?php echo $row[6] ?></td>

                        <td>
                          <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> -->
                          <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="customer" alt="<?php echo $row[0] ?>"></button>
                        </td>
                        <td>
                          <a href="cust_view.php?id=<?php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                          <a href="cust_data_print.php?id=<?php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                        </td>
                      </tr>

                    <?php  
                    }
                    ?>



                    <?php
              if(isset($_POST["btnreg"])){
                $en = mysqli_real_escape_string($conn, $_POST['cname']);
                $te = mysqli_real_escape_string($conn, $_POST['tell']);
                $ad = mysqli_real_escape_string($conn, $_POST['add']);
                $em = mysqli_real_escape_string($conn, $_POST['bal']);
                $us = mysqli_real_escape_string($conn, $_POST['user_id']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL customers_sp('$en','$te','$ad','$em','$us','$da')");
                $ress = mysqli_fetch_array($insert);

                if($insert){
                  $e_row = explode("|", $ress[0]);
                  if ($e_row[0] = 'danger') {
                    echo "<script>alert('$e_row[1]'); window.location='cust_view.php';</script>";
                  }else{
                    echo "<script>alert('$e_row[1]'); window.location='cust_view.php';</script>";
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
      // alert(name);
      var data = '_id='+id+'&_action='+name;
      // alert(data);

      $.post("get_tbls_info.php",data,function(res){
        var sql = res.split(",");

        $('#cus_id').val(sql[0]);
        $('#cname').val(sql[1]);
        $('#ctell').val(sql[2]);
        $('#cadd').val(sql[3]);
        $('#bal').val(sql[4]);
        $('#c_us_id').val(sql[5]);
        $('#cus_date').val(sql[6]);

        $('#cust_modal').modal('show');
      });
    });
  </script>

</body>
</html>

















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