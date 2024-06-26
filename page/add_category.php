<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
diss_allow_role(['cashier', 'cashier', 'chef', 'customer']);
//Add Staff
if (isset($_POST['addCategory'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["category_code"]) || empty($_POST["category_name"])) {
        $err = "Black value can't be accepted!";
    } else {
        $category_code = $_POST['category_code'];
        $category_name = $_POST['category_name'];
        //Insert Captured information to a database table
        $postQuery = "INSERT INTO category (id, name) VALUES(?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('ss', $category_code, $category_name);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Category Has Been Added" && header("refresh:1; url=category.php");
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
                                    <input type="hidden" name="category_code" class="form-control" value="<?php echo 'cate_' . $uniqueId; ?>">
                                    <div class="col-md-6">
                                        <label>Category Name</label>
                                        <input type="text" name="category_name" class="form-control" value="">
                                    </div>
                                    <hr>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="addCategory" value="Add Category" class="btn btn-success" value="">
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