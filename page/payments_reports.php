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
                            Payment Reports
                        </div>
                        <div class="table-responsive">
                            <?php if ($role == 'admin' || $role == 'cashier') { ?>
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-success" scope="col">Payment Code</th>
                                            <th scope="col">Payment Method</th>
                                            <th scope="col">Amount Paid</th>
                                            <th class="text-success" scope="col">Date Paid</th>
                                        </tr>
                                    </thead><!-- For more projects: Visit codeastro.com  -->
                                    <tbody>
                                        <?php
                                        $ret = "SELECT * FROM  payments ORDER BY `paid_date` DESC ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($payment = $res->fetch_object()) {
                                        ?>
                                            <tr>
                                                <th class="text-success" scope="row">
                                                    <?php echo $payment->id; ?>
                                                </th>
                                                <th scope="row">
                                                    <?php echo $payment->method; ?>
                                                </th>

                                                <td>
                                                    $ <?php echo $payment->amount; ?>
                                                </td>
                                                <td class="text-success">
                                                    <?php echo date('d/M/Y g:i', strtotime($payment->paid_date)) ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody><!-- For more projects: Visit codeastro.com  -->
                                </table>
                                <?php } else if ($role == 'customer') {
                                $ret = "SELECT id FROM customers WHERE u_id = '$userId'";
                                $getmt = $mysqli->prepare("$ret");
                                $getmt->execute();
                                $res = $getmt->get_result();
                                if ($result = $res->fetch_assoc()) {
                                    $cust_id = $result['id'];  ?>
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-success" scope="col">Payment Code</th>
                                                <th scope="col">Payment Method</th>
                                                <th class="text-success" scope="col">Order Code</th>
                                                <th scope="col">Amount Paid</th>
                                                <th class="text-success" scope="col">Date Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT * FROM  payments WHERE cust_id ='$cust_id' ORDER BY `paid_date` DESC ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            while ($payment = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <th class="text-success" scope="row">
                                                        <?php echo $payment->id; ?>
                                                    </th>
                                                    <th scope="row">
                                                        <?php echo $payment->method; ?>
                                                    </th>
                                                    <td class="text-success">
                                                        <?php echo $payment->o_id; ?>
                                                    </td>
                                                    <td>
                                                        $ <?php echo $payment->amount; ?>
                                                    </td>
                                                    <td class="text-success">
                                                        <?php echo date('d/M/Y g:i', strtotime($payment->paid_date)) ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
                            <?php } ?>
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
<!-- For more projects: Visit codeastro.com  -->

</html>