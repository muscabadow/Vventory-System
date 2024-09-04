<!-- ITEM MODAL -->
<div class="modal fade" id="items_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Item Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form method="POST"> 
                  <div class="form-group">
                    <div class="form-group">
                    <label>Item ID</label>
                    <input type="text" class="form-control" name="item_id" readonly="">
                  </div>
                    <label>Item Name</label>
                    <input type="text" class="form-control" name="item_na">
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="item_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>

              <?php
              require("library/conn.php");
                    if(isset($_POST['item_update'])){
                      $aid = mysqli_real_escape_string($conn, $_POST['item_id']);
                      $ac = mysqli_real_escape_string($conn, $_POST['item_na']);

                      $edit = mysqli_query($conn, "CALL items_sp('$aid','$ac','','update')");

                      $resss = mysqli_fetch_array($edit);

                      if ($resss) {
                        ?>

                        <h1 onshow="return confirm('<?php echo $resss[0] ?>');">  </h1>



                        <?php  
                        // echo $resss[0]; 
                      }else{
                        echo $conn->error;
                      }
                      
                    }
              ?>
        </div>
    </div>
  </div>
</div>
