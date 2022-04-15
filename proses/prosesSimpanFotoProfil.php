<?php
session_start();
include "../koneksi.php";

$img = $_FILES['img'];
$imgName = $img['name'];
$tmp_name = $img['tmp_name'];
$nisn = $_SESSION['nisn'];

// var_dump($img);
if ($img['error'] == 4) {
    $error = "Form tidak boleh kosong";
} else {
    // var_dump($tmp_name);
    // die;
    mysqli_query($koneksi, "UPDATE akunsiswa SET img = '$imgName' WHERE nisn = $nisn");
    move_uploaded_file($tmp_name, "../assets/img/pp/$imgName");
    if (mysqli_affected_rows($koneksi)) {
        echo "<script>alert
        ('Berhasil mengupload')
        document.location='../beranda_siswa.php'
        </script>";
    } else {
        echo "<script>alert('Gagal mengupload')</script>";
    }
}
