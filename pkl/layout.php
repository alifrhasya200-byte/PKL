<?php
if (!isset($active_menu)) {
    $active_menu = '';
}
function isActive($menu, $active_menu) {
    return $menu === $active_menu ? 'active' : '';
}
$foto = $_SESSION['foto'] ?? null;
$inisial = strtoupper(substr($_SESSION['nama'] ?? 'U', 0, 1));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Laporan PKL'; ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }
        body {
            background: #0b1120;
            display: flex;
            color: #e2e8f0;
        }
        /* SIDEBAR */
        .sidebar {
            width: 280px;
            height: 100vh;
            background: #1a2234;
            position: fixed;
            padding: 30px 20px;
            border-right: 1px solid #2d3748;
            box-shadow: 4px 0 20px rgba(0,0,0,0.5);
        }
        .profile {
            text-align: center;
            padding-bottom: 25px;
            border-bottom: 1px solid #2d3748;
            margin-bottom: 25px;
        }
        .avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(145deg, #3b49df, #8a4fff);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 3px solid #4b5565;
        }
        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .avatar span {
            font-size: 40px;
            font-weight: bold;
            color: white;
        }
        .profile h3 {
            font-size: 20px;
            color: white;
            margin-bottom: 5px;
        }
        .profile p {
            color: #9ca3af;
            font-size: 14px;
        }
        .badge {
            display: inline-block;
            background: #2d3748;
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 12px;
            color: #cbd5e0;
            margin-top: 8px;
        }
        .nav-menu {
            list-style: none;
        }
        .nav-item {
            margin-bottom: 8px;
        }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #b0b7c3;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.2s;
        }
        .nav-link:hover {
            background: #2d3748;
            color: white;
        }
        .nav-link.active {
            background: #3b49df;
            color: white;
            box-shadow: 0 8px 16px rgba(59,73,223,0.3);
        }
        .nav-link svg {
            width: 22px;
            height: 22px;
            fill: currentColor;
        }
        /* MAIN CONTENT */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            width: calc(100% - 280px);
        }
        .top-bar {
            background: #1a2234;
            border-radius: 20px;
            padding: 20px 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #2d3748;
        }
        .page-title h2 {
            font-size: 26px;
            color: white;
            margin-bottom: 5px;
        }
        .page-title p {
            color: #9ca3af;
            font-size: 14px;
        }
        .date-badge {
            background: #2d3748;
            padding: 8px 20px;
            border-radius: 40px;
            font-size: 14px;
            color: #e2e8f0;
        }
        .card {
            background: #1a2234;
            border-radius: 24px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #2d3748;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: #cbd5e0;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .form-control {
            width: 100%;
            padding: 14px 18px;
            background: #0f172a;
            border: 2px solid #2d3748;
            border-radius: 18px;
            color: white;
            font-size: 15px;
            transition: 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: #3b49df;
            background: #0b1120;
        }
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
        .btn-primary {
            background: linear-gradient(145deg, #3b49df, #8a4fff);
            border: none;
            padding: 14px 32px;
            border-radius: 40px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 16px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(59,73,223,0.4);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            text-align: left;
            padding: 15px 10px;
            color: #9ca3af;
            font-weight: 500;
            border-bottom: 2px solid #2d3748;
        }
        td {
            padding: 15px 10px;
            border-bottom: 1px solid #2d3748;
        }
        .status {
            padding: 4px 12px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status.pending { background: #854d0e; color: #fde047; }
        .status.disetujui { background: #14532d; color: #86efac; }
        .status.ditolak { background: #7f1d1d; color: #fecaca; }
        .empty-state {
            text-align: center;
            padding: 50px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
<div class="avatar">
    <?php if(isset($_SESSION['foto']) && file_exists("uploads/".$_SESSION['foto'])): ?>
        <img src="uploads/<?php echo $_SESSION['foto']; ?>" alt="foto">
    <?php else: ?>
        <span><?php echo strtoupper(substr($_SESSION['nama']??'U',0,1)); ?></span>
    <?php endif; ?>
</div>
            <h3><?php echo $_SESSION['nama'] ?? 'User'; ?></h3>
            <p><?php echo $_SESSION['username'] ?? ''; ?></p>
            <span class="badge"><?php echo ucfirst($_SESSION['role'] ?? 'siswa'); ?></span>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link <?php echo isActive('dashboard', $active_menu); ?>">
                    <svg viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="laporan_saya.php" class="nav-link <?php echo isActive('laporan', $active_menu); ?>">
                    <svg viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM17 7h-5v2h5V7zm0 4h-5v2h5v-2zM7 7h2v2H7V7zm0 4h2v2H7v-2z"/></svg>Laporan Saya
                </a>
            </li>
            <li class="nav-item">
                <a href="perusahaan.php" class="nav-link <?php echo isActive('perusahaan', $active_menu); ?>">
                    <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm-8 2h6v2h-6V6zm0 4h6v2h-6v-2zm-6 0h4v2H6v-2zm10 4h-4v-2h4v2zm-10 0h4v2H6v-2z"/></svg>Perusahaan
                </a>
            </li>
            <li class="nav-item">
                <a href="profil.php" class="nav-link <?php echo isActive('profil', $active_menu); ?>">
                    <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>Profil Saya
                </a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link">
                    <svg viewBox="0 0 24 24"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.59L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>Keluar
                </a>
            </li>
        </ul>
    </div>
    <div class="main-content">
        <?php echo $content ?? ''; ?>
    </div>
</body>
</html>