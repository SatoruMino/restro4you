<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add Staff
if (isset($_POST['addEmployee'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["employee_code"]) || empty($_POST["employee_name"]) || empty($_POST['employee_email']) || empty($_POST['employee_dob']) || empty($_POST['employee_phone']) || empty($_POST['employee_address'])) {
    $err = "Blank Values Can't Be Accepted";
  } else {
    $employee_code = $_POST['employee_code'];
    $employee_name = $_POST['employee_name'];
    $employee_gender = $_POST['employee_gender'];
    $employee_position = $_POST['employee_position'];
    $employee_email = $_POST['employee_email'];
    $employee_dob = $_POST['employee_dob'];
    $employee_phone = $_POST['employee_phone'];
    $employee_address = $_POST['employee_address'];

    //Insert Captured information to a database table
    $postQuery = "INSERT INTO employees (id, name, gender, dob, pos_id, phone, address, email) VALUES(?,?,?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssssss', $employee_code, $employee_name, $employee_gender, $employee_dob, $employee_position, $employee_phone, $employee_address, $employee_email);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Employee Has Been Added" && header("refresh:1; url=employee.php");
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
                    <input type="text" name="employee_code" class="form-control" value="<?php echo $alpha; ?>-<?php echo $beta; ?>">
                  </div>
                  <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="employee_name" class="form-control" value="">
                  </div>
                  <hr>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Gender</label>
                    <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="employee_gender" id="employee_gender">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>Position</label>
                    <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="employee_position" id="employee_position">
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
                    <input type="email" name="employee_email" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Date of Birth</label>
                    <input type="date" name="employee_dob" class="form-control" value="">
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Phone</label>
                    <input type="phone" name="employee_phone" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Address</label>
                    <textarea type="date" name="employee_address" class="form-control"></textarea>
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