<?php
	session_start();
	if (!isset($_SESSION['login']))
	{
		//user akan diarahkan ke halam login jika user belum login
		header("Location: login/index.php");
	}

	$id_user = $_SESSION['id_user']; //mengambil session id_user
	include 'koneksi.php'; //mengkoneksikan dengan database
	$query = $dbh->prepare("SELECT * FROM user WHERE ID_USER=".$id_user.""); //query untuk mengambil data user
	$query->execute(); //mengeksekusi query

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>el-Tru</title>
		<link rel="shortcut icon" href="asset/icon.png">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>
	<body>
		<div class="header">
			<!-- header yang berisi menu, tombol search dan foto profil user -->
			<div class="menu">
                <div class="icon">
					<img class="img-icon" src="asset/logo.png" alt="logo">
				</div>
				<div class="menuAndSearch">
					<?php foreach ($query as $data) { //mengeksekusi data yang berasal dari query yang telah dieksekusi?>
					<div class="userIcon">

		                <?php 
			                echo "<img class='img-profile' src='asset/user/".$data['FOTO']."' alt='profile'>";	                
		                ?>
		                <div class="option-userIcon">
		                    <a href="./?page=profile">Profile</a>
		                    <a href="login/logout.php">Logout</a>
		                </div>
		            	<?php } ?>
		            </div>
					<div class="search">
						<form class="form-search" action="/action_page.php">
				    		<input class="search-box" type="text" placeholder="Search.." name="search">
				    		<button class="btnSearch" type="submit">Search</button>
				    	</form>
					</div>
					<ul class="menu-btn">
						<li><a href="#">Pesan</a></li>
						<li><a href="#">Tugas</a></li>
						<li><a href="./?page=allClass">Kelas</a></li>
                        <li><a href="./?page=home">Home</a></li>
                        
					</ul>	
				</div>
			</div>	
        </div>
        
        <?php
        if (isset($_GET['page'])){ //mengamil data page dari parameter _GET
            $page = $_GET['page'];
            switch ($page)
                {
                    case 'home': //jika page=home maka akan menambahkan home.php ke index.php ini
                        include 'page/home.php';
                        break;
                    case 'allClass': //jika page=allClass maka akan menambahkan kelas.php ke index.php ini
                        include 'page/kelas.php';
                        break;
                    case 'profile': //jika page=profile maka akan menambahkan profile.php ke index.php ini
                        include 'page/profile.php';
                        break;
                    case 'class': //jika page=class maka akan menambahkan kelaspost.php ke index.php ini
                        include 'page/kelaspost.php';
                        break;
                    case 'editProfile': //jika page=editProfile maka akan menambahkan editProfile.php ke index.php ini
                        include 'page/editProfile.php';
                        break;
                    case 'editclass': //jika page=editclass maka akan menambahkan editkelas.php ke index.php ini
                        include 'page/editkelas.php';
                        break;
                    case 'anggota': //jika page=anggota maka akan menambahkan anggotamenu.php ke index.php ini
                        include 'page/anggotamenu.php';
                        break;
                    default:
                        echo "<p style='text-align:center;'>maaf halaman tidak ditemukan</p>"; //jika page tidak ditemukan page yag dimaksud maka akan menampilkan pesan error ini
                }       
            }else{
                include 'page/home.php'; //jika tidak ada argumen ?page= maka akan secara default include home.php
            }

        ?>
		<div class="footer"> <!-- footer halaman -->
			<p>Copyright © 2019 el-Tru<br> All rights reserved</p>
		</div>
	</body>
</html>