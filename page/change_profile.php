<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Update Profile
// Update Profile
if (isset($_POST['changeProfile'])) {
  $role = $_SESSION['role'];
  $id = $_SESSION['userId'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $gender = $_POST['gender'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $photo = $_FILES['photo']['name'];

  // Validate and move the uploaded file
  if ($photo && move_uploaded_file($_FILES["photo"]["tmp_name"], "assets/img/users/" . $photo)) {
    $photo_path = "assets/img/users/" . $photo;
  } else {
    $photo_path = null; // Handle the case where no photo is uploaded
  }

  // Prepare the SQL query based on the user's role
  $Qry = '';
  switch ($role) {
    case "admin":
      $Qry = "UPDATE admins SET name = ?, gender = ?, phone = ?, address = ?, photo = ? WHERE u_id = ?";
      break;
    case "customer":
      $Qry = "UPDATE customers SET name = ?, gender = ?, phone = ?, address = ?, photo = ? WHERE u_id = ?";
      break;
    default:
      $Qry = "UPDATE employees SET name = ?, gender = ?, phone = ?, address = ?, photo = ? WHERE u_id = ?";
      break;
  }

  $postStmt = $mysqli->prepare($Qry);
  if ($postStmt) {
    $postStmt->bind_param('ssssss', $name, $gender, $phone, $address, $photo_path, $id);
    if ($postStmt->execute()) {
      $ret = "UPDATE users SET email = ? WHERE id = ?";
      $updateStmt = $mysqli->prepare($ret);
      if ($updateStmt) {
        $updateStmt->bind_param("ss", $email, $id);
        if ($updateStmt->execute()) {
          header("Location: index.php");
          exit();
        } else {
          $err = "Failed to update email. Please try again later.";
        }
      } else {
        $err = "Failed to prepare email update statement.";
      }
    } else {
      $err = "Failed to update profile. Please try again later.";
    }
  } else {
    $err = "Failed to prepare profile update statement.";
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
    $userId = $_SESSION['userId'];
    $role = $_SESSION['role'];
    switch ($role) {
      case 'admin':
        $ret = "SELECT user.*, u.email AS email FROM admins user INNER JOIN users u ON user.u_id = u.id";
        break;
      case 'customer':
        $ret = "SELECT user.*, u.email AS email FROM customers user INNER JOIN users u ON user.u_id = u.id";
      default:
        $ret = "SELECT user.*, u.email AS email FROM employees user INNER JOIN users u ON user.u_id = u.id";
        break;
    }
    //$login_id = $_SESSION['login_id'];
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($user = $res->fetch_object()) {
    ?>
      <!-- Header -->
      <div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center" style="min-height: 600px; background-image: url(assets/img/theme/restro00.jpg); background-size: cover; background-position: center top;">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid d-flex align-items-center">
          <div class="row">
            <div class="col-lg-7 col-md-10">
              <h1 class="display-2 text-white">Hello <?php echo $user->name; ?></h1>
              <p class="text-white mt-0 mb-5">This is your profile page. You can customize your profile as you want And
                also change password too</p>
            </div>
          </div>
        </div>
      </div>
      <!-- Page content -->

      <form method="POST" enctype="multipart/form-data">
        <div class="container-fluid mt--8">
          <div class="row">
            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
              <div class="card card-profile shadow">
                <div class="row justify-content-center">
                  <div class="col-lg-3 order-lg-2">
                    <div class="card-profile-image">
                      <a href="index.php">
                        <img style="height: 175px; width: 175px; object-fit:cover;" src="<?php echo ($user->photo == null) ? 'assets/img/theme/user-a-min.png' : $user->photo; ?>" id="user_photo" name="user_photo" class="rounded-circle border border-2 border-dark">
                      </a>
                    </div>
                  </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                  <div class="d-flex justify-content-between">
                  </div>
                </div>
                <div class="card-body pt-0 pt-md-4">
                  <div class="row">
                    <div class="col">
                      <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                        <div>
                        </div>
                        <div>
                        </div>
                        <div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <h3>
                      <?php echo $user->name; ?></span>
                    </h3>
                    <div class="h5 font-weight-300">
                      <i class="ni location_pin mr-2"></i><?php echo $user->email; ?>
                    </div>
                    <div class="form-group">
                      <label class="form-control-label" for="input-photo">Photo</label>
                      <input type="file" id="input-photo" name="photo" class="form-control form-control-alternative">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-8 order-xl-1">
              <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                  <div class="row align-items-center">
                    <div class="col-8">
                      <h3 class="mb-0">My account</h3>
                    </div>
                    <div class="col-4 text-right">
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <h6 class="heading-small text-muted mb-4">User information</h6>
                  <div class="pl-lg-4">
                    <div class="row">
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label class="form-control-label" for="input-username">User Name</label>
                          <input type="text" name="name" value="<?php echo $user->name; ?>" class="form-control form-control-alternative" ">
                        </div>
                      </div>
                      <div class=" col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="input-email">Email address</label>
                            <input type="email" name="email" value="<?php echo $user->email; ?>" class="form-control form-control-alternative">
                          </div>
                        </div>


                      </div>
                      <div class=" row">
                        <div class=" col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="input-gender">Gender</label>
                            <select name="gender" class="form-control form-control-alternative">
                              <option>Please Select Gender</option>
                              <option value="Male" <?php echo ($user->gender == 'Male') ? 'selected' : null; ?>>Male</option>
                              <option value="Female" <?php echo ($user->gender == 'Female') ? 'selected' : null; ?>>Female</option>
                            </select>
                          </div>
                        </div>
                        <div class=" col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="input-phone">Phone</label>
                            <input type="phone" id="input-phone" value="<?php echo $user->phone; ?>" name="phone" class="form-control form-control-alternative">
                          </div>
                        </div>

                      </div>
                      <div class="row">
                        <div class=" col-lg-6">
                          <div class="form-group">
                            <label class="form-control-label" for="input-phone">Address</label>
                            <textarea id="input-address" name="address" class="form-control form-control-alternative"><?php echo $user->address ?></textarea>
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-group">
                            <input type="submit" id="input-email" name="changeProfile" class="btn btn-success form-control-alternative" value="Submit"">
                      </div>
                    </div>
                          </div>
                        </div>
                <hr>
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
      </form>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_sidebar.php');
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