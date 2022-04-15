<?php
session_start();
include "koneksi.php";

$id = $_GET['id'];
$img = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT img FROM akunsiswa WHERE id = $id"));
// var_dump($img);
// die;

mysqli_query($koneksi, "UPDATE akunsiswa SET img = 'default.png' WHERE id = $id");
if (mysqli_affected_rows($koneksi) > 0) {
    unlink("assets/img/pp/" . $img['img']);
    echo "<script>alert('Berhasil menghapus Foto'); document.location='beranda_siswa.php'</script>";
} else {
    echo "<script>alert('Gagal menghapus Foto'); document.location='beranda_siswa.php'</script>";
}
