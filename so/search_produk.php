<?php
include "../config/koneksi.php";
header('Content-Type: application/json; charset=utf-8');

$q = isset($_GET['q']) ? $_GET['q'] : '';
$q = trim($q);

if($q == ""){
    echo json_encode([]);
    exit;
}

$q_safe = mysqli_real_escape_string($conn, $q);

// biar cari fleksibel (abaikan tanda - dan spasi)
$q_clean = str_replace(["-", " "], "", strtolower($q_safe));

$sql = "SELECT id, nama_produk, kategori
        FROM master_produk
        WHERE REPLACE(REPLACE(LOWER(nama_produk), '-', ''), ' ', '') LIKE '%$q_clean%'
        ORDER BY nama_produk ASC
        LIMIT 20";

$result = mysqli_query($conn, $sql);

$data = [];
while($row = mysqli_fetch_assoc($result)){
    $data[] = $row;
}

echo json_encode($data);
?>