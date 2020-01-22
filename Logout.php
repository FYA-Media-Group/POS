<?php

	$pasttime = time() - 3600;
	
	setcookie("CookieAdminID","",$pasttime + (10 * 365 * 24 * 60 * 60));
	setcookie("CookieAdminFullName","",$pasttime + (10 * 365 * 24 * 60 * 60));
	setcookie("CookieAdminType","",$pasttime + (10 * 365 * 24 * 60 * 60));
	setcookie("CookieAdminUsername","",$pasttime + (10 * 365 * 24 * 60 * 60));

	session_start();
	session_unset();
	session_destroy();
	header('Location: ../admin/'); 
?>