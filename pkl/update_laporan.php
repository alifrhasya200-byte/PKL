<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require 'koneksi.php';
$user_id = $_SESSION['user_id'];

$id = $_POST['id'];
$tanggal = $_POST['tanggal'];
$jam_masuk = $_POST['jam_masuk'];
$jam_pulang = $_POST['jam_pulang'];
$kegiatan = mysqli_real_escape_string($conn, $_POST['kegiatan']);
$kendala = mysqli_real_escape_string($conn, $_POST['kendala']);
$solusi = mysqli_real_escape_string($conn, $_POST['solusi']);

// Pastikan laporan milik user yang login
$check = mysqli_query($conn, "SELECT id FROM laporan WHERE id='$id' AND user_id='$user_id'");
if (mysqli_num_rows($check) == 0) {
    header("Location: laporan_saya.php");
    exit();
}

mysqli_query($conn, "UPDATE laporan SET 
    tanggal='$tanggal',
    jam_masuk='$jam_masuk',
    jam_pulang='$jam_pulang',
    kegiatan='$kegiatan',
    kendala='$kendala',
    solusi='$solusi'
    WHERE id='$id'");

header("Location: laporan_saya.php?updated=1");
?>