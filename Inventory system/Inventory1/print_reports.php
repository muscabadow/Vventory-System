<?php
require("library/conn.php");
require("library/function.php");

//THEMES
$rq10 = mysqli_query($conn, "SELECT * FROM `theme` LIMIT 1");
$resq10 = mysqli_fetch_array($rq10);

extract($_GET);
$runQuery = mysqli_query($conn, "CALL print_reports('$action','$id','$id1','$id2','$id3','$id4')");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require("library/head.php")?>
</head>
<body class="<?php echo $resq10[0] ?> hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <!-- <div class="row"> -->
    <div class="container-fluid">
      <h4 class="text-center display-4 mt-5"><?php echo $action ?></h4>

      <!-- <div class="row"> -->
        <div class="col-md-11 offset-md-1">
          <div class="col-11">
            <!-- <php echo $action,$id,$id1,$id2; ?> -->
            <table class="table table-bordered table-striped mt-4">
              <?php table_row($runQuery); ?>
            </table>
          </div>
        </div>
      <!-- </div> -->

    </div>
  <!-- </div> -->

</div>
<!-- ./wrapper -->
</body>
</html>