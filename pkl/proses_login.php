<?php
session_start();
require 'koneksi.php';
$username = $_POST['username'];
$password = $_POST['password'];
$result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
if(mysqli_num_rows($result)==1){
    $user = mysqli_fetch_assoc($result);
    if($password == $user['password']){
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama_lengkap'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['foto'] = $user['foto_profil'];
        header("Location: dashboard.php");
        exit();
    }
}
header("Location: index.php?error=1");
?>