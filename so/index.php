<?php
include "../config/koneksi.php";

$cabang = mysqli_query($conn, "SELECT * FROM cabang ORDER BY nama_cabang ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SO Harian</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <div class="container nav-wrap">
    <div class="logo">SO<span>Harian</span></div>
    <div class="nav-links">
      <a href="../index.php">Dashboard</a>
    </div>
  </div>
</div>

<div class="container">

  <div class="card">
    <h2>Pilih Cabang - Week - User</h2>

    <form action="sheet.php" method="GET">
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
        <label>Pilih Week</label>
        <select name="week_id" required>
          <option value="">-- Pilih Week (buat di menu Week) --</option>
          <?php
          $weeks = mysqli_query($conn, "SELECT week_so.*, cabang.nama_cabang
                                        FROM week_so
                                        JOIN cabang ON week_so.cabang_id=cabang.id
                                        ORDER BY week_so.id DESC");
          while($w=mysqli_fetch_assoc($weeks)){
          ?>
            <option value="<?= $w['id'] ?>">
              <?= $w['nama_cabang']." - ".$w['nama_week']." ".$w['tahun'] ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <div class="form-group">
        <label>Pilih User</label>
        <select name="user_id" required>
          <option value="">-- Pilih User (buat di menu User) --</option>
          <?php
          $users = mysqli_query($conn, "SELECT user_so.*, week_so.nama_week, week_so.tahun
                                        FROM user_so
                                        JOIN week_so ON user_so.week_id=week_so.id
                                        ORDER BY user_so.id DESC");
          while($u=mysqli_fetch_assoc($users)){
          ?>
            <option value="<?= $u['id'] ?>">
              <?= $u['nama_user']." (".$u['nama_week']." ".$u['tahun'].")" ?>
            </option>
          <?php } ?>
        </select>
      </div>

      <br>
      <button class="btn btn-primary">Masuk Sheet</button>
    </form>

  </div>

</div>

</body>
</html>