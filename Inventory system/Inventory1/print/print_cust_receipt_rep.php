<?php 

require("../library/conn.php");
extract($_GET);

$sql = mysqli_query($conn, "CALL cust_receipt_report_sp('$id','$id1')");
$ress = mysqli_fetch_array($sql);

?>

<div class="print">
  <center><img src="../images/Kaamil.jpg" style="width: 20%;"><br>+252619630031/+252683299011</center>
  <center></center>
  <table>
    <tr>
      <th>Customer Id</th>
      <td>1</td>
    </tr>
    <tr>
      <th>Customer Name</th>
      <td>Cali</td>
    </tr>
    <tr>
      <th>Customer Tell</th>
      <td>+252617488879</td>
    </tr>
    <tr>
      <th>Customer Address</th>
      <td>Fagax</td>
    </tr>
    <tr>
      <th>Customer Age</th>
      <td>22</td>
    </tr>
  </table>  
</div>



<style type="text/css">
  .print{
    width: 90%;
    margin: auto;
    border: solid 1px;
  }
  table{
    border: solid 1px;
    border-collapse: collapse;
    width: 100%;
  }
  td,th{
    border: solid 1px;
    text-underline-position: auto;
  }
</style>