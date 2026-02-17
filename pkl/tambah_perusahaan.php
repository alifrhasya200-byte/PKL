<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
$active_menu = 'perusahaan';
$title = 'Tambah Perusahaan';
ob_start();
?>
<div class="top-bar">
    <div class="page-title"><h2>Tambah Perusahaan</h2></div>
</div>
<div class="card">
    <form action="proses_perusahaan.php" method="POST">
        <input type="hidden" name="action" value="tambah">
        <div class="form-group"><label>Nama Perusahaan</label><input type="text" name="nama" class="form-control" required></div>
        <div class="form-group"><label>Alamat</label><textarea name="alamat" class="form-control" required></textarea></div>
        <div class="form-group"><label>Kota</label><input type="text" name="kota" class="form-control" required></div>
        <div class="form-group"><label>Telepon</label><input type="text" name="telepon" class="form-control"></div>
        <button type="submit" class="btn-primary">Simpan</button>
        <a href="perusahaan.php" class="btn-primary" style="background:#4b5563;">Batal</a>
    </form>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>