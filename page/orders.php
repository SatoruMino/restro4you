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

  /* -- Snack bar-- */
  #snackbar {
    visibility: hidden;
    min-width: 250px;
    margin-left: -125px;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    bottom: 30px;
    font-size: 17px;
  }

  #snackbar.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
  }

  @-webkit-keyframes fadein {
    from {
      bottom: 0;
      opacity: 0;
    }

    to {
      bottom: 30px;
      opacity: 1;
    }
  }

  @keyframes fadein {
    from {
      bottom: 0;
      opacity: 0;
    }

    to {
      bottom: 30px;
      opacity: 1;
    }
  }

  @-webkit-keyframes fadeout {
    from {
      bottom: 30px;
      opacity: 1;
    }

    to {
      bottom: 0;
      opacity: 0;
    }
  }

  @keyframes fadeout {
    from {
      bottom: 30px;
      opacity: 1;
    }

    to {
      bottom: 0;
      opacity: 0;
    }
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
                      <td id="prod_id"><?php echo $prod->id; ?></td>
                      <td id="prod_name"><?php echo $prod->name; ?></td>
                      <td><?php echo $prod->cate_name; ?></td>
                      <td>$ <span id="prod_price"><?php echo $prod->price; ?></span></td>
                      <td>
                        <input type="number" id="prod_qty" name="prod_qty" class="form-control input-no-border" min="1" placeholder="Specify qty!">
                      </td>
                      <td><span id="status" name="status" class="form-control input-no-border">Unknown!</span></td>
                      <td>
                        <button class="btn btn-sm btn-success" id="makeOrderButton">
                          <i class="fas fa-cart-plus"></i>
                          Place Order
                        </button>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <div id="snackbar" name="snackbar"></div>
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
    var snackbar = $('#snackbar');
    $(document).ready(function() {
      function validateOrder() {
        var status = $('#status').text();
        console.log(status);
        if (status != 'Available') {
          showSnackBar(snackbar, 'Product is not available to order!');
          return false;
        }
        return true;
      }
      //Fetch Product Qty To Find Ingredient Needed
      $('#prod_qty').on("input", function() {
        var id = $('#prod_id').text();
        var qty = $(this).val();
        //Fetch Product Status
        getProductStatus(id, qty);
      });
      //Placer Order
      $('#makeOrderButton').click(function() {
        if (validateOrder()) {
          var id = $('#prod_id').text();
          var name = $('#prod_name').text();
          var price = $('#prod_price').text();
          var qty = $('#prod_qty').val();
          window.location.href = "make_order.php?prod_id=" + id + "&prod_name=" + name + "&prod_price=" + price + "&prod_qty=" + qty;
        }
      });
    });
  </script>

</body>
<!-- For more projects: Visit codeastro.com  -->

</html>