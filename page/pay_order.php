<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();

if (isset($_POST['pay'])) {
  //Prevent Posting Blank Values
  //Visit codeastro.com for more projects
  if (empty($_POST["pay_code"]) || empty($_POST["pay_amt"]) || empty($_POST['pay_method'])) {
    $err = "Blank Values Not Accepted";
  } else {

    $pay_code = $_POST['pay_code'];
    $order_code = $_GET['order_code'];
    $cust_id = $_GET['cust_id'];
    $pay_amt  = $_POST['pay_amt'];
    $pay_method = $_POST['pay_method'];
    $order_status = $_GET['order_status'];

    //Insert Captured information to a database table
    $postQuery = "INSERT INTO payments (id, o_id, cust_id, amount, method) VALUES(?,?,?,?,?)";
    $upQry = "UPDATE orders SET order_status =? WHERE id =?";

    $postStmt = $mysqli->prepare($postQuery);
    $upStmt = $mysqli->prepare($upQry);
    //bind paramaters

    $rc = $postStmt->bind_param('sssss', $pay_code, $order_code, $cust_id, $pay_amt, $pay_method);
    $rc = $upStmt->bind_param('ss', $order_status, $order_code);

    $postStmt->execute();
    $upStmt->execute();
    //declare a varible which will be passed to alert function
    if ($upStmt && $postStmt) {
      $success = "Paid" && header("refresh:1; url=receipts.php");
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
    $order_code = $_GET['order_code'];
    $ret = "SELECT * FROM  orders WHERE id ='$order_code' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($order = $res->fetch_object()) {
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
        <div class="row"><!-- For more projects: Visit codeastro.com  -->
          <div class="col">
            <div class="card shadow">
              <div class="card-header border-0">
                <h3>Please Fill All Fields</h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Payment Code</label>
                      <input type="text" name="pay_code" value="<?php echo $mpesaCode; ?>" class="form-control" value="">
                    </div>
                    <div class="col-md-6">
                      <label>Amount ($)</label>
                      <input type="text" name="pay_amt" readonly value="<?php echo $order->total; ?>" class="form-control">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Payment Method</label>
                      <select class="form-control" name="pay_method">
                        <option selected>Cash</option>
                        <option>Paypal</option>
                      </select>
                    </div>
                  </div>
                  <br><!-- For more projects: Visit codeastro.com  -->
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="pay" value="Pay Order" class="btn btn-success" value="">
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
    }
?>
</body>
<!-- For more projects: Visit codeastro.com  -->

</html>