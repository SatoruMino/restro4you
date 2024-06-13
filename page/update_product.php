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
    //Insert Captured information to a database table
    $postQuery = "UPDATE products SET id =?, name =?, cate_id =?, price =?, image =?, recipe =? WHERE id = ?";
    $postStmt = $mysqli->prepare($postQuery);
    //bind paramaters
    $rc = $postStmt->bind_param('sssssss', $code, $name, $cate, $price, $img, $recipe_json, $update);
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

<>
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
                      <input type="text" name="code" value="<?php echo $prod->id; ?>" class="form-control" value="<?php echo $prod->id; ?>">
                    </div>
                    <div class="col-md-6">
                      <label>Name</label>
                      <input type="text" name="name" class="form-control" value="<?php echo $prod->name; ?>">
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
                      <input type="number" name="price" class="form-control" step="0.01" value="<?php echo $prod->price; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-row">
                    <div class="col-md-6">
                      <label>Image</label>
                      <input type="file" name="img" class="btn btn-outline-success form-control" value="">
                      <input type="hidden" name="old_img" class="btn btn-outline-success form-control" value="<?php echo $prod->image ?>">
                    </div>
                  </div>
                  <br>
                  <div id="ingredients">
                    <?php
                    $recipes = json_decode($prod->recipe, true);
                    foreach ($recipes as $key => $rec) { ?>
                      <div class="form-row">
                        <div class="col-md-6">
                          <label>Ingredient:</label>
                          <select class="form-control" name="ingredients[]">
                            <?php
                            $stmt = $mysqli->prepare("SELECT * FROM ingredients");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            while ($ing = $result->fetch_object()) { ?>
                              <option value="<?php echo $ing->id; ?>" <?php echo ($ing->id == $rec['id']) ? 'selected' : null; ?>><?php echo $ing->name; ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-5">
                          <label>Quantity</label>
                          <input type="number" class="form-control" name="qty[]" step="0.01" value="<?php echo $rec['qty']; ?>">
                        </div>
                        <div class="col-md-1 text-danger">
                          <i class="bx bx-message-square-x" role="button" onclick="removeIngredient(this)"></i>
                        </div>
                      </div>
                      <br>
                    <?php } ?>
                  </div>
                  <div class="form-row">
                    <div class="col-md-6">
                      <button type="button" name="addIngredients" onclick="addIngredientField()" class="btn btn-outline-success">Add Ingredients</button>
                    </div>
                  </div>
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
  <script>
    let ingredientCount = <?php echo count($recipes); ?>;

    function removeIngredient(button) {
      // Get the parent form row element of the remove button
      const formRow = button.closest('.form-row');
      // Get the <br> element next to the form row
      const brElement = formRow.nextElementSibling;

      // Remove the entire form row from the DOM
      formRow.remove();
      // Remove the <br> element if it exists and if it's directly after the form row
      if (brElement && brElement.tagName === 'BR' && brElement.previousElementSibling === formRow) {
        brElement.remove();
      }
    }

    function addIngredientField() {
      ingredientCount++;

      const div = document.createElement('div');
      div.id = 'ingredient_' + ingredientCount;
      div.classList.add("form-row");
      div.innerHTML = `
      <div class="col-md-6">
        <label>Ingredient:</label>
        <select id="ingredient_${ingredientCount}" class="form-control form-select-lg mb-3" aria-label="Large select example" name="ingredients[]" id="ingredients_${ingredientCount}">
          <?php
          $ret = "SELECT * FROM ingredients ";
          $stmt = $mysqli->prepare($ret);
          $stmt->execute();
          $res = $stmt->get_result();
          while ($ingredient = $res->fetch_object()) {
          ?>
          <option value="<?php echo $ingredient->id; ?>"><?php echo $ingredient->name; ?></option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-5">
        <label>Quantity</label>
        <input type="number" class="form-control" name="qty[]" id="qty_${ingredientCount}"> 
      </div>
      <div class="col-md-1 text-danger">
        <i class="bx bx-message-square-x" role="button" onclick="removeIngredient(this)"></i>
      </div>
    `;
      document.getElementById('ingredients').appendChild(div);
    }
  </script>
  </body>

  </html>