<?php
require("library/conn.php");

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: index.php");
  return false;
}

// TOTAL USERS
$sql = mysqli_query($conn, "SELECT chart_count(p.action)`count`, `action`, `text`, `icon`, `color`, `order_by` FROM purchase_chart p WHERE p.order_by < 5");

// ORDER BY o.order_by;

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
          <div class="col-sm-12">
            <h2 class="text-center display-4">Purchase Chart</h2>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <!-- <div class="row">
          <php
          while ($ress = mysqli_fetch_array($sql)) {
          ?>
          <div class="col-lg-3 col-6">
            
            <div class="small-box <php echo $ress['color']; ?>">
              <div class="inner">
                <h3><php echo $ress['count']; ?></h3>

                <p><php echo $ress['text']; ?></p>
              </div>
              <div class="icon">
                <i  class="<php echo $ress['icon']; ?>"></i>
              </div>
              <a href="get/get_chart_rep.php" action="<php echo $ress['action'] ?>" class="small-box-footer new_orders">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <php  
          }
          ?>
        </div> -->
        <!-- /.row -->

        <!-- SMALL STATUS START -->
        <div class="row">
          <?php
          while ($ress = mysqli_fetch_array($sql)) {
          ?>
          <div class="col-12 col-sm-6 col-md-3">
            <a href="get/get_chart_rep.php" class="new_orders" action="<?php echo $ress['action'] ?>">
            <div class="info-box">
              <span class="info-box-icon <?php echo $ress['color']; ?> elevation-1"><i class="<?php echo $ress['icon']; ?>"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"><?php echo $ress['text']; ?></span>
                <span class="info-box-number">
                  <?php echo $ress['count']; ?>
                  <small></small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            </a>
            <!-- /.info-box -->
          </div>
          <?php 
          }
          ?>
          <!-- /.col -->          
        </div>
        <!-- SMALL STATUS END -->
        
        <!-- Main row -->

        <div class="hide">
          <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group input-group-lg">
                                    <input type="search" name="order" class="form-control form-control-lg custid" autocomplete="off" placeholder="Search Purchase ID,Supplier Name and Date Here...">
                                  <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default mybtn">
                                       <i class="fa fa-search"></i>
                                    </button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
          <div id="searchresult">

          </div>
        </div>
        
        
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
</body>

<script>
  // NEW ORDERS
  $(".new_orders").click(function(c){
    c.preventDefault();

    $(".hide").removeClass("hide");

    var cust = "%";
    var action = $(this).attr("action");
    var url = $(this).attr('href');
    // alert(action);

    var data = "cust="+cust+"&action="+action;
    $.post(url,data,function(res){
      $("#searchresult").html(res);
    });


      // SEARCH CUSTOMERS NEW ORDERS 
      $("body").delegate(".custid","keyup",function(){
      var custid = $(this).val();

      var data = "cust="+custid+"&action="+action;
      // alert(data);
      $.post(url,data,function(res){
        $("#searchresult").html(res);
      });
      });
  });


  // SEARCH CUSTOMERS NEW ORDERS 
  // $("body").delegate(".custid","keyup",function(){
  //   var custid = $(this).val();
  //   var url = $('.new_orders').attr('href');
  //   // var action = $(this).attr("action");
  //   alert(action);

  //   var data = "cust="+custid+"&action="+action;
  //   // alert(data);
  //   $.post(url,data,function(res){
  //     $("#searchresult").html(res);
  //   });
  // });
</script>

</html>


<style type="text/css">
  .hide{
    display: none;
  }
</style>






















<!-- ./col -->
          <!-- <div class="col-lg-3 col-6">
            small box
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Bounce Rate</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          


          <!-- ./col -->
          <!-- <div class="col-lg-3 col-6">
            small box
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><php echo $ress[0]; ?></h3>

                <p>User Registrations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          <!-- ./col -->



          <!-- <div class="col-lg-3 col-6">
            small box
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>65</h3>

                <p>Unique Visitors</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          <!-- ./col -->