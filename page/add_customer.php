<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');
//Visit codeastro.com for more projects
check_login();
diss_allow_role(["customer", "stocker", "chef"]);
//Add Customer
if (isset($_POST['addCustomer'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["code"]) || empty($_POST["name"]) || empty($_POST['phone']) || empty($_POST['address'] || empty($_POST['email']) || empty($_POST['password']))) {
    $err = "Blank Values Not Accepted";
  } else {
    $code = $_POST['code'];
    $uid = 'user_' . $uniqueId;
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $photo = $_FILES['photo'];
    if ($photo) {
      move_uploaded_file($photo["tmp_name"], "assets/img/users/" . $photo["name"]);
    }
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $postQuery = "INSERT INTO users (id, email, password, role) VALUES (?,?,?,'customer')";
    $postStmt = $mysqli->prepare($postQuery);
    $rc = $postStmt->bind_param('sss', $uid, $email, $password);
    //declare a varible which will be passed to alert function
    if ($postStmt->execute()) {
      $addStmt = $mysqli->prepare('INSERT INTO customers(id, name, gender, phone , dob, address, photo , u_id) VALUE (?,?,?,?,?,?,?,?)');
      $addStmt->bind_param('ssssssss', $code, $name, $gender, $phone, $dob, $address, $photo['name'], $uid);
      if ($addStmt->execute()) {
        $success = "Customer Has Been Added" && header("refresh:1; url=customers.php");
      } else {
        $err = "Please Try Again Or Try Later";
      }
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
              <h3>Please Fill Customers Fields</h3>
            </div><!-- For more projects: Visit codeastro.com  -->
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="col-md-6 px-5">
                  <img style="height: 175px; width: 175px; object-fit:cover;" src="" id="user_photo" name="user_photo" class="rounded-circle border border-2 border-dark">
                </div>
                <input type="hidden" name="code" class="form-control" value="<?php echo 'cust_' . $uniqueId; ?>">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Gender</label>
                    <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="gender" id="gender">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>

                  <hr>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Date of Birth</label>
                    <input type="date" name="dob" class="form-control" value="">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Phone</label>
                    <input type="phone" name="phone" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Create Password</label>
                    <input type="password" name="password" class="form-control" value="">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Photo</label>
                    <input type="file" name="photo" id="input-photo" class="btn btn-outline-success form-control">
                  </div>
                  <div class="col-md-6">
                    <label>Address</label>
                    <textarea name="address" class="form-control"></textarea>
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
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('input-photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function(e) {
            const img = document.getElementById('user_photo');
            img.src = e.target.result;
          };
          reader.readAsDataURL(file);
        } else {
          alert('Please select a valid image file.');
        }
      });
    });
  </script>
</body>

</html>