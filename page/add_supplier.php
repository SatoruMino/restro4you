<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
diss_allow_role(["customer", "cashier", "cashier"]);
//Add Staff
if (isset($_POST['addEmployee'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["sup_code"]) || empty($_POST["sup_name"]) || empty($_POST['sup_email']) || empty($_POST['sup_phone']) || empty($_POST['sup_address']) || empty($_POST['sup_company'])) {
        $err = "Blank Values Can't Be Accepted";
    } else {
        $sup_code = $_POST['sup_code'];
        $sup_name = $_POST['sup_name'];
        $sup_email = $_POST['sup_email'];
        $sup_phone = $_POST['sup_phone'];
        $sup_address = $_POST['sup_address'];
        $sup_company = $_POST['sup_company'];

        //Insert Captured information to a database table
        $postQuery = "INSERT INTO suppliers (id, name, email, phone, address, company) VALUES(?,?,?,?,?,?)";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('ssssss', $sup_code, $sup_name, $sup_email, $sup_phone, $sup_address, $sup_company);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Supplier Has Been Added" && header("refresh:1; url=suppliers.php");
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
                                    <input type="hidden" name="sup_code" class="form-control" value="<?php echo 'sup_' . $uniqueId; ?>">
                                    <div class="col-md-6">
                                        <label>Name</label>
                                        <input type="text" name="sup_name" class="form-control" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input type="email" name="sup_email" class="form-control" value="">
                                    </div>
                                    <hr>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                        <input type="phone" name="sup_phone" class="form-control" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Company</label>
                                        <input type="text" name="sup_company" class="form-control" value="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <label>Address</label>
                                        <textarea name="sup_address" class="form-control"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="form-row">
                                    <div class="col-md-6">
                                        <input type="submit" name="addEmployee" value="Add Supplier" class="btn btn-success" value="">
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