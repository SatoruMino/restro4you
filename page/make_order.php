<?php
session_start();
include('config/pdoconfig.php');
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['make'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["o_code"]) || empty($_POST["cust_id"])  || empty($_GET['prod_price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $o_code  = $_POST['o_code'];
    $prod_id  = $_GET['prod_id'];
    $prod_price = intval($_GET['prod_price']);
    $prod_qty = floatval($_GET['prod_qty']);
    $total = $prod_price * $prod_qty;
    $cust_id = $_POST['cust_id'];
    $stmt = $pdo->prepare("INSERT INTO `orders`(id, cust_id, qty, price, p_id, total) VALUES (:id,:cust_id,:qty,:price,:p_id, :total)");
    $stmt->bindParam(":id", $o_code);
    $stmt->bindParam(":cust_id", $cust_id);
    $stmt->bindParam(":qty", $prod_qty);
    $stmt->bindParam(":price", $prod_price);
    $stmt->bindParam(":p_id", $prod_id);
    $stmt->bindParam(":total", $total);
    $stmt->execute();
    //declare a varible which will be passed to alert function
    if ($stmt) {
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
                <?php if ($role == 'admin' || $role == 'cashier') { ?>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Order Code</label>
                      <input type="text" name="o_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                    </div>
                    <div class="col-md-6">
                      <label>Product Price ($)</label>
                      <input type="text" readonly value="$ <?php echo $_GET['prod_price']; ?>" class="form-control">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Customer ID</label>
                      <input type="text" name="cust_id" readonly id="cust_id" class="form-control">
                    </div>
                    <div class="col-md-6">
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
                  </div>
                  <?php } else if ($role == 'customer') {
                  $ret = "SELECT id FROM customers WHERE u_id = '$userId'";
                  $getmt = $mysqli->prepare("$ret");
                  $getmt->execute();
                  $res = $getmt->get_result();
                  if ($result = $res->fetch_assoc()) {
                    $cust_id = $result['id'];  ?>
                    <div class="form-row">
                      <div class="col-md-6">
                        <label>Customer Name</label>
                        <?php
                        //Load All Customers
                        $ret = "SELECT * FROM  customers WHERE id = '$cust_id' ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($cust = $res->fetch_object()) {
                        ?>
                          <input class="form-control" readonly type="hidden" name="cust_id" value="<?php echo $cust->id; ?>">
                          <input class="form-control" readonly name="cust_name" value="<?php echo $cust->name; ?>">
                        <?php } ?>
                      </div>
                      <div class="col-md-6">
                        <label>Order Code</label>
                        <input type="text" readonly name="o_code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
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
                      </div>
                    <?php } ?>
                <?php }
                } ?>
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