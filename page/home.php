<!-- berisi kontent atas sebelah kiri -->
<div class="content-top">
	<div class="top-left">
		<div class="content-topLeft">
			<h1 style="font-size: 45px;">E-Learning Trunojoyo</h1>
			<h3>Belajar Bersama, dan Berprestasi</h3><br>
			<hr class="lineContent-top">
			<ul style="margin-left: 20px; margin-top: 20px;">
				<li style="font-size: 20px">Bergabung dengan kelas</li>
				<li style="font-size: 20px">Pelajari materi</li>
				<li style="font-size: 20px">Kerjakan latihan dan tugas</li>
				<li style="font-size: 20px">Raih prestasi</li>
			</ul>
		</div>
	</div>
	<div class="top-right">
		<img class="img-contentTop" src="asset/person1.png" alt="user">
	</div>
</div>
<!-- berisi eberapa kelas user  -->
<div class="kelas">
	<h2 class="class-title">Kelas Saya</h2>
	<hr class="lineContent-top">
	<?php
		include "koneksi.php";
		$id_user = $_SESSION['id_user'];
		$query = $dbh->prepare("SELECT * FROM kelas_user ku, kelas k where ku.id_user='".$id_user."' and ku.id_kelas=k.id_kelas LIMIT 5");
		$query->execute();
		foreach ($query as $data){
			echo "
			<div class='class-card'>
				<img class='img-card' src='asset/icon.png' alt='img-card'>
				<hr class='line-card1'>
				<p class='class-name'>
					".$data['NAMA_KELAS']."
				</p>
				<hr class='line-card2'>
				
			</div>
			";
		}
	?>
	<!-- tombol untuk menampilkan semua kelas -->
	<div class="viewAllClass">
		<a href="./?page=allClass"><p>Tampilkan Semua Kelas >></p></a>
	</div>
</div>
<!-- konten paling bawah berisi penjelasn platform -->
<div class="content-platform">
	<div class="platform-left">
		<p class="platform-detail">Platform pembelajaran terbaik untuk <span>meraih prestasi, motifasi belajar, dan informasi prestasi</span> Mahasiswa Universitas Trunojoyo Madura</p>
		<hr class="lineContent-top">
	</div>
	<!-- logo -->
		<img class="logoInstitusi" src="asset/kemendikbud.png" alt="kemendikbud">
		<img class="logoInstitusi" src="asset/utm1.png" alt="logo">	
</div>