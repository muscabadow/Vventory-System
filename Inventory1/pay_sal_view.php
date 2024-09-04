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
            <h1 class="m-0">Salary Payment View</h1>
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
                <h3 class="card-title">Salary Payment View</h3>

              <div class="row m-12">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                  <button type="button" class="btn btn btn-block btn-info far fa-edit" data-toggle="modal" data-target="#pay_sal_reg_modal">
                    Add New Salary
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
                    <th>Employee</th>
                    <th>Salary</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Sender Account</th>
                    <th>Receifer</th>
                    <th>User</th>
                    <th>Date</th>

                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    if(isset($_POST['ps_update'])){
                      $pid = mysqli_real_escape_string($conn, $_POST['ps_id']);
                      $pu = mysqli_real_escape_string($conn, $_POST['ps_emp_idd']);
                      $ps = mysqli_real_escape_string($conn, $_POST['ps_sal']);
                      $po = mysqli_real_escape_string($conn, $_POST['ps_amo']);
                      $su = mysqli_real_escape_string($conn, $_POST['ps_type']);
                      $ca = mysqli_real_escape_string($conn, $_POST['ps_acc']);
                      $pw = mysqli_real_escape_string($conn, $_POST['ps_rec']);
                      $pa = mysqli_real_escape_string($conn, $_POST['ps_date']);

                      $edit = mysqli_query($conn, "UPDATE `pay_salary` SET `emp_id`='$pu', `salary`='$ps',`amount`='$po',`type`='$su',`acc_id`='$ca',`receifer`='$pw',`date`='$pa' WHERE `pay_sal_id`='$pid'");
                      echo "<script>alert('Updated Successfully')</script>";
                    }
                    ?>

                    <?php
                      if(isset($_GET['id'])){
                        $del = $_GET['id'];
                        $query = mysqli_query($conn, "DELETE FROM pay_salary WHERE pay_sal_id=$del");
                      }
                      ?>

                    <?php 
                    
                    $sql = mysqli_query($conn, "SELECT `pay_sal_id`, e.emp_name, p.salary, `amount`, `type`, a.account_no, `receifer`, p.user_id, `date` FROM pay_salary p JOIN employee e ON e.emp_id=p.emp_id JOIN accounts a ON a.acc_id=p.acc_id");

                    while($row = mysqli_fetch_array($sql)){
                      ?>
                      <tr>
                        <td><?php echo $row[0] ?></td>
                        <td><?php echo $row[1] ?></td>
                        <td><?php echo "$$row[2]" ?></td>
                        <td><?php echo "$$row[3]" ?></td>
                        <td><?php echo $row[4] ?></td>
                        <td><?php echo $row[5] ?></td>
                        <td><?php echo $row[6] ?></td>
                        <td><?php echo $row[7] ?></td>
                        <td><?php echo $row[8] ?></td>

                        <td>
                          <!-- <a href="#" class="btn btn-success btn-sm"><i class="fa fa-edit"></i></a> -->
                            <button type="submit" class="btn btn-success btn-sm fa fa-edit get_edit" action="pay_sal" alt="<?php echo $row[0] ?>"></button>
                        </td>
                        <td>
                          <a href="pay_sal_view.php?id=<?php echo $row[0]?>" onclick="return confirm('Mahubtaa inaad tirtirto xogtaan !!');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                        <td>
                          <a href="pay_data_print.php?id=<?php echo $row[0] ?>" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></a>
                        </td>
                      </tr>

                    <?php  
                    }
                    ?>

                    <?php
              if(isset($_POST["btnreg"])){
                $ep = mysqli_real_escape_string($conn, @$_POST['ps_emp_id']);
                $pq = mysqli_real_escape_string($conn, $_POST['ps_sal']);
                $pm = mysqli_real_escape_string($conn, @$_POST['ps_amo']);
                $pt = mysqli_real_escape_string($conn, @$_POST['ps_type']);
                $pd = mysqli_real_escape_string($conn, @$_POST['ps_acc_id']);
                $dp = mysqli_real_escape_string($conn, @$_POST['ps_rece']);
                $pe = mysqli_real_escape_string($conn, $_POST['ps_user_id']);
                $da = mysqli_real_escape_string($conn, $_POST['ps_date']);

                $insert = mysqli_query($conn, "CALL pay_salary_sp('$ep','$pq','$pm','$pt','$pd','$dp','$pe','$da');");
                $ress = mysqli_fetch_array($insert);

                if($insert){
                  $e_row = explode("|", $ress[0]);
                  if ($e_row[0] = 'danger') {
                    echo "<script>alert('$e_row[1]'); window.location='pay_sal_view.php';</script>";
                  }else{
                    echo "<script>alert('$e_row[1]'); window.location='pay_sal_view.php';</script>";
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

        $('#ps_id').val(sql[0]);
        $('#ps_emp_idd').val(sql[1]);
        $('#ps_sal').val(sql[2]);
        $('#ps_amo').val(sql[3]);
        $('#ps_type').val(sql[4]);
        $('#ps_acc').val(sql[5]);
        $('#ps_rec').val(sql[6]);
        $('#ps_us_id').val(sql[7]);
        $('#ps_date').val(sql[8]);

        $('#pay_sal_modal').modal('show');
      });
    });


    // GET EMPLOYEE SALARY
    $('.get_emp').change(function(){
      var emp = $(this).val();
      var action = 'employee';

      var data = 'id='+emp+'&action='+action;
      // alert(data);
      $.post('get/get_curren_amount.php',data,function(res){
          // var sql = res.split(',');
          $('.ps_amo').val(res);
      });
    });

    // GET EMPLOYEE SALARY
    $('.get_type').change(function(){
      var type = $(this).val();
      var em = $('.get_emp').val();
      var action = 'emp';

      var data = 'id='+em+'&action='+action;
      $.post('get/get_curren_amount.php',data,function(res){          
          if (type == 'Salary') {
            $('.cc').val(res);
          }else{
            $('.cc').val('');
          }
      });
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