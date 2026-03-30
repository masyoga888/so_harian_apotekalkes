<?php
include "../config/koneksi.php";
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM week_so WHERE id='$id'");
echo "<script>alert('Week dihapus');window.location='index.php';</script>";
?>