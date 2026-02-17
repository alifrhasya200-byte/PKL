<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
require 'koneksi.php';

$action = $_POST['action'];
$nama = mysqli_real_escape_string($conn, $_POST['nama']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
$kota = mysqli_real_escape_string($conn, $_POST['kota']);
$telepon = mysqli_real_escape_string($conn, $_POST['telepon']);

if($action == 'tambah'){
    mysqli_query($conn, "INSERT INTO perusahaan (nama_perusahaan, alamat, kota, telepon) VALUES ('$nama', '$alamat', '$kota', '$telepon')");
} elseif($action == 'edit'){
    $id = $_POST['id'];
    mysqli_query($conn, "UPDATE perusahaan SET nama_perusahaan='$nama', alamat='$alamat', kota='$kota', telepon='$telepon' WHERE id='$id'");
}
header("Location: perusahaan.php");
?>