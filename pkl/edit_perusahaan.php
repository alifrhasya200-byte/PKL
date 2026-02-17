<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
require 'koneksi.php';

$id = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM perusahaan WHERE id='$id'");
if(mysqli_num_rows($result)==0){
    header("Location: perusahaan.php");
    exit();
}
$perusahaan = mysqli_fetch_assoc($result);

$active_menu = 'perusahaan';
$title = 'Edit Perusahaan';
ob_start();
?>
<div class="top-bar">
    <div class="page-title"><h2>Edit Perusahaan</h2></div>
</div>
<div class="card">
    <form action="proses_perusahaan.php" method="POST">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?php echo $perusahaan['id']; ?>">
        <div class="form-group"><label>Nama Perusahaan</label><input type="text" name="nama" class="form-control" value="<?php echo $perusahaan['nama_perusahaan']; ?>" required></div>
        <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control" required><?php echo $perusahaan['alamat']; ?></textarea></div>
        <div class="form-group"><label>Kota</label><input type="text" name="kota" class="form-control" value="<?php echo $perusahaan['kota']; ?>" required></div>
        <div class="form-group"><label>Telepon</label><input type="text" name="telepon" class="form-control" value="<?php echo $perusahaan['telepon']; ?>"></div>
        <button type="submit" class="btn-primary">Update</button>
        <a href="perusahaan.php" class="btn-primary" style="background:#4b5563;">Batal</a>
    </form>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>