<?php
    if (!isset($_SESSION['login']))
    {
      //user akan diarahkan ke halam login jika user belum login
      header("Location: login/index.php");
    }
    $id_user = $_SESSION['id_user'];
    $id_kelas = $_GET['id_kelas'];
    include 'koneksi.php';
    include 'function/function.php';
    $query = $dbh->prepare("SELECT * FROM kelas_user ku, kelas k where ku.id_user='".$id_user."' and k.id_kelas='".$id_kelas."' and ku.id_kelas='".$id_kelas."' " );
    $query->execute();

    $queryposting = $dbh->prepare("SELECT u.NAMA, u.FOTO, m.JUDUL_MATERI, m.DESKRIPSI_MATERI, m.LINK_MATERI, k.NAMA_KELAS FROM materi m, user u, kelas k where m.ID_KELAS= '$id_kelas' and m.ID_KELAS = k.ID_KELAS and m.ID_USER = u.ID_USER order by m.ID_MATERI DESC ");
    $queryposting->execute();

    $user = $dbh->prepare("SELECT * FROM user WHERE ID_USER = '$id_user'");
    $user->execute();
?>



<div class="grid-container">
  <div class="item2">
    <div class="daftar-menu">
        <div class="clikbutton">
                <a href='./?page=class&id_kelas=<?php echo $id_kelas; ?>'>Kelas Detail</a>
                <a href='./?page=anggota&id_kelas=<?php echo $id_kelas; ?>'>Anggota</a>
        </div>
    </div>
  </div>
  <div class="item3">
    <div class="home-kelas">
          <?php
          foreach ($query as $data) {
            echo "
              <div class='class-detail'>
                <div class='isi-detail'>
                    <h2>".$data['NAMA_KELAS']."</h2>
                    <p>".$data['DESKRIPSI_KELAS']."</p>
                </div>
              </div>
            ";
          }
            
          ?>
          
    <?php
      if ($_SESSION['level']==1) { ?>
      <form method="POST" enctype="multipart/form-data">
        <div class='create-post-element'>
          <div class='create-post'>
            <div class='foto'>
              <?php foreach ($user as $profile) { ?>
                <img src='asset/user/<?php echo $profile['FOTO']; ?>' alt='fotoprofile'>
              <?php } ?>
            </div>
              <div class='inputandbutton'>
                <div class='textpost'>
                  <h4>Judul</h4>
                  <input type='text' name='judulmateri'>
                  <h4>Deskripsi</h4>
                  <textarea name='deskripsimateri'></textarea>
                </div>
                <div>
                  <input type='file' name='filemateri' size='31' id='berkas'>
                </div>
                <div class='clikbutton'>
                  <input type='submit' name='postmateri' class='formpostbutton' value='Post'>
                </div>
              </div>
          </div>
        </div>
      </form>
    <?php } else {
            echo "";
          }
    ?>

    <?php
      foreach ($queryposting as $posting) {
        # code...
      echo "
      <div class='post-element' style='margin: 20px;'>
        <div class='isi-post'>
          <div class='foto'>
            <img src='asset/user/".$posting['FOTO']."' alt='fotokecil'>
          </div>
          <div class='detail-post'>
            <h3>".$posting['NAMA']." &#10147; ".$posting['NAMA_KELAS']."</h3>
            <h4>".$posting['JUDUL_MATERI']."</h4>
            <p>".$posting['DESKRIPSI_MATERI']."</p>
            <img src='asset/pdf.png' style='width:25px; height:25px' alt='filepdf'>
            <a href='materi/".rawurlencode($posting['LINK_MATERI'])."'>".$posting['LINK_MATERI']."</a>
          </div>
          <div>
          </div>
        </div>
      </div>
      ";
      }

    ?>
    </div>
  </div>  
</div>