<?php
function check_login()
{
	if ($_SESSION["adminId"] == "0") {
		header("Location: ../index.php");
	}
}
