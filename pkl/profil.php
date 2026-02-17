<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
require 'koneksi.php';
$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'"));
$active_menu = 'profil';
$title = 'Profil Saya';
ob_start();
?>
<div class="top-bar">
    <div class="page-title"><h2>Profil Saya</h2><p>Kelola foto dan data diri</p></div>
</div>
<div class="card">
    <?php if(isset($_GET['success'])): ?><div class="alert success">Profil diperbarui!</div><?php endif; ?>
    <form action="proses_profil.php" method="POST" enctype="multipart/form-data">
        <div style="display:flex; gap:40px; align-items:center; flex-wrap:wrap;">
            <div style="text-align:center;">
                <div class="avatar" style="width:120px;height:120px; margin:0 auto 15px;">
                    <?php if($user['foto_profil'] && file_exists("uploads/".$user['foto_profil'])): ?>
                        <img src="uploads/<?php echo $user['foto_profil']; ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <span style="font-size:48px;"><?php echo strtoupper(substr($user['nama_lengkap'],0,1)); ?></span>
                    <?php endif; ?>
                </div>
                <label for="foto" style="background:#2d3748;padding:8px 20px;border-radius:30px;cursor:pointer;">Ganti Foto</label>
                <input type="file" name="foto" id="foto" accept="image/*" style="display:none;">
            </div>
            <div style="flex:1;">
                <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" class="form-control" value="<?php echo $user['nama_lengkap']; ?>" required></div>
                <div class="form-group"><label>Username</label><input type="text" class="form-control" value="<?php echo $user['username']; ?>" disabled></div>
                <div class="form-group"><label>Role</label><input type="text" class="form-control" value="<?php echo $user['role']; ?>" disabled></div>
            </div>
        </div>
        <button type="submit" class="btn-primary">Simpan Perubahan</button>
    </form>
</div>
<?php
$content = ob_get_clean();
include 'layout.php';
?>