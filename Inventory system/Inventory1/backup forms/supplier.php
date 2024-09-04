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
                <h3 class="card-title">Item Registration Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" class="form-control" name="su_id" placeholder="Supplier Name">
                  </div>
                  <div class="form-group">
                    <label>Location</label>
                    <input type="text" class="form-control" name="lo" placeholder="Supplier Location">
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
                $su = mysqli_real_escape_string($conn, $_POST['su_id']);
                $lo = mysqli_real_escape_string($conn, $_POST['lo']);
                $us = mysqli_real_escape_string($conn, $_POST['user_id']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL supplier_sp('$su','$lo','$us','$da')");
                $ress = mysqli_fetch_array($insert);

                if($ress){
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
</body>
</html>
