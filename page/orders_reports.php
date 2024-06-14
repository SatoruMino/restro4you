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
                            Orders Records
                        </div><!-- For more projects: Visit codeastro.com  -->
                        <?php if ($role == 'admin' || $role == 'cashier') {
                        ?>
                            <div class="table-responsive">
                                <table class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-success" scope="col">Code</th>
                                            <th scope="col">Customer</th>
                                            <th class="text-success" scope="col">Product</th>
                                            <th scope="col">Unit Price</th>
                                            <th class="text-success" scope="col">#</th>
                                            <th scope="col">Total Price</th>
                                            <th scop="col">Status</th>
                                            <th scope="col">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = "SELECT o.*, c.name AS cust_name, p.name AS prod_name FROM orders o INNER JOIN
                                                customers c ON o.cust_id = c.id INNER JOIN 
                                                products p ON o.p_id = p.id ORDER BY `order_date` DESC  ";
                                        $stmt = $mysqli->prepare($ret);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while ($order = $res->fetch_object()) {
                                        ?>
                                            <tr>
                                                <th class="text-success" scope="row"><?php echo $order->id; ?></th>
                                                <td><?php echo $order->cust_name; ?></td>
                                                <td class="text-success"><?php echo $order->prod_name; ?></td>
                                                <td>$ <?php echo $order->price; ?></td>
                                                <td class="text-success"><?php echo $order->qty; ?></td>
                                                <td>$ <?php echo $order->total; ?></td>
                                                <td><?php if ($order->order_status == '') {
                                                        echo "<span class='badge badge-danger'>Not Paid</span>";
                                                    } else {
                                                        echo "<span class='badge badge-success'>$order->order_status</span>";
                                                    } ?></td>
                                                <td><?php echo date('d/M/Y g:i', strtotime($order->order_date)); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php } else if ($role == 'customer') {
                            $ret = "SELECT id FROM customers WHERE u_id = '$userId'";
                            $getmt = $mysqli->prepare("$ret");
                            $getmt->execute();
                            $res = $getmt->get_result();
                            if ($result = $res->fetch_assoc()) {
                                $cust_id = $result['id'];  ?>
                                <div class="table-responsive">
                                    <table class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-success" scope="col">Code</th>
                                                <th scope="col">Customer</th>
                                                <th class="text-success" scope="col">Product</th>
                                                <th scope="col">Unit Price</th>
                                                <th class="text-success" scope="col">#</th>
                                                <th scope="col">Total Price</th>
                                                <th scop="col">Status</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = "SELECT o.*, p.name AS prod_name, c.name AS cust_name FROM orders o INNER JOIN
                                                    products p ON o.p_id = p.id INNER JOIN customers c ON
                                                    o.cust_id = c.id WHERE cust_id ='$cust_id' ORDER BY `order_date` DESC  ";
                                            $stmt = $mysqli->prepare($ret);
                                            $stmt->execute();
                                            $res = $stmt->get_result();
                                            while ($order = $res->fetch_object()) {
                                            ?>
                                                <tr>
                                                    <th class="text-success" scope="row"><?php echo $order->id; ?></th>
                                                    <td><?php echo $order->cust_name; ?></td>
                                                    <td class="text-success"><?php echo $order->prod_name; ?></td>
                                                    <td>$ <?php echo $order->price; ?></td>
                                                    <td class="text-success"><?php echo $order->qty; ?></td>
                                                    <td>$ <?php echo $order->total; ?></td>
                                                    <td><?php if ($order->order_status == '') {
                                                            echo "<span class='badge badge-danger'>Not Paid</span>";
                                                        } else {
                                                            echo "<span class='badge badge-success'>$order->order_status</span>";
                                                        } ?></td>
                                                    <td class="text-success"><?php echo date('d/M/Y g:i', strtotime($order->order_date)); ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                        <?php } ?>
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