<?php
include "../config/koneksi.php";

$user_id = $_GET['user_id'];
$hari = isset($_GET['hari']) ? $_GET['hari'] : "all";

$user = mysqli_query($conn, "SELECT * FROM user_so WHERE id='$user_id'");
$userRow = mysqli_fetch_assoc($user);

header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=SO_".$userRow['nama_user']."_sheet_".$hari.".xls");
header("Pragma: no-cache");
header("Expires: 0");

echo "<table border='1' style='border-collapse:collapse;'>";

echo "<tr>
        <th colspan='8' style='background:#d60000;color:white;font-size:16px;padding:10px;'>
          LAPORAN STOCK OPNAME HARIAN
        </th>
      </tr>";

echo "<tr>
        <td colspan='8' style='padding:8px; font-weight:bold;'>
          Nama User: ".$userRow['nama_user']." | Sheet: ".$hari."
        </td>
      </tr>";

echo "<tr style='background:#ffcccc; font-weight:bold;'>
        <th>No</th>
        <th>Sheet</th>
        <th>Nama Produk</th>
        <th>Kategori</th>
        <th>Qty Odoo</th>
        <th>Qty Fisik</th>
        <th>Selisih</th>
        <th>Keterangan</th>
      </tr>";

if($hari == "all"){
    $sql = "SELECT so_harian.*, master_produk.nama_produk, master_produk.kategori
            FROM so_harian
            JOIN master_produk ON so_harian.produk_id=master_produk.id
            WHERE so_harian.user_id='$user_id'
            ORDER BY so_harian.sheet_hari ASC, so_harian.id ASC";
} else {
    $sql = "SELECT so_harian.*, master_produk.nama_produk, master_produk.kategori
            FROM so_harian
            JOIN master_produk ON so_harian.produk_id=master_produk.id
            WHERE so_harian.user_id='$user_id' AND so_harian.sheet_hari='$hari'
            ORDER BY so_harian.id ASC";
}

$data = mysqli_query($conn, $sql);

$no = 1;
while($row = mysqli_fetch_assoc($data)){
    $selisih = $row['qty_odoo'] - $row['qty_fisik'];

    echo "<tr>
            <td>".$no++."</td>
            <td>".$row['sheet_hari']."</td>
            <td>".$row['nama_produk']."</td>
            <td>".$row['kategori']."</td>
            <td>".$row['qty_odoo']."</td>
            <td>".$row['qty_fisik']."</td>
            <td>".$selisih."</td>
            <td>".$row['keterangan']."</td>
          </tr>";
}

echo "</table>";
?>