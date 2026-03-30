<?php
include "../config/koneksi.php";
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM master_produk WHERE id='$id'");
echo "<script>alert('Produk berhasil dihapus');window.location='index.php';</script>";
?>