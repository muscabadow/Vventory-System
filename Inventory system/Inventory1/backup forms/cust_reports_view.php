<?php require("library/conn.php"); ?>
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
            <h1 class="m-0">Customer Reports View</h1>
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
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">Customer Reports View</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- <label for="inputEmail3" class="col-sm-2 col-form-label">Email : 
                </label> -->

                <form method="POST">                  
                    <input type="text" name="cust" style="margin-right: 4%; margin-left: 0px" class="form-control float-left col-sm-4 " placeholder="Search Customer ID">
                    <input type="text" name="order" class="form-control float-left col-sm-4 " placeholder="Search Order No">
                    <button type="submit" name="btnreg" class="form-control float-right col-sm-3 col-form-label btn-primary">Search
                    </button>
                </form>
                    <br><br>
                  
                  <!-- <form method="POST">                  
                    <input type="text" name="cust" style="margin-right: 4%; margin-left: 0px" class="form-control float-left col-sm-4 " placeholder="Search Customer ID">
                    <input type="text" name="order" class="form-control float-left col-sm-4 " placeholder="Search Order No">
                    <button type="submit" name="btnreg" class="form-control float-right col-sm-3 col-form-label btn-primary">Search
                    </button>
                </form>
                    <br><br> -->
                    

                <table id="example1" class="table table-bordered table-striped table-sm">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Order No</th>
                    <th>Name</th>
                    <th>Item</th>
                    <th>Item Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Remained</th>
                    <th>Discount</th>
                    <th>Balance</th>
                    <!-- <th>Status</th>
                    <th>Date</th> -->

                    <!-- <th></th>
                    <th></th>
                    <th></th> -->
                  </tr>
                  </thead>
                  <tbody>

                    <?php

                    if (isset($_POST['btnreg'])) {
                      extract($_POST);                    
                    $sql = mysqli_query($conn, "CALL customers_report_sp('$cust','$order')");

                    while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo $row[4] ?></td>
                        <td><?php echo $row[5] ?></td>
                        <td><?php echo "$$row[6]" ?></td>
                        <td><?php echo "$$row[7]" ?></td>
                        <td><?php echo "$$row[8]" ?></td>
                        <td><?php echo "$$row[9]" ?></td>
                        <td><?php echo "$$row[10]" ?></td>
                        <td><?php echo "$$row[11]" ?></td>
                      </tr>

                    <?php  
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
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>

  <!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

  <script>
  $(function () {
    // $("#example1").DataTable({
    //   "responsive": true, "lengthChange": false, "autoWidth": false,
    //   "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    // }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
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













<!-- 
    <div class="col-sm-12">
                      <label class="col-sm-3 col-form-label">Password : <input type="password" class="form-control" id="inputPassword3" placeholder="Password"></label>
                    </div> 







                    <input type="text" class="form-control float-left col-sm-4 " placeholder="Search Customer ID">
                    <input type="text" class="form-control float-left col-sm-4 " placeholder="Search Order No">
                    <button type="submit" class="form-control float-right col-sm-4 col-form-label btn-primary">Search</button>
                    <br><br>





<input type="text" style="margin-right: 5%; margin-left: 20px" class="form-control float-left col-sm-3 " placeholder="Search Customer ID">
                    <input type="text" class="form-control float-left col-sm-3 " placeholder="Search Order No">
                    <button type="submit" class="form-control float-right col-sm-3 col-form-label btn-primary">Search</button>
                    <br><br>



                    -->