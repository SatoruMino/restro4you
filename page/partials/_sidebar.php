<?php
$userId = $_SESSION['userId'];
$role = $_SESSION['role'];
$sql = "";
if ($role = 'admin') {
  $sql = "SELECT * FROM admins WHERE u_id = '$userId'";
} else if ($role == 'cashier' || $role == 'stocker') {
  $sql = "SELECT * FROM employees WHERE u_id = '$userId'";
} else {
  $sql = "SELECT * FROM customers WHERE u_id = '$userId'";
}
$stmt = $mysqli->prepare($sql);
$stmt->execute();
$res = $stmt->get_result();
while ($user = $res->fetch_object()) {

?>
  <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
      <!-- Toggler -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <!-- Brand -->
      <a class="navbar-brand pt-0" href="index.php">
        <img src="assets/img/brand/repos.png" class="navbar-brand-img" alt="...">
      </a>
      <!-- User -->
      <ul class="nav align-items-center d-md-none">
        <li class="nav-item dropdown">
          <a class="nav-link nav-link-icon" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ni ni-bell-55"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right" aria-labelledby="navbar-default_dropdown_1">
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="media align-items-center">
              <span class="avatar avatar-sm rounded-circle">
                <img alt="Image placeholder" src="assets/img/theme/team-1-800x800.jpg">
              </span>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
            <div class=" dropdown-header noti-title">
              <h6 class="text-overflow m-0">Welcome!</h6>
            </div>
            <a href="change_profile.php" class="dropdown-item">
              <i class="ni ni-single-02"></i>
              <span>My profile</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="logout.php" class="dropdown-item">
              <i class="ni ni-user-run"></i>
              <span>Logout</span>
            </a>
          </div>
        </li>
      </ul>
      <!-- Collapse -->
      <div class="collapse navbar-collapse" id="sidenav-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="index.php">
                <img src="assets/img/brand/repos.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Form -->
        <form class="mt-4 mb-3 d-md-none">
          <div class="input-group input-group-rounded input-group-merge">
            <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="Search" aria-label="Search">
            <div class="input-group-prepend">
              <div class="input-group-text">
                <span class="fa fa-search"></span>
              </div>
            </div>
          </div>
        </form>
        <!-- Navigation -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="bx bxs-dashboard text-primary"></i> DASHBOARD
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="positions.php">
              <i class="bx bxs-user-badge text-primary"></i> POSITION
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="category.php">
              <i class="bx bx-category text-primary"></i> CATEGORY
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="employees.php">
              <i class="bx bxs-group text-primary"></i> EMPLOYEE
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="customers.php">
              <i class="bx bx-user text-primary"></i> CUSTOMER
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="suppliers.php">
              <i class="bx bx-user-plus text-primary"></i> SUPPLIER
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="products.php">
              <i class="bx bx-food-menu text-primary"></i>FOOD
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="orders.php">
              <i class="bx bx-cart text-primary"></i> ORDERS
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="ingredients.php">
              <i class="bx bx-list-ul text-primary"></i> INGREDIENT
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="imports.php">
              <i class="bx bx-import text-primary"></i> IMPORT
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="payments.php">
              <i class="bx bxs-credit-card text-primary"></i> PAYMENT
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="receipts.php">
              <i class="bx bx-receipt text-primary"></i> RECEIPT
            </a>
          </li>
        </ul>
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">REPORTING</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="orders_reports.php">
              <i class="bx bx-basket"></i> ORDERS
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="import_report.php">
              <i class="bx bx-import"></i> IMPORT
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="payments_reports.php">
              <i class="bx bx-credit-card-alt"></i> PAYMENTS
            </a>
          </li>
        </ul>
        <hr class="my-3">
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="bx bx-log-out text-danger"></i> LOGOUT
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

<?php } ?>