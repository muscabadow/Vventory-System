<?php
require("library/conn.php");
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
                <h3 class="card-title">Employee Registration Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Employee Name</label>
                    <input type="text" class="form-control" name="ename" placeholder="Employee Name" required="">
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="text" class="form-control" name="tell" placeholder="Employee Tell" required="">
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="add" placeholder="Employee Address" required="">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter Email" required="">
                  </div>

                  <div class="form-group">
                    <label>Choose Job Title</label>
                    <select class="form-control" name="jtitle" required="">
                      <option selected disabled="">Select Job Title</option>
                      <option value="Manager">Manager</option>
                      <option value="Cashier">Cashier</option>
                      <option value="Marketing">Marketing</option>
                      <option value="Cleaner">Cleaner</option>                      
                    </select>                    
                  </div>

                  <div class="form-group">
                    <label>Salary</label>
                    <input type="number" class="form-control" name="sal" placeholder="Enter Salary" required="">
                  </div>

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
                $en = mysqli_real_escape_string($conn, $_POST['ename']);
                $te = mysqli_real_escape_string($conn, $_POST['tell']);
                $ad = mysqli_real_escape_string($conn, $_POST['add']);
                $em = mysqli_real_escape_string($conn, $_POST['email']);
                $jt = mysqli_real_escape_string($conn, $_POST['jtitle']);
                $sa = mysqli_real_escape_string($conn, $_POST['sal']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $insert = mysqli_query($conn, "CALL employee_sp('$en','$te','$ad','$em','$jt','$sa','$da')");
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
