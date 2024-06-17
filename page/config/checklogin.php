<?php
function redirect_to($page)
{
	$host = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	header("Location: http://$host$uri/$page");
	exit();
}
function check_login()
{
	if (strlen($_SESSION['userId']) == 0) {
		redirect_to('../');
	}
}

function diss_allow_role($role)
{
	if (in_array(strtolower($_SESSION['role']), $role)) {
		redirect_to("index.php");
	}
}
