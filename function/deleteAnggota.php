<?php
	session_start();
	include '../koneksi.php';
	$id_user = $_SESSION['id_user'];
	$id_anggota= $_GET['idAnggota'];
	$id_kelas= $_GET['id_kelas'];
	$query=$dbh->prepare("DELETE FROM kelas_user where ID_USER=$id_anggota and ID_KELAS=$id_kelas");
	$query->execute();
	header('location:../?page=anggota&id_kelas='.$id_kelas);
?>