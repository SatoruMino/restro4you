<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Udpate Staff
if (isset($_POST['updateEmployee'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["employee_code"]) || empty($_POST["employee_name"]) || empty($_POST['employee_email']) || empty($_POST['employee_dob']) || empty($_POST['employee_phone'])) {
    $err = "Blank values aren't accepted!";
  } else {
    $employee_code = $_POST['employee_code'];
    $employee_name = $_POST['employee_name'];
    $employee_gender = $_POST['employee_gender'];
    $employee_position = $_POST['employee_position'];
    $employee_email = $_POST['employee_email'];
    $employee_dob = $_POST['employee_dob'];
    $employee_phone = $_POST['employee_phone'];
    $employee_address = $_POST['employee_password'] ?? $_POST['old_employee_password'];
    $update = $_GET['update'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE employees SET  id =?, name =?, gender =?, dob =?, pos_id =?, phone=?, address =?, email =? WHERE id =?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssssssi', $employee_code, $employee_name, $employee_gender, $employee_dob, $employee_position, $employee_phone, $employee_password, $employee_email, $update);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Employee Has Been Updated" && header("refresh:1; url=employees.php");
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
    $ret = "SELECT * FROM  employees WHERE id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($employee = $res->fetch_object()) {
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
                <h3>Edit Employee Information</h3>
              </div>
              <div class="card-body">
                <form method="POST">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Code</label>
                      <input type="text" name="employee_code" class="form-control" value="<?php echo $employee->id; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Name</label>
                      <input type="text" name="employee_name" class="form-control" value="<?php echo $employee->name; ?>">
                    </div>
                    <hr>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Gender</label>
                      <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="employee_gender" id="employee_gender">
                        <option value="Male" <?php echo ($employee->gender == "Male") ? 'selected' : null;  ?>>Male</option>
                        <option value="Female" <?php echo ($employee->gender == "Female") ? 'selected' : null;  ?>>Female</option>
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
                          <option value="<?php echo $row->id; ?>" <?php echo ($employee->pos_id == $row->id) ? 'selected' : null; ?>><?php echo $row->name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Email</label>
                      <input type="email" name="employee_email" class="form-control" value="<?php echo $employee->email; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Date of Birth</label>
                      <input type="date" name="employee_dob" class="form-control" value="<?php echo $employee->dob; ?>">
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Phone</label>
                      <input type="phone" name="employee_phone" class="form-control" value="<?php echo $employee->phone; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>New Password</label>
                      <input type="text" name="employee_password" class="form-control">
                      <input type="hidden" name="old_employee_password" class="form-control" value="<?php echo $employee->password; ?>">
                    </div>
                  </div>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="updateEmployee" value="Update Employee" class="btn btn-success" value="">
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