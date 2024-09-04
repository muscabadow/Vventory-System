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
                <h3 class="card-title">Order Registration Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST">
                <div class="card-body">

                  <div class="form-group">
                    <label>Search Customer Or <i><a href="#" class="cl_item">add</a></i></label>
                    <input type="text" class="form-control get_text" placeholder="Search here...">

                    <ul style="list-style: none;" class="hide list-group">
                    </ul>

                    <input type="hidden" name="cust_id">                    
                  </div>

                  <div class="form-group">
                    <label>Select Store</label>
                    <select class="form-control get_store">
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
                    <label>Choose Item</label>
                    <select class="form-control ichange">
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
                    <select class="form-control itext" name="proid">
                      <option selected disabled>Select Item Type</option>
                      <option>Store iyo Item Soo dooro</option>
                                           
                    </select>
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

                  <input type="hidden" name="status" value="1">

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
                $pi = mysqli_real_escape_string($conn, @$_POST['proid']);
                $qt = mysqli_real_escape_string($conn, $_POST['qty']);                
                $pr = mysqli_real_escape_string($conn, $_POST['price']);
                $tp = mysqli_real_escape_string($conn, $_POST['total']);
                $us = mysqli_real_escape_string($conn, $_POST['user_id']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL orders_sp('$cu','$pi','$qt','$pr','$tp','$us','$da')");
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

<!-- CUSTOMER MODAL -->
<div class="modal fade" id="cust_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <form action="orders.php" method="POST"> 
                  <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" name="cname" placeholder="Customer Name">
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="text" class="form-control" name="ctell" placeholder="Customer Tell">
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="cadd" placeholder="Customer Address">
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
                  ?>
                  <div class="btn btn-block btn-<?php echo $rowss[0]?>">
                    <?php echo $rowss[1] ?>                    
                  </div>
                  <?php                   
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

    // Add customer model
    $('.cl_item').click(function(e){
      e.preventDefault();
      $('#cust_modal').modal('show');
    });


    // GET ITEM TYPE
    $(".ichange,.get_store").change(function(){
      var item = $(this).val();
      // alert(item);
      var store = $(".get_store").val();
      // alert(store);

      var data = "_item_id="+item+"&_store_id="+store;
      // alert(data);

      $.post("get_item_type.php",data,function(res){
        $(".itext").html(res);
      });
    });



    // SEARCH CUSTOMER 
    $(".get_text").keyup(function(){
      var text = $(this).val();
      var ul = $(this).next();
      // alert(text);

      ul.removeClass("hide");
      if(text == ''){
        ul.addClass("hide");
        return false;
      }

      var data = 'text='+text;
      $.post('search.php',data,function(res){
        ul.html(res);
      });
    });


    // CLICK LI GET TEXT AND ID
    $("body").delegate(".get_li","click",function(){
      var text_li = $(this).text();
      // alert(text_li);
      var id = $(this).val();
      // alert(id);

      $(this).parent().prev().val(text_li);
      $(this).parent().next().val(id);

      $(this).parent().addClass("hide");
    });


    // GET TOTAL PRICE
    $(".get_price,.get_qty").keyup(function(){
      var get_qty = $('.get_qty').val();
      var get_price = $('.get_price').val();

      $('.total').val(get_qty * get_price);
    });


  </script>


</body>
</html>


<style type="text/css">
  .hide{
    display: none;
  }
</style>