<?php
include "../config/koneksi.php";

$week_id = $_POST['week_id'];
$nama    = ucwords(strtolower($_POST['nama_user']));

mysqli_query($conn, "INSERT INTO user_so(week_id,nama_user) VALUES('$week_id','$nama')");
echo "<script>alert('User berhasil ditambah');window.location='index.php';</script>";
?>