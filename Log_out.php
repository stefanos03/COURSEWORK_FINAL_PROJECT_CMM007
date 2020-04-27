<?php
//logout Session here
	session_start();
	session_destroy();
	setcookie("username",'');
	setcookie("password",'');
	header("location:index.php");
?>