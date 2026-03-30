<?php
include "../config/koneksi.php";

$cabang = mysqli_query($conn, "SELECT * FROM cabang ORDER BY nama_cabang ASC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Audit</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <div class="container nav-wrap">
    <div class="logo">Audit<span>SO</span></div>
    <div class="nav-links">
      <a href="../index.php">Dashboard</a>
    </div>
  </div>
</div>

<div class="container">

  <div class="card">
    <h2>Pilih Cabang</h2>

    <form method="GET">
      <div class="form-group">
        <label>Cabang</label>
        <select name="cabang_id" onchange="this.form.submit()" required>
          <option value="">-- Pilih Cabang --</option>
          <?php while($c=mysqli_fetch_assoc($cabang)){ ?>
            <option value="<?= $c['id'] ?>" <?= (isset($_GET['cabang_id']) && $_GET['cabang_id']==$c['id']) ? "selected" : "" ?>>
              <?= $c['nama_cabang'] ?>
            </option>
          <?php } ?>
        </select>
      </div>
    </form>
  </div>

<?php
if(isset($_GET['cabang_id'])){

  $cabang_id = $_GET['cabang_id'];

  // ambil semua user yang ada di cabang tersebut (dari semua week)
  $users = mysqli_query($conn, "
    SELECT DISTINCT user_so.nama_user
    FROM user_so
    JOIN week_so ON user_so.week_id = week_so.id
    WHERE week_so.cabang_id = '$cabang_id'
    ORDER BY user_so.nama_user ASC
  ");
?>

  <div class="card">
    <h2>Progress Bulanan (28 Sheet)</h2>

    <div class="table-wrap">
      <table>
        <tr>
          <th>No</th>
          <th>Nama User</th>
          <th>Total Selesai</th>
          <th>Persentase</th>
          <th>Detail</th>
        </tr>

        <?php
        $no=1;
        while($u=mysqli_fetch_assoc($users)){

          $nama_user = $u['nama_user'];

          // total sheet selesai per bulan
          $total_selesai = 0;

          // ambil semua week user tersebut pada cabang itu
          $weekUser = mysqli_query($conn, "
            SELECT user_so.id as user_id, week_so.id as week_id, week_so.nama_week, week_so.tahun
            FROM user_so
            JOIN week_so ON user_so.week_id = week_so.id
            WHERE week_so.cabang_id='$cabang_id'
            AND user_so.nama_user='$nama_user'
            ORDER BY week_so.id ASC
          ");

          while($wu=mysqli_fetch_assoc($weekUser)){
            $user_id = $wu['user_id'];
            $week_id = $wu['week_id'];

            // hitung sheet 1-7, selesai jika >=20 baris
            for($hari=1; $hari<=7; $hari++){
              $cek = mysqli_query($conn, "
                SELECT COUNT(*) as total
                FROM so_harian
                WHERE user_id='$user_id'
                AND week_id='$week_id'
                AND sheet_hari='$hari'
              ");
              $rowCount = mysqli_fetch_assoc($cek);

              if($rowCount['total'] >= 20){
                $total_selesai++;
              }
            }
          }

          $persen = round(($total_selesai/28)*100);
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $nama_user ?></td>
          <td><b><?= $total_selesai ?> / 28</b></td>
          <td><?= $persen ?>%</td>
          <td>
            <a class="btn btn-outline" href="detail.php?cabang_id=<?= $cabang_id ?>&nama_user=<?= urlencode($nama_user) ?>">
              Detail
            </a>
          </td>
        </tr>
        <?php } ?>

      </table>
    </div>
  </div>

<?php } ?>

</div>
</body>
</html>