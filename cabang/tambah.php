<?php
include "../config/koneksi.php";

$nama = $_POST['nama_cabang'];
mysqli_query($conn, "INSERT INTO cabang(nama_cabang) VALUES('$nama')");

echo "<script>alert('Cabang berhasil ditambah');window.location='index.php';</script>";
?>