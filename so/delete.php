<?php
include "../config/koneksi.php";

$id = $_GET['id'];
$user_id = $_GET['user_id'];
$hari = $_GET['hari'];

mysqli_query($conn, "DELETE FROM so_harian WHERE id='$id'");

echo "<script>alert('Data berhasil dihapus');window.location='sheet.php?user_id=$user_id&hari=$hari';</script>";
?>