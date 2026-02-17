<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
require 'koneksi.php';
$user_id = $_SESSION['user_id'];
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM laporan WHERE user_id='$user_id'"))['c'];
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM laporan WHERE user_id='$user_id' AND status='pending'"))['c'];
$approved = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM laporan WHERE user_id='$user_id' AND status='disetujui'"))['c'];
$laporan = mysqli_query($conn, "SELECT * FROM laporan WHERE user_id='$user_id' ORDER BY tanggal DESC LIMIT 5");
$active_menu = 'dashboard';
$title = 'Dashboard';
ob_start();
?>
<div class="top-bar">
    <div class="page-title"><h2>Halo, <?php echo $_SESSION['nama']; ?> 👋</h2><p>Semangat mencatat kegiatan PKL</p></div>
    <div class="date-badge"><?php echo date('l, d F Y'); ?></div>
</div>
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:25px; margin-bottom:30px;">
    <div class="card" style="text-align:center;"><h3 style="font-size:38px;"><?php echo $total; ?></h3><p>Total Laporan</p></div>
    <div class="card" style="text-align:center;"><h3 style="font-size:38px;"><?php echo $pending; ?></h3><p>Pending</p></div>
    <div class="card" style="text-align:center;"><h3 style="font-size:38px;"><?php echo $approved; ?></h3><p>Disetujui</p></div>
</div>
<div class="card">
    <h3 style="margin-bottom:20px;">➕ Buat Laporan Baru</h3>
    <form action="simpan_laporan.php" method="POST">
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px;">
            <div class="form-group"><label>Tanggal</label><input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d'); ?>" required></div>
            <div class="form-group"><label>Jam Masuk</label><input type="time" name="jam_masuk" class="form-control" required></div>
            <div class="form-group"><label>Jam Pulang</label><input type="time" name="jam_pulang" class="form-control" required></div>
        </div>
        <div class="form-group"><label>Kegiatan</label><textarea name="kegiatan" class="form-control" required></textarea></div>
        <div class="form-group"><label>Kendala (opsional)</label><textarea name="kendala" class="form-control"></textarea></div>
        <div class="form-group"><label>Solusi (opsional)</label><textarea name="solusi" class="form-control"></textarea></div>
        <button type="submit" class="btn-primary">Simpan Laporan</button>
    </form>
</div>
<div class="card">
    <h3 style="margin-bottom:20px;">📋 Laporan Terbaru</h3>
    <?php if(mysqli_num_rows($laporan)>0): ?>
    <table>
        <tr><th>Tanggal</th><th>Jam</th><th>Kegiatan</th><th>Status</th></tr>
        <?php while($row=mysqli_fetch_assoc($laporan)): ?>
        <tr>
            <td><?php echo $row['tanggal']; ?></td>
            <td><?php echo $row['jam_masuk'].'-'.$row['jam_pulang']; ?></td>
            <td><?php echo substr($row['kegiatan'],0,50).'...'; ?></td>
            <td><span class="status <?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: echo "<p class='empty-state'>Belum ada laporan.</p>"; endif; ?>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>