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
                <h3 class="card-title">Products Registration Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST">
                <div class="card-body">

                  <div class="form-group">
                    <label>Select Store</label>
                    <select class="form-control" name="store_id" required="">
                      <option selected disabled>Choose Store</option>
                      <?php
                      $my_qu0 = mysqli_query($conn, "SELECT `store_id`, `store_name` FROM `store`");
                      while ($roww0 = mysqli_fetch_array($my_qu0)) {
                      ?>
                      <option value="<?php echo $roww0[0] ?>"><?php echo $roww0[1] ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Choose Item Or <i><a href="#" class="cl_item">add</a></i></label>
                    <select class="form-control" name="item_id">
                      <option selected disabled>Choose Item</option>
                      <?php
                      $my_qu = mysqli_query($conn, "SELECT item_id,CONCAT(item_name,' ',Category) FROM items ORDER BY item_name");
                      while ($roww = mysqli_fetch_array($my_qu)) {
                      ?>
                      <option value="<?php echo $roww[0] ?>"><?php echo $roww[1] ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>                    
                  </div>
                  <div class="form-group">
                    <label>Item Type</label>
                    <input type="text" class="form-control" name="itype" placeholder="Item Type" required="">
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control get_qty" name="qty" placeholder="Quantity" required="">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="form-control get_price" name="price" placeholder="1-ki xabo Lacagta oo kaa gadan yahay">
                  </div>
                  <div class="form-group">
                    <label>Total Price</label>
                    <input type="number" class="form-control total" name="total" placeholder="Total Price" readonly="">
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
                $sn = mysqli_real_escape_string($conn, $_POST['store_id']);
                $it = mysqli_real_escape_string($conn, $_POST['item_id']);
                $ty = mysqli_real_escape_string($conn, $_POST['itype']);
                $qt = mysqli_real_escape_string($conn, $_POST['qty']);                
                $pr = mysqli_real_escape_string($conn, $_POST['price']);
                $tp = mysqli_real_escape_string($conn, $_POST['total']);
                $us = mysqli_real_escape_string($conn, $_POST['user_id']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL product_sp('$sn','$it','$ty','$qt','$pr','$tp','$us','$da')");
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

  <!-- ITEM MODAL -->
<div class="modal fade" id="items_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Item Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form method="POST"> 
                  <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" class="form-control" name="item_na" placeholder="Item Name">
                  </div>

                  <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" class="form-control" name="cat" placeholder="Category Name">
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" name="_date" value="<?php echo date("Y-m-d") ?>" readOnly>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="item_in" class="btn btn-success item_up">Insert</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>

              <?php
              if(isset($_POST['item_in'])){
                $ac = mysqli_real_escape_string($conn, $_POST['item_na']);
                $ca = mysqli_real_escape_string($conn, $_POST['cat']);
                $da = mysqli_real_escape_string($conn, $_POST['_date']);

                $edit = mysqli_query($conn, "CALL items_sp('','$ac','$ca','$da','insert')");
                $resss = mysqli_fetch_array($edit);
                if ($resss) {
                  $rew = explode("|", $resss[0])
                ?>
                <div class="btn btn-block btn-<?php echo $rew[0]  ?>">
                  <?php echo $rew[1] ?>                  
                </div>
                <?php  
                // echo $resss[0]; 
                }else{
                echo $conn->error;
                }
              }
              ?>
        </div>
    </div>
  </div>
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
  <?php require("library/script.php")?>



    <script>

    // Add item model
    $('.cl_item').click(function(e){
      e.preventDefault();
      $('#items_modal').modal('show');
    });





    $("body").delegate(".get_qty,.get_price","keyup",function(){
      var get_qty = $('.get_qty').val();
      var get_price = $('.get_price').val();

      var qty_price =  get_qty * get_price;

      var total = $('.total').val(qty_price);
    });
  </script>


</body>
</html>
