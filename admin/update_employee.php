<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Udpate Staff
if (isset($_POST['updateEmployee'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["code"]) || empty($_POST["name"]) || empty($_POST['email']) || empty($_POST['phone'])) {
    $err = "Blank values aren't accepted!";
  } else {
    $code = $_POST['code'];
    $uid = $_POST['u_id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $position = $_POST['position'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT) ?? $_POST['old_password'];
    $update = $_GET['update'];

    //Insert Captured information to a database table
    $postQuery = "CALL updateEmployeeDetail(?,?,?,?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssssssss', $uid, $name, $gender, $position, $phone, $dob, $email, $password, $update);
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
    $ret = "SELECT e.*, u.id AS u_id, u.email AS email, u.password AS password FROM employees e INNER JOIN users u ON e.u_id = u.id WHERE e.id = '$update'";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($emp = $res->fetch_object()) {
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
                      <input type="text" name="code" class="form-control" value="<?php echo $emp->id; ?>">
                      <input type="hidden" name="u_id" class="form-control" value="<?php echo $emp->u_id; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" value="<?php echo $emp->name; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Gender</label>
                      <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="gender" id="employee_gender">
                        <option value="Male" <?php echo ($emp->gender == "Male") ? 'selected' : null;  ?>>Male</option>
                        <option value="Female" <?php echo ($emp->gender == "Female") ? 'selected' : null;  ?>>Female</option>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Position</label>
                      <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="position" id="employee_position">
                        <?php
                        $stmt = $mysqli->prepare('SELECT * FROM positions');
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>
                          <option value="<?php echo $row->id; ?>" <?php echo ($emp->pos_id == $row->id) ? 'selected' : null; ?>><?php echo $row->name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" value="<?php echo $emp->email; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Date of Birth</label>
                      <input type="date" name="dob" class="form-control" value="<?php echo $emp->dob; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Phone</label>
                      <input type="phone" name="phone" class="form-control" value="<?php echo $emp->phone; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>New Password</label>
                      <input type="text" name="password" class="form-control" value="">
                      <input type="hidden" name="old_password" class="form-control" value="<?php echo $emp->password; ?>">
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