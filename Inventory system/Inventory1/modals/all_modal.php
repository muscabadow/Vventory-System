<!-- USER MODAL -->
<div class="modal fade" id="users_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Users Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="users_view.php" method="POST" enctype="multipart/form-data"> 
                  <div class="form-group">
                    <label>User ID</label>
                    <input type="text" class="form-control" name="user_ids" id="user_ids" placeholder="Username" readonly="">
                  </div>

                  <div class="form-group">
                    <label>Employee Name</label>
                    <input type="text" class="form-control" name="em_ids" id="empids" placeholder="Employee Name" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" name="users" id="users" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="text" class="form-control" name="passs" id="passs" placeholder="Password">
                  </div>
                  <div class="form-group">
                    <label>Gender</label>
                    <select class="form-control" name="genders" id="genders">
                      <option selected disabled>Select Gender</option>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name="img">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="statuss" id="statuss">
                      <option selected disabled>Select Status</option>
                      <option value="1">Active</option>
                      <option value="0">In Active</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>User Type</label>
                    <input type="text" class="form-control" name="user_types" id="user_types">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">What is your Secret Question?</label>
                    <select class="form-control" name="sec_que" id="sec_que" required="">
                      <option selected disabled="">Choose Your Secret Question?</option>
                      <option value="Waa maxay naa niistaada?">Waa maxay naa niistaada?</option>
                      <option value="Sheeg goobta aad ku dhalatay?">Sheeg goobta aad ku dhalatay?</option>
                      <option value="Maxaad u nooshahay?">Maxaad u nooshahay?</option>
                      <option value="Waa maxay dabeecadada?">Waa maxay dabeecadada?</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Secret Answer</label>
                    <input type="text" class="form-control" name="sec_ans" id="sec_ans" placeholder="Secret Answer">
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="user_dates" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="user_updates" class="btn btn-success">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>







<!-- EMPLOYEE MODAL -->
<div class="modal fade" id="emp_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Employee Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="employees_view.php" method="POST"> 
                  <div class="form-group">
                    <div class="form-group">
                    <label>Employee ID</label>
                    <input type="text" class="form-control" name="empl_id" id="empl_id" placeholder="Username" readonly="">
                  </div>
                    <label>Employee Name</label>
                    <input type="text" class="form-control" name="ename" id="ename" placeholder="Employee Name">
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="text" class="form-control" name="tell" id="tell" placeholder="Employee Tell">
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="add" id="add" placeholder="Employee Address">
                  </div>
                  <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email">
                  </div>

                  <div class="form-group">
                    <label>Choose Job Title</label>
                    <select class="form-control" name="jtitle" id="jtitle">
                      <option selected disabled="">Select Job Title</option>
                      <option value="Manager">Manager</option>
                      <option value="Cashier">Cashier</option>
                      <option value="Marketing">Marketing</option>
                      <option value="Cleaner">Cleaner</option>                      
                    </select>                    
                  </div>
                  <div class="form-group">
                    <label>Salary</label>
                    <input type="text" class="form-control" name="sal" id="sal" placeholder="Salary">
                  </div>
                  <div class="form-group">
                    <label>Choose Status</label>
                    <select class="form-control" name="em_st" id="em_st">
                      <option selected disabled="">Select Status</option>
                      <option value="1">On</option>
                      <option value="0">Off</option>                     
                    </select>                    
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="emp_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="emp_update" class="btn btn-success">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>







<!-- CUSTOMER MODAL -->
<div class="modal fade" id="cust_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Customer Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="cust_view.php" method="POST"> 
                  <div class="form-group">
                    <div class="form-group">
                    <label>Customer ID</label>
                    <input type="text" class="form-control" name="cus_id" id="cus_id" placeholder="Username" readonly="">
                  </div>
                    <label>Customer Name</label>
                    <input type="text" class="form-control" name="cname" id="cname">
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="text" class="form-control" name="ctell" id="ctell">
                  </div>
                  <div class="form-group">
                    <label>Address</label>
                    <input type="text" class="form-control" name="cadd" id="cadd">
                  </div>
                  <div class="form-group">
                    <label>Balance</label>
                    <input type="number" class="form-control" name="bal" id="bal">
                  </div>

                  <div class="form-group">
                    <label>User ID</label>
                    <input type="text" class="form-control" name="c_us_id" id="c_us_id" readonly>
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="cus_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="cus_update" class="btn btn-success">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>







<!-- ACCOUNT MODAL -->
<div class="modal fade" id="acc_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Account Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="acc_view.php" method="POST"> 
                  <div class="form-group">
                    <div class="form-group">
                    <label>Account ID</label>
                    <input type="text" class="form-control" name="acc_id" id="acc_id"readonly="">
                  </div>
                    <label>Account No</label>
                    <input type="text" class="form-control" name="acc_no" id="acc_no">
                  </div>
                  <div class="form-group">
                    <label>Bank Name</label>
                    <input type="text" class="form-control" name="bk" id="bk">
                  </div>
                  <div class="form-group">
                    <label>Balance</label>
                    <input type="number" class="form-control" name="acc_bal" id="acc_bal">
                  </div>

                  <div class="form-group">
                    <label>User ID</label>
                    <input type="number" class="form-control" name="a_us_id" id="a_us_id" readonly>
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="acc_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="acc_update" class="btn btn-success">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>







<!-- EXPENSE MODAL -->
<div class="modal fade" id="exp_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Expense Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="expenses_view.php" method="POST"> 
                  <div class="form-group">
                    <div class="form-group">
                    <label>Expense ID</label>
                    <input type="text" class="form-control" name="exp_id" id="exp_id"readonly="">
                  </div>
                    <label>Expense Name</label>
                    <input type="text" class="form-control" name="exp_na" id="exp_na">
                  </div>
                  <div class="form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" name="amo" id="amo">
                  </div>
                  <div class="form-group">
                    <label>Tell</label>
                    <input type="text" class="form-control" name="exp_tell" id="exp_tell">
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <input type="text" class="form-control" name="rea" id="rea">
                  </div>
                  <div class="form-group">
                    <label>User ID</label>
                    <input type="number" class="form-control" name="ex_us_id" id="ex_us_id" readonly>
                  </div>

                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="exp_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="exp_update" class="btn btn-success">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>








<!-- ITEM MODAL -->
<div class="modal fade" id="item_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <form action="item_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Item ID</label>
                    <input type="text" class="form-control" name="item_id" id="item_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" class="form-control" name="item_na" id="item_na">
                  </div>
                  <div class="form-group">
                    <label>Category Name</label>
                    <input type="text" class="form-control" name="cat" id="cat">
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="item_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="item_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>







<!-- STORE MODAL -->
<div class="modal fade" id="str_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Store Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="store_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Store ID</label>
                    <input type="text" class="form-control" name="store_id" id="store_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Store Name</label>
                    <input type="text" class="form-control" name="store_na" id="store_na">
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="store_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="store_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>






<!-- PRODUCTS MODAL -->
<div class="modal fade" id="pro_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Products Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="products_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Product ID</label>
                    <input type="text" class="form-control" name="pro_id" id="pro_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Purchase ID</label>
                    <input type="text" class="form-control" name="purch_id" id="purch_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Select Store</label>
                    <select class="form-control" name="p_str" id="p_str">
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
                    <select class="form-control" name="p_item_na" id="p_item_na">
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
                    <input type="text" class="form-control" name="itype" id="itype">
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control" name="qty" id="qty">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="form-control" name="price" id="price">
                  </div>
                  <div class="form-group">
                    <label>Total Price</label>
                    <input type="number" class="form-control" name="total" id="total" readonly="">
                  </div>
                  <div class="form-group">
                    <label>User ID</label>
                    <input type="number" class="form-control" name="p_us_id" id="p_us_id" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="pro_status" id="pro_status">
                      <option selected disabled>Select Status</option>
                      <option value="1">EXISTS</option>
                      <option value="0">END</option>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="pro_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="pro_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>




<!-- ORDER MODAL -->
<div class="modal fade" id="order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Order Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="orders_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Order ID</label>
                    <input type="text" class="form-control" name="order_id" id="order_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" name="o_cust" id="o_cust"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Product ID</label>
                    <input type="text" class="form-control" name="o_pro_id" id="o_pro_id" placeholder="Please Enter Product ID">
                  </div>
                  <div class="form-group">
                    <label>Item Name</label>
                    <input type="text" class="form-control" name="o_item_na" id="o_item_na" readonly>            
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control" name="o_qty" id="o_qty">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="form-control" name="o_price" id="o_price">
                  </div>
                  <div class="form-group">
                    <label>Total Price</label>
                    <input type="number" class="form-control" name="o_total" id="o_total" readonly="">
                  </div>
                  <div class="form-group">
                    <label>User ID</label>
                    <input type="number" class="form-control" name="o_us_id" id="o_us_id" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="o_sta" id="o_sta">
                      <option selected disabled>Select Status</option>
                      <option value="1">Ordered</option>
                      <option value="0">Canceled</option>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="o_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="o_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>




<!-- RECEIPT MODAL -->
<div class="modal fade" id="rec_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Receipt Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="receipt_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Receipt ID</label>
                    <input type="text" class="form-control" name="rec_id" id="rec_id" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Order ID</label>
                    <input type="text" class="form-control" name="or_id" id="or_id">
                  </div>
                  <div class="form-group">
                    <label>Customer Name</label>
                    <input type="text" class="form-control" name="r_cust" id="r_cust" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Current Amount</label>
                    <input type="text" class="form-control" name="r_amo" id="r_amo" readonly>
                  </div>
                  <div class="form-group">
                    <label>Paid</label>
                    <input type="text" class="form-control" name="paid" id="paid">
                  </div>
                  <div class="form-group">
                    <label>Remained</label>
                    <input type="text" class="form-control" name="rem" id="rem" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Discount</label>
                    <input type="text" class="form-control" name="dis" id="dis">
                  </div>
                  <div class="form-group">
                    <label>New Balance</label>
                    <input type="text" class="form-control" name="n_bal" id="n_bal" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Account/Phone Number</label>
                    <input type="text" class="form-control" name="acc_ph" id="acc_ph">
                  </div>
                  <div class="form-group">
                    <label>Sender</label>
                    <input type="text" class="form-control" name="send" id="send">
                  </div>
                  <div class="form-group">
                    <label>Ref#</label>
                    <input type="text" class="form-control" name="ref_no" id="ref_no" readonly="">
                  </div>
                  <div class="form-group">
                    <label>User ID</label>
                    <input type="number" class="form-control" name="r_us_id" id="r_us_id" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="r_sta" id="r_sta">
                      <option selected disabled>Select Status</option>
                      <option value="1">Recepted</option>
                      <option value="0">Canceled</option>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="r_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="r_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>









<!-- STORE OUT MODAL -->
<div class="modal fade" id="str_o_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Store Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="store_out_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Store Out ID</label>
                    <input type="text" class="form-control" name="store_out_id" id="store_out_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Order ID</label>
                    <input type="text" class="form-control" readonly name="o__id" id="o__id">
                  </div>
                  <div class="form-group">
                    <label>Product ID</label>
                    <input type="text" class="form-control" name="o_p_id" id="o_p_id">
                  </div>
                  <div class="form-group">
                    <label>Out Quantity</label>
                    <input type="text" class="form-control" name="out_qty" id="out_qty">
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="st_o_sta" id="st_o_sta">
                      <option selected disabled>Select Status</option>
                      <option value="1">Ordered</option>
                      <option value="0">Canceled</option>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="store_o_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="store_o_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>



<!-- SUPPLIER MODAL -->
<div class="modal fade" id="sup_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Supplier Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="supplier_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Supplier ID</label>
                    <input type="text" class="form-control" name="sup_id" id="sup_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Supplier Name</label>
                    <input type="text" class="form-control" name="sup_na" id="sup_na">
                  </div>
                  <div class="form-group">
                    <label>Supplier Location</label>
                    <input type="text" class="form-control" name="lo" id="lo">
                  </div>
                  <div class="form-group">
                    <label>Balance</label>
                    <input type="text" class="form-control" name="supp_bal" id="supp_bal">
                  </div>
                  <div class="form-group">
                    <label>User</label>
                    <input type="text" class="form-control" name="su_us_id" id="su_us_id">
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="sup_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="sup_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>







<!-- PURCHASE MODAL -->
<div class="modal fade" id="pur_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Purchase Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="purchase_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Purchase ID</label>
                    <input type="text" class="form-control" name="pur_id" id="pur_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Select Supplier</label>
                    <select class="form-control" name="supp_id" id="supp_id">
                      <option selected disabled>Choose Store</option>
                      <?php
                      $my_qu0 = mysqli_query($conn, "SELECT s.supplier_id,concat(s.name,' ',s.location) FROM supplier s");
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
                    <select class="form-control" name="pu_item_na" id="pu_item_na">
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
                    <input type="text" class="form-control" name="pu_itype" id="pu_itype">
                  </div>
                  <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" class="form-control" name="pu_qty" id="pu_qty">
                  </div>
                  <div class="form-group">
                    <label>Price</label>
                    <input type="number" class="form-control" name="pu_price" id="pu_price">
                  </div>
                  <div class="form-group">
                    <label>Total Price</label>
                    <input type="number" class="form-control" name="pu_total" id="pu_total" readonly="">
                  </div>
                  <div class="form-group">
                    <label>User ID</label>
                    <input type="number" class="form-control" name="pu_us_id" id="pu_us_id" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="pu_status" id="pu_status">
                      <option selected disabled>Select Status</option>
                      <option value="1">Purchase</option>
                      <option value="0">Canceled</option>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="pu_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="pu_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>








<!-- PAYMENTS MODAL -->
<div class="modal fade" id="pay_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Payments Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="payments_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Payment ID</label>
                    <input type="text" class="form-control" name="pay_id" id="pay_id" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Purchase ID</label>
                    <input type="text" class="form-control" name="pu_id" id="pu_id">
                  </div>
                  <div class="form-group">
                    <label>Supplier Name</label>
                    <select class="form-control" name="su_nam" id="su_nam">
                      <option selected disabled>Select Supplier</option>
                      <?php
                      $my_qu = mysqli_query($conn, "SELECT s.supplier_id,CONCAT(s.name,' ',s.location) FROM supplier s");
                      while ($roww = mysqli_fetch_array($my_qu)) {
                      ?>
                      <option value="<?php echo $roww[0] ?>"><?php echo $roww[1] ?></option>
                      <?php  
                      }
                      ?>                      
                    </select>                    
                  </div>
                  <div class="form-group">
                    <label>Current Amount</label>
                    <input type="text" class="form-control" name="ps_amo" id="pa_amo" readonly>
                  </div>
                  <div class="form-group">
                    <label>Paid</label>
                    <input type="text" class="form-control" name="pu_paid" id="pu_paid">
                  </div>
                  <div class="form-group">
                    <label>Discount</label>
                    <input type="text" class="form-control" name="pu_dis" id="pu_dis">
                  </div>
                  <div class="form-group">
                    <label>Balance</label>
                    <input type="text" class="form-control" id="pa_n_bal" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Account Sender</label>
                    <input type="text" class="form-control" name="pa_send" id="pa_send">
                  </div>
                  <div class="form-group">
                    <label>Receifer</label>
                    <input type="text" class="form-control" name="pa_acc_ph" id="pa_acc_ph">
                  </div>
                  <div class="form-group">
                    <label>User</label>
                    <input type="number" class="form-control" name="pa_r_us_id" id="pa_r_us_id" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Invoice</label>
                    <input type="text" class="form-control" name="pa_ref_no" id="pa_ref_no">
                  </div>
                  <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="pa_r_sta" id="pa_r_sta">
                      <option selected disabled>Select Status</option>
                      <option value="1">Payed</option>
                      <option value="0">Canceled</option>                      
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" id="pa_date" readonly="">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="pa_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>





<!-- SALARY PAYMENTS MODAL -->
<div class="modal fade" id="pay_sal_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Salary Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="pay_sal_view.php" method="POST"> 
                  <div class="form-group">
                    <label>Pay Sal ID</label>
                    <input type="text" class="form-control" name="ps_id" id="ps_id" readonly="">
                  </div>
                  <div class="form-group">
                    <label>Employee</label>
                    <select class="form-control" name="ps_emp_idd" id="ps_emp_idd">
                      <option selected disabled>Select Employee</option>
                      <?php
                      $pse = mysqli_query($conn, "SELECT e.emp_id,e.emp_name FROM employee e");
                      while ($psm = mysqli_fetch_array($pse)) {
                      ?>
                      <option value="<?php echo $psm[0]; ?>"><?php echo $psm[1]; ?></option>
                      <?php  
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Salary</label>
                    <input type="text" class="form-control" name="ps_sal" id="ps_sal" readonly>
                  </div>
                  <div class="form-group">
                    <label>Amount</label>
                    <input type="text" class="form-control" name="ps_amo" id="ps_amo">
                  </div>
                  <div class="form-group">
                    <label>Type</label>
                    <select class="form-control" name="ps_type" id="ps_type">
                      <option selected disabled>Select Type Of Money</option>
                      <option value="Salary">Salary</option>
                      <option value="Hormaris">Hormaris</option>                  
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Sender Acoount</label>
                    <input type="text" class="form-control" name="ps_acc" id="ps_acc">
                  </div>
                  <div class="form-group">
                    <label>Receifer</label>
                    <input type="text" class="form-control" name="ps_rec" id="ps_rec">
                  </div>
                  <div class="form-group">
                    <label>User</label>
                    <input type="number" class="form-control" name="ps_us_id" id="ps_us_id" readonly="">
                  </div>
                  <!-- <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="pa_r_sta" id="pa_r_sta">
                      <option selected disabled>Select Status</option>
                      <option value="1">Payed</option>
                      <option value="0">Canceled</option>                      
                    </select>
                  </div> -->
                  <div class="form-group">
                    <label>Register Date</label>
                    <input type="date" class="form-control" name="ps_date" id="ps_date" readonly>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="ps_update" class="btn btn-success item_up">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>














<!-- MENU MODAL -->
<div class="modal fade" id="menu_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Account Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="menu.php" method="POST"> 
                  <div class="form-group">
                    <div class="form-group">
                    <label>Menu ID</label>
                    <input type="text" class="form-control" name="me_id" id="me_id"readonly="">
                  </div>
                    <label>Menu Text</label>
                    <input type="text" class="form-control" name="me_text" id="me_text">
                  </div>
                  <div class="form-group">
                    <label>Menu Icon</label>
                    <input type="text" class="form-control" name="me_icon" id="me_icon">
                  </div>
                  <div class="form-group">
                    <label>Order By</label>
                    <input type="number" class="form-control" name="me_ord" id="me_ord">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="menu_update" class="btn btn-success">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>













<!-- SUB_MENU MODAL -->
<div class="modal fade" id="submenu_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Account Modal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <!-- form start -->
              <form action="sub_menu.php" method="POST"> 
                  <div class="form-group">
                    <label>SubMenu ID</label>
                    <input type="text" class="form-control" name="sme_id" id="sme_id"readonly="">
                  </div>
                  <div class="form-group">
                    <label>Menu Text</label>
                    <select class="form-control" name="sm_id" id="sm_id">
                      <option selected disabled>Choose One</option>
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
                    <label>SubMenu Text</label>
                    <input type="text" class="form-control" name="sme_text" id="sme_text">
                  </div>
                  <div class="form-group">
                    <label>SubMenu Url</label>
                    <input type="text" class="form-control" name="sme_url" id="sme_url">
                  </div>
                  <div class="form-group">
                    <label>Order By</label>
                    <input type="number" class="form-control" name="sme_ord" id="sme_ord">
                  </div>
                  <div class="modal-footer">
                    <button type="submit" name="submenu_update" class="btn btn-success">Update</button>
                    <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
              </form>
        </div>
    </div>
  </div>
</div>