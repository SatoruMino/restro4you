<?php
function check_login()
{
	if ($_SESSION["userId"] == "0") {
		header("Location: ../index.php");
	}
}
