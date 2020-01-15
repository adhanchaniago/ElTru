<?php
	try
	{
	$dbh = new PDO('mysql:host=localhost;dbname=elearning', "root", ""); //mengkoneksikan dengan database
	
  	$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	catch (PDOException $e) 
	{
		// tampilkan pesan kesalahan jika koneksi gagal
		echo "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
		die();
	}
?>