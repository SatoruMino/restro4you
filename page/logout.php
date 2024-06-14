<?php
session_start();
unset($_SESSION['userId']);
unset($_SESSION['role']);
session_destroy();
header("Location: ../index.php");
exit;
