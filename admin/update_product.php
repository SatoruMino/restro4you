<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['updateProduct'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["code"]) || empty($_POST["name"]) || empty($_POST['price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $update = $_GET['update'];
    $code  = $_POST['code'];
    $name = $_POST['name'];
    $cate = $_POST['cate'];
    $img = $_FILES['img']['name'];
    $old_img = $_POST['old_img'];
    if ($img) {
      move_uploaded_file($_FILES["img"]["tmp_name"], "assets/img/products/" . $_FILES["img"]["name"]);
    } else {
      $img = $old_img;
    }
    $price = $_POST['price'];

    //Insert Captured information to a database table
    $postQuery = "UPDATE products SET id =?, name =?, cate_id =?, price =?, image =? WHERE id = ?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssss', $code, $name, $cate, $price, $img, $update);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Product Has Been Updated" && header("refresh:1; url=products.php");
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
    $ret = "SELECT * FROM  products WHERE id = '$update' ";
    $stmt = $mysqli->prepare($ret);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($prod = $res->fetch_object()) {
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
        <!-- #endregion -->
        <div class="row">
          <div class="col">
            <div class="card shadow">
              <div class="card-header border-0">
                <h3>Please Fill All Fields</h3>
              </div>
              <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Code</label>
                      <input type="text" name="code" value="<?php echo $prod->id ?>" class="form-control" value="">
                    </div>
                    <div class="col-md-6">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" value="<?php echo $prod->name ?>">
                    </div>
                  </div>
                  <hr><!-- For more projects: Visit codeastro.com  -->
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Category</label>
                      <select class="form-control" name="cate">
                        <?php
                        $stmt = $mysqli->prepare("SELECT * FROM category");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($cate = $result->fetch_object()) { ?>
                          <option value="<?php echo $cate->id; ?>" <?php echo ($cate->id == $prod->cate_id) ? 'selected' : null; ?>><?php echo $cate->name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="col-md-6">
                      <label>Price</label>
                      <input type="number" name="price" class="form-control" value="<?php echo $prod->price ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Image</label>
                      <input type="file" name="img" class="btn btn-outline-success form-control" value="">
                      <input type="hidden" name="old_img" value="<?php echo $prod->image ?>">
                    </div>
                  </div>
                  <hr>
                  <br>
                  <div class="form-row">
                    <div class="col-md-6">
                      <input type="submit" name="updateProduct" value="Update Product" class="btn btn-success" value="">
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
</body>

</html>