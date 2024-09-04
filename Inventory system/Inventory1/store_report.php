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
            <h2 class="text-center display-4">Store Report</h2>
            <form method="POST">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-12">

                              <div class="card-body">
                                <div class="row">
                                  <div class="col-6">
                                    <select class="form-control form-control-lg store">
                                      <option selected disabled>Choose Store</option>
                                      <?php
                                      $sql = mysqli_query($conn, "SELECT store_id,store_name FROM store");
                                      while ($row = mysqli_fetch_array($sql)) {
                                      ?>
                                      <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                                      <?php 
                                       } 
                                      ?>                                      
                                    </select>
                                  </div>
                                  <div class="col-6">
                                    <div class="input-group input-group-lg">
                                      <select class="form-control form-control-lg item">
                                      <option selected disabled>Choose Item</option>
                                      <?php
                                      $sql1 = mysqli_query($conn, "SELECT i.item_id,CONCAT(i.item_name,' ',i.Category) FROM items i");
                                      while ($row1 = mysqli_fetch_array($sql1)) {
                                      ?>
                                      <option value="<?php echo $row1[0]; ?>"><?php echo $row1[1]; ?></option>
                                      <?php 
                                       } 
                                      ?>                                      
                                    </select>
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




                    <div class="col-md-12 offset-md-0">
                        <div class="row">
                            <div class="col-12">
                              <div id="getresult">
                                  
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
  // $(".store,.item").change(function(){
  //   var store = $(".store").val();
  //   var item = $(".item").val();

  //   var data = "store="+store+"&item="+item;
  //   // alert(data);

  //   $.post("get/get_store_report.php",data,function(res){
  //     $("#getresult").html(res);
  //   });
  // });  


  $(".mybtn").click(function(e){
    e.preventDefault();
    var store = $(".store").val();
    var item = $(".item").val();

    if (store != null) {

      if (item == null) {
        item = '';
        var data = "store="+store+"&item="+item;
        // alert(data);

        $.post("get/get_store_report.php",data,function(res){
          $('#getresult').html(res);
        });

      }else{

        var data = "store="+store+"&item="+item;
        // alert(data);

        $.post("get/get_store_report.php",data,function(res){
          $('#getresult').html(res);
        });
        
      }

    }else{
      alert("Fadlan soo dooro store");
      window.location='store_report.php';
    }
  });
</script>
</body>
</html>