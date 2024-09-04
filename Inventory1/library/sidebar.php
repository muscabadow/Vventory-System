<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #143655">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">INVENTORY SYSTEM</span>
    </a>
    <?php 
    if ($_SESSION['image'] == 'images/') {
      $rrr = 'images/Cu-logo.jpg';
    }else{
      $rrr = $_SESSION['image'];
    }
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img style="height: 50px; width: 55px" src="<?php echo $rrr; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info mt-2">
          <a href="#" class="d-block" style="color: white;"><?php echo $_SESSION['emp_name']; ?></a>
          <a href="#" class="d-block" style="font-size: 11.7px;"><?php echo $_SESSION['type']; ?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" style="background-color: #143655" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar" style="background-color: #143655">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <!-- Admin,Purchase,Store,Transactions and Reports area starts here -->
          <?php
          require("library/conn.php");


          // DEVELOPER AREA STARTS HERE
          if ($_SESSION['type'] == 'Developer') {
            $query = mysqli_query($conn, "SELECT m.id,m.text,m.icon FROM menu m ORDER BY m.order_by");
            while ($menu = mysqli_fetch_array($query)) {
            ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon <?php echo $menu['icon']; ?>"></i>
                <p>
                  <?php echo $menu['text']; ?>
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <?php
                $sql1 = mysqli_query($conn, "SELECT s.text`sub_text`,s.url`sub_url`,s.menu_id FROM sub_menu s WHERE s.menu_id=$menu[id] ORDER BY s.order_by");
                while ($sub = mysqli_fetch_array($sql1)) {
                  // if($menu['id'] == $sub['menu_id']){
                ?>
                <li class="nav-item">
                  <a href="<?php echo $sub['sub_url'] ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo $sub['sub_text']; ?></p>
                  </a>
                </li>
                <?php 
                  // }
                }
                ?>

              </ul>
            </li>
            <?php 
            }
            // DEVELOPER AREA ENDS HERE



            // ADMINS AREA STARTS HERE
          }elseif ($_SESSION['type'] == 'Admin') {
            $query = mysqli_query($conn, "SELECT m.id,m.text,m.icon FROM menu m WHERE m.id != 6 ORDER BY m.order_by");
            while ($menu = mysqli_fetch_array($query)) {
            ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon <?php echo $menu['icon']; ?>"></i>
                <p>
                  <?php echo $menu['text']; ?>
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <?php
                $sql1 = mysqli_query($conn, "SELECT s.text`sub_text`,s.url`sub_url`,s.menu_id FROM sub_menu s WHERE s.menu_id=$menu[id] ORDER BY s.order_by");
                while ($sub = mysqli_fetch_array($sql1)) {
                  // if($menu['id'] == $sub['menu_id']){
                ?>
                <li class="nav-item">
                  <a href="<?php echo $sub['sub_url'] ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo $sub['sub_text']; ?></p>
                  </a>
                </li>
                <?php 
                  // }
                }
                ?>

              </ul>
            </li>
            <?php 
            }
            // ADMINS AREA ENDS HERE



            // USERS AREA STARTS HERE
          }else{
            $query = mysqli_query($conn, "SELECT m.id,m.text,m.icon FROM menu m JOIN user_menu um ON um.menu_id=m.id WHERE um.user_id=$_SESSION[user_id] ORDER BY m.order_by");
            while ($menu = mysqli_fetch_array($query)) {
            ?>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon <?php echo $menu['icon']; ?>"></i>
                <p>
                  <?php echo $menu['text']; ?>
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right"></span>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <?php
                $sql1 = mysqli_query($conn, "SELECT s.text`sub_text`,s.url`sub_url`,s.menu_id FROM sub_menu s JOIN user_sub_menu us ON us.sub_menu_id=s.id WHERE us.user_id=$_SESSION[user_id] AND s.menu_id=$menu[id] ORDER BY s.order_by");
                while ($sub = mysqli_fetch_array($sql1)) {
                  // if($menu['id'] == $sub['menu_id']){
                ?>
                <li class="nav-item">
                  <a href="<?php echo $sub['sub_url'] ?>" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p><?php echo $sub['sub_text']; ?></p>
                  </a>
                </li>
                <?php 
                  // }
                }
                ?>

              </ul>
            </li>
            <?php 
            }
          }
          // USERS AREA ENDS HERE


          ?>
          <!-- Admin,Purchase,Store,Transactions and Reports area Ends here -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>























  <!-- #454d55 dark gray color-->