<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
if (isset($_POST['addProduct'])) {
  //Prevent Posting Blank Values
  if (empty($_POST["code"]) || empty($_POST["name"]) || empty($_POST['cate'])  || empty($_POST['price'])) {
    $err = "Blank Values Not Accepted";
  } else {
    $code  = $_POST['code'];
    $name = $_POST['name'];
    $cate = $_POST['cate'];
    $img = $_FILES['img']['name'];
    move_uploaded_file($_FILES["img"]["tmp_name"], "assets/img/products/" . $_FILES["img"]["name"]);
    $price = $_POST['price'];
    // Loop through ingredients and quantities
    // Loop through ingredients and quantities
    $ingredients = $_POST['ingredients'];
    $qty = $_POST['qty'];
    $recipe = array();
    for ($i = 0; $i < count($ingredients); $i++) {
      $recipe[] = array(
        'id' => $ingredients[$i],
        'qty' => $qty[$i],
      );
    }
    $recipe_json = json_encode($recipe);
    //Visit codeastro.com for more projects
    //Insert Captured information to a database table
    $postQuery = "INSERT INTO products (id, name, cate_id, price, image, recipe ) VALUES(?,?,?,?,?,?)";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('ssssss', $code, $name, $cate, $price, $img, $recipe_json);
    $postStmt->execute();
    //declare a varible which will be passed to alert function
    if ($postStmt) {
      $success = "Product Added" && header("refresh:1; url=products.php");
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
    <!-- Header --><!-- For more projects: Visit codeastro.com  -->
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
              <h3>Please Fill All Fields</h3>
            </div><!-- For more projects: Visit codeastro.com  -->
            <div class="card-body">
              <form method="POST" enctype="multipart/form-data">
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Code</label>
                    <input type="text" name="code" value="<?php echo $alpha; ?>-<?php echo $beta; ?>" class="form-control" value="">
                  </div>
                  <div class="col-md-6">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
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
                        <option value="<?php echo $cate->id; ?>"><?php echo $cate->name; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label>Price</label>
                    <input type="number" name="price" class="form-control" step="0.01" value="">
                  </div>
                </div>
                <hr>
                <div class="form-row">
                  <div class="col-md-6">
                    <label>Image</label>
                    <input type="file" name="img" class="btn btn-outline-success form-control" value="">
                  </div>
                </div>
                <hr>
                <div id="ingredients"></div>
                <br>
                <div class="form-row">
                  <div class="col-md-6">
                    <button type="button" name="addIngredients" onclick="addIngredientField()" class="btn btn-outline-success">Add Ingredients</button>
                  </div>
                </div>
                <br>
                <div class="form-row">
                  <div class="ingredients"></div>
                </div>
                <input type="submit" name="addProduct" value="Add Product" class="btn btn-success" value="">
              </form>
            </div>
          </div>
        </div>
      </div><!-- For more projects: Visit codeastro.com  -->
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
    let ingredientCount = 0;

    function addIngredientField() {
      ingredientCount++;

      const div = document.createElement('div');
      div.id = 'ingredient_' + ingredientCount;
      div.classList.add("form-row");
      div.innerHTML = `
                  <div class="col-md-6">
                      <label>Ingredient:</label>
                      <select id="ingredient_${ingredientCount}" class="form-control form-select-lg mb-3" aria-label="Large select example" name="ingredients[]" id="ingredients">
                        <?php
                        $ret = "SELECT * FROM  ingredients ";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->execute();
                        $res = $stmt->get_result();
                        while ($ingredient = $res->fetch_object()) {
                        ?>
                        <option value="<?php echo $ingredient->id; ?>"><?php echo $ingredient->name; ?></option>
                        <?php } ?>
                      </select>
                  </div>
                  <div class="col-md-6">
                      <label>Quantity</label>
                      <input type="number" class="form-control" name = "qty[]" id="qty_${ingredientCount}">
                  </div>
            `;
      document.getElementById('ingredients').appendChild(div);
      loadIngredients(ingredientCount);
    }
  </script>
</body>
<!-- For more projects: Visit codeastro.com  -->

</html>