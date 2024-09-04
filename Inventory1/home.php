<?php
session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: index.php");
  return false;
}

include("library/conn.php");

//THEMES
// $rq10 = mysqli_query($conn, "SELECT * FROM `theme` LIMIT 1");
// $resq10 = mysqli_fetch_array($rq10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require("library/head.php")?>
</head>
<body style="background-color: #143655" class="hold-transition sidebar-mini layout-fixed dark-mode">
  <!-- <h1 class="text-center">sd</h1> -->
<div class="wrapper" style="background-color: #143655; color: white;">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center" style="background-color: #143655;">
    <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->

  <!-- Navbar -->
    <?php require("library/nav.php")?>
  <!-- /.navbar -->
    
  <!-- Main Sidebar Container -->
  <?php require("library/sidebar.php") ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="background-color: #143655">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0" style="color: white;">INVENTORY SYSTEM</h1>
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
              <a href="get/get_chart_data_rp.php" action="<php echo $ress['action'] ?>" class="small-box-footer new_orders">More info <i class="fas fa-arrow-circle-right"></i></a>
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
          if ($_SESSION['type'] == 'Developer' || $_SESSION['type'] == 'Admin') {
            $sql2 = mysqli_query($conn, "SELECT chart_count(c.action)`count`,c.text,c.icon,c.color,
                                    c.action FROM chart c WHERE c.id!=5 ORDER BY c.order_by;");

            while ($ress2 = mysqli_fetch_array($sql2)) {
          ?>
          <div class="col-12 col-sm-6 col-md-3">
            <a href="get/get_chart_data_rp.php" class="new_orders" action="<?php echo $ress2['action'] ?>">
            <div class="info-box" style="background-color: #143655; color: white; box-shadow: 0px 5px 20px rgba(0, 0, 0, .8);">
              <span class="info-box-icon <?php echo $ress2['color']; ?> elevation-1"><i class="<?php echo $ress2['icon']; ?>"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"><?php echo $ress2['text']; ?></span>
                <span class="info-box-number">
                  <?php echo $ress2['count']; ?>
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
          }else{
            $sql1 = mysqli_query($conn, "SELECT c.id,chart_count(c.action)`count`,c.text,c.icon,c.color,
                                    c.action FROM chart c WHERE c.id!=2 ORDER BY c.order_by;");

            while ($ress1 = mysqli_fetch_array($sql1)) {
              ?>
          <div class="col-12 col-sm-6 col-md-3">
            <a href="get/get_chart_data_rp.php" class="new_orders" action="<?php echo $ress1['action'] ?>">
            <div class="info-box" style="background-color: #143655">
              <span class="info-box-icon <?php echo $ress1['color']; ?> elevation-1"><i class="<?php echo $ress1['icon']; ?>"></i></span>
              <div class="info-box-content">
                <span class="info-box-text"><?php echo $ress1['text']; ?></span>
                <span class="info-box-number">
                  <?php echo $ress1['count']; ?>
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
          }
          ?>
          <!-- /.col -->          
        </div>
        <!-- SMALL STATUS END -->

        <!-- Main row -->

        <div class="hide-receipt hide-receipt1">
          <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group input-group-lg">
                                    <input type="search" name="order" class="form-control form-control-lg custid" style="background-color: #143655; color: white;" autocomplete="off" placeholder="Search Customer ID,Name and Tell Here...">
                                  <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default mybtn" style="background-color: #143655">
                                       <i class="fa fa-search" style="color: white;"></i>
                                    </button>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="hide-receipt2 hide-receipt3">
          <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-12">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                              <div class="input-group input-group-lg">
                                <select class="form-control form-control-lg custid store" style="background-color: #143655; color: white;">
                                  <option value="%">Choose Store</option>
                                  <?php
                                  $qs = mysqli_query($conn, "SELECT store_id,store_name FROM store");
                                  while($qs1 = mysqli_fetch_array($qs)){
                                    echo "<option value='$qs1[0]'>$qs1[1]</option>";
                                  }
                                  ?>
                                </select>
                              </div>
                            </div>
                            <div class="col-6">
                              <div class="input-group input-group-lg">
                                <select class="form-control form-control-lg text" style="background-color: #143655; color: white;">
                                  <option value="%">Choose Item</option>
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
                                  <button type="submit" class="btn btn-lg btn-default mybtn" style="background-color: #143655; color: white;">
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
        </div>

          <div class="hide">
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
    var text = "%";
    var action = $(this).attr("action");
    var url = $(this).attr('href');
    // alert(action);

    if (action == 'receipt') {
      $(".hide-receipt3").addClass("hide-receipt2");
      $(".hide-receipt").removeClass("hide-receipt");

      var data = "text="+text+"&action="+action+"&cust="+cust;
      $.post(url,data,function(res){
        $("#searchresult").html(res);
      });

      // SEARCH CUSTOMERS TOTAL RECEIPT
      $("body").delegate(".custid","keyup",function(){
        var custid = $(this).val();

        var data = "text="+text+"&action="+action+"&cust="+custid;
        $.post(url,data,function(res){
          $("#searchresult").html(res);
        });
      });
      // END IF ACTION RECEIPT

    }else{

      if (action == 'store') {
        $(".hide-receipt2").removeClass("hide-receipt2");
        $(".hide-receipt1").addClass("hide-receipt");
        var data = "text="+text+"&action="+action+"&cust="+cust;
        $.post(url,data,function(res){
          $("#searchresult").html(res);
        });

        // SEARCH STORE
        $("body").delegate(".custid","change",function(){
          var custid = $(this).val();
          var text = $('.text').val();

          var data = "text="+text+"&action="+action+"&cust="+custid;
          $.post(url,data,function(res){
            $("#searchresult").html(res);
          });
        });
        // SEARCH ITEM
        $("body").delegate(".text","change",function(){
          var text = $(this).val();
          var store = $('.store').val();

          var data = "text="+text+"&action="+action+"&cust="+store;
          $.post(url,data,function(res){
            $("#searchresult").html(res);
          });
        });
        // END IF ACTION STORE

      }else{
        $(".hide-receipt1").addClass("hide-receipt");
        $(".hide-receipt3").addClass("hide-receipt2");
        var data = "text="+text+"&action="+action+"&cust="+cust;
        $.post(url,data,function(res){
          $("#searchresult").html(res);
        });
      }
      // END IF ACTION NOT RECEIPT AND STORE

    }
    
  });


  // // SEARCH CUSTOMERS NEW ORDERS 
  // $("body").delegate(".custid","keyup",function(){
  //   var custid = $(this).val();
  //   var url = $('.new_orders').attr('href');
  //   var action = $('.new_orders').attr("action");
  //   // alert(action);

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
  .hide-receipt,.hide-receipt2{
    display: none;
  }
  .bg-color{
    background-color: #143655;
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














          