<?php
require("library/conn.php");

// $_SESSION['user_id'] =  

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require("library/head.php")?>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

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
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-sm-8">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Receipt Registration Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST">
                <div class="card-body">

                  <div class="form-group">
                    <label>Order ID</label>
                    <input type="text" class="form-control get_order" action="receipt" name="order_id" placeholder="Enter Order ID">
                  </div>

                  <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control get_text" placeholder="Customer Name" readonly> 
                    <input type="hidden" name="cust_id" class="get_id">                 
                  </div>
                  <div class="form-group">
                    <label>Current Amount</label>
                    <input type="text" class="form-control my_text" name="current" placeholder="Current Amount" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Paid</label>
                    <input type="text" class="form-control get_paid" name="paid" placeholder="Paid Money" required="">
                  </div>
                  <div class="form-group">
                    <label>Remained</label>
                    <input type="text" class="form-control remain" name="remained" placeholder="Remained" readonly>
                  </div>
                  <div class="form-group">
                    <label>Discount</label>
                    <input type="text" class="form-control discount" name="dis" placeholder="Discount">
                  </div>
                  <div class="form-group">
                    <label>New Balance</label>
                    <input type="text" class="form-control new_balance" name="new_bal" placeholder="New Balance" readonly>
                  </div>
                  <div class="form-group">
                    <label>Account / Phone Number</label>
                    <input type="text" class="form-control" name="acc" placeholder="Loo Diraha"required="">
                  </div>
                  <div class="form-group">
                    <label>Send Number</label>
                    <input type="text" class="form-control" name="tell" placeholder="Diraha sida 61XXXXXXX" required="">
                  </div>

                  <input type="hidden" name="user_id" value="0">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
              
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
                  $row = explode("|", $ress[0]);
                  ?>
                  <div class="btn btn-block btn-<?php echo $row[0]?>">
                    <?php echo $row[1] ?>                    
                  </div>
                  <?php                   
                }else{
                  echo $conn->error;
                }
              }
              ?>
            </div>
          </div>
          <div class="col-sm-2"></div>
        </div>
        <!-- /.row -->
        <!-- Main row -->
        
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
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
  <?php require("library/script.php")?>



    <script>

    // GET CUSTOMER AND HIS CURRENT AMOUNT
    $('.get_order').keyup(function(){
      var order_id = $(this).val();
      var action = $(this).attr('action');
      // alert(action);
      // var cname = $('.get_text').val();

      var data = 'id='+order_id+'&action='+action;
      $.post('get_curren_amount.php',data,function(res){
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


  </script>


</body>
</html>


<style type="text/css">
  .hide{
    display: none;
  }
</style>