<?php
session_start();
include('config/config.php');
include('config/checklogin.php');
check_login();
require_once('partials/_head.php');
?>

<body>
    <!-- Sidenav --><!-- For more projects: Visit codeastro.com  -->
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
                            Import Records
                        </div><!-- For more projects: Visit codeastro.com  -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-success" scope="col">Code</th>
                                        <th scope="col">Supplier</th>
                                        <th class="text-success" scope="col">Ingredient</th>
                                        <th scope="col">Unit Price</th>
                                        <th class="text-success" scope="col">Quantity</th>
                                        <th scope="col">Total Price</th>
                                        <th scope="col">Import Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ret = "SELECT imp.*, s.name AS sup_name, i.name AS ingred_name FROM
                                            imports imp INNER JOIN suppliers s ON imp.sup_id = s.id INNER JOIN
                                            ingredients i ON imp.int_id = i.id
                                    ";
                                    $stmt = $mysqli->prepare($ret);
                                    $stmt->execute();
                                    $res = $stmt->get_result();
                                    while ($import = $res->fetch_object()) {
                                    ?>
                                        <tr>
                                            <th class="text-success" scope="row"><?php echo $import->id; ?></th>
                                            <td><?php echo $import->sup_name; ?></td>
                                            <td class="text-success"><?php echo $import->ingred_name; ?></td>
                                            <td>$ <?php echo $import->price; ?></td>
                                            <td class="text-success"><?php echo $import->qty; ?></td>
                                            <td>$ <?php echo $import->total; ?></td>
                                            <td><?php echo date('d/M/Y g:i', strtotime($import->import_date)); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
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
</body>
<!-- For more projects: Visit codeastro.com  -->

</html>