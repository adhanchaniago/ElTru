<?php
	session_start();
	include '../koneksi.php';
	$id_user = $_SESSION['id_user'];
	$id_kelas= $_GET['idClass'];
	$query=$dbh->prepare("DELETE FROM kelas_user where id_kelas=$id_kelas");
	$query->execute();
	
	$query2=$dbh->prepare("DELETE FROM kelas where id_kelas=$id_kelas");
	$query2->execute();

	header('location:../?page=allClass');
?>