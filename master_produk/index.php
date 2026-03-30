<?php
include "../config/koneksi.php";
$data = mysqli_query($conn, "SELECT * FROM master_produk ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Master Produk</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <div class="container nav-wrap">
    <div class="logo">Master<span>Produk</span></div>
    <div class="nav-links">
      <a href="../index.php">Dashboard</a>
      <a href="import.php">Import</a>
    </div>
  </div>
</div>

<div class="container">
  <div class="card">
    <h2>Data Master Produk</h2>

    <div class="table-wrap">
      <table>
        <tr>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Aksi</th>
        </tr>
        <?php $no=1; while($row=mysqli_fetch_assoc($data)){ ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['nama_produk'] ?></td>
          <td><?= $row['kategori'] ?></td>
          <td>
            <a class="btn btn-outline" href="edit.php?id=<?= $row['id'] ?>">Edit</a>
            <a class="btn btn-primary" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus produk?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

  </div>
</div>

</body>
</html>