<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>
<style>
  .input-no-border {
    border: none !important;
    box-shadow: none !important;
  }
</style>

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
    </div><!-- For more projects: Visit codeastro.com  -->
    <!-- Page content -->
    <div class="container-fluid mt--8">
      <!-- Table -->
      <div class="row">
        <div class="col">
          <div class="card shadow">
            <div class="card-header border-0">
              Select On Any Product To Make An Order
            </div>
            <div class="table-responsive">
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col"><b>Image</b></th>
                    <th scope="col"><b>Product Code</b></th>
                    <th scope="col"><b>Name</b></th>
                    <th scope="col"><b>Category</b></th>
                    <th scope="col"><b>Price</b></th>
                    <th scope="col"><b>Qty</b></th>
                    <th scope="col"><b>Status</b></th>
                    <th scope="col"><b>Action</b></th>
                  </tr>
                </thead><!-- For more projects: Visit codeastro.com  -->
                <tbody>
                  <?php
                  $status = "Available";
                  $ret = "SELECT p.*, c.name as cate_name FROM products p INNER JOIN category c ON p.cate_id = c.id";
                  $stmt = $mysqli->prepare($ret);
                  $stmt->execute();
                  $res = $stmt->get_result();
                  while ($prod = $res->fetch_object()) {
                  ?>
                    <tr>
                      <td>
                        <?php
                        if ($prod->image) {
                          echo "<img src='assets/img/products/$prod->image' height='60' width='60 class='img-thumbnail'>";
                        } else {
                          echo "<img src='assets/img/products/default.jpg' height='60' width='60 class='img-thumbnail'>";
                        }
                        ?>
                      </td>
                      <td><span id="prod_id"><?php echo $prod->id; ?></span></td>
                      <td><?php echo $prod->name; ?></td>
                      <td><?php echo $prod->cate_name; ?></td>
                      <td>$ <?php echo $prod->price; ?></td>
                      <td>
                        <label>Customer Name</label>
                        <input type="text" id="prod_name" name="prod_name" class="text">
                      </td>
                      <td>
                        <input id="status">
                        <input id="prod_qty" type="number" name="prod_qty">
                      </td>
                      <td>
                        <?php if ($status == 'Available') { ?>
                          <a href="make_oder.php?prod_id=<?php echo $prod->id; ?>&prod_name=<?php echo $prod->name; ?>&prod_price=<?php echo $prod->price; ?>">
                            <button class="btn btn-sm btn-success">
                              <i class="fas fa-cart-plus"></i>
                              Place Order
                            </button>
                          </a>
                        <?php } else { ?>
                          <button class="btn btn-sm btn-danger">
                            <i class=""></i>
                            Not Available
                          </button>
                        <?php } ?>
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
  <script>
    $(document).ready(function() {
      $('#prod_qty').on("input", function() {
        // Get the value from #prod_id using .text() for text content
        var id = $('#prod_id').text();

        // Get the value from this (the input element) using .val() for input value
        var qty = $(this).val();

        console.log(id);
        console.log(qty);

        getProduct(id, qty);
      });
    });
  </script>

</body>
<!-- For more projects: Visit codeastro.com  -->

</html>