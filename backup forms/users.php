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
                <h3 class="card-title">User Registration Form</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Employee Name</label>
                    <select class="form-control" name="empid" required="">
                      <option selected disabled="">Choose Employee</option>
                      <?php 
                      require("library/conn.php");
                      $sql = "SELECT emp_id,emp_name FROM employee";
                      $ress = $conn->query($sql);
                      while ($row = $ress->fetch_array()) {
                      ?>
               <option value="<?php echo $row[0] ?>"><?php echo $row[1] ?></option>
                      <?php  
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="user" placeholder="Username" required="">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="pass" placeholder="Password" required="">
                  </div>
                  <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="gen">
                      <option selected disabled>Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="img" required>
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="form-control btn btn-block btn-primary">Save</button>
                </div>

                </div>
                <!-- /.card-body -->
              </form>

              <?php
              if(isset($_POST["btnreg"])){
                $ei = mysqli_real_escape_string($conn, @$_POST['empid']);
                $us = mysqli_real_escape_string($conn, $_POST['user']);
                $pa = mysqli_real_escape_string($conn, $_POST['pass']);
                $ge = mysqli_real_escape_string($conn, @$_POST['gen']);
                $da = mysqli_real_escape_string($conn, $_POST['date']);

                $path = "images/";
                $img_name = $path . $_FILES['img']['name'];

                $insert = mysqli_query($conn, "CALL users_sp('$ei','$us','$pa','$ge','$img_name','$da')");
                $ress = mysqli_fetch_array($insert);

                if($ress){
                  $msg = explode("|", $ress[0]);
                  move_uploaded_file($_FILES['img']['tmp_name'], $img_name);
                ?>
                                  
                  <div class="btn btn-block btn-<?php echo $msg[0] ?>">
                    <?php echo $msg[1] ?>
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
