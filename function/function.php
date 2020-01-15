<?php
	try
	{
	$dbh = new PDO('mysql:host=localhost;dbname=elearning', "root", ""); //mengkonaksikan dengan database
	
  	$dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	catch (PDOException $e) 
	{
		// tampilkan pesan kesalahan jika koneksi gagal
		echo "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
		die();
	}
	include 'validate.php';

	function updatedata($data) { //membuat fungsi update data untuk update data edit user
		global $dbh; //mengkoneksikan dengan database
		global $id_user; //mengambil session id_user

		$nama = htmlspecialchars($data["nama"]); //mengambil data nama user yang didapatkan dari input form
		$nomorinduk = htmlspecialchars($data["nomorinduk"]); //mengambil data nomor induk user yang didapatkan dari input form
		$email = htmlspecialchars($data["email"]); //mengambil data email user yang didapatkan dari input form
		$prodi = htmlspecialchars($data["prodi"]); //mengambil data prodi user yang didapatkan dari input form
		$fakultas = htmlspecialchars($data["fakultas"]); //mengambil data fakultas user yang didapatkan dari input form
		$pt = htmlspecialchars($data["pt"]); //mengambil data perguruan tinggi user yang didapatkan dari input form
		$gambarLama = htmlspecialchars($data["gambarLama"]); //mengambil data foto user yang saat ini sedang dipakai

		//cek apakah user pilih gambar baru atau tidak
		if ( $_FILES['foto']['error'] === 4 ) {
			$foto = $gambarLama; //jika tidak maka akan tetap menggunakan foto yang lama
		}
		else {
	 		$foto = upload(); //jika mengupload gambar baru akan menggunakan fungsi upload untuk upload gambar
		}

		try{
			$update = $dbh->prepare("UPDATE user SET NAMA = :nama, NOMORINDUK = :nomorinduk, E_MAIL = :email, PRODI = :prodi, FAKULTAS = :fakultas, PT = :pt, FOTO = :foto WHERE ID_USER = :id_user"); //query untuk mengupdate dat user
			$update->bindValue(':id_user', $id_user); 
			$update->bindValue(':nama', $nama);
			$update->bindValue(':nomorinduk', $nomorinduk);
			$update->bindValue(':email', $email);
			$update->bindValue(':prodi', $prodi);
			$update->bindValue(':fakultas', $fakultas);
			$update->bindValue(':pt', $pt);
			$update->bindValue(':foto', $foto);
			$update->execute(); //mengeksekusi query

			return 1; //pengecekan error
		} catch(PDOException $e) {
			return 0;}
	}

	function upload() { //membuat fungsi upload untuk upload foto profil user

		$namaFile = $_FILES['foto']['name'];
		$error = $_FILES['foto']['error'];
		$tmpName = $_FILES['foto']['tmp_name'];

		// cek apakah yang diupload adalah gambar
		$ekstensigambarValid = ['jpg', 'jpeg', 'png'];
		$ekstensiGambar = explode('.', $namaFile);
		$ekstensiGambar = strtolower(end($ekstensiGambar));
		if ( !in_array($ekstensiGambar, $ekstensigambarValid) ) {
			echo "<script>
					alert('yang anda upload bukan gambar');
				</script>";
			return false; 
		}

		//lolos pengecekan, gambar siap diupload
		move_uploaded_file($tmpName, 'asset/user/' . $namaFile);

		return $namaFile;
	}

	if( isset($_POST["update"]) ) { //pengecekan edit data berhasil atau error
		validateInputanAlfabetSpasi($errors, $_POST, 'nama');
		validateNomorInduk($errors, $_POST, 'nomorinduk');     
        validateEMail($errors, $_POST, 'email'); 
        validateInputanAlfabetSpasi($errors, $_POST, 'prodi');
        validateInputanAlfabetSpasi($errors, $_POST, 'fakultas');
        validateInputanAlfabetSpasi($errors, $_POST, 'pt');
        if (!$errors) {
        	if( updatedata($_POST) > 0 ) { 
			echo "
			<script>
			alert('data berhasil diubah!');
			document.location.href = './?page=profile';
			</script>
			"; 
			} else {
				echo "
				<script>
				alert('data gagal diubah!');
				document.location.href = './?page=profile';
				</script>
				";
			}
        }
	}

	function tambahkelasuser($data) { //membuat fungsi untuk menambahkan user ke kelas
		global $dbh; //mengkoneksikan ke database

		$kelas = htmlspecialchars($data["kelas"]); //mengambil data kelas dari database
		$user = htmlspecialchars($data["user"]); //mengambil data user dari database

		try{ 
			$insert = $dbh->prepare("INSERT INTO kelas_user (ID_KELAS_USER, ID_KELAS, ID_USER) values ('', :kelas, :user)"); //query untuk memasukkan user ke kelas
			$insert->bindValue(':kelas', $kelas);
			$insert->bindValue(':user', $user);
			$insert->execute(); //mengeksekusi query

			return 1; //pengecekan error
		} catch(PDOException $e) {
			return 0;}
	}

	if( isset($_POST["masuk"]) ) { //pengecekan fungsi menambahkan user ke kelas berhasil atau error
		if( tambahkelasuser($_POST) > 0 ) {
			echo "
			<script>
			alert('berhasil masuk kelas!');
			document.location.href = './?page=allClass';
			</script>
			"; 
		} else {
			echo "
			<script>
			alert('gagal masuk kelas!');
			document.location.href = './?page=allClass;
			</script>
			";
		}
	}

	function membuatkelas($data) { //fungsi membuat kelas
		global $dbh; //mengkoneksikan dengan database

		$namakelas = htmlspecialchars($data["namakelas"]); //mengambil data nama kelas dari form input
		$deskripsi = htmlspecialchars($data["deskripsikelas"]); //mengambil data deskripsi kelas dari form input
		$user = htmlspecialchars($data["user"]); //mengambil data user

		try{ 
			$insert = $dbh->prepare("INSERT INTO kelas (ID_KELAS, NAMA_KELAS, DESKRIPSI_KELAS) values ('', :namakelas, :deskripsikelas)"); //query untuk membuat kelas baru
			$insert->bindValue(':namakelas', $namakelas); 
			$insert->bindValue(':deskripsikelas', $deskripsi);
			$insert->execute(); //mengeksekusi query membuat kelas

			$insert2 = $dbh->prepare("INSERT INTO kelas_user (ID_KELAS_USER, ID_KELAS, ID_USER) values ('', (SELECT MAX(ID_KELAS) FROM kelas), :user)"); //query untuk memasukkan dosen ke kelas yang baru dibuat
			$insert2->bindValue(':user', $user);
			$insert2->execute(); //mengeksekusi query ke-2

			return 1; //pengecekan error
		} catch(PDOException $e) {
			return 0;}
	}

	if( isset($_POST["buatkelas"]) ) { //pengecekan fungsi membuatkelas berhasil atau error
		validateInputanAlfabetNomorSpasi($errors, $_POST, 'namakelas');
		validateInputanAlfabetNomorSpasi($errors, $_POST, 'deskripsikelas');     
        if (!$errors) {
        	if( membuatkelas($_POST) > 0 ) { 
			echo "
			<script>
			alert('berhasil membuat kelas!');
			document.location.href = './?page=allClass';
			</script>
			"; 
			} else {
				echo "
				<script>
				alert('gagal membuat kelas!');
				document.location.href = './?page=allClass';
				</script>
				";
			}
        }
	}

	function kirimmateri($data) { //fungsi untuk mengirim materi
		global $dbh; //mengkoneksikan dengan database
		global $id_user; //mengambil data session id_user
		global $id_kelas; //mengambil id_kelas yang didapatkan dari _GET

		$judulmateri = htmlspecialchars($data["judulmateri"]); //mengambil data dari form input
		$deskripsi = htmlspecialchars($data["deskripsimateri"]); //mengambil data dari textarea
		$filemateri = uploadmateri(); //memanggil fungsi uploadmateri untuk mengupload materi pdf/word/ppt/excel

		try{ 
			$post = $dbh->prepare("INSERT INTO materi (ID_MATERI, ID_KELAS, ID_USER, JUDUL_MATERI, DESKRIPSI_MATERI, LINK_MATERI) values ('', :idkelas, :iduser, :judulmateri, :deskripsimateri, :filemateri)"); //query untuk menambahkan data ke tabel materi (menambahkan post)
			$post->bindValue(':idkelas', $id_kelas);
			$post->bindValue(':iduser', $id_user);
			$post->bindValue(':judulmateri', $judulmateri);
			$post->bindValue(':deskripsimateri', $deskripsi);
			$post->bindValue(':filemateri', $filemateri);
			$post->execute(); //mengeksekusi query

			return 1; //pengecekan error
		} catch(PDOException $e) {
			return 0;}
	}

	function uploadmateri() { //fungsi untuk mengupload materi

		$namaFile = $_FILES['filemateri']['name'];
		$error = $_FILES['filemateri']['error'];
		$tmpName = $_FILES['filemateri']['tmp_name'];

		// cek apakah yang diupload adalah file pdf atau word atau ppt atau excel
		$ekstensiDokumenValid = ['pdf', 'docx', 'doc', 'pptx', 'ppt', 'xlsx', 'xls'];
		$ekstensiDokumen = explode('.', $namaFile);
		$ekstensiDokumen = strtolower(end($ekstensiDokumen));
		if ( !in_array($ekstensiDokumen, $ekstensiDokumenValid) ) {
			echo "<script>
					alert('yang anda upload bukan dokumen');
				</script>";
			return false; 
		}

		//lolos pengecekan, dokumen siap diupload
		move_uploaded_file($tmpName, 'materi/' . $namaFile);

		return $namaFile;
	}

	if( isset($_POST["postmateri"]) ) { //pengecekan funsgi kirimmateri berhasil atau error
		if( kirimmateri($_POST) > 0 ) {
			echo "
			<script>
			alert('berhasil mengirim materi!');
			document.location.href = './?page=class&id_kelas=".$id_kelas."';
			</script>
			"; 
		} else {
			echo "
			<script>
			alert('gagal mengirim materi!');
			document.location.href = './?page=class&id_kelas=".$id_kelas."';
			</script>
			";
		}
	}

	function updatekelas($data) { //fungsi untuk updatekelas
		global $dbh; //mengkoneksikan dengan database
		global $id_kelas; //mengambil dat id_kelas yang didapatkan dari _GET

		$namakelas = htmlspecialchars($data["namakelas"]); //mengambil data namakelas yang didapatkan dari form input
		$deskripsikelas = htmlspecialchars($data["deskripsikelas"]); //mengambil data deskripsi kelas yang berasal dari textarea

		try{
			$update = $dbh->prepare("UPDATE kelas SET NAMA_KELAS = :namakelas, DESKRIPSI_KELAS = :deskripsikelas WHERE ID_KELAS = :id_kelas"); //query untuk update data kelas
			$update->bindValue(':namakelas', $namakelas);
			$update->bindValue(':deskripsikelas', $deskripsikelas);
			$update->bindValue(':id_kelas', $id_kelas);
			$update->execute(); //mengeksekusi query

			return 1; //pengecekan error
		} catch(PDOException $e) {
			return 0;}
	}

	if( isset($_POST["editkelas"]) ) { //pengecekan fungsi editkelas berhasil atau error
		validateInputanAlfabetNomorSpasi($errors, $_POST, 'namakelas');
		validateInputanAlfabetNomorSpasi($errors, $_POST, 'deskripsikelas');     
        if (!$errors) {
        	if( updatekelas($_POST) > 0 ) { 
			echo "
			<script>
			alert('data kelas berhasil diubah!');
			document.location.href = './?page=allClass';
			</script>
			"; 
			} else {
				echo "
				<script>
				alert('data kelas gagal diubah!');
				document.location.href = './?page=allClass';
				</script>
				";
			}
        }
	}
?>