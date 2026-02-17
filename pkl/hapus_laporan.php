<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require 'koneksi.php';
$user_id = $_SESSION['user_id'];

$id = $_GET['id'] ?? 0;
$id = mysqli_real_escape_string($conn, $id);

// Pastikan laporan milik user yang login
$check = mysqli_query($conn, "SELECT id FROM laporan WHERE id='$id' AND user_id='$user_id'");
if (mysqli_num_rows($check) == 0) {
    header("Location: laporan_saya.php");
    exit();
}

mysqli_query($conn, "DELETE FROM laporan WHERE id='$id'");
header("Location: laporan_saya.php?deleted=1");
?>