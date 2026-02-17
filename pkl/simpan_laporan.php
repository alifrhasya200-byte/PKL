<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
require 'koneksi.php';
$user_id = $_SESSION['user_id'];
$tanggal = $_POST['tanggal'];
$jam_masuk = $_POST['jam_masuk'];
$jam_pulang = $_POST['jam_pulang'];
$kegiatan = mysqli_real_escape_string($conn, $_POST['kegiatan']);
$kendala = mysqli_real_escape_string($conn, $_POST['kendala']);
$solusi = mysqli_real_escape_string($conn, $_POST['solusi']);
mysqli_query($conn, "INSERT INTO laporan (user_id,tanggal,jam_masuk,jam_pulang,kegiatan,kendala,solusi) VALUES ('$user_id','$tanggal','$jam_masuk','$jam_pulang','$kegiatan','$kendala','$solusi')");
header("Location: dashboard.php");
?>