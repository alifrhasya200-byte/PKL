<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require 'koneksi.php';
$user_id = $_SESSION['user_id'];

// Ambil ID laporan dari URL
$id = $_GET['id'] ?? 0;
$id = mysqli_real_escape_string($conn, $id);

// Cek apakah laporan milik user yang login
$result = mysqli_query($conn, "SELECT * FROM laporan WHERE id = '$id' AND user_id = '$user_id'");
if (mysqli_num_rows($result) == 0) {
    header("Location: laporan_saya.php");
    exit();
}
$laporan = mysqli_fetch_assoc($result);

$active_menu = 'laporan';
$title = 'Edit Laporan';
ob_start();
?>

<div class="top-bar">
    <div class="page-title">
        <h2>Edit Laporan</h2>
        <p>Ubah data laporan PKL</p>
    </div>
</div>

<div class="card">
    <form action="update_laporan.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $laporan['id']; ?>">
        
        <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:15px;">
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="<?php echo $laporan['tanggal']; ?>" required>
            </div>
            <div class="form-group">
                <label>Jam Masuk</label>
                <input type="time" name="jam_masuk" class="form-control" value="<?php echo $laporan['jam_masuk']; ?>" required>
            </div>
            <div class="form-group">
                <label>Jam Pulang</label>
                <input type="time" name="jam_pulang" class="form-control" value="<?php echo $laporan['jam_pulang']; ?>" required>
            </div>
        </div>

        <div class="form-group">
            <label>Kegiatan</label>
            <textarea name="kegiatan" class="form-control" rows="4" required><?php echo htmlspecialchars($laporan['kegiatan']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Kendala (opsional)</label>
            <textarea name="kendala" class="form-control" rows="3"><?php echo htmlspecialchars($laporan['kendala']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Solusi (opsional)</label>
            <textarea name="solusi" class="form-control" rows="3"><?php echo htmlspecialchars($laporan['solusi']); ?></textarea>
        </div>

        <button type="submit" class="btn-primary">Update Laporan</button>
        <a href="laporan_saya.php" class="btn-primary" style="background:#4b5565; margin-left:10px;">Batal</a>
    </form>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>