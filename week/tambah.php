<?php
include "../config/koneksi.php";

$cabang_id = $_POST['cabang_id'];
$nama_week = strtoupper($_POST['nama_week']);
$tahun     = $_POST['tahun'];

mysqli_query($conn, "INSERT INTO week_so(cabang_id,nama_week,tahun) VALUES('$cabang_id','$nama_week','$tahun')");

echo "<script>alert('Week berhasil dibuat');window.location='index.php';</script>";
?>