<?php

include "koneksi.php";

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM siswa Where id_siswa = $id");
if (mysqli_affected_rows($koneksi)) {
    header("location: dataSiswa.php");
    echo "berhasil Menghapus Data";
}
