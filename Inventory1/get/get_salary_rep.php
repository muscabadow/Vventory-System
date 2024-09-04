<?php
require("../library/conn.php");
require("../library/function.php");

session_start();

if (empty($_SESSION['emp_name'])) {
  header("location: ../index.php");
  return false;
}

extract(@$_POST);

$query = mysqli_query($conn, "CALL salary_report_sp('$emp','$month','$year')");

if (mysqli_num_rows($query) > 0) {
?>
    <a href="print_reports.php?id=<?php echo $emp; ?> &&action=Salary Report &&id1=<?php echo $month; ?> &&id2=<?php echo $year; ?> &&id3= &&id4=" target="_blank" class="btn btn-info col-2" style="margin-left: 83%; margin-bottom: 5px;">Print Report</a>
	<div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped mt-3 table-sm">
                <?php table_row($query) ?>
            </table>
        </div>        
    </div>

<?php 
}else {
	echo "<h3 class='text-danger text-center mt-3'>No Data Found</h3>";
}
?>