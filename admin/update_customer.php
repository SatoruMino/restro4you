<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add Customer
if (isset($_POST['updateCustomer'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["name"]) || empty($_POST['phone']) || empty($_POST['address'] || empty($_POST['email']))) {
    $err = "Blank Values Not Accepted";
  } else {
    $uid = $_POST['u_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $photo = $_FILES['photo']['name'];
    $old_photo = $_POST['old_photo'];
    if ($customer_photo) {
      move_uploaded_file($_FILES["photo"]["tmp_name"], "assets/img/customers/" . $_FILES["photo"]["name"]);
    } else {
      $customer_photo = $old_photo;
    }
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); //Hash This 
    $update = $_GET['update'];

    //Insert Captured information to a database table
    $postQuery = "CALL updateCustomerDetail(?,?,?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssssss', $uid, $name, $phone, $address, $photo, $email, $password, $update);
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
    $ret = "SELECT c.*, u.email AS email, u.password AS password FROM customers c INNER JOIN users u ON c.u_id = u.id WHERE c.id = '$update'";
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
                      <input type="text" name="name" class="form-control" value="<?php echo $cust->name; ?>">
                      <input type="hidden" name="u_id" class="form-control" value="<?php echo $cust->u_id; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" value="<?php echo $cust->email; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Phone</label>
                      <input type="phone" name="phone" class="form-control" value="<?php echo $cust->phone; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Address</label>
                      <textarea name="address" class="form-control" value=""><?php echo $cust->address; ?></textarea>
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Photo</label>
                      <input type="file" name="photo" class="btn btn-outline-success form-control" value="">
                      <input type="hidden" name="old_photo" value="<?php echo $cust->photo; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Create Password</label>
                      <input type="password" name="password" class="form-control" value="">
                      <input type="hidden" name="old_password" class="form-control" value="<?php echo $cust->password; ?>">
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