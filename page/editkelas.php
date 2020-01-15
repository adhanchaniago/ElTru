<?php
	if (!isset($_SESSION['login']))
	{
		//user akan diarahkan ke halam login jika user belum login
		header("Location: login/index.php");
	}
	$id_user = $_SESSION["id_user"]; //mengambil session id_user
	$id_kelas = $_GET["id_kelas"]; //mengambil id_kelas yang dikirim oleh halaman allClass
	include 'koneksi.php'; //mengkoneksikan ke database
	include 'function/function.php'; //memanggil function.php
	// Use the connection...
	$statement = $dbh->prepare("SELECT * FROM kelas WHERE ID_KELAS = '$id_kelas'"); //query sql yang dipakai untuk menampilkan data kelas
	$statement->execute(); //mengeksekusi query

?>
<?php foreach ($statement as $kelas) { ?> <!-- Mengambil isi dari query yang dieksekusi -->
	<div class="profileUser"> 
		<h1 style="text-align: center;">Edit Kelas</h1>
		<hr class="lineContent-top" style="margin-left: 470px; margin-top: 15px;">
		<form method="POST" enctype="multipart/form-data">
			<div class="profileDetail">
				<input type="text" name="namakelas" placeholder="Nama Kelas" class="form" value="<?php echo $kelas['NAMA_KELAS']; ?>"><br> <!--menampilkan nama kelas ke dalam input -->
				<?php if (isset($errors["namakelas"])) { echo '<span style="color:red;">'.$errors["namakelas"].'</span><br>'; }?>
				<textarea name="deskripsikelas" placeholder="Deskripsi Kelas" class="form"><?php echo $kelas['DESKRIPSI_KELAS']; ?></textarea><br> <!-- menampilkan deskripsi kelas ke dalam textarea -->
				<?php if (isset($errors["deskripsikelas"])) { echo '<span style="color:red;">'.$errors["deskripsikelas"].'</span><br>'; }?>
				<input type="submit" name="editkelas" value="Update" class="form"> <!-- tombol submit form -->
			</div>
		</form>
	</div>
<?php } ?>

		