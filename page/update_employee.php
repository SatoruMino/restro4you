<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
diss_allow_role(["customer", "stocker", "chef", "cashier"]);
//Udpate Staff
if (isset($_POST['updateEmployee'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["code"]) || empty($_POST["name"]) || empty($_POST['email']) || empty($_POST['phone'])) {
    $err = "Blank values aren't accepted!";
  } else {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $pos_id = $_POST['pos_id'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $photo = $_FILES['photo']['name'];
    if ($photo) {
      // Sanitize the filename
      $photo = basename($_FILES['photo']['name']);
      $target_path = "assets/img/users/" . $photo;

      // Move the uploaded file to the target directory
      move_uploaded_file($_FILES["photo"]["tmp_name"], $target_path);
    } else {
      $photo = $_POST['old_photo'];
    }
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT) ?? $_POST['old_password'];
    $update = $_GET['update'];
    //Insert Captured information to a database table
    $postQuery = " UPDATE employees e INNER JOIN users u ON e.u_id = u.id
                    SET e.name = ?,
                    e.gender = ?,
                    e.pos_id = ?,
                    e.phone = ?,
                    e.dob = ?,
                    u.email = ?,
                    u.password = ?,
                    e.photo = ?
                    WHERE e.id = ?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssssssss', $name, $gender, $pos_id, $phone, $dob, $email, $password, $photo, $update);
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
    $ret = "SELECT e.*, u.email AS email, u.password AS password FROM employees e INNER JOIN users u ON e.u_id = u.id WHERE e.id = '$update'";
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
                <form method="POST" enctype="multipart/form-data">
                  <div class="col-md-6 px-5">
                    <img style="height: 175px; width: 175px; object-fit:cover;" src="<?php echo ($emp->photo == null)  ? 'assets/img/theme/user-a-min.png' :  'assets/img/users/' . $emp->photo; ?>" id="user_photo" name="user_photo" class="rounded-circle border border-2 border-dark">
                  </div>
                  <div class="d-none">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control" value="<?php echo $emp->id; ?>">
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" value="<?php echo $emp->name; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Gender</label>
                      <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="gender" id="gender">
                        <option value="Male" <?php echo ($emp->gender == "Male") ? 'selected' : null;  ?>>Male</option>
                        <option value="Female" <?php echo ($emp->gender == "Female") ? 'selected' : null;  ?>>Female</option>
                      </select>
                    </div>

                    <hr>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Position</label>
                      <select class="form-control form-select-lg mb-3" aria-label="Large select example" name="pos_id" id="pos_id">
                        <?php
                        $stmt = $mysqli->prepare('SELECT * FROM positions');
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($row = $res->fetch_object()) {
                        ?>
                          <option value="<?php echo $row->id; ?>" <?php echo ($emp->pos_id == $row->id) ? 'selected' : null;  ?>><?php echo $row->name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Email</label>
                      <input type="email" name="email" class="form-control" value="<?php echo $emp->email; ?>">
                    </div>

                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Date of Birth</label>
                      <input type="date" name="dob" class="form-control" value="<?php echo $emp->dob; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Phone</label>
                      <input type="phone" name="phone" class="form-control" value="<?php echo $emp->phone; ?>">
                    </div>

                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Create Password</label>
                      <input type="password" name="password" class="form-control" value="">
                      <input type="hidden" name="old_password" class="form-control" value="<?php echo $emp->password; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Address</label>
                      <textarea name="address" class="form-control"><?php echo $emp->address;  ?></textarea>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Photo</label>
                      <input type="file" name="photo" id="input-photo" class="btn btn-outline-success form-control">
                      <input type="hidden" name="old_photo" value="<?php echo $emp->photo; ?>">
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