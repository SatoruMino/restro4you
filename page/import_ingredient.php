<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
diss_allow_role(["customer", "cashier", "chef"]);
//Add Staff
if (isset($_POST['importIngredient'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["ingred_id"]) || empty($_POST["sup_id"]) || empty($_POST['ingred_qty']) || empty($_POST['ingred_price'])) {
        $err = "Black value can't be accepted!";
    } else {
        $ingred_id = $_POST["ingred_id"];
        $sup_id = $_POST["sup_id"];
        $ingred_qty = intval($_POST["ingred_qty"]);
        $ingred_price = floatval($_POST["ingred_price"]);
        $total = $ingred_qty * $ingred_price;
        //Insert Captured information to a database table
        $postQuery = "INSERT INTO imports (int_id, sup_id, qty, price, total) VALUES(?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('sssss', $ingred_id, $sup_id, $ingred_qty, $ingred_price, $total);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Imported Success" && header("refresh:1; url=ingredients.php");
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
                            <form method="POST">
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Select Ingredient</label>
                                        <?php
                                        $ret = "SELECT * FROM  ingredients ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        ?>
                                        <select id="ingred_id" class="form-control" name="ingred_id">
                                            <?php
                                            while ($ingred = $res->fetch_object()) {
                                            ?>
                                                <option value="<?php echo $ingred->id; ?>"><?php echo $ingred->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <?php
                                        $ret = "SELECT * FROM suppliers";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        ?>
                                        <label>Supplier Name</label>
                                        <select name="sup_id" class="form-control" id="sup_id">
                                            <?php while ($supplier = $res->fetch_object()) { ?>
                                                <option value="<?php echo $supplier->id; ?>"><?php echo $supplier->name; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Qty</label>
                                        <input type="number" name="ingred_qty" class="form-control" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Unit Price</label>
                                        <input type="number" name="ingred_price" step="0.01" class="form-control" value="">
                                    </div>
                                    <hr>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="importIngredient" value="Add Ingredient" class="btn btn-success" value="">
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