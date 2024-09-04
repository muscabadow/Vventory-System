<!-- USER REGISTRATION Modal -->
<div id="users_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
          <form action="users_view.php" method="POST" enctype="multipart/form-data">
              <div class="form-group">
                <label for="exampleInputEmail1">Employee Name</label>
                <select class="form-control" name="empids" required="">
                  <option selected disabled="">Choose Employee</option>
                  <?php 
                  require("library/conn.php");
                  $sql = "SELECT e.emp_id,e.emp_name FROM employee e where e.emp_id != 0";
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
                  <input type="text" autocomplete="off" class="form-control" name="users" placeholder="Username" required="">
              </div>
              <div class="form-group">
                <label>Password</label>
                <div class="input-group mb-3">
                  <input type="password" autocomplete="off" id="password" class="form-control" name="passs" placeholder="Password" required="">
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-eye" id="e" onclick="show()"></span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label>Gender</label>
                <select class="form-control" name="gens">
                  <option selected disabled>Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">Image</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" name="imgs">
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                  <div class="input-group-append"> 
                    <span class="input-group-text">Upload</span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>User Type</label>
                <input type="text" autocomplete="off"class="form-control" name="user_types" placeholder="User Type">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">What is your Secret Question?</label>
                <select class="form-control" name="sec_que" required="">
                  <option selected disabled="">Choose Your Secret Question?</option>
                  <option value="Waa maxay naa niistaada?">Waa maxay naa niistaada?</option>
                  <option value="Sheeg goobta aad ku dhalatay?">Sheeg goobta aad ku dhalatay?</option>
                  <option value="Maxaad u nooshahay?">Maxaad u nooshahay?</option>
                  <option value="Waa maxay dabeecadada?">Waa maxay dabeecadada?</option>
                </select>
              </div>
              <div class="form-group">
                <label>Secret Answer</label>
                <input type="text" autocomplete="off" class="form-control" name="sec_ans" placeholder="Secret Answer">
              </div>
              <div class="form-group">
                <label>Register Date</label>
                <input type="date" autocomplete="off" class="form-control" name="dates" value="<?php echo date("Y-m-d")?>" readOnly="">
              </div>

              <div class="modal-footer">
                <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
              </div>
          </form>
      </div>
    </div>
    </div>
  </div>
</div>





<!-- EMPLOYEE REGISTRATION Modal -->
<div id="emp_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Employee Name</label>
                    <input type="text" class="form-control" autocomplete="off" name="ename" placeholder="Employee Name" required="">
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="text" class="form-control" autocomplete="off" name="tell" placeholder="Employee Tell" required="">
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" autocomplete="off" name="add" placeholder="Employee Address" required="">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" autocomplete="off" name="email" placeholder="Enter Email" required="">
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
                    <input type="number" autocomplete="off" class="form-control" name="sal" placeholder="Enter Salary" required="">
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>






<!-- CUSTOMER REGISTRATION Modal -->
<div id="cust_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer Name</label>
                    <input type="text" autocomplete="off" class="form-control" name="cname" placeholder="Customer Name" required="">
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="text" autocomplete="off" class="form-control" name="tell" placeholder="Customer Tell" required="">
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" autocomplete="off" class="form-control" name="add" placeholder="Customer Address" required="">
                  </div>
                  <div class="form-group">
                    <label>Balance</label>
                    <input type="number" autocomplete="off" class="form-control" name="bal" placeholder="0">
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>






<!-- ACCOUNTS REGISTRATION Modal -->
<div id="acc_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Accounts</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Account No</label>
                    <input type="text" autocomplete="off" class="form-control" name="acc" placeholder="Account No" required="">
                  </div>
                  <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" autocomplete="off" class="form-control" name="bk" placeholder="Bank Name" required="">
                  </div>
                  <div class="form-group">
                    <label>Balance</label>
                    <input type="number" autocomplete="off" class="form-control" name="bal" placeholder="">
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary mybtn">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>







<!-- EXPENSES REGISTRATION Modal -->
<div id="exp_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Expense</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Expense Name</label>
                    <select class="form-control echange" name="acc" required="">
                      <option selected disabled>Select Expense</option>
                      <option value="Koronto">Koronto</option>
                      <option value="Biyo">Biyo</option> 
                      <option value="Other">Other</option>                   
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Amount</label>
                    <input type="text" autocomplete="off" class="form-control" name="bk" placeholder="Amount" required="">
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="number" autocomplete="off" class="form-control" name="exp_tell" placeholder="Tell-ka Lacagta Loo Diray" required="">
                  </div>

                 <!--  <div class="form-group">
                    <label>US phone mask:</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                      </div>
                      <input type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                    </div>
                    /.input group
                  </div> -->

                  <div class="form-group" id="hide">
                    <label>Description</label>
                    <input type="text" autocomplete="off" class="form-control kushub" name="bal" id="des" placeholder="Description">
                  </div>
                  <div class="form-group hide" id="hide1">
                    <label>Description</label>
                    <select class="form-control" name="bal" id="des">
                      <option selected disabled>Choose One</option>
                      <option value="Becco">Becco</option>
                      <option value="Mogadisho">Mogadisho</option>
                    </select>
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>






<!-- ITEM REGISTRATION Modal -->
<div id="item_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Item</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" autocomplete="off" class="form-control" required="" name="item" placeholder="Item Name">
                  </div>
                  <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" autocomplete="off" class="form-control" required="" name="cat" placeholder="Category Name">
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>






<!-- SUPPLIER REGISTRATION Modal -->
<div id="supp_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Supplier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" autocomplete="off" class="form-control" name="su_id" placeholder="Supplier Name">
                  </div>
                  <div class="form-group">
                    <label>Location</label>
                    <input type="text" autocomplete="off" class="form-control" name="lo" placeholder="Supplier Location">
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>








<!-- STORE REGISTRATION Modal -->
<div id="store_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Store</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">

                  <div class="form-group">
                    <label>Store Name</label>
                    <input type="text" autocomplete="off" class="form-control" name="sname" placeholder="Store Name" required="">
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                  <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>






<!-- PRODUCTS REGISTRATION Modal -->
<!-- <div id="pro_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Products</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
              <form method="POST">
                <div class="card-body">

                  <input type="hidden" autocomplete="off" name="p_pur_id" value="0">
                  
                  <div class="form-group">
                    <label>Select Store</label>
                    <select class="form-control" name="store_id" required="">
                      <option selected disabled>Choose Store</option>
                      <php
                      $my_qu0 = mysqli_query($conn, "SELECT `store_id`, `store_name` FROM `store`");
                      while ($roww0 = mysqli_fetch_array($my_qu0)) {
                      ?>
                      <option value="<php echo $roww0[0] ?>"><php echo $roww0[1] ?></option>
                      <php  
                      }
                      ?>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Choose Item Or <i><a href="#" class="cl_item">add</a></i></label>
                    <select class="form-control" name="item_id">
                      <option selected disabled>Choose Item</option>
                      <php
                      $my_qu = mysqli_query($conn, "SELECT item_id,CONCAT(item_name,' ',Category) FROM items ORDER BY item_name");
                      while ($roww = mysqli_fetch_array($my_qu)) {
                      ?>
                      <option value="<php echo $roww[0] ?>"><php echo $roww[1] ?></option>
                      <php  
                      }
                      ?>                      
                    </select>                    
                  </div>
                  <div class="form-group">
                    <label>Item Type</label>
                    <input type="text" autocomplete="off" class="form-control" name="itype" placeholder="Item Type" required="">
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" autocomplete="off" class="form-control get_qty" name="p_qty" placeholder="Quantity" required="">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" autocomplete="off" class="form-control get_price" name="p_price" placeholder="1-ki xabo Lacagta oo kaa gadan yahay">
                  </div>
                  <div class="form-group">
                    <label>Total Price</label>
                    <input type="number" autocomplete="off" class="form-control total" name="total" placeholder="Total Price" readonly="">
                  </div>

                  <input type="hidden" autocomplete="off" name="pro_user_id" value="<php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="pro_date" value="<php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="pro_btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
               
              </form>
      </div>
    </div>
    </div>
  </div>
</div> -->






<!-- STORE OUT REGISTRATION Modal -->
<!-- <div id="str_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Store Out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       
              <form method="POST">
                <div class="card-body">
                  
                  <input type="hidden" autocomplete="off" name="order_id" value="0">
                  
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product ID</label>
                    <input type="text" autocomplete="off" class="form-control" name="pro_id" placeholder="Enter Product ID" required="">
                  </div>
                  <div class="form-group">
                    <label>Out Quantity</label>
                    <input type="text" autocomplete="off" class="form-control" name="ou_qty" placeholder="Enter Inta laga gatay" required="">
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
               
              </form>
      </div>
    </div>
    </div>
  </div>
</div> -->






<!-- ORDER REGISTRATION Modal -->
<div id="order_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">

                  <!-- <div class="form-group">
                    <label>Search Customer Or <i><a href="#" class="cl_item">add</a></i></label>
                    <input type="text" autocomplete="off" class="form-control get_text" placeholder="Search Customer Name Or Tell here...">

                    <ul style="list-style: none;" class="list-group">
                    </ul>

                    <input type="hidden" autocomplete="off" name="cust_id">                    
                  </div> -->

                  <div class="form-group">
                    <label>Search Customer Or <i><a href="#" class="cl_item">add</a></i></label>
                    <select class="form-control select2" name="cust_id" style="width: 100%;">
                      <option selected="selected" disabled>Choose Customer</option>
                      <?php
                      $sel = mysqli_query($conn, "SELECT c.cust_id,CONCAT(c.cust_name,' ',c.tell) FROM customers c");
                      while($er = mysqli_fetch_array($sel)){
                        echo "<option value='$er[0]'>$er[1]</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Select Store</label>
                    <select class="form-control get_store">
                      <option selected disabled>Choose Store</option>
                      <?php
                      $my_qu0 = mysqli_query($conn, "SELECT `store_id`, `store_name` FROM `store`");
                      while ($roww0 = mysqli_fetch_array($my_qu0)) {
                      ?>
                      <option value="<?php echo $roww0[0] ?>"><?php echo $roww0[1] ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Choose Item</label>
                    <select class="form-control ichange">
                      <option selected disabled>Choose Item</option>
                      <?php
                      $my_qu = mysqli_query($conn, "SELECT item_id,CONCAT(item_name,' ',Category) FROM items ORDER BY item_name");
                      while ($roww = mysqli_fetch_array($my_qu)) {
                      ?>
                      <option value="<?php echo $roww[0] ?>"><?php echo $roww[1] ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>                    
                  </div>

                  <div class="form-group">
                    <label>Item Type</label>
                    <select class="form-control itext" name="proid">
                      <!-- <option selected disabled>Select Item Type</option> -->
                      <option selected disabled>Store iyo Item Soo dooro</option>
                                           
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Item Quantity In The Store</label>
                    <input type="text" autocomplete="off" class="form-control i_o_get_qty" placeholder="Item-ka lasoo doortay inta xabo aad ka heyso" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Item Price Per Quantity</label>
                    <input type="number" autocomplete="off" class="form-control i_o_get_price" placeholder="Item-ka lasoo doortay cost-ga aad kusoo gadatay" readonly="">
                  </div>

                  <div class="form-group">
                    <label>Order Quantity</label>
                    <input type="number" autocomplete="off" class="form-control o_get_qty" name="o_qty" placeholder="Inta xabo uu karabo customerka" required="">
                  </div>
                  <div class="form-group">
                    <label>Order Price</label>
                    <input type="number" autocomplete="off" class="form-control o_get_price" name="o_price" placeholder="1-ki xabo Lacagta aad ka siineyso">
                  </div>
                  <div class="form-group">
                    <label>Total Price</label>
                    <input type="number" autocomplete="off" class="form-control o_total" name="o_total" placeholder="Total Price-ka laga rabo customerka" readonly="">
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <input type="hidden" autocomplete="off" name="status" value="1">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>







<!-- RECEIPT REGISTRATION Modal -->
<div id="rec_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Receipt</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">

                  <div class="form-group">
                    <label>Order ID</label>
                    <input type="text" autocomplete="off" class="form-control get_order" action="receipt" name="order_id" placeholder="Enter Order ID" required="">
                  </div>

                  <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" autocomplete="off" class="form-control get_text" placeholder="Customer Name" readonly> 
                    <input type="hidden" autocomplete="off" name="cust_id" class="get_id">                 
                  </div>
                  <div class="form-group">
                    <label>Current Amount</label>
                    <input type="text" autocomplete="off" class="form-control my_text" name="current" placeholder="Current Amount" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Paid</label>
                    <input type="text" autocomplete="off" class="form-control get_paid" name="paid" placeholder="Paid Money" required="">
                  </div>
                  <div class="form-group">
                    <label>Remained</label>
                    <input type="text" autocomplete="off" class="form-control remain" name="remained" placeholder="Remained" readonly>
                  </div>
                  <div class="form-group">
                    <label>Discount</label>
                    <input type="text" autocomplete="off" class="form-control discount" name="dis" placeholder="Discount">
                  </div>
                  <div class="form-group">
                    <label>New Balance</label>
                    <input type="text" autocomplete="off" class="form-control new_balance" name="new_bal" placeholder="New Balance" readonly>
                  </div>
                  <div class="form-group">
                    <label>Account / Phone Number</label>
                    <input type="text" autocomplete="off" class="form-control" name="acc" placeholder="Loo Diraha"required="">
                  </div>
                  <div class="form-group">
                    <label>Send Number</label>
                    <input type="number" autocomplete="off" class="form-control xadid" name="tell" placeholder="Diraha sida 61XXXXXXX Or Account" required="">
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>





<!-- PURCHASE REGISTRATION Modal -->
<div id="pur_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Purchase</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Select Supplier Or <i><a href="#" class="cl_supp">add</a></i></label>
                    <select class="form-control" name="supplier_id">
                      <option selected disabled>Choose Supplier</option>
                      <?php 
                      $my_qu0 = mysqli_query($conn, "SELECT supplier_id,name FROM supplier");
                      while ($roww0 = mysqli_fetch_array($my_qu0)) {
                      ?>
                      <option value="<?php echo $roww0[0] ?>"><?php echo $roww0[1] ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select Store</label>
                    <select class="form-control" name="store_id" required="">
                      <option selected disabled>Choose Store</option>
                      <?php
                      $my_qu0 = mysqli_query($conn, "SELECT `store_id`, `store_name` FROM `store`");
                      while ($roww0 = mysqli_fetch_array($my_qu0)) {
                      ?>
                      <option value="<?php echo $roww0[0] ?>"><?php echo $roww0[1] ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Choose Item Or <i><a href="#" class="cl_item">add</a></i></label>
                    <select class="form-control" name="item_id">
                      <option selected disabled>Choose Item</option>
                      <?php
                      $my_qu = mysqli_query($conn, "SELECT item_id,CONCAT(item_name,' ',Category) FROM items ORDER BY item_name");
                      while ($roww = mysqli_fetch_array($my_qu)) {
                      ?>
                      <option value="<?php echo $roww[0] ?>"><?php echo $roww[1] ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>                    
                  </div>
                  <div class="form-group">
                    <label>Item Type</label>
                    <input type="text" autocomplete="off" class="form-control" name="puitype" placeholder="Item Type" required="">
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" autocomplete="off" class="form-control pu1_get_qty" name="pu1_qty" placeholder="Quantity" required="">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" autocomplete="off" class="form-control pu1_get_price" name="pu1_price" placeholder="1-ki xabo Lacagta oo kaa gadan yahay">
                  </div>
                  <div class="form-group">
                    <label>Total Price</label>
                    <input type="number" autocomplete="off" class="form-control pu1_total" name="pu1_total" placeholder="Total Price" readonly="">
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>





<!-- PURCHASE PAYMENT REGISTRATION Modal -->
<div id="pu_pa_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Purchase Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Purchase ID</label>
                    <input type="text" autocomplete="off" class="form-control pa_get_order" action="purchase" name="pur_id" placeholder="Enter Purchase ID" required>
                  </div>

                  <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" autocomplete="off" class="form-control pa_get_text" placeholder="Supplier Name" readonly> 
                    <input type="hidden" autocomplete="off" name="supp_id" class="pa_get_id">                 
                  </div>
                  <div class="form-group">
                    <label>Current Amount</label>
                    <input type="text" autocomplete="off" class="form-control pa_my_text" name="pa_current" placeholder="Current Amount" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Paid</label>
                    <input type="text" autocomplete="off" class="form-control pa_get_paid" name="pa_paid" placeholder="Paid Money" required="">
                  </div>
                  <div class="form-group">
                    <label>Discount</label>
                    <input type="text" autocomplete="off" class="form-control pa_get_dis" name="pa_dis" placeholder="Discount" required="">
                  </div>
                    <input type="hidden" autocomplete="off" class="pa_get_remain" name="pa_remain">
                  <div class="form-group">
                    <label>New Balance</label>
                    <input type="text" autocomplete="off" class="form-control pa_new_balance" name="pa_new_bal" placeholder="New Balance" readonly>
                  </div>
                  <div class="form-group">
                    <label>Sender</label>
                    <select class="form-control" name="pa_sen">
                      <option selected disabled>Select Account Sender</option>
                      <?php
                      $sen = mysqli_query($conn, "SELECT a.acc_id,concat(a.account_no,' ',a.bank_name) FROM accounts a");
                      while ($esn = mysqli_fetch_array($sen)) {
                      ?>
                      <option value="<?php echo $esn[0]; ?>"><?php echo $esn[1]; ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Receifer</label>
                    <input type="text" autocomplete="off" class="form-control" name="pa_rec" placeholder="Loo Diraha"required="">
                  </div>
                  <div class="form-group">
                    <label>Invoice No</label>
                    <input type="text" autocomplete="off" class="form-control" name="pa_ref_no" placeholder="Invoice No"required="">
                  </div>

                  <input type="hidden" autocomplete="off" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="date" value="<?php echo date("Y-m-d")?>" readOnly="">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>











<!-- SALARY PAYMENT REGISTRATION Modal -->
<div id="pay_sal_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Salary Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Employee</label>
                    <select class="form-control get_emp" name="ps_emp_id">
                      <option selected disabled>Select Employee</option>
                      <?php
                      $emp = mysqli_query($conn, "SELECT e.emp_id,e.emp_name FROM employee e where e.emp_id != 0");
                      while ($emps = mysqli_fetch_array($emp)) {
                      ?>
                      <option value="<?php echo $emps[0]; ?>"><?php echo $emps[1]; ?></option>
                      <?php  
                      }
                      ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Type</label>
                    <select class="form-control get_type" name="ps_type">
                      <option selected disabled>Select Type Of Money</option>
                      <option value="Salary">Salary</option>
                      <option value="Hormaris">Hormaris</option>                   
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Salary Amount</label>
                    <input type="text" autocomplete="off" class="form-control ps_amo" name="ps_sal" placeholder="Salary Amount" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Amount</label>
                    <input type="text" autocomplete="off" class="form-control cc" name="ps_amo" placeholder="Paid Amount">
                  </div>
                  <div class="form-group">
                    <label>Sender Account</label>
                    <select class="form-control" name="ps_acc_id">
                      <option selected disabled>Select Sender Accounts</option>
                      <?php
                      $acc = mysqli_query($conn, "SELECT a.acc_id,concat(a.account_no,' ',a.bank_name) FROM accounts a");
                      while ($accc = mysqli_fetch_array($acc)) {
                      ?>
                      <option value="<?php echo $accc[0]; ?>"><?php echo $accc[1]; ?></option>
                      <?php  
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Receifer</label>
                    <input type="text" autocomplete="off" class="form-control" name="ps_rece" placeholder="Enter Loo diraha">
                  </div>
                  
                  <input type="hidden" autocomplete="off" name="ps_user_id" value="<?php echo $_SESSION['user_id'] ?>">

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" autocomplete="off" class="form-control" name="ps_date" value="<?php echo date("Y-m-d")?>">
                  </div>

                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>













<!-- DEVELOPER -->
<!-- MENUES REGISTRATION Modal -->
<div id="menu_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Menues</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Menu Text</label>
                    <input type="text" autocomplete="off" class="form-control" name="me_text" placeholder="Menu Text" required="">
                  </div>
                  <div class="form-group">
                    <label>Menu Icon</label>
                    <input type="text" autocomplete="off" class="form-control" name="me_icon" placeholder="Menu Icon" required="">
                  </div>
                  <div class="form-group">
                    <label>Order By</label>
                    <?php
                    $mq = mysqli_query($conn, "SELECT COUNT(m.order_by)+1 FROM menu m");
                    $mr = mysqli_fetch_array($mq);
                    ?>
                    <input type="number" autocomplete="off" class="form-control" value="<?php echo $mr[0] ?>" name="me_order" placeholder="Order By" required="">
                  </div>
                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary mybtn">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>

















<!-- SUB_MENUES REGISTRATION Modal -->
<div id="submenu_reg_modal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div style="margin: auto;" class="col-md-11">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New SubMenues</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- form start -->
              <form method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label>Menues</label>
                    <select class="form-control" name="m_id" id="m_id">
                      <option selected disabled>Select Menu</option>
                      <?php
                      $sm = mysqli_query($conn, "SELECT m.id,m.text FROM menu m");
                      while ($smm = mysqli_fetch_array($sm)) {
                      ?>
                      <option value="<?php echo $smm[0]; ?>"><?php echo $smm[1]; ?></option>
                      <?php  
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">SubMenu Text</label>
                    <input type="text" autocomplete="off" class="form-control" name="sme_text" placeholder="SubMenu Text" required="">
                  </div>
                  <div class="form-group">
                    <label>SubMenu Url</label>
                    <input type="text" autocomplete="off" class="form-control" name="sme_url" placeholder="SubMenu Url" required="">
                  </div>
                  <div class="form-group">
                    <label>Order By</label>
                    <?php
                    $smq = mysqli_query($conn, "SELECT COUNT(s.order_by)+1 FROM sub_menu s");
                    $smr = mysqli_fetch_array($smq);
                    ?>
                    <input type="number" autocomplete="off" class="form-control" value="<?php echo $smr[0] ?>" name="sme_order" placeholder="Order By" required="">
                  </div>
                  <div class="card-footer">
                    <button type="submit" name="btnreg" class="btn btn-block btn-primary mybtn">Save</button>
                  </div>

                </div>
                <!-- /.card-body -->
              </form>
      </div>
    </div>
    </div>
  </div>
</div>

