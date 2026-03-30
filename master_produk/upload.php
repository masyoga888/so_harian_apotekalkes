<?php
include "../config/koneksi.php";

if(isset($_POST['import'])){

    $file = $_FILES['file']['tmp_name'];

    if(($handle = fopen($file, "r")) !== FALSE){

        $row = 0;
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){

            // kalau delimiter ternyata titik koma
            if($row == 0 && count($data) < 2){
                rewind($handle);
                $row = 0;
                while(($data = fgetcsv($handle, 1000, ";")) !== FALSE){

                    if($row == 0){
                        $row++;
                        continue;
                    }

                    if(count($data) < 2){
                        continue;
                    }

                    $nama_produk = mysqli_real_escape_string($conn, trim($data[0]));
                    $kategori    = mysqli_real_escape_string($conn, trim($data[1]));

                    if($nama_produk == "" || $kategori == ""){
                        continue;
                    }

                    mysqli_query($conn, "INSERT INTO master_produk(nama_produk,kategori) 
                                         VALUES('$nama_produk','$kategori')");
                }

                fclose($handle);
                echo "<script>alert('Import berhasil!');window.location='index.php';</script>";
                exit;
            }

            // normal delimiter koma
            if($row == 0){
                $row++;
                continue;
            }

            if(count($data) < 2){
                continue;
            }

            $nama_produk = mysqli_real_escape_string($conn, trim($data[0]));
            $kategori    = mysqli_real_escape_string($conn, trim($data[1]));

            if($nama_produk == "" || $kategori == ""){
                continue;
            }

            mysqli_query($conn, "INSERT INTO master_produk(nama_produk,kategori) 
                                 VALUES('$nama_produk','$kategori')");
        }

        fclose($handle);

        echo "<script>alert('Import berhasil!');window.location='index.php';</script>";
    } else {
        echo "<script>alert('Import gagal!');window.location='import.php';</script>";
    }
}
?>