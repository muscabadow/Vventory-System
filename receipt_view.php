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
            <h1 class="m-0">Receipt View</h1>
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
                <h3 class="card-title">Receipt View</h3>

                <div class="row m-12">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                  <button type="button" class="btn btn btn-block btn-info far fa-edit" data-toggle="modal" data-target="#rec_reg_modal">
                    Add New Receipt
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
                    <th>Order No</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Remained</th>
                    <th>Discount</th>
                    <th>Balance</th>
                    <th>Sender</th>
                    <th>Receifer</th>
                    <th>Ref#</th>
                    <th>User</th>
                    <th>Status</th>
                    <th>Date</th>

                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(isset($_POST['r_update'])){
                      $rid = mysqli_real_escape_string($conn, $_POST['rec_id']);
                      $or = mysqli_real_escape_string($conn, $_POST['or_id']);
                      $ca = mysqli_real_escape_string($conn, $_POST['r_amo']);
                      $pa = mysqli_real_escape_string($conn, $_POST['paid']);
                      $di = mysqli_real_escape_string($conn, $_POST['dis']);                
                      $ai = mysqli_real_escape_string($conn, $_POST['acc_ph']);                
                      $se = mysqli_real_escape_string($conn, $_POST['send']);
                      $st = mysqli_real_escape_string($conn, $_POST['r_sta']);

                      $edit = mysqli_query($conn, "CALL update_receipt_sp('$rid','$or','$pa','$di','$ai','$se','$st')");
                      echo "<script>alert('Updated Successfully')</script>";
                    }
                    ?>

                    <?php
                      if(isset($_GET['id'])){
                        $del = $_GET['id'];
                        $query = mysqli_query($conn, "DELETE FROM receipt WHERE rec_id=$del");
                      }
                      ?>

                    <?php 
                    
                    $sql = mysqli_query($conn, "SELECT `rec_id`, r.order_id, c.cust_name, r.current_amount, `paid`,  r.remained, `discount`, r.new_balance, `account_id`, `send_number`, `ref_no`, r.user_id, IF(r.status=0,'Canceled','Recepted'), r.RegDate FROM receipt r JOIN customers c ON c.cust_id=r.cust_id JOIN orders o ON o.order_id=r.order_id;");

                    while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo "$$row[3]" ?></td>
                        <td><?php echo "$$row[4]" ?></td>
                        <td><?php echo "$$row[5]" ?></td>
                        <td><?php echo "$$row[6]" ?></td>
                        <td><?php echo "$$row[7]" ?></td>
                        <td><?php echo $row[9] ?></td>
                        <td><?php echo $row[8] ?></td>
                        <td><?php echo $row[10] ?></td>
                        <td><?php echo $row[11] ?></td>
                        <td><?php echo $row[12] ?></td>
                        <td><?php echo $row[13] ?></td>

                        <td>
                          <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> -->
                            <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="receipt" alt="<?php echo $row[0] ?>"></button>
                        </td>
                        <td>
                          <a href="receipt_view.php?id=<?php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                          <a href="rec_data_print.php?id=<?php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                        </td>
                      </tr>

                    <?php  
                    }
                    ?>



                    <?php
              if(isset($_POST["btnreg"])){
                $cu = mysqli_real_escape_string($conn, $_POST['cust_id']);
                $or = mysqli_real_escape_string($conn, $_POST['order_id']);
                $ca = mysqli_real_escape_string($conn, $_POST['current']);
                $pa = mysqli_real_escape_string($conn, $_POST['paid']);
                $re = mysqli_real_escape_string($conn, $_POST['remained']);
                $di = mysqli_real_escape_string($conn, $_POST['dis']);                
                $ac = mysqli_real_escape_string($conn, $_POST['acc']);
                $te = mysqli_real_escape_string($conn, $_POST['tell']);                
                $ne = mysqli_real_escape_string($conn, $_POST['new_bal']);
                $us = mysqli_real_escape_string($conn, $_POST['user_id']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL receipts_sp('$cu','$or','$ca','$pa','$re','$di','$ne','$ac','$te','$us','$da');");
                $ress = mysqli_fetch_array($insert);

                if($insert){
                  $e_row = explode("|", $ress[0]);
                  if ($e_row[0] = 'success') {
                    echo "<script>alert('$e_row[1]'); window.location='receipt_view.php'; </script>";
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

        $('#rec_id').val(sql[0]);
        $('#or_id').val(sql[1]);
        $('#r_cust').val(sql[2]);
        $('#r_amo').val(sql[3]);
        $('#paid').val(sql[4]);
        $('#rem').val(sql[5]);
        $('#dis').val(sql[6]);
        $('#n_bal').val(sql[7]);
        $('#acc_ph').val(sql[8]);
        $('#send').val(sql[9]);
        $('#ref_no').val(sql[10]);
        $('#r_us_id').val(sql[11]);
        $('#r_sta').val(sql[12]);
        $('#r_date').val(sql[13]);

        $('#rec_modal').modal('show');
      });
    });


    // GET CUSTOMER AND HIS CURRENT AMOUNT
    $('.get_order').keyup(function(){
      var order_id = $(this).val();
      var action = $(this).attr('action');
      // alert(action);
      // var cname = $('.get_text').val();

      var data = 'id='+order_id+'&action='+action;
      $.post('get/get_curren_amount.php',data,function(res){
        var sql = res.split(',');

        if(order_id == 0){
         return false;
        }else{
          $('.get_id').val(sql[0]);
          $('.get_text').val(sql[1]);
          $('.my_text').val(sql[2]);
        }

      });
    });



    // GET REMAINED AND NEW BALANCE
    $(".get_paid").keyup(function(){
      var get_paid = $(this).val();
      var get_current = $(".my_text").val();

      $(".remain").val(get_current - get_paid);
    });


    // GET NEW BALANCE
    $(".discount").keyup(function(){
      var discount = $(this).val();
      var remain = $(".remain").val();

      $(".new_balance").val(remain - discount);
    });


    $(".xadid").keyup(function(){
      var kan = $(this).val();
      var len = kan.length;
      // alert(len);
      if (kan.length > 9) {
        $(this).val('');
      }else{
        $(this).val();
      }
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