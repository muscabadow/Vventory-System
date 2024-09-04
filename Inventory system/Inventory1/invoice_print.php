<?php

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: index.php");
  return false;
}

require("library/conn.php");
extract(@$_GET);

$query = mysqli_query($conn, "SELECT o.order_id`Order NO`,c.cust_name`Name`,r.send_number,r.account_id,concat(i.item_name,' ',i.Category)`Item`,p.item_type`Item Type`,o.qty`Quantity`,o.price`Price`,r.current_amount`Total`,SUM(r.paid)`Paid`,SUM(r.discount)`Discount`,r.current_amount - (SUM(r.paid)+SUM(r.discount))`Balance`,r.ref_no FROM customers c
    JOIN orders o ON o.cust_id=c.cust_id 
    JOIN receipt r ON r.order_id=o.order_id
    JOIN products p ON p.pro_id=o.pro_id
    JOIN items i ON i.item_id=p.item_id
    WHERE r.order_id = $order AND r.status=1 GROUP BY o.order_id;");
$ress = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require("library/head.php"); ?>
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <!-- <section class="invoice"> -->
    <!-- title row -->
    <div class="row">
      <div class="col-12">
        <h5 class="page-header">
          <!-- <i class="fas fa-globe"></i> -->
          <center><img src="images/Cu-logo.jpg" style="width: 20%"><!--  KAAMIL SYSTEM. --></center>
          <center><h4><b>9630031/3353556/7488879</b></h4></center>
        </h5>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div >
        <h6 style="margin-left: 20px;">
          <p style="font-size: 15px;"><b>Name: <?php echo $ress[1] ?></b> <br>
            <i class="fas fa-phone"></i> Mobile: 0<?php echo $ress[2] ?>
          </p>
        </h6>
      </div>
      <div  style="margin-left: 68%;">
          <b>Invoice #<?php echo $ress[12] ?></b><br>
          <b>Account:</b> <?php echo $ress[3] ?>
      </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-12 table-responsive">
        <table class="table table-striped">
          <thead>
          <tr>
            <th>Order No</th>
            <th>Product</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td><?php echo $ress[0] ?></td>
            <td><?php echo $ress[4] ?></td>
            <td><?php echo $ress[5] ?></td>
            <td><?php echo $ress[6] ?></td>
            <td><?php echo $ress[7] ?>.00</td>
          </tr>
          
          </tbody>
        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-6">
        <center style="font-size: 20px; margin-top: 13%;"><b>Signature: ___________________________________</b></center>
      </div>
      <!-- /.col -->
      <div class="col-6">
        <p class="lead">Payment Due <?php echo date("Y-m-d"); ?></p>

        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>$<?php echo $ress[8] ?>.00</td>
            </tr>
            <tr>
              <th>Paid:</th>
              <td>$<?php echo $ress[9] ?>.00</td>
            </tr>
            <tr>
              <th>Discount:</th>
              <td>$<?php echo $ress[10] ?>.00</td>
            </tr>
            <tr>
              <th>Balance:</th>
              <td>$<?php echo $ress[11] ?>.00</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <footer>
      <center style="font-size: 20px;" class="btn btn-block btn-dark"><b>FG: Alaab Lagatay Lama Celin Karo Lamana Badali Karo.</b></center>
    </footer>
    <!-- /.row -->
  <!-- </section> -->
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
