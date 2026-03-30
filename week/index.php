<?php
include "../config/koneksi.php";

$cabang = mysqli_query($conn, "SELECT * FROM cabang ORDER BY nama_cabang ASC");
$weeks = mysqli_query($conn, "SELECT week_so.*, cabang.nama_cabang 
                              FROM week_so 
                              JOIN cabang ON week_so.cabang_id=cabang.id
                              ORDER BY week_so.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Week</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <div class="container nav-wrap">
    <div class="logo">Create<span>Week</span></div>
    <div class="nav-links">
      <a href="../index.php">Dashboard</a>
    </div>
  </div>
</div>

<div class="container">

  <div class="card">
    <h2>Tambah Week</h2>

    <form action="tambah.php" method="POST">
      <div class="form-group">
        <label>Pilih Cabang</label>
        <select name="cabang_id" required>
          <option value="">-- Pilih Cabang --</option>
          <?php while($c=mysqli_fetch_assoc($cabang)){ ?>
            <option value="<?= $c['id'] ?>"><?= $c['nama_cabang'] ?></option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <label>Nama Week</label>
        <input type="text" name="nama_week" placeholder="WEEK 1" required>
      </div>

      <div class="form-group">
        <label>Tahun</label>
        <input type="number" name="tahun" placeholder="2026" required>
      </div>

      <br>
      <button class="btn btn-primary">Tambah Week</button>
    </form>
  </div>

  <div class="card">
    <h2>List Week</h2>

    <div class="table-wrap">
      <table>
        <tr>
          <th>No</th>
          <th>Cabang</th>
          <th>Week</th>
          <th>Tahun</th>
          <th>Aksi</th>
        </tr>
        <?php $no=1; while($w=mysqli_fetch_assoc($weeks)){ ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $w['nama_cabang'] ?></td>
          <td><?= $w['nama_week'] ?></td>
          <td><?= $w['tahun'] ?></td>
          <td>
            <a class="btn btn-primary" href="delete.php?id=<?= $w['id'] ?>" onclick="return confirm('Hapus week?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

  </div>

</div>

</body>
</html>