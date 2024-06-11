<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');
//Visit codeastro.com for more projects
check_login();
//Add Customer
if (isset($_POST['addCustomer'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["code"]) || empty($_POST["name"]) || empty($_POST['phone']) || empty($_POST['address'] || empty($_POST['email']) || empty($_POST['password']))) {
    $err = "Blank Values Not Accepted";
  } else {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $photo = $_FILES['photo']['name'];
    move_uploaded_file($_FILES["photo"]["tmp_name"], "assets/img/customers/" . $_FILES["photo"]["name"]);
    $address = $_POST['address'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO users (email, password, role) VALUES (?,?,'customer')";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ss', $email, $password);
    if ($postStmt->execute()) {
      $result = $mysqli->query("SELECT id FROM users WHERE email = '$email'");
      if ($result) {
        $row = $result->fetch_assoc();
        $u_id = $row['id'];
        $custmt = $mysqli->prepare('INSERT INTO customers(id, name, phone, address, photo, u_id) VALUE (?,?,?,?,?,?)');
        $custmt->bind_param('ssssss', $code, $name, $phone, $address, $photo, $u_id);
        if ($custmt->execute()) {
          $success = "Customer Has Been Added" && header("refresh:1; url=customers.php");
        } else {
          $err = "Please Try Again Or Try Later";
        }
      }
    }
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Customer Has Been Added" && header("refresh:1; url=customers.php");
    } else {
      $err = "Please Try Again Or Try Later";
    }
  }
}
//Visit codeastro.com for more projects
require_once('partials/_head.php');
?>

<body>
  <!-- For more projects: Visit codeastro.com  -->
  <!-- Sidenav -->
  <?php
  require_once('partials/_sidebar.php');
  ?>
  <!-- Main content -->
  <div class="main-content">
    <!-- Top navbar -->
    <?php
    require_once('partials/_topnav.php');
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
            </div><!-- For more projects: Visit codeastro.com  -->
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                    <input type="hidden" name="code" value="<?php echo $cus_id; ?>" class="form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Phone</label>
                    <input type="phone" name="phone" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Address</label>
                    <textarea name="address" class="form-control" value=""></textarea>
                  </div>

                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Photo</label>
                    <input type="file" name="photo" class="btn btn-outline-success form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Create Password</label>
                    <input type="password" name="password" class="form-control" value="">
                  </div>
                </div>
                <br><!-- For more projects: Visit codeastro.com  -->
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addCustomer" value="Add Customer" class="btn btn-success" value="">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer --><!-- For more projects: Visit codeastro.com  -->
      <?php
      require_once('partials/_footer.php');
      ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>