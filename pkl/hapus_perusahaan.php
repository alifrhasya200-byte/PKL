<?php
session_start();
if(!isset($_SESSION['user_id'])){ header("Location: index.php"); exit(); }
require 'koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM perusahaan WHERE id='$id'");
header("Location: perusahaan.php");
?>