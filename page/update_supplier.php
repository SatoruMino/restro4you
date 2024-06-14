<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
include('config/code-generator.php');

check_login();
diss_allow_role(["customer", "cashier", "chef"]);
//Udpate Staff
if (isset($_POST['updateSupplier'])) {
    //Prevent Posting Blank Values
    if (empty($_POST["sup_code"]) || empty($_POST["sup_name"]) || empty($_POST['sup_email']) || empty($_POST['sup_phone']) || empty($_POST['sup_address']) || empty($_POST['sup_company'])) {
        $err = "Blank Values Can't Be Accepted";
    } else {
        $update = $_GET['update'];
        $sup_code = $_POST['sup_code'];
        $sup_name = $_POST['sup_name'];
        $sup_email = $_POST['sup_email'];
        $sup_phone = $_POST['sup_phone'];
        $sup_address = $_POST['sup_address'];
        $sup_company = $_POST['sup_company'];

        //Insert Captured information to a database table
        $postQuery = "UPDATE suppliers SET  id =?, name =?, email =?, phone =?, address =?, company=? WHERE id =?";
        $postStmt = $mysqli->prepare($postQuery);
        //bind paramaters
        $rc = $postStmt->bind_param('ssssssi', $sup_code, $sup_name, $sup_email, $sup_phone, $sup_address, $sup_company, $update);
        $postStmt->execute();
        //declare a varible which will be passed to alert function
        if ($postStmt) {
            $success = "Suppliers Has Been Updated" && header("refresh:1; url=suppliers.php");
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
        $ret = "SELECT * FROM  suppliers WHERE id = '$update' ";
        $stmt = $mysqli->prepare($ret);
        $stmt->execute();
        $res = $stmt->get_result();
        while ($sup = $res->fetch_object()) {
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
                                <h3>Edit Supplier Information</h3>
                            </div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Code</label>
                                            <input type="text" name="sup_code" class="form-control" value="<?php echo $sup->id; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Name</label>
                                            <input type="text" name="sup_name" class="form-control" value="<?php echo $sup->name; ?>">
                                        </div>
                                        <hr>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Email</label>
                                            <input type="email" name="sup_email" class="form-control" value="<?php echo $sup->email; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Phone</label>
                                            <input type="phone" name="sup_phone" class="form-control" value="<?php echo $sup->phone; ?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <label>Company</label>
                                            <input type="text" name="sup_company" class="form-control" value="<?php echo $sup->company; ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label>Address</label>
                                            <textarea name="sup_address" class="form-control"><?php echo $sup->address; ?></textarea>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <input type="submit" name="updateSupplier" value="Update Employee" class="btn btn-success" value="">
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