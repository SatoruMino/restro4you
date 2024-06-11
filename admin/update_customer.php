<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add Customer
if (isset($_POST['updateCustomer'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["customer_phone"]) || empty($_POST["customer_name"]) || empty($_POST['customer_email']) || empty($_POST['customer_password']) || empty($_POST['customer_address'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $customer_email = $_POST['customer_email'];
    $customer_address = $_POST['customer_address'];
    $customer_photo = $_FILES['customer_photo']['name'];
    $old_customer_photo = $_POST['old_customer_photo'];
    if ($customer_photo) {
      move_uploaded_file($_FILES["customer_photo"]["tmp_name"], "assets/img/customers/" . $_FILES["customer_photo"]["name"]);
    } else {
      $customer_photo = $old_customer_photo;
    }
    $customer_password = password_hash($_POST['customer_password'], PASSWORD_DEFAULT); //Hash This 
    $update = $_GET['update'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE customers SET name =?, phone =?,  address =?, photo =?, password =?, email =? WHERE  id =?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssssss', $customer_name, $customer_phone, $customer_address, $customer_photo, $customer_password, $customer_email, $update);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Customer Has Been Updated" && header("refresh:1; url=customers.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
require_once('partials/_head.php');
?>

<body>
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
    $update = $_GET['update'];
    $ret = "SELECT * FROM  customers WHERE id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($cust = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div style="background-image: url(assets/img/theme/restro00.jpg); background-size: cover;" class="header  pb-8 pt-5 pt-md-8">
        <span class="mask bg-gradient-dark opacity-8"></span>
        <div class="container-fluid">
          <div class="header-body">
          </div>
        </div>
      </div>
      <!-- Page content -->
      <div class="container-fluid mt--8">
        <!-- Table -->
        <div class="row">
          <div class="col">
            <div class="card shadow">
              <div class="card-header border-0">
                <h3>Please Fill All Fields</h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Name</label>
                      <input type="text" name="customer_name" class="form-control" value="<?php echo $cust->name; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Email</label>
                      <input type="email" name="customer_email" class="form-control" value="<?php echo $cust->email; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Phone</label>
                      <input type="phone" name="customer_phone" class="form-control" value="<?php echo $cust->phone; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Address</label>
                      <textarea name="customer_address" class="form-control" value=""><?php echo $cust->address; ?></textarea>
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Photo</label>
                      <input type="file" name="customer_photo" class="btn btn-outline-success form-control" value="">
                      <input type="hidden" name="old_customer_photo" value="<?php echo $cust->photo; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Create Password</label>
                      <input type="password" name="customer_password" class="form-control" value="">
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="updateCustomer" value="Update Customer" class="btn btn-success" value="">
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Footer -->
      <?php
      require_once('partials/_footer.php');
    }
      ?>
      </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>