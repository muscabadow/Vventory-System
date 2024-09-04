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
  <!-- <script>
  $("body").removeClass("dark-mode");
</script> -->
</head>
<body class="<?php echo $resq10[0] ?> hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class='preloader flex-column justify-content-center align-items-center'>
    <img class='animation__shake' src='dist/img/AdminLTELogo.png' alt='AdminLTELogo' height='60' width='60'>
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
            <h1 class="m-0">Userprivilege</h1>
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
                <h3 class="card-title">Userprivilege</h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">

                <form method="post">
                  <div class="form-group">
                    <div class="input-group input-group-lg">
                      <select name="user" class="form-control form-control-lg col-md-9" style="margin-left: 38px;" required="">
                        <option selected disabled>Choose User</option>
                        <?php
                        $query = mysqli_query($conn, "SELECT user_id,username FROM users WHERE type != 'Developer' ");
                        while ($ress = mysqli_fetch_array($query)) {
                          echo "<option value='$ress[0]'>$ress[1]</option>";
                        }
                        ?>
                      </select>
                      <button type="submit" name="btnreg" class="btn btn-lg btn-info col-md-2 mybtn">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>

                <table class="table table-striped table-sm">
                  <?php
                  if (isset($_POST['btnreg'])) {
                    // echo "<script>$('.preloader').css('visibility','initial');</script>";
                    $user_id = mysqli_real_escape_string($conn, @$_POST['user']);
                    if($user_id != ''){
                  ?>
                    <tr>
                      <th>Menu ID</th>
                      <th>Menu Text</th>
                      <th>Action</th>
                    </tr>

                    <?php
                    // DEVELOPER AREA STARTS HERE

                    if ($_SESSION['type'] == 'Developer') {

                      $menu_query = mysqli_query($conn, "SELECT * FROM menu");
                      while ($menu = mysqli_fetch_array($menu_query)) { // START DEVELOPER while menu
                        $sub_queery = mysqli_query($conn, "SELECT * FROM sub_menu WHERE menu_id=$menu[0]");
                      ?>
                        <tr>
                          <td><?php echo $menu[0] ?></td>
                          <td><?php echo "<i class='$menu[2]'></i> ".$menu[1] ?></td>
                          
                          <!-- START CHECKING DEVELOPER USER MENU -->
                          <?php 
                          $check_user_menu = mysqli_query($conn, "SELECT * FROM user_menu WHERE user_id=$user_id AND menu_id=$menu[0];");
                          if (mysqli_num_rows($check_user_menu) > 0) {
                          ?>
                            <td>
                              <a class="btn btn-warning remove_menu" id="remclick" href="remove_user_menu.php" menu_id="<?php echo $menu[0] ?>" user_id="<?php echo $user_id ?>">Remove User Privilege</a>
                            </td>
                          <?php
                          }else{
                          ?>
                            <td> <!-- onclick="adduser()"  onclick="remuser()" -->
                              <a class="btn btn-success add_menu" id="addclick" href="add_user_menu.php" menu_id="<?php echo $menu[0] ?>" user_id="<?php echo $user_id ?>">Add User Privilege</a>
                            </td>
                          <?php 
                          }
                          ?>
                          <!-- END CHECKING DEVELOPER USER MENU -->
                        </tr>

                        <!-- DEVELOPER SUB MENU STARTS HERE -->
                        <tr>
                          <td></td>
                          <td>
                            <table class="table">
                              <tr>
                                <th>Sub Menu ID</th>
                                <th>Sub Menu Text</th>
                                <th>Action</th>
                              </tr>
                              <?php
                              while ($sub = mysqli_fetch_array($sub_queery)) { // START while sub menu
                              ?>
                                <tr>
                                  <td><?php echo $sub[0] ?></td>
                                  <td><?php echo $sub[1] ?></td>
                                  <!-- START CHECKING DEVELOPER USER SUB_MENU -->
                                  <?php 
                                  $check_user_sub_menu = mysqli_query($conn, "SELECT * FROM user_sub_menu WHERE user_id=$user_id AND sub_menu_id=$sub[0];");
                                  if (mysqli_num_rows($check_user_sub_menu) > 0) {
                                  ?>
                                    <td>
                                      <a class="btn btn-warning remove_submenu" id="remSclick" href="remove_user_sub_menu.php" submenu_id="<?php echo $sub[0] ?>" user_id="<?php echo $user_id ?>">Remove User Privilege</a>
                                    </td>
                                  <?php
                                  }else{
                                  ?>
                                    <td>
                                      <a class="btn btn-success add_submenu" id="addSclick" href="add_user_sub_menu.php" submenu_id="<?php echo $sub[0] ?>" user_id="<?php echo $user_id ?>">Add User Privilege</a>
                                    </td>
                                  <?php 
                                  }
                                  ?>
                                  <!-- END CHECKING DEVELOPER USER SUB_MENU -->
                                </tr>
                              <?php 
                              }// END DEVELOPER while sub menu
                              ?>
                            </table>
                          </td>
                        </tr>
                        <!-- DEVELOPER SUB MENU ENDS HERE -->

                      <?php
                        }// END DEVELOPER while menu

                    // DEVELOPER AREA ENDS HERE


                    }else{

                    // ADMINS AREA STARTS HERE
                      $menu_query = mysqli_query($conn, "SELECT * FROM menu WHERE id != 6");
                      while ($menu = mysqli_fetch_array($menu_query)) { // START while menu
                        $sub_queery = mysqli_query($conn, "SELECT * FROM sub_menu WHERE menu_id=$menu[0]");
                      ?>
                        <tr>
                          <td><?php echo $menu[0] ?></td>
                          <td><?php echo "<i class='$menu[2]'></i> ".$menu[1] ?></td>
                          
                          <!-- START CHECKING ADMINS USER MENU -->
                          <?php 
                          $check_user_menu = mysqli_query($conn, "SELECT * FROM user_menu WHERE user_id=$user_id AND menu_id=$menu[0];");
                          if (mysqli_num_rows($check_user_menu) > 0) {
                          ?>
                            <td>
                              <a class="btn btn-warning remove_menu" id="remclick" href="remove_user_menu.php" menu_id="<?php echo $menu[0] ?>" user_id="<?php echo $user_id ?>">Remove User Privilege</a>
                            </td>
                          <?php
                          }else{
                          ?>
                            <td>
                              <a class="btn btn-success add_menu" id="addclick" href="add_user_menu.php" menu_id="<?php echo $menu[0] ?>" user_id="<?php echo $user_id ?>">Add User Privilege</a>
                            </td>
                          <?php 
                          }
                          ?>
                          <!-- END CHECKING ADMINS USER MENU -->
                        </tr>

                        <!-- ADMINS SUB MENU STARTS HERE -->
                        <tr>
                          <td></td>
                          <td>
                            <table class="table">
                              <tr>
                                <th>Sub Menu ID</th>
                                <th>Sub Menu Text</th>
                                <th>Action</th>
                              </tr>
                              <?php
                              while ($sub = mysqli_fetch_array($sub_queery)) { // START while sub menu
                              ?>
                                <tr>
                                  <td><?php echo $sub[0] ?></td>
                                  <td><?php echo $sub[1] ?></td>
                                  <!-- START CHECKING ADMINS USER SUB_MENU -->
                                  <?php 
                                  $check_user_sub_menu = mysqli_query($conn, "SELECT * FROM user_sub_menu WHERE user_id=$user_id AND sub_menu_id=$sub[0];");
                                  if (mysqli_num_rows($check_user_sub_menu) > 0) {
                                  ?>
                                    <td>
                                      <a class="btn btn-warning remove_submenu" id="remSclick" href="remove_user_sub_menu.php" submenu_id="<?php echo $sub[0] ?>" user_id="<?php echo $user_id ?>">Remove User Privilege</a>
                                    </td>
                                  <?php
                                  }else{
                                  ?>
                                    <td>
                                      <a class="btn btn-success add_submenu" id="addSclick" href="add_user_sub_menu.php" submenu_id="<?php echo $sub[0] ?>" user_id="<?php echo $user_id ?>">Add User Privilege</a>
                                    </td>
                                  <?php 
                                  }
                                  ?>
                                  <!-- END CHECKING ADMINS USER SUB_MENU -->
                                </tr>
                              <?php 
                              }// END while ADMINS sub menu
                              ?>
                            </table>
                          </td>
                        </tr>
                        <!-- ADMINS SUB MENU ENDS HERE -->

                      <?php
                        }// END ADMINS while menu

                    // ADMINS AREA ENDS HERE
                    }

                    }else{
                      echo "<script>alert('Fadlan dooro user')</script>";
                    }
                  }// END if isset 
                  ?>
                </table>

              </div>
              <!-- /.card-body -->
            </div>
        <!-- /.row -->
        <!-- Main row -->
        
        
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
    // ADD USER MENU
    $(".add_menu").click(function(e){
      e.preventDefault();
      
      var url = $(this).attr("href");
      var menu_id = $(this).attr("menu_id");
      var user_id = $(this).attr("user_id");
      var data = "menu_id="+menu_id+"&user_id="+user_id;
      // alert(data);
      $.post(url,data,function(){
        
      });
      // FIRST CLICK OR ADD MENU
      var aclass = $("#remclick").attr("class");
      var ahref = $("#remclick").attr("href");
      var atext = $("#remclick").text();

      // SECOND CLICK OR REMOVE MENU
      var aclasss = $(this).attr("class");
      var ahreff =  $(this).attr("href");
      var atextt =  $(this).text();
      // alert(aclasss);

      if (ahreff == "add_user_menu.php"){
        $(this).attr("class",aclass);
        $(this).attr("href",ahref);
        $(this).text(atext);
      }
      if (ahreff == "remove_user_menu.php") {
        $(this).attr("class","btn btn-success add_menu");
        $(this).attr("href","add_user_menu.php");
        $(this).text("Add User Privilege");
      }

    });





    // REMOVE USER MENU
    $(".remove_menu").click(function(e){
      e.preventDefault();
      
      var url = $(this).attr("href");
      var menu_id = $(this).attr("menu_id");
      var user_id = $(this).attr("user_id");
      var data = "menu_id="+menu_id+"&user_id="+user_id;
      // alert(url);
      $.post(url,data,function(){

      });
      // FIRST CLICK OR ADD MENU
      var aclass = $("#addclick").attr("class");
      var ahref = $("#addclick").attr("href");
      var atext = $("#addclick").text();

      // SECOND CLICK OR REMOVE MENU
      var aclasss = $(this).attr("class");
      var ahreff =  $(this).attr("href");
      var atextt =  $(this).text();
      // alert(aclasss);

      if (ahreff == "remove_user_menu.php") {
        $(this).attr("class",aclass);
        $(this).attr("href",ahref);
        $(this).text(atext);
      }
      if (ahreff == "add_user_menu.php"){
        $(this).attr("class","btn btn-warning remove_menu");
        $(this).attr("href","remove_user_menu.php");
        $(this).text("Remove User Privilege");
      }

    });





    // ADD USER SUBMENU
    $(".add_submenu").click(function(e){
      e.preventDefault();
      
      var url = $(this).attr("href");
      var submenu_id = $(this).attr("submenu_id");
      var user_id = $(this).attr("user_id");
      var data = "submenu_id="+submenu_id+"&user_id="+user_id;
      // alert(url);
      $.post(url,data,function(){
        // $(".remove_menu").html().show();
      });
      // FIRST CLICK OR ADD MENU
      var aclass = $("#remSclick").attr("class");
      var ahref = $("#remSclick").attr("href");
      var atext = $("#remSclick").text();

      // SECOND CLICK OR REMOVE MENU
      var aclasss = $(this).attr("class");
      var ahreff =  $(this).attr("href");
      var atextt =  $(this).text();
      // alert(aclasss);

      if (ahreff == "add_user_sub_menu.php"){
        $(this).attr("class",aclass);
        $(this).attr("href",ahref);
        $(this).text(atext);
      }
      if (ahreff == "remove_user_sub_menu.php") {
        $(this).attr("class","btn btn-success add_submenu");
        $(this).attr("href","add_user_sub_menu.php");
        $(this).text("Add User Privilege");
      }

    });













    // REMOVE USER SUBMENU
    $(".remove_submenu").click(function(e){
      e.preventDefault();
      
      var url = $(this).attr("href");
      var submenu_id = $(this).attr("submenu_id");
      var user_id = $(this).attr("user_id");
      var data = "submenu_id="+submenu_id+"&user_id="+user_id;
      // alert(url);
      $.post(url,data,function(){

      });
      // FIRST CLICK OR ADD MENU
      var aclass = $("#addSclick").attr("class");
      var ahref = $("#addSclick").attr("href");
      var atext = $("#addSclick").text();

      // SECOND CLICK OR REMOVE MENU
      var aclasss = $(this).attr("class");
      var ahreff =  $(this).attr("href");
      var atextt =  $(this).text();
      // alert(aclasss);

      if (ahreff == "remove_user_sub_menu.php") {
        $(this).attr("class",aclass);
        $(this).attr("href",ahref);
        $(this).text(atext);
      }
      if (ahreff == "add_user_sub_menu.php"){
        $(this).attr("class","btn btn-warning remove_submenu");
        $(this).attr("href","remove_user_sub_menu.php");
        $(this).text("Remove User Privilege");
      }

    });
  </script>

</body>
</html>



<style type="text/css">
  .hide{
    display: none;
  }
</style>












<!--            <div class="form-group">
                  <button type="submit" style="margin-left: 80%; margin-bottom: -2%;" class="col-md-2 btn btn-info form-control-lg">Search</button>
                  <select class="form-control form-control-lg col-md-9" style="margin-left: 20px;">
                    <option selected disabled>Choose User</option>
                  </select>
                  <button type="submit" style="margin-left: 80%; margin-top: -69px;" class="col-md-2 btn btn-info form-control-lg">Search</button>
                </div> -->