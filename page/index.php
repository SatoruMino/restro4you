<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
require_once('partials/_analytics.php');
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

      <!-- Stocker -->
      <?php if ($role == 'stocker') { ?>
        <div class="container-fluid">
          <div class="header-body">
            <div class="row">
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">INGREDIENTS</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $ingredients; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                          <i class="fa-solid fa-pepper-hot"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">IMPORT</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $imports; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                          <i class="fa-solid fa-file-import"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">SUPPLIERS</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $suppliers; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-dark text-white rounded-circle shadow">
                          <i class="fa-solid fa-truck-field"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">EXPENSE</h5>
                        <span class="h2 font-weight-bold mb-0">$<?php echo $importExpense; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                          <i class="fa-solid fa-money-bill-transfer"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <!-- Cashier -->
      <?php if ($role == 'cashier') { ?>
        <div class="container-fluid">
          <div class="header-body">
            <!-- Card stats -->
            <div class="row">
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Customers</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $customers; ?></span>
                      </div><!-- For more projects: Visit codeastro.com  -->
                      <div class="col-auto">
                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- For more projects: Visit codeastro.com  -->
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Products</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                          <i class="fas fa-utensils"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">SALE</h5>
                        <span class="h2 font-weight-bold mb-0">$sales</span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                          <i class="fas fa-dollar-sign"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <!-- Customer -->
      <?php if ($role == 'customer') { ?>
        <div class="container-fluid">
          <div class="header-body">
            <!-- Card stats -->
            <div class="row">
              <div class="col-xl-4 col-lg-6">
                <a href="orders.php">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Available Items</h5>
                          <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                        </div><!-- For more projects: Visit codeastro.com  -->
                        <div class="col-auto">
                          <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                            <i class="fas fa-utensils"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div><!-- For more projects: Visit codeastro.com  -->
              <div class="col-xl-4 col-lg-6">
                <a href="orders_reports.php">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Total Orders</h5>
                          <span class="h2 font-weight-bold mb-0"><?php echo $custOrder; ?></span>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                            <i class="fas fa-shopping-cart"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </a><!-- For more projects: Visit codeastro.com  -->
              </div>
              <div class="col-xl-4 col-lg-6">
                <a href="payments_reports.php">
                  <div class="card card-stats mb-4 mb-xl-0">
                    <div class="card-body">
                      <div class="row">
                        <div class="col">
                          <h5 class="card-title text-uppercase text-muted mb-0">Total Money Spend</h5>
                          <span class="h2 font-weight-bold mb-0">$<?php echo $sales; ?></span>
                        </div>
                        <div class="col-auto">
                          <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                            <i class="fas fa-wallet"></i>
                          </div>
                        </div><!-- For more projects: Visit codeastro.com  -->
                      </div>
                    </div>
                  </div>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
      <?php if ($role == 'admin') { ?>
        <div class="container-fluid">
          <div class="header-body">
            <!-- Card stats -->
            <div class="row">
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Customers</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $customers; ?></span>
                      </div><!-- For more projects: Visit codeastro.com  -->
                      <div class="col-auto">
                        <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                          <i class="fas fa-users"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- For more projects: Visit codeastro.com  -->
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Products</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $products; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                          <i class="fas fa-utensils"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">INGREDIENTS</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $ingredients; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-primary text-white rounded-circle shadow">
                          <i class="fa-solid fa-pepper-hot"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">IMPORT</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $imports; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                          <i class="fa-solid fa-file-import"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row my-4">
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">SUPPLIERS</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $suppliers; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-dark text-white rounded-circle shadow">
                          <i class="fa-solid fa-truck-field"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">SALE</h5>
                        <span class="h2 font-weight-bold mb-0">$<?php echo $sales; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                          <i class="fas fa-dollar-sign"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">EXPENSE</h5>
                        <span class="h2 font-weight-bold mb-0">$<?php echo $importExpense; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                          <i class="fa-solid fa-money-bill-transfer"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-3 col-lg-6">
                <div class="card card-stats mb-4 mb-xl-0">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">ORDERS</h5>
                        <span class="h2 font-weight-bold mb-0"><?php echo $orders; ?></span>
                      </div>
                      <div class="col-auto">
                        <div class="icon icon-shape bg-purple text-white rounded-circle shadow">
                          <i class="fa-solid fa-shopping-cart"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <?php if ($role == 'admin') { ?>
        <div class="row mt-5">
          <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col">
                    <h3 class="mb-0">Recent Orders</h3>
                  </div>
                  <div class="col text-right">
                    <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr><!-- For more projects: Visit codeastro.com  -->
                      <th class="text-success" scope="col"><b>Code</b></th>
                      <th scope="col"><b>Customer</b></th>
                      <th class="text-success" scope="col"><b>Product</b></th>
                      <th scope="col"><b>Unit Price</b></th>
                      <th class="text-success" scope="col"><b>Qty</b></th>
                      <th scope="col"><b>Total</b></th>
                      <th scop="col"><b>Status</b></th>
                      <th class="text-success" scope="col"><b>Date</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT o.*, p.name AS prod_name, c.name AS cust_name FROM orders o INNER JOIN 
                  products p ON o.p_id = p.id INNER JOIN
                  customers c ON o.cust_id = c.id
                  ORDER BY `o`.`order_date` DESC LIMIT 7 ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($order = $res->fetch_object()) {
                    ?>
                      <tr>
                        <th class="text-success" scope="row"><?php echo $order->id; ?></th>
                        <td><?php echo $order->cust_name; ?></td>
                        <td class="text-success"><?php echo $order->prod_name; ?></td>
                        <td>$<?php echo $order->price; ?></td>
                        <td class="text-success"><?php echo $order->qty; ?></td>
                        <td>$<?php echo $order->total; ?></td>
                        <td><?php if ($order->order_status == '') {
                              echo "<span class='badge badge-danger'>Not Paid</span>";
                            } else {
                              echo "<span class='badge badge-success'>$order->order_status</span>";
                            } ?></td>
                        <td class="text-success"><?php echo date('d/M/Y g:i', strtotime($order->order_date)); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-xl-12">
            <div class="card shadow">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col">
                    <h3 class="mb-0">Recent Payments</h3>
                  </div>
                  <div class="col text-right">
                    <a href="payments_reports.php" class="btn btn-sm btn-primary">See all</a>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-success" scope="col"><b>Code</b></th>
                      <th scope="col"><b>Amount</b></th>
                      <th class='text-success' scope="col"><b>Order Code</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT * FROM payments ORDER BY `payments`.`paid_date` DESC LIMIT 7 ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($payment = $res->fetch_object()) {
                    ?>
                      <tr>
                        <th class="text-success" scope="row">
                          <?php echo $payment->id; ?>
                        </th>
                        <td>
                          $<?php echo $payment->amount; ?>
                        </td>
                        <td class='text-success'>
                          <?php echo $payment->o_id; ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-xl-12">
            <div class="card shadow">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col">
                    <h3 class="mb-0">Recent Import</h3>
                  </div>
                  <div class="col text-right">
                    <a href="import_report.php" class="btn btn-sm btn-primary">See all</a>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-success" scope="col"><b>Import Code</b></th>
                      <th scope="col"><b>Import Date</b></th>
                      <th class='text-success' scope="col"><b>Supplier Name</b></th>
                      <th class='text-success' scope="col"><b>Ingredient Name</b></th>
                      <th class='text-success' scope="col"><b>Total</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT imp.*, s.name AS sup_name, i.name AS ingred_name FROM imports imp INNER JOIN 
                            suppliers s ON imp.sup_id = s.id INNER JOIN 
                            ingredients i ON imp.int_id = i.id ORDER BY `imp`.`import_date` DESC LIMIT 7 ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($import = $res->fetch_object()) {
                    ?>
                      <tr>
                        <th class="text-success" scope="row">
                          <?php echo $import->id; ?>
                        </th>
                        <td>
                          $<?php echo $import->import_date; ?>
                        </td>
                        <td class='text-success'>
                          <?php echo $import->sup_name; ?>
                        </td>
                        <td class='text-success'>
                          <?php echo $import->ingred_name; ?>
                        </td>
                        <td class='text-success'>
                          $<?php echo $import->total; ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php } else if ($role == 'stocker') { ?>
        <!-- For more projects: Visit codeastro.com  -->
        <div class="row mt-5">
          <div class="col-xl-12">
            <div class="card shadow">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col">
                    <h3 class="mb-0">Recent Import</h3>
                  </div>
                  <div class="col text-right">
                    <a href="import_report.php" class="btn btn-sm btn-primary">See all</a>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-success" scope="col"><b>Import Code</b></th>
                      <th scope="col"><b>Import Date</b></th>
                      <th class='text-success' scope="col"><b>Supplier Name</b></th>
                      <th class='text-success' scope="col"><b>Ingredient Name</b></th>
                      <th class='text-success' scope="col"><b>Total</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT imp.*, s.name AS sup_name, i.name AS ingred_name FROM imports imp INNER JOIN 
                            suppliers s ON imp.sup_id = s.id INNER JOIN 
                            ingredients i ON imp.int_id = i.id ORDER BY `imp`.`import_date` DESC LIMIT 7 ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($import = $res->fetch_object()) {
                    ?>
                      <tr>
                        <th class="text-success" scope="row">
                          <?php echo $import->id; ?>
                        </th>
                        <td>
                          $<?php echo $import->import_date; ?>
                        </td>
                        <td class='text-success'>
                          <?php echo $import->sup_name; ?>
                        </td>
                        <td class='text-success'>
                          <?php echo $import->ingred_name; ?>
                        </td>
                        <td class='text-success'>
                          $<?php echo $import->total; ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      <?php } else if ($role == 'cashier') {  ?>
        <div class="row mt-5">
          <div class="col-xl-12 mb-5 mb-xl-0">
            <div class="card shadow">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col">
                    <h3 class="mb-0">Recent Orders</h3>
                  </div>
                  <div class="col text-right">
                    <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr><!-- For more projects: Visit codeastro.com  -->
                      <th class="text-success" scope="col"><b>Code</b></th>
                      <th scope="col"><b>Customer</b></th>
                      <th class="text-success" scope="col"><b>Product</b></th>
                      <th scope="col"><b>Unit Price</b></th>
                      <th class="text-success" scope="col"><b>Qty</b></th>
                      <th scope="col"><b>Total</b></th>
                      <th scop="col"><b>Status</b></th>
                      <th class="text-success" scope="col"><b>Date</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT o.*, p.name AS prod_name, c.name AS cust_name FROM orders o INNER JOIN 
                  products p ON o.p_id = p.id INNER JOIN
                  customers c ON o.cust_id = c.id
                  ORDER BY `o`.`order_date` DESC LIMIT 7 ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($order = $res->fetch_object()) {
                    ?>
                      <tr>
                        <th class="text-success" scope="row"><?php echo $order->id; ?></th>
                        <td><?php echo $order->cust_name; ?></td>
                        <td class="text-success"><?php echo $order->prod_name; ?></td>
                        <td>$<?php echo $order->price; ?></td>
                        <td class="text-success"><?php echo $order->qty; ?></td>
                        <td>$<?php echo $order->total; ?></td>
                        <td><?php if ($order->order_status == '') {
                              echo "<span class='badge badge-danger'>Not Paid</span>";
                            } else {
                              echo "<span class='badge badge-success'>$order->order_status</span>";
                            } ?></td>
                        <td class="text-success"><?php echo date('d/M/Y g:i', strtotime($order->order_date)); ?></td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-5">
          <div class="col-xl-12">
            <div class="card shadow">
              <div class="card-header border-0">
                <div class="row align-items-center">
                  <div class="col">
                    <h3 class="mb-0">Recent Payments</h3>
                  </div>
                  <div class="col text-right">
                    <a href="payments_reports.php" class="btn btn-sm btn-primary">See all</a>
                  </div>
                </div>
              </div>
              <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                  <thead class="thead-light">
                    <tr>
                      <th class="text-success" scope="col"><b>Code</b></th>
                      <th scope="col"><b>Amount</b></th>
                      <th class='text-success' scope="col"><b>Order Code</b></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $ret = "SELECT * FROM payments ORDER BY `payments`.`paid_date` DESC LIMIT 7 ";
                    $stmt = $mysqli->prepare($ret);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    while ($payment = $res->fetch_object()) {
                    ?>
                      <tr>
                        <th class="text-success" scope="row">
                          <?php echo $payment->id; ?>
                        </th>
                        <td>
                          $<?php echo $payment->amount; ?>
                        </td>
                        <td class='text-success'>
                          <?php echo $payment->o_id; ?>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <?php } else if ($role == 'customer') {
        $ret = "SELECT id FROM customers WHERE u_id = '$userId'";
        $getmt = $mysqli->prepare("$ret");
        $getmt->execute();
        $res = $getmt->get_result();
        if ($result = $res->fetch_assoc()) {
          $cust_id = $result['id'];
        ?>
          <div class="row mt-5">
            <div class="col-xl-12">
              <div class="card shadow">
                <div class="card-header border-0">
                  <div class="row align-items-center">
                    <div class="col">
                      <h3 class="mb-0">Recent Payment</h3>
                    </div>
                    <div class="col text-right">
                      <a href="import_report.php" class="btn btn-sm btn-primary">See all</a>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <!-- Projects table -->
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr>
                        <th class="text-success" scope="col"><b>Code</b></th>
                        <th scope="col"><b>Amount</b></th>
                        <th class='text-success' scope="col"><b>Order Code</b></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = "SELECT * FROM payments WHERE cust_id ='$cust_id'   ORDER BY `payments`.`paid_date` DESC LIMIT 10 ";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($payment = $res->fetch_object()) {
                      ?>
                        <tr>
                          <th class="text-success" scope="row">
                            <?php echo $payment->id; ?>
                          </th>
                          <td>
                            $<?php echo $payment->amount; ?>
                          </td>
                          <td class='text-success'>
                            <?php echo $payment->o_id; ?>
                          </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-5">
            <div class="col-xl-12 mb-5 mb-xl-0">
              <div class="card shadow">
                <div class="card-header border-0">
                  <div class="row align-items-center">
                    <div class="col">
                      <h3 class="mb-0">Recent Orders</h3>
                    </div>
                    <div class="col text-right">
                      <a href="orders_reports.php" class="btn btn-sm btn-primary">See all</a>
                    </div>
                  </div>
                </div>
                <div class="table-responsive">
                  <!-- Projects table -->
                  <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                      <tr><!-- For more projects: Visit codeastro.com  -->
                        <th class="text-success" scope="col">Code</th>
                        <th scope="col">Customer</th>
                        <th class="text-success" scope="col">Product</th>
                        <th scope="col">Unit Price</th>
                        <th class="text-success" scope="col">#</th>
                        <th scope="col">Total Price</th>
                        <th scop="col">Status</th>
                        <th class="text-success" scope="col">Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $ret = "SELECT o.*, p.name AS prod_name, c.name AS cust_name FROM orders o INNER JOIN
                              products p ON o.p_id = p.id INNER JOIN
                              customers c ON o.cust_id = c.id  WHERE o.cust_id = '$cust_id' ORDER BY `o`.`order_date` DESC LIMIT 10 ";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($order = $res->fetch_object()) {
                      ?>
                        <tr>
                          <th class="text-success" scope="row"><?php echo $order->id; ?></th>
                          <td><?php echo $order->cust_name; ?></td>
                          <td class="text-success"><?php echo $order->prod_name; ?></td>
                          <td>$<?php echo $order->price; ?></td>
                          <td class="text-success"><?php echo $order->qty; ?></td>
                          <td>$<?php echo $order->total; ?></td>
                          <td><?php if ($order->order_status == '') {
                                echo "<span class='badge badge-danger'>Not Paid</span>";
                              } else {
                                echo "<span class='badge badge-success'>$order->order_status</span>";
                              } ?></td>
                          <td class="text-success"><?php echo date('d/M/Y g:i', strtotime($order->order_date)); ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>

      <?php }
      } ?>
      <!-- Footer -->
      <?php require_once('partials/_footer.php'); ?>
    </div>
  </div>
  <!-- Argon Scripts -->
  <?php
  require_once('partials/_scripts.php');
  ?>
</body>
<!-- For more projects: Visit codeastro.com  -->

</html>