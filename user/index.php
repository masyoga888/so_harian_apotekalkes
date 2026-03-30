<?php
include "../config/koneksi.php";

$weeks = mysqli_query($conn, "SELECT week_so.*, cabang.nama_cabang 
                              FROM week_so 
                              JOIN cabang ON week_so.cabang_id=cabang.id
                              ORDER BY week_so.id DESC");

$users = mysqli_query($conn, "SELECT user_so.*, week_so.nama_week, week_so.tahun, cabang.nama_cabang
                              FROM user_so
                              JOIN week_so ON user_so.week_id=week_so.id
                              JOIN cabang ON week_so.cabang_id=cabang.id
                              ORDER BY user_so.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User SO</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <div class="container nav-wrap">
    <div class="logo">Data<span>User</span></div>
    <div class="nav-links">
      <a href="../index.php">Dashboard</a>
    </div>
  </div>
</div>

<div class="container">

  <div class="card">
    <h2>Tambah User</h2>

    <form action="tambah.php" method="POST">
      <div class="form-group">
        <label>Pilih Week</label>
        <select name="week_id" required>
          <option value="">-- Pilih Week --</option>
          <?php while($w=mysqli_fetch_assoc($weeks)){ ?>
            <option value="<?= $w['id'] ?>">
              <?= $w['nama_cabang']." - ".$w['nama_week']." ".$w['tahun'] ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <label>Nama User</label>
        <input type="text" name="nama_user" placeholder="Yoga Anggoro" required>
      </div>

      <br>
      <button class="btn btn-primary">Tambah User</button>
    </form>
  </div>

  <div class="card">
    <h2>List User</h2>

    <div class="table-wrap">
      <table>
        <tr>
          <th>No</th>
          <th>Cabang</th>
          <th>Week</th>
          <th>User</th>
          <th>Aksi</th>
        </tr>
        <?php $no=1; while($u=mysqli_fetch_assoc($users)){ ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $u['nama_cabang'] ?></td>
          <td><?= $u['nama_week']." ".$u['tahun'] ?></td>
          <td><?= $u['nama_user'] ?></td>
          <td>
            <a class="btn btn-primary" href="delete.php?id=<?= $u['id'] ?>" onclick="return confirm('Hapus user?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>

  </div>

</div>

</body>
</html>