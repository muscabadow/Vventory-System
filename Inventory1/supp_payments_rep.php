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
<body class="<?php echo $resq10[0] ?> hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php require("library/nav.php")?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php require("library/sidebar.php")?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h2 class="text-center display-4">Supplier Payments Report</h2>
            <form method="POST">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-12">

                              <div class="card-body">
                                <div class="row">
                                  <div class="col-6">
                                    <input type="search" name="cust" class="form-control form-control-lg cust" autocomplete="off" placeholder="Search Supplier Name Here...">
                                  </div>
                                  <div class="col-6">
                                    <div class="input-group input-group-lg">
                                      <input type="search" name="order" class="form-control form-control-lg order" autocomplete="off" placeholder="Search Purchase NO Here...">
                                      <div class="input-group-append">
                                        <button type="submit" class="btn btn-lg btn-default mybtn">
                                          <i class="fa fa-search"></i>
                                        </button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>


                              <!-- <div id="searchresult">
                                  
                              </div> -->

                                <!-- <div class="content-wrapper"> -->
                                  <!-- <section class="content">
                                    <div class="container-fluid">
                                      <div class="card">
                                        <div class="card-body">
                                          <div id="searchresult">
                                  
                                          </div>                                          
                                        </div>
                                      </div>
                                    </div>
                                  </section> -->                                    
                                <!-- </div>                   -->

                            </div>
                        </div>
                    </div>



                    <!-- PRINT RESPONSE RESULT -->
                    <div class="col-md-12 offset-md-0">
                        <div class="row">
                            <div class="col-12">
                              <div id="searchresult">
                                  
                              </div>
                            </div>
                        </div>
                    </div>




                </div>
            </form>
        </div>
    </section>
  </div>

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



<script>
  $(".cust,.order").keyup(function(){
    var cust = $(".cust").val();
    var order = $('.order').val();

    var data = "cust="+cust+"&order="+order;
    // alert(data)

    if (data != '') {
      $.post("get/get_supp_payments_reports.php",data,function(res){
        $('#searchresult').html(res);
      });
    }else{
      $('#searchresult').css("display","none");
    }
  });


  $(".mybtn").click(function(e){
    e.preventDefault();
    var custr = '';
    var orderr = '';

    var data = "cust="+custr+"&order="+orderr;
    // alert(data);

    $.post("get/get_supp_payments_reports.php",data,function(res){
      $('#searchresult').html(res);
    });
  });
</script>
</body>
</html>