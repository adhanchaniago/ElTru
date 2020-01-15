<?php
    include 'koneksi.php';
    $id_user = $_SESSION['id_user'];
    $id_kelas = $_GET['id_kelas'];
    $query = $dbh->prepare("SELECT * FROM kelas_user ku, kelas k where ku.id_user='".$id_user."' and k.id_kelas='".$id_kelas."' and ku.id_kelas='".$id_kelas."' " );
    $query->execute();

    $queryAnggota = $dbh->prepare("SELECT * FROM kelas_user ku, kelas k where ku.id_user='".$id_user."' and k.id_kelas='".$id_kelas."' and ku.id_kelas='".$id_kelas."' " );
    $queryAnggota->execute();
?>

<?php
    include 'koneksi.php';
    $id_user = $_SESSION['id_user'];
    $id_kelas = $_GET['id_kelas'];
    $queryNama = $dbh->prepare("SELECT user.NAMA, k.ID_KELAS, ku.ID_KELAS, ku.ID_USER, user.NOMORINDUK  FROM level, user, kelas_user ku, kelas k where k.id_kelas='".$id_kelas."' and ku.ID_KELAS='".$id_kelas."' AND ku.ID_USER=user.ID_USER AND user.ID_LEVEL=2 AND level.ID_LEVEL=2" );
    $queryNama->execute();
?>

<div class="grid-container">
  <div class="item2">
    <div class="daftar-menu">
        <div class="clikbutton">
          <?php
          foreach ($query as $data){
               echo "<a href='./?page=class&id_kelas=".$id_kelas."'>Kelas Detail</a>
            ";
          }
          ?>
          <?php
          foreach ($queryAnggota as $data){
               echo "<a href='./?page=anggota&id_kelas=".$id_kelas."'>Anggota</a>
            ";
          }
          ?>
        </div>
    </div>
  </div>
  <div class="item3">
    <div class="judulfl">
      <h2>Anggota Kelas</h2>
    </div>
        <div class="tabel-anggota">
          <?php
          if ($_SESSION['level']==1){
                echo "
                    <div class='baris-1-anggota'>
                      <h3 class='nama-tabel'>Nama</h3>
                      <h3 class='action-tabel'>Action</h3>
                    </div>
                ";
              }
          if ($_SESSION['level']==2){
                echo "
                    <div class='baris-1-anggota'>
                      <h3 class='nama-tabel'>Nama</h3>
                      <h3 class='NIM-tabel'>NIM</h3>
                    </div>
                ";
              }
            ?>
            <?php
            foreach ($queryNama as $data){
              if ($_SESSION['level']==1){
                  echo "
                  <div class='baris-2-anggota'>
                    <p class='p-nama'>".$data['NAMA']."</p>
                    <a href='function/deleteAnggota.php?id_kelas=".$data['ID_KELAS']."&idAnggota=".$data['ID_USER']."'>Delete</a>
                  </div>
                  ";
                }
              if ($_SESSION['level']==2){
                  echo "
                  <div class='baris-2-anggota'>
                    <p class='p-nama'>".$data['NAMA']."</p>
                    <p class='p-nama'>".$data['NOMORINDUK']."</p>
                  </div>
                  ";
                }
              }
            ?>
        </div>
    </div>
</div>