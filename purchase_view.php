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
            <h1 class="m-0">Purchase View</h1>
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
                <h3 class="card-title">Purchase View</h3>

                <div class="row m-12">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                  <button type="button" class="btn btn btn-block btn-info far fa-edit" data-toggle="modal" data-target="#pur_reg_modal">
                    Add New Purchase
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
                    <th>Supplier</th>
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
                    if(isset($_POST['pu_update'])){
                      $pu = mysqli_real_escape_string($conn, $_POST['pur_id']);
                      $su = mysqli_real_escape_string($conn, $_POST['supp_id']);
                      $pt = mysqli_real_escape_string($conn, $_POST['pu_item_na']);
                      $put = mysqli_real_escape_string($conn, $_POST['pu_itype']);
                      $qy = mysqli_real_escape_string($conn, $_POST['pu_qty']);
                      $pe = mysqli_real_escape_string($conn, $_POST['pu_price']);
                      $st = mysqli_real_escape_string($conn, $_POST['pu_status']);
                      $to = $qy * $pe;

                      $edit = mysqli_query($conn, "CALL update_purchase_sp('$pu','$su','$pt','$put','$qy','$pe','$to','$st')");
                      echo "<script>alert('Updated Successfully')</script>"; 
                    }
                    ?>

                    <?php
                      if(isset($_GET['id'])){
                        $del = $_GET['id'];
                        $query = mysqli_query($conn, "DELETE FROM purchase WHERE purchase_id=$del");
                      }
                      ?>

                    <?php 
                    
                    $sql = mysqli_query($conn, "SELECT p.purchase_id,su.name,concat(i.item_name,' ',i.Category),p.item_type,p.qty,p.price,p.total_price,p.user_id,IF(p.status=0,'Canceled','Purchased'),p.RegDate FROM purchase p JOIN supplier su ON su.supplier_id=p.supplier_id JOIN items i ON i.item_id=p.item_id");

                    while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo $row[2] ?></td>
                        <td><?php echo $row[3] ?></td>
                        <td><?php echo $row[4] ?></td>
                        <td><?php echo '$'.$row[5] ?></td>
                        <td><?php echo '$'.$row[6] ?></td>
                        <td><?php echo $row[7] ?></td>
                        <td><?php echo $row[8] ?></td>
                        <td><?php echo $row[9] ?></td>

                        <td>
                          <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> -->
                          <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="purchase" alt="<?php echo $row[0] ?>"></button>
                        </td>
                        <td>
                          <a href="purchase_view.php?id=<?php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                          <a href="pur_data_print.php?id=<?php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                        </td>
                      </tr>

                    <?php  
                    }
                    ?>


                    <?php
              if(isset($_POST["btnreg"])){
                $su = mysqli_real_escape_string($conn, $_POST['supplier_id']);
                $sn = mysqli_real_escape_string($conn, $_POST['store_id']);
                $it = mysqli_real_escape_string($conn, $_POST['item_id']);
                $ty = mysqli_real_escape_string($conn, $_POST['puitype']);
                $qt = mysqli_real_escape_string($conn, $_POST['pu1_qty']);                
                $pr = mysqli_real_escape_string($conn, $_POST['pu1_price']);
                $tp = mysqli_real_escape_string($conn, $_POST['pu1_total']);
                $us = mysqli_real_escape_string($conn, $_POST['user_id']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL purchase_sp('$su','$sn','$it','$ty','$qt','$pr','$tp','$us','$da')");
                $ress = mysqli_fetch_array($insert);

                if($insert){
                  $e_row = explode("|", $ress[0]);
                  if ($e_row[0] = 'danger') {
                    echo "<script>alert('$e_row[1]'); window.location='purchase_view.php';</script>";
                  }else{
                    echo "<script>alert('$e_row[1]'); window.location='purchase_view.php';</script>";
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
                    <input type="text" class="form-control" required="" name="item_na" placeholder="Item Name">
                  </div>

                  <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" class="form-control" required="" name="cat" placeholder="Category Name">
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

                $edit1 = mysqli_query($conn, "CALL items_sp('','$ac','$ca','$da','insert')");
                $resss = mysqli_fetch_array($edit1);
                if ($resss) {
                  $e_row1 = explode("|", $ress[0]);
                  if ($e_row1[0] = 'danger') {
                    echo "<script>alert('$e_row1[1]')</script>";
                  }else{
                    echo "<script>alert('$e_row1[1]')</script>";
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


 <!-- SUPPLIER MODAL -->
<div class="modal fade" id="suppliers_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Supplier Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" class="form-control" required="" name="suu_id" placeholder="Supplier Name">
                  </div>
                  <div class="form-group">
                    <label>Location</label>
                    <input type="text" class="form-control" required="" name="loo" placeholder="Supplier Location">
                  </div>

                  <input type="hidden" name="uuser_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" name="datee" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="modal-footer">
                    <button type="submit" name="supp_in" class="btn btn-success item_up">Insert</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>

              <?php
              if(isset($_POST["supp_in"])){
                $su = mysqli_real_escape_string($conn, $_POST['suu_id']);
                $loo = mysqli_real_escape_string($conn, $_POST['loo']);
                $us = mysqli_real_escape_string($conn, $_POST['uuser_id']);
                $da = mysqli_real_escape_string($conn, $_POST['datee']);

                $insert = mysqli_query($conn, "CALL supplier_sp('$su','$loo','$us','$da')");
                $ress = mysqli_fetch_array($insert);

                if($ress){
                  $e_row = explode("|", $ress[0]);
                  if ($e_row[0] = 'danger') {
                    echo "<script>alert('$e_row[1]'); window.location='purchase_view.php';</script>";
                  }else{
                    echo "<script>alert('$e_row[1]'); window.location='purchase_view.php';</script>";
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

        $('#pur_id').val(sql[0]);
        $('#supp_id').val(sql[1]);
        $('#pu_item_na').val(sql[2]);
        $('#pu_itype').val(sql[3]);
        $('#pu_qty').val(sql[4]);
        $('#pu_price').val(sql[5]);
        $('#pu_total').val(sql[6]);
        $('#pu_us_id').val(sql[7]);
        $('#pu_status').val(sql[8]);
        $('#pu_date').val(sql[9]);

        $('#pur_modal').modal('show');
      });
    });


    // Add item model
    $('.cl_item').click(function(e){
      e.preventDefault();
      $('#items_modal').modal('show');
    });

    // Add supplier model
    $('.cl_supp').click(function(e){
      e.preventDefault();
      $('#suppliers_modal').modal('show');
    });


    $("body").delegate(".pu1_get_qty,.pu1_get_price","keyup",function(){
      var get_qty = $('.pu1_get_qty').val();
      var get_price = $('.pu1_get_price').val();

      var qty_price =  get_qty * get_price;

      var total = $('.pu1_total').val(qty_price);
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