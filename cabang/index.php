<?php
include "../config/koneksi.php";
$data = mysqli_query($conn, "SELECT * FROM cabang ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cabang</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <div class="container nav-wrap">
    <div class="logo">Data<span>Cabang</span></div>
    <div class="nav-links">
      <a href="../index.php">Dashboard</a>
    </div>
  </div>
</div>

<div class="container">
  <div class="card">
    <h2>Tambah Cabang</h2>

    <form action="tambah.php" method="POST">
      <div class="form-group">
        <label>Nama Cabang</label>
        <input type="text" name="nama_cabang" required>
      </div>
      <br>
      <button class="btn btn-primary" type="submit">Tambah</button>
    </form>
  </div>

  <div class="card">
    <h2>List Cabang</h2>
    <div class="table-wrap">
      <table>
        <tr>
          <th>No</th>
          <th>Nama Cabang</th>
          <th>Aksi</th>
        </tr>
        <?php $no=1; while($row=mysqli_fetch_assoc($data)){ ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['nama_cabang'] ?></td>
          <td>
            <a class="btn btn-primary" href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Hapus cabang?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>

</body>
</html>