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
            <h1 class="m-0">Purchase Payment View</h1>
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
                <h3 class="card-title">Purchase Payment View</h3>

              <div class="row m-12">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                  <button type="button" class="btn btn btn-block btn-info far fa-edit" data-toggle="modal" data-target="#pu_pa_reg_modal">
                    Add New Payment
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
                    <th>Purchase No</th>
                    <th>Supplier</th>
                    <th>Amount</th>
                    <th>Paid</th>
                    <th>Discount</th>
                    <th>Balance</th>
                    <th>Sender</th>
                    <th>Receifer</th>
                    <th>User</th>
                    <th>Invoice</th>
                    <th>Status</th>
                    <th>Date</th>

                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(isset($_POST['pa_update'])){
                      $pid = mysqli_real_escape_string($conn, $_POST['pay_id']);
                      $pu = mysqli_real_escape_string($conn, $_POST['pu_id']);
                      $su = mysqli_real_escape_string($conn, $_POST['su_nam']);
                      $ca = mysqli_real_escape_string($conn, $_POST['ps_amo']);
                      $pa = mysqli_real_escape_string($conn, $_POST['pu_paid']);
                      $pd = mysqli_real_escape_string($conn, $_POST['pu_dis']);
                      $ba = ($ca - $pa) - $pd;
                      $ai = mysqli_real_escape_string($conn, $_POST['pa_acc_ph']);                
                      $se = mysqli_real_escape_string($conn, $_POST['pa_send']);
                      $st = mysqli_real_escape_string($conn, $_POST['pa_r_sta']);
                      $pf = mysqli_real_escape_string($conn, $_POST['pa_ref_no']);

                      $edit = mysqli_query($conn, "CALL update_payments_sp('$pid','$pu','$su','$ca','$pa','$pd','$ba','$se','$ai','$pf','$st')");
                    }
                    ?>

                    <?php
                      if(isset($_GET['id'])){
                        $del = $_GET['id'];
                        $query = mysqli_query($conn, "DELETE FROM payments WHERE payment_id=$del");
                      }
                      ?>

                    <?php 
                    
                    $sql = mysqli_query($conn, "SELECT p.payment_id,p.purchase_id,s.name,p.total_price,p.paid,p.discount,p.balance,p.Sender,p.receifer,p.user_id,p.ref_no,IF(p.status=0,'Canceled','Payed'),p.RegDate FROM payments p JOIN supplier s ON s.supplier_id=p.supplier_id");

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
                        <td><?php echo $row[7] ?></td>
                        <td><?php echo $row[8] ?></td>
                        <td><?php echo $row[9] ?></td>
                        <td><?php echo $row[10] ?></td>
                        <td><?php echo $row[11] ?></td>
                        <td><?php echo $row[12] ?></td>

                        <td>
                          <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> -->
                            <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="payments" alt="<?php echo $row[0] ?>"></button>
                        </td>
                        <td>
                          <a href="payments_view.php?id=<?php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                          <a href="pay_data_print.php?id=<?php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                        </td>
                      </tr>

                    <?php  
                    }
                    ?>


                    <?php
              if(isset($_POST["btnreg"])){
                $pu = mysqli_real_escape_string($conn, $_POST['pur_id']);
                $su = mysqli_real_escape_string($conn, $_POST['supp_id']);
                $cu = mysqli_real_escape_string($conn, $_POST['pa_current']);
                $pa = mysqli_real_escape_string($conn, $_POST['pa_paid']);
                $pd = mysqli_real_escape_string($conn, $_POST['pa_dis']);
                $ne = mysqli_real_escape_string($conn, $_POST['pa_new_bal']);
                $us = mysqli_real_escape_string($conn, $_POST['user_id']);
                $se = mysqli_real_escape_string($conn, $_POST['pa_sen']);
                $re = mysqli_real_escape_string($conn, $_POST['pa_rec']);
                $rf = mysqli_real_escape_string($conn, $_POST['pa_ref_no']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL payments_sp('$pu','$su','$cu','$pa','$pd','$ne','$us','$se','$re','$rf','$da');");
                $ress = mysqli_fetch_array($insert);

                if($insert){
                  $e_row = explode("|", $ress[0]);
                  if ($e_row[0] = 'danger') {
                    echo "<script>alert('$e_row[1]'); window.location='payments_view.php';</script>";
                  }else{
                    echo "<script>alert('$e_row[1]'); window.location='payments_view.php';</script>";
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

        $('#pay_id').val(sql[0]);
        $('#pu_id').val(sql[1]);
        $('#su_nam').val(sql[2]);
        $('#pa_amo').val(sql[3]);
        $('#pu_paid').val(sql[4]);
        $('#pu_dis').val(sql[5]);
        $('#pa_n_bal').val(sql[6]);
        $('#pa_r_us_id').val(sql[7]);
        $('#pa_send').val(sql[8]);
        $('#pa_acc_ph').val(sql[9]);
        $('#pa_ref_no').val(sql[10]);
        $('#pa_r_sta').val(sql[11]);
        $('#pa_date').val(sql[12]);

        $('#pay_modal').modal('show');
      });
    });


    // GET SUPPLIER AND HIS CURRENT AMOUNT
    $('.pa_get_order').keyup(function(){
      var pur_id = $(this).val();
      var action = $(this).attr('action');
      // alert(action);
      // var cname = $('.get_text').val();

      var data = 'id='+pur_id+'&action='+action;
      // alert(data);
      $.post('get/get_curren_amount.php',data,function(res){
        var sql = res.split(',');

        if(pur_id == 0){
         return false;
        }else{
          $('.pa_get_id').val(sql[0]);
          $('.pa_get_text').val(sql[1]);
          $('.pa_my_text').val(sql[2]);
        }
      });
    });



    // AFTER PAID GET NEW BALANCE
    $(".pa_get_paid").keyup(function(){
      var get_paid = $(this).val();
      var get_current = $(".pa_my_text").val();

      $(".pa_new_balance").val(get_current - get_paid);
      $(".pa_get_remain").val(get_current - get_paid);
    });


    // AFTER DISCOUNT GET NEW BALANCE
    $(".pa_get_dis").keyup(function(){
      var get_discount = $(this).val();
      var get_remain = $(".pa_get_remain").val();

      $(".pa_new_balance").val(get_remain - get_discount);
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