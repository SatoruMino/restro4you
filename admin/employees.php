<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
//Delete Staff
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $adn = "DELETE FROM  employees  WHERE  id = ?";
  $stmt = $mysqli->prepare($adn);
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $stmt->close();
  if ($stmt) {
    $success = "Deleted" && header("refresh:1; url=employees.php");
  } else {
    $err = "Try Again Later";
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
              <a href="add_employee.php" class="btn btn-outline-success"><i class='bx bx-user-plus'></i> Add Employee</a>
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">CODE</th>
                    <th scope="col">NAME</th>
                    <th scope="col">GENDER</th>
                    <th scope="col">POSITION</th>
                    <th scope="col">PHONE</th>
                    <th scope="col">EMAIL</th>
                    <th scope="col">ACTIONS</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $ret = "SELECT * FROM getEmployeeDetail";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($emp = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td><?php echo $emp->id; ?></td>
                      <td><?php echo $emp->name; ?></td>
                      <td><?php echo $emp->gender; ?></td>
                      <td><?php echo $emp->emp_pos; ?></td>
                      <td><?php echo $emp->phone; ?></td>
                      <td><?php echo $emp->emp_email; ?></td>
                      <td>
                        <a href="employees.php?delete=<?php echo $emp->id; ?>">
                          <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i>
                            Delete
                          </button>
                        </a>

                        <a href="update_employee.php?update=<?php echo $emp->id; ?>">
                          <button class="btn btn-sm btn-primary">
                            <i class="fas fa-user-edit"></i>
                            Update
                          </button>
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
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