<?php
include "../config/koneksi.php";
$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM master_produk WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

if(isset($_POST['update'])){
    $nama = $_POST['nama_produk'];
    $kat  = $_POST['kategori'];

    mysqli_query($conn, "UPDATE master_produk SET nama_produk='$nama', kategori='$kat' WHERE id='$id'");
    echo "<script>alert('Update berhasil');window.location='index.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Produk</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="container">
  <div class="card">
    <h2>Edit Produk</h2>

    <form method="POST">
      <div class="form-group">
        <label>Nama Produk</label>
        <input type="text" name="nama_produk" value="<?= $row['nama_produk'] ?>" required>
      </div>

      <div class="form-group">
        <label>Kategori</label>
        <input type="text" name="kategori" value="<?= $row['kategori'] ?>" required>
      </div>
      <br>
      <button class="btn btn-primary" name="update">Update</button>
      <a class="btn btn-outline" href="index.php">Kembali</a>
    </form>
  </div>
</div>

</body>
</html>