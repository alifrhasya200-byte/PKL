<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require 'koneksi.php';
$user_id = $_SESSION['user_id'];

// Ambil semua laporan milik user
$query = "SELECT * FROM laporan WHERE user_id = '$user_id' ORDER BY tanggal DESC";
$laporan = mysqli_query($conn, $query);

$active_menu = 'laporan';
$title = 'Laporan Saya';
ob_start();

?>

<?php if (isset($_GET['updated'])): ?>
    <div style="background:#14532d; color:#86efac; padding:15px; border-radius:12px; margin-bottom:20px;">
        ✅ Laporan berhasil diperbarui.
    </div>
<?php elseif (isset($_GET['deleted'])): ?>
    <div style="background:#7f1d1d; color:#fecaca; padding:15px; border-radius:12px; margin-bottom:20px;">
        🗑️ Laporan berhasil dihapus.
    </div>
<?php endif; ?>

<div class="top-bar">
    <div class="page-title">
        <h2>Laporan Saya</h2>
        <p>Semua riwayat laporan PKL</p>
    </div>
    <div class="date-badge">
        Total: <?php echo mysqli_num_rows($laporan); ?>
    </div>
</div>

<div class="card">
    <?php if (mysqli_num_rows($laporan) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Kegiatan</th>
                    <th>Kendala</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($laporan)): ?>
                <tr>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td><?php echo $row['jam_masuk'] . ' - ' . $row['jam_pulang']; ?></td>
                    <td><?php echo nl2br(htmlspecialchars(substr($row['kegiatan'], 0, 50))); ?>...</td>
                    <td><?php echo nl2br(htmlspecialchars(substr($row['kendala'] ?? '-', 0, 30))); ?></td>
                    <td>
                        <span class="status <?php echo $row['status']; ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </td>
                    <td>
                        <a href="edit_laporan.php?id=<?php echo $row['id']; ?>" class="btn-edit" style="background:#3b49df; padding:6px 12px; border-radius:8px; color:white; text-decoration:none; margin-right:5px;">Edit</a>
                        <a href="hapus_laporan.php?id=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus laporan ini?')" style="background:#b91c1c; padding:6px 12px; border-radius:8px; color:white; text-decoration:none;">Hapus</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <p>Belum ada laporan. Silakan buat laporan baru di dashboard.</p>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include 'layout.php';
?>