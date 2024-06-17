<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
diss_allow_role(["cashier", "customer", "chef"]);
//Add Staff
if (isset($_POST['addIngredient'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["name"]) || empty($_POST['unit'])) {
        $err = "Black value can't be accepted!";
    } else {
        $code = $_POST['code'];
        $name = $_POST['name'];
        $unit = $_POST['unit'];
        //Insert Captured information to a database table
        $postQuery = "INSERT INTO ingredients (id, name, unit) VALUES(?, ?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('sss', $code, $name, $unit);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Ingredient Has Been Added" && header("refresh:1; url=ingredients.php");
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
                                    <input type="hidden" name="code" value="<?php echo 'ingred_' . $uniqueId; ?>">
                                    <div class="col-md-6">
                                        <label>Ingredient Name</label>
                                        <input type="text" name="name" class="form-control" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Ingredient Unit</label>
                                        <input type="unit" name="unit" class="form-control" value="">
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="addIngredient" value="Add Ingredient" class="btn btn-success" value="">
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