<?php
	if (!isset($_SESSION['login']))
	{
		//user akan diarahkan ke halam login jika user belum login
		header("Location: login/index.php"); 
	}
	$id_user = $_SESSION["id_user"]; //mengambil session id_user
	include 'koneksi.php'; //mengkoneksikan dengan database
	include 'function/function.php'; //memanggil function.php
	// Use the connection...
	$statement = $dbh->prepare("SELECT u.ID_USER, u.ID_LEVEL, u.USERNAME, u.E_MAIL, u.NAMA, u.FOTO, u.NOMORINDUK, u.PRODI, u.FAKULTAS, u.PT, l.NAMA_LEVEL
							FROM user as u, level as l
							WHERE u.ID_USER = '$id_user' and u.ID_LEVEL = l.ID_LEVEL"); //query untuk mengambil data user dari database
	$statement->execute(); //mengeksekusi query

?>
<?php foreach ($statement as $person) { ?> <!--mengambil data dari query yang telah dieksekusi -->
	<div class="profileUser">
		<h1 style="text-align: center;">Edit Profile</h1>
		<hr class="lineContent-top" style="margin-left: 470px; margin-top: 15px;">
		<form method="POST" enctype="multipart/form-data">
			<input type="hidden" name="gambarLama" value="<?php echo $person['FOTO']; ?>"> <!-- memasukkan data foto yang sekarang sedang dipakai ke dalam input hidden untuk memberikan kebebasan kepada user yang tidak ingin mengganti foto profilnya -->
			<div class="imgProfile">
				<img src="asset/user/<?php echo $person['FOTO']; ?>" alt="<?php echo $person['FOTO']; ?>"> <!-- mengambil data fot sekarang yang sedang dipakai -->
				<br>
				<input style="margin-top: 10px" type="file" name="foto" id="picture" />
			</div>
			<div class="profileDetail">
				<input type="text" name="nama" placeholder="Nama" class="form" value="<?php echo $person['NAMA']; ?>"><br>
				<!-- mengambil data nama user untuk ditampilkan di form input -->
				<?php if (isset($errors["nama"])) { echo '<span style="color:red;">'.$errors["nama"].'</span><br>'; }?> 
				<input type="text" name="nomorinduk" placeholder="Nomor Induk" class="form" value="<?php echo $person['NOMORINDUK']; ?>"><br> <!-- mengambil data nomor induk user untuk ditampilkan di form input -->
				<?php if (isset($errors["nomorinduk"])) { echo '<span style="color:red;">'.$errors["nomorinduk"].'</span><br>'; }?>
				<input type="text" name="email" placeholder="E-Mail" class="form" value="<?php echo $person['E_MAIL']; ?>"><br>
				<!-- mengambil data email user untuk ditampilkan di form input -->
				<?php if (isset($errors["email"])) { echo '<span style="color:red;">'.$errors["email"].'</span><br>'; }?>
				<input type="text" name="prodi" placeholder="Program Studi" class="form" value="<?php echo $person['PRODI']; ?>"><br> <!-- mengambil data prodi user untuk ditampilkan di form input -->
				<?php if (isset($errors["prodi"])) { echo '<span style="color:red;">'.$errors["prodi"].'</span><br>'; }?>
				<input type="text" name="fakultas" placeholder="Fakultas" class="form" value="<?php echo $person['FAKULTAS']; ?>"><br> <!-- mengambil data fakultas user untuk ditampilkan di form input -->
				<?php if (isset($errors["fakultas"])) { echo '<span style="color:red;">'.$errors["fakultas"].'</span><br>'; }?>
				<input type="text" name="pt" placeholder="Universitas" class="form" value="<?php echo $person['PT']; ?>"><br> <!-- mengambil data universitas user untuk ditampilkan di form input -->
				<?php if (isset($errors["pt"])) { echo '<span style="color:red;">'.$errors["pt"].'</span><br>'; }?>
				<input type="submit" name="update" value="Update" class="form"> <!-- tombol untuk mengirim pembaruan data ke database -->
			</div>
		</form>
	</div>
<?php } ?>

		