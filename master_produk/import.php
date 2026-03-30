<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Import Produk</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<div class="navbar">
  <div class="container nav-wrap">
    <div class="logo">Import<span>Produk</span></div>
    <div class="nav-links">
      <a href="../index.php">Dashboard</a>
      <a href="index.php">Master Produk</a>
    </div>
  </div>
</div>

<div class="container">
  <div class="card">
    <h2>Import CSV Master Produk</h2>
    <p>Format CSV: nama_produk,kategori</p>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label>Pilih File CSV</label>
        <input type="file" name="file" required>
      </div>
      <br>
      <button class="btn btn-primary" type="submit" name="import">Import</button>
    </form>
  </div>
</div>

</body>
</html>