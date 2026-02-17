<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
require 'koneksi.php';
$perusahaan = mysqli_query($conn, "SELECT * FROM perusahaan ORDER BY id DESC");
$active_menu = 'perusahaan';
$title = 'Perusahaan';
ob_start();
?>
<div class="top-bar">
    <div class="page-title"><h2>Data Perusahaan</h2><p>Tempat pelaksanaan PKL</p></div>
    <a href="tambah_perusahaan.php" class="btn-primary">+ Tambah Perusahaan</a>
</div>
<div class="card">
    <table>
        <tr><th>Nama Perusahaan</th><th>Alamat</th><th>Kota</th><th>Telepon</th><th>Aksi</th></tr>
        <?php while($row=mysqli_fetch_assoc($perusahaan)): ?>
        <tr>
            <td><?php echo $row['nama_perusahaan']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td><?php echo $row['kota']; ?></td>
            <td><?php echo $row['telepon']; ?></td>
            <td>
                <a href="edit_perusahaan.php?id=<?php echo $row['id']; ?>" style="color:#3b49df;">Edit</a>
                <a href="hapus_perusahaan.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Yakin hapus?')" style="color:#ef4444; margin-left:10px;">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>