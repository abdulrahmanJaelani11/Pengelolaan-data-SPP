<?php

include "../koneksi.php";

$kelas = htmlspecialchars($_POST['kelas']);
$NoKelas = htmlspecialchars($_POST['NoKelas']);

$QUERY = mysqli_query($koneksi, "SELECT * FROM kelas WHERE NoKelas = '$NoKelas'");

if (mysqli_num_rows($QUERY) > 0) {
    echo "kelasSudahAda";
} else {
    mysqli_query($koneksi, "INSERT INTO kelas VALUES ('', '$kelas', '$NoKelas')");
    if (mysqli_affected_rows($koneksi) > 0) {
        echo "sukses";
    } else {
        echo "gagal";
    }
}
