<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
require 'koneksi.php';
$user_id = $_SESSION['user_id'];
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$foto_lama = $_SESSION['foto'];

// Upload foto baru
$foto_baru = $foto_lama;
if($_FILES['foto']['error'] == 0){
    $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $fname = "user_".$user_id."_".time().".".$ext;
    $target = "uploads/".$fname;
    if(move_uploaded_file($_FILES['foto']['tmp_name'], $target)){
        $foto_baru = $fname;
        // hapus foto lama jika ada
        if($foto_lama && file_exists("uploads/".$foto_lama)) unlink("uploads/".$foto_lama);
    }
}

mysqli_query($conn, "UPDATE users SET nama_lengkap='$nama', foto_profil='$foto_baru' WHERE id='$user_id'");
$_SESSION['nama'] = $nama;
$_SESSION['foto'] = $foto_baru;
header("Location: profil.php?success=1");
?>