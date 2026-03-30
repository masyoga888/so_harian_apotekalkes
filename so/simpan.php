<?php
include "../config/koneksi.php";

$user_id    = $_POST['user_id'];
$sheet_hari = $_POST['sheet_hari'];
$produk_id  = $_POST['produk_id'];
$qty_odoo   = $_POST['qty_odoo'];
$qty_fisik  = $_POST['qty_fisik'];
$ket        = $_POST['keterangan'];

if($produk_id == ""){
    echo "<script>alert('Produk wajib dipilih dari search!');history.back();</script>";
    exit;
}

mysqli_query($conn, "INSERT INTO so_harian(user_id,sheet_hari,produk_id,qty_odoo,qty_fisik,keterangan)
                     VALUES('$user_id','$sheet_hari','$produk_id','$qty_odoo','$qty_fisik','$ket')");

echo "<script>alert('Data SO berhasil disimpan');window.location='sheet.php?user_id=$user_id&hari=$sheet_hari';</script>";
?>