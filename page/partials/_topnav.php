<?php
$userId = $_SESSION['userId'];
$role = $_SESSION['role'];
if ($role == 'admin') {
    $ret = "SELECT * FROM  admins  WHERE u_id = '$userId'";
} else if ($role == 'cashier' || $role == 'stocker') {
    $ret = "SELECT * FROM  employees  WHERE u_id = '$userId'";
} else {
    $ret = "SELECT * FROM  customers  WHERE u_id = '$userId'";
}
//$login_id = $_SESSION['login_id'];

$stmt = $mysqli->prepare($ret);
$stmt->execute();
$res = $stmt->get_result();
while ($user = $res->fetch_object()) {

?>
    <nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
        <div class="container-fluid">
            <!-- Brand -->
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="index.php"><?php echo $user->name; ?> Dashboard</a>
            <!-- User -->
            <ul class="navbar-nav align-items-center d-none d-md-flex">
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar rounded-circle">
                                <img style="width: 50px;height: 50px; object-fit:cover;" src="<?php echo ($user->photo == null) ? 'assets/img/theme/user-a-min.png' : $user->photo;; ?>">
                            </span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                <span class="mb-0 text-sm  font-weight-bold"><?php echo $user->name; ?></span>
                            </div>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <a href="change_profile.php" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>My profile</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?php } ?>