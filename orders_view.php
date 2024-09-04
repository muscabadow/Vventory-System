<?php 
session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: index.php");
  return false;
}
require("library/conn.php"); 

//THEMES
$rq10 = mysqli_query($conn, "SELECT * FROM `theme` LIMIT 1");
$resq10 = mysqli_fetch_array($rq10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>INVENTORY SYSTEM</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- BS Stepper -->
  <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
  <!-- dropzonejs -->
  <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<body class="hold-transition sidebar-mini">
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
            <h1 class="m-0">Orders View</h1>
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

    <!-- <php require('modals/insert_modals.php') ?> -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Orders View</h3>

              <div class="row m-12">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                  <button type="button" class="btn btn btn-block btn-info far fa-edit" data-toggle="modal" data-target="#order_reg_modal">
                    Add New Order
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
                    <th>Customer</th>
                    <th>Pro ID</th>
                    <th>Item</th>
                    <th>Item Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
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
                    if(isset($_POST['o_update'])){
                      $pd = mysqli_real_escape_string($conn, $_POST['order_id']);
                      $pi = mysqli_real_escape_string($conn, $_POST['o_pro_id']);
                      $qy = mysqli_real_escape_string($conn, $_POST['o_qty']);
                      $pe = mysqli_real_escape_string($conn, $_POST['o_price']);
                      $st = mysqli_real_escape_string($conn, $_POST['o_sta']);
                      $to = $qy * $pe;

                  $edit = mysqli_query($conn, "CALL update_orders_sp('$pd','$pi','$qy','$pe','$to','$st')");
                  echo "<script>alert('Updated Successfully')</script>";
                    }
                    ?>

                    <?php
                      if(isset($_GET['id'])){
                        $del = $_GET['id'];
                        $query = mysqli_query($conn, "DELETE FROM orders WHERE order_id=$del");
                      }
                      ?>

                    <?php 
                    
                    $sql = mysqli_query($conn, "SELECT o.order_id,c.cust_name,p.pro_id,CONCAT(i.item_name,' ',i.Category),p.item_type,o.qty, o.price,o.total_price,o.user_id,IF(o.status=1,'Ordered','Canceled'),o.RegDate FROM orders o JOIN products p ON p.pro_id=o.pro_id JOIN store s ON s.store_id=p.store_id JOIN items i ON i.item_id=p.item_id JOIN customers c ON c.cust_id=o.cust_id");

                    while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo $row[4] ?></td>
                        <td><?php echo $row[5] ?></td>
                        <td><?php echo '$'.$row[6] ?></td>
                        <td><?php echo '$'.$row[7] ?></td>
                        <td><?php echo $row[8] ?></td>
                        <td><?php echo $row[9] ?></td>
                        <td><?php echo $row[10] ?></td>

                        <td>
                          <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> -->
                          <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="orders" alt="<?php echo $row[0] ?>"></button>
                        </td>
                        <td>
                          <a href="orders_view.php?id=<?php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                          <a href="order_data_print.php?id=<?php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                        </td>
                      </tr>

                    <?php  
                    }
                    ?>



                    <?php
              if(isset($_POST["btnreg"])){
                $cu = mysqli_real_escape_string($conn, @$_POST['cust_id']);
                $pi = mysqli_real_escape_string($conn, @$_POST['proid']);
                $qt = mysqli_real_escape_string($conn, $_POST['o_qty']);                
                $pr = mysqli_real_escape_string($conn, $_POST['o_price']);
                $tp = mysqli_real_escape_string($conn, $_POST['o_total']);
                $us = mysqli_real_escape_string($conn, $_POST['user_id']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL orders_sp('$cu','$pi','$qt','$pr','$tp','$us','$da')");
                $ress = mysqli_fetch_array($insert);

                if($insert){
                  $e_row = explode("|", $ress[0]);
                  if ($e_row[0] = 'success') {
                    echo "<script>alert('$e_row[1]'); window.location='orders_view.php'; </script>";
                  }else{
                    echo "<script>alert('$e_row[1]'); window.location='orders_view.php'; </script>";
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
        <?php require("modals/insert_modals.php"); ?>
        <!-- Main row -->
        
<!-- CUSTOMER MODAL -->
<div class="modal fade" id="custss_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Customer Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="orders_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" name="cname" placeholder="Customer Name" required>
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="text" class="form-control" name="ctell" placeholder="Customer Tell" required>
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="cadd" placeholder="Customer Address" required>
                  </div>
                  <div class="form-group">
                    <label>Balance</label>
                    <input type="number" class="form-control" name="bal" placeholder="Before System Lacagti Lagu Lahaa">
                  </div>

                    <input type="hidden" value="0" name="c_us_id">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" name="dte" value="<?php echo date("Y-m-d"); ?>" readOnly>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="cut_reg" class="btn btn-success">Save</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>

            <?php
                if(isset($_POST['cut_reg'])){
                  $cn = mysqli_real_escape_string($conn, $_POST['cname']);
                  $te = mysqli_real_escape_string($conn, $_POST['ctell']);
                  $ad = mysqli_real_escape_string($conn, $_POST['cadd']);
                  $ba = mysqli_real_escape_string($conn, $_POST['bal']);
                  $cd = mysqli_real_escape_string($conn, $_POST['c_us_id']);
                  $dt = mysqli_real_escape_string($conn, $_POST['dte']);

                  $inser = mysqli_query($conn, "CALL customers_sp('$cn','$te','$ad','$ba','$cd','$dt')");
                  $resss = mysqli_fetch_array($inser);

                if($inser){
                  $rowss = explode("|", $resss[0]);
                  if ($rowss[0] = 'danger') {
                    echo "<script>alert('$rowss[1]')</script>";
                  }else{
                    echo "<script>alert('$rowss[1]')</script>";
                  }
                }else{
                  echo $conn->error;
                }
                }
            ?>

        </div>
    </div>
  </div>
</div>

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <?php require("modals/all_modal.php"); ?>
  <?php require("modals/insert_modals.php"); ?>
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

<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>

<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/jquery.inputmask.min.js"></script>

<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>

<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Page specific script -->

<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2(
    {
      dropdownParent: $("#order_reg_modal")
    }
    );
  });
</script>

  <script>
    $("body").delegate('.get_edit','click',function(){
      var id = $(this).attr('alt');
      var name = $(this).attr('action');
      // alert(name);
      var data = '_id='+id+'&_action='+name;
      // alert(data);

      $.post("get_tbls_info.php",data,function(res){
        var sql = res.split(",");

        $('#order_id').val(sql[0]);
        $('#o_cust').val(sql[1]);
        $('#o_pro_id').val(sql[2]);
        $('#o_item_na').val(sql[3]);
        $('#o_qty').val(sql[4]);
        $('#o_price').val(sql[5]);
        $('#o_total').val(sql[6]);
        $('#o_us_id').val(sql[7]);
        $('#o_sta').val(sql[8]);
        $('#o_date').val(sql[9]);

        $('#order_modal').modal('show');
      });
    });



    // Add customer model
    $('.cl_item').click(function(e){
      e.preventDefault();
      $('#custss_modal').modal('show');
    });


    // GET ITEM TYPE
    $(".ichange,.get_store").change(function(){
      var item = $(".ichange").val();
      var store = $(".get_store").val();
      // alert(store);

      var data = "_item_id="+item+"&_store_id="+store;
      // alert(data);

      $.post("get/get_item_type.php",data,function(res){
        $(".itext").html(res);
      });
    });


    // GET ITEM PRICE AND QUANTITY
    $(".itext").change(function(){
      var itemm = $('.ichange').val();
      var storee = $(".get_store").val();
      var item_typee = $(this).val();
      
      var data = "item_idd="+itemm+"&storee="+storee+"&item_typee="+item_typee;
      // alert(data);
      $.post("get/get_qty_price.php",data,function(res){
        var sss = res.split(",");

        $(".i_o_get_qty").val(sss[0]);
        $(".i_o_get_price").val(sss[1]);
      });
    });



    // SEARCH CUSTOMER 
    // $(".select2-search__field").keyup(function(){
    //   var text = $(this).val();
    //   var ul = $(this).next();
    //   alert(text);

    //   ul.css("display","");
    //   if(text != ''){
    //     var data = 'text='+text;
    //     $.post('search_cust.php',data,function(res){
    //       ul.html(res);
    //     });
    //   }else{
    //     ul.css("display","none");
    //   }
    // });


    // CLICK LI GET TEXT AND ID
    $("body").delegate(".get_li","click",function(){
      var text_li = $(this).text();
      // alert(text_li);
      var id = $(this).val();
      // alert(id);

      $(this).parent().prev().val(text_li);
      $(this).parent().next().val(id);

      $(this).parent().css("display","none");
    });


    // GET TOTAL PRICE
    $(".o_get_price,.o_get_qty").keyup(function(){
      var get_qty = $('.o_get_qty').val();
      var get_price = $('.o_get_price').val();

      $('.o_total').val(get_qty * get_price);
    });


    $("body").delegate(".select2","click",function(){
      $(".select2-search__field").attr("placeholder","Search Customer Name or Tell Here...");
    });

    // $("body").delegate(".select2","change",function(){
    //   // alert(1);
    //   // alert($(this).val());
    //   // $(".select2-search__field").attr("placeholder","Search Customer Name or Tell");
    // });
</script>

</body>
</html>