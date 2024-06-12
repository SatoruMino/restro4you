<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['make'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["o_code"]) || empty($_POST["cust_name"]) || empty($_GET['prod_price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $o_code  = $_POST['o_code'];
    $cust_id = $_POST['cust_id'];
    $prod_id  = $_GET['prod_id'];
    $prod_price = $_GET['prod_price'];
    $prod_qty = $_POST['prod_qty'];
    $total = $prod_price * $prod_qty;
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO orders (id, cust_id, p_id, qty, price, total) VALUES(?, ?, ?, ?, ?, ?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssss', $o_id, $cust_id, $prod_id, $prod_qty, $prod_price, $total);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Order Submitted" && header("refresh:1; url=payments.php");
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
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-4">
                    <label>Customer Name</label>
                    <select class="form-control" name="cust_name" id="cust_name" onchange="getCustomer(this.value)">
                      <option value="">Select Customer Name</option>
                      <?php
                      //Load All Customers
                      $ret = "SELECT * FROM  customers ";
                      $stmt = $mysqli->prepare($ret);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      while ($cust = $res->fetch_object()) {
                      ?>
                        <option><?php echo $cust->name; ?></option>
                      <?php } ?>
                    </select>
                  </div>

                  <div class="col-md-4">
                    <label>Customer ID</label>
                    <input type="text" name="cust_id" readonly id="cust_id" class="form-control">
                  </div>

                  <div class="col-md-4">
                    <label>Order Code</label>
                    <input type="text" name="o_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                  </div>
                </div>
                <hr>
                <?php
                $prod_id = $_GET['prod_id'];
                $ret = "SELECT * FROM  products WHERE id = '$prod_id'";
                $stmt = $mysqli->prepare($ret);
                $stmt->execute();
                $res = $stmt->get_result();
                while ($prod = $res->fetch_object()) {
                ?>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Product Price ($)</label>
                      <input type="text" readonly name="prod_price" value="$ <?php echo $prod->price; ?>" class="form-control">
                    </div>
                    <div class="col-md-6">
                      <label>Product Quantity</label>
                      <input type="text" name="prod_qty" class="form-control" value="">
                    </div>
                  </div>
                <?php } ?>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <input type="submit" name="make" value="Make Order" class="btn btn-success" value="">
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