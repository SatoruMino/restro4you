<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add Staff
if (isset($_POST['addEmployee'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["code"]) || empty($_POST["name"]) || empty($_POST['email']) || empty($_POST['dob']) || empty($_POST['phone']) || empty($_POST['password'])) {
    $err = "Blank Values Can't Be Accepted";
  } else {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO users (email, password, role) VALUES (?,?,'employee')";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ss', $email, $password);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $result = $mysqli->query("SELECT id FROM users WHERE email = '$email'");
      if ($result) {
        $row = $result->fetch_assoc();
        $u_id = $row['id'];
        $empStmt = $mysqli->prepare('INSERT INTO employees(id, name, gender, pos_id, dob, phone, u_id) VALUE (?,?,?,?,?,?,?)');
        $empStmt->bind_param('sssssss', $code, $name, $gender, $position, $dob, $phone, $u_id);
        if ($empStmt->execute()) {
          $success = "Customer Has Been Added" && header("refresh:1; url=employees.php");
        } else {
          $err = "Please Try Again Or Try Later";
        }
      }
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
              <form method="POST">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control" value="<?php echo $alpha; ?>-<?php echo $beta; ?>">
                  </div>
                  <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" value="">
                  </div>
                  <hr>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Gender</label>
                    <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="gender" id="gender">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>Position</label>
                    <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="position" id="position">
                      <?php
                      $stmt = $mysqli->prepare('SELECT * FROM positions');
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($row = $res->fetch_object()) {
                      ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
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
                    <input type="text" name="password" class="form-control" value="">
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="addEmployee" value="Add Employee" class="btn btn-success" value="">
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
      ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>

</html>