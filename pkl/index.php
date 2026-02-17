<?php session_start(); if(isset($_SESSION['user_id'])) header("Location: dashboard.php"); ?>
<!DOCTYPE html>
<html>
<head><title>Login</title><style>body{background:#0b1120;display:flex;justify-content:center;align-items:center;height:100vh;font-family:'Segoe UI';}.card{background:#1a2234;padding:40px;border-radius:30px;width:350px;border:1px solid #2d3748;}.card h2{color:white;text-align:center;margin-bottom:30px;}.input-group{margin-bottom:20px;}input{width:100%;padding:14px;background:#0f172a;border:2px solid #2d3748;border-radius:16px;color:white;}.btn{width:100%;padding:14px;background:#3b49df;border:none;border-radius:40px;color:white;font-weight:bold;cursor:pointer;}.error{background:#7f1d1d;color:#fecaca;padding:10px;border-radius:12px;margin-bottom:20px;text-align:center;}.info{text-align:center;color:#9ca3af;margin-top:20px;}</style>
</head>
<body>
<div class="card">
    <h2> Laporan PKL</h2>
    <?php if(isset($_GET['error'])) echo '<div class="error">Username/password salah</div>'; ?>
    <form method="POST" action="proses_login.php">
        <div class="input-group"><input type="text" name="username" placeholder="Username" required></div>
        <div class="input-group"><input type="password" name="password" placeholder="Password" required></div>
        <button class="btn" type="submit">Masuk</button>
    </form>
</div>
</body>
</html>