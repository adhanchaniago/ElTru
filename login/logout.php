<?php 
	session_start(); //start session
	unset($_SESSION['login']); //unset session login
	header("Location: ../index.php"); //mengalihkan ke halaman login
	exit();
 ?>
