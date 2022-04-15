<?php

include "koneksi.php";

$nisn = $_POST['nisn'];
// var_dump($nisn);


$siswa =  mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM siswa WHERE nisn = $nisn "));

$id_siswa = $siswa['id_siswa'];
mysqli_query($koneksi, "DELETE FROM pembayaran WHERE id_siswa = $id_siswa ");
mysqli_query($koneksi, "DELETE FROM siswa WHERE nisn = '$nisn'");

if (mysqli_affected_rows($koneksi) > 0) {
    echo 1;
} else {
    echo 4;
}
