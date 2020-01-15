<?php
	$levelUser = $_SESSION['level']; //mengambil session level
	$idUser = $_SESSION['id_user'];	//mengambil session id_user
	include "koneksi.php"; //mengkoneksikan dengan database
	$query= $dbh->prepare("SELECT * FROM user u,level l WHERE u.ID_USER=$idUser and u.ID_LEVEL = $levelUser and u.ID_LEVEL = l.ID_LEVEL"); //query untuk mengambil data user
	$query->execute(); //mengeksekusi query

?>
<?php foreach ($query as $data) { //mengambil data dari query yang telah dieksekusi?>
<!-- halaman profile -->
<div class="profileUser">
	<h1 style="text-align: center;">Edit Profile</h1>
	<hr class="lineContent-top" style="margin-left: 470px; margin-top: 15px;">
	<div class="imgProfile">
		<img src="asset/user/<?php echo $data['FOTO'] ?>" alt="<?php echo $data['FOTO'] ?>">
		<a href="./?page=editProfile" id="aButton"><div class="editButton"><p>Edit Profile</p></div></a>
	</div>
	<!-- detail profile user -->
	<div class="profileDetail">
		<p style='font-size: 25px;'><?php echo $data['NAMA']," ",$data['NOMORINDUK'] ?></p>
		<p style='color: #8A8686'><?php echo $data['NAMA_LEVEL'] ?></p>
		<p><?php echo $data['PRODI']," ,"," Fakultas ",$data['FAKULTAS'] ?></p>
		<p><?php echo $data['PT'] ?></p>
		<p><?php echo $data['E_MAIL'] ?></p>
	</div>
</div>
<?php } ?>