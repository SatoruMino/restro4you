<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
//Add Customer
if (isset($_POST['updatePosition'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["position_code"]) || empty($_POST["position_name"])) {
        $err = "Blank Value Can't Be Accepted";
    } else {
        $position_code = $_POST['position_code'];
        $position_name = $_POST['position_name']; //Hash This 
        $update = $_GET['update'];
        //Insert Captured information to a database table
        $postQuery = "UPDATE positions SET id =?, name =? WHERE id =?";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('sss', $position_code, $position_name, $update);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Position Updated" && header("refresh:1; url=positions.php");
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
        $ret = "SELECT * FROM  positions WHERE id = '$update' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($position = $res->fetch_object()) {
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
                                            <label>Position Code</label>
                                            <input type="text" name="position_code" value="<?php echo $position->id; ?>" class="form-control">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Position Name</label>
                                            <input type="text" name="position_name" value="<?php echo $position->name; ?>" class="form-control" value="">
                                        </div>
                                    </div>

                                    <br>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <input type="submit" name="updatePosition" value="Update Position" class="btn btn-success" value="">
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