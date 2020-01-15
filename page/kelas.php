<!-- daftar kelas yang diikuti -->
<div class="kelas-katalog">
  <?php if ($_SESSION['level'] == 1) { //pengecekan level, jika level = 1(dosen) maka akan menampilkan tombol Membuat kelas?> 
      <button class="button" id="myBtn">+ Membuat Kelas</button>  
  <?php } ?>
  <?php if ($_SESSION['level'] == 2) { //pengecekan level, jika level = 2(mahasiswa) maka akan menampilkan tombol Gabung kelas?>
      <button class="button" id="myBtn">+ Gabung Kelas</button>   
  <?php } ?>  
  <h2  class="class-title">Semua Kelas</h2>
  <hr class="lineContent-top">    
  <?php
    include "koneksi.php"; //mengkoneksikan dengan database
    include "function/function.php"; //memanggil function.php 
  	$id_user = $_SESSION['id_user']; //mengambil session id_user
  	$query = $dbh->prepare("SELECT * FROM kelas_user ku, kelas k where ku.id_user='".$id_user."' and ku.id_kelas=k.id_kelas LIMIT 6"); //mendeklarasikan query untuk menampilkan kelas yang diambil user
  	$query->execute(); //mengeksekusi query yang telah dideklarasikan
  	foreach ($query as $data){ //mengambil data query yang telah dieksekusi
      $kelas = $data['NAMA_KELAS'];
      if (strlen($kelas)>30){
          $kelas = substr($data['NAMA_KELAS'],0,30)."...";
      }
      else{
          $kelas = $data['NAMA_KELAS'];
      }

      if ($_SESSION['level']==2){
          //pengecekan session level, jika level = 2(mahasiswa) maka akan menampilkan tampilan berikut
          echo "
          <!-- card kelas -->
          <div class='class-card-katalog'>
              <img class='img-card-katalog' src='asset/icon.png' alt='img-card'>
              <hr class='line-katalog'>
              <hr class='line-katalog-left'>
              <h2 class='nameClass-katalog'>".$kelas."</h2>
              <div class='viewKelas'>
                  <a href='./?page=class&id_kelas=".$data['ID_KELAS']."'><p>Lihat Kelas</p></a>
              </div>
          </div>
      ";     
      }else{
          //pengecekan session level, jika level = 1(dosen) maka akan menampilkan tampilan berikut
          echo "
          <!-- card kelas -->
          <div class='class-card-katalog'>
              <img class='img-card-katalog' src='asset/icon.png' alt='img-card'>
              <hr class='line-katalog'>
              <hr class='line-katalog-left'>
              <h2 class='nameClass-katalog'>".$kelas."</h2>
              <div class='optKelas'>
                  <a href='./?page=class&id_kelas=".$data['ID_KELAS']."'><p class='viewClassTeacher'>Lihat Kelas</p></a>
                  <a href='./?page=editclass&id_kelas=".$data['ID_KELAS']."'><p class='editClassTeacher'>Edit Kelas</p></a>
                  <a href='function/deleteClass.php?idClass=".$data['ID_KELAS']."'><p class='deleteClassTeacher'>Hapus Kelas</p></a>
              </div>
          </div>
          ";
      }
    }
  ?>
</div>
<!-- paginasi halaman -->
<div class="page">
    <div class="pagination">
        <a href="#">&laquo;</a>
        <a href="#">1</a>
        <a class="active" href="#">2</a>
        <a href="#">3</a>
        <a href="#">4</a>
        <a href="#">5</a>
        <a href="#">6</a>
        <a href="#">&raquo;</a>
    </div>
</div>

<?php 
    $id_user = $_SESSION["id_user"];
    if ($_SESSION['level'] == 1) { //pengecekan session level, jika level user = 1(dosen), maka akan menampilkan modal membuat kelas ?>
    <!-- Modal Dosen (membuat kelas) -->
    <div id="myModal" class="modal">

      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2 style="margin: 30px">Buat Kelas</h2>
        </div>
        <div class="modal-body">
          <form action="?page=allClass" method="POST">
          <input type="hidden" name="user" value="<?php echo $id_user; ?>">
          <div class="row">
            <div class="column30">
              <label for="namakelas">Nama Kelas</label>
            </div>
            <div style="float: left;" class="column30">
              <input class="buatkelas" type="text" name="namakelas" id="namakelas" size="31"/>
              <?php if (isset($errors["namakelas"])) { echo '<span style="color:red;">'.$errors["namakelas"].'</span>'; }?>
            </div>
          </div>
          <div class="row">
            <div class="column30">
              <label for="deskripsikelas">Deskripsi Kelas</label>
            </div>  
            <div style="float: left;" class="column30">
              <textarea rows="5" style="width: 150%;" class="buatkelas" name="deskripsikelas" id="deskripsikelas"></textarea>
              <?php if (isset($errors["deskripsikelas"])) { echo '<span style="color:red;">'.$errors["deskripsikelas"].'</span>'; }?>
            </div>
          </div>
          <div class="row">
            <div class="column50">
              <input class="submit" type="submit" value="Tambah Kelas" name="buatkelas" />
              <input class="reset" type="reset" value="Reset" name="reset" />
            </div>
          </div>
          </form>
        </div>
      </div>

    </div>
    <?php } else { //pengecekan session level, jika level user = 2(mahasiswa), maka akan menampilkan modal gabug kelas?>
    <!-- Modal Mahasiswa (Gabung kelas)-->
    <div id="myModal" class="modal">
      <?php
        $id_user = $_SESSION["id_user"];
        $kelasuser = $dbh->prepare("SELECT ID_KELAS, NAMA_KELAS, (SELECT COUNT(ID_USER) FROM kelas_user ku WHERE k.ID_KELAS = ku.ID_KELAS and ku.ID_USER = '$id_user') as cek FROM kelas k");
        $kelasuser->execute();
      ?>
      <!-- Modal content -->
      <div class="modal-content">
        <div class="modal-header">
          <span class="close">&times;</span>
          <h2 style="margin: 30px">Gabung Kelas</h2>
        </div>
        <div class="modal-body">
          <?php foreach ($kelasuser as $ku) { ?>
          <div class="row">
            <div class="column60">
              <p><?php echo $ku['NAMA_KELAS']; ?></p>
            </div>
            <form action="?page=allClass" method="POST">
            <input type="hidden" name="kelas" value="<?php echo $ku['ID_KELAS']; ?>">
            <input type="hidden" name="user" value="<?php echo $id_user; ?>">
            <?php 
                if ($ku['cek'] == 1) { 
                    echo '<input type="submit" class="button" value="✓ Sudah Bergabung" disabled>';
                } else {
                    echo '<input type="submit" name="masuk" class="button" value="Gabung Kelas">';
                }
            ?>
            </form>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <?php } ?>
<script>
// Memanggil modal
var modal = document.getElementById("myModal");

// Memanggil button yang dapat membuka modal
var btn = document.getElementById("myBtn");

// Memanggil elemen <span> yang dapat menutup modal
var span = document.getElementsByClassName("close")[0];

// Ketika user mengklik tombolnya maka akan membuka modal
btn.onclick = function() {
  modal.style.display = "block";
}

// Ketika user mengklik <span> (x), modal akan menutup
span.onclick = function() {
  modal.style.display = "none";
}

// Ketika user mengklik area dimana saja diluar modal, maka modal akan menutup
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>