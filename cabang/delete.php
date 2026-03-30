<?php
include "../config/koneksi.php";
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM cabang WHERE id='$id'");
echo "<script>alert('Cabang dihapus');window.location='index.php';</script>";
?>