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
            <h1 class="m-0">Product Out View</h1>
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
                <h3 class="card-title">Product Out View</h3>

              <!-- <div class="row m-12">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                  <button type="button" class="btn btn btn-block btn-info far fa-edit" data-toggle="modal" data-target="#str_reg_modal">
                    Add New Product Out
                  </button>
                </div>
              </div> -->

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped table-sm">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Store</th>
                    <th>Out Quantity</th>
                    <th>Status</th>
                    <th>Date</th>


                    <!-- <th></th>
                    <th></th>
                    <th></th> -->
                  </tr>
                  </thead>
                  <tbody>
                    <!-- <php
                    if(isset($_POST['store_o_update'])){
                      $sid = mysqli_real_escape_string($conn, $_POST['store_out_id']);
                      $pi = mysqli_real_escape_string($conn, $_POST['o_p_id']);
                      $sn = mysqli_real_escape_string($conn, $_POST['out_qty']);

                      $edit = mysqli_query($conn, "UPDATE `store_out` SET `pro_id`='$pi', `out_qty`='$sn' WHERE `store_out_id`='$sid'");
                      echo "<script>alert('Updated Successfully')</script>";
                    }
                    ?>

                    <php
                      if(isset($_GET['id'])){
                        $del = $_GET['id'];
                        $query = mysqli_query($conn, "DELETE FROM store_out WHERE store_out_id=$del");
                      }
                    ?> -->

                    <?php 
                    
                    $sql = mysqli_query($conn, "SELECT s.store_out_id,CONCAT(i.item_name,' ',i.Category),p.item_type,st.store_name,s.out_qty,IF(s.status=0,'Canceled','Ordered'),s.Reg_date FROM store_out s
                      JOIN products p ON p.pro_id=s.pro_id
                      JOIN items i ON i.item_id=p.item_id
                      JOIN store st ON st.store_id=p.store_id;");

                    while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo $row[4] ?></td>
                        <td><?php echo $row[5] ?></td>
                        <td><?php echo $row[6] ?></td>

                        <!-- <td>
                          <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a>
                          <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="store_o" alt="<php echo $row[0] ?>"></button>
                        </td>
                        <td>
                          <a href="store_out_view.php?id=<php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                          <a href="str_o_data_print.php?id=<php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                        </td> -->
                      </tr>

                    <?php  
                    }
                    ?>

                    <!-- <php
              if(isset($_POST["btnreg"])){
                $or = mysqli_real_escape_string($conn, $_POST['order_id']);
                $en = mysqli_real_escape_string($conn, $_POST['pro_id']);
                $te = mysqli_real_escape_string($conn, $_POST['ou_qty']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL store_out_sp('$or','$en','$te','$da')");
                $ress = mysqli_fetch_array($insert);

                if($insert){
                  $e_row = explode("|", $ress[0]);
                  if ($e_row[0] = 'danger') {
                    echo "<script>alert('$e_row[1]'); window.location='store_out_view.php';</script>";
                  }else{
                    echo "<script>alert('$e_row[1]'); window.location='store_out_view.php';</script>";
                  }                   
                }else{
                  echo $conn->error;
                }
              }
              ?> -->
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

<!--   <script>
    $("body").delegate('.get_edit','click',function(){
      var id = $(this).attr('alt');
      var name = $(this).attr('action');
      // alert(name);
      var data = '_id='+id+'&_action='+name;
      // alert(data);

      $.post("get_tbls_info.php",data,function(res){
        var sql = res.split(",");

        $('#store_out_id').val(sql[0]);
        $('#o__id').val(sql[1])
        $('#o_p_id').val(sql[2]);
        $('#out_qty').val(sql[3]);
        $('#st_o_sta').val(sql[4]);
        $('#store_o_date').val(sql[5]);

        $('#str_o_modal').modal('show');
      });
    });
  </script> -->

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