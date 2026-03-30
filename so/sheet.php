<?php
include "../config/koneksi.php";

$user_id = $_GET['user_id'];
$hari = isset($_GET['hari']) ? $_GET['hari'] : 1;

$user = mysqli_query($conn, "SELECT * FROM user_so WHERE id='$user_id'");
$userRow = mysqli_fetch_assoc($user);

$data = mysqli_query($conn, "SELECT so_harian.*, master_produk.nama_produk, master_produk.kategori
                             FROM so_harian
                             JOIN master_produk ON so_harian.produk_id=master_produk.id
                             WHERE so_harian.user_id='$user_id' AND so_harian.sheet_hari='$hari'
                             ORDER BY so_harian.id DESC");
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sheet <?= $hari ?></title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <div class="container nav-wrap">
    <div class="logo">Sheet<span><?= $hari ?></span></div>
    <div class="nav-links">
      <a href="../index.php">Dashboard</a>
      <a href="index.php">SO Menu</a>
    </div>
  </div>
</div>

<div class="container">

  <div class="card">
    <h2>User: <?= $userRow['nama_user'] ?></h2>

    <div class="tabs">
      <?php for($i=1; $i<=7; $i++){ ?>
        <a class="tab <?= ($i==$hari) ? "active" : "" ?>" href="sheet.php?user_id=<?= $user_id ?>&hari=<?= $i ?>">
          Sheet <?= $i ?>
        </a>
      <?php } ?>
    </div>
  </div>

  <div class="card">
    <h2>Input SO Harian (Sheet <?= $hari ?>)</h2>

    <form action="simpan.php" method="POST">
      <input type="hidden" name="user_id" value="<?= $user_id ?>">
      <input type="hidden" name="sheet_hari" value="<?= $hari ?>">

      <div class="form-group">
        <div class="form-group">
  <label>Nama Produk</label>

  <div style="position:relative;">
    <input type="text" id="produk_search" placeholder="Cari produk..." autocomplete="off" required>

    <div id="hasil_search" style="
      display:none;
      position:absolute;
      top:105%;
      left:0;
      width:100%;
      background:white;
      border:1px solid rgba(0,0,0,0.15);
      border-radius:12px;
      overflow:hidden;
      z-index:9999;
      max-height:250px;
      overflow-y:auto;
      box-shadow:0 10px 25px rgba(0,0,0,0.15);
    "></div>
  </div>

  <input type="hidden" name="produk_id" id="produk_id">
</div>

      <div class="form-group">
        <label>Kategori</label>
        <input type="text" id="kategori" readonly>
      </div>

      <div class="form-group">
        <label>Qty Odoo</label>
        <input type="number" name="qty_odoo" required>
      </div>

      <div class="form-group">
        <label>Qty Fisik</label>
        <input type="number" name="qty_fisik" required>
      </div>

      <div class="form-group">
        <label>Keterangan</label>
        <textarea name="keterangan"></textarea>
      </div>

      <br>
      <button class="btn btn-primary">Simpan</button>
    </form>

    <br>
    <div id="hasil_search" class="card" style="display:none;"></div>

  </div>

  <div class="card">
    
  <h2>Data SO Sheet <?= $hari ?></h2>

  <a class="btn btn-primary" href="export_excel.php?user_id=<?= $user_id ?>&hari=<?= $hari ?>">
    Export Sheet <?= $hari ?> (Excel)
  </a>

  <a class="btn btn-outline" href="export_excel.php?user_id=<?= $user_id ?>&hari=all">
    Export Semua Sheet (Excel)
  </a>

    <div class="table-wrap">
      <table>
        <tr>
          <th>No</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Qty Odoo</th>
          <th>Qty Fisik</th>
          <th>Selisih</th>
          <th>Keterangan</th>
          <th>Aksi</th>
        </tr>

        <?php $no=1; while($row=mysqli_fetch_assoc($data)){ 
          $selisih = $row['qty_odoo'] - $row['qty_fisik'];
          $class = ($selisih >= 0) ? "plus" : "minus";
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= $row['nama_produk'] ?></td>
          <td><?= $row['kategori'] ?></td>
          <td><?= $row['qty_odoo'] ?></td>
          <td><?= $row['qty_fisik'] ?></td>
          <td class="<?= $class ?>"><?= $selisih ?></td>
          <td><?= $row['keterangan'] ?></td>
          <td>
            <a class="btn btn-primary" href="delete.php?id=<?= $row['id'] ?>&user_id=<?= $user_id ?>&hari=<?= $hari ?>" onclick="return confirm('Hapus data?')">Hapus</a>
          </td>
        </tr>
        <?php } ?>

      </table>
    </div>

  </div>

</div>

<script>
const produkSearch = document.getElementById("produk_search");
const hasilSearch = document.getElementById("hasil_search");
const kategori = document.getElementById("kategori");
const produkId = document.getElementById("produk_id");

produkSearch.addEventListener("keyup", function(){
    let q = produkSearch.value.trim();

    if(q.length < 2){
        hasilSearch.style.display = "none";
        hasilSearch.innerHTML = "";
        return;
    }

    fetch("search_produk.php?q=" + encodeURIComponent(q))
      .then(res => res.json())
      .then(data => {

        hasilSearch.innerHTML = "";

        if(data.length > 0){
            hasilSearch.style.display = "block";

            data.forEach(item => {

                let div = document.createElement("div");
                div.style.padding = "10px 12px";
                div.style.cursor = "pointer";
                div.style.borderBottom = "1px solid rgba(0,0,0,0.08)";
                div.style.fontSize = "14px";

                div.innerHTML = `
                  <b style="color:#d60000;">${item.nama_produk}</b>
                  <br>
                  <small style="color:#666;">${item.kategori}</small>
                `;

                div.onmouseover = function(){
                    div.style.background = "rgba(214,0,0,0.08)";
                };
                div.onmouseout = function(){
                    div.style.background = "white";
                };

                div.onclick = function(){
                    produkSearch.value = item.nama_produk;
                    kategori.value = item.kategori;
                    produkId.value = item.id;

                    hasilSearch.style.display = "none";
                    hasilSearch.innerHTML = "";
                };

                hasilSearch.appendChild(div);
            });

        } else {
            hasilSearch.style.display = "block";
            hasilSearch.innerHTML = `<div style="padding:10px;color:#777;">Produk tidak ditemukan</div>`;
        }

      })
      .catch(err => {
        console.log(err);
        hasilSearch.style.display = "block";
        hasilSearch.innerHTML = `<div style="padding:10px;color:red;">Error ambil data</div>`;
      });
});

// klik luar dropdown → hilang
document.addEventListener("click", function(e){
    if(!hasilSearch.contains(e.target) && e.target !== produkSearch){
        hasilSearch.style.display = "none";
    }
});
</script>

</body>
</html>