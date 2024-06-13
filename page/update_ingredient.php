<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add Staff
if (isset($_POST['updateIngredient'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["name"]) || empty($_POST["qty"]) || empty($_POST['unit'])) {
        $err = "Black value can't be accepted!";
    } else {
        $name = $_POST['name'];
        $unit = $_POST['unit'];
        $qty = $_POST['qty'];
        $update = $_GET['update'];
        //Insert Captured information to a database table
        $postQuery = "UPDATE ingredients SET name =?, unit =?, qty =? WHERE id =?";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('ssss', $name, $unit, $qty, $update);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Ingredient Has Been Updated" && header("refresh:1; url=ingredients.php");
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
        $ret = "SELECT * FROM  ingredients WHERE id = '$update' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($ingred = $res->fetch_object()) {
        ?>
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
                                            <label>Ingredient Name</label>
                                            <input type="text" name="name" class="form-control" value="<?php echo $ingred->name; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Ingredient Unit</label>
                                            <input type="unit" name="unit" class="form-control" value="<?php echo $ingred->unit; ?>">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Ingredient Qty</label>
                                            <input type="number" name="qty" class="form-control" value="<?php echo $ingred->qty; ?>">
                                        </div>
                                        <hr>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <input type="submit" name="updateIngredient" value="Update Ingredient" class="btn btn-success" value="">
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
        <?php } ?>
    </div>
    <!-- Argon Scripts -->
    <?php
    require_once('partials/_scripts.php');
    ?>
</body>

</html>